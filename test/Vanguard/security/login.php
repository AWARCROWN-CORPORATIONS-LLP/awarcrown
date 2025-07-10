<?php
// Start session
session_start();
ini_set('log_errors', 1);
ini_set('error_log', '/path/to/error.log');

if (defined('Login_page')) {
    header("HTTP/1.1 403 Forbidden");
    header("Location: https://cybertron7.in/test/Vanguard/security/unauthorisedaccess.awc");
exit();

}

if (defined('ACCESS_GRANTED')) {
    header("HTTP/1.1 403 Forbidden");
    echo "<script>alert('Unauthorized access!'); window.location.href='https://cybertron7.in/test/Vanguard/security/unauthorisedaccess.awc';</script>";
    exit;
}


define("INCLUDE_FLAG", true);
require_once 'config.php';

// Database connection check
if (!isset($conn) || $conn->connect_error) {
    error_log("Database connection failed: " . ($conn->connect_error ?? 'Connection not initialized'));
        header("Location: https://cybertron7.in/test/Vanguard/security/dbconnectionerror.awc");
    exit;
}

try {
    // Auto-login with remember me functionality
    if (!isset($_SESSION['username']) && isset($_COOKIE['remember_me'])) {
        $token = filter_var($_COOKIE['remember_me'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        
        $stmt = $conn->prepare("SELECT u.username, u.name, u.email, rt.token, rt.created_at FROM remember_tokens rt INNER JOIN users u ON u.user_id = rt.user_id WHERE rt.token = ? AND rt.created_at > DATE_SUB(NOW(), INTERVAL 30 DAY)");
        if ($stmt === false) throw new Exception("Prepare failed: " . $conn->error);
        
        $stmt->bind_param("s", $token);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            if (password_verify($token, $row['token'])) {
                session_regenerate_id(true);
                $_SESSION['username'] = $row['username'];
                $_SESSION['name'] = $row['name'];
                $_SESSION['email'] = $row['email'];
                
                echo "<script>window.location.href='https://cybertron7.in/test/form-1/zone.awc';</script>";
                exit;
            }
        }
        $stmt->close();
    }

    // Login form handling
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $remember = isset($_POST['remember']);

        // Username validation
        if (!preg_match('/^[a-zA-Z0-9_]{3,20}$/', $username)) {
            throw new Exception("Invalid username format. Use 3-20 alphanumeric characters or underscore.");
        }

        // Password validation
        if (empty($password) || strlen($password) < 6) {
            throw new Exception("Password must be at least 6 characters long.");
        }

        $stmt = $conn->prepare("SELECT user_id, password, name, email, policy, is_verified FROM users WHERE username = ?");
        if ($stmt === false) throw new Exception("Prepare failed: " . $conn->error);
        
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            if (!$user['is_verified']) {
                throw new Exception("Email verification needed. Please check your inbox and confirm your email address. ");
            }

            if (password_verify($password, $user['password'])) {
                session_regenerate_id(true);
                $_SESSION['username'] = $username;
                $_SESSION['name'] = $user['name'];
                $_SESSION['email'] = $user['email'];

                if ($remember) {
                    $token = bin2hex(random_bytes(32));
                    $hashed_token = password_hash($token, PASSWORD_ARGON2ID);
                    
                    $user_agent = substr($_SERVER['HTTP_USER_AGENT'], 0, 255);
                    $ip_address = $_SERVER['REMOTE_ADDR'];
                    $created_at = date('Y-m-d H:i:s');
                    
                    setcookie("remember_me", $token, [
                        'expires' => time() + (86400 * 30),
                        'path' => '/',
                        'secure' => true,
                        'httponly' => true,
                        'samesite' => 'Strict'
                    ]);
                    
                    $insertToken = $conn->prepare("INSERT INTO remember_tokens (user_id, token, created_at, user_agent, ip_address) VALUES (?, ?, ?, ?, ?) ON DUPLICATE KEY UPDATE token = VALUES(token), created_at = VALUES(created_at)");
                    if ($insertToken === false) throw new Exception("Token prepare failed: " . $conn->error);
                    
                    $insertToken->bind_param("issss", $user['user_id'], $hashed_token, $created_at, $user_agent, $ip_address);
                    $insertToken->execute();
                    $insertToken->close();
                }
                
                $redirect = $user['policy'] ? "https://cybertron7.in/test/form-1/zone.awc" : "https://cybertron7.in/test/Vanguard/security/policy.awc";
                echo "<script>window.location.href='$redirect';</script>";
                exit;
            }
        }
        throw new Exception("Invalid credentials. Please try again.");
    }
} catch (Exception $e) {
    error_log("Login error: " . $e->getMessage());
    $errorMessage = htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8');
    echo "<script>alert('$errorMessage'); window.location.href='https://cybertron7.in/test/Vanguard/security/register.awc';</script>";
    exit;
} finally {
    if (isset($stmt) && $stmt !== false) {
        $stmt->close();
    }
    if (isset($conn) && $conn !== false) {
        $conn->close();
    }
}
?>