<?php
session_start();
define('INCLUDE_FLAG', true);
require 'config.php';

// Security check - same as login.php
if (defined('ACCESS_GRANTED')) {
    header("HTTP/1.1 403 Forbidden");
    header("Location: https://cybertron7.in/test/Vanguard/security/unauthorisedaccess.awc");
    exit;
}

// Database connection check
if (!isset($conn) || $conn->connect_error) {
    error_log("Database connection failed: " . ($conn->connect_error ?? 'Connection not initialized'));
    header("HTTP/1.1 503 Service Unavailable");
    header("Location: https://cybertron7.in/test/Vanguard/security/dbconnectionerror.awc");
    exit;
}

try {
    // Delete "Remember Me" token from remember_tokens table if user is logged in
    if (isset($_SESSION['username'])) {
        // First get the user_id from users table
        $stmt = $conn->prepare("
            SELECT user_id 
            FROM users 
            WHERE username = ?
        ");
        
        if ($stmt === false) {
            error_log("User ID prepare failed: " . $conn->error);
        } else {
            $stmt->bind_param("s", $_SESSION['username']);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($row = $result->fetch_assoc()) {
                $user_id = $row['user_id'];
                
                // Now delete the specific token from remember_tokens
                $tokenStmt = $conn->prepare("
                    DELETE FROM remember_tokens 
                    WHERE user_id = ?
                ");
                
                if ($tokenStmt === false) {
                    error_log("Token delete prepare failed: " . $conn->error);
                } else {
                    $tokenStmt->bind_param("i", $user_id);
                    $tokenStmt->execute();
                    $tokenStmt->close();
                }
            }
            $stmt->close();
        }
    }

    // Unset all session variables
    $_SESSION = array();

    // Delete session cookie
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], 
            $params["domain"],
            $params["secure"], 
            $params["httponly"]
        );
    }

    // Destroy the session
    session_destroy();

    // Delete "remember_me" cookie specifically
    if (isset($_COOKIE['remember_me'])) {
        setcookie("remember_me", '', [
            'expires' => time() - 3600,
            'path' => '/',
            'domain' => '.cybertron7.in',
            'secure' => true,
            'httponly' => true,
            'samesite' => 'Strict'
        ]);
    }

    // Redirect to register page after logout
    header("Location: https://www.cybertron7.in/test/Vanguard/security/register.awc");
    exit;

} catch (Exception $e) {
    error_log("Logout error: " . $e->getMessage());
    // Continue with logout even if an error occurs
    session_destroy();
    if (isset($_COOKIE['remember_me'])) {
        setcookie("remember_me", '', [
            'expires' => time() - 3600,
            'path' => '/',
            'domain' => '.cybertron7.in',
            'secure' => true,
            'httponly' => true,
            'samesite' => 'Strict'
        ]);
    }
    header("Location: https://www.cybertron7.in/test/Vanguard/security/register.awc");
    exit;
} finally {
    if (isset($stmt) && $stmt !== false) {
        $stmt->close();
    }
    if (isset($tokenStmt) && $tokenStmt !== false) {
        $tokenStmt->close();
    }
    $conn->close();
}
?>