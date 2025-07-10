<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
ob_start();

include 'database/cy_config.php'; // Your DB connection

header('Content-Type: application/json');
$response = ['success' => false, 'message' => ''];

function logError($message) {
    $logPath = __DIR__ . '/logs/email_errors.log';
    if (!file_exists(dirname($logPath))) {
        mkdir(dirname($logPath), 0775, true);
    }
    file_put_contents($logPath, "[" . date('Y-m-d H:i:s') . "] $message\n", FILE_APPEND);
}

// Sanitize input
$name = isset($_POST['name']) ? htmlspecialchars(trim($_POST['name'])) : null;
$email = isset($_POST['email']) ? htmlspecialchars(trim($_POST['email'])) : null;
$feedbackType = isset($_POST['feedbackType']) ? htmlspecialchars(trim($_POST['feedbackType'])) : null;
$message = isset($_POST['message']) ? htmlspecialchars(trim($_POST['message'])) : null;

try {
    if (!$name || !$email || !$feedbackType || !$message) {
        throw new Exception("Please fill out all required fields.");
    }

    $ticketID = strtoupper(uniqid('AWC-'));

    // Insert feedback into database
    $stmt = $conn->prepare("INSERT INTO feedback (name, email, feedback_type, message, ticket_id) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $name, $email, $feedbackType, $message, $ticketID);

    if (!$stmt->execute()) {
        throw new Exception("Database error: " . $stmt->error);
    }
    $stmt->close();

    // Prepare email headers and message
    $to = $email;
    $subject = "Cybertron7 Feedback Received - Ticket #$ticketID";
    $headers = "From: Cybertron7 Support <support@cybertron7.in>\r\n";
    $headers .= "Reply-To: support@cybertron7.in\r\n";
    $headers .= "Bcc: naveenjupalli1019@gmail.com, alapatijanardhan19254@gmail.com, adityach0523@gmail.com\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

    $emailMessage = "
        <html><body>
        <h2>Thank you for your feedback, $name!</h2>
        <p>We have received your feedback. Your ticket ID is <strong>$ticketID</strong>.</p>
        <p>We will get back to you soon.</p>
        </body></html>
    ";

    $mailSent = mail($to, $subject, $emailMessage, $headers);

    if ($mailSent) {
        $response['success'] = true;
        $response['message'] = "Feedback submitted and confirmation email sent.";
        $response['ticketID'] = $ticketID;
    } else {
        logError("Mail() failed to send email to $to [Ticket ID: $ticketID]");
        $response['success'] = true;
        $response['message'] = "Feedback submitted, but email delivery failed.";
        $response['ticketID'] = $ticketID;
    }

} catch (Exception $e) {
    logError("Error: " . $e->getMessage());
    $response['message'] = $e->getMessage();
}

$conn->close();
ob_end_clean();
echo json_encode($response);
?>
