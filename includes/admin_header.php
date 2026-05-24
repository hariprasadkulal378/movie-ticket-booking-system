<?php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/functions.php';
requireAdmin();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($pageTitle) ? clean($pageTitle) : 'Admin Dashboard'; ?></title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<header class="site-header">
    <nav class="navbar">
        <a class="brand" href="../index.php">CinemaHub Admin</a>
        <button class="nav-toggle" type="button" aria-label="Toggle navigation">Menu</button>
        <div class="nav-links">
            <a href="index.php">Dashboard</a>
            <a href="movies.php">Movies</a>
            <a href="theaters.php">Theaters</a>
            <a href="../movies.php">Public Site</a>
            <a href="../logout.php">Logout</a>
        </div>
    </nav>
</header>
<main>
