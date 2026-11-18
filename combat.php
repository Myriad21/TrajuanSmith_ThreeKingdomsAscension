<?php
    session_start();

    // Require authentication before accessing combat.
    if (!isset($_SESSION["user"])) {
        header("Location: login.php");
        exit;
    }

    require_once __DIR__ . "/includes/game_functions.php";
    require_once __DIR__ . "/includes/combat_functions.php";
    require_once __DIR__ . "/includes/save_functions.php";


    $pageTitle = "Combat Encounter";

    // Only allow players with an existing champion.
    if (
        !isset($_SESSION["champion"]) ||
        !is_array($_SESSION["champion"])
    ) {
        header("Location: character.php");
        exit;
    }

    // Allow the player to leave combat training at any time.
    if (
        $_SERVER["REQUEST_METHOD"] === "POST" &&
        ($_POST["combat_action"] ?? "") === "end_training" &&
        ($_SESSION["combat"]["enemy"]["id"] ?? "") === "training_dummy"
    ) {
        // Remove the temporary training encounter.
        unset($_SESSION["combat"]);

        // Return to the training grounds story scene.
        $_SESSION["story_node"] = "act1_training_dummy";

        // Redirect back to the story interface.
        header("Location: game.php");
        exit;
    }

    
    // Retry the current battle after defeat.
    if (
        $_SERVER["REQUEST_METHOD"] === "POST" &&
        ($_POST["combat_action"] ?? "") === "retry_combat" &&
        ($_SESSION["combat"]["status"] ?? "") === "defeat" &&
        isset($_SESSION["combat_checkpoint"]) &&
        ($_SESSION["combat"]["enemy"]["id"] ?? "") !== "corrupted_mana_beast"
    ) {
        $checkpoint = $_SESSION["combat_checkpoint"];

        // Restore the champion and inventory from before the battle.
        $_SESSION["champion"] = $checkpoint["champion"];
        $_SESSION["inventory"] = $checkpoint["inventory"];

        // Identify the enemy from the failed encounter.
        $enemyId = $_SESSION["combat"]["enemy"]["id"];

        // Start a fresh encounter with the same enemy.
        unset($_SESSION["combat"]);

        startCombat($enemyId);

        // Reapply the rival's opening surprise attack, if applicable.
        if (
            !empty($_SESSION["story_flags"]["act1_rival_surprised"]) &&
            ($_SESSION["story_node"] ?? "") === "act1_rival_interception"
        ) {
            $damage = min(20, max(0, (int) $_SESSION["champion"]["hp"]));

            $_SESSION["champion"]["hp"] -= $damage;

            $_SESSION["combat"]["log"][] =
                "The rival champion catches you off guard and deals "
                . $damage
                . " surprise damage!";

            $_SESSION["combat"]["rival_opening_attack_applied"] = true;
        }

        // Save the restored champion and inventory.
        savePlayerProgress(collectPlayerProgress());

        // Redirect to prevent repeated submissions.
        header("Location: combat.php");
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


    // Record and save the wolf victory once.
    
    if (
        $combat["status"] === "victory" &&
        ($combat["enemy"]["id"] ?? "") === "mana_corrupted_wolf" &&
        empty($_SESSION["story_flags"]["wolf_defeated"])
    ) {
        $_SESSION["story_flags"]["wolf_defeated"] = true;

        // The battle is finished, so do not persist its temporary state.
        $completedCombat = $_SESSION["combat"];
        unset($_SESSION["combat"]);

        savePlayerProgress(collectPlayerProgress());

        // Keep the result available for the victory screen.
        $_SESSION["combat"] = $completedCombat;
        $combat = $completedCombat;
    }


    // Record the Act 1 rival victory only once.
    if (
        $combat["status"] === "victory" &&
        isset($combat["enemy"]["faction"]) &&
        ($combat["enemy"]["level"] ?? 0) === 2 &&
        in_array(
            $_SESSION["story_node"] ?? "",
            [
                "rival_ambush",
                "act1_rival_interception",
                "first_rival_encounter"
            ],
            true
        ) &&
        empty($_SESSION["story_flags"]["act1_rival_defeated"])
    ) {
        // Identify the actual faction of the defeated rival.
        $rivalFaction = $combat["enemy"]["faction"];

        // Initialize the defeated rivals list if necessary.
        if (!isset($_SESSION["story_flags"]["defeated_rivals"])) {
            $_SESSION["story_flags"]["defeated_rivals"] = [];
        }

        // Initialize the injured rivals list if necessary.
        if (!isset($_SESSION["story_flags"]["injured_rivals"])) {
            $_SESSION["story_flags"]["injured_rivals"] = [];
        }

        // Record the rival's faction without duplicates.
        if (!in_array(
            $rivalFaction,
            $_SESSION["story_flags"]["defeated_rivals"],
            true
        )) {
            $_SESSION["story_flags"]["defeated_rivals"][] = $rivalFaction;
        }

        if (!in_array(
            $rivalFaction,
            $_SESSION["story_flags"]["injured_rivals"],
            true
        )) {
            $_SESSION["story_flags"]["injured_rivals"][] = $rivalFaction;
        }

        // Mark the first rival as defeated but still alive.
        $_SESSION["story_flags"]["act1_rival_defeated"] = true;

        // The defeated rival retreats and survives.
        $_SESSION["story_flags"]["act1_rival_retreated"] = true;

        // Move to the victory aftermath scene.
        $_SESSION["story_node"] = "rival_retreat";

        // Save the completed encounter and updated story state.
        $completedCombat = $_SESSION["combat"];

        unset($_SESSION["combat"]);

        savePlayerProgress(collectPlayerProgress());

        // Keep the victory screen visible until Return to Story.
        $_SESSION["combat"] = $completedCombat;
        $combat = $completedCombat;
    }



    // Record the Act 2 Zenith rival victory.
    if (
        ($combat["status"] ?? "") === "victory" &&
        ($combat["encounter"] ?? "") === "act2_zenith_rival" &&
        ($combat["enemy"]["level"] ?? 0) == 3 &&
        empty($_SESSION["story_flags"]["act2_geyser_rival_defeated"])
    ) {
        // Identify the faction of the defeated rival.
        $rivalFaction = $combat["enemy"]["faction"] ?? null;

        // Track the defeated rival without duplicates.
        if ($rivalFaction !== null) {
            if (!isset($_SESSION["story_flags"]["defeated_rivals"])) {
                $_SESSION["story_flags"]["defeated_rivals"] = [];
            }

            if (!in_array(
                $rivalFaction,
                $_SESSION["story_flags"]["defeated_rivals"],
                true
            )) {
                $_SESSION["story_flags"]["defeated_rivals"][] = $rivalFaction;
            }
        }

        // Record the outcome of the confrontation.
        $_SESSION["story_flags"]["act2_geyser_rival_defeated"] = true;
        $_SESSION["story_flags"]["act2_geyser_cooperation_agreed"] = false;

        // Return to the geyser without cooperative assistance.
        $_SESSION["story_node"] = "act2_ruptured_mana_geyser";

        // Preserve the completed battle for the victory screen.
        $completedCombat = $_SESSION["combat"];

        // Do not include temporary combat data in the saved progress.
        unset($_SESSION["combat"]);

        savePlayerProgress(collectPlayerProgress());

        // Restore the victory screen until Return to Story is clicked.
        $_SESSION["combat"] = $completedCombat;
        $combat = $completedCombat;
    }


    // Record the Act 3 final boss outcome.
    if (
        ($combat["enemy"]["id"] ?? "") === "corrupted_mana_beast" &&
        in_array($combat["status"] ?? "", ["victory", "defeat"], true) &&
        empty($_SESSION["story_flags"]["act3_final_boss_resolved"])
    ) {
        $victory = $combat["status"] === "victory";

        $_SESSION["story_flags"]["act3_mana_beast_defeated"] = $victory;
        $_SESSION["story_flags"]["act3_mana_beast_failed"] = !$victory;
        $_SESSION["story_flags"]["act3_final_boss_resolved"] = true;

        // Victory leads to the artifact decision.
        // Defeat leads directly to the ending summary.
        $_SESSION["story_node"] = $victory
            ? "act3_artifact_decision"
            : "act3_faction_defeat";

        // Preserve the completed battle for its result screen.
        $completedCombat = $_SESSION["combat"];
        unset($_SESSION["combat"]);

        // Save the permanent outcome.
        savePlayerProgress(collectPlayerProgress());

        // Restore the result screen.
        $_SESSION["combat"] = $completedCombat;
        $combat = $completedCombat;
    }




    if ($_SERVER["REQUEST_METHOD"] === "POST") {

        $combatAction = $_POST["combat_action"] ?? "";

        // Basic Attack
        if ($combatAction === "basic_attack") {

            // Only process actions while combat is active.
            if ($_SESSION["combat"]["status"] === "active") {

                
                // Calculate the bonus from the champion's equipped weapon.
                $weaponBonus = getEquippedWeaponBonus(
                    $_SESSION["champion"],
                    $_SESSION["inventory"] ?? []
                );

                // Player attacks the enemy with their weapon bonus.
                performBasicAttack(
                    $_SESSION["combat"],
                    $_SESSION["champion"],
                    $weaponBonus
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

                    $_SESSION["combat"]["item_cooldown"] = max(
                        0,
                        (int) ($_SESSION["combat"]["item_cooldown"] ?? 0) - 1
                    );

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
            
            $weaponBonus = getEquippedWeaponBonus(
                $_SESSION["champion"],
                $_SESSION["inventory"] ?? []
            );

            $attackSuccessful = performSpecialAttack(
                $_SESSION["combat"],
                $_SESSION["champion"],
                $abilityId,
                $weaponBonus
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

            $itemId = $_POST["item_id"] ?? "";

            if (!isset($_SESSION["inventory"])) {
                $_SESSION["inventory"] = [];
            }

            // Check whether the potion is still on cooldown.
            $itemCooldown = (int) (
                $_SESSION["combat"]["item_cooldown"] ?? 0
            );

            if (
                $_SESSION["combat"]["status"] === "active" &&
                $itemCooldown === 0
            ) {

                // Attempt to use the selected healing item.
                $itemUsed = useCombatItem(
                    $_SESSION["combat"],
                    $_SESSION["champion"],
                    $_SESSION["inventory"],
                    $itemId
                );

                if ($itemUsed) {

                    // Prevent another potion until a combat turn passes.
                    $_SESSION["combat"]["item_cooldown"] = 1;

                    // No enemy counterattack.
                    // No turn advancement.
                    $_SESSION["combat"]["log"][] =
                        "You recover without giving the enemy an opening.";
                }
            }

            header("Location: combat.php#CI");
            exit;
        }


        // Escape
        elseif ($combatAction === "escape") {

            // Attempt to escape from the current enemy.
            $escaped = attemptEscape(
                $_SESSION["combat"],
                $_SESSION["champion"]
            );

            // A failed escape from an active battle costs a turn.
            if (
                !$escaped &&
                $_SESSION["combat"]["status"] === "active"
            ) {
                performEnemyAttack(
                    $_SESSION["combat"],
                    $_SESSION["champion"]
                );

                if ($_SESSION["combat"]["status"] === "active") {
                    reduceSpecialCooldown($_SESSION["combat"]);
                    $_SESSION["combat"]["turn"]++;
                }
            }

            // Reload to display the updated combat state.
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
                                Hostile Enemy |
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


                <?php if ($combat["status"] === "escaped"): ?>
                    <div class="combat-result">
                        <h2>Successfully Escaped</h2>

                        <p>
                            You escaped from
                            <?= htmlspecialchars($enemy["name"]) ?>.
                        </p>

                        <p>
                            Your journey is not over.
                            Return to the story to continue your adventure.
                        </p>

                        <a href="game.php" class="combat-result__button">
                            Return to Story
                        </a>
                    </div>
                <?php endif; ?>


                <!-- Combat Actions -->
                <section class="combat-actions" id="combat-actions">

                    <?php if ($combat["status"] === "active"): ?>

                        <h2>Choose Your Combat Action</h2>

                        <?php if (!empty($combat["enemy"]["is_training"])): ?>
                            <form action="combat.php" method="POST">
                                <button
                                    type="submit"
                                    name="combat_action"
                                    value="end_training"
                                    class="combat-action"
                                >
                                    <span class="combat-action__title">
                                        End Training
                                    </span>

                                    <span class="combat-action__description">
                                        Stop practicing and return to the training grounds.
                                    </span>
                                </button>
                            </form>
                        <?php endif; ?>

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

                            <?php if (empty($combat["enemy"]["is_training"])): ?>
                                <!-- Escape -->
                                <form action="combat.php" method="POST">
                                    <button
                                        type="submit"
                                        name="combat_action"
                                        value="escape"
                                        class="combat-action"
                                        <?= $combat["status"] !== "active" ? "disabled" : "" ?>
                                    >
                                        <span class="combat-action__title">Escape</span>
                                        <span class="combat-action__description">
                                            Attempt to flee from the current encounter.
                                        </span>
                                    </button>
                                </form>
                            <?php endif; ?>


                            <!-- Expandable Special Abilities Panel -->
                            <div class="combat-specials" id="special-abilities">

                                <h3>Available Special Abilities</h3>

                                <?php
                                $abilities = getSpecialAbilities(
                                    $_SESSION["champion"]["faction"]
                                );
                                ?>


                                <?php if ($championLevel < 2): ?>

                                    <div class="combat-specials__locked">
                                        <span class="combat-specials__lock-icon" aria-hidden="true">
                                            🔒
                                        </span>

                                        <h4>Special Ability Locked</h4>

                                        <p>
                                            Reach Level 2 to unlock your first
                                            special ability.
                                        </p>

                                    </div>

                                <?php else: ?>


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

                                <?php endif; ?>

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

                                                <?php
                                                    $itemCooldown = (int) ($combat["item_cooldown"] ?? 0);

                                                    $itemDisabled = $championHP >= $championMaxHP
                                                        || $itemCooldown > 0;
                                                ?>

                                                <button
                                                    type="submit"
                                                    name="combat_action"
                                                    value="use_item"
                                                    class="combat-action"
                                                    <?= $itemDisabled ? "disabled" : "" ?>
                                                >
                                                    
                                                    <?php if ($championHP >= $championMaxHP): ?>

                                                        HP Already Full

                                                    <?php elseif ($itemCooldown > 0): ?>

                                                        Potion Cooldown: <?= $itemCooldown ?> Turn

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

                    <?php if (!empty($combat["enemy"]["is_training"])): ?>

                        <h2>Training Complete!</h2>

                        <p class="combat-result__message">
                            <?= htmlspecialchars($championName) ?>
                            has successfully completed combat training!
                        </p>

                        <p class="combat-result__description">
                            Your attacks have overwhelmed the reinforced training dummy.
                            You have sharpened your combat techniques without risking
                            your life.
                        </p>

                        <p class="combat-result__description">
                            Training does not provide experience, levels, or additional rewards.
                        </p>

                        <form action="combat.php" method="POST">
                            <button
                                type="submit"
                                name="combat_action"
                                value="end_training"
                                class="combat-result__button"
                            >
                                Return to Training Grounds
                            </button>
                        </form>

                    <?php else: ?>

                        <h2>Victory!</h2>

                        <p class="combat-result__message">
                            <?= htmlspecialchars($championName) ?>
                            has defeated
                            <?= htmlspecialchars($enemy["name"]) ?>!
                        </p>

                        <p class="combat-result__description">
                            You've emerged victorious.
                        </p>

                        <a href="game.php" class="combat-result__button">
                            Return to Story
                        </a>

                    <?php endif; ?>


                    <?php elseif ($combat["status"] === "defeat"): ?>

                        <h2>Champion Defeated</h2>

                        <p class="combat-result__message">
                            <?= htmlspecialchars($championName) ?>
                            has fallen in battle.
                        </p>

                        <p class="combat-result__description">
                            Your champion's journey has come to an end.
                        </p>

                        
                        <?php if (($combat["enemy"]["id"] ?? "") === "corrupted_mana_beast"): ?>

                            <p class="combat-result__description">
                                The Corrupted Mana Beast has overwhelmed your champion.
                                Your expedition has failed to stop the mana catastrophe.
                                This defeat is permanent.
                            </p>

                            <a href="game.php" class="combat-result__button">
                                View Final Outcome
                            </a>

                        <?php else: ?>

                            <form action="combat.php" method="POST" class="combat-retry-form">
                                <input
                                    type="hidden"
                                    name="combat_action"
                                    value="retry_combat"
                                >

                                <button type="submit" class="combat-retry-button">
                                    Try Again
                                </button>
                            </form>

                        <?php endif; ?>


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

