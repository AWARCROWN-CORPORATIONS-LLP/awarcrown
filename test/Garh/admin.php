<?php
// Error reporting configuration
ini_set('display_errors', 0);
ini_set('log_errors', 1);
ini_set('error_log', '/home/cybertron/public_html/test/logs/error.log');

session_start();

// Pagination logic
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int) $_GET['page'] : 1;
$limit = 10;
$offset = ($page - 1) * $limit;

try {
    $db = new PDO(
        "mysql:host=localhost;dbname=ideaship;charset=utf8mb4",
        "awarcrownadmin",
        "Aditya@1299",
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false
        ]
    );

    // Fetch applications
    $countStmt = $db->prepare("SELECT COUNT(*) FROM applications");
    $countStmt->execute();
    $totalApplications = $countStmt->fetchColumn();

    $stmt = $db->prepare("SELECT * FROM applications ORDER BY submitted_at DESC LIMIT :limit OFFSET :offset");
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    $applications = $stmt->fetchAll();

    // Count intern applications
    $countStmt = $db->prepare("SELECT COUNT(*) FROM intern_awc20250850");
    $countStmt->execute();
    $totalApplications_AWC = $countStmt->fetchColumn();

    // Fetch intern_awc20250850
    $internStmt = $db->prepare("SELECT * FROM intern_awc20250850 ORDER BY created_at ASC");
    $internStmt->execute();
    $interns = $internStmt->fetchAll();

} catch (PDOException $e) {
    error_log("Database error: " . $e->getMessage());
    $totalApplications = 0;
    $applications = $coreTeam = $interns = [];
    $dbError = "Database error: " . $e->getMessage();
}
$totalPages = ceil($totalApplications / $limit);
echo '<div style="margin: 20px 0;">';
for ($i = 1; $i <= $totalPages; $i++) {
    if ($i == $page) {
        echo "<strong>$i</strong> ";
    } else {
        echo "<a href='?page=$i'>[ $i ]</a> ";
    }
}
echo '</div>';
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Admin Dashboard</title>
<style>
body {
     font-family: 'Segoe UI', Tahoma, sans-serif;
    
    line-height: 1.6;
    background-color: #fff;
    color: #000;
    margin-right:0px;
}

.container {
    max-width: 1200px;
    
}

.stats {
    margin-bottom: 20px;
    padding: 12px 20px;
    background-color: #f2f2f2;
    border-left: 4px solid #000;
    font-weight: bold;
    border-radius: 4px;
}

button {
    padding: 8px 14px;
    margin-right: 10px;
    font-size: 14px;
    background-color: #000;
    color: #fff;
    border: none;
    border-radius: 3px;
    cursor: pointer;
    transition: background 0.3s;
}

button:hover {
    background-color: #333;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 30px;
}

th, td {
    padding: 10px;
    border: 1px solid #ccc;
    text-align: left;
}

th {
    background-color: #f7f7f7;
    font-weight: bold;
}

.resume-btn {
    background-color: #000;
    color: #fff;
    padding: 5px 10px;
    border: none;
    cursor: pointer;
    border-radius: 3px;
}

.resume-btn:hover {
    background-color: #444;
}

.resume-btn:disabled {
    background-color: #aaa;
    cursor: not-allowed;
}

#error-message, .error-message {
    color: #721c24;
    background-color: #f8d7da;
    padding: 10px;
    margin-bottom: 15px;
    border-radius: 4px;
    border: 1px solid #f5c6cb;
}

#resumeModal {
    display: none;
    position: fixed;
    top: 0; left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,0.6);
    z-index: 1000;
}

.modal-content {
    background: #fff;
    margin: 50px auto;
    padding: 20px;
    width: 80%;
    max-width: 800px;
    max-height: 80vh;
    overflow-y: auto;
    border-radius: 4px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    position: relative;
}

.close-btn {
    position: absolute;
    top: 10px;
    right: 20px;
    font-size: 24px;
    cursor: pointer;
    color: #000;
}

.loading {
    text-align: center;
    padding: 20px;
}

@media (max-width: 768px) {
    body {
        font-size: 14px;
        margin: 10px;
    }

    .container {
        padding: 0 10px;
    }

    table {
        display: block;
        overflow-x: auto;
        white-space: nowrap;
    }

    th, td {
        min-width: 100px;
        padding: 8px;
    }

    .modal-content {
        width: 95%;
        margin: 30px auto;
    }

    button, .resume-btn {
        font-size: 13px;
        padding: 6px 10px;
    }
}

</style>
</head>
<body>
<div class="container">
<?php if (isset($dbError)): ?>
<div class="error-message"><?php echo htmlspecialchars($dbError); ?></div>
<?php endif; ?>

<div style="margin-bottom: 20px;">
    <button onclick="showSection('applicationsTableSection')">Applications</button>
   
    <button onclick="showSection('internSection')">Intern AWC 20250850</button>
</div>

<div id="applicationsTableSection">
    <div class="stats">
    <h2>Total Applications: <span id="totalCount"><?php echo htmlspecialchars($totalApplications); ?></span></h2>
