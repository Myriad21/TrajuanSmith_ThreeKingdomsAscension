<?php
session_start();

// Require authentication before starting an adventure.
if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit;
}

// Only accept POST requests.
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: character_confirm.php");
    exit;
}


if (!isset($_SESSION["champion"])) {
    header("Location: character.php");
    exit;
}

$_SESSION["champion"]["adventure_started"] = true;

header("Location: character_confirm.php?started=1");
exit;
