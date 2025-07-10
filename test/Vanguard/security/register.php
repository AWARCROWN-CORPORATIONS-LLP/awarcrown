<?php
ob_start();
session_start();

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
define('Login_page',true);
define('INCLUDE_FLAG', true);
define('ACCESS_GRANTED', true);
include 'config.php';
include 'userlogin.php';
include 'send_mail.php';


if (!isset($_SESSION['username']) && isset($_COOKIE['remember_me'])) {
    $token = $_COOKIE['remember_me'];

    $stmt = $conn->prepare("
        SELECT users.user_id, users.username, users.name, users.email, rt.token 
        FROM remember_tokens rt
        JOIN users ON users.user_id = rt.user_id
        WHERE rt.token IS NOT NULL
    ");
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($user_id, $username, $name, $email, $stored_token_hash);
        
        while ($stmt->fetch()) {
            if (password_verify($token, $stored_token_hash)) { // Verify token
                $_SESSION['user_id'] = $user_id;
                $_SESSION['username'] = $username;
                $_SESSION['name'] = $name;
                $_SESSION['email'] = $email;

                header("Location: https://cybertron7.in/test/form-1/zone.awc");
                exit();
            }
        }
    }
}

// Password validation settings
$min_password_length = getenv('MIN_PASSWORD_LENGTH') ?: 8;
$require_uppercase = getenv('REQUIRE_UPPERCASE') == 'true';
$require_special_char = getenv('REQUIRE_SPECIAL_CHAR') == 'true';
$require_number = getenv('REQUIRE_NUMBER') == 'true';

function validatePassword($password) {
    global $min_password_length, $require_uppercase, $require_special_char, $require_number;

    $pattern = "/^";
    $pattern .= $require_uppercase ? "(?=.*[A-Z])" : "";
    $pattern .= $require_special_char ? "(?=.*[\\W_])" : "";
    $pattern .= $require_number ? "(?=.*\\d)" : "";
    $pattern .= ".{" . $min_password_length . ",}$/";

    return preg_match($pattern, $password);
}

function addToEmailQueue($to, $subject, $message) {
    global $conn;
    $query = "INSERT INTO email_queue (recipient, subject, message, status) VALUES (?, ?, ?, 'pending')";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sss", $to, $subject, $message);
    return $stmt->execute();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (empty($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        echo '<script>alert("Invalid CSRF token."); window.location.href="https://cybertron7.in/test/Vanguard/security/unauthorisedaccess.awc";</script>';
        exit();
    }

    // Collect and sanitize input
    $user_username = htmlspecialchars(trim($_POST['username']));
    $user_password = $_POST['password'];
    $confirm_password = $_POST['conformpassword'];
    $user_name = htmlspecialchars(trim($_POST['name']));
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo '<script>alert("Invalid email format."); window.location.href="https://cybertron7.in/test/Vanguard/security/register.awc";</script>';
        exit();
    }

    if (!$user_password || !$confirm_password || !$user_username || !$user_name || !$email) {
        echo '<script>alert("Please fill in all required fields."); window.location.href="https://cybertron7.in/test/Vanguard/security/register.awc";</script>';
        exit();
    }

    if ($user_password !== $confirm_password) {
        echo '<script>alert("Passwords do not match."); window.location.href="https://cybertron7.in/test/Vanguard/security/register.awc";</script>';
        exit();
    }

    if (!validatePassword($user_password)) {
        $message = "Password must be at least $min_password_length characters long";
        if ($require_uppercase) $message .= ", include one uppercase letter";
        if ($require_special_char) $message .= ", include one special character";
        if ($require_number) $message .= ", include one number";
        echo '<script>alert("' . $message . '"); window.location.href="https://cybertron7.in/test/Vanguard/security/register.awc";</script>';
        exit();
    }

    // Check if username or email already exists
    $query = "SELECT username, email FROM users WHERE username = ? OR email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $user_username, $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        echo '<script>alert("Username or email already registered."); window.location.href="https://cybertron7.in/test/Vanguard/security/register.awc";</script>';
        $stmt->close();
        exit();
    }
    $stmt->close();

    // Hash password and generate email verification token
    $hashed_password = password_hash($user_password, PASSWORD_DEFAULT);
    $verification_token = bin2hex(random_bytes(16));
    $token_expiry = date('Y-m-d H:i:s', strtotime('+24 hours'));

    // Insert user data into database
    $stmt = $conn->prepare("INSERT INTO users (username, password, name, email, verification_token, token_expiry, is_verified) VALUES (?, ?, ?, ?, ?, ?, 0)");
    $stmt->bind_param("ssssss", $user_username, $hashed_password, $user_name, $email, $verification_token, $token_expiry);

    if ($stmt->execute()) {
        // Add email verification to queue
        $verification_link = "https://cybertron7.in/test/Vanguard/security/verify_login.php?token=$verification_token";
        $subject = "Email Verification Required";
        $message = "Dear $user_username,\n\nPlease verify your email by clicking the link below:\n$verification_link\n\nIf you did not register, ignore this email.";

        if (addToEmailQueue($email, $subject, $message)) {
            echo '<script>alert("Registration successful! Please check your email for the verification token."); window.location.href="https://cybertron7.in/test/Vanguard/security/register.awc";</script>';
        } else {
            echo '<script>alert("Failed to queue the verification email."); window.location.href="https://cybertron7.in/test/Vanguard/security/register.awc";</script>';
        }
    } else {
        echo '<script>alert("Registration failed. Please try again later."); window.location.href="https://cybertron7.in/test/Vanguard/security/register.awc";</script>';
    }

    $stmt->close();
}

$conn->close();
ob_end_flush(); 
?>
