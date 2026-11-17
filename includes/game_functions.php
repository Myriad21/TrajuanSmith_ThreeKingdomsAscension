<?php


function getStartingStats(): array
{
    return [
        "warrior" => [
            "hp" => 120,
            "strength" => 15,
            "mana" => 40
        ],
        "mage" => [
            "hp" => 85,
            "strength" => 7,
            "mana" => 100
        ],
        "rogue" => [
            "hp" => 85,
            "strength" => 13,
            "mana" => 70
        ]
    ];
}


function createChampion(string $name, string $faction): array
{
    $startingStats = getStartingStats();

    if (!isset($startingStats[$faction])) {
        throw new InvalidArgumentException(
            "Invalid faction selected."
        );
    }

    return [
        "name" => $name,
        "faction" => $faction,
        "hp" => $startingStats[$faction]["hp"],
        "max_hp" => $startingStats[$faction]["hp"],
        "strength" => $startingStats[$faction]["strength"],
        "mana" => $startingStats[$faction]["mana"],
        "max_mana" => $startingStats[$faction]["mana"],
        
        "level" => 1,
        "inventory" => [],

        "act" => 1,
        "story_node" => "act1_start",
        "choices_log" => [],

        
        "relationships" => [
            "warrior" => $faction === "warrior" ? 100 : 50,
            "mage" => $faction === "mage" ? 100 : 50,
            "rogue" => $faction === "rogue" ? 100 : 50
        ],

        "defeated_rivals" => [],

        "artifact_knowledge" => false,
        "ending" => null

    ];
}


/**
 * Check whether a champion meets the stat requirements
 * for a story choice.
 *
 * An empty requirements array means the choice is unlocked.
 */
function meetsChoiceRequirements(array $champion, array $inventory, array $flags, array $requirements): bool {

    // Rejects unsupported requirement categories.
    $allowedCategories = ["stats", "inventory", "flags", "trust"];

    foreach ($requirements as $category => $value) {
        if (
            !in_array($category, $allowedCategories, true) ||
            !is_array($value)
        ) {
            return false;
        }
    }

    // 1. Check minimum stat requirements.
    foreach ($requirements["stats"] ?? [] as $stat => $minimum) {
        if (
            !is_string($stat) ||
            !isset($champion[$stat]) ||
            !is_numeric($champion[$stat]) ||
            !is_numeric($minimum) ||
            $champion[$stat] < $minimum
        ) {
            return false;
        }
    }

    // 2. Check required inventory items.
    foreach ($requirements["inventory"] ?? [] as $itemId) {
        if (
            !is_string($itemId) ||
            !in_array($itemId, $inventory, true)
        ) {
            return false;
        }
    }

    // 3. Check story flags.
    foreach ($requirements["flags"] ?? [] as $flag => $expected) {
        if (
            !is_string($flag) ||
            !is_bool($expected) ||
            ($flags[$flag] ?? false) !== $expected
        ) {
            return false;
        }
    }

    // 4. Check hidden relationship requirements.
    $playerFaction = $champion["faction"] ?? "";

    foreach ($requirements["trust"] ?? [] as $target => $minimum) {

        if (
            !is_string($target) ||
            !is_numeric($minimum)
        ) {
            return false;
        }

        $resolvedTarget = resolveRelationshipTarget(
            $target,
            $playerFaction
        );

        if (
            $resolvedTarget === null ||
            $resolvedTarget === $playerFaction ||
            !isset($champion["relationships"][$resolvedTarget]) ||
            $champion["relationships"][$resolvedTarget] < $minimum
        ) {
            return false;
        }
    }

    return true;
}



/** Apply stat changes caused by a story choice.
 *
 * Positive values increase a stat.
 * Negative values decrease a stat.
 */
function applyStatEffects(array $champion, array $effects): array {
    // Only these Stats can be modified by this function.
    $allowedStats = [
        "hp",
        "strength",
        "mana"
    ];

    foreach ($effects as $stat => $change) {

        // Ignore unsupported stats or invalid changes.
        if (
            !in_array($stat, $allowedStats, true) ||
            !is_numeric($change)
        ) {
            continue;
        }

        // Apply the change.
        $champion[$stat] += $change;

        // Health cannot exceed maximum HP or fall below zero.
        if ($stat === "hp") {
            $champion["hp"] = max(
                0,
                min($champion["hp"], $champion["max_hp"])
            );
        }

        // Mana cannot exceed maximum Mana or fall below zero.
        if ($stat === "mana") {
            $champion["mana"] = max(
                0,
                min($champion["mana"], $champion["max_mana"])
            );
        }

        // Strength cannot become negative.
        if ($stat === "strength") {
            $champion["strength"] = max(
                0,
                $champion["strength"]
            );
        }
    }

    return $champion;
}


