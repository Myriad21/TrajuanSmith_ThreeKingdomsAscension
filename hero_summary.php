
<?php
session_start();

require_once __DIR__ . "/includes/game_functions.php";
require_once __DIR__ . "/includes/story_nodes.php";
require_once __DIR__ . "/includes/score_functions.php";
require_once __DIR__ . "/includes/save_functions.php";

// A champion must exist before viewing the summary.
if (
    !isset($_SESSION["champion"]) ||
    !is_array($_SESSION["champion"])
) {
    header("Location: character.php");
    exit;
}

$champion = $_SESSION["champion"];

$championName = $champion["name"] ?? "Unknown";
$championFaction = $champion["faction"] ?? "Unknown";
$championLevel = $champion["level"] ?? 1;


/* =========================================
   DYNAMIC ENDING DETECTION
========================================= */

$storyNode = $_SESSION["story_node"]
    ?? $champion["story_node"]
    ?? "";

$storyFlags = $_SESSION["story_flags"] ?? [];

$factionNames = [
    "warrior" => "Warrior Kingdom",
    "mage" => "Mage Kingdom",
    "rogue" => "Rogue Kingdom"
];

$factionKey = strtolower((string) $championFaction);

$factionName = $factionNames[$factionKey]
    ?? "Your Kingdom";

$endingTitle = "Journey Incomplete";
$endingSubtitle = "Your champion's fate has not yet been decided.";
$kingdomFate = "Continue your adventure to determine the fate of the Three Kingdoms.";

if ($storyNode === "act3_faction_victory") {

    $endingTitle = "Faction Victory";

    $endingSubtitle = "$factionName claims the ancient artifact.";

    $kingdomFate = "$championName defeated the Corrupted Mana Beast "
        . "and secured the ancient mana artifact for the $factionName. "
        . "The kingdom celebrates its champion's triumph, but the "
        . "balance of power has shifted. The other two kingdoms "
        . "now face an uncertain future under the growing influence "
        . "of the victorious faction.";

} elseif ($storyNode === "act3_faction_defeat") {

    $endingTitle = "Faction Defeat";

    if (!empty($storyFlags["act3_artifact_relinquished"])) {

        $endingSubtitle = "You relinquished your kingdom's claim to the artifact.";

        $kingdomFate = "Although $championName defeated the Corrupted "
            . "Mana Beast, the champion chose to relinquish the "
            . "ancient artifact rather than claim it for the "
            . "$factionName. The expedition returns without its "
            . "greatest prize. The three kingdoms remain divided, "
            . "and their struggle for power continues.";

    } else {

        $endingSubtitle = "Your expedition failed to secure the artifact.";

        $kingdomFate = "$championName was unable to overcome the "
            . "Corrupted Mana Beast. Without the ancient artifact, "
            . "the $factionName must face an uncertain future. "
            . "The other kingdoms continue competing for dominance, "
            . "while the expedition's defeat becomes a reminder "
            . "of the dangers hidden within the Blackened Cavern.";
    }

} elseif ($storyNode === "act3_secret_ending") {

    $endingTitle = "The Threefold Accord";

    $endingSubtitle = "The three kingdoms unite through a historic agreement.";

    $kingdomFate = "After defeating the Corrupted Mana Beast, "
        . "$championName refused to allow any single kingdom "
        . "to control the ancient artifact. Having earned the "
        . "trust of the Warriors, Mages, and Rogues, the champion "
        . "used the power of the Zenith crystals to help "
        . "establish the Threefold Accord. The artifact would "
        . "be protected through cooperation between all three "
        . "kingdoms, beginning a new era of shared responsibility "
        . "and peace.";
}



/* =========================================
   THREE MAJOR STORY DECISIONS
========================================= */

$majorDecisions = [];

// Decision 1: Rival expedition in Act 1
if (!empty($storyFlags["act1_rival_cooperated"])) {

    $majorDecisions[] =
        "You chose to negotiate with the rival champion during your first Expedition "
        . ". With this you were able to maintain peace.";

} elseif (!empty($storyFlags["act1_rival_defeated"])) {

    $majorDecisions[] =
        "You fought and defeated the rival champions "
        . "instead of cooperating with them.";

} else {

    $majorDecisions[] =
        "Your encounter with the rival expedition "
        . "was not recorded.";
}

