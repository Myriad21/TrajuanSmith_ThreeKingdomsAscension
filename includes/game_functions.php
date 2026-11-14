<?php


function getStartingStats(): array
{
    return [
        "warrior" => [
            "hp" => 120,
            "strength" => 15,
            "mana" => 8
        ],
        "mage" => [
            "hp" => 85,
            "strength" => 7,
            "mana" => 20
        ],
        "rogue" => [
            "hp" => 85,
            "strength" => 13,
            "mana" => 12
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
        "hp" => "HP",
        "strength" => "Strength",
        "mana" => "Mana"
    ];

    $statEffects = $effects["stats"] ?? [];

    if (!is_array($statEffects)) {
        return $previews;
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

    return $previews;
}








?>