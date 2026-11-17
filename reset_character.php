
<?php
session_start();

// Require authentication before resetting a champion.
if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit;
}

// Only allow POST requests to reset a champion.
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: character_confirm.php");
    exit;
}

// Clear the current champion.
unset($_SESSION["champion"]);

header("Location: character.php");
exit;
