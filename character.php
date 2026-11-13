<?php
session_start();

require_once __DIR__ . "/includes/game_functions.php";

$pageTitle = "Character Creation";
$errorMessage = "";
$characterCreated = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = trim($_POST["champion_name"] ?? "");
    $faction = $_POST["faction"] ?? "";

    if ($name === "" || mb_strlen($name) > 30) {
        $errorMessage = "Enter a champion name between 1 and 30 characters.";
    } elseif (!is_string($faction)) {
        $errorMessage = "Select a valid faction.";
    } else {
        try {
            $_SESSION["champion"] = createChampion($name, $faction);
            session_regenerate_id(true);

            header("Location: character_confirm.php");
            exit;
        } catch (InvalidArgumentException $exception) {
            $errorMessage = $exception->getMessage();
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?php echo htmlspecialchars($pageTitle); ?></title>

    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="assets/css/character.css">
    <link rel="stylesheet" href="assets/css/faction_background.css">
</head>

<body>

    <!-- Faction-specific background layers -->
    <div class="faction-backgrounds" aria-hidden="true">
        <div class="faction-background faction-background--warrior"></div>
        <div class="faction-background faction-background--mage"></div>
        <div class="faction-background faction-background--rogue"></div>
    </div>

    <header class="site-header site-header--compact">
        <h1>Three Kingdoms Ascension</h1>

        <nav aria-label="Main navigation">
            <!-- Authentication and navigation controls
                will be integrated by Hien. -->
        </nav>
    </header>

    <main>
        <section>
            
            <h2>Create Your Champion</h2>

            <p>
                Before your journey begins, choose a name
                and the kingdom you will represent.
            </p>


            <?php if ($errorMessage !== ""): ?>
                <p role="alert">
                    <?php echo htmlspecialchars($errorMessage); ?>
                </p>
            <?php endif; ?>


            <form action="character.php" method="POST">

               
                <div class="champion-name-field">
                    <label for="champion_name">
                        Champion Name
                    </label>

                    <input
                        type="text"
                        id="champion_name"
                        name="champion_name"
                        placeholder="Enter your champion's name"
                        minlength="1"
                        maxlength="30"
                        autocomplete="off"
                        required
                    >
                </div>

                <!--Choose your faction-->
                <fieldset class="faction-selection">
                    <legend>Select Your Faction</legend>

                    <div class="faction-grid">

                        <label class="faction-card faction-card--warrior">
                            <input
                                type="radio"
                                name="faction"
                                value="warrior"
                                required
                            >

                            <span class="faction-card__name">Warrior</span>

                            <span class="faction-card__description">
                                High health and strength
                            </span>

                            <span class="faction-card__indicator" aria-hidden="true"></span>
                        </label>

                        <label class="faction-card faction-card--mage">
                            <input
                                type="radio"
                                name="faction"
                                value="mage"
                            >

                            <span class="faction-card__name">Mage</span>

                            <span class="faction-card__description">
                                Powerful mana abilities
                            </span>

                            <span class="faction-card__indicator" aria-hidden="true"></span>
                        </label>

                        <label class="faction-card faction-card--rogue">
                            <input
                                type="radio"
                                name="faction"
                                value="rogue"
                            >

                            <span class="faction-card__name">Rogue</span>

                            <span class="faction-card__description">
                                Precise and agile fighting style
                            </span>

                            <span class="faction-card__indicator" aria-hidden="true"></span>
                        </label>

                    </div>
                </fieldset>

                <!--Preview Stats-->
                <div class="stats-preview">
                    <h3>Starting Statistics Preview</h3>

                    <p class="stats-preview__placeholder">
                        Select a faction to reveal your starting statistics.
                    </p>

                    <?php foreach (getStartingStats() as $faction => $stats): ?>
                        <div class="stats-preview__group stats-preview__group--<?php echo htmlspecialchars($faction); ?>">

                            <h4>
                                <?php echo htmlspecialchars(ucfirst($faction)); ?> Starting Statistics
                            </h4>

                            <div class="stats-preview__grid">
                                <div class="stats-preview__stat">
                                    <span>Health (HP)</span>
                                    <strong><?php echo $stats["hp"]; ?></strong>
                                </div>

                                <div class="stats-preview__stat">
                                    <span>Strength</span>
                                    <strong><?php echo $stats["strength"]; ?></strong>
                                </div>

                                <div class="stats-preview__stat">
                                    <span>Mana</span>
                                    <strong><?php echo $stats["mana"]; ?></strong>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>


                <button type="submit" class="begin-adventure-btn">
                    Begin Adventure
                </button>

            </form>
        </section>
    </main>

    <footer>
        <p>
            Three Kingdoms Ascension — Web Development Project 2
        </p>
    </footer>

</body>
</html>
