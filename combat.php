
<?php
    session_start();

    require_once __DIR__ . "/includes/game_functions.php";
    require_once __DIR__ . "/includes/combat_functions.php";

    $pageTitle = "Combat Encounter";

    // Only allow players with an existing champion.
    if (
        !isset($_SESSION["champion"]) ||
        !is_array($_SESSION["champion"])
    ) {
        header("Location: character.php");
        exit;
    }

    // Retrieve the champion's current information.
    $champion = $_SESSION["champion"];

    $championName = $champion["name"];
    $championFaction = $champion["faction"];
    $championLevel = $champion["level"];

    $championHP = $champion["hp"];
    $championMaxHP = $champion["max_hp"];

    $championStrength = $champion["strength"];

    $championMana = $champion["mana"];
    $championMaxMana = $champion["max_mana"];


// Temporary enemy data for testing the combat layout.
// This will be replaced by session-based combat data.
$enemy = [
    "name" => "Mana-Corrupted Wolf",
    "level" => 1,
    "hp" => 40,
    "max_hp" => 40,
    "strength" => 6
];

// Temporary turn counter.
$combatTurn = 1;


// Temporary combat log entries for layout testing.
// These will be replaced by session-based battle events.
$combatLog = [
    "Battle started! A Mana-Corrupted Wolf blocks your path.",
    "The wolf growls as unstable mana surrounds its body.",
    "Choose your first combat action."
];


// Calculate HP percentages for the health bars.
$playerHPPercent = $championMaxHP > 0
    ? max(0, min(100, ($championHP / $championMaxHP) * 100))
    : 0;

$enemyHPPercent = $enemy["max_hp"] > 0
    ? max(0, min(100, ($enemy["hp"] / $enemy["max_hp"]) * 100))
    : 0;

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?= htmlspecialchars($pageTitle) ?> | Three Kingdoms Ascension</title>

    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="assets/css/navigation.css">
    <link rel="stylesheet" href="assets/css/combat.css">
</head>

<body>
    <header class="site-header site-header--compact">
        <h1>Three Kingdoms Ascension</h1>

        <nav aria-label="Main navigation">
            <!-- Navigation will be integrated with Hien's work. -->
        </nav>
    </header>

    <main class="combat-main">

        <section class="combat-champion">
            <div class="combat-champion__identity">
                <h2>
                    Champion:
                    <?= htmlspecialchars($championName) ?>
                </h2>

                <p>
                    <?= htmlspecialchars(ucfirst($championFaction)) ?>
                    | Level <?= htmlspecialchars((string) $championLevel) ?>
                </p>
            </div>

            <div class="combat-champion__stats">

                <div class="combat-champion__stat">
                    <span>Health (HP)</span>
                    <strong>
                        <?= htmlspecialchars((string) $championHP) ?>
                        /
                        <?= htmlspecialchars((string) $championMaxHP) ?>
                    </strong>
                </div>

                <div class="combat-champion__stat">
                    <span>Strength</span>
                    <strong>
                        <?= htmlspecialchars((string) $championStrength) ?>
                    </strong>
                </div>

                <div class="combat-champion__stat">
                    <span>Mana</span>
                    <strong>
                        <?= htmlspecialchars((string) $championMana) ?>
                        /
                        <?= htmlspecialchars((string) $championMaxMana) ?>
                    </strong>
                </div>

            </div>
        </section>

        <!-- Battle Encounter -->
        <section class="combat-battle">

            <div class="combat-battle__heading">
                <h2>Battle Encounter</h2>

                <span>
                    Turn <?= htmlspecialchars((string) $combatTurn) ?>
                </span>
            </div>

            <div class="combat-battle__fighters">

                <!-- Player -->
                <article class="combat-fighter combat-fighter--player">
                    <h3><?= htmlspecialchars($championName) ?></h3>

                    <p>
                        <?= htmlspecialchars(ucfirst($championFaction)) ?>
                        Champion | Level <?= htmlspecialchars((string) $championLevel) ?>
                    </p>

                    <div class="combat-fighter__health">
                        <div
                            class="combat-fighter__health-fill"
                            style="width: <?= $playerHPPercent ?>%;"
                        ></div>
                    </div>

                    <p class="combat-fighter__health-text">
                        HP:
                        <?= htmlspecialchars((string) $championHP) ?>
                        /
                        <?= htmlspecialchars((string) $championMaxHP) ?>
                    </p>
                </article>

                <!-- Enemy -->
                <article class="combat-fighter combat-fighter--enemy">
                    <h3><?= htmlspecialchars($enemy["name"]) ?></h3>

                    <p>
                        Hostile Creature |
                        Level <?= htmlspecialchars((string) $enemy["level"]) ?>
                    </p>

                    <div class="combat-fighter__health">
                        <div
                            class="combat-fighter__health-fill"
                            style="width: <?= $enemyHPPercent ?>%;"
                        ></div>
                    </div>

                    <p class="combat-fighter__health-text">
                        HP:
                        <?= htmlspecialchars((string) $enemy["hp"]) ?>
                        /
                        <?= htmlspecialchars((string) $enemy["max_hp"]) ?>
                    </p>
                </article>

            </div>

        </section>

        <!-- Combat Actions -->
        <section class="combat-actions">

            <h2>Choose Your Combat Action</h2>

            <form action="combat.php" method="POST"
                class="combat-actions__grid">

                <!-- Basic Attack -->
                <button
                    type="submit"
                    name="combat_action"
                    value="basic_attack"
                    class="combat-action"
                >
                    <span class="combat-action__title">
                        Basic Attack
                    </span>

                    <span class="combat-action__description">
                        Attack using your equipped weapon.
                    </span>
                </button>

                <!-- Special Ability -->
                <button
                    type="submit"
                    name="combat_action"
                    value="special_attack"
                    class="combat-action"
                >
                    <span class="combat-action__title">
                        Special Ability
                    </span>

                    <span class="combat-action__description">
                        Powerful faction ability. Consumes Mana.
                    </span>
                </button>

                <!-- Use Item -->
                <button
                    type="submit"
                    name="combat_action"
                    value="use_item"
                    class="combat-action"
                >
                    <span class="combat-action__title">
                        Use Item
                    </span>

                    <span class="combat-action__description">
                        Use a healing potion from your inventory.
                    </span>
                </button>

                <!-- Escape -->
                <button
                    type="submit"
                    name="combat_action"
                    value="escape"
                    class="combat-action"
                >
                    <span class="combat-action__title">
                        Escape
                    </span>

                    <span class="combat-action__description">
                        Attempt to flee from the encounter.
                    </span>
                </button>

            </form>

        </section>

        <!-- Combat Log -->
        <section class="combat-log" aria-labelledby="combat-log-heading">

            <h2 id="combat-log-heading">Combat Log</h2>

            <div class="combat-log__entries">

                <?php foreach ($combatLog as $entry): ?>

                    <p class="combat-log__entry">
                        <?= htmlspecialchars($entry) ?>
                    </p>

                <?php endforeach; ?>

            </div>

        </section>


    </main>

    <footer>
        <p>Three Kingdoms Ascension — Web Development Project 2</p>
    </footer>
</body>
</html>

