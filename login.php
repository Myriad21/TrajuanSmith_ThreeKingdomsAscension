<?php
session_start();

// Redirect logged-in users to the game
if (isset($_SESSION['user'])) {
    header("Location: game.php");
    exit();
}

$errors = [];
$username = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    $usersFile = 'storage/users.json';

    if (!file_exists($usersFile)) {
        $errors[] = "User storage file is missing.";
    }

    if (empty($errors)) {
        $jsonData = file_get_contents($usersFile);
        if ($jsonData === false) {
            $errors[] = "Unable to access user storage.";
        } else {
            $users = json_decode($jsonData, true);
            if (
                json_last_error() !== JSON_ERROR_NONE ||
                !is_array($users)
            ) {
                $errors[] = "Unable to read user storage.";
            }
        }
    }

    if (empty($errors)) {
        $authenticated = false;

        foreach ($users as $user) {
            if (
                isset($user['username'], $user['password']) &&
                strcasecmp($user['username'], $username) === 0
            ) {
                if (password_verify($password, $user['password'])) {
                    $authenticated = true;
                    session_regenerate_id(true);

                    $_SESSION['user'] = $user['id'];
                    $_SESSION['username'] = $user['username'];

                    header("Location: game.php");
                    exit();
                }
                break;
            }
        }
        if (!$authenticated) {
            $errors[] = "Invalid username or password.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Create your Three Kingdoms Ascension account.">
    <title>Login - Three Kingdoms Ascension</title>
    <link rel="icon" href="images/favicon.ico">

    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="assets/css/navigation.css">
    <link rel="stylesheet" href="assets/css/auth.css">
</head>

<body class="<?= !empty($errors) ? 'auth-error' : 'auth-default' ?>">
    <header class="site-header">
        <nav class="site-nav" aria-label="Main navigation">
            <a href="index.php" class="site-logo">
                Three Kingdoms Ascension
            </a>
            <ul class="nav-links">
                <li><a href="index.php">Home</a></li>
                <li><a href="leaderboard.php">Leaderboard</a></li>
                <li><a href="register.php">Register</a></li>
                <li><a href="login.php" aria-current="page">Login</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <section class="login-section">
            <h1>Welcome Back</h1>
            <p>Continue your journey across the three kingdoms.</p>

            <form action="login.php" method="POST">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input
                        type="text"
                        id="username"
                        name="username"
                        value="<?= htmlspecialchars($username, ENT_QUOTES, 'UTF-8') ?>"
                        required
                        autocomplete="username"
                    >
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        required
                        autocomplete="current-password"
                    >
                </div>

                <?php if (!empty($errors)): ?>
                    <div class="error-message" role="alert">
                        <h2>YOU SHALL NOT PASS!</h2>
                        <ul>
                            <?php foreach ($errors as $error): ?>
                                <li>
                                    <?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php else: ?>
                    <h2>Ready to Return?</h2>
                <?php endif; ?>
                <button type="submit" class="button">
                    Login
                </button>
            </form>

            <p class="register-link">
                Don't have an account?
                <a href="register.php">Register here</a>
            </p>
        </section>
    </main>

    <footer class="site-footer">
        <p>
            &copy; 2026 Three Kingdoms Ascension. All rights reserved.
        </p>
    </footer>
</body>
</html>
