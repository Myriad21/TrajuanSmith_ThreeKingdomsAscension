<?php
    session_start();

    // Require authentication before accessing the game.
    if (!isset($_SESSION["user"])) {
        header("Location: login.php");
        exit;
    }

    require_once __DIR__ . "/includes/story_nodes.php";
    require_once __DIR__ . "/includes/game_functions.php";
    require_once __DIR__ . "/includes/save_functions.php";
    require_once __DIR__ . "/includes/combat_functions.php";

    $pageTitle = "Your Adventure";


    $pageTitle = "Your Adventure";

    // Require a valid champion before entering the game.
    if (
        !isset($_SESSION["champion"]) ||
        !is_array($_SESSION["champion"])
    ) {
        header("Location: character.php");
        exit;
    }




    // Reset the adventure while preserving champion identity.
    if (
        $_SERVER["REQUEST_METHOD"] === "POST" &&
        ($_POST["game_action"] ?? "") === "reset_adventure"
    ) {
        // Preserve the champion's original name and faction.
        $name = $_SESSION["champion"]["name"];
        $faction = $_SESSION["champion"]["faction"];

        // Recreate the champion with starting stats and relationships.
        $_SESSION["champion"] = createChampion($name, $faction);

        // Reset all adventure progress.
        $_SESSION["story_node"] = "introduction";
        $_SESSION["story_flags"] = [];
        $_SESSION["inventory"] = [];
        $_SESSION["choices_log"] = [];

        // Clear previous decisions and encounters.
        unset(
            $_SESSION["last_choice_summary"],
            $_SESSION["combat"]
        );

        // Overwrite the saved adventure with the reset state.
        savePlayerProgress(collectPlayerProgress());

        // Redirect to prevent repeating the reset on refresh.
        header("Location: game.php");
        exit;
    }






    // Retrieve the champion's information.
    $champion = $_SESSION["champion"];

    $championName = $champion["name"];
    $championFaction = $champion["faction"];
    $championLevel = $champion["level"];

    
    $championHP = $champion["hp"];
    $championMaxHP = $champion["max_hp"];

    $championStrength = $champion["strength"];

    $championMana = $champion["mana"];
    $championMaxMana = $champion["max_mana"];


    // Load the story definitions.
    $storyNodes = getStoryNodes();

    if (!isset($_SESSION["inventory"])) {
        $_SESSION["inventory"] = [];
    }


    // Initialize persistent story flags.
    if (!isset($_SESSION["story_flags"])) {
        $_SESSION["story_flags"] = [];
    }


    // Apply the wolf ambush only once when entering the encounter.
    if (
        ($_SESSION["story_node"] ?? null) === "expedition_deeper" &&
        empty($_SESSION["story_flags"]["wolf_ambush_resolved"])
    ) {
        $wasWarned = !empty(
            $_SESSION["story_flags"]["mana_beast_warning"]
        );

        if (!$wasWarned) {
            $_SESSION["champion"]["hp"] = max(
                0,
                (int) $_SESSION["champion"]["hp"] - 12
            );
        }

        // Record that this encounter's ambush has been processed.
        $_SESSION["story_flags"]["wolf_ambush_resolved"] = true;

        // Save the updated HP and ambush flag.
        savePlayerProgress(collectPlayerProgress());


        // Refresh the displayed HP after updating the session.
        $championHP = $_SESSION["champion"]["hp"];
    }


    // Equip an owned weapon without advancing the story.
    if (
        $_SERVER["REQUEST_METHOD"] === "POST" &&
        ($_POST["game_action"] ?? "") === "equip_weapon"
    ) {
        $weaponId = $_POST["weapon_id"] ?? null;

        if (
            is_string($weaponId) &&
            canEquipWeapon(
                $weaponId,
                $_SESSION["champion"]["faction"],
                $_SESSION["inventory"]
            )
        ) {
            $_SESSION["champion"]["equipped_weapon"] = $weaponId;

            // Save the champion's updated equipment selection.
            savePlayerProgress(collectPlayerProgress());
        }

        // Prevent duplicate submissions on refresh.
        header("Location: game.php");
        exit;
    }


    // Initialize the player's story position if needed.
    if (!isset($_SESSION["story_node"])) {
        $_SESSION["story_node"] = "introduction";
    }

    // Retrieve the current story node.
    $currentNodeId = $_SESSION["story_node"];

    // Fall back to the introduction if the saved node is invalid.
    if (!is_string($currentNodeId) || !isset($storyNodes[$currentNodeId])) {
        $currentNodeId = "introduction";
        $_SESSION["story_node"] = $currentNodeId;
    }

    $currentNode = $storyNodes[$currentNodeId];

    // Process a player's story choice.
    if ($_SERVER["REQUEST_METHOD"] === "POST") {

        $choiceId = $_POST["choice"] ?? null;

        // Only accept choices belonging to the current scene.
        if (
            is_string($choiceId) &&
            isset($currentNode["choices"][$choiceId])
        ) {
            $selectedChoice = $currentNode["choices"][$choiceId];

            // Validate requirements on the server.
            $requirements = $selectedChoice["requires"] ?? [];


            if (
                $choiceId === "unlock_secret_ending" &&
                !meetsThreefoldAccordRequirements(
                    $_SESSION["champion"],
                    $_SESSION["story_flags"]
                )
            ) {
                header("Location: game.php");
                exit;
            }


            if (
                !is_array($requirements) ||
                !meetsChoiceRequirements(
                    $_SESSION["champion"],
                    $_SESSION["inventory"],
                    $_SESSION["story_flags"],
                    $requirements
                )
            ) {
                // Reject the locked choice without changing the story.
                header("Location: game.php");
                exit;
            }

            // Only unlocked choices can advance.
            $nextNodeId = $selectedChoice["next"];


            // Makes sure the destination scene exists.
            
            if (
                is_string($nextNodeId) &&
                isset($storyNodes[$nextNodeId])
            ) {
                // Retrieve the selected choice's stat effects.
                $effects = $selectedChoice["effects"] ?? [];


                // Apply the First Zenith cultivation reward.
                if (
                    $currentNodeId === "act2_first_zenith" &&
                    $choiceId === "absorb_first_zenith" &&
                    empty($_SESSION["story_flags"]["act2_first_zenith_absorbed"])
                ) {
                    $faction = strtolower(
                        $_SESSION["champion"]["faction"] ?? ""
                    );

                    switch ($faction) {
                        case "warrior":
                            $effects["stats"]["max_hp"] = 5;
                            $effects["stats"]["strength"] = 5;
                            break;

                        case "rogue":
                            $effects["stats"]["strength"] = 2;
                            $effects["stats"]["max_mana"] = 30;
                            break;

                        case "mage":
                            $effects["stats"]["max_mana"] = 75;
                            break;
                    }
                }


                // Apply the Second Zenith cultivation reward.
                if (
                    $currentNodeId === "act2_glowing_roots_rescue" &&
                    $choiceId === "absorb_second_zenith" &&
                    empty($_SESSION["story_flags"]["act2_second_zenith_absorbed"])
                ) {
                    $faction = strtolower(
                        $_SESSION["champion"]["faction"] ?? ""
                    );

                    switch ($faction) {
                        case "warrior":
                            $effects["stats"]["max_hp"] = 10;
                            $effects["stats"]["strength"] = 10;
                            $effects["stats"]["mana"] = 75;

                            break;

                        case "rogue":
                            $effects["stats"]["strength"] = 5;
                            $effects["stats"]["max_mana"] = 50;
                            break;

                        case "mage":
                            $effects["stats"]["max_mana"] = 75;
                            break;
                    }
                }



                // Give the player their faction-specific expedition weapon.
                if (
                    $currentNodeId === "explore_path" &&
                    $choiceId === "take_weapon" &&
                    empty($_SESSION["story_flags"]["path_weapon_collected"])
                ) {
                    $weapon = getExpeditionWeapon(
                        $_SESSION["champion"]["faction"]
                    );

                    if ($weapon !== null) {
                        // Add the weapon through the existing inventory system.
                        $effects["inventory"]["add"][] = $weapon["id"];
                    }
                }

                $championBefore = $_SESSION["champion"];
                $inventoryBefore = $_SESSION["inventory"];
                $flagsBefore = $_SESSION["story_flags"];



                // Apply valid effects to the champion.
                if (is_array($effects)) {

                    $updatedState = applyStoryConsequences(
                        $_SESSION["champion"],
                        $_SESSION["inventory"],
                        $_SESSION["story_flags"],
                        $effects
                    );

                    $_SESSION["champion"] = $updatedState["champion"];
                    $_SESSION["inventory"] = $updatedState["inventory"];
                    $_SESSION["story_flags"] = $updatedState["flags"];

                    // Successful Zenith negotiation establishes 90 trust.
                    if (
                        $currentNodeId === "act2_geyser_rival_negotiation" &&
                        $choiceId === "propose_geyser_cooperation"
                    ) {
                        $playerFaction = $_SESSION["champion"]["faction"];

                        $rivalFaction = resolveRelationshipTarget(
                            "geyser_rival",
                            $playerFaction
                        );

                        if (
                            $rivalFaction !== null &&
                            $rivalFaction !== $playerFaction
                        ) {
                            $_SESSION["champion"]["relationships"][$rivalFaction] = 90;
                        }
                    }
                }

                // Save the player's state AFTER the decision.
                $championAfter = $_SESSION["champion"];
                $inventoryAfter = $_SESSION["inventory"];
                $flagsAfter = $_SESSION["story_flags"];

                // Generate a summary using the actual stat changes.
                $consequenceSummary = getChoiceConsequenceSummary(
                    $championBefore,
                    $championAfter,
                    $inventoryBefore,
                    $inventoryAfter
                );
                
                // Initialize the decision history if necessary.
                if (
                    !isset($_SESSION["choices_log"]) ||
                    !is_array($_SESSION["choices_log"])
                ) {
                    $_SESSION["choices_log"] = [];
                }

                // Record the player's decision.
                $_SESSION["choices_log"][] = [
                    "scene" => $currentNodeId,
                    "act" => $currentNode["act"],
                    "scene_title" => $selectedChoice["tracker_title"]
                        ?? $currentNode["title"],
                    "choice" => $choiceId,
                    "choice_text" => $selectedChoice["tracker_text"]
                        ?? $selectedChoice["text"]
                ];


                // Remember the latest decision and its consequences.
                $_SESSION["last_choice_summary"] = [
                    "choice" => $selectedChoice["text"],
                    "consequences" => $consequenceSummary
                ];

                
                // Advance to the next scene.
                $_SESSION["story_node"] = $nextNodeId;

                
                // Act 3: Reward the rescue of an unidentified cultivator.
                if (
                    $currentNodeId === "act3_blackened_cavern_entrance" &&
                    $choiceId === "rescue_injured_cultivator" &&
                    $nextNodeId === "act3_cultivator_rescued" &&
                    empty($_SESSION["story_flags"]["act3_cultivator_rescue_rewarded"])
                ) {
                    $rescuedFaction = getLowestTrustFaction(
                        $championBefore
                    );

                    if ($rescuedFaction !== null) {
                        // Preserve the rescued cultivator's identity.
                        $_SESSION["story_flags"]["act3_rescued_cultivator_faction"] =
                            $rescuedFaction;

                        // Raise that kingdom's trust to at least 90.
                        $currentTrust = (int) (
                            $_SESSION["champion"]["relationships"][$rescuedFaction] ?? 0
                        );

                        $_SESSION["champion"]["relationships"][$rescuedFaction] =
                            max(90, $currentTrust);
                    }

                    // The elixir advances the champion to at least Level 4.
                    $currentLevel = (int) (
                        $_SESSION["champion"]["level"] ?? 1
                    );

                    if ($currentLevel < 4) {
                        $_SESSION["champion"] = levelUpChampion(
                            $_SESSION["champion"],
                            4 - $currentLevel
                        );
                    }

                    // Award the rescue benefits only once.
                    $_SESSION["story_flags"]["act3_cultivator_elixir_received"] = true;
                    $_SESSION["story_flags"]["act3_cultivator_rescue_rewarded"] = true;
                }


                // Save the updated champion, inventory, story flags,
                // and Story Path Tracker before redirecting.
                savePlayerProgress(collectPlayerProgress());

                // Start the wolf encounter when the player chooses to fight.
                if (
                    $currentNodeId === "expedition_deeper" &&
                    $choiceId === "fight_wolf"
                ) {
                    // Clear any previous combat session.
                    unset($_SESSION["combat"]);

                    // Redirect to the combat interface.
                    header("Location: combat.php");
                    exit;
                }


                // Start the Act 1 rival champion encounter.
                if (
                    $currentNodeId === "rival_ambush" &&
                    $choiceId === "fight_rival"
                ) {
                    // Determine the Act 1 rival based on the player's faction.
                    $rivalFaction = getFirstRival(
                        $_SESSION["champion"]["faction"]
                    );

                    if ($rivalFaction !== null) {

                        // Check whether the player previously chose an ambush.
                        $ambush = !empty(
                            $_SESSION["story_flags"]["rival_surprise_attack"]
                        );

                        // Clear any previous battle.
                        unset($_SESSION["combat"]);

                        // Start the Level 2 rival encounter.
                        startRivalCombat($rivalFaction, 2, $ambush);

                        // Open the combat interface.
                        header("Location: combat.php");
                        exit;
                    }
                }

                // Start combat when the rival intercepts the player.
                if (
                    $currentNodeId === "act1_rival_interception" &&
                    $choiceId === "defend_against_rival"
                ) {
                    $rivalFaction = getFirstRival(
                        $_SESSION["champion"]["faction"]
                    );

                    if ($rivalFaction !== null) {

                        // The player did not successfully ambush the rival.
                        $ambush = false;

                        // Save the player's state before combat begins.
                        $_SESSION["combat_checkpoint"] = [
                            "champion" => $_SESSION["champion"],
                            "inventory" => $_SESSION["inventory"] ?? []
                        ];

                        // Clear any previous combat session.
                        unset($_SESSION["combat"]);

                        // Start the existing Level 2 rival encounter.
                        startRivalCombat($rivalFaction, 2, $ambush);

                        // The rival lands a surprise attack before normal combat begins.
                        $surpriseDamage = 20;

                        $currentHP = (int) $_SESSION["champion"]["hp"];

                        $actualDamage = min($surpriseDamage, max(0, $currentHP));

                        $_SESSION["champion"]["hp"] = max(
                            0,
                            $currentHP - $actualDamage
                        );

                        // Record the opening attack in the combat log.
                        $_SESSION["combat"]["log"][] =
                            "The rival champion catches you off guard and deals "
                            . $actualDamage
                            . " surprise damage!";

                        // Prevent duplicate opening attacks.
                        $_SESSION["combat"]["rival_opening_attack_applied"] = true;

                        // Save the updated HP and combat encounter.
                        savePlayerProgress(collectPlayerProgress());

                        // Redirect to the combat interface.
                        header("Location: combat.php");
                        exit;
                    }
                }

                
                // Start combat when the player challenges the Act 2 geyser rival.
                if (
                    $currentNodeId === "act2_geyser_rival_negotiation" &&
                    $choiceId === "fight_geyser_rival"
                ) {
                    // Retrieve the rivals eligible for this encounter.
                    $availableRivals = getAct2GeyserRivals(
                        $_SESSION["champion"],
                        $_SESSION["story_flags"]
                    );

                    // Identify the rival assigned to the player's faction.
                    $rivalFaction = resolveRelationshipTarget(
                        "geyser_rival",
                        $_SESSION["champion"]["faction"]
                    );

                    
                    // Never start combat against an unavailable rival.
                    if (
                        $rivalFaction === null ||
                        !in_array($rivalFaction, $availableRivals, true)
                    ) {
                        error_log(
                            "Act 2 geyser combat unavailable for faction: " .
                            $_SESSION["champion"]["faction"]
                        );

                        header("Location: game.php");
                        exit;
                    }

                    // Preserve the champion and inventory for combat retries.
                    $_SESSION["combat_checkpoint"] = [
                        "champion" => $_SESSION["champion"],
                        "inventory" => $_SESSION["inventory"] ?? []
                    ];

                    // Clear any previous encounter.
                    unset($_SESSION["combat"]);

                    // Initialize the Level 3 rival champion.
                    startRivalCombat($rivalFaction, 3, false);

                    // Mark this as the Act 2 Zenith rival encounter.
                    $_SESSION["combat"]["encounter"] = "act2_zenith_rival";

                    // Redirect to the combat page.
                    header("Location: combat.php");
                    exit;
                }



                // Start the Act 3 final boss encounter.
                if (
                    $currentNodeId === "act3_mana_beast_encounter" &&
                    $choiceId === "confront_mana_beast"
                ) {
                    // Preserve the champion and inventory before combat.
                    $_SESSION["combat_checkpoint"] = [
                        "champion" => $_SESSION["champion"],
                        "inventory" => $_SESSION["inventory"] ?? []
                    ];

                    // Clear any previous combat session.
                    unset($_SESSION["combat"]);

                    // Initialize the final boss.
                    startCombat("corrupted_mana_beast");

                    // Identify this encounter as the Act 3 final battle.
                    $_SESSION["combat"]["encounter"] = "act3_final_boss";

                    // Save story progress before entering combat.
                    savePlayerProgress(collectPlayerProgress());

                    // Redirect to the existing combat interface.
                    header("Location: combat.php");
                    exit;
                }


                // Start a practice battle against the training dummy.
                if (
                    $currentNodeId === "act1_training_dummy" &&
                    $choiceId === "begin_dummy_training"
                ) {
                    // Clear any previous battle so training starts fresh.
                    unset($_SESSION["combat"]);

                    // Initialize the harmless training dummy encounter.
                    startCombat("training_dummy");

                    // Open the existing combat interface.
                    header("Location: combat.php");
                    exit;
                }


                // Prevent duplicate form submissions.
                header("Location: game.php");
                exit;

            }

        }
    }


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?php echo htmlspecialchars($pageTitle); ?> | Three Kingdoms Ascension</title>

    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="assets/css/navigation.css">
    <link rel="stylesheet" href="assets/css/game.css">
    <link rel="stylesheet" href="assets/css/insight_relic.css">

