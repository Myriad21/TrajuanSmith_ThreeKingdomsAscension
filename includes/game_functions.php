
<?php

function createChampion(string $name, string $faction): array
{
    $startingStats = [
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
