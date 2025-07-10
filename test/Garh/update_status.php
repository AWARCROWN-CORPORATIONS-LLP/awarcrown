<?php
ob_start();
header('Content-Type: application/json');

ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(E_ALL);
ini_set('log_errors', 1);
ini_set('error_log', 'php_errors.log');

$db_server = "localhost";
$db_user = "awarcrownadmin";
$db_pass = "Aditya@1299";
$db_name = "ideaship";

try {
    $pdo = new PDO("mysql:host=$db_server;dbname=$db_name;charset=utf8mb4", $db_user, $db_pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $id = isset($_POST['id']) ? (int) $_POST['id'] : 0;
    $status = isset($_POST['status']) ? trim($_POST['status']) : '';

    if ($id <= 0 || !in_array($status, ['approved', 'rejected', 'pending'])) {
        echo json_encode(['success' => false, 'message' => 'Invalid input data']);
        exit;
    }

    $stmt = $pdo->prepare("UPDATE internship_applications SET status = ? WHERE id = ?");
    $stmt->execute([$status, $id]);

    echo json_encode(['success' => true, 'message' => 'Status updated successfully']);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Unexpected error: ' . $e->getMessage()]);
}

ob_end_flush();
?>
