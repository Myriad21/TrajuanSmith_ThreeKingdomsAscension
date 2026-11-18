
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
                ],
                [
                    "requires" => [
                        "flags" => [
                            "mana_beast_warning" => false
                        ]
                    ],

                    
                    "text" => "Without warning, the creature lunges from the surrounding vegetation.

                        You had no reason to expect an attack, and the sudden assault catches you completely off guard. The wolf's claws tear across your defenses before you can react.

                        You lose 12 HP from the surprise attack.

                        Despite the injury, you regain your footing and prepare to confront the creature."

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

            

            "choices" => [
                "fight_wolf" => [
                    "text" => "Confront the Mana-Corrupted Wolf",

                    "description" => "Prepare your weapon and face the corrupted creature.",

                    "insight_text" => "The wolf is dangerous, but defeating it may allow the expedition to continue.",

                    "next" => "expedition_deeper",

                    "requires" => [
                        "flags" => [
                            "wolf_defeated" => false
                        ]
                    ],

                    "effects" => [],

                    "tracker_title" => "Confronting the Corrupted Wolf",

                    "tracker_text" => "You prepared to battle the Mana-Corrupted Wolf."
                ],

                "continue_after_wolf" => [
                    "text" => "Continue the Expedition",

                    "description" => "With the corrupted wolf defeated, proceed deeper into the ruins.",

                    "insight_text" => "The immediate danger has passed. Your expedition can now continue.",

                    "next" => "wolf_aftermath",

                    "requires" => [
                        "flags" => [
                            "wolf_defeated" => true
                        ]
                    ],

                    "effects" => [],

                    "tracker_title" => "Wolf Defeated",

                    "tracker_text" => "You defeated the Mana-Corrupted Wolf and secured the expedition's path."
                ]
            ]


        ],


        "wolf_aftermath" => [
            "title" => "After the Battle",
            "act" => 1,

            "conditional_text" => [
                [
                    "requires" => [
                        "flags" => [
                            "mana_beast_warning" => true
                        ]
                    ],

                    "text" => "One of your senior companions turns toward you.

                    'Your earlier warning gave us time to prepare. Without it, that creature might have caught the entire expedition by surprise.'

                    Their acknowledgment reinforces the value of your investigation. Although your cultivation remains limited, your judgment has already proven useful."
                ],

                [
                    "requires" => [
                        "flags" => [
                            "mana_beast_warning" => false
                        ]
                    ],

                    "text" => "As the tension of battle fades, you become increasingly aware of the injuries sustained during the wolf's sudden attack.

                    The encounter serves as a reminder that even seemingly abandoned ruins can conceal dangerous threats.

                    Your senior companions urge you to remain cautious as the expedition continues."
                ]
            ],


            "text" => "The Mana-Corrupted Wolf lies motionless as the dark energy surrounding its body slowly fades.

            Your two Level 4 senior companions approach the fallen creature. One kneels beside it, examining the strange corruption lingering beneath its fur.

            As they investigate, a faint glow emerges from a wound near the creature's chest.

            Hidden within its body is an extraordinarily small crystal, no larger than a grain of sand. Despite its size, the crystal radiates a surprising amount of concentrated mana.

            'Interesting,' one senior remarks. 'The creature must have absorbed this energy from somewhere within the ruins.'

            Your other companion studies the crystal before turning toward you.

            'Its energy is relatively weak, but for a Level 1 cultivator, it may be enough to trigger a breakthrough.'

            The crystal pulses gently, its mana responding to your presence.",


            "backgrounds" => [
                "page" => null,
                "scene" => null
            ],

            "choices" => [
                "absorb_wolf_crystal" => [
                    "text" => "Absorb the Wolf's Mana Crystal",

                    "description" => "Absorb the concentrated mana to strengthen your cultivation and advance to Level 2.",

                    "insight_text" => "The crystal contains enough concentrated mana to trigger your first cultivation breakthrough. Absorbing it will permanently strengthen your body and unlock your faction's first special ability.",

                    "next" => "wolf_breakthrough",

                    "requires" => [
                        "flags" => [
                            "wolf_defeated" => true,
                            "wolf_crystal_absorbed" => false
                        ]
                    ],

                    "effects" => [
                         "special" => [
                            "level_up" => 1
                        ],
                        "flags" => [
                            "wolf_crystal_absorbed" => true
                        ],
                    ],

                    "tracker_title" => "First Cultivation Breakthrough",

                    "tracker_text" => "You absorbed the Mana-Corrupted Wolf's crystal and advanced to Level 2."
                ]

            ]

        ],


        "wolf_breakthrough" => [
            "title" => "Your First Cultivation Breakthrough",
            "act" => 1,

            "text" => "You carefully absorb the tiny mana crystal.

                The concentrated energy enters your body, spreading through your meridians. For a moment, the pressure becomes overwhelming as your cultivation approaches its limit.

                Then, something within you gives way.

                The barrier separating Level 1 from Level 2 shatters, and a new current of mana surges through your body.",

            "faction_text" => [
                "warrior" => "The energy rushes into your muscles and bones, reinforcing your body from within.

                                Your heartbeat grows stronger as your physical endurance increases. You tighten your grip around your weapon, surprised by how effortlessly you can now control its weight.

                                Instinctively, you channel mana through your arms and into your weapon. A powerful force gathers around its edge, revealing a new combat technique that had previously been beyond your abilities.

                                Your strength and durability have increased significantly.

                                You have successfully reached Level 2, awakening your Warrior special ability.",

                "mage" => "The concentrated mana flows toward your spiritual core, gathering into a brilliant sphere of magical energy.

                            Your core expands as the crystal's power merges with your own. The surrounding mana, once difficult to distinguish, now feels remarkably clear.

                            You extend your hand, and magical energy gathers around your fingertips. Without consciously forming a spell, you begin manipulating the mana into a concentrated arcane technique.

                            Your magical capacity has expanded significantly.

                            You have successfully reached Level 2, awakening your Mage special ability.",

                "rogue" => "The crystal's energy spreads through your nerves and muscles, sharpening your senses almost instantly.

                            Your surroundings seem to slow as your perception becomes more precise. Every movement feels lighter, and even the smallest shifts in your balance become effortless to control.

                            You instinctively channel mana through your weapon. For an instant, your movements become nearly impossible to follow as you execute a rapid, precise strike.

                            Your physical control and combat precision have improved significantly.

                            You have successfully reached Level 2, awakening your Rogue special ability: Shadow Strike."
            ],

            "companion_text" => "Your two Level 4 senior companions exchange surprised glances.

                                    'Already a breakthrough?' one remarks. 'That crystal was small, but your body absorbed its energy remarkably well.'

                                    The other senior nods.

                                    'You've reached Level 2, but don't become overconfident. There are far more dangerous creatures deeper within these ruins.'

                                    With your cultivation strengthened, the expedition prepares to continue.",

            "backgrounds" => [
                "page" => null,
                "scene" => null
            ],

            "choices" => [
                "continue_exploration" => [
                    "text" => "Explore Deeper Into the Ruins",

                    "description" => "Continue investigating the ancient ruins alongside your senior companions.",

                    "insight_text" => "Your cultivation has advanced, but the source of the wolf's corruption remains unknown. Continuing deeper may reveal what is affecting these ruins.",

                    "next" => "ruins_deeper_exploration",

                    "requires" => [
                        "stats" => [
                            "level" => 2
                        ]
                    ],

                    "effects" => [],

                    "tracker_title" => "Exploring the Ancient Ruins",

                    "tracker_text" => "After reaching Level 2, you continued the expedition alongside your two Level 4 senior companions."
                ]
            ]
        ],



        "ruins_deeper_exploration" => [
            "title" => "Deeper Into the Ancient Ruins",
            "act" => 1,

            "text" => "With the Mana-Corrupted Wolf defeated, your expedition resumes its journey into the ancient ruins. The forest gradually gives way to a sprawling network of forgotten structures, many of which have been swallowed by centuries of vegetation.

            Broken towers rise above the treetops, while enormous stone pillars lie scattered across the forest floor. Faint traces of mana linger within the crumbling walls, suggesting that this place was once home to cultivators of considerable strength.

            Your two senior companions begin examining the ruins more thoroughly. Although the surrounding structures appear unstable, neither senior seems particularly concerned about the dangers they might conceal.

            One of the seniors suddenly rises into the air, their body surrounded by a faint aura of concentrated mana. Without wings or any visible support, they ascend effortlessly above the surrounding trees, surveying the ruins from a height that would be impossible for an ordinary cultivator to reach.

            The second senior approaches a massive stone structure blocking the expedition's path. With a casual movement of their hand, a tremendous wave of mana erupts forward. The ancient wall shatters under the pressure, sending fragments of stone crashing into the surrounding vegetation.

            You watch in astonishment as an obstacle that might have required hours of effort to overcome is destroyed in an instant.

            Such is the power of a Level 4 cultivator.

            Despite your recent breakthrough to Level 2, the difference between your cultivation and that of your Level 4 companions remains overwhelming.

            The mana flowing through their bodies is far denser and more refined than anything you can currently control. Although the wolf's crystal has strengthened your abilities, even the simplest techniques demonstrated by your seniors reveal how much further you have yet to progress.

            As the expedition continues, the seniors uncover fragments of ancient inscriptions, damaged formations, and remnants of structures that once channeled extraordinary quantities of mana.

            Occasionally, they exchange observations about the ruins' unusual energy. Certain formations appear to have been deliberately damaged, while others show signs of having remained dormant for generations.

            Despite their experience, neither senior can immediately explain the source of the corruption spreading throughout the surrounding region.

            Several hours pass as your group ventures farther into the ruins. The forest grows quieter, and the concentration of mana gradually increases.

            Eventually, your expedition reaches a clearing surrounded by enormous stone columns.

            At its center stands a remarkably intact ancient structure, untouched by much of the destruction that has consumed the surrounding ruins. Intricate symbols cover its walls, and an immense concentration of mana radiates from somewhere deep within.

            Even your senior companions pause at the sight. Whatever lies inside this structure may hold the answers your expedition has been searching for.",

            "backgrounds" => [
                "page" => null,
                "scene" => null
            ],

            
            "choices" => [
                "approach_structure" => [
                    "text" => "Approach the Ancient Structure",

                    "description" => "Move toward the ancient structure and investigate the powerful mana emanating from within.",

                    "insight_text" => "The structure may contain valuable information about the artifact. However, approaching immediately means leaving the surrounding area unexplored.",

                    "next" => "act1_rival_interception",

                    "requires" => [],

                    "effects" => [
                        "flags" => [
                            "approached_rivals_first" => false
                        ]
                    ],

                    "tracker_title" => "Approaching the Ancient Structure",

                    "tracker_text" => "You decided to approach the ancient structure without scouting the surrounding area."
                ],

                "scout_surroundings" => [
                    "text" => "Check the Surrounding Area",

                    "description" => "Search the nearby ruins for signs of other cultivators before approaching the structure.",

                    "insight_text" => "The intelligence reports you investigated earlier mentioned rival cultivators traveling toward this region. Examining the surroundings may help you avoid being caught off guard.",

                    "next" => "rival_scouting",

                    "requires" => [
                        "flags" => [
                            "artifact_rival_warning" => true
                        ]
                    ],

                    "effects" => [],

                    "tracker_title" => "Scouting the Ancient Ruins",

                    "tracker_text" => "Remembering the intelligence reports, you decided to investigate the surrounding area before approaching the ancient structure."
                ]
            ]

        ],


        "act1_rival_interception" => [
            "title" => "An Unexpected Interception",
            "act" => 1,

            "text" => "You lead your expedition toward the ancient structure without first scouting the surrounding ruins. The area seems unusually quiet, and the broken stone pathways offer little cover. Before your group can reach the entrance, movement suddenly erupts from the nearby rubble. A rival expedition has been watching your approach. You have walked directly into their position.",

            "faction_text" => [
                "warrior" => "Rogue cultivators emerge from the shadows surrounding the ruins. Their daggers flash as they rush toward your expedition, striking before your warriors can properly form a defensive line.",

                "mage" => "Warrior cultivators burst from behind the shattered pillars, their swords already drawn. They charge your expedition before your mages can establish their defensive formations.",

                "rogue" => "Mage cultivators reveal themselves among the broken structures. Their eyes gleam as concentrated mana gathers around their hands. Before your rogues can retreat into the shadows, a barrage of spells erupts toward your position."
            ],

            "choices" => [
                "defend_against_rival" => [
                    "text" => "Defend yourself against the rival expedition.",
                    "description" => "The rival expedition has already launched its attack. Defend yourself against the Level 2 rival champion.",

                    "insight_text" => "Your expedition was caught off guard. The rival champion has the advantage of surprise, and avoiding the confrontation is no longer possible. Prepare for a difficult battle.",
                    "next" => "act1_rival_interception",
                    "effects" => [
                        "flags" => [
                            "act1_rival_intercepted" => true,
                            "act1_rival_surprised" => true
                        ]
                    ]
                ]
            ]
        ],


        "ancient_structure_approach" => [
            "title" => "Shadows Among the Ruins",
            "act" => 1,

            "text" => "You and your two senior companions begin approaching the ancient structure.

            As you draw closer, the mana surrounding the ruins grows increasingly intense. Intricate formations carved into the stone walls emit a faint glow, suggesting that some of the structure's ancient mechanisms remain active.

            The entrance stands beyond a series of enormous stone pillars. Although much of the surrounding area has fallen into disrepair, the path leading toward the entrance appears unusually clear.

            Your senior companions slow their pace, carefully examining the powerful energy radiating from within the structure.",

            "conditional_text" => [
                [
                    "requires" => [
                        "flags" => [
                            "artifact_rival_warning" => true
                        ]
                    ],

                    "text" => "As you examine the surrounding ruins, you remember the intelligence reports you investigated before leaving your kingdom.

                    Rival agents had reportedly been sighted traveling toward this region. Given the extraordinary mana surrounding the ancient structure, you suspect that your expedition may not be the first to discover it.

                    Rather than focusing entirely on the entrance, you carefully survey the surrounding pillars and damaged structures.

                    Your caution proves worthwhile.

                    Beyond a partially collapsed wall, you notice several figures moving through the ruins. Their movements are deliberate, and the mana surrounding them is unmistakably that of trained cultivators.

                    You quickly alert your senior companions.

                    From your concealed position, you identify a rival expedition consisting of three cultivators. Two possess mana signatures comparable to those of your Level 4 companions, while the third appears to be a younger champion.

                    The rival expedition has not yet noticed your presence.

                    You have an opportunity to approach them on your own terms."
                ],

                [
                    "requires" => [
                        "flags" => [
                            "artifact_rival_warning" => false
                        ]
                    ],

                    "text" => "Your attention remains fixed on the extraordinary mana emanating from the ancient structure.

                    Unaware that other expeditions may be searching the region, you fail to notice the movement taking place among the surrounding ruins.

                    Before your group can reach the entrance, a powerful voice suddenly echoes from behind a nearby stone pillar.

                    'Hold your position.'

                    Three figures emerge from the ruins, blocking your expedition's approach.

                    Two of them radiate the unmistakable pressure of Level 4 cultivators. Between them stands a younger champion whose attention immediately settles upon you.

                    Your senior companions step forward, their expressions growing serious.

                    The rival expedition has discovered you first."
                ]
            ],

            "backgrounds" => [
                "page" => null,
                "scene" => null
            ],

            "choices" => [
                "approach_rivals" => [
                    "text" => "Approach the Rival Expedition",

                    "description" => "Reveal your presence and initiate contact with the rival cultivators.",

                    "insight_text" => "Your earlier investigation allowed you to discover the rival expedition before they noticed you. Approaching voluntarily may help establish a more favorable first impression.",

                    "next" => "first_rival_encounter",

                    "requires" => [
                        "flags" => [
                            "artifact_rival_warning" => true
                        ]
                    ],

                    "effects" => [
                        "flags" => [
                            "approached_rivals_first" => true
                        ]
                    ],

                    "tracker_title" => "Discovering the Rival Expedition",

                    "tracker_text" => "You identified the rival expedition before they discovered your presence and chose to approach them."
                ]
            ]
        ],


        "rival_scouting" => [
            "title" => "An Unexpected Discovery",
            "act" => 1,

            
            "text" => "Remembering the intelligence reports you investigated before leaving your kingdom, you decide to scout the surrounding ruins before approaching the ancient structure.

                Your two senior companions agree, and together you move carefully between the enormous stone pillars.

                Before long, you notice movement beyond a partially collapsed wall. You signal your companions to stop, observing the figures from a concealed position.

                Fortunately, the strangers have not noticed your presence.",

            "faction_text" => [
                "warrior" => "You recognize the dark equipment and concealed weapons of the Rogue Kingdom.

                The expedition consists of two Level 4 senior cultivators and a Level 2 champion carrying a dagger. The younger cultivator moves with remarkable precision.",

                "mage" => "You recognize the armor and military insignia of the Warrior Kingdom.

                The expedition consists of two Level 4 senior cultivators and a Level 2 champion carrying a sword. The younger cultivator moves with the discipline of a trained soldier.",

                "rogue" => "You recognize the distinctive robes and arcane equipment of the Mage Kingdom.

                The expedition consists of two Level 4 senior cultivators and a Level 2 champion carrying a staff. Faint magical energy gathers around the younger cultivator's hands."
            ],

            "companion_text" => "One of your seniors studies the rival expedition before turning toward you.

                'Their seniors are as strong as we are. However, their champion is at your level.'

                Your other companion nods.

                'This expedition is also a test of your judgment. How we approach them is up to you.'

                'The decision is yours. If things get out of hand, we'll intervene.'

                Both seniors wait for your response.",


           
                "backgrounds" => [
                "page" => null,
                "scene" => null
            ],

            "choices" => [
                "approach_rivals" => [
                    "text" => "Approach the Rival Expedition",

                    "description" => "Reveal your presence and initiate contact with the rival cultivators.",

                    "insight_text" => "Your earlier investigation allowed you to discover the rival expedition first. Approaching them voluntarily may create a more favorable first impression, although their intentions remain unknown.",

                    "next" => "first_rival_encounter",

                    "requires" => [],

                    "effects" => [
                        "flags" => [
                            "approached_rivals_first" => true
                        ]
                    ],

                    "tracker_title" => "Approaching the Rival Expedition",

                    "tracker_text" => "After discovering the rival expedition before being noticed, you chose to reveal your presence and initiate contact."
                ],
                
                "surprise_attack_rival" => [
                    "text" => "Launch a Surprise Attack",

                    "description" => "Attack the unsuspecting rival champion before their expedition can react.",

                    "insight_text" => "The rival expedition is unaware of your presence. A surprise attack may give you an advantage in combat, but attacking without warning could severely damage relations between your kingdoms.",

                    "next" => "rival_ambush",

                    "requires" => [],

                    "effects" => [
                        "flags" => [
                            "rival_surprise_attack" => true,
                            "approached_rivals_first" => false
                        ],
                        "trust" => [
                            "first_rival" => -20
                        ]
                    ],

                    "tracker_title" => "Ambushing the Rival Champion",

                    "tracker_text" => "You launched a surprise attack against the unsuspecting rival champion, damaging relations with their kingdom."
                ],

            ]
        ],


        "rival_ambush" => [
            "title" => "A Sudden Ambush",
            "act" => 1,

            "text" => "You signal your companions and launch your attack before the rival expedition can react.

                Your two Level 4 seniors immediately intercept the opposing seniors, forcing them into a confrontation of their own.",

            "faction_text" => [
                "warrior" => "With the stronger cultivators occupied, you rush toward the unsuspecting rival Rogue champion and land a clean strike.

                The Rogue champion staggers backward, wounded by the unexpected attack.

                'The warrior kingdom, you really picked your moment.' injured but not too surprised by your presence, they draw their weapon.

                The element of surprise has given you an advantage, but your opponent is far from defeated.
                
                The Rogue champion tightens their grip on their dagger, shifting into a guarded stance as they prepare to retaliate.",

               
                "mage" => "With the stronger cultivators occupied, fire a MANA BOLT toward the unsuspecting rival Warrior champion and land a clean strike.

                The Rogue champion staggers backward, wounded by the unexpected attack.

                'Ofcourse its you filthy book worms!!' they roar, drawing their weapon.

                The element of surprise has given you an advantage, but your opponent is far from defeated.
                
                The Warrior champion steadies their sword, their expression hardening as they prepare to retaliate.",

                
                "rogue" => "With the stronger cultivators occupied, you rush toward the unsuspecting rival Warrior champion and land a clean strike from the shadows.

                The Rogue champion staggers backward, wounded by the unexpected attack.

                'Rogues?! I should've known you'd be here!' they exclaim, drawing their weapon.

                The element of surprise has given you an advantage, but your opponent is far from defeated.
                
                The Mage champion raises their staff, gathering arcane energy as they prepare to retaliate.",
            ],

            "backgrounds" => [
                "page" => null,
                "scene" => null
            ],

            "choices" => [
                "fight_rival" => [
                    "text" => "Confront the Rival Champion",

                    "description" => "Prepare to battle the wounded rival champion.",

                    "insight_text" => "Your surprise attack has weakened the rival champion, but they remain dangerous. Both of you have reached Level 2, and your opponent may possess techniques you have not encountered before.",

                    "next" => "rival_ambush",

                    "requires" => [
                        "flags" => [
                            "rival_surprise_attack" => true,
                            "rival_defeated" => false
                        ]
                    ],

                    "effects" => [],

                    "tracker_title" => "Battling the Rival Champion",

                    "tracker_text" => "After landing a successful ambush, you prepared to fight the wounded Level 2 rival champion."
                ]
            ]
        ],


        "rival_retreat" => [
            "act" => 1,
            "title" => "Victory — The Rival Retreats",

            
            "text" => "The battle reaches its conclusion. With the opposing champion defeated, the balance of the confrontation shifts decisively in your favor.

                For a brief moment, the battlefield falls into uneasy silence as both expeditions recognize the outcome.",


            "faction_text" => [
                "warrior" => "The Rogue Champion drops to one knee, their movements noticeably slower than before.

                    'You caught me off guard,' they mutter, gripping their wounded side. 'Don't expect that to happen again.'

                    Their senior companion helps them retreat into the shadows.

                    Your Warrior seniors approach, acknowledging your victory. The Rogue Champion has survived, but their injuries will prevent them from showing up again anytime soon.",

                "mage" => "The Warrior Champion struggles to lift their weapon, their armor cracked from your final attack.

                    'This isn't finished,' they declare, even as their senior companion orders them to withdraw.

                    The Warrior reluctantly lowers their weapon and retreats.

                    Your Mage seniors regroup around you. The opposing champion has been defeated and seriously injured, but their companions have ensured their survival.",

                "rogue" => "The Mage Champion's magical barrier shatters under your final strike. They stumble backward, their remaining mana flickering uncontrollably.

                        'Impossible...' they whisper, staring at you.

                        Before they can recover, their senior companion raises a protective barrier and escorts them away.

                        Your Rogue seniors emerge from the battlefield. The Mage Champion has survived, but their injuries will keep them away from future expeditions for some time."
            ],

            "companion_text" => "With the opposing expedition gone, your senior companions turn their attention toward the ancient ruins.

                The immediate threat has passed, but the unstable mana surrounding the area suggests that something valuable may still be hidden nearby.",

            "choices" => [
                "investigate_ruins" => [
                    "text" => "Investigate the Ancient Ruins",
                    "description" => "Explore the ruins with your companions and search for the source of the unusual mana.",

                    "insight_text" => "With the rival expedition forced to retreat, you can investigate the ruins without interference. The unusually concentrated mana suggests that something valuable may lie deeper within.",
                    "next" => "rival_victory_ruins",

                    "tracker_title" => "Victory Over the Rival",
                    "tracker_text" => "Defeated the rival champion and continued exploring the ancient ruins.",

                    "requires" => [
                        "flags" => [
                            "act1_rival_defeated" => true
                        ]
                    ],

                    "effects" => []
                ]
            ]
        ],



        "rival_victory_ruins" => [
            "act" => 1,
            "title" => "The Ancient Ruins",

        
            "text" => "With the opposing expedition gone, your group finally has an opportunity to investigate the ruins without interference.

                The deeper you travel, the stronger the surrounding mana becomes. Ancient stone pillars line the passage, their surfaces covered in markings that have survived for centuries.

                The remains of collapsed buildings and weathered statues suggest that this place once served as a gathering ground for an ancient organization of powerful cultivators. Whatever became of them, their presence has long since faded into history.

                Eventually, the passage opens into a large underground chamber. At its center lies an 50 meter stone basin filled with shimmering liquid. The surrounding mana is so concentrated that even breathing feels different.",


            "faction_text" => [
                "warrior" => "Your Warrior companions examine the chamber cautiously.

                    One of the senior cultivators kneels beside the basin, studying the shimmering liquid.

                    'An entire pool of liquid mana...' they say, their usually steady voice betraying disbelief. 'When ambient mana becomes dense enough, it can condense into a liquid state. It's extraordinarily pure.'

                    They examine the ancient surroundings before continuing.

                    'Places like this once housed cultivators far beyond our current strength. Their presence may have left the surrounding mana unusually concentrated.'

                    Another senior cultivator looks toward the basin.

                    'These fluctuations... they're remarkably similar to the ones our kingdom detected from the mysterious artifact. I doubt that's a coincidence.'",

                "mage" => "Your Mage companions immediately begin examining the unusual energy surrounding the basin.

                        One of the senior cultivators studies the liquid with growing disbelief.

                        'An entire pool... This is liquid mana. Ambient mana compressed to such an extraordinary density that it has taken physical form. The purity is remarkable.'

                        They glance toward the ancient pillars surrounding the chamber.

                        'An organization of powerful cultivators may have gathered here centuries ago. Their prolonged cultivation could explain why the ambient mana remains so concentrated.'

                        Another Mage senior closes their eyes, sensing the energy.

                        'Interesting... the mana fluctuations here closely resemble the readings associated with the artifact. Whatever is happening to the world's mana, these two phenomena may be connected.'",

                "rogue" => "Your Rogue companions spread out, checking the chamber for hidden mechanisms and possible traps.

                        One of the senior cultivators approaches the basin and freezes.

                        'You've got to be kidding me... An entire pool?'

                        They gesture toward the shimmering liquid.

                        'Liquid mana. Ordinary mana is all around us, but when enough of it gathers in one place, it can become dense enough to liquefy. And this stuff is almost perfectly pure.'

                        They glance around at the ruined structures.

                        'An ancient organization probably used this place. Judging by what's left, its members weren't ordinary cultivators.'

                        Another Rogue senior studies the surrounding energy.

                        'You know what's strange? These fluctuations feel almost identical to what our kingdom detected from that artifact. Something tells me we didn't stumble across this place by accident.'"
            ],

            "companion_text" => "One of your senior companions explains that liquid mana is exceptionally rare. Even a small quantity could take centuries to accumulate naturally.

                    The Three Kingdoms have maintained much of their cultivation superiority through access to extraordinary resources like this. Their most advanced facilities can even condense ambient mana into small quantities of liquid mana over several decades, although the process requires enormous resources.

                    Your companions exchange glances before turning toward you.

                    'You should take a handful. It may seem small but for you, it could make an enormous difference.'

                    They step away from the basin.

                    'Go ahead. Absorb it carefully. This may be an opportunity you won't encounter again for a very long time.'",

            "choices" => [
                "absorb_ancient_mana" => [
                    "text" => "Absorb the Liquid Mana",
                    "description" => "Carefully absorb the exceptionally pure liquid mana to strengthen your cultivation.",

                    "insight_text" => "Even a small portion of this exceptionally pure liquid mana could trigger a cultivation breakthrough.",

                    "next" => "act1_cultivation_breakthrough",

                    "tracker_title" => "Liquid Mana Discovered",
                    "tracker_text" => "Discovered a rare pool of liquid mana within the ancient ruins and began a cultivation breakthrough.",

                    "requires" => [
                        
                    ],

                    "effects" => [
                        "flags" => [
                            "ancient_mana_absorbed" => true
                        ],
                        "special" => [
                            "level_up" => 1
                        ],
                    ]
                ],


                "ask_about_fluctuations" => [
                    "text" => "Fluctuations?",
                    "description" => "Ask your senior companions why the mana fluctuations in these ruins seem familiar.",

                    "insight_text" => "Your companions have noticed similarities between the mana fluctuations here and those associated with the mysterious artifact. Asking about them may reveal why your kingdom sent this expedition.",

                    "next" => "minor_fluctuation_explanation",

                    "tracker_title" => "Questions About the Artifact",
                    "tracker_text" => "Asked the senior cultivators about the strange mana fluctuations.",

                    "effects" => []
                ]

            ]
        ],


        "minor_fluctuation_explanation" => [
            "act" => 1,
            "title" => "The Mysterious Fluctuations",

            "text" => "You turn toward your senior companions, remembering their earlier remarks about the unusual mana surrounding the ruins.

                'Fluctuations?' you ask.

                One of the seniors nods, realizing that you haven't been told the full reason behind the expedition.",

            "faction_text" => [
                "warrior" => "A Warrior senior folds their arms before explaining.

                    'As we mentioned before setting out, all Three Kingdoms detected an extraordinary disturbance in the world's mana. The fluctuations were unlike anything our observers had recorded.'

                    'Our kingdom suspects that some ancient artifact, perhaps a relic of a forgotten civilization, is gradually being uncovered.'

                    They gesture toward the ruins.

                    'We detected a much weaker fluctuation coming from this region. Its pattern resembled the greater disturbance, so we were ordered to investigate.'

                    They glance back toward the pool.

                    'And now we've discovered an entire reservoir of liquid mana. Whatever caused those fluctuations, this expedition has already proven worthwhile.'",

                "mage" => "One of the Mage seniors begins explaining, clearly pleased to have an opportunity to discuss the phenomenon.

                    'The Three Kingdoms have all detected a massive, unusual fluctuation in ambient mana. Our scholars believe an ancient artifact may be responsible, although its location and nature remain unknown.'

                    'The energy signature coming from this region was considerably weaker, but its characteristics were remarkably similar.'

                    They gesture toward the liquid mana.

                    'That similarity is precisely why we were sent here. We hoped to find evidence connected to the greater disturbance.'

                    Their expression brightens.

                    'Instead, we've found an entire natural reservoir of liquid mana. Even if we learn nothing more about the artifact, this discovery alone could justify the expedition many times over.'",

                "rogue" => "A Rogue senior gives you an amused look.

                        'You really weren't paying attention before we left, were you?'

                        They lean against a nearby pillar.

                        'All Three Kingdoms picked up a massive disturbance in the world's mana. Nobody knows exactly what's causing it, but the leading theory is that some ancient artifact is resurfacing.'

                        'Our scouts detected a smaller fluctuation coming from this area. Much weaker, sure, but similar enough that the kingdom decided it was worth investigating.'

                        They glance toward the pool with a grin.

                        'And would you look at that? An entire pool of liquid mana. Even if this place has nothing to do with the artifact, we've just brought home a fortune.'"
            ],

            "companion_text" => "Your companions explain that the source of the greater disturbance remains unidentified. The Three Kingdoms continue searching for answers, and expeditions like this one are part of that effort.

                now, however, the extraordinary discovery within these ruins demands their immediate attention.",

            "choices" => [
                "return_to_ruins" => [
                    "text" => "Go Back",
                    "description" => "Return your attention to the liquid mana and the expedition.",

                    "insight_text" => "You've learned why the Three Kingdoms are investigating unusual mana disturbances.",
                    
                    "next" => "rival_victory_ruins",

                    "tracker_title" => "Ancient Ruins",
                    "tracker_text" => "You've learnt about the mysterious fluctuations.",

                    "effects" => []
                ]
            ]
        ],


        "act1_cultivation_breakthrough" => [
            "title" => "A Second Cultivation Breakthrough",
            "act" => 1,

            "text" => "You kneel beside the ancient basin and carefully draw a small portion of liquid mana into your body.

                The extraordinary purity of the energy immediately surpasses anything you have experienced before.

                As the mana circulates through your meridians, the barrier restricting your cultivation begins to weaken.

                With one final surge of energy, the barrier shatters.

                You have successfully advanced to Level 3.",

            "faction_text" => [
                "warrior" => "The concentrated mana reinforces your muscles, bones, and meridians. Your physical strength rises dramatically, and your body becomes capable of withstanding far greater punishment.

                    Your control over weapon techniques improves as your Warrior cultivation reaches Level 3.",

                "mage" => "The liquid mana flows into your spiritual core, expanding its capacity and refining the energy within.

                    Your ability to manipulate ambient mana becomes considerably more precise. Spells that once required intense concentration now feel increasingly natural as your Mage cultivation reaches Level 3.",

                "rogue" => "The concentrated mana spreads through your nerves and meridians, sharpening your perception and strengthening your physical control.

                    Your movements become faster and more precise. Even the slightest disturbances in the surrounding mana become easier to detect as your Rogue cultivation reaches Level 3."
            ],

            "backgrounds" => [
                "page" => null,
                "scene" => null
            ],

            "choices" => [
                "speak_to_companions" => [
                    "text" => "Speak to Your Companions",
                    "description" => "Turn toward your senior companions after successfully reaching Level 3.",

                    "insight_text" => "Your breakthrough has attracted the attention of your senior companions. Speaking with them may reveal their thoughts on your rapid advancement.",

                    "next" => "act1_companion_congratulations",

                    "requires" => [
                        "stats" => [
                            "level" => 3
                        ]
                    ],

                    "effects" => [],

                    "tracker_title" => "Reaching Level 3",
                    "tracker_text" => "You absorbed the ancient liquid mana, achieved your second cultivation breakthrough, and advanced to Level 3."
                ]
            ]
        ],

        "act1_companion_congratulations" => [
            "title" => "Recognition of a Champion",
            "act" => 1,

            "text" => "You rise from beside the ancient basin, the newly refined mana flowing steadily through your body.

                Your two senior companions approach, having witnessed your remarkable breakthrough.

                One of them studies you for a moment before breaking into a proud smile.

                'Level 3 already, and at such a young age. Remarkable. You truly deserve to be called our kingdom's champion.'

                The other senior nods approvingly.

                'The times are changing. To think that someone of your generation could advance so quickly. Perhaps the future of our kingdom is brighter than we imagined.'

                They exchange a glance before turning their attention toward the ancient chamber.

                'You've done well. Congratulations on your breakthrough.'

                After gathering their findings and securing the expedition's discoveries, your companions prepare to leave.

                'Our investigation here is complete. We should return to the kingdom and report what we've discovered.'

                With your cultivation strengthened and the expedition concluded, the journey home awaits.",

            "backgrounds" => [
                "page" => null,
                "scene" => null
            ],

            "choices" => [
                "return_to_kingdom" => [
                    "text" => "Return to Your Kingdom",

                    "description" => "Accompany your senior companions home and report the expedition's discoveries.",

                    "insight_text" => "Your expedition has uncovered an extraordinary reservoir of liquid mana. Returning home will allow your kingdom's leaders to evaluate the discovery and prepare for what lies ahead.",

                    "next" => "act1_kingdom_return",

                    "requires" => [
                        "stats" => [
                            "level" => 3
                        ]
                    ],

                    "effects" => [
                        "flags" => [
                            "act1_expedition_completed" => true,
                            "act1_returned_home" => true
                        ]
                    ],

                    "tracker_title" => "Returning Home",

                    "tracker_text" => "After reaching Level 3, you received congratulations from your senior companions and began the journey back to your kingdom."
                ]
            ]
        ],

        "act1_kingdom_return" => [
            "title" => "Return to the Kingdom",
            "act" => 1,

            "text" => "After several days of travel, you and your senior companions finally return to your home kingdom.

                News of your successful expedition has already reached the kingdom's leadership. You are summoned to report your discoveries and the events that unfolded within the ancient ruins.",

            "faction_text" => [
                "warrior" => "You enter the Warrior Kingdom's fortified capital, where towering stone walls and disciplined soldiers reflect generations of military tradition.

                    Within the kingdom's grand command hall, several high-ranking commanders await your arrival.

                    Your senior companions report the discovery of the ancient liquid mana reservoir and your victory over the rival champion.

                    One commander studies you with approval.

                    'You departed as a promising young cultivator and returned having reached Level 3. Your progress brings honor to the Warrior Kingdom.'

                    The commanders acknowledge your achievements before dismissing you to recover from the expedition.",

                "mage" => "You return to the Mage Kingdom's magnificent capital, where towering academies and enchanted structures stand as monuments to generations of magical research.

                    Within the Grand Arcane Council's chambers, senior scholars gather to hear your expedition's findings.

                    Your companions describe the ancient ruins, the extraordinary liquid mana reservoir, and your victory over the rival champion.

                    One of the council's senior mages regards you with considerable interest.

                    'To reach Level 3 during a single expedition is an extraordinary achievement. Your talent may one day surpass even our greatest scholars.'

                    The council acknowledges your progress and grants you time to recover from your journey.",

                "rogue" => "You return to the Rogue Kingdom's concealed capital, where hidden passageways and guarded strongholds protect the kingdom's most valuable secrets.

                    Within the headquarters of the kingdom's intelligence leadership, several senior operatives await your report.

                    Your companions describe the discovery of the ancient liquid mana reservoir and your victory over the rival champion.

                    One of the senior operatives gives a satisfied nod.

                    'Level 3 already? Impressive. Your enemies will soon learn that the Rogue Kingdom's next generation is not to be underestimated.'

                    With your achievements acknowledged, you are dismissed to recover and prepare for future assignments."
            ],

            "backgrounds" => [
                "page" => null,
                "scene" => null
            ],

            "choices" => [
                "learn_warrior_history" => [
                    "text" => "Learn About the Warrior Kingdom",

                    "description" => "Explore the history, traditions, and military philosophy of the Warrior Kingdom.",

                    "insight_text" => "Understanding the Warrior Kingdom's traditions may provide valuable insight into its military strength and political ambitions.",

                    "next" => "warrior_kingdom_lore",

                    "requires" => [
                        "flags" => [
                            "learned_warrior_history" => false
                        ]
                    ],

                    "effects" => [],

                    "tracker_title" => "Studying the Warrior Kingdom",

                    "tracker_text" => "You chose to learn about the history and traditions of the Warrior Kingdom."
                ],

                "learn_mage_history" => [
                    "text" => "Learn About the Mage Kingdom",

                    "description" => "Study the Mage Kingdom's history, magical traditions, and cultivation practices.",

                    "insight_text" => "The Mage Kingdom's understanding of mana may offer clues about the mysterious artifact and the unusual disturbances spreading across the world.",

                    "next" => "mage_kingdom_lore",

                    "requires" => [
                        "flags" => [
                            "learned_mage_history" => false
                        ]
                    ],

                    "effects" => [],

                    "tracker_title" => "Studying the Mage Kingdom",

                    "tracker_text" => "You chose to learn about the history and magical traditions of the Mage Kingdom."
                ],

                "learn_rogue_history" => [
                    "text" => "Learn About the Rogue Kingdom",

                    "description" => "Discover the Rogue Kingdom's history, intelligence networks, and covert traditions.",

                    "insight_text" => "Learning about the Rogue Kingdom may help you understand its methods of gathering intelligence and protecting its interests.",

                    "next" => "rogue_kingdom_lore",

                    "requires" => [
                        "flags" => [
                            "learned_rogue_history" => false
                        ]
                    ],

                    "effects" => [],

                    "tracker_title" => "Studying the Rogue Kingdom",

                    "tracker_text" => "You chose to learn about the history and covert traditions of the Rogue Kingdom."
                ],

                "continue_after_return" => [
                    "text" => "Continue Your Journey",

                    "description" => "Leave the kingdom's leadership chambers and spend some time recovering from the expedition.",

                    "insight_text" => "Your expedition has concluded successfully. Continuing will allow you to recover, train, and prepare for whatever challenges await.",

                    "next" => "act1_recovery_training",

                    "requires" => [],

                    "effects" => [
                        "flags" => [
                            "act1_kingdom_report_completed" => true
                        ]
                    ],

                    "tracker_title" => "A New Chapter",

                    "tracker_text" => "After reporting your expedition's discoveries to your kingdom's leadership, you prepared for the next stage of your journey."
                ]
            ]
        ],


        "act1_recovery_training" => [
            "title" => "A Period of Recovery",
            "act" => 1,

            "text" => "Several weeks pass following your return from the ancient ruins.

                With your expedition successfully completed, you spend your time recovering from the battles and refining the cultivation strength you gained during your journey.

                Having reached Level 3, you discover that your control over mana has improved considerably. Techniques that once demanded intense concentration now feel increasingly natural.

                During your recovery, you are granted access to your kingdom's training facilities, where cultivators regularly practice their techniques and test their combat abilities.

                Among the equipment available is a reinforced training dummy designed to withstand attacks from cultivators.

                You may use it to practice your abilities as often as you wish.

                However, your peaceful recovery is interrupted by troubling reports.

                Rumors have begun spreading about an extraordinary mana disturbance near the Mage Kingdom. Some reports describe unstable mana surges, while others suggest that entire regions have begun experiencing dangerous fluctuations.

                Although the details remain uncertain, the scale of the disturbance has attracted the attention of all three kingdoms.

                Your kingdom's leadership is expected to announce a new expedition soon.",

            "faction_text" => [
                "warrior" => "Within the Warrior Kingdom's training grounds, soldiers and cultivators exchange increasingly troubling reports.

                    Senior commanders have begun discussing an unprecedented mana disaster near the Mage Kingdom's borders. Several military units have been placed on alert as preparations for a possible expedition begin.",

                "mage" => "Within the Mage Kingdom's academies, scholars are struggling to understand the increasingly unstable mana readings.

                    Senior mages report that a potentially catastrophic disturbance has emerged near the kingdom's borders. Research teams are urgently attempting to determine its cause.",

                "rogue" => "Within the Rogue Kingdom's intelligence headquarters, reports from covert operatives reveal disturbing developments.

                    Senior agents have detected extraordinary mana fluctuations near the Mage Kingdom. Intelligence networks are being mobilized as the kingdom prepares to investigate the growing threat."
            ],

            "backgrounds" => [
                "page" => null,
                "scene" => null
            ],

            "choices" => [
                "practice_training_dummy" => [
                    "text" => "Practice Against the Training Dummy",

                    "description" => "Enter the training grounds and test your combat abilities against a harmless training dummy.",

                    "insight_text" => "The training dummy cannot attack or injure you. Practicing against it allows you to experiment with your combat techniques without risking defeat.",

                    "next" => "act1_training_dummy",

                    "requires" => [],

                    "effects" => [],

                    "tracker_title" => "Combat Training",

                    "tracker_text" => "You entered the training grounds to practice your combat techniques against a reinforced training dummy."
                ],

                "investigate_mana_disaster" => [
                    "text" => "Mana Disaster?",

                    "description" => "Learn more about the extraordinary mana disturbance reported near the Mage Kingdom.",

                    "insight_text" => "The reports describe mana fluctuations far beyond those encountered during your previous expedition. Investigating the situation may reveal a threat affecting all three kingdoms.",

                    "next" => "act1_mana_disaster_briefing",

                    "requires" => [],

                    "effects" => [],

                    "tracker_title" => "Reports of a Mana Disaster",

                    "tracker_text" => "After recovering from the ancient ruins expedition, you sought information about an unprecedented mana disaster near the Mage Kingdom."
                ]
            ]
        ],


        "first_rival_encounter" => [
            "title" => "A Tense Confrontation",
            "act" => 1,

            "text" => "Having spotted the rival expedition first, you and your two senior companions emerge from behind the ancient stone pillars.

                The rival cultivators immediately notice your presence. Their two senior members step forward, positioning themselves protectively around their younger champion.

                Neither expedition makes another move. The air grows tense as both groups assess one another.",

            "faction_text" => [
                "warrior" => "The Rogue champion immediately lowers their stance, slipping partially into the shadows. Two daggers appear in their hands.

                    'Warriors? Here?' they mutter suspiciously.

                    Their companions remain alert, watching for the slightest indication of an attack.",

                "mage" => "The Warrior champion draws their sword, their shoulders tightening as they recognize your expedition.

                    'Mages. I should have known,' they say, keeping their weapon raised.

                    Their senior companions remain still, but their expressions make it clear they are prepared to fight.",

                "rogue" => "The Mage champion's eyes gleam as they recognize your expedition. The mana gathering around their hands suddenly becomes unnaturally still.

                    'Rogues...' they whisper, watching your every movement.

                    Their companions shift into defensive positions, prepared to unleash their techniques at the first sign of hostility."
            ],

            "companion_text" => "One of your senior companions leans toward you.

                'They haven't attacked. We may still be able to settle this peacefully.'

                The opposing expedition waits for your response.",

            "backgrounds" => [
                "page" => null,
                "scene" => null
            ],

            "choices" => [
                "attack_rival" => [
                    "text" => "Attack the Rival Expedition",

                    "description" => "Abandon diplomacy and confront the rival champion in battle.",

                    "insight_text" => "Both expeditions are aware of one another. Attacking now will begin an open confrontation rather than a surprise attack.",

                    "next" => "first_rival_encounter",

                    "requires" => [],

                    "effects" => [
                        "trust" => [
                            "first_rival" => -20
                        ],
                        "flags" => [
                            "rival_surprise_attack" => false
                        ]
                    ],

                    "tracker_title" => "Confronting the Rival Champion",

                    "tracker_text" => "You abandoned negotiations and challenged the rival champion to battle."
                ],

                "ask_to_negotiate" => [
                    "text" => "Ask to Negotiate",

                    "description" => "Attempt to resolve the confrontation peacefully.",

                    "insight_text" => "The rival expedition is tense but has not attacked. Negotiation may offer a way to investigate the ruins without unnecessary bloodshed.",

                    "next" => "act1_rival_negotiation",

                    "requires" => [],

                    "effects" => [
                        "trust" => [
                            "first_rival" => 0
                        ],
                        "flags" => [
                            "act1_rival_negotiation_attempted" => true
                        ]
                    ],

                    "tracker_title" => "Opening Negotiations",

                    "tracker_text" => "You chose to negotiate with the rival expedition instead of attacking."
                ]
            ]
        ],

        "act1_rival_negotiation" => [
            "title" => "An Offer of Cooperation",
            "act" => 1,

            "text" => "You raise a hand, signaling that you have no intention of attacking.

                'We were sent here to investigate the unusual mana fluctuations surrounding these ruins. I assume your kingdom detected them as well.'

                You glance toward the ancient structure.

                'Whatever lies inside may be more dangerous than either of our expeditions anticipated. Fighting each other would only weaken us before we even begin our investigation.'

                The rival champion remains silent, listening to your proposal.",

            "faction_text" => [
                "warrior" => "The Rogue champion keeps their daggers drawn, although their stance relaxes slightly.

                    'And why should we trust a Warrior champion? What's stopping your kingdom from claiming everything for itself?'",

                "mage" => "The Warrior champion narrows their eyes, their sword still held firmly at their side.

                    'You expect us to believe the Mage Kingdom suddenly wants to share its discoveries? Give me one good reason.'",

                "rogue" => "The Mage champion studies you carefully, the mana surrounding their hands gradually settling.

                    'An interesting proposition coming from a Rogue. But what exactly are you suggesting?'"
            ],

            "companion_text" => "Your senior companions exchange cautious glances. Neither interrupts, allowing you to continue speaking.",

            "backgrounds" => [
                "page" => null,
                "scene" => null
            ],

            "choices" => [
                "propose_cooperation" => [
                    "text" => "Propose Sharing Resources and Information",

                    "description" => "Offer to cooperate during the investigation and share any discoveries made within the ruins.",

                    "insight_text" => "Offering mutual cooperation may establish trust with the rival champion. Both expeditions could benefit from sharing information instead of risking unnecessary casualties.",

                    "next" => "act1_rival_cooperation",

                    "requires" => [],

                    "effects" => [
                        "trust" => [
                            "first_rival" => 20
                        ],

                        "flags" => [
                            "act1_rival_cooperated" => true,
                            "act1_rival_defeated" => false
                        ]
                    ],

                    "tracker_title" => "A Proposal for Cooperation",

                    "tracker_text" => "You offered to share resources and information with the rival expedition."
                ]
            ]
        ],

        "act1_rival_cooperation" => [
            "title" => "An Unexpected Agreement",
            "act" => 1,

            "text" => "For a moment, silence falls between the two expeditions. The rival champion considers your proposal while their senior companions exchange uncertain glances.",

            "faction_text" => [
                "warrior" => "The Rogue champion slowly lowers their daggers.

                    'I still don't trust your kingdom,' they admit. 'But you're right. There's no point wasting our strength fighting each other.'

                    They glance toward the ancient structure.

                    'We'll investigate another entrance. If we discover anything important, we'll share what we find. I expect you to do the same.'",

                "mage" => "The Warrior champion studies you for several moments before finally sheathing their sword.

                    'I never expected to agree with a Mage,' they admit. 'But fighting here would be foolish.'

                    They turn toward their companions.

                    'We'll take another route through the ruins. If we uncover anything useful, you'll hear about it. See that you honor your end of the agreement.'",

                "rogue" => "The Mage champion allows the mana surrounding their hands to dissipate.

                    'A surprisingly reasonable proposal,' they remark. 'Perhaps cooperation will prove more productive than another pointless conflict.'

                    They gesture toward a distant passage.

                    'Our expedition will investigate that entrance. We'll exchange our findings once we've completed our search.'"
            ],

            "companion_text" => "The rival expedition gradually withdraws, disappearing among the ruined pathways.

                One of your senior companions watches them leave before turning toward you.

                'I genuinely didn't expect that to work.'

                Your other companion lets out a quiet laugh.

                'Neither did I. But we've avoided a battle, and we still have a mission to complete.'

                With the confrontation resolved, your expedition turns its attention back toward the ancient structure.",

            "choices" => [
                "investigate_ruins_after_cooperation" => [
                    "text" => "Investigate the Ancient Ruins",

                    "description" => "Continue your expedition into the ancient structure now that the rival confrontation has been resolved peacefully.",

                    "insight_text" => "Your agreement has allowed both expeditions to investigate without fighting. The rival group will explore another entrance while you continue toward the source of the mana fluctuations.",

                    "next" => "rival_victory_ruins",

                    "requires" => [],

                    "effects" => [
                        "trust" => [
                            "first_rival" => 0
                        ],
                        "flags" => [
                            "act1_rival_cooperated" => true,
                            "act1_rival_defeated" => false
                        ]
                    ],

                    "tracker_title" => "A Peaceful Resolution",

                    "tracker_text" => "You reached an agreement with the rival expedition and continued investigating the ruins without a battle."
                ]
            ]
        ],

        "act1_training_dummy" => [
            "title" => "The Training Grounds",
            "act" => 1,

            "text" => "You make your way toward the kingdom's training grounds, where cultivators practice their techniques and refine their combat abilities.

                Near the center of the training area stands a reinforced training dummy, constructed from durable materials and strengthened with protective mana formations.

                Unlike a living opponent, the dummy cannot retaliate. Its purpose is simply to withstand attacks while allowing cultivators to evaluate their strength, accuracy, and control.

                With your recent advancement to Level 3, this is an excellent opportunity to test how much your abilities have improved.

                You approach the dummy and prepare to begin.",

            "faction_text" => [
                "warrior" => "You tighten your grip on your weapon, preparing to test the physical strength and refined combat techniques gained from your recent breakthrough.",

                "mage" => "You gather mana within your spiritual core, preparing to measure the power and precision of your newly strengthened spells.",

                "rogue" => "You study the dummy's structure, identifying potential weak points before preparing to test your improved speed and precision."
            ],

            "backgrounds" => [
                "page" => null,
                "scene" => null
            ],

            "choices" => [
                "begin_dummy_training" => [
                    "text" => "Begin Combat Training",

                    "description" => "Practice your attacks and special abilities against the reinforced training dummy.",

                    "insight_text" => "The training dummy cannot retaliate, making it a safe opportunity to test your combat abilities. Training provides no experience, levels, or leaderboard points.",

                    "next" => "act1_training_dummy",

                    "requires" => [],

                    "effects" => [],

                    "tracker_title" => "Combat Training",

                    "tracker_text" => "You practiced your combat techniques against a reinforced training dummy."
                ],

                "investigate_mana_disaster" => [
                    "text" => "Investigate the Mana Fluctuations",

                    "description" => "Leave the training grounds and learn more about the unprecedented mana disaster near the Mage Kingdom.",

                    "insight_text" => "Reports suggest that the mana fluctuations are far more dangerous than those encountered during your previous expedition. Investigating them will advance the main story.",

                    "next" => "act1_mana_disaster_briefing",

                    "requires" => [],

                    "effects" => [],

                    "tracker_title" => "An Unprecedented Mana Disaster",

                    "tracker_text" => "After spending time training, you turned your attention toward reports of dangerous mana fluctuations near the Mage Kingdom."
                ]
            ]
        ],


        "act1_mana_disaster_briefing" => [
            "title" => "An Emerging Mana Disaster",
            "act" => 1,

            "text" => "Your time at the training grounds is interrupted by an urgent summons from your kingdom's leadership.

                Reports of an increasingly dangerous mana disturbance near the Mage Kingdom have prompted an emergency briefing.

                You leave the training grounds and make your way to meet your superiors, where the situation and your next assignment will be explained.",

            "faction_text" => [
                "warrior" => "Within the Warrior Kingdom's command hall, several senior commanders examine reports arriving from the Mage Kingdom's outer territories.

                    'Our observers have confirmed an unstable concentration of mana near the Mage Kingdom,' one commander explains.

                    'The disturbance has already begun affecting the surrounding environment. If it continues to grow, the consequences could extend well beyond the region.'

                    The commander turns toward you.

                    'The Three Kingdoms have agreed to dispatch cultivators to investigate and contain the disaster. We cannot afford to ignore a threat that may eventually reach our own borders.'

                    'You have reached Level 3 and demonstrated your abilities during your previous expedition. You are qualified to accompany our senior forces on this assignment.'

                    'Your two Level 4 companions from the ancient ruins expedition have been assigned to accompany you once again.'",

                "mage" => "Within the Mage Kingdom's Grand Arcane Council, senior scholars gather around detailed maps and unstable mana readings.

                    'We were the first to detect the disturbance,' one senior mage explains.

                    'The affected region lies within our outer territory, near an abandoned mana refinery that operated for generations.'

                    The mage gestures toward an old facility marked on the map.

                    'Centuries ago, this region possessed exceptionally high ambient mana density. Our predecessors constructed a refinery to concentrate that energy and gradually produce liquid mana.'

                    'The process continued for decades, but eventually the available mana diminished. The facility was abandoned when further refinement became impractical.'

                    Another scholar examines the readings.

                    'Recent worldwide increases in ambient mana appear to have reactivated the region's natural concentration. The abandoned refinery's remaining formations and equipment may have contributed to a dangerous chain reaction.'

                    'We believe this has triggered the current mana disaster.'

                    The council turns toward you.

                    'Although the region belongs to our kingdom, its remote location places it beyond our regularly controlled mana zones. Under the Three Kingdoms' disaster-response treaty, all three kingdoms are sending assistance.'

                    'You have reached Level 3, and your previous expedition has demonstrated your potential. Your two Level 4 senior companions will accompany you once again.'",

                "rogue" => "Within the Rogue Kingdom's intelligence headquarters, senior operatives examine reports gathered by scouts stationed near the Mage Kingdom.

                    'Our agents have confirmed an extraordinary mana disturbance in the Mage Kingdom's outer territory,' one senior operative explains.

                    'The surrounding environment is becoming increasingly unstable. Reports suggest the disturbance is growing rather than fading.'

                    Another operative places a map before you.

                    'We have limited information about the cause. However, the concentration of mana is far beyond what our scouts normally encounter.'

                    'Under the Three Kingdoms' disaster-response treaty, each kingdom is expected to assist in containing threats of this magnitude.'

                    The senior operative studies you.

                    'You have already proven yourself during the ancient ruins expedition. At Level 3, you are capable of participating in a more demanding assignment.'

                    'Your two Level 4 companions from the previous expedition have been selected to accompany you again. Investigate the disturbance, determine what is happening, and help prevent it from spreading.'"
            ],

            "companion_text" => "The briefing concludes with instructions to prepare for departure.

                Representatives from all three kingdoms are expected to participate in the containment effort.

                Your assignment is to travel with your senior companions, investigate the affected region, and assist in preventing the unstable mana from spreading further.

                Before leaving, you have an opportunity to ask about the nature of mana disasters or accept your assignment immediately.",

            "backgrounds" => [
                "page" => null,
                "scene" => null
            ],

            "choices" => [
                "ask_about_mana_disaster" => [
                    "text" => "What Is a Mana Disaster?",

                    "description" => "Ask your superiors to explain how mana disasters occur and why the Three Kingdoms must cooperate to contain them.",

                    "insight_text" => "Understanding mana disasters may reveal why uncontrolled mana is dangerous and why all three kingdoms are obligated to respond.",

                    "next" => "act1_mana_disaster_explanation",

                    "requires" => [],

                    "effects" => [],

                    "tracker_title" => "Understanding Mana Disasters",

                    "tracker_text" => "You requested an explanation of mana disasters and the Three Kingdoms' responsibility to contain them."
                ],

                "accept_mana_disaster_mission" => [
                    "text" => "Accept the Mission",

                    "description" => "Accept your assignment and prepare to depart with your two Level 4 senior companions.",

                    "insight_text" => "Your cultivation has reached Level 3, qualifying you to accompany experienced cultivators on this dangerous mission. Accepting will advance the main story.",

                    "next" => "act1_mission_departure",

                    "requires" => [
                        "stats" => [
                            "level" => 3
                        ]
                    ],

                    "effects" => [],

                    "tracker_title" => "Accepting the Mana Disaster Mission",

                    "tracker_text" => "You accepted your kingdom's assignment to investigate and contain the mana disaster near the Mage Kingdom."
                ]
            ]
        ],

        "act1_mission_departure" => [
            "title" => "Preparations for Departure",
            "act" => 1,

            "text" => "With the briefing concluded, you leave your kingdom's leadership chambers and make your way toward the expedition's designated gathering point.

                Preparations are already underway. Equipment and medical supplies are being distributed to the cultivators assigned to investigate the mana disaster.

                Among the assembled forces, you recognize two familiar figures.

                Your Level 4 senior companions from the ancient ruins expedition have been assigned to accompany you once again.",

            "faction_text" => [
                "warrior" => "Your two Warrior seniors stand near a group of soldiers preparing their equipment.

                    One notices your approach and smiles.

                    'There you are! We heard you'd been assigned to this expedition.'

                    The other senior examines your cultivation before nodding approvingly.

                    'Level 3 already. You've grown considerably stronger since our first journey.'

                    'This mission is different from exploring ancient ruins. We're dealing with an unstable concentration of mana that could threaten entire regions.'

                    'Keep your weapon ready and follow our instructions. We'll handle anything beyond your cultivation.'",

                "mage" => "Your two Mage seniors are examining several magical instruments designed to measure ambient mana density.

                    One looks up as you approach.

                    'Excellent. We were hoping you'd be joining us again.'

                    The other senior studies your cultivation with satisfaction.

                    'Your control over mana has improved significantly. Level 3 suits you.'

                    They gesture toward the instruments.

                    'The readings from the affected region are extremely concerning. We'll need to monitor the mana carefully once we arrive.'

                    'Stay close to us. If the surrounding energy becomes unstable, we may need to establish protective formations immediately.'",

                "rogue" => "Your two Rogue seniors wait near the expedition's supply station, quietly examining maps and intelligence reports.

                    One notices you approaching.

                    'Look who's back. Ready for another expedition?'

                    The other senior gives you an approving glance.

                    'Level 3. Not bad. You've made impressive progress since the ruins.'

                    They lower their voice.

                    'Our scouts have provided limited information about the affected region. The mana is unstable, and we don't know what else might be waiting there.'

                    'Keep your senses sharp and stay within our protection. This isn't a mission where carelessness can be tolerated.'"
            ],

            "companion_text" => "Before departure, your senior companions provide you with five Healing Potions.

                'These are emergency supplies. Keep them close. We cannot predict what dangers the unstable mana might produce.'

                You carefully secure the potions among your belongings.

                Your companions then offer you a final opportunity to prepare.

                'If you're still recovering from training or previous battles, now is the time to restore your strength.'

                'Once we leave, we intend to travel at full speed. There may not be another opportunity to rest before reaching the affected region.'

                With the expedition ready to depart, you must decide whether to complete your recovery or leave immediately.",

            "backgrounds" => [
                "page" => null,
                "scene" => null
            ],

            "choices" => [
                "complete_final_preparations" => [
                    "text" => "Complete Final Preparations",

                    "description" => "Restore your HP and Mana completely, collect your supplies, and prepare to begin Act 2.",

                    "insight_text" => "Recovering before departure ensures that you enter the dangerous region at full strength. You will also receive five Healing Potions for the expedition.",

                    "next" => "act2_disaster_arrival",

                    "requires" => [
                        "stats" => [
                            "level" => 3
                        ]
                    ],

                    "effects" => [
                        "inventory" => [
                            "add" => [
                                "healing_potion",
                                "healing_potion",
                                "healing_potion",
                                "healing_potion",
                                "healing_potion"
                            ]
                        ],
                        "flags" => [
                            "act1_completed" => true,
                            "act2_mission_started" => true
                        ],
                        "stats"=> [
                            "mana" => 2000,
                            "hp" => 200,
                        ]
                    ],

                    "tracker_title" => "Fully Prepared for Act 2",

                    "tracker_text" => "You reunited with your two Level 4 senior companions, received five Healing Potions, and completed your recovery before departing for the mana disaster."
                ],

                "depart_immediately" => [
                    "text" => "Depart Immediately",

                    "description" => "Collect your supplies and begin the expedition without taking additional time to recover.",

                    "insight_text" => "Leaving immediately advances the mission, but any missing HP or Mana will remain unrestored. You will still receive five Healing Potions.",

                    "next" => "act2_disaster_arrival",

                    "requires" => [
                        "stats" => [
                            "level" => 3
                        ]
                    ],

                    "effects" => [
                        "inventory" => [
                            "add" => [
                                "healing_potion",
                                "healing_potion",
                                "healing_potion",
                                "healing_potion",
                                "healing_potion"
                            ]
                        ],
                        "flags" => [
                            "act1_completed" => true,
                            "act2_mission_started" => true
                        ]
                    ],

                    "tracker_title" => "Departing for the Mana Disaster",

                    "tracker_text" => "You reunited with your two Level 4 senior companions, received five Healing Potions, and departed immediately for the mana disaster."
                ]
            ]
        ],


        "act2_disaster_arrival" => [
            "title" => "Act II — The Mana Disaster",
            "act" => 2,

            "text" => "With preparations complete, your expedition finally departs.

                Accompanied by your two Level 4 senior cultivators, you travel toward the remote region where the mana disaster has been reported.

                As your destination draws closer, you begin sensing an unusual concentration of mana in the surrounding atmosphere.",

            "faction_text" => [
                "warrior" => "Your two Warrior seniors waste no time beginning the journey.

                    Drawing upon their Level 4 cultivation, they rise into the sky, carrying you along as they accelerate toward the distant Mage Kingdom.

                    The landscape races beneath you. Mountains, rivers, and vast stretches of wilderness disappear behind the expedition.

                    Although your Level 3 cultivation has strengthened your body considerably, sustained flight remains beyond your current abilities.

                    Your seniors maintain their tremendous speed until the distant forest surrounding the disaster site finally comes into view.

                    As you descend, you feel an oppressive concentration of mana pressing against your body.",

                "mage" => "Your two Mage seniors activate their flight techniques, lifting themselves into the air and carrying you alongside them.

                    Unlike the expeditions departing from the other kingdoms, your destination lies relatively close to the Mage Kingdom's outer territories.

                    The journey takes you beyond the regularly maintained mana-regulation zones and toward a remote region that has remained largely abandoned for decades.

                    As you approach, the ambient mana becomes increasingly concentrated.

                    Your seniors exchange concerned glances as their instruments begin registering unstable readings.

                    Even before reaching the forest, you can sense the violent fluctuations spreading through the surrounding atmosphere.",

                "rogue" => "Your two Rogue seniors exchange a glance before activating their movement techniques.

                    Their Level 4 cultivation allows them to take to the skies, and they carry you along as they accelerate across the wilderness.

                    The journey is astonishingly fast. Forests, mountain ranges, and distant settlements blur beneath you.

                    Despite your improved Level 3 cultivation, you struggle to follow the movements of your seniors.

                    Eventually, the expedition approaches the remote forest near the Mage Kingdom.

                    As you descend toward the outskirts, your senses detect something deeply unsettling.

                    The mana surrounding the region is unusually dense, unstable, and constantly shifting."
            ],

            "companion_text" => "Your expedition lands near the outskirts of a vast forest.

                The atmosphere feels entirely different from the regions you traveled through earlier.

                Mana saturates the air in overwhelming quantities. Unstable currents surge through the surroundings, occasionally whipping against your body like invisible gusts of wind.

                The trees sway despite the absence of any ordinary breeze, and faint pulses of concentrated energy ripple through the forest.

                One of your senior companions studies the environment.

                'We're here. The mana density is even worse than the reports suggested.'

                The other senior scans the distant treeline.

                'Stay alert. We need to understand what is happening before attempting to approach the center of the disturbance.'

                Your expedition prepares to investigate the surrounding area.",

            "backgrounds" => [
                "page" => null,
                "scene" => null
            ],

            "choices" => [
                "survey_disaster_area" => [
                    "text" => "Survey the Surrounding Area",

                    "description" => "Examine the forest outskirts and look for signs of unusual activity before proceeding.",

                    "insight_text" => "Careful observation may reveal information about the disturbance or evidence of others who have passed through the region.",

                    "next" => "act2_disaster_scouting",

                    "requires" => [],

                    "effects" => [],

                    "tracker_title" => "Investigating the Mana Disaster",

                    "tracker_text" => "You arrived at the mana disaster site and began surveying the unstable forest outskirts."
                ]
            ]
        ],


        "act2_disaster_scouting" => [
            "title" => "Two Paths Through the Forest",
            "act" => 2,

            "text" => "Your expedition begins surveying the outskirts of the disaster-stricken forest.

                The atmosphere is saturated with unstable mana. Strange fluctuations ripple through the trees, making it difficult to determine exactly where the disturbance originates.

                After carefully examining the surrounding terrain, your two senior companions identify two areas worth investigating.

                In one direction, several trees have been broken or knocked aside. The damage forms an irregular trail extending deeper into the forest.

                In another direction, the surrounding mana grows noticeably denser. Powerful fluctuations radiate from somewhere beyond the treeline.

                Both locations may provide valuable information about the disaster, but they appear to lead toward very different discoveries.",

            "companion_text" => "One of your seniors gestures toward the damaged trees.

                'Look over there. Several trees have been broken, and the damage seems to continue farther into the forest.'

                Your other senior examines the surrounding area.

                'That could be evidence of human activity. Remember, all three kingdoms have dispatched cultivators to investigate this disaster. Other expeditions may already be operating nearby.'

                They turn toward the second direction.

                'However, the mana fluctuations are considerably stronger over there. If we're searching for the source of this disaster, following that concentration may be more productive.'

                The first senior looks toward you.

                'Both directions are worth investigating. We could examine the damaged forest first, or proceed directly toward the stronger mana fluctuations.'

                Your companions wait for your decision.",

            "backgrounds" => [
                "page" => null,
                "scene" => null
            ],

            "choices" => [
                "investigate_broken_trees" => [
                    "text" => "Investigate the Broken Trees",

                    "description" => "Examine the damaged forest for evidence of human activity or other expeditions.",

                    "insight_text" => "The damaged trees may reveal information about other cultivators operating in the region. Investigating could uncover an optional path that would otherwise remain hidden.",

                    "next" => "act2_forest_tracks",

                    "requires" => [],

                    "effects" => [
                        "flags" => [
                            "investigated_broken_trees" => true
                        ]
                    ],

                    "tracker_title" => "Investigating the Damaged Forest",

                    "tracker_text" => "You chose to examine the broken trees for signs of human activity before following the stronger mana fluctuations."
                ],

                "follow_dense_mana" => [
                    "text" => "Follow the Dense Mana",

                    "description" => "Proceed toward the stronger mana fluctuations and investigate the source of the disturbance.",

                    "insight_text" => "Following the stronger mana fluctuations advances the main investigation, but you may miss information hidden along the damaged forest trail.",

                    "next" => "act2_dense_mana",

                    "requires" => [],

                    "effects" => [
                        "flags" => [
                            "followed_dense_mana" => true
                        ]
                    ],

                    "tracker_title" => "Following the Mana Fluctuations",

                    "tracker_text" => "You bypassed the damaged forest and proceeded toward the increasingly powerful mana fluctuations."
                ]
            ]
        ],



        "act2_forest_tracks" => [
            "title" => "Traces of Another Expedition",
            "act" => 2,

            "text" => "You lead your companions toward the damaged section of the forest.

                Several large trees have been snapped apart, while others have been knocked aside with considerable force.

                At first, the destruction appears to be another consequence of the unstable mana saturating the region.

                However, closer examination reveals something unusual.

                The broken trees form a rough passage through the forest. Beneath the fallen branches, you discover disturbed soil, footprints, and traces of recently released cultivation energy.

                These are not the marks of ordinary wildlife or a natural mana disturbance.

                Someone has deliberately forced their way through this forest.

                Although the remaining energy signatures are too distorted to identify their kingdom, the tracks appear relatively fresh.

                Whoever passed through here may still be somewhere nearby.",

            "companion_text" => "One of your seniors crouches beside the disturbed ground.

                'These are definitely cultivation traces. Another expedition passed through here recently.'

                Your second companion examines the damaged trees.

                'They must have cleared a path using their techniques. Judging by how fresh these marks are, they might still be operating in the surrounding forest.'

                The first senior nods.

                'We cannot determine which kingdom they belong to, but we should remain alert. We may encounter them farther ahead.'

                Your companions turn toward the increasingly powerful mana fluctuations.

                'For now, we should continue toward the source of the disturbance.'",

            "backgrounds" => [
                "page" => null,
                "scene" => null
            ],

            "choices" => [
                "continue_toward_dense_mana" => [
                    "text" => "Follow the Dense Mana",

                    "description" => "Continue toward the stronger mana fluctuations while remaining alert for the unidentified expedition.",

                    "insight_text" => "You discovered evidence that another expedition passed through the forest. Although their identity remains unknown, you now know to search for their presence as you investigate the disaster.",

                    "next" => "act2_dense_mana",

                    "requires" => [],

                    "effects" => [
                        "flags" => [
                            "rival_location_discovered" => true,
                            "followed_dense_mana" => true
                        ]
                    ],

                    "tracker_title" => "Discovered Another Expedition's Tracks",

                    "tracker_text" => "You discovered fresh cultivation traces left by an unidentified expedition and continued toward the dense mana, aware that other cultivators may be nearby."
                ]
            ]
        ],


        "act2_dense_mana" => [
            "title" => "The Thickening Mana",
            "act" => 2,

            "text" => "You press deeper into the forest, following the increasingly concentrated mana. The ground has begun to fracture, and a faint blue mist rises through the cracks. Nearby trees pulse with unnatural blue veins beneath their bark, while a low hum vibrates through the earth. With every step, the air grows heavier, until you notice a small, blackened cavern ahead. An intense stream of blue mist pours from its entrance, carrying the densest concentration of ambient mana you have ever encountered.",

            "companion_text" => "One of your senior cultivators stops beside you, studying the cavern. \"That concentration should not be possible here. Something has disturbed the natural flow of mana. Stay close. We do not know what is waiting inside.\"",

            "backgrounds" => [
                "page" => null,
                "scene" => null
            ],

            "choices" => [
                "approach_blackened_cavern" => [
                    "text" => "Approach the Blackened Cavern",

                    "description" => "Move closer to the source of the unusually dense ambient mana.",

                    "insight_text" => "The cavern appears to be a major source of the disturbance. Approaching it may reveal more about the disaster, but the abnormal mana concentration suggests that the area could be dangerous.",

                    "next" => "act2_cavern_treants",

                    "requires" => [],

                    "effects" => [
                        "stats" => [],
                        "inventory" => [
                            "add" => [],
                            "remove" => []
                        ],
                        "trust" => [],
                        "flags" => [
                            "act2_cavern_approached" => true
                        ]
                    ],

                    "tracker_title" => "The Blackened Cavern",
                    "tracker_text" => "You followed the dense mana through the unstable forest and discovered a blackened cavern emitting an extraordinary concentration of ambient mana."
                ]
            ]
        ],


        "act2_cavern_treants" => [
            "title" => "Guardians of the Blackened Cavern",
            "act" => 2,

            "text" => "As you approach the cavern, several humanoid figures emerge through the thick blue mist. Their bodies resemble twisted trees, with blackened bark and branches warped by excessive mana. These mana-corrupted treants stand between your expedition and the cavern entrance. Before you can examine them further, one releases a distorted howl and lunges directly toward you. Your senior cultivators immediately move to intercept the remaining creatures.",

            "companion_text" => "One of your senior cultivators shouts, \"Rank Three treants! There are a few Rank Fours among them! Handle the one approaching you. We will take care of the others!\"",

            "backgrounds" => [
                "page" => null,
                "scene" => null
            ],

            "choices" => [
                "defeat_corrupted_treant" => [
                    "text" => "Defeat the Corrupted Treant",

                    "description" => "Engage the attacking treant while your senior cultivators eliminate the remaining creatures.",

                    "insight_text" => "The treant is already committed to its attack. Your senior cultivators are occupied with the other creatures, leaving you to handle this opponent. The encounter will advance the story without deducting HP or Mana.",

                    "next" => "act2_treant_aftermath",

                    "requires" => [],

                    "effects" => [
                        "stats" => [],
                        "inventory" => [
                            "add" => [],
                            "remove" => []
                        ],
                        "trust" => [],
                        "flags" => [
                            "act2_corrupted_treants_defeated" => true
                        ]
                    ],

                    "tracker_title" => "Corrupted Treants Defeated",
                    "tracker_text" => "You defeated an attacking mana-corrupted treant while your senior cultivators eliminated the remaining creatures guarding the cavern."
                ]
            ]
        ],


        "act2_treant_aftermath" => [
            "title" => "The Cavern's Threshold",
            "act" => 2,

            "text" => "The final corrupted treant collapses, its twisted body crumbling against the fractured earth. Around you, your senior cultivators finish eliminating the remaining Rank Three and Rank Four creatures. With the entrance secured, your expedition regroups before the small blackened cavern. Dense blue mist continues pouring from its depths, and the surrounding earth trembles with unstable mana. As you prepare to investigate, you notice several other concentrated mana signatures deeper within the surrounding forest.",

            "companion_text" => "One of your senior cultivators examines the cavern entrance. \"We should investigate this place. However, those other mana signatures are unusual as well. If we intend to examine them, we should do so before entering. We cannot afford to keep retracing our steps through this unstable forest.\"",

            "backgrounds" => [
                "page" => null,
                "scene" => null
            ],

            "choices" => [
                "enter_blackened_cavern" => [
                    "text" => "Enter the Blackened Cavern",

                    "description" => "Proceed directly into the cavern to investigate the source of the mana disaster. You will not be able to return to the surrounding forest.",

                    "insight_text" => "Entering the cavern advances the main investigation. However, doing so means abandoning the opportunity to investigate the other mana signatures and obtain the optional Zenith Boosts.",

                    "next" => "act3_blackened_cavern_entrance",

                    "requires" => [],

                    "effects" => [
                        "stats" => [],
                        "inventory" => [
                            "add" => [],
                            "remove" => []
                        ],
                        "trust" => [],
                        "flags" => [
                            "act2_cavern_entered" => true,
                            "act2_zenith_path_skipped" => true
                        ]
                    ],

                    "tracker_title" => "Entered the Blackened Cavern",
                    "tracker_text" => "You entered the blackened cavern to continue investigating the mana disaster, leaving the other mana signatures unexplored."
                ],

                "investigate_other_mana_signatures" => [
                    "text" => "Investigate the Other Mana Signatures",

                    "description" => "Explore the unusual mana concentrations surrounding the cavern before proceeding inside.",

                    "insight_text" => "The surrounding forest contains additional concentrations of unstable mana. Investigating them could reveal valuable discoveries, but doing so may expose you to further dangers and consume resources needed later.",

                    "next" => "act2_zenith_path_start",

                    "requires" => [],

                    "effects" => [
                        "stats" => [],
                        "inventory" => [
                            "add" => [],
                            "remove" => []
                        ],
                        "trust" => [],
                        "flags" => [
                            "act2_zenith_path_started" => true
                        ]
                    ],

                    "tracker_title" => "Investigating the Mana Signatures",
                    "tracker_text" => "Before entering the cavern, you decided to investigate the other unusual mana signatures detected in the surrounding forest."
                ]
            ]
        ],

        // Zenith Path

        "act2_zenith_path_start" => [
            "title" => "The Shattered Amber Clearing",
            "act" => 2,

            "text" => "Following the unusual mana signatures, your expedition arrives at what was once a clearing filled with amber sap trees. Many of the trees have violently ruptured, scattering splintered trunks and hardened amber across the forest floor. Brilliant blue veins pulse beneath the surrounding earth, feeding unstable mana into the surviving trees. Ahead, an enormous formation of crystallized amber blocks the passage. The ground beneath it trembles faintly, accompanied by a deep, rhythmic hum.",

            "companion_text" => "One of your senior cultivators kneels beside the amber formation. \"These trees absorbed far more mana than their bodies could contain. Their sap crystallized when they ruptured.\" Another senior studies the ground. \"There is still a considerable amount of mana moving beneath us. We should be careful about disturbing it.\"",

            "backgrounds" => [
                "page" => null,
                "scene" => null
            ],

            "choices" => [
                "shatter_amber_barrier" => [
                    "text" => "Shatter the Amber Barrier",

                    "description" => "Use raw strength to break through the crystallized amber. The unstable formation may retaliate violently.",

                    "insight_text" => "A forceful approach could clear the obstruction quickly, but the amber is saturated with unstable mana. Shattering it risks triggering a violent reaction and causing physical injury. You will lose 5 HP.",

                    "next" => "act2_geyser_crossing",

                    "requires" => [
                        "stats" => [
                            "hp" => 6
                        ]
                    ],

                    "effects" => [
                        "stats" => [
                            "hp" => -5
                        ],
                        "inventory" => [
                            "add" => [],
                            "remove" => []
                        ],
                        "trust" => [],
                        "flags" => [
                            "act2_amber_shattered" => true
                        ]
                    ],

                    "tracker_title" => "Shattered the Amber Barrier",
                    "tracker_text" => "You forcefully shattered the crystallized amber, suffering minor injuries as the unstable mana beneath the clearing erupted."
                ],

                "siphon_amber_mana" => [
                    "text" => "Carefully Siphon the Mana",

                    "description" => "Work alongside your senior cultivators to release the pressure within the amber formation without suffering injury.",

                    "insight_text" => "Your senior cultivators can guide you in carefully regulating the mana flowing through the amber. This approach takes longer but allows you to detect the dangerous pressure beneath the clearing and retreat before it erupts. It is VERY mana intensive.",

                    "next" => "act2_geyser_crossing",

                    "requires" => [],

                    "effects" => [
                        "stats" => [
                            "mana" => -10
                        ],
                        "inventory" => [
                            "add" => [],
                            "remove" => []
                        ],
                        "trust" => [],
                        "flags" => [
                            "act2_amber_siphoned" => true
                        ]
                    ],

                    "tracker_title" => "Stabilized the Amber Barrier",
                    "tracker_text" => "With guidance from your senior cultivators, you carefully released the mana trapped within the amber and avoided injury when the underground geyser erupted."
                ],

                "examine_geyser_tracks" => [
                    "text" => "Examine the Area",

                    "description" => "Search the shattered amber clearing for signs of the expedition whose tracks you discovered earlier.",

                    "insight_text" => "You discovered signs of another expedition while investigating the broken trees. The unusual tracks and cultivation traces suggest they may be somewhere near this clearing. Searching the area could reveal their location and create an opportunity for negotiation.",

                    "next" => "act2_geyser_rival_discovery",

                    "requires" => [
                        "flags" => [
                            "rival_location_discovered" => true,
                            "investigated_broken_trees" => true,
                        ],

                        "geyser_rival" => [
                            "available" => true
                        ]
                    ],

                    "effects" => [
                        "flags" => [
                            "act2_geyser_tracks_examined" => true
                        ]
                    ],

                    "tracker_title" => "Examined the Shattered Clearing",

                    "tracker_text" => "You followed the clues discovered earlier and searched the shattered amber clearing, locating another expedition nearby."
                ],
            ]
        ],


        "act2_ruptured_mana_geyser" => [
            "title" => "The Ruptured Mana Geyser",
            "act" => 2,

            "text" => "The amber barrier fractures, and a deafening rumble tears through the clearing. A towering column of brilliant blue mana erupts from beneath the earth, scattering crystallized amber in every direction. Your senior cultivators pull you away from the eruption before the full force reaches you. As the debris settles, you realize that the exposed opening is only a small portion of a much larger underground mana geyser. The entire ravine trembles as pressure continues building beneath it. Beyond the unstable passage, an unusual concentration of mana glimmers through the mist.",
            
            "companion_text" => "One of your senior cultivators studies the surging mana. 'This is no ordinary fluctuation. The entire ravine is acting as a pressure chamber.'

            Another points toward the opening. 'We can force our way through, or use mana to shield ourselves, but both methods carry risks.'

            The rival champion steps forward if cooperation has been established. 'Our expeditions have agreed to work together. Let us combine our cultivation techniques and stabilize the passage.'

            Your senior cultivator nods. 'With both expeditions working together, we should be able to cross safely.'",


            "backgrounds" => [
                "page" => null,
                "scene" => null
            ],

            "choices" => [
                "force_through_geyser" => [
                    "text" => "Force Through the Geyser",

                    "description" => "Push through the unstable passage using your physical endurance.",

                    "insight_text" => "Crossing through the surging mana without sufficient protection will expose your body to intense pressure and flying debris. You will lose 15 HP, and the noise may alert anyone nearby.",

                    "next" => "act2_geyser_crossing",

                    "requires" => [
                        "stats" => [
                            "hp" => 16
                        ]
                    ],

                    "effects" => [
                        "stats" => [
                            "hp" => -15
                        ],
                        "inventory" => [
                            "add" => [],
                            "remove" => []
                        ],
                        "trust" => [],
                        "flags" => [
                            "act2_geyser_crossed_with_hp" => true
                        ]
                    ],

                    "tracker_title" => "Endured the Mana Geyser",
                    "tracker_text" => "You forced your way through the unstable mana geyser, sacrificing 15 HP to reach the other side."
                ],

                "shield_with_mana" => [
                    "text" => "Shield Yourself with Mana",

                    "description" => "Channel your mana into a protective barrier and cross the unstable passage.",

                    "insight_text" => "A concentrated mana shield can protect your body from the geyser's pressure. However, maintaining the barrier will consume 20 Mana, potentially limiting your abilities in later encounters.",

                    "next" => "act2_geyser_crossing",

                    "requires" => [
                        "stats" => [
                            "mana" => 20
                        ]
                    ],

                    "effects" => [
                        "stats" => [
                            "mana" => -20
                        ],
                        "inventory" => [
                            "add" => [],
                            "remove" => []
                        ],
                        "trust" => [],
                        "flags" => [
                            "act2_geyser_crossed_with_mana" => true
                        ]
                    ],

                    "tracker_title" => "Shielded Against the Geyser",
                    "tracker_text" => "You created a protective mana barrier and crossed the geyser, sacrificing 20 Mana to avoid physical injury."
                ],


                "cooperate_cross_geyser" => [
                    "text" => "Cooperate with the Rival Expedition",

                    "description" => "Combine your expedition's cultivation techniques with those of the rival kingdom to safely cross the unstable mana geyser.",

                    "insight_text" => "Your successful negotiations have created an opportunity for cooperation. By combining the strength and cultivation techniques of both expeditions, you can stabilize the surrounding mana long enough to cross without sacrificing HP or Mana.",

                    "next" => "act2_first_zenith",

                    "requires" => [
                        "flags" => [
                            "act2_geyser_cooperation_agreed" => true
                        ]
                    ],

                    "effects" => [
                        "stats" => [],
                        "inventory" => [
                            "add" => [],
                            "remove" => []
                        ],
                        "trust" => [
                            "geyser_rival" => 0
                        ],
                        "flags" => [
                            "act2_geyser_crossed_cooperatively" => true
                        ]
                    ],

                    "tracker_title" => "Crossed the Geyser Together",

                    "tracker_text" => "You and the rival expedition combined your cultivation techniques to stabilize the ruptured mana geyser. Working together, both expeditions crossed safely without sacrificing HP or Mana."
                ],

            ]
        ],


        "act2_geyser_crossing" => [
            "title" => "Crossing the Ruptured Mana Geyser",
            "act" => 2,

            "text" => "The amber barrier fractures, and a deafening rumble tears through the clearing. A towering column of brilliant blue mana erupts from beneath the earth, scattering crystallized amber in every direction. Your senior cultivators pull you away from the eruption before the full force reaches you. As the debris settles, you realize that the exposed opening is only a small portion of a much larger underground mana geyser. The entire ravine trembles as pressure continues building beneath it. Beyond the unstable passage, an unusual concentration of mana glimmers through the mist.",

            "companion_text" => "One of your senior cultivators studies the surging mana. 'The pressure is still increasing. We cannot remain here indefinitely.'

            Another examines the unstable passage. 'We have two options. We can force our way through and endure the physical damage, or channel mana into a protective barrier.'

            Your senior cultivator turns toward you. 'Neither approach is without risk, Champion. The decision is yours.'",

            "backgrounds" => [
                "page" => null,
                "scene" => null
            ],

            "choices" => [
                "force_through_geyser" => [
                    "text" => "Force Through the Geyser",

                    "description" => "Push through the unstable passage using your physical endurance.",

                    "insight_text" => "Crossing through the surging mana without sufficient protection will expose your body to intense pressure and flying debris. You will lose 15 HP.",

                    "next" => "act2_first_zenith",

                    "requires" => [
                        "stats" => [
                            "hp" => 16
                        ]
                    ],

                    "effects" => [
                        "stats" => [
                            "hp" => -15
                        ],
                        "flags" => [
                            "act2_geyser_crossed_with_hp" => true
                        ]
                    ],

                    "tracker_title" => "Endured the Mana Geyser",
                    "tracker_text" => "You forced your way through the unstable mana geyser, sacrificing 15 HP to reach the other side."
                ],

                "shield_with_mana" => [
                    "text" => "Shield Yourself with Mana",

                    "description" => "Channel your mana into a protective barrier and cross the unstable passage.",

                    "insight_text" => "A concentrated mana shield can protect your body from the geyser's pressure. Maintaining the barrier will consume 20 Mana.",

                    "next" => "act2_first_zenith",

                    "requires" => [
                        "stats" => [
                            "mana" => 20
                        ]
                    ],

                    "effects" => [
                        "stats" => [
                            "mana" => -20
                        ],
                        "flags" => [
                            "act2_geyser_crossed_with_mana" => true
                        ]
                    ],

                    "tracker_title" => "Shielded Against the Geyser",
                    "tracker_text" => "You created a protective mana barrier and crossed the geyser, sacrificing 20 Mana to avoid physical injury."
                ]
            ]
        ],



        "act2_geyser_rival_discovery" => [
            "title" => "Figures Behind the Foliage",
            "act" => 2,

            "text" => "Remembering the cultivation traces discovered earlier in the forest, you decide to investigate the shattered amber clearing more carefully.

                Beyond several fallen trees, you notice footprints partially concealed beneath crystallized amber.

                The tracks are fresh.

                Following them around the edge of the clearing, you discover several figures gathered behind a dense wall of vegetation.

                Their clothing and insignia remain obscured by the foliage and drifting blue mist, making it impossible to determine which kingdom they belong to.

                You can distinguish several experienced cultivators and a younger champion among them.

                They appear to be examining the unstable mana flowing beneath the clearing.

                Fortunately, they have not noticed your expedition.

                You have discovered another kingdom's expedition before they discovered yours.",


            "companion_text" => "One of your senior cultivators quietly signals everyone to stop.

                'Another expedition. Those tracks in the forest led us directly to them.'

                Your second senior studies the figures from behind the vegetation.

                'I cannot identify their kingdom from here. However, they appear to be investigating the same mana disturbance.'

                The senior turns toward you.

                'We can approach them peacefully and attempt to cooperate, avoid them entirely, or attack before they notice us.'

                'Remember, all three kingdoms are supposed to be cooperating to contain this disaster. An unnecessary confrontation could have serious consequences.'

                Your companions wait for your decision.",

            "backgrounds" => [
                "page" => null,
                "scene" => null
            ],

            "choices" => [
                "approach_rival_peacefully" => [
                    "text" => "Approach the Expedition Peacefully",

                    "description" => "Reveal your presence and attempt to communicate with the unidentified cultivators.",

                    "insight_text" => "A peaceful approach allows you to identify the expedition and potentially negotiate cooperation. Their response may depend on your existing relationship with their kingdom.",

                    "next" => "act2_geyser_rival_negotiation",

                    "requires" => [],

                    "effects" => [
                        "stats" => [],
                        "inventory" => [
                            "add" => [],
                            "remove" => []
                        ],
                        "trust" => [],
                        "flags" => [
                            "act2_geyser_rival_spotted" => true,
                            "act2_geyser_peaceful_approach" => true
                        ]
                    ],

                    "tracker_title" => "Approached an Unknown Expedition",
                    "tracker_text" => "You discovered an unidentified expedition near the geyser and chose to approach them peacefully."
                ],

                "attack_rival_expedition" => [
                    "text" => "Attack the Unidentified Expedition",

                    "description" => "Launch an attack before the other cultivators can react. This is an openly hostile action.",

                    "insight_text" => "Attacking an unidentified expedition could provoke a dangerous confrontation and severely damage diplomatic relations. Once their kingdom is identified, the attack will cost 20 trust with that kingdom. You will not receive a trust reward simply for sparing someone you deliberately attacked.",

                    "next" => "act2_geyser_rival_attack",

                    "requires" => [],

                    "effects" => [
                        "stats" => [],
                        "inventory" => [
                            "add" => [],
                            "remove" => []
                        ],
                        "trust" => [],
                        "flags" => [
                            "act2_geyser_rival_spotted" => true,
                            "act2_geyser_player_attacked" => true
                        ]
                    ],

                    "tracker_title" => "Attacked the Unknown Expedition",
                    "tracker_text" => "You launched an attack against an unidentified expedition near the mana geyser."
                ],

                "avoid_rival_expedition" => [
                    "text" => "Avoid the Unidentified Expedition",

                    "description" => "Withdraw quietly and attempt to cross the geyser without making contact.",

                    "insight_text" => "Avoiding the expedition prevents an immediate confrontation but does not guarantee safety. You have identified their approximate location, so you will not be completely surprised if they attempt an ambush later.",

                    "next" => "act2_zenith_path_start",

                    "requires" => [],

                    "effects" => [
                        "stats" => [],
                        "inventory" => [
                            "add" => [],
                            "remove" => []
                        ],
                        "trust" => [],
                        "flags" => [
                            "act2_geyser_rival_spotted" => true,
                            "act2_geyser_rival_avoided" => true
                        ]
                    ],

                    "tracker_title" => "Avoided the Unknown Expedition",
                    "tracker_text" => "You located an unidentified expedition near the geyser but chose to avoid contact while remaining aware of its position."
                ]
            ]
        ],

        
        "act2_geyser_rival_negotiation" => [
            "title" => "An Uneasy Encounter",
            "act" => 2,

            "text" => "You emerge from behind the foliage with your hands visible, signaling peaceful intentions. Your senior cultivators follow cautiously. Across the clearing, the rival expedition immediately assumes defensive positions. Their champion steps forward, recognizing your kingdom's insignia. Both expeditions remain separated by the unstable mana geyser. Despite the tension, neither side has attacked.",

            "faction_text" => [
                "warrior" => "The Rogue Kingdom champion studies you carefully. Their weapons remain ready, but they appear willing to hear your proposal.",

                "mage" => "The Warrior Kingdom champion recognizes your Mage Kingdom robes. 'So the Mage Kingdom has reached the geyser as well,' they remark. 'What do you want?'",

                "rogue" => "The Warrior Kingdom champion steps forward. Their senior cultivators remain alert, waiting for their champion's decision."
            ],

            "companion_text" => "One of your senior cultivators speaks quietly. 'The geyser is too unstable for either expedition to approach carelessly. Combining our cultivation techniques may allow us to cross safely.' Another adds, 'All three kingdoms agreed to investigate this disaster. Cooperation would serve everyone better than unnecessary bloodshed.'",

            "backgrounds" => [
                "page" => null,
                "scene" => null
            ],

            "choices" => [
                "propose_geyser_cooperation" => [
                    "text" => "Propose Cooperation",

                    "description" => "Ask the rival expedition to combine their strength with yours and stabilize the geyser together.",

                    "insight_text" => "The rival expedition understands the danger of the geyser. Cooperation will allow both groups to cross safely without sacrificing HP or Mana. Their agreement will unlock a cooperative crossing option.",

                    "next" => "act2_ruptured_mana_geyser",

                    "requires" => [],

                    "effects" => [
                        "stats" => [],
                        "inventory" => [
                            "add" => [],
                            "remove" => []
                        ],
                        "trust" => [
                            "geyser_rival" => 0
                        ],
                        "flags" => [
                            "act2_geyser_cooperation_agreed" => true,
                            "act2_geyser_rival_negotiated" => true
                        ]
                    ],

                    "tracker_title" => "Established Expedition Cooperation",

                    "tracker_text" => "You successfully negotiated with the rival champion. Both expeditions agreed to combine their cultivation techniques to cross the unstable mana geyser."
                ],

                "fight_geyser_rival" => [
                    "text" => "Challenge the Rival Champion",

                    "description" => "Reject cooperation and prepare to fight the opposing expedition.",

                    "insight_text" => "Choosing violence will damage relations with the rival kingdom and prevent a peaceful crossing. This confrontation will be developed separately.",

                    "next" => "act2_ruptured_mana_geyser",

                    "requires" => [],

                    "effects" => [
                        "stats" => [],
                        "inventory" => [
                            "add" => [],
                            "remove" => []
                        ],
                        "trust" => [
                            "geyser_rival" => -20
                        ],
                        "flags" => [
                            "act2_geyser_rival_attacked" => true,
                            "act2_geyser_cooperation_agreed" => false
                        ]
                    ],

                    "tracker_title" => "Challenged the Rival Champion",

                    "tracker_text" => "You rejected cooperation and challenged the rival expedition, risking the fragile alliance between the kingdoms."
                ]
            ]
        ],


        "act2_first_zenith" => [
            "title" => "First Zenith — The Mana Crystal",
            "act" => 2,

            "text" => "Beyond the ruptured mana geyser, the turbulent pressure gradually begins to settle. You and your senior cultivators emerge into the heart of the Amber Clearing.

            At the center of the clearing rests a small, brilliantly glowing mana crystal. Despite its size, the crystal radiates an extraordinary concentration of spiritual energy. Tiny droplets of condensation continuously form along its surface, rolling down its crystalline edges before evaporating into the surrounding air.

            The mana pressure throughout the clearing appears to originate from this single crystal. Every pulse sends a faint wave of energy through the surrounding earth.

            You approach cautiously, sensing that the crystal contains enough concentrated mana to strengthen your cultivation.",

            "companion_text" => "One of your senior cultivators examines the crystal from a distance. 'Remarkable. Such a small object should not be capable of containing this much mana.'

            Another cultivator turns toward you. 'Champion, your cultivation foundation may be strong enough to absorb its energy. If you succeed, this could provide a significant breakthrough.'

            Your companions step aside, allowing you to approach the crystal.",

            "backgrounds" => [
                "page" => null,
                "scene" => null
            ],

            "choices" => [
                "absorb_first_zenith" => [
                    "text" => "Grab and Absorb",

                    "description" => "Take hold of the glowing mana crystal and absorb its concentrated spiritual energy to strengthen your cultivation.",

                    "insight_text" => "The crystal contains highly concentrated mana capable of permanently strengthening your cultivation. Warriors will gain 5 maximum HP and 5 Strength. Rogues will gain 2 Strength and 30 maximum Mana. Mages will gain 50 maximum Mana.",

                    "next" => "act2_zenith_clearing_return",

                    "requires" => [
                        "flags" => [
                            "act2_first_zenith_absorbed" => false
                        ]
                    ],

                    "effects" => [
                        "stats" => [],
                        "inventory" => [
                            "add" => [],
                            "remove" => []
                        ],
                        "trust" => [],
                        "flags" => [
                            "act2_first_zenith_absorbed" => true
                        ]
                    ],

                    "tracker_title" => "First Zenith Achieved",

                    "tracker_text" => "You absorbed the concentrated mana crystal at the center of the Amber Clearing, permanently strengthening your cultivation."
                ]
            ]
        ],


        "act2_zenith_clearing_return" => [
            "title" => "The Amber Clearing",
            "act" => 2,

            "text" => "The mana crystal dissolves into brilliant streams of spiritual energy as you absorb its power. A surge of warmth spreads throughout your body, strengthening your cultivation foundation.

            As the final traces of energy settle, you return your attention to the surrounding clearing. The once-overwhelming mana pressure has weakened considerably, allowing you to examine the area more carefully.

            Beyond the clearing, the entrance to the Blackened Cavern stands partially concealed by jagged rocks and dark vegetation. Faint pulses of unfamiliar mana emerge from its depths.

            However, something else catches your attention. Along the forest's edge, several enormous roots glow with an unnatural amber light. Their movements suggest that the surrounding vegetation has been affected by the same mana disturbances.

            Your expedition has reached a crossroads. You can investigate the glowing roots or continue directly toward the cavern.",

            "companion_text" => "One of your senior cultivators examines the cavern entrance. 'The mana fluctuations appear to continue underground. Whatever caused this disaster may be waiting inside.'

            Another gestures toward the glowing roots. 'Those roots are behaving strangely. There may be something worth investigating before we proceed.'

            Your companions await your decision.",

            "backgrounds" => [
                "page" => null,
                "scene" => null
            ],

            "choices" => [
                "investigate_glowing_roots" => [
                    "text" => "Investigate the Glowing Roots",

                    "description" => "Explore the strange mana-infused roots near the forest's edge before entering the cavern.",

                    "insight_text" => "The glowing roots appear to contain traces of concentrated mana. Investigating them may reveal another opportunity to strengthen your cultivation, although the vegetation could present an unexpected danger.",

                    "next" => "act2_glowing_roots",

                    "requires" => [
                        "flags" => [
                            "act2_glowing_roots_rescue_refused" => false
                        ]
                    ],
 
                    "effects" => [
                        "stats" => [],
                        "inventory" => [
                            "add" => [],
                            "remove" => []
                        ],
                        "trust" => [],
                        "flags" => [
                            "act2_glowing_roots_investigated" => true
                        ]
                    ],

                    "tracker_title" => "Investigated the Glowing Roots",

                    "tracker_text" => "You chose to investigate the strange mana-infused roots before entering the Blackened Cavern."
                ],

                "enter_blackened_cavern" => [
                    "text" => "Enter the Blackened Cavern",

                    "description" => "Leave the Amber Clearing behind and continue your investigation inside the mysterious cavern.",

                    "insight_text" => "The strongest remaining mana fluctuations originate from inside the Blackened Cavern. Entering will advance the story into Act 3. However, doing so now means leaving the optional second Zenith crystal undiscovered.",

                    "next" => "act3_blackened_cavern_entrance",

                    "requires" => [],

                    "effects" => [
                        "stats" => [],
                        "inventory" => [
                            "add" => [],
                            "remove" => []
                        ],
                        "trust" => [],
                        "flags" => [
                            "act2_zenith_path_completed" => true,
                            "act3_blackened_cavern_entered" => true
                        ]
                    ],

                    "tracker_title" => "Entered the Blackened Cavern",

                    "tracker_text" => "After absorbing the first Zenith crystal, you left the Amber Clearing and entered the Blackened Cavern to investigate the source of the mana disturbances."
                ]
            ]
        ],


        "act2_glowing_roots" => [
            "title" => "The Glowing Roots",
            "act" => 2,

            "text" => "Following the strange amber glow, you venture toward the edge of the clearing. The vegetation becomes increasingly dense, and thick roots twist across the forest floor.

            As you approach, you notice several frightened forest animals struggling against enormous roots wrapped around their bodies. The roots pulse with concentrated mana, tightening whenever the animals attempt to escape.

            You recognize the same amber energy that radiated from the mana crystal you absorbed earlier. These roots appear to have been strengthened by the surrounding mana disturbances.

            The animals struggle desperately, but the roots show no signs of releasing them. You sense that forcing the roots apart with ordinary strength would be nearly impossible.

            However, you could channel your own mana into the roots, overwhelming their absorption capacity and forcing them to loosen their grip.",

            "companion_text" => "One of your senior cultivators kneels beside the roots. 'These plants have been transformed by the surrounding mana. They're continuously absorbing spiritual energy.'

            Another examines the trapped animals. 'If you channel enough mana into the roots, they may release their grip. But the process will consume a considerable amount of your own energy.'

            Your companions look toward you, awaiting your decision.",

            "backgrounds" => [
                "page" => null,
                "scene" => null
            ],

            "choices" => [
                "rescue_trapped_animals" => [
                    "text" => "Rescue the Trapped Animals",

                    "description" => "Channel 40 Mana into the glowing roots, forcing them to release the trapped animals.",

                    "insight_text" => "The roots will absorb 40 Mana from your reserves. However, overwhelming their absorption capacity should cause them to loosen their grip, allowing the animals to escape safely.",

                    "next" => "act2_glowing_roots_rescue",

                    "requires" => [
                        "stats" => [
                            "mana" => 40
                        ]
                    ],

                    "effects" => [
                        "stats" => [
                            "mana" => -40
                        ],
                        "inventory" => [
                            "add" => [],
                            "remove" => []
                        ],
                        "trust" => [],
                        "flags" => [
                            "act2_glowing_roots_animals_rescued" => true
                        ]
                    ],

                    "tracker_title" => "Rescued the Forest Animals",

                    "tracker_text" => "You sacrificed 40 Mana to overwhelm the mana-infused roots and free the trapped forest animals."
                ],


                "refuse_rescue_animals" => [
                    "text" => "Leave the Animals Behind",

                    "description" => "Decide not to interfere with the mana-infused roots and return to the Amber Clearing.",

                    "insight_text" => "Leaving the animals behind will preserve your Mana, but you may miss a Opportunity. Good deeds are often greatly Rewarded.",

                    "next" => "act2_zenith_clearing_return",

                    "requires" => [],

                    "effects" => [
                        "stats" => [],
                        "inventory" => [
                            "add" => [],
                            "remove" => []
                        ],
                        "trust" => [],
                        "flags" => [
                            "act2_glowing_roots_rescue_refused" => true
                        ]
                    ],

                    "tracker_title" => "Left the Animals Behind",

                    "tracker_text" => "You decided not to rescue the trapped forest animals and returned to the Amber Clearing to continue your expedition."
                ],

            ]
        ],


        "act2_glowing_roots_rescue" => [
            "title" => "Second Zenith — A Gift of Gratitude",
            "act" => 2,

            "text" => "You extend your hands toward the glowing roots and begin channeling your mana into them.

            The roots immediately respond, greedily siphoning spiritual energy from your body. Their amber glow intensifies as they absorb your mana.

            For a moment, the roots tighten even further. Then, as the energy overwhelms their capacity, the roots begin to tremble. Their grip weakens, and one by one, the trapped animals break free.

            The exhausted creatures scramble away from the roots and rush toward the safety of the forest.

            However, just before disappearing into the vegetation, one of the animals drops a small, brilliantly glowing crystal onto the forest floor.

            You approach the object and immediately recognize its appearance. It is nearly identical to the mana crystal you discovered at the center of the Amber Clearing.

            Despite its small size, the crystal radiates concentrated spiritual energy. Another opportunity to strengthen your cultivation has appeared.",

            "companion_text" => "One of your senior cultivators picks up the crystal and examines it carefully. 'Incredible. This crystal contains the same concentrated mana as the one you absorbed earlier.'

            Another cultivator smiles. 'It seems your decision to rescue those creatures has rewarded you with another cultivation opportunity.'

            Your companions step aside, allowing you to claim the crystal.",

            "backgrounds" => [
                "page" => null,
                "scene" => null
            ],

            "choices" => [
                "absorb_second_zenith" => [
                    "text" => "Grab and Absorb",

                    "description" => "Absorb the second mana crystal and strengthen your cultivation once again.",

                    "insight_text" => "This crystal contains another concentration of spiritual energy. Absorbing it will provide a second permanent cultivation boost based on your faction.",

                    "next" => "act2_zenith_path_complete",

                    "requires" => [],

                    "effects" => [
                        "stats" => [],
                        "inventory" => [
                            "add" => [],
                            "remove" => []
                        ],
                        "trust" => [],
                        "flags" => [
                            "act2_second_zenith_absorbed" => true
                        ]
                    ],

                    "tracker_title" => "Second Zenith Achieved",

                    "tracker_text" => "After rescuing the trapped forest animals, you discovered and absorbed a second mana crystal, permanently strengthening your cultivation."
                ]
            ]
        ],


        "act2_zenith_path_complete" => [
            "title" => "The End of the Zenith Path",
            "act" => 2,

            "text" => "The second mana crystal dissolves into radiant streams of spiritual energy as you absorb its power.

            A familiar surge of energy courses through your body. Your cultivation foundation strengthens once again, and the remaining mana settles within you.

            With the trapped animals rescued and the mysterious crystals absorbed, there is little left to investigate along the Zenith Path.

            You return to the Amber Clearing, where your expedition has gathered near the entrance to the Blackened Cavern.

            The cavern's entrance stretches into darkness, surrounded by jagged stone formations and vegetation corrupted by the surrounding mana disturbances.

            Unlike the unstable geyser, the energy emerging from the cavern feels strangely controlled. Its fluctuations are powerful, yet they follow an almost deliberate rhythm.

            Whatever lies beneath the earth may finally explain the disaster that brought the three kingdoms here.

            Your exploration of the Zenith Path is complete. It is time to continue the expedition.",

            "companion_text" => "One of your senior cultivators studies the cavern entrance.

            'We've investigated everything we reasonably can on the surface. The strongest remaining mana fluctuations are coming from underground.'

            Another cultivator nods.

            'Champion, our next destination is clear. We must enter the Blackened Cavern and discover what is causing these disturbances.'

            Your expedition prepares to advance.",

            "backgrounds" => [
                "page" => null,
                "scene" => null
            ],

            "choices" => [
                "enter_blackened_cavern" => [
                    "text" => "Enter the Blackened Cavern",

                    "description" => "Conclude your exploration of the Zenith Path and begin the final stage of the expedition.",

                    "insight_text" => "The Zenith Path has provided two cultivation breakthroughs. The strongest remaining mana fluctuations originate from within the Blackened Cavern. Entering will begin Act 3, where the source of the disturbance may finally be revealed.",

                    "next" => "act3_blackened_cavern_entrance",

                    "requires" => [
                        "flags" => [
                            "act2_second_zenith_absorbed" => true
                        ]
                    ],

                    "effects" => [
                        "stats" => [],
                        "inventory" => [
                            "add" => [],
                            "remove" => []
                        ],
                        "trust" => [],
                        "flags" => [
                            "act2_zenith_path_completed" => true,
                            "act3_blackened_cavern_entered" => true
                        ]
                    ],

                    "tracker_title" => "Completed the Zenith Path",

                    "tracker_text" => "After absorbing two mana crystals and rescuing the trapped forest animals, you completed your exploration of the Zenith Path and prepared to enter the Blackened Cavern."
                ]
            ]
        ],



        // Act 3

        
        "act3_blackened_cavern_entrance" => [
            "title" => "Act 3: The Blackened Cavern",
            "act" => 3,

            "text" => "Your expedition enters the Blackened Cavern. The air is thick with blue mana mist, and the cavern walls are covered in strange crystalline veins.

            As you descend, a desperate cry echoes through the darkness.

            Ahead, a Level Four cultivator lies trapped beneath a massive slab of fractured stone. Their robes are torn and blackened, with their kingdom's insignia completely obscured by dirt and blood.

            You cannot determine which kingdom they belong to.

            Unstable mana pulses through the surrounding rocks, threatening to bring the passage down.

            The injured cultivator struggles to free themselves, but their remaining strength is insufficient.

            They notice your expedition and desperately call for assistance.

            You must decide whether to risk your own safety to save this stranger or continue toward the source of the disturbance.",

            "companion_text" => "One of your senior cultivators examines the unstable passage.

            'Champion, that cultivator is badly injured. We may be able to free them, but the surrounding mana is dangerously unstable.'

            Another cultivator looks deeper into the cavern.

            'Their insignia is completely destroyed. We cannot tell which kingdom they belong to.'

            The injured cultivator calls out.

            'Please! I cannot escape on my own!'",

            "backgrounds" => [
                "page" => null,
                "scene" => null
            ],

            "choices" => [
                "rescue_injured_cultivator" => [
                    "text" => "Rescue the Injured Cultivator",

                    "description" => "Risk your own safety to free the unidentified Level Four cultivator.",

                    "insight_text" => "Rescuing this cultivator will cost 40 HP. Their identity remains unknown, but your actions may strengthen relations with another kingdom.",

                    "next" => "act3_cultivator_rescued",

                    "requires" => [
                        "stats" => [
                            "hp" => 41
                        ]
                    ],

                    "effects" => [
                        "stats" => [
                            "hp" => -40
                        ],
                        "flags" => [
                            "act3_injured_cultivator_rescued" => true
                        ]
                    ],

                    "tracker_title" => "Rescued an Injured Cultivator",
                    "tracker_text" => "You sacrificed 15 HP to rescue an unidentified Level Four cultivator trapped beneath unstable cavern debris."
                ],

                "ignore_injured_cultivator" => [
                    "text" => "Leave the Cultivator Behind",

                    "description" => "Continue deeper into the cavern without risking your expedition to rescue the stranger.",

                    "insight_text" => "Leaving the cultivator behind preserves your HP, but you will miss any information, assistance, or rewards they might have offered.",

                    "next" => "act3_fallen_expedition",

                    "requires" => [],

                    "effects" => [
                        "flags" => [
                            "act3_injured_cultivator_abandoned" => true
                        ]
                    ],

                    "tracker_title" => "Left the Cultivator Behind",
                    "tracker_text" => "You chose to continue investigating the cavern rather than risk your safety rescuing the unidentified cultivator."
                ]
            ]
        ],


        // Rescue the cultivator
        "act3_cultivator_rescued" => [
            "title" => "The Cultivator's Gratitude",
            "act" => 3,

            "text" => "With a final surge of strength, you lift the fractured stone and pull the injured cultivator to safety. The unstable mana lashes against your body, leaving you wounded.

            As the cultivator recovers, they remove their damaged cloak, revealing the insignia of their kingdom.

            'You saved my life,' they say. 'I never expected another kingdom's champion to risk their safety for me.'

            The cultivator reaches into their robes and produces a small vial containing a luminous golden liquid.

            'This is a refined cultivation elixir. I recovered it before everything went wrong. Please, accept it as my thanks.'

            You carefully drink the elixir. A tremendous wave of purified mana flows through your meridians, strengthening your cultivation foundation.

            Your cultivation rapidly advances toward the fourth level.

            The cultivator looks toward the darkness deeper within the cavern.

            'Be careful. Something powerful has awakened down there. Our expedition was completely overwhelmed.'",

            "companion_text" => "Your senior cultivator examines the empty vial.

            'An extraordinary cultivation elixir. The energy within it has accelerated your advancement considerably.'

            The rescued cultivator speaks again.

            'Whatever you encounter deeper inside, do not underestimate it.'

            Your senior cultivator turns toward you.

            'Champion, we should continue. The source of the disturbance must be close.'",

            "backgrounds" => [
                "page" => null,
                "scene" => null
            ],

            "choices" => [
                "continue_after_cultivator_rescue" => [
                    "text" => "Continue Deeper into the Cavern",

                    "description" => "Leave the rescued cultivator in safety and investigate what destroyed their expedition.",

                    "insight_text" => "Your rescue has earned the gratitude of another kingdom, and the cultivation elixir has strengthened your abilities. A powerful threat awaits deeper within the cavern.",

                    "next" => "act3_fallen_expedition",

                    "requires" => [],

                    "effects" => [
                        "flags" => [
                            "act3_cultivator_elixir_received" => true
                        ]
                    ],

                    "tracker_title" => "Received the Cultivation Elixir",
                    "tracker_text" => "After rescuing an injured cultivator, you received a powerful cultivation elixir and continued toward the source of the mana disturbance."
                ]
            ]
        ],


        "act3_fallen_expedition" => [
            "title" => "The Fallen Expedition",
            "act" => 3,

            "text" => "Your expedition ventures deeper into the Blackened Cavern. The brilliant blue mana veins along the walls grow increasingly unstable, illuminating the passage with violent pulses of energy.

            As you enter a vast underground chamber, a horrifying sight awaits.

            Bodies are scattered across the cavern floor. Broken weapons, shattered cultivation artifacts, and fragments of armor lie among the fallen.

            Several enormous trees, their roots twisted by unstable mana, have been ripped from the ground and thrown across the chamber.

            You approach one of the fallen cultivators and recognize the insignia of the Mage Kingdom.

            Examining the surrounding bodies reveals that many of these cultivators had reached Level Four.

            Whatever destroyed this expedition was powerful enough to overwhelm numerous experienced Mage cultivators.

            Deep claw marks cover the cavern walls. Massive footprints have crushed the surrounding stone, and traces of concentrated mana linger around the destruction.

            At the far end of the chamber, a brilliant blue glow pulses from somewhere beyond the darkness.

            A low, distant rumble echoes through the cavern.",

            "companion_text" => "One of your senior cultivators kneels beside a fallen Mage.

            'Level Four. And this one too. Almost everyone here had reached the fourth cultivation level.'

            Another examines the enormous claw marks along the wall.

            'These wounds were not caused by ordinary weapons. Something monstrous attacked them.'

            Your senior cultivator studies the unstable mana surrounding the chamber.

            'The Mage Kingdom must have discovered something here before the other kingdoms arrived. But whatever they attempted has clearly gone terribly wrong.'

            A deep rumble echoes through the cavern once again.

            'Champion, whatever destroyed this expedition may still be nearby.'",

            "backgrounds" => [
                "page" => null,
                "scene" => null
            ],

            "choices" => [
                "investigate_fallen_mages" => [
                    "text" => "Investigate the Fallen Cultivators",

                    "description" => "Examine the bodies and surrounding destruction for evidence of what happened.",

                    "insight_text" => "The fallen cultivators appear to have belonged to the Mage Kingdom. Their cultivation levels and the surrounding damage suggest they encountered an extraordinarily powerful mana-based creature. The intense mana signatures deeper within the cavern may reveal the source of the catastrophe.",

                    "next" => "act3_mana_beast_encounter",

                    "requires" => [],

                    "effects" => [
                        "flags" => [
                            "act3_fallen_mages_investigated" => true,
                            "act3_mage_artifact_suspicion" => true
                        ]
                    ],

                    "tracker_title" => "Investigated the Fallen Expedition",
                    "tracker_text" => "You discovered the remains of numerous Level Four Mage cultivators and evidence of a devastating mana-based creature."
                ],

                "follow_mana_disturbance" => [
                    "text" => "Follow the Mana Disturbance",

                    "description" => "Move past the fallen cultivators and follow the powerful mana signatures deeper into the cavern.",

                    "insight_text" => "The concentrated mana ahead appears connected to the destruction throughout the chamber. Proceeding will bring you closer to its source, but you may encounter whatever destroyed the Mage expedition.",

                    "next" => "act3_mana_beast_encounter",

                    "requires" => [],

                    "effects" => [
                        "flags" => [
                            "act3_followed_mana_disturbance" => true
                        ]
                    ],

                    "tracker_title" => "Followed the Mana Disturbance",
                    "tracker_text" => "You followed the increasingly powerful mana fluctuations deeper into the Blackened Cavern."
                ]
            ]
        ],

        "act3_mana_beast_encounter" => [
            "title" => "The Heart of the Blackened Cavern",
            "act" => 3,

            "text" => "Following the increasingly violent mana fluctuations, your expedition enters an enormous underground chamber.

            At its center stands a colossal crystalline formation, radiating brilliant blue energy. Ancient symbols pulse across its surface, and enormous streams of mana flow outward through the cavern walls.

            You recognize the unmistakable signature of the ancient mana artifact that brought the three kingdoms into this expedition.

            But something is terribly wrong.

            Shattered Mage Kingdom cultivation equipment surrounds the crystal. Broken containment pillars and destroyed sealing formations lie scattered across the chamber.

            The truth becomes clear.

            The Mage Kingdom discovered the artifact long before the other kingdoms arrived. They attempted to contain and harness its power, but the artifact's energy exceeded their control.

            Their failed containment caused the massive mana fluctuations detected across the three kingdoms.

            And now, standing directly before the artifact, is the consequence of their failure.

            An enormous beast formed from corrupted mana towers above the shattered containment equipment. Brilliant blue energy courses through its body, and its claws carve deep fractures into the surrounding stone.

            The creature slowly turns toward your expedition.

            Its eyes ignite with concentrated mana.

            'ROOOOOAAAAARRRR!'

            The entire cavern trembles.

            The beast charges.",

            "companion_text" => "Your senior cultivator stares at the enormous crystal.

            'The artifact... It was here all along.'

            Another examines the shattered containment formations.

            'The Mage Kingdom tried to control it. Their failed experiment caused the disturbances that brought us here.'

            The mana beast releases another deafening roar.

            'Champion! That creature is drawing power from the artifact itself!'

            Your senior cultivator draws their weapon.

            'We cannot retreat now. If that monster escapes the cavern, the consequences could be catastrophic.'

            'Prepare yourself. This is our final battle.'",

            "backgrounds" => [
                "page" => null,
                "scene" => null
            ],

            "choices" => [
                "confront_mana_beast" => [
                    "text" => "Confront the Mana Beast",

                    "description" => "Face the Level Four mana beast guarding the ancient artifact.",

                    "insight_text" => "The mana beast is an extremely dangerous Level Four opponent with 200 HP and 15 Strength. Prepare your healing items before engaging. Defeat will end your expedition permanently, without another attempt.",

                    "next" => "act3_mana_beast_battle",

                    "requires" => [],

                    "effects" => [
                        "flags" => [
                            "act3_mana_artifact_discovered" => true,
                            "act3_mage_containment_failure_discovered" => true,
                            "act3_mana_beast_confronted" => true
                        ]
                    ],

                    "tracker_title" => "Confronted the Mana Beast",
                    "tracker_text" => "You discovered that the Mage Kingdom's failed attempt to contain the ancient artifact caused the mana catastrophe, and prepared to face the corrupted mana beast."
                ]
            ]
        ],


        "act3_mana_beast_battle" => [
            "title" => "The Final Battle",
            "act" => 3,

            "text" => "The Corrupted Mana Beast stands between your expedition and the ancient mana artifact. The final battle has begun.",

            "companion_text" => "Your senior cultivators prepare themselves for the confrontation.",

            "backgrounds" => [
                "page" => null,
                "scene" => null
            ],

            "choices" => []
        ],

        // Endings

        "act3_artifact_decision" => [
            "title" => "The Fate of the Ancient Artifact",
            "act" => 3,

            "text" => "The Corrupted Mana Beast releases one final roar before collapsing onto the shattered cavern floor.

            The violent mana surges begin to subside.

            Before you stands the enormous crystalline artifact, its brilliant blue light illuminating the ruined containment chamber.

            The Mage Kingdom had discovered this artifact long before the other kingdoms arrived. Their attempt to harness its power caused the catastrophic mana disturbance that threatened all three kingdoms.

            Now, with the creature defeated, the artifact is finally within your reach.

            Your expedition gathers around the ancient crystal.

            The decision you make here will determine the future of your kingdom and the balance of power between all three kingdoms.",

            "companion_text" => "Your senior cultivator approaches the ancient crystal.

            'Champion, we have accomplished what the Mage Kingdom could not. The artifact is ours to claim.'

            Another cultivator studies the fading mana fluctuations.

            'But we must consider the consequences. This artifact has already caused tremendous destruction.'

            Your senior cultivator turns toward you.

            'The decision belongs to you, Champion. What shall we do with the artifact?'",

            "backgrounds" => [
                "page" => null,
                "scene" => null
            ],

            "choices" => [
                "claim_ancient_artifact" => [
                    "text" => "Claim the Artifact for Your Kingdom",

                    "description" => "Secure the ancient mana artifact and return it to your kingdom.",

                    "insight_text" => "Claiming the artifact will secure a decisive victory for your kingdom. However, the artifact's immense power may alter the balance between the three kingdoms.",

                    "next" => "act3_faction_victory",

                    "requires" => [],

                    "effects" => [
                        "flags" => [
                            "act3_artifact_claimed" => true,
                            "act3_faction_victory" => true
                        ]
                    ],

                    "tracker_title" => "Claimed the Ancient Artifact",
                    "tracker_text" => "You defeated the Corrupted Mana Beast and claimed the ancient artifact for your kingdom."
                ],

                "relinquish_artifact_claim" => [
                    "text" => "Relinquish Your Claim",

                    "description" => "Refuse to claim the ancient artifact despite defeating its guardian.",

                    "insight_text" => "Relinquishing your claim prevents your kingdom from obtaining the artifact. Although you defeated the mana beast, your expedition will be considered unsuccessful in securing its objective.",

                    "next" => "act3_faction_defeat",

                    "requires" => [],

                    "effects" => [
                        "flags" => [
                            "act3_artifact_relinquished" => true,
                            "act3_faction_defeat" => true
                        ]
                    ],

                    "tracker_title" => "Relinquished the Artifact",
                    "tracker_text" => "You defeated the Corrupted Mana Beast but chose to relinquish your kingdom's claim to the ancient artifact."
                ],

                "unlock_secret_ending" => [
                    "text" => "Secret Ending",

                    "description" => "???",

                    "insight_text" => "Something remains undiscovered/undone. Reconsider the alliances you formed and the path of cultivation you followed.",

                    "next" => "act3_secret_ending",

                    "requires" => [],

                    "effects" => [
                        "flags" => [
                            "act3_secret_ending_unlocked" => true
                        ]
                    ],

                    "tracker_title" => "An Unknown Destiny",
                    "tracker_text" => "Your decisions throughout the expedition revealed a hidden possibility beyond the ordinary fate of the three kingdoms."
                ]
            ]
        ],


        "act3_faction_victory" => [
            "title" => "Ending: Faction Victory",
            "act" => 3,
            "location" => "Blackened Cavern",
            "text" => [
                "The Corrupted Mana Beast has fallen. With the ancient artifact finally secured, your expedition has accomplished what the three kingdoms believed might be impossible.",

                "You return to your kingdom carrying the artifact and the promise of a new era of power. Your leaders celebrate your victory, recognizing you as the champion who changed the course of history.",

                "Yet beyond your kingdom's borders, the other factions watch with uncertainty. The balance of power has shifted, and although your kingdom has emerged victorious, the future of the three kingdoms remains uncertain.",

                "Your journey has ended in triumph, but the consequences of your victory will echo throughout the realm."
            ],
            "choices" => [],
            "is_ending" => true,
            "ending_type" => "faction_victory"
        ],

        "act3_faction_defeat" => [
            "title" => "Ending: Faction Defeat",
            "act" => 3,
            "location" => "Blackened Cavern",
            "text" => [
                "The expedition has reached its conclusion, but the ancient artifact will not be returning to your kingdom.",

                "Whether through defeat at the hands of the Corrupted Mana Beast or the decision to relinquish your claim, your kingdom's objective remains unfulfilled.",

                "News of the failed expedition spreads throughout the realm. Your kingdom must now face an uncertain future without the power it had hoped to secure.",

                "The other kingdoms continue their pursuit of dominance, and the tensions that first brought the three factions into conflict remain unresolved.",

                "Your journey has ended, but the struggle for the future of the three kingdoms continues."
            ],
            "choices" => [],
            "is_ending" => true,
            "ending_type" => "faction_defeat"
        ],

        "act3_secret_ending" => [
            "title" => "Secret Ending: The Threefold Accord",
            "act" => 3,
            "location" => "Blackened Cavern",

            "text" => [
                "The Corrupted Mana Beast has fallen, and the ancient artifact rests before you. Its power is greater than anything the three kingdoms have encountered, yet you recognize that claiming it for a single kingdom would only deepen the divisions between them.",

                "Throughout your journey, you earned the trust of the Warriors, Mages, and Rogues. You completed the Zenith Path, absorbed both Zenith crystals, and demonstrated that the power of the realm need not belong to any one faction.",

                "Drawing upon the energy of the Zenith crystals, you stabilize the ancient artifact. Instead of claiming its power for your kingdom, you propose an unprecedented agreement: the artifact will be protected through the cooperation of all three kingdoms.",

                "Your proposal is met with hesitation. Generations of rivalry cannot be forgotten in a single moment. Yet the trust you have established gives the leaders of each kingdom a reason to listen.",

                "The Warriors pledge their strength to defend the artifact. The Mages agree to study and preserve its ancient knowledge. The Rogues offer their intelligence and vigilance to ensure that no kingdom secretly attempts to seize its power.",

                "Together, the three kingdoms establish the Threefold Accord, an alliance founded upon shared responsibility rather than conquest.",

                "For the first time in generations, the future of the realm is no longer determined by which kingdom possesses the greatest power, but by what they can accomplish together.",

                "Your journey ends not as the champion of a single kingdom, but as the champion who united all three."
            ],

            "choices" => [],
            "is_ending" => true,
            "ending_type" => "threefold_accord"
        ],








        // Lore

         // Three Kingdoms Lore
        "warrior_kingdom_lore" => [
            "title" => "The Warrior Kingdom",
            "act" => 1,

            "text" => "The Warrior Kingdom was founded upon the belief that strength, discipline, and perseverance are the foundations of lasting prosperity.

                During the early age of cultivation, powerful warrior clans united their territories under a single military command. Their alliance eventually developed into the kingdom that exists today.

                Unlike Mages who rely primarily on complex magical techniques, Warrior cultivators focus on strengthening their bodies, refining their weapons, and mastering the flow of mana through physical combat.

                The kingdom's military academies train cultivators from a young age, emphasizing endurance, loyalty, and the responsibility that accompanies great strength.

                Throughout its history, the Warrior Kingdom has defended its borders against rival factions and dangerous mana-corrupted creatures.

                Its leaders believe that maintaining military superiority is essential to protecting their people.

                However, this philosophy has also contributed to tensions with the Mage and Rogue Kingdoms, whose methods of cultivation and governance differ considerably.

                Despite these differences, the Warrior Kingdom remains one of the three great powers maintaining the world's fragile balance.",

            "backgrounds" => [
                "page" => null,
                "scene" => null
            ],

            "choices" => [
                "return_from_warrior_lore" => [
                    "text" => "Return to the Kingdom",

                    "description" => "Finish studying the Warrior Kingdom's history and return to your previous activities.",

                    "insight_text" => "You have gained a better understanding of the Warrior Kingdom's military traditions and cultivation philosophy.",

                    "next" => "act1_kingdom_return",

                    "requires" => [],

                    "effects" => [
                        "flags" => [
                            "learned_warrior_history" => true
                        ]
                    ],

                    "tracker_title" => "Warrior Kingdom History",

                    "tracker_text" => "You studied the Warrior Kingdom's origins, military traditions, and philosophy of physical cultivation."
                ]
            ]
        ],
        "mage_kingdom_lore" => [
            "title" => "The Mage Kingdom",
            "act" => 1,

            "text" => "The Mage Kingdom traces its origins to ancient scholars who devoted their lives to understanding the mysterious energy known as mana.

                These early researchers discovered that mana could be manipulated through carefully constructed techniques, allowing cultivators to produce extraordinary effects without relying entirely on physical strength.

                Over generations, their discoveries led to the establishment of magical academies, research institutions, and powerful cultivation organizations.

                Eventually, these institutions united to form the Mage Kingdom.

                Unlike the Warrior Kingdom, which emphasizes physical refinement, Mage cultivators focus on expanding their spiritual cores, increasing their mana capacity, and mastering increasingly complex magical techniques.

                The kingdom's greatest scholars study ancient artifacts, forgotten civilizations, and the fundamental principles governing the world's mana.

                Their research has produced remarkable advances in magical formations, defensive barriers, and methods of concentrating ambient mana.

                However, the Mage Kingdom's pursuit of knowledge has occasionally brought it into conflict with the other kingdoms, particularly when powerful artifacts or rare cultivation resources are discovered.

                Its leaders believe that understanding the nature of mana is essential to securing the future of civilization.

                Today, the Mage Kingdom remains one of the world's three great powers, balancing extraordinary magical knowledge against the military strength and covert influence of its rivals.",

            "backgrounds" => [
                "page" => null,
                "scene" => null
            ],

            "choices" => [
                "return_from_mage_lore" => [
                    "text" => "Return to the Kingdom",

                    "description" => "Finish studying the Mage Kingdom's history and return to your previous activities.",

                    "insight_text" => "Understanding the Mage Kingdom's research traditions may provide valuable context for the mysterious mana fluctuations affecting the world.",

                    "next" => "act1_kingdom_return",

                    "requires" => [],

                    "effects" => [
                        "flags" => [
                            "learned_mage_history" => true
                        ]
                    ],

                    "tracker_title" => "Mage Kingdom History",

                    "tracker_text" => "You studied the Mage Kingdom's origins, magical research institutions, and philosophy of spiritual cultivation."
                ]
            ]
        ],
        "rogue_kingdom_lore" => [
            "title" => "The Rogue Kingdom",
            "act" => 1,

            "text" => "The Rogue Kingdom emerged from an alliance of independent clans that survived through secrecy, intelligence, and precise military operations.

                During the early age of cultivation, these clans occupied territories that lacked the military resources of the Warrior Kingdom and the magical institutions of the Mage Kingdom.

                Rather than confronting stronger opponents directly, they developed techniques emphasizing speed, concealment, and the ability to strike at an enemy's weaknesses.

                Over time, their cooperation evolved into an organized kingdom supported by extensive intelligence networks and highly trained covert operatives.

                Rogue cultivators specialize in agility, precision, and controlling mana through rapid, carefully executed movements.

                Their training emphasizes awareness, adaptability, and the importance of choosing the right moment to act.

                The kingdom's intelligence organizations gather information about rival factions, dangerous creatures, and unusual disturbances in the world's mana.

                Although outsiders frequently associate the Rogue Kingdom with assassination and deception, its leaders view intelligence and secrecy as necessary tools for protecting their independence.

                The kingdom's methods have occasionally created distrust among the other factions, particularly when its operatives are discovered investigating sensitive territories.

                Nevertheless, the Rogue Kingdom has maintained its position as one of the world's three great powers.

                Its continued independence demonstrates that knowledge, precision, and strategy can rival overwhelming physical or magical strength.",

            "backgrounds" => [
                "page" => null,
                "scene" => null
            ],

            "choices" => [
                "return_from_rogue_lore" => [
                    "text" => "Return to the Kingdom",

                    "description" => "Finish studying the Rogue Kingdom's history and return to your previous activities.",

                    "insight_text" => "You have gained a better understanding of the Rogue Kingdom's intelligence networks and covert cultivation techniques.",

                    "next" => "act1_kingdom_return",

                    "requires" => [],

                    "effects" => [
                        "flags" => [
                            "learned_rogue_history" => true
                        ]
                    ],

                    "tracker_title" => "Rogue Kingdom History",

                    "tracker_text" => "You studied the Rogue Kingdom's origins, intelligence networks, and philosophy of precision-based cultivation."
                ]
            ]
        ],

        "act1_mana_disaster_explanation" => [
            "title" => "Understanding Mana Disasters",
            "act" => 1,

            "text" => "Before the briefing concludes, you raise a question.

                'What exactly is a mana disaster?'

                One of your superiors pauses before offering an explanation.

                'A mana disaster is a natural catastrophe caused or intensified by an uncontrolled concentration of mana.'

                'Under ordinary circumstances, mana exists throughout the environment. Cultivators can absorb and manipulate it, while the Three Kingdoms maintain systems for regulating its concentration within their controlled territories.'

                'However, when ambient mana accumulates beyond what the surrounding environment can safely sustain, it becomes unstable.'

                'That instability can manifest in several ways. Violent mana storms can tear through entire regions. Sudden surges of concentrated energy can trigger devastating explosions, while disturbances beneath the earth can produce powerful earthquakes.'

                'In extreme cases, the surrounding environment itself becomes dangerous, as uncontrolled mana continues to gather and react unpredictably.'

                'Unlike an ordinary natural disaster, however, a mana disaster can sometimes be contained before it reaches its most destructive stage.'

                'Experienced cultivators can disperse accumulated mana, redirect its flow, or use specialized formations to reduce the concentration within the affected region.'

                'By lowering the ambient mana density to a manageable level, it is possible to stabilize the environment and prevent further destruction.'

                The explanation continues.

                'The Three Kingdoms have spent generations developing methods to regulate mana within their borders. Their major settlements and inner territories are protected by carefully maintained systems that prevent dangerous concentrations from forming.'

                'Mana disasters are therefore much more likely to occur in remote regions, abandoned facilities, and territories where these systems are absent or poorly maintained.'

                'Even when a disaster begins within one kingdom's territory, its effects may spread far beyond that kingdom's borders.'

                'A powerful mana storm does not recognize political boundaries. Neither do the earthquakes, explosions, or other disturbances that may follow.'

                'For this reason, the Three Kingdoms established a mutual disaster-response treaty.'

                'Under this agreement, all three kingdoms are obligated to assist in containing major mana disasters, regardless of which kingdom controls the affected territory.'

                'The treaty exists because allowing such disasters to spread would ultimately threaten everyone.'

                'Political rivalries may continue, but preventing a widespread mana catastrophe is a responsibility shared by all three kingdoms.'",

            "companion_text" => "Your superior returns their attention to the mission briefing.

                'That brings us to the situation near the Mage Kingdom.'

                'An unusually large concentration of unstable mana has developed in a remote region of its outer territory. The disturbance is continuing to intensify, and there is a serious risk that it could spread into surrounding lands.'

                'Representatives from all three kingdoms are being dispatched to investigate the cause and assist with containment.'

                'Your assignment is to accompany your two Level 4 senior companions to the affected region. You will help investigate the disturbance while the senior cultivators coordinate the containment effort.'

                'At Level 3, you possess sufficient cultivation to participate in this mission, but you must remain cautious. The unstable mana may produce dangers that cannot be predicted in advance.'

                Your superior gives you a final look.

                'You have been briefed on the situation. Report to your companions and prepare for departure.'",

            "backgrounds" => [
                "page" => null,
                "scene" => null
            ],

            "choices" => [
                "accept_mana_disaster_mission" => [
                    "text" => "Accept the Mission",

                    "description" => "Finish the briefing and meet your two Level 4 senior companions before departing.",

                    "insight_text" => "You now understand the dangers of uncontrolled mana and why the Three Kingdoms must cooperate. Accepting the mission will advance the main story.",

                    "next" => "act1_mission_departure",

                    "requires" => [
                        "stats" => [
                            "level" => 3
                        ]
                    ],

                    "effects" => [],

                    "tracker_title" => "Understanding the Mana Disaster",

                    "tracker_text" => "After learning about mana disasters and the Three Kingdoms' mutual assistance treaty, you accepted the mission to investigate the disturbance near the Mage Kingdom."
                ]
            ]
        ],












    ];
}
