<?php
// Start output buffering to catch any stray output
ob_start();
session_start();
ini_set('display_errors', 0);
ini_set('log_errors', 1);
error_log("PHP Error detected in userProfileSubmission.php");

// Include database config (ensure no output here)
require_once 'config.php';
if (!$conn) {
    error_log("Database connection failed: " . mysqli_connect_error());
    showMessage("Database connection error", false);
}

// Check for session
if (!isset($_SESSION['username'])) {
    showMessage("User not logged in", false);
}

// Check request method
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    showMessage("Invalid request method", false);
}

try {
    $username = $_SESSION['username'];

    // Fetch user_id
    $stmt = $conn->prepare("SELECT user_id FROM users WHERE username = ?");
    if (!$stmt) {
        throw new Exception("Prepare failed: " . $conn->error);
    }
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        $stmt->close();
        showMessage("User not found", false);
    }

    $user = $result->fetch_assoc();
    $user_id = $user['user_id'];
    $stmt->close();

    // Sanitize inputs (using updated filters for PHP 8.1+)
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? '';
    $quote = filter_input(INPUT_POST, 'quote', FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? '';
    $bio = filter_input(INPUT_POST, 'bio', FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? '';
    $phone = filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_NUMBER_INT) ?? ''; // Using FILTER_SANITIZE_NUMBER_INT for phone
    $location = filter_input(INPUT_POST, 'location', FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? '';
    $interests = !empty($_POST['interests']) ? htmlspecialchars($_POST['interests'], ENT_QUOTES, 'UTF-8') : json_encode([]);
    $linkedin = filter_input(INPUT_POST, 'linkedin', FILTER_SANITIZE_URL) ?? '';
    $github = filter_input(INPUT_POST, 'github', FILTER_SANITIZE_URL) ?? '';
    $twitter = filter_input(INPUT_POST, 'twitter', FILTER_SANITIZE_URL) ?? '';

    // Validate URLs
    if ($linkedin && !filter_var($linkedin, FILTER_VALIDATE_URL)) $linkedin = '';
    if ($github && !filter_var($github, FILTER_VALIDATE_URL)) $github = '';
    if ($twitter && !filter_var($twitter, FILTER_VALIDATE_URL)) $twitter = '';
    

    // Handle other social links
    $other_names = $_POST['other_social_links_name'] ?? [];
    $other_urls = $_POST['other_social_links_url'] ?? [];
    $other_social_links = [];
    for ($i = 0; $i < count($other_names); $i++) {
        if (!empty($other_names[$i]) && !empty($other_urls[$i])) {
            $url = filter_var($other_urls[$i], FILTER_SANITIZE_URL);
            if (filter_var($url, FILTER_VALIDATE_URL)) {
                $other_social_links[] = [
                    'name' => htmlspecialchars($other_names[$i], ENT_QUOTES, 'UTF-8'),
                    'url' => $url
                ];
            }
        }
    }
    $other_social_links = json_encode($other_social_links);
    $is_profile_public = isset($_POST['is_profile_public']) ? 1 : 0;


    // Prepare and execute the update/insert query
    $stmt = $conn->prepare("
        INSERT INTO user_profiles (
            user_id, name, quote, bio, phone, location, 
            interests, linkedin, github, twitter, other_social_links,is_profile_public
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?)
        ON DUPLICATE KEY UPDATE
            name = VALUES(name),
            quote = VALUES(quote),
            bio = VALUES(bio),
            phone = VALUES(phone),
            location = VALUES(location),
            interests = VALUES(interests),
            linkedin = VALUES(linkedin),
            github = VALUES(github),
            twitter = VALUES(twitter),
            other_social_links = VALUES(other_social_links),
            is_profile_public=VALUES(is_profile_public)
    ");
    if (!$stmt) {
        throw new Exception("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("issssssssssi", 
        $user_id, $name, $quote, $bio, $phone, 
        $location, $interests, $linkedin, $github, 
        $twitter, $other_social_links,$is_profile_public
    );

    if ($stmt->execute()) {
        showMessage("Profile updated successfully", true);
    } else {
        showMessage("Failed to update profile: " . $stmt->error, false);
    }

    $stmt->close();
    $conn->close();
} catch (Exception $e) {
    error_log("Error in userProfileSubmission.php: " . $e->getMessage());
    showMessage("Error: " . $e->getMessage(), false);
}

// Function to show a message in a modal and redirect
function showMessage($message, $success) {
    $redirectUrl = "https://cybertron7.in/test/form-1/zone.php";
    echo "
    <!DOCTYPE html>
    <html>
    <head>
        <title>Profile Update</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                background-color: rgba(0,0,0,0.5);
            }
            .modal {
                display: block;
                position: fixed;
                z-index: 1000;
                left: 50%;
                top: 50%;
                transform: translate(-50%, -50%);
                width: 320px;
                padding: 20px;
                background: white;
                border-radius: 10px;
                box-shadow: 0px 0px 10px rgba(0,0,0,0.3);
                text-align: center;
            }
            .modal h3 {
                color: " . ($success ? "green" : "red") . ";
            }
            .modal button {
                margin-top: 15px;
                padding: 8px 15px;
                border: none;
                background: #007BFF;
                color: white;
                cursor: pointer;
                border-radius: 5px;
            }
            .modal button:hover {
                background: #0056b3;
            }
        </style>
    </head>
    <body>
        <div class='modal'>
            <h3>$message</h3>
            <button onclick='redirect()'>OK</button>
        </div>
        <script>
            function redirect() {
                window.location.href = '$redirectUrl';
            }
        </script>
    </body>
    </html>";
    exit;
}

ob_end_flush();
?>
