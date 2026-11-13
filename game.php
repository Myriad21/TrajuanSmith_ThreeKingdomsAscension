
<?php
    session_start();

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

                <!-- Temporary story placeholder -->
                <div class="game-story">
                    <h2>Your Adventure Begins</h2>
                    <p>
                        Your champion's journey through the Three Kingdoms
                        is about to begin.
                    </p>
                </div>

            </section>

            <!-- Story Path Tracker Sidebar -->
            <aside class="game-tracker" aria-labelledby="tracker-heading">
                <h2 id="tracker-heading">Story Path Tracker</h2>

                <div class="game-tracker__history">
                    <p>Your journey has just begun.</p>
                </div>
            </aside>
        </div>

    </main>

    <footer>
        <p>Three Kingdoms Ascension — Web Development Project 2</p>
    </footer>
</body>
</html>
