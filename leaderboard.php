<?php
session_start();
$leaderboardFile = 'storage/leaderboard.json';
$leaderboard = [];
$errors = [];

function getPlayerLeague($level) {
    if ($level < 15) {
        return [
            'name' => 'Bronze',
            'badge' => 'assets/images/leagues/bronze.png'
        ];
    }
    if ($level < 30) {
        return [
            'name' => 'Silver',
            'badge' => 'assets/images/leagues/silver.png'
        ];
    }
    return [
        'name' => 'Gold',
        'badge' => 'assets/images/leagues/gold.png'
    ];
}

if (!file_exists($leaderboardFile)) {
    $errors[] = "Leaderboard storage file is missing.";
} else {
    $leaderboardData = json_decode(
        file_get_contents($leaderboardFile),
        true
    );
    if (!is_array($leaderboardData)) {
        $errors[] = "Unable to read leaderboard data.";
    } else {
        usort($leaderboardData, function ($a, $b) {
            return ($b['level'] ?? 0) <=> ($a['level'] ?? 0);
        });
        foreach ($leaderboardData as $player) {
            $level = (int) $player['level'];
            $leaderboard[] = [
                'user_id' => (int) $player['user_id'],
                'champion_name' => $player['champion_name'],
                'kingdom' => $player['kingdom'],
                'level' => $level,
                'league' => getPlayerLeague($level)
            ];
        }
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
                            <th>Kingdom</th>
                            <th>Level</th>
                            <th>League</th>
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
                                        $player['kingdom'],
                                        ENT_QUOTES,
                                        'UTF-8'
                                    ) ?>
                                </td>
                                <td><?= $player['level'] ?></td>
                                <td>
                                    <div class="league-badge">
                                        <img
                                            src="<?= htmlspecialchars($player['league']['badge'], ENT_QUOTES, 'UTF-8') ?>"
                                            alt="<?= htmlspecialchars($player['league']['name'], ENT_QUOTES, 'UTF-8') ?> League"
                                        >
                                        <span>
                                            <?= htmlspecialchars($player['league']['name'], ENT_QUOTES, 'UTF-8') ?>
                                        </span>
                                    </div>
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