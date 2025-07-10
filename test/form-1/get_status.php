<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Content-Type: application/json');
session_start();

include 'config.php';

if (!isset($_SESSION['email'])) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    exit;
}

// FIX: Use FILTER_SANITIZE_FULL_SPECIAL_CHARS instead of deprecated FILTER_SANITIZE_STRING
$app_number = filter_input(INPUT_POST, 'applicant_id', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

if (empty($app_number)) {
    echo json_encode(['success' => false, 'message' => 'Application number is required']);
    exit;
}

try {
    // Ensure PDO connection is available
    if (!isset($pdo)) {
        throw new Exception("Database connection not found.");
    }

    $stmt = $pdo->prepare("SELECT * FROM interns WHERE applicant_id = ? AND email = ?");
    $stmt->execute([$app_number, $_SESSION['email']]);
    $application = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($application) {
        echo json_encode([
            'success' => true,
            'data' => [
                'applicant_id' => $application['applicant_id'],
                'company_name'=>$application['company'],
                'name' => $application['full_name'],
                'status' => $application['status'],
                'submitted_on' => $application['created_at']
            ]
        ]);
    } else {
        echo json_encode(['success' => false, 'message' => ' Access denied only your applications status can be verified']);
    }
} catch (PDOException $e) {
    error_log("Database error: " . $e->getMessage()); // Log error instead of displaying it
    echo json_encode(['success' => false, 'message' => 'An internal error occurred. Please try again later.']);
} catch (Exception $e) {
    error_log("General error: " . $e->getMessage()); // Log error
    echo json_encode(['success' => false, 'message' => 'An unexpected error occurred.']);
}
?>
