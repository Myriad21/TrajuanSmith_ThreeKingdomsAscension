
<?php

function initializeCombat(string $enemyId): array
{
    $enemies = [
        "mana_corrupted_wolf" => [
            "id" => "mana_corrupted_wolf",
            "name" => "Mana-Corrupted Wolf",
            "level" => 1,
            "hp" => 136,
            "max_hp" => 136,
            "strength" => 6
        ]
    ];

    if (!isset($enemies[$enemyId])) {
        throw new InvalidArgumentException(
            "Unknown enemy: " . $enemyId
        );
    }

    $enemy = $enemies[$enemyId];

    return [
        "enemy" => $enemy,
        "turn" => 1,
        "status" => "active",
        "special_cooldown" => 0,
        "log" => [
            "Battle started! A " . $enemy["name"] . " blocks your path.",
            "The creature growls as unstable mana surrounds its body.",
            "Choose your first combat action."
        ]
    ];
}

function startCombat(string $enemyId): void
{
    $_SESSION["combat"] = initializeCombat($enemyId);
}


function calculateBasicDamage(
    int $strength,
    int $maxMana,
    string $faction,
    int $weaponBonus = 0
): int {
    $trainingBonuses = [
        "warrior" => 1,
        "rogue" => -1,
        "mage" => 1
    ];

    $trainingBonus = $trainingBonuses[$faction] ?? 0;

    $manaDamage = intdiv(max(0, $maxMana), 10);

    $damage = $strength
        + $manaDamage
        + $trainingBonus
        + $weaponBonus;

    return max(1, $damage);
}



function performBasicAttack(array &$combat, array $champion, int $weaponBonus = 0): void {
    // Only allow attacks while the battle is active.
    if ($combat["status"] !== "active") {
        return;
    }

    // Calculate the player's damage.
    $damage = calculateBasicDamage(
        (int) $champion["strength"],
        (int) $champion["max_mana"],
        $champion["faction"],
        $weaponBonus
    );

    // Reduce the enemy's HP without going below zero.
    $combat["enemy"]["hp"] = max(
        0,
        $combat["enemy"]["hp"] - $damage
    );

    // Record the attack in the combat log.
    $combat["log"][] =
        $champion["name"] .
        " used Basic Attack and dealt " .
        $damage .
        " damage to " .
        $combat["enemy"]["name"] .
        ".";

    // Check whether the enemy was defeated.
    if ($combat["enemy"]["hp"] <= 0) {
        $combat["status"] = "victory";

        $combat["log"][] =
            $combat["enemy"]["name"] .
            " has been defeated!";
    }
}


function performEnemyAttack(array &$combat, array &$champion): void {
    // Enemy attacks are only allowed during active combat.
    if ($combat["status"] !== "active") {
        return;
    }

    // Calculate the enemy's damage.
    $damage = max(1, (int) $combat["enemy"]["strength"]);

    // Reduce the champion's HP without going below zero.
    $champion["hp"] = max(
        0,
        (int) $champion["hp"] - $damage
    );

    // Record the enemy's attack.
    $combat["log"][] =
        $combat["enemy"]["name"] .
        " attacks " .
        $champion["name"] .
        " and deals " .
        $damage .
        " damage.";

    // Check whether the champion was defeated.
    if ($champion["hp"] <= 0) {
        $combat["status"] = "defeat";

        $combat["log"][] =
            $champion["name"] .
            " has been defeated!";
    }
}


function getSpecialAbilities(string $faction): array
{
    $abilities = [
        "warrior" => [
            "power_strike" => [
                "name" => "Power Strike",
                "description" => "A powerful physical attack.",
                "mana_cost" => 10,
                "damage_bonus" => 8,
                "required_level" => 2,
                "unlock_type" => "level"

            ]
        ],

        "mage" => [
            "arcane_burst" => [
                "name" => "Arcane Burst",
                "description" => "Unleash concentrated arcane energy.",
                "mana_cost" => 15,
                "damage_bonus" => 12,
                "required_level" => 2,
                "unlock_type" => "level"
            ]
        ],

        "rogue" => [
            "shadow_strike" => [
                "name" => "Shadow Strike",
                "description" => "Strike from the shadows with precision.",
                "mana_cost" => 12,
                "damage_bonus" => 10,
                "required_level" => 2,
                "unlock_type" => "level"
            ]
        ]
    ];

    return $abilities[strtolower($faction)] ?? [];
}


