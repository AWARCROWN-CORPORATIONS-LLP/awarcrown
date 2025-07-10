<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$db_server = "localhost";
$db_user = "awarcrownadmin";
$db_pass = "Aditya@1299";
$db_name = "ideaship";

try {
    $pdo = new PDO("mysql:host=$db_server;dbname=$db_name;charset=utf8mb4", $db_user, $db_pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>
