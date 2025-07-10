<?php
require "database/config.php";

header('Content-Type: application/json');

$action = isset($_GET['action']) ? $_GET['action'] : $_POST['action'];

switch ($action) {
    case 'send_email':
        $to = $_POST['to'];
        $cc = $_POST['cc'] ?? '';
        $bcc = $_POST['bcc'] ?? '';
        $subject = $_POST['subject'];
        $body = $_POST['body'];
        $header = $_POST['header'] ?? '';
        $attachments = $_FILES['attachments'] ?? [];

        // Prepare email headers
        $headers = [
            "From: Awarcrown Corporations <support@cybertron7.in>",
            "MIME-Version: 1.0",
            "Content-Type: multipart/mixed; boundary=\"boundary_" . uniqid() . "\""
        ];
        if ($cc) {
            $headers[] = "Cc: " . $cc;
        }
        if ($bcc) {
            $headers[] = "Bcc: " . $bcc;
        }
        if ($header) {
            $headers[] = $header;
        }

        // Prepare email body
        $message = "--boundary_" . uniqid() . "\r\n";
        $message .= "Content-Type: text/html; charset=UTF-8\r\n\r\n";
        $message .= nl2br(htmlspecialchars($body)) . "<br><br><p style=\"font-size: 12px; color: #777;\">Powered by Awarcrown Corporations</p>\r\n";

        // Handle attachments
        if (!empty($attachments['name'][0])) {
            for ($i = 0; $i < count($attachments['name']); $i++) {
                if ($attachments['error'][$i] === UPLOAD_ERR_OK) {
                    $file_path = $attachments['tmp_name'][$i];
                    $file_name = $attachments['name'][$i];
                    $file_content = chunk_split(base64_encode(file_get_contents($file_path)));
                    $message .= "--boundary_" . uniqid() . "\r\n";
                    $message .= "Content-Type: application/octet-stream; name=\"" . $file_name . "\"\r\n";
                    $message .= "Content-Transfer-Encoding: base64\r\n";
                    $message .= "Content-Disposition: attachment; filename=\"" . $file_name . "\"\r\n\r\n";
                    $message .= $file_content . "\r\n";
                }
            }
        }
        $message .= "--boundary_" . uniqid() . "--\r\n";

        // Send email using mail()
        try {
            $success = mail($to, $subject, $message, implode("\r\n", $headers));
            if (!$success) {
                error_log("Failed to send email to: " . $to);
                echo json_encode(['success' => false, 'message' => 'Failed to send email']);
                break;
            }

            // Save email record to database
            $stmt = $conn->prepare("INSERT INTO emails (to_email, cc, bcc, subject, body, header, status) VALUES (?, ?, ?, ?, ?, ?, 'sent')");
            if (!$stmt) {
                error_log("Prepare failed: " . $conn->error);
                echo json_encode(['success' => false, 'message' => 'Database prepare error']);
                break;
            }

            $stmt->bind_param('ssssss', $to, $cc, $bcc, $subject, $body, $header);
            if (!$stmt->execute()) {
                error_log("Execute failed: " . $stmt->error);
                echo json_encode(['success' => false, 'message' => 'Failed to save email record']);
                break;
            }

            echo json_encode(['success' => true, 'message' => 'Email sent successfully']);
        } catch (Exception $e) {
            error_log("Exception: " . $e->getMessage());
            echo json_encode(['success' => false, 'message' => 'Failed to send email: ' . $e->getMessage()]);
        }
        break;

    case 'save_draft':
        $to = $_POST['to'];
        $cc = $_POST['cc'] ?? '';
        $bcc = $_POST['bcc'] ?? '';
        $subject = $_POST['subject'];
        $body = $_POST['body'];
        $header = $_POST['header'] ?? '';

        $stmt = $conn->prepare("INSERT INTO emails (to_email, cc, bcc, subject, body, header, status) VALUES (?, ?, ?, ?, ?, ?, 'draft')");
        if (!$stmt) {
            error_log("Prepare failed: " . $conn->error);
            echo json_encode(['success' => false, 'message' => 'Database prepare error']);
            break;
        }

        $stmt->bind_param('ssssss', $to, $cc, $bcc, $subject, $body, $header);
        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Draft saved successfully']);
        } else {
            error_log("Execute failed: " . $stmt->error);
            echo json_encode(['success' => false, 'message' => 'Failed to save draft']);
        }
        break;

    case 'get_emails':
        $result = $conn->query("SELECT * FROM emails ORDER BY created_at DESC");
        if (!$result) {
            error_log("Query failed: " . $conn->error);
            echo json_encode(['success' => false, 'message' => 'Failed to retrieve emails']);
            break;
        }

        $emails = [];
        while ($row = $result->fetch_assoc()) {
            $emails[] = $row;
        }
        echo json_encode($emails);
        break;

    case 'get_email':
        $id = $_GET['id'];
        $stmt = $conn->prepare("SELECT * FROM emails WHERE id = ?");
        if (!$stmt) {
            error_log("Prepare failed: " . $conn->error);
            echo json_encode(['success' => false, 'message' => 'Database prepare error']);
            break;
        }

        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) {
            echo json_encode($row);
        } else {
            echo json_encode(['success' => false, 'message' => 'Email not found']);
        }
        break;

    case 'delete_email':
        $id = $_GET['id'];
        $stmt = $conn->prepare("DELETE FROM emails WHERE id = ?");
        if (!$stmt) {
            error_log("Prepare failed: " . $conn->error);
            echo json_encode(['success' => false, 'message' => 'Database prepare error']);
            break;
        }

        $stmt->bind_param('i', $id);
        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Email deleted successfully']);
        } else {
            error_log("Execute failed: " . $stmt->error);
            echo json_encode(['success' => false, 'message' => 'Failed to delete email']);
        }
        break;

    default:
        error_log("Invalid action attempted: " . $action);
        echo json_encode(['success' => false, 'message' => 'Invalid action']);
}

$conn->close();
?>