function performSpecialAttack(
    array &$combat,
    array &$champion,
    string $abilityId
): bool {

    // Special attacks can only be used during active combat.
    if ($combat["status"] !== "active") {
        return false;
    }

    // Find the selected faction's abilities.
    $abilities = getSpecialAbilities($champion["faction"]);

    // Reject abilities that do not belong to this faction.
    if (!isset($abilities[$abilityId])) {
        return false;
    }

    $ability = $abilities[$abilityId];

    // Check the required champion level.
   // if ($champion["level"] < $ability["required_level"]) {
     //   return false;
    //}

    // Check available mana.
    if ($champion["mana"] < $ability["mana_cost"]) {
        return false;
    }

    // Check the special ability cooldown.
    if ($combat["special_cooldown"] > 0) {
        return false;
    }

    // Deduct mana.
    $champion["mana"] -= $ability["mana_cost"];

    // Calculate damage using the same formula as Basic Attack.
    $damage = calculateBasicDamage(
                (int) $champion["strength"],
                (int) $champion["max_mana"],
                $champion["faction"]
            ) + (int) $ability["damage_bonus"];

    // Apply damage without allowing negative enemy HP.
    $combat["enemy"]["hp"] = max(
        0,
        $combat["enemy"]["hp"] - $damage
    );

    // Record the special attack in the combat log.
    $combat["log"][] =
        $champion["name"] .
        " used " .
        $ability["name"] .
        " and dealt " .
        $damage .
        " damage!";

    // Start the two-turn cooldown.
    $combat["special_cooldown"] = 2;

    // Check for victory.
    if ($combat["enemy"]["hp"] <= 0) {
        $combat["status"] = "victory";

        $combat["log"][] =
            $combat["enemy"]["name"] . " was defeated!";
    }

    return true;
}


function reduceSpecialCooldown(array &$combat): void
{
    if ($combat["status"] !== "active") {
        return;
    }

    if ($combat["special_cooldown"] > 0) {
        $combat["special_cooldown"]--;
    }
}

function healChampion(array &$champion, int $healingAmount): int
{
    // Healing cannot restore a negative amount.
    $healingAmount = max(0, $healingAmount);

    // Record the champion's current valid HP.
    $previousHP = max(
        0,
        min(
            (int) $champion["hp"],
            (int) $champion["max_hp"]
        )
    );

    // Restore HP without exceeding the champion's maximum.
    $champion["hp"] = min(
        (int) $champion["max_hp"],
        $previousHP + $healingAmount
    );

    // Return the amount of HP actually restored.
    return $champion["hp"] - $previousHP;
}

function normalizeChampionHP(array &$champion): void
{
    $champion["max_hp"] = max(
        1,
        (int) $champion["max_hp"]
    );

    $champion["hp"] = max(
        0,
        min(
            (int) $champion["hp"],
            $champion["max_hp"]
        )
    );
}


function useCombatItem(array &$combat, array &$champion, array &$inventory, string $itemId): bool {

    // Items can only be used during active combat.
    if ($combat["status"] !== "active") {
        return false;
    }

    // Verify that the item is a recognized consumable.
    $consumables = getConsumableItems();

    if (!isset($consumables[$itemId])) {
        return false;
    }

    // Check that the player owns the item.
    $itemIndex = array_search($itemId, $inventory, true);

    if ($itemIndex === false) {
        return false;
    }

    // Prevent wasting a healing potion at full HP.
    if ($champion["hp"] >= $champion["max_hp"]) {
        return false;
    }

    // Restore HP using the existing healing cap.
    $healedAmount = healChampion(
        $champion,
        (int) $consumables[$itemId]["heal_amount"]
    );

    // Consume exactly one copy of the item.
    unset($inventory[$itemIndex]);
    $inventory = array_values($inventory);

    // Record the action in the combat log.
    $combat["log"][] =
        $champion["name"] .
        " used " .
        $consumables[$itemId]["name"] .
        " and restored " .
        $healedAmount .
        " HP.";

    return true;
}



?>