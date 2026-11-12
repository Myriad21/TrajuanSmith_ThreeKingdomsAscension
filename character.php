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

            $characterCreated = true;
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
</head>

<body>

    

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

            
            <?php if ($characterCreated): ?>
                <div class="character-preview">
                    <h3>Champion Created Successfully!</h3>

                    <p>
                        Name:
                        <?php echo htmlspecialchars($_SESSION["champion"]["name"]); ?>
                    </p>

                    <p>
                        Faction:
                        <?php echo htmlspecialchars(ucfirst($_SESSION["champion"]["faction"])); ?>
                    </p>

                    <p>
                        HP: <?php echo $_SESSION["champion"]["hp"]; ?>
                    </p>

                    <p>
                        Strength: <?php echo $_SESSION["champion"]["strength"]; ?>
                    </p>

                    <p>
                        Mana: <?php echo $_SESSION["champion"]["mana"]; ?>
                    </p>

                    <p>
                        Level: <?php echo $_SESSION["champion"]["level"]; ?>
                    </p>
                </div>
            <?php endif; ?>


            <form action="character.php" method="POST">

                <div>
                    <label for="champion_name">
                        Champion Name
                    </label>

                    <input
                        type="text"
                        id="champion_name"
                        name="champion_name"
                        maxlength="30"
                        required
                    >
                </div>

                <fieldset>
                    <legend>Select Your Faction</legend>

                    <div>
                        <input
                            type="radio"
                            id="warrior"
                            name="faction"
                            value="warrior"
                            required
                        >
                        <label for="warrior">
                            Warriors
                        </label>
                    </div>

                    <div>
                        <input
                            type="radio"
                            id="mage"
                            name="faction"
                            value="mage"
                        >
                        <label for="mage">
                            Mages
                        </label>
                    </div>

                    <div>
                        <input
                            type="radio"
                            id="rogue"
                            name="faction"
                            value="rogue"
                        >
                        <label for="rogue">
                            Rogues
                        </label>
                    </div>

                </fieldset>

                <button type="submit">
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