</div>
<table>
<thead><tr><th>ID</th><th>Name</th><th>Email</th><th>Phone</th><th>Tech Stack</th><th>Experience</th><th>Submitted At</th><th>Resume</th></tr></thead>
<tbody id="applicationsTable">
<?php if (!empty($applications)): foreach ($applications as $app): ?>
<tr><td><?= htmlspecialchars($app['id']) ?></td><td><?= htmlspecialchars($app['name']) ?></td><td><?= htmlspecialchars($app['email']) ?></td><td><?= htmlspecialchars($app['phone']) ?></td><td><?= htmlspecialchars($app['tech_stack']) ?></td><td><?= htmlspecialchars($app['experience']) ?></td><td><?= htmlspecialchars($app['submitted_at']) ?></td><td><button class="resume-btn" data-resume-path="<?= htmlspecialchars($app['resume']) ?>" onclick="viewResume(this)" <?= empty($app['resume']) ? 'disabled' : '' ?>>View</button></td></tr>
<?php endforeach; else: ?>
<tr><td colspan="8">No applications found</td></tr>
<?php endif; ?>
</tbody>
</table>
</div>

<div id="coreTeamSection" style="display: none;">
<h2>Core Team Members</h2>
<table>
<thead><tr><th>ID</th><th>Name</th><th>Email</th><th>Role</th><th>Joined</th></tr></thead>
<tbody>
<?php if (!empty($coreTeam)): foreach ($coreTeam as $member): ?>
<tr><td><?= htmlspecialchars($member['id']) ?></td><td><?= htmlspecialchars($member['name']) ?></td><td><?= htmlspecialchars($member['email']) ?></td><td><?= htmlspecialchars($member['role']) ?></td><td><?= htmlspecialchars($member['joined_at'] ?? 'N/A') ?></td></tr>
<?php endforeach; else: ?>

<tr><td colspan="5">No core team data available</td></tr>
<?php endif; ?>
</tbody>
</table>
</div>

<div id="internSection" style="display: none;">
<h2>Intern Applications - AWC 20250850</h2>
 <div class="stats">
    <h2>Total Applications: <span id="totalCount"><?php echo htmlspecialchars($totalApplications_AWC); ?></span></h2>
</div>
<table>
<thead><tr><th>ID</th><th>App ID</th><th>Name</th><th>Email</th><th>Phone</th><th>Program</th><th>Role</th><th>Tech</th><th>Motivation</th><th>Hours</th><th>College</th><th>CGPA</th><th>Resume</th><th>Created</th></tr></thead>
<tbody>
<?php if (!empty($interns)): foreach ($interns as $intern): ?>
<tr>
<td><?= htmlspecialchars($intern['id']) ?></td>
<td><?= htmlspecialchars($intern['application_id']) ?></td>
<td><?= htmlspecialchars($intern['name']) ?></td>
<td><?= htmlspecialchars($intern['email']) ?></td>
<td><?= htmlspecialchars($intern['phone']) ?></td>
<td><?= htmlspecialchars($intern['program']) ?></td>
<td><?= htmlspecialchars($intern['role']) ?></td>
<td><?= htmlspecialchars($intern['tech_stack']) ?></td>
<td><?= htmlspecialchars($intern['motivation']) ?></td>
<td><?= htmlspecialchars($intern['hours']) ?></td>
<td><?= htmlspecialchars($intern['college']) ?></td>
<td><?= htmlspecialchars($intern['cgpa']) ?></td>
<td><button class="resume-btn" data-resume-path="<?= htmlspecialchars($intern['resume']) ?>" onclick="viewResume(this)" <?= empty($intern['resume']) ? 'disabled' : '' ?>>View</button></td>
<td><?= htmlspecialchars($intern['created_at']) ?></td>
</tr>
<?php endforeach; else: ?>
<tr><td colspan="14">No intern applications found</td></tr>
<?php endif; ?>
</tbody>
</table>
</div>

<div id="resumeModal"><div class="modal-content"><span class="close-btn" onclick="closeModal()" title="Close">×</span><div id="resumeContent"></div></div></div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
(function($) {
'use strict';
const BASE_URL = '/test/form-1/';

window.viewResume = function(button) {
    const resumePath = $(button).data('resume-path');
    if (!resumePath) return showError('No resume path available');

    const fullUrl = BASE_URL + resumePath;
    const ext = resumePath.split('.').pop().toLowerCase();
    let content = '';
    if (ext === 'pdf') {
        content = `<iframe src="${fullUrl}" width="100%" height="600px" frameborder="0"></iframe>`;
    } else if (ext === 'doc' || ext === 'docx') {
        content = `<object data="${fullUrl}" width="100%" height="600px" type="application/msword"></object>`;
    } else {
        return showError('Unsupported file format: ' + ext);
    }

    fetch(fullUrl, { method: 'HEAD' }).then(res => {
        if (!res.ok) return showError(`Resume not found (Status: ${res.status})`);
        $('#resumeContent').html(content);
        $('#resumeModal').show();
    }).catch(() => showError('Error checking resume availability'));
};

function showError(msg) {
    $('#resumeContent').html(`<div class="error-message">${$('<div/>').text(msg).html()}</div>`);
    $('#resumeModal').show();
}

window.closeModal = function() {
    $('#resumeModal').hide();
    $('#resumeContent').empty();
};

window.showSection = function(id) {
    $('#applicationsTableSection, #coreTeamSection, #internSection').hide();
    $('#' + id).show();
};

$(window).on('click', e => { if (e.target.id === 'resumeModal') closeModal(); });
$(document).on('keydown', e => { if (e.key === 'Escape' && $('#resumeModal').is(':visible')) closeModal(); });
})(jQuery);
</script>
</body>
</html>