</head>

<body>
    <header class="site-header site-header--compact">
        <h1>Three Kingdoms Ascension</h1>

        <nav aria-label="Main navigation">
            <a href="leaderboard.php">Leaderboard</a>
            <a href="logout.php">Logout</a>
        </nav>
    </header>

    <main class="game-main">
       
        <div class="game-layout">
            <!-- Main Game Display -->
            <section class="game-interface">

                <!-- Champion Information Panel -->
                <div class="game-champion">

                    <div class="game-champion__identity">
                        <div>
                            <h2>
                                Champion:
                                <?php echo htmlspecialchars($championName); ?>
                            </h2>

                            <p>
                                <?php echo htmlspecialchars(ucfirst($championFaction)); ?>
                                | Level
                                <?php echo htmlspecialchars((string) $championLevel); ?>
                            </p>
                        </div>



                        <!-- Adventure Reset -->
                        <form
                            action="game.php"
                            method="POST"
                            class="game-reset-form"
                            onsubmit="return confirm('Reset your adventure? All story progress, inventory, and combat progress will be lost. Your champion name and faction will be preserved.');"
                        >
                            <input
                                type="hidden"
                                name="game_action"
                                value="reset_adventure"
                            >

                            <button type="submit" class="game-reset-button">
                                Reset Adventure
                            </button>
                        </form>


                        <!-- Inventory Display -->
                        <details class="inventory-dropdown">
                            <summary class="inventory-toggle">
                                Inventory
                            </summary>

                            <section class="inventory-section">
                                <h3>Your Inventory</h3>

                                <?php if (empty($_SESSION["inventory"])): ?>
                                    <p>Your inventory is empty.</p>
                                <?php else: ?>
                                    
                                <ul class="inventory-list">
                                    <?php foreach ($_SESSION["inventory"] as $itemId): ?>
                                        <?php
                                            $weapon = getWeapon($itemId);

                                            $isEquipped = (
                                                $champion["equipped_weapon"] ?? null
                                            ) === $itemId;
                                        ?>

                                        <li class="inventory-item">

                                            <?php if ($weapon !== null): ?>

                                                <div class="inventory-item__details">
                                                    <strong>
                                                        <?= htmlspecialchars($weapon["name"]) ?>
                                                    </strong>

                                                    <span>
                                                        +<?= (int) $weapon["damage_bonus"] ?>
                                                        Damage
                                                    </span>
                                                </div>

                                                <?php if ($isEquipped): ?>

                                                    <span class="inventory-item__equipped">
                                                        Equipped
                                                    </span>

                                                <?php elseif (canEquipWeapon(
                                                    $itemId,
                                                    $championFaction,
                                                    $_SESSION["inventory"]
                                                )): ?>

                                                    <form action="game.php" method="POST">
                                                        <input
                                                            type="hidden"
                                                            name="game_action"
                                                            value="equip_weapon"
                                                        >

                                                        <input
                                                            type="hidden"
                                                            name="weapon_id"
                                                            value="<?= htmlspecialchars($itemId) ?>"
                                                        >

                                                        <button type="submit">
                                                            Equip
                                                        </button>
                                                    </form>

                                                <?php endif; ?>

                                            <?php else: ?>

                                                <span>
                                                    <?= htmlspecialchars(
                                                        ucwords(str_replace("_", " ", $itemId))
                                                    ) ?>
                                                </span>

                                            <?php endif; ?>

                                        </li>
                                    <?php endforeach; ?>
                                </ul>

                                <?php endif; ?>
                            </section>
                        </details>
                    </div>

                    <!-- Champion Statistics -->
                    <div class="game-champion__stats">

                        <div class="game-champion__stat">
                            <span>Health (HP)</span>
                            <strong>
                                <?php echo htmlspecialchars((string) $championHP); ?> 
                                /
                                <?php echo htmlspecialchars((string) $championMaxHP); ?> 
                            </strong>
                        </div>

                        <div class="game-champion__stat">
                            <span>Strength</span>
                            <strong>
                                <?php echo htmlspecialchars((string) $championStrength); ?>
                            </strong>
                        </div>

                        <div class="game-champion__stat">
                            <span>Mana</span>
                            <strong>
                                <?php echo htmlspecialchars((string) $championMana); ?>
                                /
                                <?php echo htmlspecialchars((string) $championMaxMana); ?>
                            </strong>
                        </div>

                    </div>

                </div>
               
                <!-- Dynamic Story Narration -->
                <div class="game-story">
                    <h2>
                        <?= htmlspecialchars($currentNode["title"]) ?>
                    </h2>

                    <!-- Conditional narration based on previous decisions -->
                    <?php foreach ($currentNode["conditional_text"] ?? [] as $entry): ?>
                        <?php
                            $requiredFlags = $entry["requires"]["flags"] ?? [];
                            $matches = true;

                            foreach ($requiredFlags as $flagName => $expectedValue) {
                                if (
                                    ($_SESSION["story_flags"][$flagName] ?? false) !== $expectedValue
                                ) {
                                    $matches = false;
                                    break;
                                }
                            }
                        ?>

                        <?php if ($matches): ?>
                            <p>
                                <?= nl2br(htmlspecialchars($entry["text"])) ?>
                            </p>
                        <?php endif; ?>
                    <?php endforeach; ?>

                    <!-- Shared story narration -->
                    <p>
                        
