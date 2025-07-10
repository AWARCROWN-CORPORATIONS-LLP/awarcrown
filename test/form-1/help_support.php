<?php
session_start();
header('Content-Type: application/json');

// Database connection (adjust credentials as needed)
$db = new mysqli('localhost', 'username', 'password', 'internship_portal');
if ($db->connect_error) {
    die(json_encode(['error' => 'Database connection failed']));
}

// Check authentication
if (!isset($_SESSION['username']) || !isset($_SESSION['email'])) {
    http_response_code(401);
    echo json_encode(['error' => 'Unauthorized']);
    exit;
}

$user_id = $_SESSION['user_id']; // Assuming user_id is stored in session after login

$method = $_SERVER['REQUEST_METHOD'];
$action = $_GET['action'] ?? '';

switch ($method) {
    case 'GET':
        if ($action === 'faqs') {
            // Fetch all FAQs
            $result = $db->query("SELECT question, answer FROM faqs");
            $faqs = $result->fetch_all(MYSQLI_ASSOC);
            echo json_encode($faqs);
        } elseif ($action === 'tickets') {
            // Fetch user's tickets
            $stmt = $db->prepare("SELECT id, subject, status, created_at FROM support_tickets WHERE user_id = ?");
            $stmt->bind_param('i', $user_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $tickets = $result->fetch_all(MYSQLI_ASSOC);
            echo json_encode($tickets);
        }
        break;

    case 'POST':
        $data = json_decode(file_get_contents('php://input'), true);

        if ($action === 'submit_ticket') {
            // Submit a new ticket
            $subject = $db->real_escape_string($data['subject']);
            $description = $db->real_escape_string($data['description']);
            $stmt = $db->prepare("INSERT INTO support_tickets (user_id, subject, description) VALUES (?, ?, ?)");
            $stmt->bind_param('iss', $user_id, $subject, $description);
            $stmt->execute();
            echo json_encode(['success' => 'Ticket submitted', 'ticket_id' => $db->insert_id]);
        } elseif ($action === 'contact_support') {
            // Submit a contact message
            $message = $db->real_escape_string($data['message']);
            $stmt = $db->prepare("INSERT INTO contact_messages (user_id, message) VALUES (?, ?)");
            $stmt->bind_param('is', $user_id, $message);
            $stmt->execute();
            
            // Send email to support (example using mail())
            $to = 'support@awarcrown.com';
            $subject = 'New Support Message from ' . $_SESSION['username'];
            $body = "User: {$_SESSION['username']}\nEmail: {$_SESSION['email']}\nMessage: $message";
            mail($to, $subject, $body);
            
            echo json_encode(['success' => 'Message sent']);
        }
        break;

    default:
        http_response_code(405);
        echo json_encode(['error' => 'Method not allowed']);
        break;
}

$db->close();
?>