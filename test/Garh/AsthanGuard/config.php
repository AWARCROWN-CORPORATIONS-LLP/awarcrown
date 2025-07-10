<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


// Prevent direct access
if (!defined('INCLUDE_FLAG')) {
    include 'security/unauthorisedaccess.php';
    exit; 
}
$db_server = "localhost";
$db_user = "awarcrownadmin";
$db_pass = "Aditya@1299";
$db_name = "cybertron7";
$conn = new mysqli($db_server, $db_user, $db_pass, $db_name);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
