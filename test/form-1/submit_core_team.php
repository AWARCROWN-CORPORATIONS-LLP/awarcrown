<?php
header('Content-Type: application/json');

// Database configuration
$host = 'localhost';
$dbname = 'ideaship';
$username = 'awarcrownadmin';
$password = 'Aditya@1299';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Database connection failed: ' . $e->getMessage()]);
    exit;
}

// Function to generate a unique application ID
function generateApplicationId() {
    return 'AWC' . date('Ymd') . rand(1000, 9999);
}

// Function to send HTML email
function sendEmail($to, $applicationId, $details) {
    $subject = 'Application Received - Awarcrown Corporations';

    // HTML Email Template
    $message = "
    <!DOCTYPE html>
    <html>
    <head>
        <style>
            body { font-family: Arial, sans-serif; color: #333; }
            .container { max-width: 600px; margin: 0 auto; padding: 20px; background: #f9f9f9; border-radius: 10px; }
            .header { background: #87CEEB; color: white; padding: 15px; text-align: center; border-radius: 10px 10px 0 0; }
            .content { padding: 20px; }
            .details { border: 1px solid #ddd; padding: 15px; background: white; border-radius: 5px; }
            .footer { text-align: center; font-size: 12px; color: #777; margin-top: 20px; }
        </style>
    </head>
    <body>
        <div class='container'>
            <div class='header'>
                <h2>Application Received</h2>
            </div>
            <div class='content'>
                <p>Dear {$details['name']},</p>
                <p>Thank you for applying to join our Core Team at Awarcrown Corporations. Your application has been successfully received.</p>
                <p><strong>Your Application ID:</strong> $applicationId</p>
                <p>We will review your application and get back to you soon.</p>
                <div class='details'>
                    <h3>Your Submitted Details:</h3>
                    <p><strong>Name:</strong> {$details['name']}</p>
                    <p><strong>Email:</strong> {$details['email']}</p>
                    <p><strong>Phone:</strong> {$details['phone']}</p>
                    <p><strong>Tech Stack:</strong> {$details['tech_stack']}</p>
                    <p><strong>Experience:</strong> {$details['experience']}</p>
                    <p><strong>Hours/Week:</strong> {$details['hours']}</p>
                </div>
            </div>
            <div class='footer'>
                <p>&copy; 2025 Awarcrown Corporations. All rights reserved.</p>
            </div>
        </div>
    </body>
    </html>";

    // Headers for HTML email
    $headers = "MIME-Version: 1.0\r\n" .
               "Content-type: text/html; charset=UTF-8\r\n" .
               "From: support@cybertron7.in\r\n" .
               "Reply-To: support@cybertron7.in\r\n" .
               "X-Mailer: PHP/" . phpversion();

    // Attempt to send email
    if (mail($to, $subject, $message, $headers)) {
        return true;
    } else {
        error_log("Failed to send email to $to");
        return false;
    }
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and validate inputs
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $phone = filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_STRING);
    $portfolio = filter_input(INPUT_POST, 'portfolio', FILTER_SANITIZE_URL);
    $tech_stack = filter_input(INPUT_POST, 'tech_stack', FILTER_SANITIZE_STRING);
    $project_from_scratch = filter_input(INPUT_POST, 'project_from_scratch', FILTER_SANITIZE_STRING);
    $experience = filter_input(INPUT_POST, 'experience', FILTER_SANITIZE_STRING);
    $new_project = filter_input(INPUT_POST, 'new_project', FILTER_SANITIZE_STRING);
    $ownership = filter_input(INPUT_POST, 'ownership', FILTER_SANITIZE_STRING);
    $feedback = filter_input(INPUT_POST, 'feedback', FILTER_SANITIZE_STRING);
    $hours = filter_input(INPUT_POST, 'hours', FILTER_SANITIZE_NUMBER_INT);
    $discussion = filter_input(INPUT_POST, 'discussion', FILTER_SANITIZE_STRING);
    $reason = filter_input(INPUT_POST, 'reason', FILTER_SANITIZE_STRING);

    // Validate required fields
    if (empty($name) || empty($email) || empty($phone) || empty($tech_stack) || empty($project_from_scratch) || 
        empty($experience) || empty($new_project) || empty($ownership) || empty($feedback) || empty($hours) || empty($discussion)) {
        echo json_encode(['success' => false, 'message' => 'All required fields must be filled.']);
        exit;
    }

    // Additional validations
    if (!preg_match("/^[A-Za-z\s]{2,50}$/", $name)) {
        echo json_encode(['success' => false, 'message' => 'Name must be 2-50 letters']);
        exit;
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['success' => false, 'message' => 'Invalid email']);
        exit;
    }
    if (!preg_match("/^[0-9]{10}$/", $phone)) {
        echo json_encode(['success' => false, 'message' => 'Phone must be 10 digits']);
        exit;
    }

    // Check for duplicate email
    try {
        $checkStmt = $pdo->prepare("SELECT COUNT(*) FROM applications WHERE email = :email");
        $checkStmt->execute([':email' => $email]);
        $emailCount = $checkStmt->fetchColumn();

        if ($emailCount > 0) {
            echo json_encode(['success' => false, 'message' => 'An application with this email has already been submitted.']);
            exit;
        }
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Error checking email: ' . $e->getMessage()]);
        exit;
    }

    // Handle file upload
    $resume = '';
    if (isset($_FILES['resume']) && $_FILES['resume']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = 'uploads/resumes/';
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $fileName = uniqid() . '-' . basename($_FILES['resume']['name']);
        $uploadPath = $uploadDir . $fileName;

        if (pathinfo($fileName, PATHINFO_EXTENSION) !== 'pdf' || $_FILES['resume']['size'] > 5 * 1024 * 1024) {
            echo json_encode(['success' => false, 'message' => 'Only PDF files under 5MB allowed.']);
            exit;
        }

        if (!move_uploaded_file($_FILES['resume']['tmp_name'], $uploadPath)) {
            echo json_encode(['success' => false, 'message' => 'Failed to upload resume.']);
            exit;
        }
        $resume = $uploadPath;
    }

    // Generate application ID
    $applicationId = generateApplicationId();

    // Prepare details for email
    $details = [
        'name' => $name,
        'email' => $email,
        'phone' => $phone,
        'tech_stack' => $tech_stack,
        'experience' => $experience,
        'hours' => $hours
    ];

    // Insert into database
    $sql = "INSERT INTO applications (application_id, name, email, phone, portfolio, tech_stack, project_from_scratch, experience, new_project, ownership, feedback, hours, discussion, reason, resume) 
            VALUES (:application_id, :name, :email, :phone, :portfolio, :tech_stack, :project_from_scratch, :experience, :new_project, :ownership, :feedback, :hours, :discussion, :reason, :resume)";
    
    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':application_id' => $applicationId,
            ':name' => $name,
            ':email' => $email,
            ':phone' => $phone,
            ':portfolio' => $portfolio,
            ':tech_stack' => $tech_stack,
            ':project_from_scratch' => $project_from_scratch,
            ':experience' => $experience,
            ':new_project' => $new_project,
            ':ownership' => $ownership,
            ':feedback' => $feedback,
            ':hours' => $hours,
            ':discussion' => $discussion,
            ':reason' => $reason,
            ':resume' => $resume
        ]);

        // Send confirmation email
        if (!sendEmail($email, $applicationId, $details)) {
            error_log("Email sending failed for $email");
            // Continue even if email fails, but log the issue
        }

        echo json_encode(['success' => true, 'message' => "Application submitted successfully! Your ID: $applicationId"]);
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}
?>