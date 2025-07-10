<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
include'database/config.php';

$sql = "SELECT id, name, email,feedback_type,message,ticket_id FROM feedback";

$result = $conn->query($sql);

// Create an HTML table to display the startups
echo '<table border="1">
        <tr>
            <th>Feedback ID</th>  			
            <th>Name</th>
            <th>Email</th>
           
            <th>Feedback type</th>
            <th>Message</th>
            <th>Ticket_id</th>
            
            
        </tr>';

while ($row = $result->fetch_assoc()) {
    echo '<tr>
            <td>' . htmlspecialchars($row['id'] ?? '') . '</td>
            <td>' . htmlspecialchars($row['name'] ?? '') . '</td>
            <td>' . htmlspecialchars($row['email'] ?? '') . '</td>
            <td>' . htmlspecialchars($row['feedback_type'] ?? '') . '</td>
            <td>' . htmlspecialchars($row['message'] ?? '') . '</td>
            <td>' . htmlspecialchars($row['ticket_id'] ?? '') . '</td>

        
        </tr>';
}

echo '</table>';

$conn->close();
?>
