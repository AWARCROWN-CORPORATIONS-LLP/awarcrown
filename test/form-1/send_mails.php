<?php
include 'config.php';

try {
    // Ensure PDO connection is available
    if (!isset($pdo)) {
        throw new Exception("Database connection not found.");
    }

    // Fetch pending emails (limit to 10 at a time)
    $stmt = $pdo->prepare("SELECT * FROM email_queue_intern WHERE status = 'pending' LIMIT 10");
    $stmt->execute();
    $emails = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (empty($emails)) {
        echo "No pending emails to process.";
        exit;
    }

    foreach ($emails as $email) {
        $to = $email['to_email'];
        $subject = $email['subject'];
        $message = $email['message'];

        // Improved email headers
        $headers = "From: support@cybertron7.in\r\n";
        $headers .= "Reply-To: support@cybertron7.in\r\n";
        $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

        // Send email
        $success = mail($to, $subject, $message, $headers);

        // Log errors if mail fails
        if (!$success) {
            error_log("Email failed to send to $to. Subject: $subject");
        }

        // Update email status in the database
        $updateStmt = $pdo->prepare("UPDATE email_queue_intern SET status = ? WHERE id = ?");
        $updateStmt->execute([$success ? 'sent' : 'failed', $email['id']]);
    }

    echo "Email queue processed successfully.";
} catch (Exception $e) {
    error_log("Error processing email queue: " . $e->getMessage());
    echo "An error occurred while processing emails.";
}
?>
