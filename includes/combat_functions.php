
<?php

function initializeCombat(string $enemyId): array
{
    $enemies = [
        "mana_corrupted_wolf" => [
            "id" => "mana_corrupted_wolf",
            "name" => "Mana-Corrupted Wolf",
            "level" => 1,
            "hp" => 36,
            "max_hp" => 36,
            "strength" => 6,
            "is_boss" => false,
        ],

        "training_dummy" => [
            "id" => "training_dummy",
            "name" => "Reinforced Training Dummy",
            "level" => 5,
            "hp" => 500,
            "max_hp" => 500,
            "strength" => 0,
            "is_boss" => false,
            "is_training" => true
        ],


        // Rival Champions
        "warrior_level_1" => [
            "id" => "warrior_level_1",
            "name" => "Warrior Champion",
            "faction" => "warrior",
            "level" => 1,
            "hp" => 120,
            "max_hp" => 120,
            "strength" => 23,
            "is_boss" => true,
        ],

        "warrior_level_2" => [
            "id" => "warrior_level_2",
            "name" => "Warrior Champion",
            "faction" => "warrior",
            "level" => 2,
            "hp" => 140,
            "max_hp" => 140,
            "strength" => 29,
            "is_boss" => true,
        ],

        "warrior_level_3" => [
            "id" => "warrior_level_3",
            "name" => "Warrior Champion",
            "faction" => "warrior",
            "level" => 3,
            "hp" => 160,
            "max_hp" => 160,
            "strength" => 35,
            "is_boss" => true,
        ],

        "warrior_level_4" => [
            "id" => "warrior_level_4",
            "name" => "Warrior Champion",
            "faction" => "warrior",
            "level" => 4,
            "hp" => 180,
            "max_hp" => 180,
            "strength" => 41,
            "is_boss" => true,
        ],

        "warrior_level_5" => [
            "id" => "warrior_level_5",
            "name" => "Warrior Champion",
            "faction" => "warrior",
            "level" => 5,
            "hp" => 200,
            "max_hp" => 200,
            "strength" => 47,
            "is_boss" => true,
        ],

        // Mage Champions

        "mage_level_1" => [
            "id" => "mage_level_1",
            "name" => "Mage Champion",
            "faction" => "mage",
            "level" => 1,
            "hp" => 85,
            "max_hp" => 85,
            "strength" => 21,
            "is_boss" => true,
        ],

        "mage_level_2" => [
            "id" => "mage_level_2",
            "name" => "Mage Champion",
            "faction" => "mage",
            "level" => 2,
            "hp" => 95,
            "max_hp" => 95,
            "strength" => 26,
            "is_boss" => true,
        ],

        "mage_level_3" => [
            "id" => "mage_level_3",
            "name" => "Mage Champion",
            "faction" => "mage",
            "level" => 3,
            "hp" => 105,
            "max_hp" => 105,
            "strength" => 31,
            "is_boss" => true,
        ],

        "mage_level_4" => [
            "id" => "mage_level_4",
            "name" => "Mage Champion",
            "faction" => "mage",
            "level" => 4,
            "hp" => 115,
            "max_hp" => 115,
            "strength" => 36,
            "is_boss" => true,
        ],

        "mage_level_5" => [
            "id" => "mage_level_5",
            "name" => "Mage Champion",
            "faction" => "mage",
            "level" => 5,
            "hp" => 125,
            "max_hp" => 125,
            "strength" => 41,
            "is_boss" => true,
        ],

        // Rogue Champions

        "rogue_level_1" => [
            "id" => "rogue_level_1",
            "name" => "Rogue Champion",
            "faction" => "rogue",
            "level" => 1,
            "hp" => 85,
            "max_hp" => 85,
            "strength" => 22,
            "is_boss" => true,
        ],

        "rogue_level_2" => [
            "id" => "rogue_level_2",
            "name" => "Rogue Champion",
            "faction" => "rogue",
            "level" => 2,
            "hp" => 100,
            "max_hp" => 100,
            "strength" => 27,
            "is_boss" => true,
        ],

        "rogue_level_3" => [
            "id" => "rogue_level_3",
            "name" => "Rogue Champion",
            "faction" => "rogue",
            "level" => 3,
            "hp" => 115,
            "max_hp" => 115,
            "strength" => 33,
            "is_boss" => true,
        ],

        "rogue_level_4" => [
            "id" => "rogue_level_4",
            "name" => "Rogue Champion",
            "faction" => "rogue",
            "level" => 4,
            "hp" => 130,
            "max_hp" => 130,
            "strength" => 38,
            "is_boss" => true,
        ],

        "rogue_level_5" => [
            "id" => "rogue_level_5",
            "name" => "Rogue Champion",
            "faction" => "rogue",
            "level" => 5,
            "hp" => 145,
            "max_hp" => 145,
            "strength" => 44,
            "is_boss" => true,
        ],


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


function startRivalCombat(
    string $rivalFaction,
    int $rivalLevel,
    bool $ambush = false
): void {

    // Validate the rival faction.
    if (!in_array($rivalFaction, ["warrior", "mage", "rogue"], true)) {
        throw new InvalidArgumentException(
            "Invalid rival faction."
        );
    }

    // Validate the rival level.
    if ($rivalLevel < 1 || $rivalLevel > 5) {
        throw new InvalidArgumentException(
            "Invalid rival level."
        );
    }

    // Select the correct enemy definition.
    $enemyId = $rivalFaction . "_level_" . $rivalLevel;

    // Initialize combat using that rival's stats.
    $combat = initializeCombat($enemyId);

    // Track the enemy's special cooldown.
    $combat["enemy_special_cooldown"] = 0;

    // Apply the Act 1 surprise attack when appropriate.
    if ($ambush) {
        $combat["enemy"]["hp"] = max(
            0,
            $combat["enemy"]["hp"] - 20
        );

        $combat["log"][] =
            "Your surprise attack deals 20 damage before the battle begins!";
    }

    // Store the battle in the session.
    $_SESSION["combat"] = $combat;
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


function performEnemyBasicAttack(
    array &$combat,
    array &$champion
): void {

    if ($combat["status"] !== "active") {
        return;
    }

    $damage = max(
        1,
        (int) $combat["enemy"]["strength"]
    );

    $champion["hp"] = max(
        0,
        (int) $champion["hp"] - $damage
    );

    $combat["log"][] =
        $combat["enemy"]["name"] .
        " attacks " .
        $champion["name"] .
        " and deals " .
        $damage .
        " damage.";

    if ($champion["hp"] <= 0) {
        $combat["status"] = "defeat";

        $combat["log"][] =
            $champion["name"] .
            " has been defeated!";
    }
}

function performEnemyAttack(array &$combat, array &$champion): void
{
    if ($combat["status"] !== "active") {
        return;
    }

    $enemy = $combat["enemy"];

    // Training dummies cannot attack or damage the champion.
    if (!empty($enemy["is_training"])) {
        $combat["log"][] =
            "The training dummy remains motionless, Taunting to try harder.";

        return;
    }

    // Ordinary enemies continue using their existing basic attack.
    if (
        !isset($enemy["faction"]) ||
        (int) ($enemy["level"] ?? 1) < 2
    ) {
        performEnemyBasicAttack($combat, $champion);
        return;
    }

    // Track the rival's special cooldown separately from the player.
    $cooldown = (int) ($combat["enemy_special_cooldown"] ?? 0);

    if ($cooldown === 0) {

        // Use a special attack when available.
        performEnemySpecialAttack($combat, $champion);

    } else {

        // Use a basic attack while the special is unavailable.
        performEnemyBasicAttack($combat, $champion);

        // Reduce cooldown after the rival's basic attack.
        $combat["enemy_special_cooldown"] = max(
            0,
            $cooldown - 1
        );
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
    string $abilityId,
    int $weaponBonus = 0
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
    if ($champion["level"] < $ability["required_level"]) {
       return false;
    }

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
        $champion["faction"],
        $weaponBonus
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


function performEnemySpecialAttack(
    array &$combat,
    array &$champion
): void {

    if ($combat["status"] !== "active") {
        return;
    }

    $enemy = &$combat["enemy"];

    // Only rival champions at Level 2 or above can use specials.
    if (
        !isset($enemy["faction"]) ||
        ($enemy["level"] ?? 1) < 2
    ) {
        return;
    }

    // Determine the special attack based on faction.
    $specials = [
        "warrior" => [
            "name" => "Power Strike",
            "bonus" => 8
        ],
        "mage" => [
            "name" => "Arcane Burst",
            "bonus" => 15
        ],
        "rogue" => [
            "name" => "Shadow Strike",
            "bonus" => 10
        ]
    ];

    $faction = $enemy["faction"];

    if (!isset($specials[$faction])) {
        return;
    }

    $special = $specials[$faction];

    // Use the rival's precalculated basic damage.
    $damage = (int) $enemy["strength"]
        + (int) $special["bonus"];

    $champion["hp"] = max(
        0,
        (int) $champion["hp"] - $damage
    );

    $combat["log"][] =
        $enemy["name"] .
        " used " .
        $special["name"] .
        " and dealt " .
        $damage .
        " damage!";

    // Begin the enemy's special cooldown.
    $combat["enemy_special_cooldown"] = 2;

    if ($champion["hp"] <= 0) {
        $combat["status"] = "defeat";

        $combat["log"][] =
            $champion["name"] .
            " has been defeated!";
    }
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


function attemptEscape(array &$combat, array $champion): bool
{
    // Escaping is only possible during active combat.
    if ($combat["status"] !== "active") {
        return false;
    }

    // Boss encounters cannot be escaped.
    if ($combat["enemy"]["is_boss"] ?? false) {
        $combat["log"][] =
            "Escape failed! You cannot flee from this battle.";

        return false;
    }

    // Ordinary encounters allow guaranteed escape.
    $combat["status"] = "escaped";

    // Record the successful escape.
    $combat["log"][] =
        $champion["name"] .
        " successfully escaped from " .
        $combat["enemy"]["name"] .
        ".";

    return true;
}



?>