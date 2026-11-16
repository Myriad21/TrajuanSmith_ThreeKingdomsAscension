
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

    
    // Create the battle only if one does not already exist.
    if (!isset($_SESSION["combat"])) {
        $_SESSION["combat"] = initializeCombat(
            "mana_corrupted_wolf"
        );
    }

    //startCombat("mana_corrupted_wolf");

    // Retrieve the current battle state.
    $combat = $_SESSION["combat"];


    if ($_SERVER["REQUEST_METHOD"] === "POST") {

        $combatAction = $_POST["combat_action"] ?? "";

        // Basic Attack
        if ($combatAction === "basic_attack") {

            // Only process actions while combat is active.
            if ($_SESSION["combat"]["status"] === "active") {

                // Player attacks the enemy.
                performBasicAttack(
                    $_SESSION["combat"],
                    $_SESSION["champion"]
                );

                // Enemy counterattacks if it survived.
                if ($_SESSION["combat"]["status"] === "active") {
                    performEnemyAttack(
                        $_SESSION["combat"],
                        $_SESSION["champion"]
                    );
                }

                
                // Advance the turn and reduce the special ability cooldown.
                if ($_SESSION["combat"]["status"] === "active") {

                    reduceSpecialCooldown($_SESSION["combat"]);

                    $_SESSION["combat"]["turn"]++;
                }

            }

            // Redirect to prevent repeating the action on refresh.
            header("Location: combat.php#CI");
            exit;
        }

        // Special Attacks
        elseif ($combatAction === "use_special") {

            // Identify which special ability the player selected.
            $abilityId = $_POST["ability_id"] ?? "";

            // Attempt to perform the special attack.
            $attackSuccessful = performSpecialAttack(
                $_SESSION["combat"],
                $_SESSION["champion"],
                $abilityId
            );

            // Only allow an enemy counterattack if the special attack
            // succeeded and the enemy is still alive.
            if (
                $attackSuccessful &&
                $_SESSION["combat"]["status"] === "active"
            ) {
                performEnemyAttack(
                    $_SESSION["combat"],
                    $_SESSION["champion"]
                );
            }

            // Advance the turn if the battle is still active.
            if (
                $attackSuccessful &&
                $_SESSION["combat"]["status"] === "active"
            ) {
                $_SESSION["combat"]["turn"]++;
            }

            // Prevent the attack from repeating on refresh.
            header("Location: combat.php#CI");
            exit;
        }

        // USe Item
        elseif ($combatAction === "use_item") {

            // Identify the item selected by the player.
            $itemId = $_POST["item_id"] ?? "";

            // Initialize the inventory if necessary.
            if (!isset($_SESSION["inventory"])) {
                $_SESSION["inventory"] = [];
            }

            // Attempt to use the selected item.
            $itemUsed = useCombatItem(
                $_SESSION["combat"],
                $_SESSION["champion"],
                $_SESSION["inventory"],
                $itemId
            );

            // The enemy counterattacks after a successful item use.
            if (
                $itemUsed &&
                $_SESSION["combat"]["status"] === "active"
            ) {
                performEnemyAttack(
                    $_SESSION["combat"],
                    $_SESSION["champion"]
                );
            }

            // Advance the turn and update cooldown.
            if (
                $itemUsed &&
                $_SESSION["combat"]["status"] === "active"
            ) {
                reduceSpecialCooldown($_SESSION["combat"]);
                $_SESSION["combat"]["turn"]++;
            }

            // Prevent duplicate item use when refreshing.
            header("Location: combat.php#CI");
            exit;
        }



    }

    // Keep the champion's HP within its valid range.
    //normalizeChampionHP($_SESSION["champion"]);


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

    // Retrieve the enemy from the active combat session.
    $enemy = $combat["enemy"];

    $combatTurn = $combat["turn"];

    $combatLog = $combat["log"];


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

        <div class="combat-layout">

            <!-- Main Combat Interface -->
            <div class="combat-interface">

                <section class="combat-champion">

                    <div class="combat-champion__identity" id="CI">
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
                <section class="combat-actions" id="combat-actions">

                    <?php if ($combat["status"] === "active"): ?>

                        <h2>Choose Your Combat Action</h2>

                        <div class="combat-actions__grid">

                            <!-- Basic Attack -->
                            <form action="combat.php" method="POST">
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
                            </form>


                            <!-- Special Abilities toggle -->
                            <input
                                type="checkbox"
                                id="toggle-specials"
                                class="combat-toggle-input">

                            <label
                                for="toggle-specials"
                                class="combat-action combat-specials-button">
                                <span class="combat-action__title">
                                    Special Abilities
                                </span>

                                <span class="combat-action__description">
                                    View your available combat techniques.
                                </span>
                            </label>

                            
                            <!-- Use Item toggle -->
                            <input
                                type="checkbox"
                                id="toggle-items"
                                class="combat-toggle-input">

                            <label
                                for="toggle-items"
                                class="combat-action combat-items-button">
                                <span class="combat-action__title">
                                    Use Item
                                </span>

                                <span class="combat-action__description">
                                    View available consumables in your inventory.
                                </span>
                            </label>


                            <!-- Escape -->
                            <button
                                type="submit"
                                name="combat_action"
                                value="escape"
                                class="combat-action">
                                <span class="combat-action__title">
                                    Escape
                                </span>

                                <span class="combat-action__description">
                                    Attempt to flee from the encounter.
                                </span>
                            </button>

                            <!-- Expandable Special Abilities Panel -->
                            <div class="combat-specials" id="special-abilities">

                                <h3>Available Special Abilities</h3>

                                <?php
                                $abilities = getSpecialAbilities(
                                    $_SESSION["champion"]["faction"]
                                );
                                ?>

                                <?php foreach ($abilities as $abilityId => $ability): ?>

                                    <div class="combat-specials__ability combat-specials__ability--<?= htmlspecialchars($championFaction) ?>">

                                        <h4>
                                            <?= htmlspecialchars($ability["name"]) ?>
                                        </h4>

                                        <p>
                                            <?= htmlspecialchars($ability["description"]) ?>
                                        </p>

                                        <p>
                                            Mana Cost: <?= (int) $ability["mana_cost"] ?>
                                            | Damage Bonus: +<?= (int) $ability["damage_bonus"] ?>
                                        </p>

                                        <form action="combat.php" method="POST">
                                            <input
                                                type="hidden"
                                                name="ability_id"
                                                value="<?= htmlspecialchars($abilityId) ?>"
                                            >

                                           
                                            <?php
                                                $cooldown = (int) ($combat["special_cooldown"] ?? 0);

                                                $hasEnoughMana = $championMana >= $ability["mana_cost"];

                                                $abilityDisabled = $cooldown > 0 || !$hasEnoughMana;
                                            ?>

                                            <button
                                                type="submit"
                                                name="combat_action"
                                                value="use_special"
                                                class="combat-action combat-action--<?= htmlspecialchars($abilityId) ?>"
                                                <?= $abilityDisabled ? "disabled" : "" ?>
                                            >
                                                <?php if ($cooldown > 0): ?>

                                                    <?= htmlspecialchars($ability["name"]) ?>
                                                    — Cooldown: <?= $cooldown ?> turn<?= $cooldown === 1 ? "" : "s" ?>

                                                <?php elseif (!$hasEnoughMana): ?>

                                                    Insufficient Mana

                                                <?php else: ?>

                                                    Use <?= htmlspecialchars($ability["name"]) ?>

                                                <?php endif; ?>
                                            </button>

                                        </form>

                                    </div>

                                <?php endforeach; ?>

                            </div>

                            <!-- Expandable Use Item Panel -->
                            <div class="combat-items" id="combat-items">

                                <h3>Available Consumables</h3>

                                <?php
                                    $consumables = getConsumableItems();

                                    $inventory = $_SESSION["inventory"] ?? [];

                                    $availableItems = array_count_values(
                                        array_filter(
                                            $inventory,
                                            fn($itemId) => is_string($itemId)
                                                && isset($consumables[$itemId])
                                        )
                                    );
                                ?>

                                <?php if (empty($availableItems)): ?>

                                    <p>You have no consumable items available.</p>

                                <?php else: ?>

                                    <?php foreach ($availableItems as $itemId => $quantity): ?>

                                        <?php $item = $consumables[$itemId]; ?>

                                        <div class="combat-items__item combat-items__item--<?= htmlspecialchars($itemId) ?>">

                                            <h4><?= htmlspecialchars($item["name"]) ?></h4>

                                            <p><?= htmlspecialchars($item["description"]) ?></p>

                                            <p>Quantity: <?= (int) $quantity ?></p>

                                            <form action="combat.php" method="POST">

                                                <input
                                                    type="hidden"
                                                    name="item_id"
                                                    value="<?= htmlspecialchars($itemId) ?>"
                                                >

                                                <button
                                                    type="submit"
                                                    name="combat_action"
                                                    value="use_item"
                                                    class="combat-action"
                                                    <?= $championHP >= $championMaxHP ? "disabled" : "" ?>
                                                >
                                                    <?php if ($championHP >= $championMaxHP): ?>
                                                        HP Already Full
                                                    <?php else: ?>
                                                        Use <?= htmlspecialchars($item["name"]) ?>
                                                    <?php endif; ?>
                                                </button>

                                            </form>


                                        </div>

                                    <?php endforeach; ?>

                                <?php endif; ?>

                            </div>


                        </div>


     
                    <!-- Victory / Defeat--->
                    <?php elseif ($combat["status"] === "victory"): ?>

                        <h2>Victory!</h2>

                        <p class="combat-result__message">
                            <?= htmlspecialchars($championName) ?>
                            has defeated
                            <?= htmlspecialchars($enemy["name"]) ?>!
                        </p>

                        <p class="combat-result__description">
                            You've emerged victorious.
                        </p>

                    <?php elseif ($combat["status"] === "defeat"): ?>

                        <h2>Champion Defeated</h2>

                        <p class="combat-result__message">
                            <?= htmlspecialchars($championName) ?>
                            has fallen in battle.
                        </p>

                        <p class="combat-result__description">
                            Your champion's journey has come to an end.
                        </p>

                    <?php endif; ?>


                </section>

            </div>

            <!-- Combat Log -->
            <aside class="combat-log" aria-labelledby="combat-log-heading">

                <h2 id="combat-log-heading">Combat Log</h2>

                <div class="combat-log__entries">

                    <?php foreach ($combatLog as $entry): ?>

                        <p class="combat-log__entry">
                            <?= htmlspecialchars($entry) ?>
                        </p>

                    <?php endforeach; ?>

                </div>

            </aside>

        </div>

    </main>

    <footer>
        <p>Three Kingdoms Ascension — Web Development Project 2</p>
    </footer>
</body>
</html>

