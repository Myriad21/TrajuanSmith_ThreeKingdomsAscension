<?php
session_start();

if (isset($_SESSION['user'])) {
    header("Location: game.php");
    exit();
}

$errors = [];
$username = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';

    if (strlen($username) < 3 || strlen($username) > 30) {
        $errors[] = "Username must be between 3 and 30 characters.";
    } elseif (!preg_match('/^[a-zA-Z0-9_]+$/', $username)) {
        $errors[] = "Username can only contain letters, numbers and underscores.";
    }

    if (strlen($password) < 8) {
        $errors[] = "Password must contain at least 8 characters.";
    }

    if ($password !== $confirmPassword) {
        $errors[] = "Passwords do not match.";
    }

    $usersFile = 'users.json';

    if (!file_exists($usersFile)) {
        $errors[] = "User storage file is missing.";
    }
    if (empty($errors)) {
        $users = json_decode(
            file_get_contents($usersFile),
            true
        );
        if (!is_array($users)) {
            $errors[] = "Unable to read user storage.";
        } else {
            foreach ($users as $user) {
                if (
                    strcasecmp($user['username'], $username) === 0 ||
                    strcasecmp($user['email'], $email) === 0
                ) {
                    $errors[] = "Username or email is already registered.";
                    break;
                }
            }
        }
    }

    if (empty($errors)) {
        $newUser = [
            'id' => count($users) + 1,
            'username' => $username,
            'email' => $email,
            'password' => password_hash(
                $password,
                PASSWORD_DEFAULT
            )
        ];
        $users[] = $newUser;
        $jsonData = json_encode(
            $users,
            JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES
        );

        if (file_put_contents(
            $usersFile,
            $jsonData . PHP_EOL,
            LOCK_EX
        ) === false) {
            $errors[] = "Registration failed. Please try again.";
        } else {

            session_regenerate_id(true);
            $_SESSION['user'] = $newUser['id'];
            $_SESSION['username'] = $username;
            header("Location: game.php");
            exit();
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
    <title>Register - Three Kingdoms Ascension</title>
    <link rel="icon" href="images/favicon.ico">

    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="assets/css/navigation.css">
    <link rel="stylesheet" href="assets/css/register.css">
</head>

<body>
    <header class="site-header">
        <nav class="site-nav" aria-label="Main navigation">
            <a href="index.php" class="site-logo">
                Three Kingdoms Ascension
            </a>

            <ul class="nav-links">
                <li><a href="index.php" aria-current="page">Home</a></li>
                <li><a href="leaderboard.php">Leaderboard</a></li>
                <li><a href="login.php">Login</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <section class="register-section">
            <h1>Create Your Account</h1>
            <p>Register to begin your journey across the three kingdoms.</p>

            <form action="register.php" method="POST">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input
                        type="text"
                        id="username"
                        name="username"
                        value="<?= htmlspecialchars($username, ENT_QUOTES, 'UTF-8') ?>"
                        required
                    >
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        minlength="8"
                        required
                    >
                </div>

                <div class="form-group">
                    <label for="confirm_password">Confirm Password</label>
                    <input
                        type="password"
                        id="confirm_password"
                        name="confirm_password"
                        minlength="8"
                        required
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
                    <h2>Let's Begin Your Journey</h2>
                <?php endif; ?>

                <button type="submit" class="button">
                    Create Account
                </button>
            </form>

            <p class="login-link">
                Already have an account?
                <a href="login.php">Login here</a>
            </p>
        </section>
    </main>

    <footer class="site-footer">
        <p>&copy; 2026 Three Kingdoms Ascension. All rights reserved.</p>
    </footer>

</body>
</html>
