
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

                    "next" => "ancient_structure_approach",

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
                "warrior" => "You recognize the distinctive robes and arcane equipment of the Mage Kingdom.

                The expedition consists of two Level 4 senior cultivators and a Level 2 champion carrying a staff. Faint magical energy gathers around the younger cultivator's hands.",

                "mage" => "You recognize the armor and military insignia of the Warrior Kingdom.

                The expedition consists of two Level 4 senior cultivators and a Level 2 champion carrying a sword. The younger cultivator moves with the discipline of a trained soldier.",

                "rogue" => "You recognize the dark equipment and concealed weapons of the Rogue Kingdom.

                The expedition consists of two Level 4 senior cultivators and a Level 2 champion carrying a dagger. The younger cultivator moves with remarkable precision."
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
                        "flags" => [
                            "act1_rival_defeated" => true
                        ]
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
            "title" => "The Rival Expedition",
            "act" => 1,

            "conditional_text" => [
                [
                    "requires" => [
                        "flags" => [
                            "approached_rivals_first" => true
                        ]
                    ],

                    "text" => "Having discovered the rival expedition before being noticed, you and your two senior companions step out from behind the ancient stone pillars.

                    The distant cultivators immediately turn toward your group. Their two senior members move forward cautiously, positioning themselves between you and the younger champion.

                    'We mean no harm,' one of your companions announces. 'We are investigating these ruins and wish to speak with you.'

                    The rival expedition exchanges surprised glances. They clearly had not expected another group to approach them so openly.

                    For the moment, you have taken the initiative in this encounter."
                ],

                [
                    "requires" => [
                        "flags" => [
                            "approached_rivals_first" => false
                        ]
                    ],

                    "text" => "As you and your senior companions approach the ancient structure, a powerful voice suddenly echoes from behind a nearby stone pillar.

                    'Hold your position.'

                    Three figures emerge from the surrounding ruins, blocking your expedition's path.

                    Two of them radiate the unmistakable pressure of Level 4 cultivators. Between them stands a younger champion whose attention immediately settles upon you.

                    Your senior companions step forward, carefully observing the unexpected visitors.

                    The rival expedition has discovered you first, leaving you little opportunity to determine their intentions before the confrontation begins."
                ]
            ],

            "text" => "For several moments, neither expedition makes another move.

            The two groups carefully assess one another, their senior cultivators exchanging measured glances.

            Although no weapons have been drawn, the concentration of mana gathering around the experienced cultivators makes the tension unmistakable.

            One of your senior companions finally breaks the silence.

            'It appears we are not the only ones investigating this place.'

            A senior from the opposing expedition responds with a cautious nod.

            'Indeed. We have traveled a considerable distance to reach these ruins. It seems our kingdoms have developed an interest in the same mystery.'

            The younger rival champion steps forward, studying you with an expression that is difficult to interpret.

            Despite belonging to different kingdoms, the two of you occupy remarkably similar positions. Each has been entrusted with accompanying powerful senior cultivators on a mission that may influence the future of your homeland.

            Whatever happens next, this encounter may shape the relationship between your kingdoms.",

            "backgrounds" => [
                "page" => null,
                "scene" => null
            ],

            "choices" => []
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











    ];
}
