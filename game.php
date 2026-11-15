
<?php
    session_start();
    require_once __DIR__ . "/includes/story_nodes.php";
    require_once __DIR__ . "/includes/game_functions.php";

    $pageTitle = "Your Adventure";

    // Require a valid champion before entering the game.
    if (
        !isset($_SESSION["champion"]) ||
        !is_array($_SESSION["champion"])
    ) {
        header("Location: character.php");
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

    // TEMPORARY TEST RESET — REMOVE AFTER ONE REFRESH 
    $_SESSION["story_node"] = "introduction";
    $_SESSION["choices_log"] = [];


    if (!isset($_SESSION["inventory"])) {
        $_SESSION["inventory"] = [];
    }


    // Initialize persistent story flags.
    if (!isset($_SESSION["story_flags"])) {
        $_SESSION["story_flags"] = [];
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
            <!-- Navigation will be integrated with Hien's work. -->
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
                                            <li>
                                                <?= htmlspecialchars($itemId) ?>
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
                        <?php echo htmlspecialchars($currentNode["title"]); ?>
                    </h2>

                    <p>
                        <?php echo htmlspecialchars($currentNode["text"]); ?>
                    </p>
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

                                <?php $choiceIndex++; ?>


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


                                $choiceEffects = $choice["effects"] ?? [];

                                $statPreviews = getChoiceStatPreviews(
                                    is_array($choiceEffects) ? $choiceEffects : []
                                );

                                ?>

                                <form action="game.php" method="POST" class="game-choice" style="--choice-index: <?= $choiceIndex ?>">
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

                                                <?php if (
                                                    !empty($requirements["inventory"]) ||
                                                    !empty($requirements["flags"]) ||
                                                    !empty($requirements["trust"])
                                                ): ?>
                                                    <span class="game-choice__requirement-detail">
                                                        <br>Additional story conditions may be required.
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

                            <?php $adviceIndex++; ?>


                            <?php
                                $customInsight = $choice["insight_text"] ?? "";

                                $automaticInsight = getInsightRelicHint(
                                    $choice["effects"] ?? []
                                );

                                $requirements = $choice["requires"] ?? [];

                                $isInsightUnlocked = meetsChoiceRequirements(
                                    $champion,
                                    $_SESSION["inventory"],
                                    $_SESSION["story_flags"],
                                    $requirements
                                );

                            ?>

                            <div class="insight-relic__advice"
                                data-choice="<?= htmlspecialchars($choiceId) ?>"
                                style="--advice-index: <?= $adviceIndex ?>"
                                >

                                <?php if ($customInsight !== ""): ?>
                                    <p class="insight-relic__custom">
                                        <?= htmlspecialchars($customInsight) ?>
                                    </p>
                                <?php endif; ?>

                                <?php if ($automaticInsight !== null): ?>
                                    <p class="insight-relic__automatic">
                                        <?= htmlspecialchars($automaticInsight) ?>
                                    </p>
                                <?php endif; ?>

                                <?php if (!$isInsightUnlocked): ?>
                                    <div class="insight-relic__locked">
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
