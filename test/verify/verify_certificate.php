<?php
header('Content-Type: application/json');
define("INCLUDE_FLAG",true);
require "config.php";

$applicant_id = $_POST['applicant_id'] ?? '';

if (empty($applicant_id)) {
    echo json_encode(['success' => false, 'message' => 'Applicant ID is required']);
    exit;
}

$stmt = $conn->prepare("SELECT u.applicant_id, u.name, u.email, c.certificate_path 
                        FROM user_profiles u 
                        LEFT JOIN certificates c ON u.applicant_id = c.applicant_id 
                        WHERE u.applicant_id = ?");
$stmt->bind_param("s", $applicant_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $email = $row['email'];
    $email_parts = explode('@', $email);
    $email_masked = substr($email_parts[0], 0, 6) . str_repeat('*', max(0, strlen($email_parts[0]) - 6)) . '@' . $email_parts[1];
    
    echo json_encode([
        'success' => true,
        'applicant_id' => $row['applicant_id'],
        'name' => $row['name'],
        'email' => $email_masked,
        'certificate_path' => $row['certificate_path'] ?? ''
    ]);
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid Applicant ID']);
}

$stmt->close();
$conn->close();
?>