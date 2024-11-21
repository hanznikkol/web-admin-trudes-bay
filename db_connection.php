<?php
// Database connection configuration
$host = 'localhost';
$dbname = 'db_trudes';
$username = 'root';
$password = '';

try {
    // Create a connection using PDO
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
