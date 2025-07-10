<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_name('Admin_session');
session_start();
define("INCLUDE_FLAG",true);
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password']; // Entered password

    // Prepare and bind
    $stmt = $conn->prepare("SELECT password, Adminname,position, mail,postionapproval,document FROM admindatabase WHERE username = ?");
    if ($stmt === false) {
        die("Error preparing statement: " . $conn->error);
    }

    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($stored_password, $name,$position, $email,$postionapproval,$document); // Password from database
        $stmt->fetch();

        // Direct password comparison (since it's not hashed)
        if ($password === $stored_password) {
            // Set session variables
            $_SESSION['username'] = $username;
            $_SESSION['name'] = $name;
            $_SESSION['email'] = $email;
            $_SESSION['position']=$position;
            $_SESSION['postionapproval']=$postionapproval;
            $_SESSION['document']=$document;

            // Redirect directly if login is successful
            header("Location:https://cybertron7.in/test/Garh/asthan.awc");
            exit();
        } else {
            // Invalid password
            header("Location: https://www.cybertron7.in/Login/userlogin.php?error=invalid_login");
            exit();
        }
    } else {
        // Invalid username
        header("Location: https://www.cybertron7.in/Login/userlogin.php?error=invalid_login");
        exit();
    }

    $stmt->close();
}

$conn->close();
?>