/**
 * Apply all supported story choice consequences.
 *
 * The effects array can contain:
 * - stats
 * - inventory
 * - trust
 * - flags
 *
 */
function applyStoryConsequences( array $champion, array $inventory, array $flags, array $effects): array {
    // Apply champion stat changes.
    $statEffects = $effects["stats"] ?? [];

    if (is_array($statEffects)) {
        $champion = applyStatEffects(
            $champion,
            $statEffects
        );
    }

    // Inventory rewards and removals
    $inventoryEffects = $effects["inventory"] ?? [];

    if (is_array($inventoryEffects)) {
        $inventory = applyInventoryEffects(
            $inventory,
            $inventoryEffects
        );
    }

    // Apply faction relationship changes.
    $trustEffects = $effects["trust"] ?? [];

    if (is_array($trustEffects)) {
        $champion = applyTrustEffects(
            $champion,
            $trustEffects
        );
    }

    // Story flags
    $flagEffects = $effects["flags"] ?? [];

    if (is_array($flagEffects)) {
        $flags = applyFlagEffects(
            $flags,
            $flagEffects
        );
    }

    // Apply reusable special effects.
    $specialEffects = $effects["special"] ?? [];

    if (
        is_array($specialEffects) &&
        !empty($specialEffects["level_up"])
    ) {
        $levels = (int) $specialEffects["level_up"];

        $champion = levelUpChampion(
            $champion,
            $levels
        );
    }




    return [
        "champion" => $champion,
        "inventory" => $inventory,
        "flags" => $flags
    ];
}


function applyInventoryEffects( array $inventory, array $effects): array {
    // Add items to the inventory.
    $itemsToAdd = $effects["add"] ?? [];

    if (is_array($itemsToAdd)) {
        foreach ($itemsToAdd as $itemId) {
            if (!is_string($itemId) || $itemId === "") {
                continue;
            }

            $inventory[] = $itemId;
        }
    }

    // Remove items from the inventory.
    $itemsToRemove = $effects["remove"] ?? [];

    if (is_array($itemsToRemove)) {
        foreach ($itemsToRemove as $itemId) {
            if (!is_string($itemId) || $itemId === "") {
                continue;
            }

            $itemIndex = array_search(
                $itemId,
                $inventory,
                true
            );

            if ($itemIndex !== false) {
                unset($inventory[$itemIndex]);
            }
        }
    }

    // Reindex the inventory after removing items.
    return array_values($inventory);
}


/**
 * Determine which rival champion the player
 * encounters first in Act 1 based on their faction.
 */
function getFirstRival(string $faction): ?string
{
    $encounters = [
        "warrior" => "rogue",
        "rogue" => "mage",
        "mage" => "warrior"
    ];

    return $encounters[$faction] ?? null;
}


/**
 * Resolve a relationship target based on
 * the player's selected faction.
 */
function resolveRelationshipTarget( string $target, string $playerFaction): ?string {
    if ($target === "first_rival") {
        return getFirstRival($playerFaction);
    }

    $validFactions = ["warrior", "mage", "rogue"];

    if (in_array($target, $validFactions, true)) {
        return $target;
    }

    return null;
}


/**
 * Apply relationship changes from story choices.
 *
 * Positive values increase trust.
 * Negative values decrease trust.
 * Trust is always limited to 0–100.
 */
function applyTrustEffects(array $champion, array $effects): array {
    $playerFaction = $champion["faction"];

    foreach ($effects as $target => $change) {

        // Ignore invalid trust changes.
        if (!is_string($target) || !is_numeric($change)) {
            continue;
        }

        // Convert dynamic targets into actual factions.
        $resolvedTarget = resolveRelationshipTarget(
            $target,
            $playerFaction
        );

        // Ignore unknown relationship targets.
        if (
            $resolvedTarget === null ||
            !isset($champion["relationships"][$resolvedTarget])
        ) {
            continue;
        }

        // Keep the player's own faction at maximum trust.
        if ($resolvedTarget === $playerFaction) {
            continue;
        }

        // Apply the change and enforce the 0–100 limits.
        $currentTrust = $champion["relationships"][$resolvedTarget];

        $champion["relationships"][$resolvedTarget] = max(
            0,
            min(100, $currentTrust + $change)
        );
    }

    return $champion;
}


