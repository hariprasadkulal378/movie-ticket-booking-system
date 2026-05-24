<?php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/functions.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($pageTitle) ? clean($pageTitle) : 'Movie Ticket Booking'; ?></title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<header class="site-header">
    <nav class="navbar">
        <a class="brand" href="index.php">CinemaHub</a>
        <button class="nav-toggle" type="button" aria-label="Toggle navigation">Menu</button>
        <div class="nav-links">
            <a href="index.php">Home</a>
            <a href="movies.php">Movies</a>
            <?php if (isLoggedIn()) : ?>
                <a href="history.php">Booking History</a>
                <?php if (isAdmin()) : ?>
                    <a href="admin/index.php">Admin</a>
                <?php endif; ?>
                <a href="logout.php">Logout</a>
            <?php else : ?>
                <a href="login.php">Login</a>
                <a class="nav-cta" href="register.php">Register</a>
            <?php endif; ?>
        </div>
    </nav>
</header>
<main>
