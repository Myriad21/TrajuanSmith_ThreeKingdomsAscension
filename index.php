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
        <!-- Hero section with Register and Login button -->
        <div class="hero-section">
            <div class="title-section">
                <img src="images/scroll-banner.png">
                <h1>Three Kingdoms Ascension</h1>
                <p>Three Kingdoms. Three Champions. One Legendary Artifact.</p>
            </div>
            <div class="authentication-section">
                <?php if (isset($_SESSION['user'])): ?>
                    <a href="game.php" class="button">Continue Game</a>
                    <a href="logout.php" class="button">Logout</a>
                <?php else: ?>
                    <a href="register.php" class="button">Register</a>
                    <a href="login.php" class="button">Login</a>
                <?php endif; ?>
            </div>
        </div>
        
        <!-- About section -->
        <section class="about-section">
            <h2>About the Game</h2>
            <p>
                Choose your faction, develop your champion, explore branching narative, and determine
                the fate of the three kingdoms
            </p>
            
            <div class="faction-section">
                <div class="interactive-card" id="warrior-faction">
                    <img src="images/factions/warrior-symbol.jpg">
                    <h3>Warriors</h3>
                </div>
                <div class="interactive-card" id="warrior-faction">
                    <img src="images/factions/mage-symbol.jpg">
                    <h3>Mages</h3>
                </div>
                <div class="interactive-card" id="warrior-faction">
                    <img src="images/factions/rogue-symbol.jpg">
                    <h3>Rogues</h3>
                </div>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer class="site-footer">
        <p>&copy; 2026 Three Kingdom Ascension. All rights reserved.</p>
    </footer>
    
</body>
</html>