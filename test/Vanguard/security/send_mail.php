<?php
if(!defined("INCLUDE_FLAG")){
    header("https://cybertron7.in/security/unauthorisedaccess.awc");
}

$query = "SELECT id, recipient, subject, message FROM email_queue WHERE status = 'pending' LIMIT 10";
$stmt = $conn->prepare($query);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($id, $recipient, $subject, $message);

while ($stmt->fetch()) {
    $headers = "From: support@cybertron7.in\r\n";
    $headers .= "Reply-To: support@cybertron7.in\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

    if (mail($recipient, $subject, $message, $headers)) {
        $update = $conn->prepare("UPDATE email_queue SET status = 'sent', sent_at = NOW() WHERE id = ?");
        $update->bind_param("i", $id);
        $update->execute();
        $update->close();
    } else {
        $update = $conn->prepare("UPDATE email_queue SET status = 'failed' WHERE id = ?");
        $update->bind_param("i", $id);
        $update->execute();
        $update->close();
    }
}

?>

