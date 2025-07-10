<?php

ob_start(); // Start output buffering
session_start();
ini_set('display_errors', 0);
ini_set('log_errors', 1);
error_reporting(E_ALL);

// Define error log file
$error_log_file = __DIR__ . '/error_logs.txt';
ini_set('error_log', $error_log_file);

require_once 'config.php';

if (!isset($_SESSION['username'])) {
    showPopupAndRedirect("User not logged in", false);
}

$username = $_SESSION['username'];

try {
    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_FILES['image'])) {
        handleFileUpload($conn, $username);
    } elseif (isset($_GET['delete'])) {
        handleFileDeletion($conn, $username);
    } else {
        throw new Exception("Invalid request", 400);
    }
} catch (Exception $e) {
    logError($e->getMessage());
    showPopupAndRedirect($e->getMessage(), false);
}
exit;

function handleFileUpload($conn, $username) {
    if (!isset($_FILES['image']) || $_FILES['image']['error'] !== UPLOAD_ERR_OK) {
        throw new Exception("File upload error", 400);
    }

    $target_dir = __DIR__ . '/uploadProfile/';
    if (!is_dir($target_dir) && !mkdir($target_dir, 0755, true)) {
        throw new Exception("Failed to create upload directory", 500);
    }

    $file = $_FILES['image'];
    $file_extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];

    if ($file['size'] > 2000000) {
        throw new Exception("File too large. Maximum size is 2MB.", 400);
    }
    if (!in_array($file_extension, $allowed_extensions)) {
        throw new Exception("Invalid file type. Only JPG, JPEG, PNG, and GIF allowed.", 400);
    }
    
    list($width, $height) = getimagesize($file['tmp_name']);
    if ($width < 320 || $height < 320) {
        throw new Exception("Image dimensions too small. Minimum size is 320x320 pixels.", 400);
    }

    $encrypted_file_name = hash('sha256', $file['name'] . time()) . '.' . $file_extension;
    $target_file = $target_dir . $encrypted_file_name;

    if ($width > 2080 || $height > 2080) {
        resizeAndSaveImage($file['tmp_name'], $target_file, $file_extension, 1080);
    } else {
        if (!move_uploaded_file($file['tmp_name'], $target_file)) {
            throw new Exception("Error moving uploaded file", 500);
        }
    }

    $stmt = $conn->prepare("UPDATE users SET profile_picture = ? WHERE username = ?");
    $stmt->bind_param("ss", $encrypted_file_name, $username);
    if (!$stmt->execute()) {
        throw new Exception("Database error: " . $stmt->error, 500);
    }
    $stmt->close();

    showPopupAndRedirect("Profile updated successfully", true);
}
function handleFileDeletion($conn, $username) {
    header('Content-Type: application/json'); // Ensure JSON response

    // Fetch profile picture
    $stmt = $conn->prepare("SELECT profile_picture FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        logError("User not found: $username");
        echo json_encode(['success' => false, 'message' => 'User not found']);
        exit;
    }

    $row = $result->fetch_assoc();
    $profile_picture = $row['profile_picture'];
    $stmt->close();

    if ($profile_picture) {
        $file_path = realpath(__DIR__ . '/uploadProfile/' . $profile_picture); // Ensure valid path

        if ($file_path && file_exists($file_path)) {
            if (!unlink($file_path)) {
                logError("Failed to delete file: $file_path");
                echo json_encode(['success' => false, 'message' => 'Failed to delete file']);
                exit;
            }
        } else {
            logError("File does not exist: $file_path");
            echo json_encode(['success' => false, 'message' => 'File not found']);
            exit;
        }

        // Update database to remove profile picture reference
        $stmt = $conn->prepare("UPDATE users SET profile_picture = NULL WHERE username = ?");
        $stmt->bind_param("s", $username);
        if (!$stmt->execute()) {
            logError("Database update error: " . $stmt->error);
            echo json_encode(['success' => false, 'message' => 'Database update failed']);
            exit;
        }
        $stmt->close();
    }

    echo json_encode(['success' => true, 'message' => 'Profile picture deleted successfully']);
    exit;
}

// Error Logging Function
function logError($message) {
    $error_log_file = __DIR__ . "/error_log.txt"; // Store logs in a file
    file_put_contents($error_log_file, date('Y-m-d H:i:s') . " - " . $message . "\n", FILE_APPEND);
}

function showPopupAndRedirect($message, $success) {
    $redirect_url = "https://cybertron7.in/test/form-1/zone.php";
    $escaped_message = htmlspecialchars($message, ENT_QUOTES, 'UTF-8');

    echo "
    <html>
    <head>
        <style>
            .popup-container {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0, 0, 0, 0.5);
                display: flex;
                align-items: center;
                justify-content: center;
            }
            .popup-box {
                background: white;
                padding: 20px;
                border-radius: 10px;
                text-align: center;
                width: 300px;
                box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            }
            .popup-message {
                font-size: 16px;
                color: black;
                margin-bottom: 20px;
            }
            .popup-button {
                background: blue;
                color: white;
                border: none;
                padding: 10px 20px;
                font-size: 14px;
                border-radius: 5px;
                cursor: pointer;
            }
        </style>
    </head>
    <body>
        <div class='popup-container'>
            <div class='popup-box'>
                <p class='popup-message'>$escaped_message</p>
                <button class='popup-button' onclick='redirect()'>OK</button>
            </div>
        </div>
        <script>
            function redirect() {
                window.location.href = '$redirect_url';
            }
        </script>
    </body>
    </html>";
    exit;
}
