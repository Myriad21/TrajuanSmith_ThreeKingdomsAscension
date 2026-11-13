
<?php
session_start();

if (!isset($_SESSION["champion"])) {
    header("Location: character.php");
    exit;
}

$champion = $_SESSION["champion"];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Champion Confirmation — Three Kingdoms Ascension</title>

    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="assets/css/character.css">
</head>

<body>
    <header class="site-header site-header--compact">
        <h1>Three Kingdoms Ascension</h1>

        <nav aria-label="Main navigation">
            <!-- Authentication controls will be added later. -->
        </nav>
    </header>

    <main>
    
        <section class="champion-confirmation">

            <div class="champion-confirmation__heading">
                <h2>Your Champion's Record</h2>

                <p>
                    Your champion has been created.
                    Review your character before beginning your journey.
                </p>
            </div>

            <?php if (
                isset($_GET["started"]) &&
                $_GET["started"] === "1" &&
                !empty($champion["adventure_started"])
            ): ?>
                <p class="champion-confirmation__status" role="status">
                    Your champion is confirmed!
                    The adventure is ready to begin.
                </p>
            <?php endif; ?>

            <div class="champion-confirmation__identity">
                <div>
                    <span class="champion-confirmation__label">
                        Champion Name
                    </span>

                    <h3>
                        <?php echo htmlspecialchars($champion["name"]); ?>
                    </h3>
                </div>

                <div>
                    <span class="champion-confirmation__label">
                        Faction
                    </span>

                    <p class="champion-confirmation__faction">
                        <?php echo htmlspecialchars(ucfirst($champion["faction"])); ?>
                    </p>
                </div>
            </div>

            <div class="champion-confirmation__stats">
                <dl>
                    <div>
                        <dt>Health (HP)</dt>
                        <dd><?php echo $champion["hp"]; ?></dd>
                    </div>

                    <div>
                        <dt>Strength</dt>
                        <dd><?php echo $champion["strength"]; ?></dd>
                    </div>

                    <div>
                        <dt>Mana</dt>
                        <dd><?php echo $champion["mana"]; ?></dd>
                    </div>

                    <div>
                        <dt>Starting Level</dt>
                        <dd><?php echo $champion["level"]; ?></dd>
                    </div>
                </dl>
            </div>

            <p class="champion-confirmation__closing">
                Your decisions will determine the future of the three kingdoms.
            </p>

            <div class="champion-confirmation__actions">

                <form action="reset_character.php" method="post">
                    <button
                        type="submit"
                        class="champion-confirmation__back"
                    >
                        Back to Character Creation
                    </button>
                </form>

                <form action="start_adventure.php" method="post">
                    <button
                        type="submit"
                        class="champion-confirmation__begin"
                    >
                        Begin Adventure
                    </button>
                </form>

            </div>

        </section>

    </main>

    <footer>
        <p>Three Kingdoms Ascension — Web Development Project 2</p>
    </footer>
</body>
</html>
