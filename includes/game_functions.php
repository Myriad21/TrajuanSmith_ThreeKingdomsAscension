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
function meetsChoiceRequirements(array $champion, array $requirements) : bool {
    foreach ($requirements as $stat => $minimum) {

        // Reject requirements for unknown or invalid stats.
        if (
            !array_key_exists($stat, $champion) ||
            !is_numeric($champion[$stat]) ||
            !is_numeric($minimum)
        ) {
            return false;
        }

        // The champion must meet every minimum requirement.
        if ($champion[$stat] < $minimum) {
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
    // Only these statistics can be modified by this function.
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
function applyStoryConsequences( array $champion, array $inventory, array $effects): array {
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

    // Future handlers:
    // NPC and faction trust changes
    // Story flags

    return [
        "champion" => $champion,
        "inventory" => $inventory
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



?>