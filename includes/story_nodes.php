
<?php

/**
 * Three Kingdoms Ascension
 * Story Node Definitions
 *
 * Each node contains:
 * - title: The scene heading
 * - act: The current story act
 * - text: The narration shown to the player
 * - choices: Available decisions and their consequences
 */

function getStoryNodes(): array
{
    return [
        
        "introduction" => [
            "title" => "The Journey Begins",
            "act" => null,

            "text" => "Across the Three Kingdoms, rumors of an ancient mana artifact have begun to spread. As a champion of your faction, you have been summoned to investigate.",

            "backgrounds" => [
                "page" => null,
                "scene" => null
            ],

            "choices" => [
                "investigate" => [
                    "text" => "Investigate the rumors",
                    "description" => "Gather information before beginning your expedition.",
                    
                    "insight_text" => "Knowledge can reveal opportunities that strength alone cannot. Investigating these rumors may uncover valuable information about the artifact.",

                    "next" => "expedition_start",
                    
                    "requires" => [
                        "stats" => [],
                        "inventory" => [],
                        "flags" => [],
                        "trust" => []
                    ],
                    
                    "effects" => [
                        "stats" => [],
                        "inventory" => [
                            "add" => [],
                            "remove" => ["Sowrd"]
                        ],
                        "trust" => [],
                        "flags" => []
                    ],

                    "tracker_title" => "Investigating the Rumors",
                    "tracker_text" => "You decided to investigate the rumors surrounding the ancient artifact.",

                ],

                "prepare" => [
                    "text" => "Prepare for the expedition",
                    "description" => "Strengthen your preparations before leaving the kingdom.",
                    
                    "insight_text" => "Preparation may improve your chances of surviving the dangers ahead. However, delaying your investigation could allow others to reach the artifact first.",
                    
                    "next" => "expedition_start",
                    
                    "requires" => [
                        "stats" => [
                            "strength" => 15
                        ],
                        "inventory" => [],
                        "flags" => [],
                        "trust" => []
                    ],

                    "effects" => [
                        "stats" => [],
                        "inventory" => [
                            "add" => [],
                            "remove" => []
                        ],
                        "trust" => [],
                        "flags" => []
                    ],
                    
                    "tracker_title" => "Preparing for the Expedition",
                    "tracker_text" => "You decided to prepare for the expedition before leaving your kingdom.",

                ]
            ]
        ],

        "expedition_start" => [
            "title" => "The Expedition Begins",
            "act" => 1,

            "text" => "With your preparations complete, you depart from your kingdom. The road ahead is uncertain, and the rumors surrounding the ancient artifact have already begun to attract dangerous attention.",

            "backgrounds" => [
                "page" => null,
                "scene" => null
            ],

            "choices" => []
        ]


    ];
}
