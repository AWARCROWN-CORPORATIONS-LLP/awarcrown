<?php
include 'config.php';

$query = $pdo->prepare("SELECT * FROM email_queue_intern WHERE status = 'pending' LIMIT 10");
$query->execute();
$emails = $query->fetchAll(PDO::FETCH_ASSOC);

foreach ($emails as $email) {
    $to = $email['to_email'];
    $subject = $email['subject'];
    $message = $email['message'];
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8" . "\r\n";
    $headers .= "From: support@cybertron7.in\r\n" .
                "Reply-To: support@cybertron7.in\r\n" .
                "X-Mailer: PHP/" . phpversion();

    if (mail($to, $subject, $message, $headers)) {
        // Mark email as sent
        $update = $pdo->prepare("UPDATE email_queue_intern SET status = 'sent' WHERE id = ?");
        $update->execute([$email['id']]);
    } else {
        // Retry later
        $update = $pdo->prepare("UPDATE email_queue_intern SET status = 'failed' WHERE id = ?");
        $update->execute([$email['id']]);
    }
}

echo "Email queue processed successfully.";
?>
