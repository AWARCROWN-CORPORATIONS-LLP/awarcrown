<?php
define("INCLUDE_FLAG", true);
require 'config.php';

// Check for server errors (HTTP 500+)
if (http_response_code() >= 500) {
    header("Location: https://cybertron7.in/test/Vanguard/security/dbconnectionerror.awc");
    exit;
}

// Check if token is provided
if (!isset($_GET['token']) || empty($_GET['token'])) {
    echo '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vanguard Security Alert</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #111;
            color: #fff;
            font-family: Arial, sans-serif;
            text-align: center;
        }
        .container {
            padding: 20px;
            background: #222;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(255, 0, 0, 0.7);
        }
        h1 {
            color: red;
        }
        .redirect-btn {
            background-color: red;
            color: white;
            border: none;
            padding: 10px 20px;
            margin-top: 10px;
            font-size: 16px;
            cursor: pointer;
            border-radius: 5px;
            transition: background 0.3s;
        }
        .redirect-btn:hover {
            background-color: darkred;
        }
    </style>
    <script>
        setTimeout(function() {
            window.location.href = "https://cybertron7.in/test/Vanguard/security/register.php";
        }, 2000);
    </script>
</head>
<body>
    <div class="container">
        <h1>Vanguard Security Alert</h1>
        <p>Token verification failed. Please register again.</p>
    </div>
</body>
</html>';
    exit;
}

$token = $_GET['token'] ?? '';

if (!preg_match('/^[a-zA-Z0-9]{32,64}$/', $token)) {
    echo '<script>alert("Invalid token format."); window.location.href="https://cybertron7.in/test/Vanguard/security/register.awc";</script>';
    exit;
}

try {
    // Verify the token and check expiration
    $stmt = $conn->prepare("SELECT user_id FROM users WHERE verification_token = ? AND token_expiry > NOW() AND is_verified = 0");
    if (!$stmt) {
        throw new Exception("Failed to prepare statement: " . $conn->error);
    }
    
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($user_id);
        $stmt->fetch();

        // Mark the user as verified
        $update_stmt = $conn->prepare("UPDATE users SET is_verified = 1, verification_token = NULL, token_expiry = NULL WHERE verification_token = ?");
        if (!$update_stmt) {
            throw new Exception("Failed to prepare update statement: " . $conn->error);
        }
        
        $update_stmt->bind_param("s", $token);
        if ($update_stmt->execute()) {
            // Generate a session token
            $session_token = bin2hex(random_bytes(32));
            
            // Store the session token in the database
            $token_stmt = $conn->prepare("UPDATE users SET session_token = ? WHERE user_id = ?");
            if (!$token_stmt) {
                throw new Exception("Failed to prepare token statement: " . $conn->error);
            }
            
            $token_stmt->bind_param("si", $session_token, $user_id);
            if ($token_stmt->execute()) {
                // Set the session token as a cookie (valid for 30 days)
                setcookie("session_token", $session_token, [
                    'expires' => time() + (30 * 24 * 60 * 60),
                    'path' => '/',
                    'secure' => true,
                    'httponly' => true,
                    'samesite' => 'Strict'
                ]);

                // Auto-login successful
                echo '<script>alert("Email verification successful! You are now logged in."); window.location.href="https://cybertron7.in/test/Vanguard/security/register.awc";</script>';
            } else {
                throw new Exception("Failed to set session token.");
            }
            $token_stmt->close();
        } else {
            throw new Exception("Failed to verify email.");
        }
        $update_stmt->close();
    } else {
        echo '<script>alert("Invalid or expired verification token."); window.location.href="https://cybertron7.in/test/Vanguard/security/register.awc";</script>';
    }
    
    $stmt->close();
} catch (Exception $e) {
    // Log the error (you can implement logging as needed)
    error_log("Verification error: " . $e->getMessage());
    
    // Show user-friendly error message
    echo '<script>alert("An error occurred during verification. Please try again later."); window.location.href="https://cybertron7.in/test/Vanguard/security/register.awc";</script>';
}

// Close the database connection
$conn->close();
?>