// Decision 2: Injured cultivator in Act 3
if (!empty($storyFlags["act3_injured_cultivator_rescued"])) {

    $majorDecisions[] =
        "You rescued the injured cultivator "
        . "inside the Blackened Cavern. Receiving their reward to help you defeat the terrible mana beast.";

} else {

    $majorDecisions[] =
        "You continued through the Blackened Cavern "
        . "without rescuing the injured cultivator.";
}

// Decision 3: Final artifact outcome
if ($storyNode === "act3_secret_ending") {

    $majorDecisions[] =
        "You established the Threefold Accord, "
        . "sharing responsibility for the artifact "
        . "between all three kingdoms.";

} elseif (
    !empty($storyFlags["act3_mana_beast_failed"])
) {

    $majorDecisions[] =
        "You challenged the Corrupted Mana Beast "
        . "but were defeated in the final battle.";

} elseif (
    !empty($storyFlags["act3_artifact_relinquished"])
) {

    $majorDecisions[] =
        "You defeated the Corrupted Mana Beast "
        . "but relinquished the artifact, "
        . "abandoning your kingdom's claim.";

} elseif (
    !empty($storyFlags["act3_artifact_claimed"])
    || $storyNode === "act3_faction_victory"
) {

    $majorDecisions[] =
        "You claimed the ancient artifact "
        . "for the $factionName after defeating "
        . "the Corrupted Mana Beast.";

} else {

    $majorDecisions[] =
        "Your final decision concerning "
        . "the artifact has not been recorded.";
}



/* =========================================
   PERSONALIZED HERO NARRATIVE
========================================= */

// Introduce the champion.
$heroNarrative = "$championName, champion of the "
    . "$factionName, embarked on an expedition "
    . "to uncover the mystery of the ancient mana artifact. ";

// Act 1: Rival expedition.
if (!empty($storyFlags["act1_rival_cooperated"])) {

    $heroNarrative .=
        "During the first expedition, you chose diplomacy "
        . "over conflict, negotiating with the rival champions "
        . "and maintaining peace. ";

} elseif (!empty($storyFlags["act1_rival_defeated"])) {

    $heroNarrative .=
        "During the first expedition, you confronted "
        . "and defeated the rival champions, demonstrating "
        . "your willingness to fight for your kingdom. ";

} else {

    $heroNarrative .=
        "Your early expedition brought you into contact "
        . "with the rival kingdoms. ";
}

// Act 3: Injured cultivator.
if (!empty($storyFlags["act3_injured_cultivator_rescued"])) {

    $heroNarrative .=
        "Later, within the Blackened Cavern, you rescued "
        . "an injured cultivator and received assistance "
        . "that strengthened your chances against "
        . "the Corrupted Mana Beast. ";

} else {

    $heroNarrative .=
        "Within the Blackened Cavern, you continued "
        . "your expedition without rescuing "
        . "the injured cultivator. ";
}

// Final outcome.
if ($storyNode === "act3_secret_ending") {

    $heroNarrative .=
        "After overcoming the final battle, your trust "
        . "with all three kingdoms allowed you to establish "
        . "the Threefold Accord. Rather than claiming "
        . "the artifact for one faction, you chose unity "
        . "and secured a peaceful future for "
        . "the Three Kingdoms.";

} elseif ($storyNode === "act3_faction_victory") {

    $heroNarrative .=
        "After defeating the Corrupted Mana Beast, "
        . "you claimed the ancient artifact for the "
        . "$factionName. Your decisions ultimately "
        . "secured a Faction Victory, strengthening "
        . "your kingdom's position among the three powers.";

} elseif ($storyNode === "act3_faction_defeat") {

    if (!empty($storyFlags["act3_artifact_relinquished"])) {

        $heroNarrative .=
            "Although you defeated the Corrupted Mana Beast, "
            . "you chose to relinquish the ancient artifact. "
            . "Your decision placed your kingdom's ambitions "
            . "aside, leaving the balance of power "
            . "between the Three Kingdoms unresolved.";

    } else {

        $heroNarrative .=
            "Despite your efforts, the Corrupted Mana Beast "
            . "proved too powerful. Your defeat prevented "
            . "your kingdom from securing the artifact, "
            . "bringing your expedition to an unfortunate end.";
    }

} else {

    $heroNarrative .=
        "Your journey through the Three Kingdoms "
        . "has not yet reached its final conclusion.";
}