<?php
    $storyText = $currentNode["text"] ?? "";

    if (is_array($storyText)) {
        $storyText = implode("\n\n", $storyText);
    }

    echo nl2br(htmlspecialchars($storyText));
?>

                    </p>

                    <!-- Faction-specific story narration -->
                    <?php
                        $factionNarration =
                            $currentNode["faction_text"][$championFaction] ?? null;
                    ?>

                    <?php if (is_string($factionNarration) && $factionNarration !== ""): ?>
                        <p>
                            <?= nl2br(htmlspecialchars($factionNarration)) ?>
                        </p>
                    <?php endif; ?>

                    <!-- Expedition companions narration -->
                    <?php if (!empty($currentNode["companion_text"])): ?>
                        <p>
                            <?= nl2br(htmlspecialchars($currentNode["companion_text"])) ?>
                        </p>
                    <?php endif; ?>

                </div>

                <!-- Post-Choice Consequence Summary -->
                <?php
                    // Retrieve the most recent decision summary.
                    $lastChoiceSummary = $_SESSION["last_choice_summary"] ?? null;

                    // Clear the pending notification after retrieving it.
                    unset($_SESSION["last_choice_summary"]);
                ?>


                <?php if (is_array($lastChoiceSummary)): ?>
                    <section
                        class="game-consequences game-consequences--notification"
                        id="consequence-notification"
                        role="status"
                        aria-label="Decision consequences">

                        <div class="game-consequences__header">
                            <h2>Decision Recorded</h2>
                        </div>


                        <p class="game-consequences__choice">
                            You chose:
                            <strong>
                                <?= htmlspecialchars($lastChoiceSummary["choice"]) ?>
                            </strong>
                        </p>

                        <?php if (!empty($lastChoiceSummary["consequences"])): ?>

                            <div class="game-consequences__effects">

                                <?php foreach ($lastChoiceSummary["consequences"] as $effect): ?>

                                    <span class="game-consequences__effect game-consequences__effect--<?= htmlspecialchars($effect["type"]) ?>">
                                        <?= htmlspecialchars($effect["text"]) ?>
                                    </span>

                                <?php endforeach; ?>

                            </div>

                        <?php else: ?>

                            <p class="game-consequences__empty">
                                Your decision has shaped the path ahead.
                            </p>

                        <?php endif; ?>

                    </section>
                <?php endif; ?>

                <!-- Choices --->
                <?php if (!empty($currentNode["choices"])): ?>
                    <section class="game-choices" aria-labelledby="choices-heading">
                        <h2 id="choices-heading">Choose Your Path</h2>

                        <div class="game-choices__grid">
                            
                            
                            <?php $choiceIndex = 0; ?>

                            
                            <?php foreach ($currentNode["choices"] as $choiceId => $choice): ?>

                                <?php
                                    // Hide rival tracks only when no eligible
                                    // expedition can appear at the geyser.
                                    if (
                                        $choiceId === "identify_rival_tracks" &&
                                        empty(getAct2GeyserRivals(
                                            $champion,
                                            $_SESSION["story_flags"]
                                        ))
                                    ) {
                                        continue;
                                    }

                                    $choiceIndex++;
                                ?>



                                <?php
                                // Retrieve this choice's requirements.
                                $requirements = $choice["requires"] ?? [];

                                // Determine whether the champion meets them.
                                $isUnlocked = meetsChoiceRequirements(
                                    $champion,
                                    $_SESSION["inventory"],
                                    $_SESSION["story_flags"],
                                    $requirements
                                );


                                if ($choiceId === "unlock_secret_ending") {
                                    $isUnlocked = meetsThreefoldAccordRequirements(
                                        $champion,
                                        $_SESSION["story_flags"]
                                    );
                                }


                                // Determine whether this exploration location was completed.
                                $explorationFlags = [
                                    "explored_markings",
                                    "explored_path",
                                    "explored_mana"
                                ];

                                $isAlreadyExplored = false;

                                foreach ($explorationFlags as $flag) {
                                    if (
                                        isset($requirements["flags"][$flag]) &&
                                        $requirements["flags"][$flag] === false &&
                                        ($_SESSION["story_flags"][$flag] ?? false) === true
                                    ) {
                                        $isAlreadyExplored = true;
                                        break;
                                    }
                                }

                                $choiceEffects = $choice["effects"] ?? [];

                                $statPreviews = getChoiceStatPreviews(
                                    is_array($choiceEffects) ? $choiceEffects : []
                                );

                                ?>

                                
                                <?php
                                    $hideRivalChoice = false;
                                ?>

                                <form
                                    action="game.php"
                                    method="POST"
                                    class="game-choice"
                                    style="--choice-index: <?= $choiceIndex ?>; <?= $hideRivalChoice ? 'visibility: hidden; pointer-events: none;' : '' ?>"
                                    <?= $hideRivalChoice ? 'inert aria-hidden="true"' : '' ?>
                                >

                                    <input
                                        type="hidden"
                                        name="choice"
                                        value="<?php echo htmlspecialchars($choiceId); ?>"
                                    >

                                    <button
                                        type="submit"
                                        class="game-choice__button<?php echo $isUnlocked ? '' : ' game-choice__button--locked'; ?>"
                                        <?php echo $isUnlocked ? '' : 'disabled'; ?>
                                    >
                                        <strong>
                                            <?php echo htmlspecialchars($choice["text"]); ?>
                                        </strong>

                                        <span>
                                            <?php echo htmlspecialchars($choice["description"]); ?>
                                        </span>

                                        <!-- Potential Stats Preview--->
                                        <?php if (!empty($statPreviews)): ?>
                                            <span class="game-choice__effects">

                                                <?php foreach ($statPreviews as $preview): ?>
                                                    <span class="game-choice__effect game-choice__effect--<?= htmlspecialchars($preview["type"]) ?>">
                                                        <?= htmlspecialchars($preview["text"]) ?>
                                                    </span>
                                                <?php endforeach; ?>

                                            </span>
                                        <?php endif; ?>

                                        <?php if (!$isUnlocked): ?>
                                            <span class="game-choice__requirement">

                                                <?php foreach ($requirements["stats"] ?? [] as $stat => $minimum): ?>
                                                    <?php
                                                        $current = $champion[$stat] ?? 0;
                                                        $missing = max(0, $minimum - $current);
                                                    ?>

                                                    <?php if ($missing > 0): ?>
                                                        <span class="game-choice__requirement-detail">
                                                            <?= htmlspecialchars(ucfirst($stat)) ?>:
                                                            <?= htmlspecialchars((string) $current) ?>
                                                            /
                                                            <?= htmlspecialchars((string) $minimum) ?>

                                                            <small>
                                                                (Need <?= htmlspecialchars((string) $missing) ?> more)
                                                            </small>
                                                        </span>
                                                    <?php endif; ?>

                                                <?php endforeach; ?>

                                               
                                                <?php if ($isAlreadyExplored): ?>

                                                    <span class="game-choice__requirement-detail">
                                                        This location has already been explored.
                                                    </span>

                                                <?php elseif (
                                                    !empty($requirements["inventory"]) ||
                                                    !empty($requirements["flags"]) ||
                                                    !empty($requirements["trust"])
                                                ): ?>

                                                    <span class="game-choice__requirement-detail">
                                                        Additional story conditions may be required.
                                                    </span>

                                                <?php endif; ?>


                                            </span>
                                        <?php endif; ?>

                                    </button>
                                </form>

                            <?php endforeach; ?>

                        </div>
                        
                    </section>
                <?php endif; ?>


                <!-- Insight Relic Adviser -->
                <section class="insight-relic" aria-labelledby="insight-relic-heading">

                    <div class="insight-relic__header">
                        <h2 id="insight-relic-heading">Insight Relic</h2>
                        <p>Ancient guidance for the path ahead</p>
                    </div>

                    <div class="insight-relic__content">

                        <!-- Default message -->
                        <p class="insight-relic__default">
                            The relic hums softly. Examine a possible path
                            to reveal its guidance.
                        </p>

                        <!-- Choice-specific guidance -->
                        <?php $adviceIndex = 0; ?>

                        <?php foreach ($currentNode["choices"] ?? [] as $choiceId => $choice): ?>


                            <?php
                                // Keep Insight Relic guidance consistent
                                // with the rival-track choice visibility.
                                if (
                                    $choiceId === "identify_rival_tracks" &&
                                    empty(getAct2GeyserRivals(
                                        $champion,
                                        $_SESSION["story_flags"]
                                    ))
                                ) {
                                    continue;
                                }
                            ?>


                            <?php $adviceIndex++; ?>


                            <?php
                                $customInsight = $choice["insight_text"] ?? "";

                                // Retrieve the player's previous story decisions.
                                $choicesLog = $_SESSION["choices_log"] ?? [];

                                // Generate an Insight Relic prediction using
                                // the current choice effects and decision history.
                                $automaticInsight = getInsightRelicHint(
                                    $choice["effects"] ?? [],
                                    $choicesLog
                                );

                                $requirements = $choice["requires"] ?? [];

                                // Retrieve relationship changes for this choice.
                                $trustEffects = $choice["effects"]["trust"] ?? [];

                                // Store relationship tiers using actual faction names.
                                $relationshipTiers = [];

                                $playerFaction = $champion["faction"] ?? "";

                                if (is_array($trustEffects)) {

                                    foreach ($trustEffects as $target => $change) {

                                        // Convert aliases such as first_rival
                                        // into the actual faction name.
                                        $rivalFaction = resolveRelationshipTarget(
                                            $target,
                                            $playerFaction
                                        );

                                        // Ignore invalid targets and the player's own faction.
                                        if (
                                            $rivalFaction === null ||
                                            $rivalFaction === $playerFaction
                                        ) {
                                            continue;
                                        }

                                        // Retrieve the current relationship tier.
                                        $currentTier = getRivalRelationshipStatus(
                                            $champion,
                                            $rivalFaction
                                        );

                                        if ($currentTier !== null) {
                                            $relationshipTiers[$rivalFaction] = $currentTier;
                                        }
                                    }
                                }

                                $isInsightUnlocked = meetsChoiceRequirements(
                                    $champion,
                                    $_SESSION["inventory"],
                                    $_SESSION["story_flags"],
                                    $requirements
                                );


                                if ($choiceId === "unlock_secret_ending") {
                                    $isInsightUnlocked = meetsThreefoldAccordRequirements(
                                        $champion,
                                        $_SESSION["story_flags"]
                                    );
                                }


                            ?>

                            <div class="insight-relic__advice"
                                data-choice="<?= htmlspecialchars($choiceId) ?>"
                                style="--advice-index: <?= $adviceIndex ?>"
                                >

                                <?php if (!empty($relationshipTiers)): ?>

                                    <div class="insight-relic__relationships">

                                        <?php foreach ($relationshipTiers as $target => $tier): ?>

                                            <div class="insight-relic__relationship">

                                                <span class="insight-relic__relationship-name">
                                                    <?= htmlspecialchars(
                                                        ucwords(str_replace("_", " ", $target))
                                                    ) ?>
                                                </span>

                                                <span class="insight-relic__relationship-tier"
                                                    data-tier="<?= htmlspecialchars($tier) ?>">
                                                    <?= htmlspecialchars($tier) ?>
                                                </span>

                                            </div>

                                        <?php endforeach; ?>

                                    </div>

                                <?php endif; ?>

                                <?php if ($customInsight !== ""): ?>
                                    <p class="insight-relic__custom">
                                        <?= htmlspecialchars($customInsight) ?>
                                    </p>
                                <?php endif; ?>

                                <?php if ($automaticInsight !== null): ?>
                                    <?php
                                        $isCultivationPrediction =
                                            (int) ($choice["effects"]["special"]["level_up"] ?? 0) > 0;
                                    ?>

                                    <p class="insight-relic__automatic<?= $isCultivationPrediction ? ' insight-relic__automatic--cultivation' : '' ?>">
                                        <?= htmlspecialchars($automaticInsight) ?>
                                    </p>
                                <?php endif; ?>

                                <?php
                                    $isCompletedExploration = false;

                                    foreach ([
                                        "explored_markings",
                                        "explored_path",
                                        "explored_mana"
                                    ] as $flag) {
                                        if (
                                            isset($requirements["flags"][$flag]) &&
                                            $requirements["flags"][$flag] === false &&
                                            ($_SESSION["story_flags"][$flag] ?? false) === true
                                        ) {
                                            $isCompletedExploration = true;
                                            break;
                                        }
                                    }
                                ?>

                              
                                <?php if (!$isInsightUnlocked): ?>
                                    <div class="insight-relic__locked">

                                        <?php if ($isCompletedExploration): ?>

                                            <p class="insight-relic__locked-title">
                                                Location Already Explored
                                            </p>

                                            <p class="insight-relic__locked-detail">
                                                You have already investigated this location.
                                                There is nothing more to discover here.
                                            </p>

                                        <?php else: ?>

                                            <p class="insight-relic__locked-title">
                                                Path Currently Unavailable
                                            </p>
                                        


                                        <?php foreach (($requirements["stats"] ?? []) as $stat => $minimum): ?>
                                            <?php
                                                $current = $champion[$stat] ?? 0;

                                                if (!is_numeric($minimum) || $current >= $minimum) {
                                                    continue;
                                                }

                                                $missing = $minimum - $current;
                                                $statName = ucfirst($stat);
                                            ?>

                                            <p class="insight-relic__locked-detail">
                                                Requires <?= htmlspecialchars((string) $minimum) ?>
                                                <?= htmlspecialchars($statName) ?>.
                                                Your current <?= htmlspecialchars($statName) ?>
                                                is <?= htmlspecialchars((string) $current) ?>,
                                                so you need <?= htmlspecialchars((string) $missing) ?> more.
                                            </p>
                                        <?php endforeach; ?>

                                        <?php foreach (($requirements["inventory"] ?? []) as $itemId): ?>

                                            <?php
                                                if (
                                                    !is_string($itemId) ||
                                                    in_array($itemId, $_SESSION["inventory"], true)
                                                ) {
                                                    continue;
                                                }

                                                // Convert item IDs into readable names.
                                                $itemName = ucwords(
                                                    str_replace("_", " ", $itemId)
                                                );
                                            ?>

                                            <p class="insight-relic__locked-detail">
                                                This path requires
                                                <?= htmlspecialchars($itemName) ?>,
                                                which is not currently in your inventory.
                                            </p>

                                        <?php endforeach; ?>

                                        <?php
                                            $missingStoryCondition = false;

                                            foreach (($requirements["flags"] ?? []) as $flag => $expected) {

                                                if (
                                                    !is_string($flag) ||
                                                    !is_bool($expected) ||
                                                    ($_SESSION["story_flags"][$flag] ?? false) !== $expected
                                                ) {
                                                    $missingStoryCondition = true;
                                                    break;
                                                }
                                            }
                                        ?>

                                        <?php if ($missingStoryCondition): ?>
                                            <p class="insight-relic__locked-detail">
                                                This path depends on an earlier discovery
                                                or decision that has not been fulfilled.
                                            </p>
                                        <?php endif; ?>

                                        <?php
                                            $missingTrustRequirement = false;

                                            foreach (($requirements["trust"] ?? []) as $target => $minimumTrust) {

                                                $resolvedTarget = resolveRelationshipTarget(
                                                    $target,
                                                    $champion['faction']
                                                );

                                                $currentTrust = $champion["relationships"][$resolvedTarget] ?? 0;

                                                if ($currentTrust < $minimumTrust) {
                                                    $missingTrustRequirement = true;
                                                    break;
                                                }
                                            }
                                        ?>

                                        <?php if ($missingTrustRequirement): ?>
                                            <p class="insight-relic__locked-detail">
                                                This path requires a stronger relationship
                                                with another champion. Build their trust
                                                through your decisions before attempting it.
                                            </p>
                                        <?php endif; ?>


                                    <?php endif; ?>
                                    </div>
                                <?php endif; ?>


                            </div>

                        <?php endforeach; ?>

                    </div>

                </section>

            </section>

            <!-- Story Path Tracker Sidebar -->
            <aside class="game-tracker" aria-labelledby="tracker-heading">
                <h2 id="tracker-heading">Story Path Tracker</h2>

                <div class="game-tracker__history">
                    <?php
                    $choicesLog = $_SESSION["choices_log"] ?? [];
                    ?>

                    <?php if (empty($choicesLog)): ?>
                        <p>Your journey has just begun.</p>
                    <?php else: ?>
                        <ol class="game-tracker__list">
                            <?php foreach ($choicesLog as $entry): ?>
                                <li class="game-tracker__entry">
                                    <strong>
                                        <?php echo htmlspecialchars($entry["scene_title"]); ?>
                                    </strong>

                                    <span>
                                        <?php echo htmlspecialchars($entry["choice_text"]); ?>
                                    </span>
                                </li>
                            <?php endforeach; ?>
                        </ol>
                    <?php endif; ?>
                </div>
            </aside>

        </div>

    </main>

    <footer>
        <p>Three Kingdoms Ascension — Web Development Project 2</p>
    </footer>
</body>
</html>
