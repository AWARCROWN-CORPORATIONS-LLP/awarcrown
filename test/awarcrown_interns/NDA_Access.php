<?php
// PHP Backend Logic
$servername = "localhost";
$username = "awarcrownadmin";
$password = "Aditya@1299";
$dbname = "ideaship";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    error_log('Database connection failed: ' . $e->getMessage());
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Database connection failed.']);
    exit;
}

$action = isset($_GET['action']) ? $_GET['action'] : '';

if ($action == 'get_intern') {
    header('Content-Type: application/json');
    $data = json_decode(file_get_contents('php://input'), true);
    $applicant_id = $data['applicant_id'] ?? null;

    if (!$applicant_id) {
        echo json_encode(['success' => false, 'message' => 'Applicant ID is required']);
        exit;
    }

    $stmt = $conn->prepare("SELECT id, full_name, email, phone, address, emergency_contact, relationship, secondary_phone, aadhar_path, resume_path, nda_document, created_at,applicant_id FROM interns WHERE applicant_id = ?");
    $stmt->bindValue(1, $applicant_id);
    $stmt->execute();
    $intern = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($intern) {
        echo json_encode(['success' => true, 'intern' => $intern]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid Applicant ID']);
    }
    exit;
}

if ($action == 'get_interns') {
    header('Content-Type: application/json');
    $result = $conn->query("SELECT * FROM interns");
    $interns = [];
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        $interns[] = $row;
    }
    echo json_encode(['success' => true, 'interns' => $interns]);
    exit;
}

if ($action == 'add_intern') {
    header('Content-Type: application/json');
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
    $show_application_id=$_POST['applicant_id'];
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
    exit;
}

if ($action == 'download_nda') {
    $applicant_id = $_GET['applicant_id'] ?? null;
    if (!$applicant_id) {
        header('Content-Type: application/json');
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
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'File not found']);
    exit;
}

if ($action == 'download_resume') {
    $applicant_id = $_GET['applicant_id'] ?? null;
    if (!$applicant_id) {
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'Applicant ID is required']);
        exit;
    }
    $applicant_id = preg_replace('/[^a-zA-Z0-9_-]/', '', $applicant_id);
    $stmt = $conn->prepare("SELECT offer_path FROM interns WHERE applicant_id = ?");
    $stmt->bindValue(1, $applicant_id);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($result && $result['offer_path']) {
        $file_path = $result['offer_path'];
        if (file_exists($file_path)) {
            header('Content-Type: application/pdf');
            header('Content-Disposition: attachment; filename="Offer Letter_' . $applicant_id . '.pdf"');
            readfile($file_path);
            exit;
        }
    }
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'File not found']);
    exit;
}

if ($action == 'download_aadhar') {
    $applicant_id = $_GET['applicant_id'] ?? null;
    if (!$applicant_id) {
        header('Content-Type: application/json');
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
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'File not found']);
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Intern Portal - Download Documents</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
        }
        .container {
            max-width: 600px;
        }
        .btn-primary {
            background-color: #1a73e8;
            transition: background-color 0.3s;
        }
        .btn-primary:hover {
            background-color: #1557b0;
        }
        .btn-secondary {
            background-color: #6b7280;
        }
        .btn-secondary:hover {
            background-color: #4b5563;
        }
    </style>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="container mx-auto p-6 bg-white rounded-lg shadow-lg">
        <h1 class="text-2xl font-bold text-gray-800 mb-6 text-center">Intern Document Download Portal</h1>
        
       
        <div id="step1" class="space-y-4">
            <div>
                <label for="applicant_id" class="block text-sm font-medium text-gray-700">Enter Applicant ID</label>
                <input type="text" id="applicant_id" class="mt-1 block w-full p-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500" placeholder="e.g., AWC-XXXXXXXXXXXXXXXX">
            </div>
            <button onclick="getInternDetails()" class="btn-primary w-full py-2 px-4 text-white rounded-md">Get Intern Details</button>
        </div>

     
        <div id="step2" class="space-y-4 hidden">
            <h2 class="text-lg font-semibold text-gray-800">Intern Details</h2>
            <div id="intern-details" class="bg-gray-50 p-4 rounded-md"></div>
            <div class="flex space-x-4">
                <button onclick="downloadNDA()" class="btn-primary flex-1 py-2 px-4 text-white rounded-md">Download NDA</button>
                <button onclick="downloadResume()" class="btn-secondary flex-1 py-2 px-4 text-white rounded-md">Download Offer letter</button>
                <button onclick="downloadAadhar()" class="btn-secondary flex-1 py-2 px-4 text-white rounded-md">Download Aadhar</button>
            </div>
        </div>

        <div id="error-message" class="text-red-500 text-sm mt-4 hidden"></div>
    </div>

    <script>
        async function getInternDetails() {
            const applicantId = document.getElementById('applicant_id').value.trim();
            if (!applicantId) {
                showError('Please enter a valid Applicant ID.');
                return;
            }

            try {
                const response = await fetch('?action=get_intern', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ applicant_id: applicantId })
                });
                const data = await response.json();
                if (data.success) {
                    document.getElementById('step1').classList.add('hidden');
                    document.getElementById('step2').classList.remove('hidden');
                    displayInternDetails(data.intern);
                } else {
                    showError(data.message);
                }
            } catch (error) {
                showError('An error occurred. Please try again.');
            }
        }

        function displayInternDetails(intern) {
            const detailsDiv = document.getElementById('intern-details');
            detailsDiv.innerHTML = `
            <p><strong>Applicantation Id:</strong> ${intern.applicant_id || 'N/A'}</p>
                <p><strong>Name:</strong> ${intern.full_name || 'N/A'}</p>
                <p><strong>Email:</strong> ${intern.email || 'N/A'}</p>
                <p><strong>Phone:</strong> ${intern.phone || 'N/A'}</p>
                <p><strong>Address:</strong> ${intern.address || 'N/A'}</p>
                <p><strong>Emergency Contact:</strong> ${intern.emergency_contact || 'N/A'}</p>
                <p><strong>Relationship:</strong> ${intern.relationship || 'N/A'}</p>
                <p><strong>Secondary Phone:</strong> ${intern.secondary_phone || 'N/A'}</p>
                <p><strong>Created At:</strong> ${intern.created_at || 'N/A'}</p>
            `;
        }

        async function downloadNDA() {
            const applicantId = document.getElementById('applicant_id').value.trim();
            window.location.href = `?action=download_nda&applicant_id=${applicantId}`;
        }

        async function downloadResume() {
            const applicantId = document.getElementById('applicant_id').value.trim();
            window.location.href = `?action=download_resume&applicant_id=${applicantId}`;
        }

        async function downloadAadhar() {
            const applicantId = document.getElementById('applicant_id').value.trim();
            window.location.href = `?action=download_aadhar&applicant_id=${applicantId}`;
        }

        function showError(message, isSuccess = true) {
            const errorDiv = document.getElementById('error-message');
            errorDiv.textContent = message;
            errorDiv.classList.remove('hidden');
            errorDiv.classList.toggle('text-red-500', isSuccess);
            errorDiv.classList.toggle('text-green-500', !isSuccess);
        }
    </script>
</body>
</html>
