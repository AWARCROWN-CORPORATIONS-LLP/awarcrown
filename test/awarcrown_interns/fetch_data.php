<?php
header('Content-Type: application/json');

$host = "localhost";
$dbname = "ideaship";
$username = "awarcrownadmin";
$password = "Aditya@1299";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $pdo->query("SELECT * FROM interns ORDER BY created_at DESC");
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Sanitize data to prevent XSS
    foreach ($data as &$row) {
        foreach ($row as $key => $value) {
            $row[$key] = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
        }
    }

    echo json_encode($data);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
}
?>