$finalScore = calculateFinalScore(
    $storyFlags,
    $storyNode,
    (int) $championLevel
);


/* =========================================
   SAVE FINAL SCORE
========================================= */

$completedEndings = [
    "act3_faction_victory",
    "act3_faction_defeat",
    "act3_secret_ending"
];

// Save only when the player has completed the story.
if (in_array($storyNode, $completedEndings, true)) {

    // Check whether the stored score needs updating.
    if (
        !isset($_SESSION["final_score"]) ||
        (int) $_SESSION["final_score"] !== $finalScore
    ) {

        $_SESSION["final_score"] = $finalScore;

        // Collect the entire player state, including the score.
        $progress = collectPlayerProgress();

        // Preserve all existing progress when saving.
        savePlayerProgress($progress);
    }
}


function summaryEscape($value) {
    return htmlspecialchars((string) $value, ENT_QUOTES, "UTF-8");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Hero Summary | Three Kingdoms Ascension</title>

    <link rel="stylesheet" href="assets/css/hero_summary.css">
</head>

<body>
    <div class="summary-page">

        <header class="summary-header">
            <span>THREE KINGDOMS ASCENSION</span>

            <nav>
                <a href="leaderboard.php">Leaderboard</a>
                <a href="logout.php">Logout</a>
            </nav>
        </header>

        <main>
            <section class="ending-section">

                <div class="ending-artwork">
                    <span>Ending Illustration / Artwork</span>
                </div>

                <p class="ending-eyebrow">
                    YOUR JOURNEY HAS ENDED
                </p>

                <h1><?= summaryEscape($endingTitle) ?></h1>

                <p class="ending-subtitle">
                    <?= summaryEscape($endingSubtitle) ?>
                </p>

                <div class="kingdom-fate">
                    <h2>The Fate of the Three Kingdoms</h2>
                    <p><?= summaryEscape($kingdomFate) ?></p>
                </div>

            </section>

            <section class="hero-section">

                <h2>Your Hero Summary</h2>

                <div class="hero-grid">

                    <div class="hero-stat">
                        <span>Champion</span>
                        <strong><?= summaryEscape($championName) ?></strong>
                    </div>

                    <div class="hero-stat">
                        <span>Faction</span>
                        <strong><?= summaryEscape($championFaction) ?></strong>
                    </div>

                    <div class="hero-stat">
                        <span>Final Level</span>
                        <strong><?= summaryEscape($championLevel) ?></strong>
                    </div>

                    <div class="hero-stat">
                        <span>Ending Earned</span>
                        <strong><?= summaryEscape($endingTitle) ?></strong>
                    </div>

                </div>

                <div class="major-decisions">
                    <h3>Your Three Major Decisions</h3>

                    <ol>
                        <?php foreach ($majorDecisions as $decision): ?>
                            <li><?= summaryEscape($decision) ?></li>
                        <?php endforeach; ?>
                    </ol>
                </div>

                <div class="hero-narrative">
                    <p><?= summaryEscape($heroNarrative) ?></p>
                </div>

            </section>

            <section class="results-section">

                <h2>Final Results</h2>

                <div class="results-grid">

                    <div class="result-card">
                        <span>Final Score</span>
                        <strong><?= summaryEscape($finalScore) ?></strong>
                    </div>

                    <div class="result-card">
                        <span>Story Completion</span>
                        <strong>Complete</strong>
                    </div>

                </div>

                <p class="results-note">
                    Your final score will be recorded for the leaderboard.
                </p>

            </section>

            <div class="summary-actions">
                <a href="leaderboard.php">View Leaderboard</a>
                <a href="reset_character.php">New Adventure</a>
            </div>

        </main>

        <footer class="summary-footer">
            Three Kingdoms Ascension — Project and Team Credits
        </footer>

    </div>
</body>
</html>
