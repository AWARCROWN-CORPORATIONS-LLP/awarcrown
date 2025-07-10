<?php
ini_set('log_errors', 1);
ini_set('error_log', '/path/to/error.log');
session_start();

define("INCLUDE_FLAG", true);
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['email'])) {
    $email = $_POST['email'];

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo '<script>alert("Invalid email address.");
                window.location.href="https://cybertron7.in/test/Vanguard/security/forgot_password.awc";
                </script>';
        exit();
    }

    $stmt = $conn->prepare("SELECT user_id FROM users WHERE email = ?");
    if ($stmt === false) {
        error_log("Error preparing statement: " . $conn->error);
        die("Server error. Please try again later.");
    }

    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $token = bin2hex(random_bytes(50)); // Generate secure token
        $stmt->bind_result($user_id);
        $stmt->fetch();

        $expiry = date('Y-m-d H:i:s', strtotime('+1 hour'));

        // Insert token into password_resets table
        $stmt = $conn->prepare("INSERT INTO password_resets (user_id, token, expiry) VALUES (?, ?, ?)");

        if ($stmt === false) {
            error_log("Error preparing statement: " . $conn->error);
            die("Server error. Please try again later.");
        }

        $stmt->bind_param("iss", $user_id, $token, $expiry);
        $stmt->execute();

        $reset_link = "https://cybertron7.in/test/Vanguard/security/reset_password.awc?token=$token";

        // Send email logic
        $subject = "Password Reset Request";
        $message = "<html>
        <head>
            <title>Password Reset Request</title>
        </head>
        <body>
            <p>Dear User,</p>
            <p>We received a request to reset your password. Click the link below to reset your password:</p>
            <a href='$reset_link'>$reset_link</a>
            <p>If you did not request this, please ignore this email.</p>
            <p>Thanks,</p>
            <p>The Cybertron7 Team</p>
        </body>
        </html>";
        $headers = "From: support@cybertron7.in\r\n";
        $headers .= "Reply-To: support@cybertron7.in\r\n";
        $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

        if (mail($email, $subject, $message, $headers)) {
            echo '<script>alert("A password reset link has been sent to your email.");
                    window.location.href="https://cybertron7.in/test/Vanguard/security/register.awc";
                    </script>';
        } else {
            error_log("Failed to send email to $email");
            echo '<script>alert("Failed to send email. Please try again later.");
                    window.location.href="https://cybertron7.in/test/Vanguard/security/register.awc";
                    </script>';
        }
        exit();
    } else {
        echo '<script>alert("Email not found in our records.");
                window.location.href="https://cybertron7.in/test/Vanguard/security/forget_password.awc";
                </script>';
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
           background-color: #f5f7fa;



            margin: 0;
        }

        .container {
            background-color: #fff;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 350px;
            text-align: center;
        }

        h2 {
            color: #333;
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #555;
            text-align: left;
        }

        input[type="email"] {
            width: calc(100% - 22px);
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }

        button {
            background-color: #4285f4;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
            font-size: 16px;
        }

        button:hover {
            background-color: #3c78d8;
        }

        a {
            display: block;
            margin-top: 20px;
            color: #4285f4;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }

        .loading-spinner {
            border: 4px solid #f3f3f3;
            border-top: 4px solid #3498db;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            animation: spin 2s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Forgot Password</h2>
        <form method="POST" action="" onsubmit="showLoading()">
            <label for="email">Enter your email address:</label>
            <input type="email" name="email" id="email">
            <button type="submit">Send Reset Link</button>
        </form>
        <a href="https://cybertron7.in/test/Vanguard/security/register.php">Back to Login</a>
    </div>

    <div class="loading-overlay" id="loadingOverlay">
        <div class="loading-spinner"></div>
    </div>

    <script>
        function showLoading() {
            document.getElementById('loadingOverlay').style.display = 'flex';
        }
        window.addEventListener('load',function(){
            document.getElementById('loadingOverlay').style.display='none';
        })
    </script>
</body>
</html>