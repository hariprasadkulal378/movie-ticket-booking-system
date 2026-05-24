<?php
// config.php connects every PHP page to the MySQL database.
// Update these values if your XAMPP MySQL username/password is different.
$host = 'localhost';
$database = 'movie_ticket_booking';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;port=3307;dbname=$database;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $error) {
    die('Database connection failed: ' . $error->getMessage());
}

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