/**
 * Convert a numerical trust value into
 * a descriptive relationship tier.
 */
function getRelationshipTier(int $trust): string
{
    $trust = max(0, min(100, $trust));

    switch (true) {
        case $trust <= 20:
            return "Hostile";

        case $trust <= 40:
            return "Wary";

        case $trust <= 59:
            return "Neutral";

        case $trust <= 79:
            return "Cooperative";

        case $trust <= 89:
            return "Trusted";

        default:
            return "Fully Trusted";
    }
}


/**
 * Retrieve the relationship status of a rival champion.
 *
 * Returns null if the target is invalid or
 * belongs to the player's own faction.
 */
function getRivalRelationshipStatus(array $champion, string $target): ?string {
    $playerFaction = $champion["faction"] ?? null;

    if (!is_string($playerFaction)) {
        return null;
    }

    $rivalFaction = resolveRelationshipTarget(
        $target,
        $playerFaction
    );

    // Reject invalid targets and the player's own faction.
    if (
        $rivalFaction === null ||
        $rivalFaction === $playerFaction
    ) {
        return null;
    }

    // Retrieve the stored relationship value.
    $trust = $champion["relationships"][$rivalFaction] ?? null;

    if (!is_numeric($trust)) {
        return null;
    }

    // Convert the hidden number into a visible tier.
    return getRelationshipTier((int) $trust);
}


/**
 * Apply story flag changes caused by player choices.
 *
 * True means an event occurred.
 * False means the event was cleared or reversed.
 */
function applyFlagEffects(array $flags, array $effects): array {
    foreach ($effects as $flag => $value) {
        if (
            !is_string($flag) ||
            $flag === "" ||
            !is_bool($value)
        ) {
            continue;
        }
        $flags[$flag] = $value;
    }

    return $flags;
}


/**
 * Generate visible stat consequence previews
 * from a story choice's effects.
 *
 * Hidden trust changes and story flags are excluded.
 */
function getChoiceStatPreviews(array $effects): array
{
    $previews = [];

    $allowedStats = [
        "level" => "Level",
        "max_hp" => "Max HP",
        "hp" => "HP",
        "strength" => "Strength",
        "max_mana" => "Max Mana",
        "mana" => "Mana"
    ];

    $statEffects = $effects["stats"] ?? [];

    if (!is_array($statEffects)) {
        $statEffects = [];
    }

    foreach ($statEffects as $stat => $change) {

        if (
            !isset($allowedStats[$stat]) ||
            !is_numeric($change) ||
            $change == 0
        ) {
            continue;
        }

        $sign = $change > 0 ? "+" : "";

        $previews[] = [
            "text" => $sign . $change . " " . $allowedStats[$stat],
            "type" => $change > 0 ? "positive" : "negative"
        ];
    }


    // Preview level increases from reusable special effects.
    $levelIncrease = (int) ($effects["special"]["level_up"] ?? 0);

    if ($levelIncrease > 0) {
        $previews[] = [
            "text" => "+" . $levelIncrease . " Level",
            "type" => "positive"
        ];
    }


    return $previews;
}


/**
 * Generate Insight Relic guidance for a story choice.
 *
 * Relationship changes are described narratively.
 * Exact trust values remain hidden.
 */
