<?php
$host = 'localhost';
$db = 'ideaship';
$user = 'awarcrownadmin';
$pass = 'Aditya@1299';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Fetch all internship applications
    $stmt = $pdo->query("SELECT id, application_id, email, contact, whatsapp, first_name, last_name, college, year_study, branch, position, domain, languages, reason, duration, status, created_at, company FROM internship_applications");
    $applications = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Separate applications by status
    $approved = array_filter($applications, fn($app) => strtolower($app['status']) === 'approved');
    $rejected = array_filter($applications, fn($app) => strtolower($app['status']) === 'rejected');
    $hold = array_filter($applications, fn($app) => strtolower($app['status']) === 'pending' || empty($app['status']));

    
    function renderTable($apps, $title, $status) {
        echo "<div class='table-container'>";
        echo "<h2>$title</h2>";
        
        if (empty($apps)) {
            echo "<p class='no-data'>No $title found.</p>";
            echo "</div>";
            return;
        }

        echo '<table class="status-table">';
        echo '<thead><tr>
                <th>ID</th><th>App ID</th><th>Email</th><th>Contact</th><th>First Name</th><th>Last Name</th>
                <th>College</th><th>Year</th><th>Branch</th><th>Position</th><th>Domain</th><th>Status</th><th>Actions</th>
              </tr></thead>';
        echo '<tbody>';

        foreach ($apps as $app) {
            try {
                echo '<tr>';
                echo '<td>' . htmlspecialchars($app['id']) . '</td>';
                echo '<td>' . htmlspecialchars($app['application_id']) . '</td>';
                echo '<td>' . htmlspecialchars($app['email']) . '</td>';
                echo '<td>' . htmlspecialchars($app['contact']) . '</td>';
                echo '<td>' . htmlspecialchars($app['first_name']) . '</td>';
                echo '<td>' . htmlspecialchars($app['last_name']) . '</td>';
                echo '<td>' . htmlspecialchars($app['college']) . '</td>';
                echo '<td>' . htmlspecialchars($app['year_study']) . '</td>';
                echo '<td>' . htmlspecialchars($app['branch']) . '</td>';
                echo '<td>' . htmlspecialchars($app['position']) . '</td>';
                echo '<td>' . htmlspecialchars($app['domain']) . '</td>';
                echo '<td id="status-' . htmlspecialchars($app['id']) . '">' . htmlspecialchars($app['status']) . '</td>';
                echo '<td>';
                echo '<div class="dropdown">';
                echo '<button class="dropbtn">Update Status</button>';
                echo '<div class="dropdown-content">';
                echo '<a href="#" onclick="updateStatus(' . htmlspecialchars($app['id']) . ', \'approved\')">Approve</a>';
                echo '<a href="#" onclick="updateStatus(' . htmlspecialchars($app['id']) . ', \'rejected\')">Reject</a>';
                echo '<a href="#" onclick="updateStatus(' . htmlspecialchars($app['id']) . ', \'pending\')">Pending</a>';
                echo '</div>';
                echo '</div>';
                echo '</td>';
                echo '</tr>';
            } catch (Exception $e) {
                echo '<tr><td colspan="13" class="error-msg">Error rendering row: ' . htmlspecialchars($e->getMessage()) . '</td></tr>';
            }
        }
        echo '</tbody></table></div>';
    }

    // Render tables for different statuses
    renderTable($approved, 'Approved Applications', 'approved');
    renderTable($rejected, 'Rejected Applications', 'rejected');
    renderTable($hold, 'Pending/Hold Applications', 'pending');

} catch (PDOException $e) {
    // Error message passed to dashboard
    echo "<script>showPopup('Database error: " . addslashes(htmlspecialchars($e->getMessage())) . "');</script>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="interns_applications.css">
    
</head>
<body>
    
</body>
<script>
      // Show success or error popups
  function showPopup(message, isError = true) {
    const modal = document.createElement('div');
    modal.className = 'modal';
    modal.innerHTML = `
        <div class="modal-content">
            <p class="${isError ? 'error' : 'success'}">${message}</p>
            <button onclick="closePopup()" class="modal-btn">OK</button>
        </div>
    `;
    document.body.appendChild(modal);
    modal.style.display = 'block';
}

function closePopup() {
    const modal = document.querySelector('.modal');
    if (modal) modal.remove();
}


async function updateStatus(id, status) {
    try {
        const response = await fetch('update_status.awc', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `id=${id}&status=${status}`
        });

        const data = await response.json();
        if (data.success) {
            showPopup(data.message, false);
            document.getElementById(`status-${id}`).textContent = status;
        } else {
            showPopup(data.message);
        }
    } catch (error) {
        showPopup('Error updating status: ' + error.message);
    }
}
</script>
</html>