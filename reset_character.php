
<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: character_confirm.php");
    exit;
}

unset($_SESSION["champion"]);

header("Location: character.php");
exit;
