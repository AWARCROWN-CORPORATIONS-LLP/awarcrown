<?php
header('Content-Type: application/json');

try {
    // Log request details for debugging
    error_log("Request Method: " . $_SERVER['REQUEST_METHOD']);
    error_log("Request URI: " . $_SERVER['REQUEST_URI']);
    error_log("Received POST: " . print_r($_POST, true));
    error_log("Received FILES: " . print_r($_FILES, true));

    // Reject non-POST requests
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Invalid request method. POST required.', 405);
    }

    define("INCLUDE_FLAG", true);
    require "config.php";

    // Input validation
    $applicant_id = isset($_POST['applicant_id']) ? htmlspecialchars(trim($_POST['applicant_id']), ENT_QUOTES, 'UTF-8') : '';
    $certificate = $_FILES['certificate'] ?? null;

    if (empty($applicant_id) || !$certificate) {
        throw new Exception('Applicant ID and certificate file are required', 400);
    }

    // Check for file upload errors
    if ($certificate['error'] !== UPLOAD_ERR_OK) {
        $upload_errors = [
            UPLOAD_ERR_INI_SIZE => 'File size exceeds server limit',
            UPLOAD_ERR_FORM_SIZE => 'File size exceeds form limit',
            UPLOAD_ERR_PARTIAL => 'File was only partially uploaded',
            UPLOAD_ERR_NO_FILE => 'No file was uploaded',
            UPLOAD_ERR_NO_TMP_DIR => 'Missing temporary folder',
            UPLOAD_ERR_CANT_WRITE => 'Failed to write file to disk',
            UPLOAD_ERR_EXTENSION => 'File upload stopped by extension'
        ];
        $error_msg = $upload_errors[$certificate['error']] ?? 'Unknown upload error';
        throw new Exception($error_msg, 400);
    }

    // Validate file size (max 5MB)
    $max_file_size = 5 * 1024 * 1024; // 5MB in bytes
    if ($certificate['size'] > $max_file_size) {
        throw new Exception('File size exceeds 5MB limit', 400);
    }

    // Verify file type and check for PDF signature
    if ($certificate['type'] !== 'application/pdf' || !is_valid_pdf($certificate['tmp_name'])) {
        throw new Exception('Only valid PDF files are allowed', 400);
    }

    // Verify applicant exists
    $stmt = $conn->prepare("SELECT applicant_id FROM interns WHERE applicant_id = ?");
    if (!$stmt) {
        throw new Exception('Database query preparation failed: ' . $conn->error, 500);
    }
    $stmt->bind_param("s", $applicant_id);
    if (!$stmt->execute()) {
        throw new Exception('Database query execution failed: ' . $stmt->error, 500);
    }
    $result = $stmt->get_result();
    if ($result->num_rows === 0) {
        throw new Exception('Invalid Applicant ID', 404);
    }
    $stmt->close();

    // Set up upload directory
    $upload_dir = 'certificates/';
    if (!is_dir($upload_dir) && !mkdir($upload_dir, 0755, true) && !is_dir($upload_dir)) {
        throw new Exception('Failed to create upload directory', 500);
    }

    // Generate unique filename
    $filename = $applicant_id . '_' . time() . '_' . bin2hex(random_bytes(4)) . '.pdf';
    $destination = $upload_dir . $filename;

    // Start transaction
    $conn->begin_transaction();
    try {
        // Upload file
        if (!move_uploaded_file($certificate['tmp_name'], $destination)) {
            throw new Exception('Failed to upload certificate', 500);
        }

        // Store in database
        $stmt = $conn->prepare("INSERT INTO certificates (applicant_id, certificate_path) VALUES (?, ?)");
        if (!$stmt) {
            throw new Exception('Database query preparation failed: ' . $conn->error, 500);
        }
        $stmt->bind_param("ss", $applicant_id, $destination);
        if (!$stmt->execute()) {
            throw new Exception('Failed to save certificate details: ' . $stmt->error, 500);
        }

        $conn->commit();
        echo json_encode(['success' => true, 'certificate_path' => $destination]);
    } catch (Exception $e) {
        $conn->rollback();
        throw $e;
    } finally {
        if (isset($stmt)) {
            $stmt->close();
        }
    }
} catch (Exception $e) {
    // Log error
    error_log("Certificate Upload Error: [{$e->getCode()}] {$e->getMessage()} at {$e->getFile()}:{$e->getLine()}");
    
    http_response_code($e->getCode() >= 400 && $e->getCode() < 600 ? $e->getCode() : 500);
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage(),
        'error_code' => $e->getCode()
    ]);
} finally {
    if (isset($conn) && $conn->ping()) {
        $conn->close();
    }
}

// Function to validate PDF file
function is_valid_pdf($file_path) {
    try {
        $handle = fopen($file_path, 'rb');
        if ($handle === false) {
            return false;
        }
        $header = fread($handle, 4);
        fclose($handle);
        return $header === '%PDF';
    } catch (Exception $e) {
        return false;
    }
}
?>