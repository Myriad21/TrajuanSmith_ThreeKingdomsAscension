
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

                // Apply valid effects to the champion.
                if (is_array($effects)) {
                    $updatedState = applyStoryConsequences(
                        $_SESSION["champion"],
                        $_SESSION["inventory"],
                        $effects
                    );

                    $_SESSION["champion"] = $updatedState["champion"];
                    $_SESSION["inventory"] = $updatedState["inventory"];
                }
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

                <!-- Choices --->
                <?php if (!empty($currentNode["choices"])): ?>
                    <section class="game-choices" aria-labelledby="choices-heading">
                        <h2 id="choices-heading">Choose Your Path</h2>

                        <div class="game-choices__grid">
                            
                            <?php foreach ($currentNode["choices"] as $choiceId => $choice): ?>

                                <?php
                                // Retrieve this choice's requirements.
                                $requirements = $choice["requires"] ?? [];

                                // Determine whether the champion meets them.
                                $isUnlocked = meetsChoiceRequirements(
                                    $champion,
                                    $requirements
                                );
                                ?>

                                <form action="game.php" method="POST" class="game-choice">
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

                                        <?php if (!$isUnlocked): ?>
                                            <span class="game-choice__requirement">

                                                <?php foreach ($requirements as $stat => $minimum): ?>
                                                    <?php
                                                    $current = $champion[$stat] ?? 0;
                                                    $missing = max(0, $minimum - $current);
                                                    ?>

                                                    <span class="game-choice__requirement-detail">
                                                        <?php echo htmlspecialchars(ucfirst($stat)); ?>:
                                                        <?php echo htmlspecialchars((string) $current); ?>
                                                        /
                                                        <?php echo htmlspecialchars((string) $minimum); ?>

                                                        <?php if ($missing > 0): ?>
                                                            <small>
                                                                (Need <?php echo htmlspecialchars((string) $missing); ?> more)
                                                            </small>
                                                        <?php endif; ?>
                                                    </span>
                                                <?php endforeach; ?>
                                            </span>
                                        <?php endif; ?>

                                    </button>
                                </form>

                            <?php endforeach; ?>

                        </div>
                        
                    </section>
                <?php endif; ?>

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
