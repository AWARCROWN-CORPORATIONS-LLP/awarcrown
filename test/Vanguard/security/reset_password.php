<?php
ini_set('log_errors', 1);
ini_set('error_log', 'reset_error.log');
session_start();

define("INCLUDE_FLAG", true);
require 'config.php';

    if (!isset($_GET['token'])) {
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
$token = $_GET['token'];

// Validate token and check expiry
$stmt = $conn->prepare("SELECT user_id, expiry FROM password_resets WHERE token = ?");
if ($stmt === false) {
    error_log("Error preparing statement: " . $conn->error);
    die("Server error. Please try again later.");
}

$stmt->bind_param("s", $token);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    $stmt->bind_result($user_id, $expiry);
    $stmt->fetch();

    if (strtotime($expiry) < time()) {
        echo '<script>showError("Token has expired. Please request a new password reset link.", "https://cybertron7.in/test/Vanguard/security/forgot_password.awc");</script>';
        exit();
    }
} else {
    
    echo"<script>
    alert('Invalid Token');
    window.location.href='https://cybertron7.in/test/Vanguard/security/register.awc';
    </script>";
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Validate password
    if ($new_password !== $confirm_password) {
        echo '<script>showError("Passwords do not match.");</script>';
    } elseif (strlen($new_password) < 8) {
        echo '<script>showError("Password must be at least 8 characters long.");</script>';
    } else {
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

        // Update password in users table
        $stmt = $conn->prepare("UPDATE users SET password = ? WHERE user_id = ?");
        if ($stmt === false) {
            error_log("Error preparing statement: " . $conn->error);

            header("Location: https://cybertron7.in/test/Vanguard/security/dbconnectionerror.awc");
        }

        $stmt->bind_param("si", $hashed_password, $user_id);
        $stmt->execute();

        // Delete the token to prevent reuse
        $stmt = $conn->prepare("DELETE FROM password_resets WHERE token = ?");
        $stmt->bind_param("s", $token);
        $stmt->execute();

        echo '<script>alert("Password reset successfully. You can now log in.");
                window.location.href="https://cybertron7.in/test/Vanguard/security/register.php";
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
    <title>Reset Password</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-color: #f4f4f4;
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

        input[type="password"] {
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

        .error-box {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: white;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            z-index: 1001;
            display: none;
            text-align: center;
        }

        .error-message {
            color: red;
            margin-bottom: 10px;
        }

        .close-button {
            background-color: #ddd;
            border: none;
            padding: 8px 12px;
            border-radius: 4px;
            cursor: pointer;
            margin-top:10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Reset Password</h2>
        <form method="POST" action="">
            <label for="new_password">New Password:</label>
            <input type="password" name="new_password" id="new_password" required>

            <label for="confirm_password">Confirm Password:</label>
            <input type="password" name="confirm_password" id="confirm_password" required>

            <button type="submit">Reset Password</button>
        </form>
    </div>

    <div class="error-box" id="errorBox">
        <p class="error-message" id="errorMessage"></p>
        <button class="close-button" onclick="closeError()">Close</button>
    </div>

    <script>
        function showError(message, redirect = null) {
            document.getElementById('errorMessage').innerText = message;
            document.getElementById('errorBox').style.display = 'block';
            if(redirect){
                document.getElementById('errorBox').innerHTML = `<p class="error-message">${message}</p><button class="close-button" onclick="window.location.href='${redirect}'">OK</button>`
            }

        }

        function closeError() {
            document.getElementById('errorBox').style.display = 'none';
        }
    </script>
</body>
</html>