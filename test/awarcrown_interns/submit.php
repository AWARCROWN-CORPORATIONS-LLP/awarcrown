<?php
header('Content-Type: application/json');

// Debugging (disable in production)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Database connection
$servername = "localhost";
$username = "awarcrownadmin";
$password = "Aditya@1299";
$dbname = "ideaship";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    error_log('Database connection failed: ' . $e->getMessage());
    echo json_encode(['error' => 'Database connection failed.']);
    exit;
}

// Check cookie to prevent multiple submissions
if (isset($_COOKIE['formSubmitted']) && $_COOKIE['formSubmitted'] === 'true') {
    echo json_encode(['error' => 'You have already submitted the form.']);
    exit;
}

// Validate inputs
$errors = [];
$fullName = filter_input(INPUT_POST, 'fullName', FILTER_SANITIZE_SPECIAL_CHARS) ?? '';
$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL) ?? '';
$phone = filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_SPECIAL_CHARS) ?? '';
$address = filter_input(INPUT_POST, 'address', FILTER_SANITIZE_SPECIAL_CHARS) ?? '';
$emergencyContact = filter_input(INPUT_POST, 'emergencyContact', FILTER_SANITIZE_SPECIAL_CHARS) ?? '';
$relationship = filter_input(INPUT_POST, 'relationship', FILTER_SANITIZE_SPECIAL_CHARS) ?? '';
$secondaryPhone = filter_input(INPUT_POST, 'secondaryPhone', FILTER_SANITIZE_SPECIAL_CHARS) ?? '';
$applicant_id = filter_input(INPUT_POST, 'applicant_id', FILTER_SANITIZE_SPECIAL_CHARS) ?? '';

// Server-side validation
if (empty($fullName) || !preg_match("/^[a-zA-Z\s]+$/", $fullName) || strlen($fullName) < 2) {
    $errors[] = "Invalid full name.";
}
if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "Invalid email address.";
}
if (empty($phone) || !preg_match("/^\d{10}$/", $phone)) {
    $errors[] = "Invalid phone number.";
}
if (empty($address) || strlen($address) < 5) {
    $errors[] = "Invalid address.";
}
if (empty($emergencyContact) || !preg_match("/^[a-zA-Z\s]+$/", $emergencyContact) || strlen($emergencyContact) < 2) {
    $errors[] = "Invalid emergency contact name.";
}
if (empty($relationship) || !preg_match("/^[a-zA-Z\s]+$/", $relationship) || strlen($relationship) < 2) {
    $errors[] = "Invalid relationship.";
}
if (empty($secondaryPhone) || !preg_match("/^\d{10}$/", $secondaryPhone)) {
    $errors[] = "Invalid secondary phone number.";
}

// Handle file uploads
$uploadDir = 'uploads/';
if (!is_dir($uploadDir)) {
    if (!mkdir($uploadDir, 0755, true)) {
        error_log('Failed to create uploads directory.');
        $errors[] = "Server error: Unable to create uploads directory.";
    }
}

// Aadhar file
$aadharPath = '';
if (isset($_FILES['aadhar']) && $_FILES['aadhar']['error'] === UPLOAD_ERR_OK) {
    $aadhar = $_FILES['aadhar'];
    $validTypes = ['application/pdf', 'image/jpeg', 'image/png'];
    if (!in_array($aadhar['type'], $validTypes) || $aadhar['size'] > 5 * 1024 * 1024) {
        $errors[] = "Invalid Aadhar file. Must be PDF/JPG/PNG and less than 5MB.";
    } else {
        $aadharExt = pathinfo($aadhar['name'], PATHINFO_EXTENSION);
        $aadharPath = $uploadDir . uniqid('aadhar_') . '.' . $aadharExt;
        if (!move_uploaded_file($aadhar['tmp_name'], $aadharPath)) {
            error_log('Failed to upload Aadhar file: ' . $aadhar['name']);
            $errors[] = "Failed to upload Aadhar file.";
        }
    }
} else {
    $errorCode = isset($_FILES['aadhar']) ? $_FILES['aadhar']['error'] : 'No file uploaded';
    error_log('Aadhar file error: ' . $errorCode);
    $errors[] = "Aadhar file is required.";
}

// Resume file
$resumePath = '';
if (isset($_FILES['resume']) && $_FILES['resume']['error'] === UPLOAD_ERR_OK) {
    $resume = $_FILES['resume'];
    if ($resume['type'] !== 'application/pdf' || $resume['size'] > 5 * 1024 * 1024) {
        $errors[] = "Invalid resume file. Must be PDF and less than 5MB.";
    } else {
        $resumePath = $uploadDir . uniqid('resume_') . '.pdf';
        if (!move_uploaded_file($resume['tmp_name'], $resumePath)) {
            error_log('Failed to upload resume file: ' . $resume['name']);
            $errors[] = "Failed to upload resume file.";
        }
    }
} else {
    $errorCode = isset($_FILES['resume']) ? $_FILES['resume']['error'] : 'No file uploaded';
    error_log('Resume file error: ' . $errorCode);
    $errors[] = "Resume file is required.";
}

// If no validation or upload errors, proceed
if (empty($errors)) {
    try {
        // Check if email already exists
        $checkEmailStmt = $conn->prepare("SELECT COUNT(*) FROM interns WHERE email = :email");
        $checkEmailStmt->execute([':email' => $email]);
        if ($checkEmailStmt->fetchColumn() > 0) {
            echo json_encode(['error' => 'This email has already been submitted.']);
            exit;
        }

        // Check if phone already exists
        $checkPhoneStmt = $conn->prepare("SELECT COUNT(*) FROM interns WHERE phone = :phone");
        $checkPhoneStmt->execute([':phone' => $phone]);
        if ($checkPhoneStmt->fetchColumn() > 0) {
            echo json_encode(['error' => 'This phone number has already been submitted.']);
            exit;
        }

        // Insert into DB
        $stmt = $conn->prepare("INSERT INTO interns (full_name, email, phone, address, emergency_contact, relationship, secondary_phone, aadhar_path, resume_path, applicant_id) 
                                VALUES (:full_name, :email, :phone, :address, :emergency_contact, :relationship, :secondary_phone, :aadhar_path, :resume_path, :applicant_id)");
        $stmt->execute([
            ':full_name' => $fullName,
            ':email' => $email,
            ':phone' => $phone,
            ':address' => $address,
            ':emergency_contact' => $emergencyContact,
            ':relationship' => $relationship,
            ':secondary_phone' => $secondaryPhone,
            ':aadhar_path' => $aadharPath,
            ':resume_path' => $resumePath,
            ':applicant_id' => $applicant_id
        ]);

        // Set cookie to prevent duplicate submission
        setcookie('formSubmitted', 'true', time() + (30 * 24 * 3600), "/");

        echo json_encode(['success' => 'Form submitted successfully!']);
    } catch (PDOException $e) {
        error_log('Database error: ' . $e->getMessage());
        echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['error' => implode(' ', $errors)]);
}
?>