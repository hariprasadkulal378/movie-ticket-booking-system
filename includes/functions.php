<?php
// Small helper functions used across the project.

function isLoggedIn()
{
    return isset($_SESSION['user_id']);
}

function isAdmin()
{
    return isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
}

function requireLogin()
{
    if (!isLoggedIn()) {
        header('Location: login.php');
        exit;
    }
}

function requireAdmin()
{
    if (!isAdmin()) {
        header('Location: ../login.php');
        exit;
    }
}

function clean($value)
{
    return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8');
}
?>
