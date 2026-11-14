<?php
session_start();

if (isset($_SESSION['user'])) {
    // Redirect logged-in players to the game
    header("Location: game.php");
    exit();
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
    <link rel="stylesheet" href="assets/css/home.css">
</head>
<body>

    <!-- Header with navigation -->
    <header class="site-header">
        <nav class="site-nav" aria-label="Main navigation">
            <a href="index.php" class="site-logo">
                Three Kingdoms Ascension
            </a>

            <ul class="nav-links">
                <li><a href="index.php" aria-current="page">Home</a></li>
                <li><a href="leaderboard.php">Leaderboard</a></li>

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
        <section class="hero-section">
            <img src="images/favicon.ico" alt="Game logo">
            <h1>
                Three Kingdoms Ascension
            </h1>
            <p>
                Three Kingdoms. Three Champions. One Legendary Artifact.
            </p>
            <div class="authentication-section">
                <?php if (isset($_SESSION['user'])): ?>
                    <a href="game.php" class="btn">Continue Game</a>
                    <a href="logout.php" class="btn">Logout</a>
                <?php else: ?>
                    <a href="register.php" class="btn">Register</a>
                    <a href="login.php" class="btn">Login</a>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer class="site-footer">
        <p>&copy; 2026 Three Kingdom Ascension. All rights reserved.</p>
    </footer>
    
</body>
</html>