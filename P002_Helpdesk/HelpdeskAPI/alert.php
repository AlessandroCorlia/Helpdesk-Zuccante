<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title id="title"></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/beercss@3.5.1/dist/cdn/beer.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="css/style.css">
    <link rel="shortcut icon" href="img/Logo_zuccante.png">
</head>

<body>
<header class="navbar">
    <nav>
        <button class="circle transparent" id="menuBtn">
            <i>menu</i>
        </button>
        <img src="img/Logo_zuccante.png" alt="Logo" id="logoZ">
        <span class="navbar-brand">Helpdesk ITIS Zuccante</span>
        <?php if (isset($_SESSION['google_loggedin']) && $_SESSION['google_loggedin'] === TRUE) : ?>
            <button class="circle transparent" id="accountIcon">
                <a href="myaccount.php">
                </a>
            </button>
        <?php endif; ?>
    </nav>
</header>

