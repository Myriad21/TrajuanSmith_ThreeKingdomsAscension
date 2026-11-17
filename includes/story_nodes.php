
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


            "text" => "The Mana-Corrupted Wolf collapses to the ground, its final growl fading into the silence of the surrounding forest.

            Your two senior companions approach curiously, examining the fallen creature. The dark mana surrounding its body slowly begins to dissipate, leaving behind traces of an unfamiliar corruption.

            One of your companions kneels beside the beast, studying the lingering energy.

            'This corruption is no ordinary disturbance,' they warn. 'Something deeper within these ruins may be responsible.'

            The other senior turns toward the path ahead, their expression growing serious.

            Although the immediate threat has been eliminated, the encounter raises troubling questions about the forces affecting this region.

            With the path now clear, your expedition prepares to continue deeper into the ancient ruins.",

            "backgrounds" => [
                "page" => null,
                "scene" => null
            ],

            "choices" => [
                "continue_exploration" => [
                    "text" => "Explore Deeper Into the Ruins",

                    "description" => "Continue investigating the ancient ruins alongside your senior companions.",

                    "insight_text" => "The wolf's corruption suggests that something unusual is affecting this region. Continuing the investigation may reveal its source.",

                    "next" => "ruins_deeper_exploration",

                    "requires" => [],

                    "effects" => [],

                    "tracker_title" => "Exploring the Ancient Ruins",

                    "tracker_text" => "You continued the expedition alongside your two Level 4 senior companions."
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

            Compared to your own Level 1 cultivation, the difference is overwhelming. The mana flowing through their bodies is far denser and more refined than anything you can currently control. Even their simplest techniques demonstrate a level of mastery that remains far beyond your reach.

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

                    "next" => "first_rival_encounter",

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

        "text" => "Remembering the intelligence reports you investigated before leaving your kingdom, you decide to examine the surrounding ruins before approaching the ancient structure.

        Your two senior companions initially appear more interested in the powerful mana emanating from the structure, but they agree that investigating the surrounding area would be a sensible precaution.

        Moving carefully between the enormous stone pillars, your group searches for signs of recent activity.

        It does not take long for your caution to prove worthwhile.

        Beyond a partially collapsed wall, you notice several figures moving through the ruins. Their movements are deliberate, and their equipment appears far too well maintained for ordinary travelers.

        You quietly alert your senior companions.

        One of them raises a hand, signaling for everyone to remain still. A faint wave of mana spreads outward from their position as the senior examines the distant figures.

        Their expression changes almost immediately.

        'Three cultivators,' the senior whispers. 'Two of them have reached Level 4. The third is considerably weaker, but their cultivation is still developing.'

        Your other companion studies the figures carefully before turning toward you.

        'It appears another kingdom has sent an expedition of its own. They must have followed the same rumors that brought us here.'

        You observe the distant group more closely.

        The two senior cultivators move with the confidence of experienced powerhouses, occasionally examining the ancient structures with techniques similar to those demonstrated by your own companions.

        Between them stands a younger cultivator, apparently accompanying the expedition in much the same capacity as you.

        Although you cannot yet determine their intentions, their presence confirms that the search for the ancient artifact is no longer limited to your kingdom.

        Fortunately, the rival expedition remains unaware of your presence.

        Your senior companions turn toward you, waiting to see how you wish to proceed.

        For the moment, you possess an advantage that the rival champion does not: you know they are here, but they do not know about you.",

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

                "insight_text" => "The rival expedition has not noticed your presence. A surprise attack could deal 40 damage before combat begins, but such an aggressive action will severely damage relations between your kingdoms.",

                "next" => "rival_scouting",

                "requires" => [],

                "effects" => [
                    "flags" => [
                        "rival_surprise_attack" => true
                    ],
                    "trust" => [
                        "first_rival" => -20
                    ],
                    
                ],

                "tracker_title" => "Ambushing the Rival Champion",

                "tracker_text" => "You chose to launch a surprise attack against the unsuspecting rival expedition."
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











    ];
}
