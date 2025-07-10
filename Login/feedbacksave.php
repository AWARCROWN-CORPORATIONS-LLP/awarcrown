<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();

// Database configuration
$db_server = "localhost";
$db_user = "awarcrownadmin";
$db_pass = "Aditya@1299";
$db_name = "cybertron7";

// Create connection
$conn = new mysqli($db_server, $db_user, $db_pass, $db_name);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Sanitize input
$name = isset($_POST['name']) ? htmlspecialchars(trim($_POST['name'])) : null;
$email = isset($_POST['email']) ? htmlspecialchars(trim($_POST['email'])) : null;
$feedbackType = isset($_POST['feedbackType']) ? htmlspecialchars(trim($_POST['feedbackType'])) : null;
$message = isset($_POST['message']) ? htmlspecialchars(trim($_POST['message'])) : null;

if ($name && $email && $feedbackType && $message) {
    // Generate a unique ticket ID
    $ticketID = strtoupper(uniqid('CY7-'));

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO feedback (name, email, feedback_type, message, ticket_id) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $name, $email, $feedbackType, $message, $ticketID);

    // Execute the query
    if ($stmt->execute()) {
        // Email configuration
        $to = $email; // Only the user email will be visible
$subject = "Cybertron7 Feedback Received - Ticket #$ticketID";
$headers = "From: support@cybertron7.in\r\n";
$headers .= "Reply-To: support@cybertron7.in\r\n";
$headers .= "Bcc: naveenjupalli1019@gmail.com, alapatijanardhan19254@gmail.com, adityach0523@gmail.com\r\n"; // BCC for internal team
$headers .= "Content-Type: text/html; charset=UTF-8\r\n";

        // Email content
        $logoUrl = "https://www.cybertron7.in/images/black_logo.png";
        $linkedinUrl = "https://www.linkedin.com/company/cybertron7";
        $emailMessage = "
            <html>
            <body>
                <h2>Thank you for your feedback, $name!</h2>
                <p>We have received your feedback/bug report. Your ticket ID is <strong>$ticketID</strong>.</p>
                <p><strong>Details:</strong></p>
                <ul>
                    <li><strong>Name:</strong> $name</li>
                    <li><strong>Email:</strong> $email</li>
                    <li><strong>Feedback Type:</strong> $feedbackType</li>
                    <li><strong>Message:</strong> $message</li>
                </ul>
                <p>We will get back to you shortly. Meanwhile, feel free to connect with us on <a href='$linkedinUrl'>LinkedIn</a>.</p>
                <p>Thank you,<br>The Cybertron7 Team</p>
                <img src='$logoUrl' alt='Cybertron7 Logo' style='width:200px;'>
            </body>
            </html>
        ";

        // Send email
        if (mail($to, $subject, $emailMessage, $headers)) {
            echo "
                <div class='success-box'>
                    <h2> Feedback Submitted Successfully!</h2>
                    <p>Your Ticket ID: <strong>$ticketID</strong></p>
                    <p>A confirmation email has been sent to your email address.</p>
                    <p>Redirecting you to the main page in <span id='countdown'>5</span> seconds...</p>
                </div>
            ";
        } else {
            echo "
                <div class='error-box'>
                    <h2>Feedback Submitted, but Email Failed!</h2>
                    <p>Your Ticket ID: <strong>$ticketID</strong></p>
                    <p>We were unable to send a confirmation email. Please check your email later.</p>
                </div>
            ";
        }

        echo "<script>
                setTimeout(function() {
                    window.location.href = 'https://www.cybertron7.in';
                }, 5000);

                let count = 5;
                setInterval(function() {
                    count--;
                    if (count >= 0) {
                        document.getElementById('countdown').textContent = count;
                    }
                }, 1000);
              </script>";

        echo "<style>
                body {
                    font-family: Arial, sans-serif;
                    text-align: center;
                    background-color: #f4f4f4;
                }
                .success-box {
                    background: #d4edda;
                    color: #155724;
                    padding: 20px;
                    border-radius: 8px;
                    border: 1px solid #c3e6cb;
                    display: inline-block;
                    margin-top: 50px;
                    box-shadow: 2px 2px 10px rgba(0,0,0,0.1);
                }
                .error-box {
                    background: #f8d7da;
                    color: #721c24;
                    padding: 20px;
                    border-radius: 8px;
                    border: 1px solid #f5c6cb;
                    display: inline-block;
                    margin-top: 50px;
                    box-shadow: 2px 2px 10px rgba(0,0,0,0.1);
                }
              </style>";
    } else {
        echo "<p style='color: red;'>Error: " . $stmt->error . "</p>";
    }

    // Close statement
    $stmt->close();
} else {
    echo "<p style='color: red;'>Please fill out all required fields.</p>";
}

// Close connection
$conn->close();
?>
