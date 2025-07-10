<?php
header('Content-Type: application/json');

// Database connection (update with your credentials)
$host = 'localhost';
$dbname = 'ideaship';
$username = 'awarcrownadmin';
$password = 'Aditya@1299';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Get the application number from POST request
    $application_number = $_POST['application_number'] ?? '';

    if (empty($application_number)) {
        echo json_encode(['success' => false, 'message' => 'Application number is required']);
        exit;
    }

    // Query the database
    $stmt = $pdo->prepare("SELECT application_number, name, status, submitted_on FROM core_team_application WHERE application_number = ?");
    $stmt->execute([$application_number]);
    $data = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($data) {
        echo json_encode(['success' => true, 'data' => $data]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Application not found']);
    }
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
}
?>