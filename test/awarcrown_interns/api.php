<?php
header('Content-Type: application/json');

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

$action = isset($_GET['action']) ? $_GET['action'] : '';

if ($action == 'get_intern') {
    $data = json_decode(file_get_contents('php://input'), true);
    $applicant_id = $data['applicant_id'] ?? null;

    if (!$applicant_id) {
        echo json_encode(['success' => false, 'message' => 'Applicant ID is required']);
        exit;
    }

    $stmt = $conn->prepare("SELECT id, full_name, email, phone, address, emergency_contact, relationship, secondary_phone, aadhar_path, resume_path, nda_document, created_at FROM interns WHERE applicant_id = ?");
    $stmt->bindValue(1, $applicant_id);
    $stmt->execute();
    $intern = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($intern) {
        echo json_encode(['success' => true, 'intern' => $intern]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid Applicant ID']);
    }
}

if ($action == 'get_interns') {
    $result = $conn->query("SELECT applicant_id, full_name, email FROM interns");
    $interns = [];
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        $interns[] = $row;
    }
    echo json_encode(['success' => true, 'interns' => $interns]);
}

if ($action == 'add_intern') {
    $required_fields = ['applicant_id', 'full_name', 'email'];
    $missing_fields = [];

    foreach ($required_fields as $field) {
        if (!isset($_POST[$field]) || empty(trim($_POST[$field]))) {
            $missing_fields[] = $field;
        }
    }

    if (!empty($missing_fields)) {
        echo json_encode(['success' => false, 'message' => 'Missing required fields: ' . implode(', ', $missing_fields)]);
        exit;
    }

    $applicant_id = preg_replace('/[^a-zA-Z0-9_-]/', '', $_POST['applicant_id']);
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $phone = isset($_POST['phone']) ? $_POST['phone'] : null;
    $address = isset($_POST['address']) ? $_POST['address'] : null;
    $emergency_contact = isset($_POST['emergency_contact']) ? $_POST['emergency_contact'] : null;
    $relationship = isset($_POST['relationship']) ? $_POST['relationship'] : null;
    $secondary_phone = isset($_POST['secondary_phone']) ? $_POST['secondary_phone'] : null;

    $upload_dir = 'Uploads/';
    if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);

    $aadhar_path = $resume_path = $nda_path = null;

    if (isset($_FILES['resume']) && $_FILES['resume']['error'] == 0) {
        $allowed_types = ['application/pdf'];
        if (in_array($_FILES['resume']['type'], $allowed_types) && $_FILES['resume']['size'] <= 5 * 1024 * 1024) {
            $resume_path = $upload_dir . 'resume_' . $applicant_id . '.pdf';
            move_uploaded_file($_FILES['resume']['tmp_name'], $resume_path);
        } else {
            echo json_encode(['success' => false, 'message' => 'Invalid resume file']);
            exit;
        }
    }

    if (isset($_FILES['aadhar']) && $_FILES['aadhar']['error'] == 0) {
        $allowed_types = ['application/pdf'];
        if (in_array($_FILES['aadhar']['type'], $allowed_types) && $_FILES['aadhar']['size'] <= 5 * 1024 * 1024) {
            $aadhar_path = $upload_dir . 'aadhar_' . $applicant_id . '.pdf';
            move_uploaded_file($_FILES['aadhar']['tmp_name'], $aadhar_path);
        } else {
            echo json_encode(['success' => false, 'message' => 'Invalid Aadhar file']);
            exit;
        }
    }

    if (isset($_FILES['nda_document']) && $_FILES['nda_document']['error'] == 0) {
        $allowed_types = ['application/pdf'];
        if (in_array($_FILES['nda_document']['type'], $allowed_types) && $_FILES['nda_document']['size'] <= 5 * 1024 * 1024) {
            $nda_path = $upload_dir . 'nda_' . $applicant_id . '.pdf';
            move_uploaded_file($_FILES['nda_document']['tmp_name'], $nda_path);
        } else {
            echo json_encode(['success' => false, 'message' => 'Invalid NDA document']);
            exit;
        }
    }

    $stmt = $conn->prepare("INSERT INTO interns (applicant_id, full_name, email, phone, address, emergency_contact, relationship, secondary_phone, aadhar_path, resume_path, nda_document, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())");
    $stmt->bindValue(1, $applicant_id);
    $stmt->bindValue(2, $full_name);
    $stmt->bindValue(3, $email);
    $stmt->bindValue(4, $phone);
    $stmt->bindValue(5, $address);
    $stmt->bindValue(6, $emergency_contact);
    $stmt->bindValue(7, $relationship);
    $stmt->bindValue(8, $secondary_phone);
    $stmt->bindValue(9, $aadhar_path);
    $stmt->bindValue(10, $resume_path);
    $stmt->bindValue(11, $nda_path);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Intern added successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to add intern']);
    }
}

if ($action == 'download_nda') {
    $applicant_id = $_GET['applicant_id'] ?? null;
    if (!$applicant_id) {
        echo json_encode(['success' => false, 'message' => 'Applicant ID is required']);
        exit;
    }
    $applicant_id = preg_replace('/[^a-zA-Z0-9_-]/', '', $applicant_id);
    $stmt = $conn->prepare("SELECT nda_document FROM interns WHERE applicant_id = ?");
    $stmt->bindValue(1, $applicant_id);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($result && $result['nda_document']) {
        $file_path = $result['nda_document'];
        if (file_exists($file_path)) {
            header('Content-Type: application/pdf');
            header('Content-Disposition: attachment; filename="NDA_' . $applicant_id . '.pdf"');
            readfile($file_path);
            exit;
        }
    }
    echo json_encode(['success' => false, 'message' => 'File not found']);
}

if ($action == 'download_resume') {
    $applicant_id = $_GET['applicant_id'] ?? null;
    if (!$applicant_id) {
        echo json_encode(['success' => false, 'message' => 'Applicant ID is required']);
        exit;
    }
    $applicant_id = preg_replace('/[^a-zA-Z0-9_-]/', '', $applicant_id);
    $stmt = $conn->prepare("SELECT resume_path FROM interns WHERE applicant_id = ?");
    $stmt->bindValue(1, $applicant_id);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($result && $result['resume_path']) {
        $file_path = $result['resume_path'];
        if (file_exists($file_path)) {
            header('Content-Type: application/pdf');
            header('Content-Disposition: attachment; filename="Resume_' . $applicant_id . '.pdf"');
            readfile($file_path);
            exit;
        }
    }
    echo json_encode(['success' => false, 'message' => 'File not found']);
}

if ($action == 'download_aadhar') {
    $applicant_id = $_GET['applicant_id'] ?? null;
    if (!$applicant_id) {
        echo json_encode(['success' => false, 'message' => 'Applicant ID is required']);
        exit;
    }
    $applicant_id = preg_replace('/[^a-zA-Z0-9_-]/', '', $applicant_id);
    $stmt = $conn->prepare("SELECT aadhar_path FROM interns WHERE applicant_id = ?");
    $stmt->bindValue(1, $applicant_id);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($result && $result['aadhar_path']) {
        $file_path = $result['aadhar_path'];
        if (file_exists($file_path)) {
            header('Content-Type: application/pdf');
            header('Content-Disposition: attachment; filename="Aadhar_' . $applicant_id . '.pdf"');
            readfile($file_path);
            exit;
        }
    }
    echo json_encode(['success' => false, 'message' => 'File not found']);
}

$conn->close();
?>