function getInsightRelicHint(array $effects, array $choicesLog = []): ?string
{
    
    // Predict cultivation breakthroughs from special effects.
    $levelIncrease = (int) ($effects["special"]["level_up"] ?? 0);

    if ($levelIncrease > 0) {
        if ($levelIncrease === 1) {
            return "This choice may increase your cultivation level by 1, strengthening your abilities and unlocking new combat techniques.";
        }

        return "This choice may increase your cultivation level by up to {$levelIncrease} levels, strengthening your abilities and unlocking new combat techniques.";
    }


    $trustEffects = $effects["trust"] ?? [];

    if (!is_array($trustEffects) || empty($trustEffects)) {
        return null;
    }

    // Track specific decisions from the player's story history.
    $attackedRivals = false;
    $approachedRivals = false;

    foreach ($choicesLog as $previousChoice) {

        $previousScene = $previousChoice["scene"] ?? "";
        $previousChoiceId = $previousChoice["choice"] ?? "";

        // Check whether the player launched a surprise attack.
        if ($previousChoiceId === "surprise_attack_rival") {
            $attackedRivals = true;
        }

        // Check whether the player approached peacefully.
        if ($previousChoiceId === "approach_rivals") {
            $approachedRivals = true;
        }
    }

    $hasPositiveChange = false;
    $hasNegativeChange = false;

    foreach ($trustEffects as $change) {

        if (!is_numeric($change)) {
            continue;
        }

        if ($change > 0) {
            $hasPositiveChange = true;
        } elseif ($change < 0) {
            $hasNegativeChange = true;
        }
    }

    if ($hasPositiveChange && $hasNegativeChange) {
        return "This decision may strengthen some alliances while straining others.";
    }

    if ($hasPositiveChange) {

        if ($attackedRivals) {
            return "Your earlier surprise attack damaged relations with the rival expedition. This decision may help rebuild trust, although past hostility may not be easily forgotten.";
        }

        if ($approachedRivals) {
            return "You previously chose diplomacy over aggression. This decision may further strengthen your relationships with other champions.";
        }

        return "This decision may improve your relationship with another champion.";
    }

   if ($hasNegativeChange) {

        if ($attackedRivals) {
            return "Your earlier surprise attack has already created hostility. This decision may further worsen your image.";
        }

        if ($approachedRivals) {
            return "Although you previously approached the rival expedition peacefully, this decision may undermine the goodwill established through diplomacy.";
        }

        return "This decision may damage your relationship with another champion.";
    }

    return null;
}


/**
 * Generate a summary of the actual consequences
 * caused by a player's story choice.
 *
 * Supports stats, inventory, and relationship changes.
 */
function getChoiceConsequenceSummary( array $championBefore,
    array $championAfter,
    array $inventoryBefore,
    array $inventoryAfter
): array {

    $summary = [];

    // 1. STAT CONSEQUENCES
    $statNames = [
        "level" => "Level",
        "max_hp" => "Max HP",
        "hp" => "HP",
        "strength" => "Strength",
        "max_mana" => "Max Mana",
        "mana" => "Mana"
    ];

    // Compare actual stats before and after the decision.
    foreach ($statNames as $stat => $displayName) {

        $before = $championBefore[$stat] ?? null;
        $after = $championAfter[$stat] ?? null;

        if (!is_numeric($before) || !is_numeric($after)) {
            continue;
        }

        $change = $after - $before;

        // Ignore stats that did not change.
        if ($change == 0) {
            continue;
        }

        $sign = $change > 0 ? "+" : "";

        $summary[] = [
            "text" => $sign . $change . " " . $displayName,
            "type" => $change > 0 ? "positive" : "negative"
        ];
    }

    // 2. INVENTORY CONSEQUENCES

    // Count how many copies of each item existed.
    $itemsBefore = array_count_values($inventoryBefore);
    $itemsAfter = array_count_values($inventoryAfter);

    // Collect all items from both inventories.
    $allItems = array_unique(array_merge(
        array_keys($itemsBefore),
        array_keys($itemsAfter)
    ));

    foreach ($allItems as $itemId) {

        $beforeCount = $itemsBefore[$itemId] ?? 0;
        $afterCount = $itemsAfter[$itemId] ?? 0;

        $change = $afterCount - $beforeCount;

        // Ignore items whose quantities did not change.
        if ($change === 0) {
            continue;
        }

        // Convert item IDs into readable names.
        $itemName = ucwords(str_replace("_", " ", $itemId));

        $sign = $change > 0 ? "+" : "";

        $summary[] = [
            "text" => $sign . $change . " " . $itemName,
            "type" => $change > 0 ? "positive" : "negative"
        ];
    }

    // 3. RELATIONSHIP CONSEQUENCES

    // Compare actual relationship values.
    // Never display the hidden numerical values.

    $relationshipsBefore = $championBefore["relationships"] ?? [];
    $relationshipsAfter = $championAfter["relationships"] ?? [];

    $hasPositiveChange = false;
    $hasNegativeChange = false;

    foreach ($relationshipsAfter as $faction => $afterTrust) {

        $beforeTrust = $relationshipsBefore[$faction] ?? null;

        if (
            !is_numeric($beforeTrust) ||
            !is_numeric($afterTrust)
        ) {
            continue;
        }

        $change = $afterTrust - $beforeTrust;

        if ($change > 0) {
            $hasPositiveChange = true;
        } elseif ($change < 0) {
            $hasNegativeChange = true;
        }
    }

    if ($hasPositiveChange) {
        $summary[] = [
            "text" => "Your relationship has improved",
            "type" => "positive"
        ];
    }

    if ($hasNegativeChange) {
        $summary[] = [
            "text" => "Your relationship has worsened",
            "type" => "negative"
        ];
    }

    return $summary;
}


