<?php
header('Content-Type: text/html; charset=UTF-8');
define("INCLUDE_FLAG", true);

// Enable error logging
ini_set('display_errors', 0);
ini_set('log_errors', 1);
ini_set('error_log', 'logs/error.log');

try {
    require "config.php";
} catch (Exception $e) {
    error_log("Config file inclusion failed: " . $e->getMessage());
    http_response_code(500);
    $error_message = 'Internal server error. Please try again later.';
    include 'error_page.php'; // Optional: create a separate error page
    exit;
}

function verifyApplicant($applicant_id, $conn) {
    // Validate applicant_id
    $applicant_id = trim($applicant_id);
    if (empty($applicant_id)) {
        http_response_code(400);
        return ['success' => false, 'message' => 'Applicant ID is required'];
    }

    // Validate format
    if (!preg_match('/^[a-zA-Z0-9_-]{1,50}$/', $applicant_id)) {
        http_response_code(400);
        return ['success' => false, 'message' => 'Invalid Applicant ID format. Use alphanumeric characters, underscores, or hyphens (max 50 characters).'];
    }

    try {
        $stmt = $conn->prepare("SELECT u.applicant_id, u.full_name, u.email, c.certificate_path 
                                FROM interns u 
                                LEFT JOIN certificates c ON u.applicant_id = c.applicant_id 
                                WHERE u.applicant_id = ?");
        if (!$stmt) {
            throw new Exception("Database prepare failed: " . $conn->error);
        }

        $stmt->bind_param("s", $applicant_id);
        if (!$stmt->execute()) {
            throw new Exception("Database execute failed: " . $stmt->error);
        }

        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $email = $row['email'];

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                error_log("Invalid email format for applicant_id: $applicant_id");
                return ['success' => false, 'message' => 'Invalid email data retrieved'];
            }

            $email_parts = explode('@', $email);
            $email_masked = substr($email_parts[0], 0, 6) . str_repeat('*', max(0, strlen($email_parts[0]) - 6)) . '@' . $email_parts[1];
            
            return [
                'success' => true,
                'applicant_id' => $row['applicant_id'],
                'name' => $row['full_name'],
                'email' => $email_masked,
                'certificate_path' => $row['certificate_path'] ?? ''
            ];
        } else {
            http_response_code(404);
            return ['success' => false, 'message' => 'No record found for the provided Applicant ID'];
        }
    } catch (Exception $e) {
        error_log("Database error for applicant_id $applicant_id: " . $e->getMessage());
        http_response_code(500);
        return ['success' => false, 'message' => 'Database error occurred. Please try again later.'];
    } finally {
        if (isset($stmt)) {
            $stmt->close();
        }
    }
}

// Initialize variables for HTML rendering
$result = ['success' => false, 'message' => 'Applicant ID required'];
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['applicant_id'])) {
    $result = verifyApplicant(urldecode($_GET['applicant_id']), $conn);
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Certificate - Awarcrown Corporations</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        #certificate_preview {
            max-height: 500px;
            width: 100%;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
         .fade-in {
      animation: fadeIn 0.6s ease-in-out;
    }
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(10px); }
      to { opacity: 1; transform: translateY(0); }
    }
    </style>
</head>
<body class="bg-gradient-to-br from-gray-100 to-gray-200 min-h-screen flex flex-col justify-between">

  <!-- Main Content -->
  <main class="flex-grow flex items-center justify-center px-4 py-12">
    <div class="bg-white fade-in p-10 rounded-2xl shadow-xl w-full max-w-2xl border border-gray-300">
      <h1 class="text-3xl font-bold text-center text-gray-800 mb-6">Certificate Verification</h1>

      <!-- Result Section -->
      <div id="result" class="<?php echo $result['success'] ? '' : 'hidden'; ?>">
        <div class="space-y-3 text-gray-700">
          <div>
            <p><strong>Applicant ID:</strong> <span id="result_applicant_id"><?php echo isset($result['applicant_id']) ? htmlspecialchars($result['applicant_id']) : ''; ?></span></p>
            <p><strong>Name:</strong> <span id="result_name"><?php echo isset($result['name']) ? htmlspecialchars($result['name']) : ''; ?></span></p>
            <p><strong>Email:</strong> <span id="result_email"><?php echo isset($result['email']) ? htmlspecialchars($result['email']) : ''; ?></span></p>
            <p><strong>Company:</strong> Awarcrown Corporations LLP</p>
            <p><strong>Certificate:</strong> 
              <a id="certificate_link" href="<?php echo isset($result['certificate_path']) ? htmlspecialchars($result['certificate_path']) : '#'; ?>" 
              target="_blank" class="text-blue-600 hover:text-blue-800 underline transition">View Certificate</a>
            </p>
            <p class="text-green-700 font-semibold">Verified by Awarcrown Corporations LLP</p>
          </div>

          <!-- Certificate Preview -->
          <div class="mt-4">
            <h3 class="text-md font-semibold mb-2">Certificate Preview</h3>
            <?php if (isset($result['certificate_path']) && $result['certificate_path']): ?>
              <embed id="certificate_preview" src="<?php echo htmlspecialchars($result['certificate_path']); ?>" type="application/pdf" width="100%" height="500px" class="rounded-md border shadow-sm">
            <?php else: ?>
              <p class="text-gray-500 italic">No certificate available for preview.</p>
            <?php endif; ?>
          </div>
        </div>
      </div>

      <!-- Error Message -->
      <div id="error" class="mt-6 text-red-600 text-center <?php echo !$result['success'] ? '' : 'hidden'; ?>">
        <?php echo isset($result['message']) ? htmlspecialchars($result['message']) : ''; ?>
      </div>
    </div>
  </main>

  <!-- Footer -->
  <footer class="bg-white text-gray-500 text-center text-sm py-4 border-t">
    Powered by <strong class="text-gray-700">Awarcrown Corporations LLP</strong>
  </footer>
</html>