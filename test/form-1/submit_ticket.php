<?php
session_start();
require_once '../config/db.php'; // Include your database connection file

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['error' => 'User not logged in']);
    exit;
}

$user_id = $_SESSION['user_id'];
$subject = trim($_POST['subject']);
$message = trim($_POST['message']);

if (empty($subject) || empty($message)) {
    echo json_encode(['error' => 'Subject and message cannot be empty']);
    exit;
}

$sql = "INSERT INTO support_tickets (user_id, subject, message) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("iss", $user_id, $subject, $message);

if ($stmt->execute()) {
    echo json_encode(['success' => 'Ticket submitted successfully!']);
} else {
    echo json_encode(['error' => 'Failed to submit ticket']);
}

$stmt->close();
$conn->close();
?>
