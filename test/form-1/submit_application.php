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
    $intern_id = $data['intern_id'] ?? null;

    if (!$intern_id) {
        echo json_encode(['success' => false, 'message' => 'Intern ID is required']);
        exit;
    }

    $stmt = $conn->prepare("SELECT * FROM interns WHERE id = ?");
    $stmt->bindValue(1, $intern_id);
    $stmt->execute();
    $intern = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($intern) {
        echo json_encode(['success' => true, 'intern' => $intern]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid Intern ID']);
    }
}

if ($action == 'add_intern') {
    $required_fields = ['intern_id', 'name', 'email'];
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

    $intern_id = preg_replace('/[^a-zA-Z0-9_-]/', '', $_POST['intern_id']); 
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = isset($_POST['phone']) ? $_POST['phone'] : null;
    $address = isset($_POST['address']) ? $_POST['address'] : null;
    $guardian_name = isset($_POST['guardian_name']) ? $_POST['guardian_name'] : null;
    $guardian_phone = isset($_POST['guardian_phone']) ? $_POST['guardian_phone'] : null;
    $college_name = isset($_POST['college_name']) ? $_POST['college_name'] : null;

    $upload_dir = 'Uploads/';
    if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);

    $resume_path = $nda_path = $offer_letter_path = null;

    if (isset($_FILES['resume']) && $_FILES['resume']['error'] == 0) {
        $allowed_types = ['application/pdf'];
        if (in_array($_FILES['resume']['type'], $allowed_types) && $_FILES['resume']['size'] <= 5 * 1024 * 1024) {
            $resume_path = $upload_dir . 'resume_' . $intern_id . '.pdf';
            move_uploaded_file($_FILES['resume']['tmp_name'], $resume_path);
        } else {
            echo json_encode(['success' => false, 'message' => 'Invalid resume file']);
            exit;
        }
    }
    if (isset($_FILES['nda_document']) && $_FILES['nda_document']['error'] == 0) {
        $allowed_types = ['application/pdf'];
        if (in_array($_FILES['nda_document']['type'], $allowed_types) && $_FILES['nda_document']['size'] <= 5 * 1024 * 1024) {
            $nda_path = $upload_dir . 'nda_' . $intern_id . '.pdf';
            move_uploaded_file($_FILES['nda_document']['tmp_name'], $nda_path);
        } else {
            echo json_encode(['success' => false, 'message' => 'Invalid NDA document']);
            exit;
        }
    }
    if (isset($_FILES['offer_letter']) && $_FILES['offer_letter']['error'] == 0) {
        $allowed_types = ['application/pdf'];
        if (in_array($_FILES['offer_letter']['type'], $allowed_types) && $_FILES['offer_letter']['size'] <= 5 * 1024 * 1024) {
            $offer_letter_path = $upload_dir . 'offer_letter_' . $intern_id . '.pdf';
            move_uploaded_file($_FILES['offer_letter']['tmp_name'], $offer_letter_path);
        } else {
            echo json_encode(['success' => false, 'message' => 'Invalid offer letter file']);
            exit;
        }
    }

    $stmt = $conn->prepare("INSERT INTO interns_data (intern_id, name, email, phone, resume, address, guardian_name, guardian_phone, college_name, nda_document, offer_letter) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bindValue(1, $intern_id);
    $stmt->bindValue(2, $name);
    $stmt->bindValue(3, $email);
    $stmt->bindValue(4, $phone);
    $stmt->bindValue(5, $resume_path);
    $stmt->bindValue(6, $address);
    $stmt->bindValue(7, $guardian_name);
    $stmt->bindValue(8, $guardian_phone);
    $stmt->bindValue(9, $college_name);
    $stmt->bindValue(10, $nda_path);
    $stmt->bindValue(11, $offer_letter_path);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Intern added successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to add intern']);
    }
}

if ($action == 'get_interns') {
    $result = $conn->query("SELECT id, full_name, email FROM interns");
    $interns = [];
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        $interns[] = $row;
    }
    echo json_encode(['success' => true, 'interns' => $interns]);
}

if ($action == 'download_nda') {
    $intern_id = $_GET['intern_id'] ?? null;
    if (!$intern_id) {
        echo json_encode(['success' => false, 'message' => 'Intern ID is required']);
        exit;
    }
    $intern_id = preg_replace('/[^a-zA-Z0-9_-]/', '', $intern_id);
    $stmt = $conn->prepare("SELECT nda_document FROM interns_data WHERE id = ?");
    $stmt->bindValue(1, $intern_id);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($result && $result['nda_document']) {
        $file_path = $result['nda_document'];
        if (file_exists($file_path)) {
            header('Content-Type: application/pdf');
            header('Content-Disposition: attachment; filename="NDA_' . $intern_id . '.pdf"');
            readfile($file_path);
            exit;
        }
    }
    echo json_encode(['success' => false, 'message' => 'File not found']);
}

if ($action == 'download_resume') {
    $intern_id = $_GET['intern_id'] ?? null;
    if (!$intern_id) {
        echo json_encode(['success' => false, 'message' => 'Intern ID is required']);
        exit;
    }
    $intern_id = preg_replace('/[^a-zA-Z0-9_-]/', '', $intern_id);
    $stmt = $conn->prepare("SELECT offer_path FROM interns WHERE id = ?");
    $stmt->bindValue(1, $intern_id);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($result && $result['resume']) {
        $file_path = $result['resume'];
        if (file_exists($file_path)) {
            header('Content-Type: application/pdf');
            header('Content-Disposition: attachment; filename="Offer Letter_' . $intern_id . '.pdf"');
            readfile($file_path);
            exit;
        }
    }
    echo json_encode(['success' => false, 'message' => 'File not found']);
}

if ($action == 'download_offer_letter') {
    $intern_id = $_GET['intern_id'] ?? null;
    if (!$intern_id) {
        echo json_encode(['success' => false, 'message' => 'Intern ID is required']);
        exit;
    }
    $intern_id = preg_replace('/[^a-zA-Z0-9_-]/', '', $intern_id);
    $stmt = $conn->prepare("SELECT offer_letter FROM interns_data WHERE intern_id = ?");
    $stmt->bindValue(1, $intern_id);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($result && $result['offer_letter']) {
        $file_path = $result['offer_letter'];
        if (file_exists($file_path)) {
            header('Content-Type: application/pdf');
            header('Content-Disposition: attachment; filename="Offer_Letter_' . $intern_id . '.pdf"');
            readfile($file_path);
            exit;
        }
    }
    echo json_encode(['success' => false, 'message' => 'File not found']);
}

$conn->close();
?>