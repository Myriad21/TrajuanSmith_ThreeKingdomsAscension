
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

                        
            "text" => "For generations, the Three Kingdoms have existed in an uneasy balance. The Warriors rule through military strength and discipline, the Mages through their mastery of arcane knowledge, and the Rogues through secrecy, intelligence, and precision. Though their methods differ, each kingdom has fought to preserve its independence.

            That balance is beginning to fracture.

            Whispers of an ancient artifact, said to contain an extraordinary concentration of mana, have spread across the kingdoms. Its origins remain unknown, but rumors of its power have already stirred suspicion among the three factions. Each fears what might happen should another obtain it first.

            With tensions rising and the threat of war growing closer, the leaders of each kingdom have begun searching for answers. As one of your faction's most promising champions, you have been summoned to undertake a mission that may determine the fate of all three kingdoms.",

            "faction_text" => [
                "warrior" => "Within the Warrior Kingdom's fortified halls, your commanders deliver their orders. You are to investigate the artifact's rumored location and ensure that no rival faction gains the power to threaten your homeland.",

                "mage" => "Within the Mage Kingdom's grand archives, the senior scholars present their findings. The artifact's magical properties could surpass anything they have studied. You are instructed to uncover its origins and determine whether its power can be safely controlled.",

                "rogue" => "Within the Rogue Kingdom's hidden headquarters, your superiors reveal intelligence gathered from across the borders. Rival agents are already searching for the artifact. You are ordered to discover its location before the other kingdoms can act."
            ],

            "companion_text" => "Two senior cultivators, both having reached Level 4, have been assigned to investigate the mysterious artifact. Their experience and strength make them well suited to uncovering the truth behind its appearance.

                                As your kingdom's chosen champion and a promising future leader, you have been permitted to accompany them. Although your cultivation remains at Level 1, the expedition presents an opportunity to gain experience, strengthen your abilities, and observe matters that may one day become your responsibility.

                                The seniors will conduct their investigation while keeping watch over your safety, leaving you free to explore and develop your own judgment throughout the journey.",

                                
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
                            "remove" => []
                        ],
                        "trust" => [],
                        "flags" => [
                            "artifact_rival_warning" => true
                        ]
                    ],

                    "tracker_title" => "Investigating the Rumors",
                    "tracker_text" => "You decided to investigate the rumors surrounding the ancient artifact.",

                ],

                "prepare" => [
                    "text" => "Prepare for the expedition",
                    "description" => "Strengthen your preparations before leaving the kingdom.",
                    
                    "insight_text" => "Preparation may improve your chances of surviving the dangers ahead.",
                    
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
                            "add" => ["healing_potion"],
                            "remove" => []
                        ],
                        "trust" => [],
                        "flags" => [
                            "artifact_rival_warning" => false
                        ]
                    ],
                    
                    "tracker_title" => "Preparing for the Expedition",
                    "tracker_text" => "You decided to prepare for the expedition before leaving your kingdom.",

                ]
            ]
        ],

        "expedition_start" => [
            "title" => "The Expedition Begins",
            "act" => 1,

            
            "text" => "After several days of travel, your expedition finally reaches the outskirts of an ancient ruin, partially concealed by the surrounding forest.

            Weathered stone pillars rise above the vegetation, while fragments of forgotten structures lie scattered along the path. Although the area appears abandoned, an unusual concentration of mana lingers in the atmosphere.

            Your two senior companions begin examining the surrounding structures, searching for traces of the mysterious artifact. Their greater cultivation allows them to sense disturbances in the mana that remain beyond your current abilities.

            For now, the area appears relatively safe. With the seniors occupied by their investigation, you have an opportunity to explore your surroundings.

            Several points of interest catch your attention: strange markings carved into an ancient stone monument, an overgrown path leading deeper into the forest, and unusual fluctuations of mana near the ruins.

            You may investigate these locations, or ignore them and continue the expedition. However, any discoveries left behind may prove valuable later in your journey.",


            "conditional_text" => [
                [
                    "requires" => [
                        "flags" => [
                            "artifact_rival_warning" => true
                        ]
                    ],
                    "text" => "Before leaving your kingdom, you examined intelligence reports concerning the ancient artifact. Among the scattered accounts, one detail stood out: agents from the other two kingdoms had been sighted traveling toward the same region.

                    The reports offered no confirmation of their intentions, but one thing was clear. You were unlikely to be the only champion searching for the artifact.

                    As you begin your journey, you remain alert for signs of rival activity."
                ],
                [
                    "requires" => [
                        "flags" => [
                            "artifact_rival_warning" => false
                        ]
                    ],
                    "text" => "Before departing, you gathered supplies for the difficult journey ahead. Among your provisions is a Healing Potion, carefully packed for use in an emergency.
                            Although you have little information surrounding this expedition, you begin your expedition better equipped to face the dangers ahead."
                ]
            ],

            "backgrounds" => [
                "page" => null,
                "scene" => null
            ],
            
            "choices" => [
                "examine_markings" => [
                    "text" => "Examine the Ancient Stone Markings",
                    "description" => "Investigate the strange markings carved into the ruins.",
                    "insight_text" => "Ancient markings may reveal information about the ruins and their connection to the artifact.",
                    "next" => "explore_markings",
                    "requires" => [
                        "stats" => [],
                        "inventory" => [],
                        "flags" => [
                            "explored_markings" => false
                        ],
                        "trust" => []
                    ],
                    "effects" => [],

                    "tracker_title" => "Investigating the Ancient Markings",
                    "tracker_text" => "You decided to examine the mysterious markings carved into the ruins, hoping to uncover clues about the artifact.",

                ],

                "explore_path" => [
                    "text" => "Explore the Overgrown Path",
                    "description" => "Search a partially concealed path for anything useful.",
                    "insight_text" => "Forgotten paths may conceal valuable equipment or supplies.",
                    "next" => "explore_path",
                    "requires" => [
                        "stats" => [],
                        "inventory" => [],
                        "flags" => [
                            "explored_path" => false
                        ],
                        "trust" => []
                    ],
                    "effects" => [],

                    "tracker_title" => "Exploring the Overgrown Path",
                    "tracker_text" => "You ventured beyond the main ruins to investigate a forgotten trail concealed by the surrounding forest.",

                ],

                "investigate_mana" => [
                    "text" => "Investigate the Unusual Mana",
                    "description" => "Examine the strange mana fluctuations surrounding the ruins.",
                    "insight_text" => "The unusual mana may explain why the surrounding area feels disturbed.",
                    "next" => "explore_mana",
                    "requires" => [
                        "stats" => [],
                        "inventory" => [],
                        "flags" => [
                            "explored_mana" => false
                        ],
                        "trust" => []
                    ],
                    "effects" => [],

                    "tracker_title" => "Investigating the Mana Disturbance",
                    "tracker_text" => "You chose to investigate the unusual mana fluctuations surrounding the ancient ruins.",

                ],

                "continue_expedition" => [
                    "text" => "Continue the Expedition",
                    "description" => "Leave the area behind and proceed deeper into the ruins.",
                    "insight_text" => "Moving forward will leave any unexplored discoveries behind.",
                    "next" => "expedition_deeper",
                    "requires" => [
                        "stats" => [],
                        "inventory" => [],
                        "flags" => [],
                        "trust" => []
                    ],
                    "effects" => [],

                    "tracker_title" => "Continuing the Expedition",
                    "tracker_text" => "You decided to leave the exploration area behind and proceed deeper into the ruins, abandoning any remaining discoveries.",

                ]
            ]

        ],

        "explore_markings" => [
            "title" => "The Ancient Stone Markings",
            "act" => 1,

            "text" => "You approach the weathered stone monument, brushing aside the vines that have grown across its surface.

            Strange symbols have been carved into the stone. Although much of the writing has faded, several markings remain visible beneath the accumulated dirt and moss.

            As you examine the monument, you notice that the symbols appear to follow the flow of mana through the surrounding area. The markings suggest that this place once held a much greater concentration of mana than it does today.

            You cannot determine who created the monument or what purpose it originally served, but the discovery suggests that the unusual mana surrounding these ruins may not be a recent phenomenon.

            After committing the markings to memory, you turn your attention back toward the expedition.",

            "backgrounds" => [
                "page" => null,
                "scene" => null
            ],

            "choices" => [
                "return_to_exploration" => [
                    "text" => "Return to the Expedition",
                    "description" => "Rejoin the expedition and investigate another location.",
                    "insight_text" => "The markings may become important as you uncover more about the artifact.",
                    "next" => "expedition_start",
                    "requires" => [],
                    "effects" => [
                        "flags" => [
                            "explored_markings" => true,
                            "artifact_markings_clue" => true
                        ]
                    ],

                    "tracker_title" => "Uncovering the Ancient Markings",
                    "tracker_text" => "You discovered that the markings follow the flow of mana through the ruins, suggesting that the area's unusual mana concentration may have ancient origins.",

                ]
            ]
        ],

        "explore_path" => [
            "title" => "The Overgrown Path",
            "act" => 1,

            "text" => "You follow a narrow trail leading away from the main ruins. Thick vegetation covers much of the path, and broken stone structures lie scattered beneath the surrounding trees.

            After a short walk, you discover the remains of an abandoned campsite. Its shelters have long since collapsed, leaving behind weathered supplies and fragments of equipment.

            Among the scattered belongings, you notice a partially concealed weapon. Despite its age, the weapon appears remarkably well preserved. A faint trace of mana lingers within it, suggesting that it was crafted for a cultivator.",

            "faction_text" => [
                "warrior" => "You uncover a Reinforced Sword. Its sturdy blade and balanced construction should make it more effective than your Basic Sword.",

                "mage" => "You uncover an Enhanced Staff. Faint magical inscriptions run along its surface, suggesting that it can channel mana more effectively than your Basic Staff.",

                "rogue" => "You uncover a Reinforced Dagger. Its lightweight design and sharpened edge should make it more effective than your Basic Dagger."
            ],

            "backgrounds" => [
                "page" => null,
                "scene" => null
            ],

            "choices" => [

                "take_weapon" => [
                    "text" => "Take Weapon",
                    "description" => "Collect the weapon discovered at the abandoned campsite.",
                    "insight_text" => "The weapon may prove useful during future battles.",

                    "next" => "explore_path",

                    "requires" => [
                        "stats" => [],
                        "inventory" => [],
                        "flags" => [
                            "path_weapon_collected" => false
                        ],
                        "trust" => []
                    ],

                    "effects" => [
                        "flags" => [
                            "path_weapon_collected" => true
                        ]
                    ],

                    "tracker_title" => "Recovering Forgotten Equipment",
                    "tracker_text" => "You recovered a weapon from the abandoned campsite."
                ],

                "return_to_exploration" => [
                    "text" => "Return to the Expedition",
                    "description" => "Leave the abandoned campsite and rejoin the expedition",
                    "insight_text" => "A stronger weapon may improve your chances of surviving future encounters.",
                    "next" => "expedition_start",
                    "requires" => [],
                    "effects" => [
                        "flags" => [
                            "explored_path" => true
                        ]
                    ],

                    "tracker_title" => "Discovering Forgotten Equipment",
                    "tracker_text" => "You discovered an abandoned campsite containing a well-preserved cultivator weapon, potentially superior to your starting equipment.",

                ]
            ]
        ],

        "explore_mana" => [
            "title" => "The Unusual Mana",
            "act" => 1,

            "text" => "You approach a secluded section of the ruins where the surrounding mana feels noticeably different.

            At first, the disturbance is difficult to identify. The mana in the atmosphere appears to fluctuate unpredictably, occasionally gathering into faint streams of energy before dispersing into the surrounding forest.

            As you concentrate on the disturbance, you notice several unusual tracks in the soil. They resemble those of a wild beast, but the surrounding vegetation has been damaged in ways that suggest something far more aggressive than ordinary wildlife.

            Nearby, deep scratches mark the surface of a fallen stone pillar. Faint traces of unstable mana linger around the damaged stone.

            You begin to suspect that the unusual mana is affecting the creatures inhabiting these ruins. Whatever caused these disturbances may still be nearby.

            Having gathered what information you can, you decide to return to the expedition.",

            "backgrounds" => [
                "page" => null,
                "scene" => null
            ],

            "choices" => [
                "return_to_exploration" => [
                    "text" => "Return to the Expedition",
                    "description" => "Return to the main ruins with your findings.",

                    "insight_text" => "Recognizing signs of danger before an encounter may provide an advantage.",

                    "tracker_title" => "Discovering Signs of Danger",
                    "tracker_text" => "You discovered evidence that unstable mana may be affecting the local wildlife, suggesting that a dangerous creature could be roaming the ruins.",

                    "next" => "expedition_start",
                    "requires" => [],

                    "effects" => [
                        "flags" => [
                            "explored_mana" => true,
                            "mana_beast_warning" => true
                        ]
                    ]
                ]
            ]
        ],
        
        "expedition_deeper" => [
            "title" => "A Disturbance in the Ruins",
            "act" => 1,

            "conditional_text" => [
                [
                    "requires" => [
                        "flags" => [
                            "mana_beast_warning" => true
                        ]
                    ],
                    "text" => "As you prepare to leave the outer ruins, a familiar sensation catches your attention.

                                The unstable mana you investigated earlier has grown noticeably stronger. Remembering the damaged vegetation and unusual tracks, you suspect that something dangerous is nearby.

                                You warn your two senior companions to remain alert as the expedition moves forward."
                ]
            ],

            "text" => "Leaving the outer ruins behind, you follow your two senior companions deeper into the forest.

                    The vegetation grows increasingly dense, and the ancient structures become harder to recognize. An unnatural silence settles over the surrounding area.

                    Suddenly, a violent surge of corrupted mana ripples through the trees. The bushes ahead begin to shake.

                    A large wolf emerges from the vegetation. Dark mana flows across its body, and its eyes glow with an unnatural light.

                    The Mana-Corrupted Wolf lowers its head and prepares to attack.",

            "backgrounds" => [
                "page" => null,
                "scene" => null
            ],

            "choices" => []
        ],








    ];
}