function getConsumableItems(): array
{
    return [
        "healing_potion" => [
            "name" => "Healing Potion",
            "description" => "Restores up to 30 HP.",
            "type" => "consumable",
            "heal_amount" => 30
        ]
    ];
}


function getWeapons(): array
{
    return [
        "reinforced_sword" => [
            "name" => "Reinforced Sword",
            "faction" => "warrior",
            "damage_bonus" => 3,
            "description" => "A sturdy sword recovered from an abandoned campsite."
        ],

        "enhanced_staff" => [
            "name" => "Enhanced Staff",
            "faction" => "mage",
            "damage_bonus" => 3,
            "description" => "A staff inscribed with symbols that enhance its combat power."
        ],

        "reinforced_dagger" => [
            "name" => "Reinforced Dagger",
            "faction" => "rogue",
            "damage_bonus" => 3,
            "description" => "A lightweight dagger with a reinforced, sharpened blade."
        ]
    ];
}

function getWeapon(string $weaponId): ?array
{
    $weapons = getWeapons();

    if (!isset($weapons[$weaponId])) {
        return null;
    }

    return array_merge(
        ["id" => $weaponId],
        $weapons[$weaponId]
    );
}

function getExpeditionWeapon(string $faction): ?array
{
    $expeditionWeapons = [
        "warrior" => "reinforced_sword",
        "mage" => "enhanced_staff",
        "rogue" => "reinforced_dagger"
    ];

    $weaponId = $expeditionWeapons[strtolower($faction)] ?? null;

    return $weaponId !== null
        ? getWeapon($weaponId)
        : null;
}


function canEquipWeapon(
    string $weaponId,
    string $faction,
    array $inventory
): bool {
    $weapon = getWeapon($weaponId);

    if ($weapon === null) {
        return false;
    }

    // The weapon must belong to the player's faction.
    if ($weapon["faction"] !== strtolower($faction)) {
        return false;
    }

    // The player must actually own the weapon.
    return in_array($weaponId, $inventory, true);
}


function getEquippedWeaponBonus(
    array $champion,
    array $inventory
): int {
    $weaponId = $champion["equipped_weapon"] ?? null;

    if (!is_string($weaponId)) {
        return 0;
    }

    if (!canEquipWeapon(
        $weaponId,
        $champion["faction"],
        $inventory
    )) {
        return 0;
    }

    $weapon = getWeapon($weaponId);

    return (int) ($weapon["damage_bonus"] ?? 0);
}


/**
 * Level up a champion using faction-specific stat gains.
 * Champions cannot exceed Level 5 with this function.
 */
function levelUpChampion(array $champion, int $levels = 1): array
{
    $statGains = [
        "warrior" => [
            "max_hp" => 20,
            "strength" => 5,
            "max_mana" => 10
        ],
        "mage" => [
            "max_hp" => 10,
            "strength" => 3,
            "max_mana" => 22
        ],
        "rogue" => [
            "max_hp" => 15,
            "strength" => 4,
            "max_mana" => 16
        ]
    ];

    $faction = $champion["faction"] ?? "";

    if (!isset($statGains[$faction]) || $levels <= 0) {
        return $champion;
    }

    for ($i = 0; $i < $levels; $i++) {

        if ($champion["level"] >= 5) {
            break;
        }

        $champion["level"]++;

        $champion["max_hp"] += $statGains[$faction]["max_hp"];
        $champion["strength"] += $statGains[$faction]["strength"];
        $champion["max_mana"] += $statGains[$faction]["max_mana"];

        
        // Fully restore HP after gaining a level.
        $champion["hp"] = $champion["max_hp"];


        $champion["mana"] = min(
            $champion["max_mana"],
            $champion["mana"] + $statGains[$faction]["max_mana"]
        );
    }

    return $champion;
}

/**
 * Zenith Boost - This is outside level stat specific increases 
 * that do not increase level
 * Only available in act II through sufficient exploration of Compound
 * And its surrounding Area. Once a character
 * 
 * A set +5 increase in strenght for Warrior
 * A set +5 increase in Mana for Mage
 * A set +2 strength and +3 mana for Rogue
 * 
 * Achieve 3 Zenith boosts and Achieve Level 5 to fullfill one of the
 * requirements for the 3 fold accord secret ending.
 */

function zenithBoost() {}















?>