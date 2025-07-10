<?php
header('Content-Type: application/json');

$host = 'localhost';
$dbname = 'ideaship';
$username = 'awarcrownadmin';
$password = 'Aditya@1299';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Database connection failed.']);
    exit;
}

function generateApplicationId() {
    return 'AWC' . date('Ymd') . strtoupper(substr(uniqid(), -5));
}

function sendEmail($to, $appId, $details) {
    $subject = "Confirmation - Internship Application Received (ID: $appId)";

    $message = "
    <html>
    <head>
      <style>
        body { font-family: 'Segoe UI', sans-serif; color: #2c3e50; background: #f8f9fa; }
        .container { max-width: 600px; margin: auto; background: #fff; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 10px rgba(0,0,0,0.06); }
        .header { background-color: #004578; color: white; padding: 20px; text-align: center; }
        .content { padding: 20px; }
        .details { background: #f1f3f4; padding: 15px; border-radius: 6px; }
        .footer { text-align: center; padding: 20px; font-size: 13px; color: #666; background: #f0f0f0; }
        h2 { margin-top: 0; }
      </style>
    </head>
    <body>
      <div class='container'>
        <div class='header'>
          <h2>Awarcrown Corporations LLP</h2>
          <p>Your Application Has Been Received</p>
        </div>
        <div class='content'>
          <p>Dear <strong>{$details['name']}</strong>,</p>
          <p>Thank you for applying for an internship role at <strong>Awarcrown Corporations</strong>. We have successfully received your application. Our team will review your details and get in touch with you shortly.</p>
          <div class='details'>
            <p><strong>Application ID:</strong> $appId</p>
            <p><strong>Role:</strong> {$details['role']}</p>
            <p><strong>College:</strong> {$details['college']}</p>
            <p><strong>CGPA:</strong> {$details['cgpa']}</p>
            <p><strong>Weekly Hours:</strong> {$details['hours']}</p>
          </div>
          <p>If you have any questions, feel free to reach out at <a href='mailto:support@cybertron7.in'>support@cybertron7.in</a>.</p>
        </div>
        <div class='footer'>&copy; " . date('Y') . " Awarcrown Corporations LLP. All rights reserved.</div>
      </div>
    </body>
    </html>";

    $headers = "MIME-Version: 1.0\r\n" .
               "Content-type: text/html; charset=UTF-8\r\n" .
               "From: Awarcrown Corporations <support@cybertron7.in>\r\n" .
               "Reply-To: support@cybertron7.in\r\n" .
               "X-Mailer: PHP/" . phpversion();

    return mail($to, $subject, $message, $headers);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fields = ['name', 'email', 'phone', 'program', 'role', 'tech_stack', 'motivation', 'hours', 'college', 'cgpa'];
    $data = [];

    foreach ($fields as $field) {
        $data[$field] = isset($_POST[$field]) ? trim($_POST[$field]) : '';
    }

    // Basic validations
    if (!preg_match("/^[a-zA-Z\s]{2,}$/", $data['name'])) exit(json_encode(['success' => false, 'message' => 'Invalid name']));
    if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) exit(json_encode(['success' => false, 'message' => 'Invalid email']));
    if (!preg_match("/^\d{10,15}$/", $data['phone'])) exit(json_encode(['success' => false, 'message' => 'Invalid phone']));
    if (!is_numeric($data['hours']) || $data['hours'] < 1) exit(json_encode(['success' => false, 'message' => 'Invalid hours']));
    if (!is_numeric($data['cgpa']) || $data['cgpa'] < 0 || $data['cgpa'] > 10) exit(json_encode(['success' => false, 'message' => 'CGPA must be 0-10']));
    
    // Resume Handling
    $resumePath = '';
    if (isset($_FILES['resume']) && $_FILES['resume']['error'] === UPLOAD_ERR_OK) {
        $file = $_FILES['resume'];
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

        if ($ext !== 'pdf' || $file['size'] > 5 * 1024 * 1024) {
            exit(json_encode(['success' => false, 'message' => 'Resume must be a PDF under 5MB']));
        }

        $uploadDir = 'uploads/interns/';
        if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);

        $resumePath = $uploadDir . uniqid('resume_') . '.pdf';
        move_uploaded_file($file['tmp_name'], $resumePath);
    } else {
        exit(json_encode(['success' => false, 'message' => 'Resume upload required']));
    }

    // Check for duplicate email
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM intern_awc20250850  WHERE email = ?");
    $stmt->execute([$data['email']]);
    if ($stmt->fetchColumn() > 0) {
        exit(json_encode(['success' => false, 'message' => 'You have already submitted an application.']));
    }

    $applicationId = generateApplicationId();

    $insert = $pdo->prepare("INSERT INTO intern_awc20250850 
        (application_id, name, email, phone, program, role, tech_stack, motivation, hours, college, cgpa, resume)
        VALUES (:application_id, :name, :email, :phone, :program, :role, :tech_stack, :motivation, :hours, :college, :cgpa, :resume)");

    try {
        $insert->execute([
            ':application_id' => $applicationId,
            ':name' => $data['name'],
            ':email' => $data['email'],
            ':phone' => $data['phone'],
            ':program' => $data['program'],
            ':role' => $data['role'],
            ':tech_stack' => $data['tech_stack'],
            ':motivation' => $data['motivation'],
            ':hours' => $data['hours'],
            ':college' => $data['college'],
            ':cgpa' => $data['cgpa'],
            ':resume' => $resumePath
        ]);

        sendEmail($data['email'], $applicationId, $data);

        echo json_encode(['success' => true, 'message' => 'Application submitted successfully!']);
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Database error. Please try again later.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
}
?>
