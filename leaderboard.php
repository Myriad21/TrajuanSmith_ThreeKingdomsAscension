
<?php
session_start();

require_once __DIR__ . "/includes/score_functions.php";

$leaderboardFile = __DIR__ . "/storage/saves.json";
$leaderboard = [];
$errors = [];

$endingLabels = [
    "act3_faction_victory" => "Faction Victory",
    "act3_faction_defeat" => "Faction Defeat",
    "act3_secret_ending" => "Threefold Accord"
];

if (!is_file($leaderboardFile)) {
    $errors[] = "Player save storage is missing.";
} else {
    $saves = json_decode(
        file_get_contents($leaderboardFile),
        true
    );

    if (!is_array($saves)) {
        $errors[] = "Unable to read player saves.";
    } else {
        foreach ($saves as $userId => $save) {
            if (!is_array($save) ||
                !isset($save["champion"]) ||
                !is_array($save["champion"])) {
                continue;
            }

            $champion = $save["champion"];
            $level = (int) ($champion["level"] ?? 1);
            $storyNode = $save["story_node"] ?? "introduction";
            $storyFlags = $save["story_flags"] ?? [];

            if (!is_array($storyFlags)) {
                $storyFlags = [];
            }

            $score = calculateFinalScore(
                $storyFlags,
                $storyNode,
                $level
            );

            $leaderboard[] = [
                "user_id" => (string) $userId,
                "champion_name" => $champion["name"] ?? "Unknown",
                "faction" => ucfirst($champion["faction"] ?? "Unknown"),
                "level" => $level,
                "ending" => $endingLabels[$storyNode] ?? "—",
                "score" => $score
            ];
        }

        usort($leaderboard, function ($a, $b) {
            return $b["score"] <=> $a["score"];
        });
    }
}
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Fill out description here">
    <title>Three Kingdoms Ascension</title>
    <link rel="icon" type="image/x-icon" href="images/favicon.ico">
    
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="assets/css/navigation.css">
    <link rel="stylesheet" href="assets/css/leaderboard.css">
</head>
<body>

    <!-- Header with navigation -->
    <header class="site-header">
        <nav class="site-nav" aria-label="Main navigation">
            <a href="index.php" class="site-logo">
                Three Kingdoms Ascension
            </a>

            <ul class="nav-links">
                <li><a href="index.php">Home</a></li>
                <li><a href="leaderboard.php" aria-current="page">Leaderboard</a></li>

                <?php if (isset($_SESSION['user'])): ?>
                    <li><a href="game.php">Continue Game</a></li>
                    <li><a href="logout.php">Logout</a></li>
                <?php else: ?>
                    <li><a href="register.php">Register</a></li>
                    <li><a href="login.php">Login</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>

    <!-- Main content -->
    <main>
        <section class="leaderboard-section">
            <h1>Hall of Champions</h1>
            <p class="leaderboard-description">
                Discover the greatest champions across the Three Kingdoms.
            </p>
            <?php if (!empty($errors)): ?>
                <div class="error-message" role="alert">
                    <?php foreach ($errors as $error): ?>
                        <p>
                            <?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?>
                        </p>
                    <?php endforeach; ?>
                </div>
            <?php elseif (empty($leaderboard)): ?>
                <p class="empty-leaderboard">
                    No warriors have appeared on the leaderboard yet.
                </p>
            <?php else: ?>
                
                <div class="leaderboard-table-wrapper">
                    <table class="leaderboard-table">
                        <thead>
                            <tr>
                                <th>Rank</th>
                                <th>Champion</th>
                                <th>Faction</th>
                                <th>Level</th>
                                <th>Ending Achieved</th>
                                <th>Score</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php foreach ($leaderboard as $index => $player): ?>
                                <tr>
                                    <td><?= $index + 1 ?></td>

                                    <td>
                                        <?= htmlspecialchars(
                                            $player['champion_name'],
                                            ENT_QUOTES,
                                            'UTF-8'
                                        ) ?>
                                    </td>

                                    <td>
                                        <?= htmlspecialchars(
                                            $player['faction'],
                                            ENT_QUOTES,
                                            'UTF-8'
                                        ) ?>
                                    </td>

                                    <td>
                                        <?= (int) $player['level'] ?>
                                    </td>

                                    <td>
                                        <?= htmlspecialchars(
                                            $player['ending'],
                                            ENT_QUOTES,
                                            'UTF-8'
                                        ) ?>
                                    </td>

                                    <td class="score-cell">
                                        <?= number_format($player['score']) ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

            <?php endif; ?>
        </section>
    </main>


    <!-- Footer -->
    <footer class="site-footer">
        <p>&copy; 2026 Three Kingdom Ascension. All rights reserved.</p>
    </footer>
    
</body>
</html>