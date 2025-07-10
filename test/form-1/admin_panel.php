<?php
session_start();

$username = $_SESSION['username'];
$email = $_SESSION['email'];

// Database connection
try {
    $pdo = new PDO("mysql:host=localhost;dbname=ideaship", "awarcrownadmin", "Aditya@1299", [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Fetch all users with their reward points
$stmt = $pdo->query("SELECT i.email, i.username, COALESCE(ur.points, 0) as points 
                     FROM interns i 
                     LEFT JOIN user_rewards ur ON i.email = ur.email");
$users = $stmt->fetchAll();

// Fetch all deadlines
$stmt = $pdo->query("SELECT id, title, deadline_date FROM deadlines ORDER BY deadline_date ASC");
$deadlines = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Awarcrown Corporations</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f4f7fa;
            margin: 0;
        }
        .container {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        .top-nav {
            background: #ffffff;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .nav-brand {
            font-size: 1.5em;
            font-weight: 700;
            color: #333;
        }
        .user-info {
            font-size: 1em;
            color: #333;
        }
        .main-content {
            display: flex;
            flex: 1;
        }
        .sidebar {
            width: 250px;
            background: #2c3e50;
            color: #fff;
            padding: 20px;
        }
        .sidebar-nav .nav-item {
            display: flex;
            align-items: center;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 4px;
            cursor: pointer;
            transition: background 0.3s;
        }
        .sidebar-nav .nav-item:hover, .sidebar-nav .nav-item.active {
            background: #3498db;
        }
        .sidebar-nav .nav-item i {
            margin-right: 10px;
        }
        .content-area {
            flex: 1;
            padding: 20px;
        }
        .section {
            display: none;
        }
        .section.active {
            display: block;
        }
        .table-container {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }
        th {
            background: #3498db;
            color: #fff;
        }
        .btn {
            padding: 8px 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background 0.3s;
        }
        .btn-primary {
            background: #3498db;
            color: #fff;
        }
        .btn-primary:hover {
            background: #2980b9;
        }
        .btn-danger {
            background: #e74c3c;
            color: #fff;
        }
        .btn-danger:hover {
            background: #c0392b;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: 500;
        }
        .form-group input {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .error {
            color: #e74c3c;
            font-size: 0.9em;
            margin-top: 5px;
        }
        .modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }
        .modal-content {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            width: 400px;
            max-width: 90%;
        }
        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        .modal-header h2 {
            margin: 0;
        }
        .close-btn {
            background: none;
            border: none;
            font-size: 1.5em;
            cursor: pointer;
        }
        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 1001;
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
        <div class="top-nav">
            <div class="nav-brand">Awarcrown Corporations - Admin Panel</div>
            <div class="user-info">
                <span><?php echo htmlspecialchars($username); ?></span>
            </div>
        </div>
        <div class="main-content">
            <div class="sidebar">
                <nav class="sidebar-nav">
                    <a href="#" class="nav-item active" data-section="manage-rewards">
                        <i class="material-icons">star</i>
                        <span>Manage Rewards</span>
                    </a>
                    <a href="#" class="nav-item" data-section="manage-deadlines">
                        <i class="material-icons">event</i>
                        <span>Manage Deadlines</span>
                    </a>
                    <a href="https://cybertron7.in/test/Vanguard/security/logout.php" class="nav-item logout">
                        <i class="material-icons">exit_to_app</i>
                        <span>Logout</span>
                    </a>
                </nav>
            </div>
            <div class="content-area">
                <div class="section active" id="manage-rewards">
                    <h1>Manage Reward Points</h1>
                    <div class="table-container">
                        <table>
                            <thead>
                                <tr>
                                    <th>Email</th>
                                    <th>Username</th>
                                    <th>Points</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($users as $user): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($user['email']); ?></td>
                                        <td><?php echo htmlspecialchars($user['username']); ?></td>
                                        <td><?php echo htmlspecialchars($user['points']); ?></td>
                                        <td>
                                            <button class="btn btn-primary update-points-btn" data-email="<?php echo htmlspecialchars($user['email']); ?>">Update</button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="section" id="manage-deadlines">
                    <h1>Manage Deadlines</h1>
                    <div class="table-container">
                        <button class="btn btn-primary" id="add-deadline-btn">Add New Deadline</button>
                        <table>
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Deadline Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($deadlines as $deadline): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($deadline['title']); ?></td>
                                        <td><?php echo date('Y-m-d', strtotime($deadline['deadline_date'])); ?></td>
                                        <td>
                                            <button class="btn btn-primary update-deadline-btn" data-id="<?php echo $deadline['id']; ?>">Update</button>
                                            <button class="btn btn-danger delete-deadline-btn" data-id="<?php echo $deadline['id']; ?>">Delete</button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal" id="update-points-modal">
            <div class="modal-content">
                <div class="modal-header">
                    <h2>Update Reward Points</h2>
                    <button class="close-btn" id="close-points-modal">×</button>
                </div>
                <div class="modal-body">
                    <form id="update-points-form">
                        <div class="form-group">
                            <label for="points-email">Email:</label>
                            <input type="email" id="points-email" name="email" readonly>
                        </div>
                        <div class="form-group">
                            <label for="points">Points:</label>
                            <input type="number" id="points" name="points" required min="0">
                            <div class="error" id="points-error"></div>
                        </div>
                        <button type="submit" class="btn btn-primary">Update Points</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal" id="deadline-modal">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 id="deadline-modal-title">Add/Update Deadline</h2>
                    <button class="close-btn" id="close-deadline-modal">×</button>
                </div>
                <div class="modal-body">
                    <form id="deadline-form">
                        <input type="hidden" id="deadline-id" name="id">
                        <div class="form-group">
                            <label for="deadline-title">Title:</label>
                            <input type="text" id="deadline-title" name="title" required>
                            <div class="error" id="deadline-title-error"></div>
                        </div>
                        <div class="form-group">
                            <label for="deadline-date">Deadline Date:</label>
                            <input type="date" id="deadline-date" name="deadline_date" required>
                            <div class="error" id="deadline-date-error"></div>
                        </div>
                        <button type="submit" class="btn btn-primary">Save Deadline</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="loading-overlay" id="loadingOverlay">
            <div class="loading-spinner"></div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            // Sidebar navigation
            $('.nav-item').click(function(e) {
                e.preventDefault();
                if (!$(this).hasClass('logout')) {
                    $('.nav-item').removeClass('active');
                    $(this).addClass('active');
                    $('.section').removeClass('active');
                    $('#' + $(this).data('section')).addClass('active');
                }
            });

            // Show loading overlay
            function showLoading() {
                $('#loadingOverlay').show();
            }

            // Hide loading overlay
            function hideLoading() {
                $('#loadingOverlay').hide();
            }

            // Update points modal
            $('.update-points-btn').click(function() {
                const email = $(this).data('email');
                $('#points-email').val(email);
                $('#update-points-modal').show();
            });

            // Close points modal
            $('#close-points-modal').click(function() {
                $('#update-points-modal').hide();
                $('#update-points-form')[0].reset();
                $('#points-error').text('');
            });

            // Update points form submission
            $('#update-points-form').submit(function(e) {
                e.preventDefault();
                const email = $('#points-email').val();
                const points = $('#points').val();
                if (points < 0) {
                    $('#points-error').text('Points cannot be negative');
                    return;
                }
                showLoading();
                $.ajax({
                    url: 'update_points.php',
                    type: 'POST',
                    data: { email, points },
                    success: function(response) {
                        if (response.success) {
                            location.reload();
                        } else {
                            $('#points-error').text(response.message);
                        }
                    },
                    error: function() {
                        $('#points-error').text('An error occurred. Please try again.');
                    },
                    complete: function() {
                        hideLoading();
                    }
                });
            });

            // Add deadline modal
            $('#add-deadline-btn').click(function() {
                $('#deadline-modal-title').text('Add Deadline');
                $('#deadline-form')[0].reset();
                $('#deadline-id').val('');
                $('#deadline-modal').show();
            });

            // Update deadline modal
            $('.update-deadline-btn').click(function() {
                const id = $(this).data('id');
                showLoading();
                $.ajax({
                    url: 'get_deadline.php',
                    type: 'GET',
                    data: { id },
                    success: function(response) {
                        if (response.success) {
                            $('#deadline-id').val(response.data.id);
                            $('#deadline-title').val(response.data.title);
                            $('#deadline-date').val(response.data.deadline_date);
                            $('#deadline-modal-title').text('Update Deadline');
                            $('#deadline-modal').show();
                        } else {
                            alert(response.message);
                        }
                    },
                    complete: function() {
                        hideLoading();
                    }
                });
            });

            // Delete deadline
            $('.delete-deadline-btn').click(function() {
                if (!confirm('Are you sure you want to delete this deadline?')) return;
                const id = $(this).data('id');
                showLoading();
                $.ajax({
                    url: 'delete_deadline.php',
                    type: 'POST',
                    data: { id },
                    success: function(response) {
                        if (response.success) {
                            location.reload();
                        } else {
                            alert(response.message);
                        }
                    },
                    complete: function() {
                        hideLoading();
                    }
                });
            });

            // Deadline form submission
            $('#deadline-form').submit(function(e) {
                e.preventDefault();
                const id = $('#deadline-id').val();
                const title = $('#deadline-title').val();
                const deadline_date = $('#deadline-date').val();
                if (!title || !deadline_date) {
                    $('#deadline-title-error').text(!title ? 'Title is required' : '');
                    $('#deadline-date-error').text(!deadline_date ? 'Date is required' : '');
                    return;
                }
                showLoading();
                $.ajax({
                    url: 'update_deadline.php',
                    type: 'POST',
                    data: { id, title, deadline_date },
                    success:ycja

System: The artifact content was cut off. I'll complete the admin panel code and provide the backend PHP scripts for updating reward points and deadlines, ensuring they integrate with your existing internship portal. The solution will maintain the corporate theme, session-based authentication, and database structure (`ideaship` database, `user_rewards`, and `deadlines` tables) from your previous interactions. Below are the corrected and complete artifacts.

<xaiArtifact artifact_id="9582c91c-0797-47a6-9b69-b2bc48ac2b34" artifact_version_id="7c9137f6-ccc2-4970-aa83-f242cc5a5742" title="admin_panel.php" contentType="text/php">
<?php
session_start();
if (!isset($_SESSION['username']) || !isset($_SESSION['email']) || $_SESSION['role'] !== 'admin') {
    header('Location: https://cybertron7.in/test/Vanguard/security/register.php');
    exit;
}
$username = $_SESSION['username'];
$email = $_SESSION['email'];

// Database connection
try {
    $pdo = new PDO("mysql:host=localhost;dbname=ideaship", "awarcrownadmin", "your_password_here", [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Fetch all users with their reward points
$stmt = $pdo->query("SELECT i.email, i.username, COALESCE(ur.points, 0) as points 
                     FROM interns i 
                     LEFT JOIN user_rewards ur ON i.email = ur.email");
$users = $stmt->fetchAll();

// Fetch all deadlines
$stmt = $pdo->query("SELECT id, title, deadline_date FROM deadlines ORDER BY deadline_date ASC");
$deadlines = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Awarcrown Corporations</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f4f7fa;
            margin: 0;
        }
        .container {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        .top-nav {
            background: #ffffff;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .nav-brand {
            font-size: 1.5em;
            font-weight: 700;
            color: #333;
        }
        .user-info {
            font-size: 1em;
            color: #333;
        }
        .main-content {
            display: flex;
            flex: 1;
        }
        .sidebar {
            width: 250px;
            background: #2c3e50;
            color: #fff;
            padding: 20px;
        }
        .sidebar-nav .nav-item {
            display: flex;
            align-items: center;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 4px;
            cursor: pointer;
            transition: background 0.3s;
        }
        .sidebar-nav .nav-item:hover, .sidebar-nav .nav-item.active {
            background: #3498db;
        }
        .sidebar-nav .nav-item i {
            margin-right: 10px;
        }
        .content-area {
            flex: 1;
            padding: 20px;
        }
        .section {
            display: none;
        }
        .section.active {
            display: block;
        }
        .table-container {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }
        th {
            background: #3498db;
            color: #fff;
        }
        .btn {
            padding: 8px 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background 0.3s;
        }
        .btn-primary {
            background: #3498db;
            color: #fff;
        }
        .btn-primary:hover {
            background: #2980b9;
        }
        .btn-danger {
            background: #e74c3c;
            color: #fff;
        }
        .btn-danger:hover {
            background: #c0392b;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: 500;
        }
        .form-group input {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .error {
            color: #e74c3c;
            font-size: 0.9em;
            margin-top: 5px;
        }
        .modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }
        .modal-content {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            width: 400px;
            max-width: 90%;
        }
        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        .modal-header h2 {
            margin: 0;
        }
        .close-btn {
            background: none;
            border: none;
            font-size: 1.5em;
            cursor: pointer;
        }
        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 1001;
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
        <div class="top-nav">
            <div class="nav-brand">Awarcrown Corporations - Admin Panel</div>
            <div class="user-info">
                <span><?php echo htmlspecialchars($username); ?></span>
            </div>
        </div>
        <div class="main-content">
            <div class="sidebar">
                <nav class="sidebar-nav">
                    <a href="#" class="nav-item active" data-section="manage-rewards">
                        <i class="material-icons">star</i>
                        <span>Manage Rewards</span>
                    </a>
                    <a href="#" class="nav-item" data-section="manage-deadlines">
                        <i class="material-icons">event</i>
                        <span>Manage Deadlines</span>
                    </a>
                    <a href="https://cybertron7.in/test/Vanguard/security/logout.php" class="nav-item logout">
                        <i class="material-icons">exit_to_app</i>
                        <span>Logout</span>
                    </a>
                </nav>
            </div>
            <div class="content-area">
                <div class="section active" id="manage-rewards">
                    <h1>Manage Reward Points</h1>
                    <div class="table-container">
                        <table>
                            <thead>
                                <tr>
                                    <th>Email</th>
                                    <th>Username</th>
                                    <th>Points</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($users as $user): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($user['email']); ?></td>
                                        <td><?php echo htmlspecialchars($user['username']); ?></td>
                                        <td><?php echo htmlspecialchars($user['points']); ?></td>
                                        <td>
                                            <button class="btn btn-primary update-points-btn" data-email="<?php echo htmlspecialchars($user['email']); ?>">Update</button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="section" id="manage-deadlines">
                    <h1>Manage Deadlines</h1>
                    <div class="table-container">
                        <button class="btn btn-primary" id="add-deadline-btn">Add New Deadline</button>
                        <table>
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Deadline Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($deadlines as $deadline): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($deadline['title']); ?></td>
                                        <td><?php echo date('Y-m-d', strtotime($deadline['deadline_date'])); ?></td>
                                        <td>
                                            <button class="btn btn-primary update-deadline-btn" data-id="<?php echo $deadline['id']; ?>">Update</button>
                                            <button class="btn btn-danger delete-deadline-btn" data-id="<?php echo $deadline['id']; ?>">Delete</button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal" id="update-points-modal">
            <div class="modal-content">
                <div class="modal-header">
                    <h2>Update Reward Points</h2>
                    <button class="close-btn" id="close-points-modal">×</button>
                </div>
                <div class="modal-body">
                    <form id="update-points-form">
                        <div class="form-group">
                            <label for="points-email">Email:</label>
                            <input type="email" id="points-email" name="email" readonly>
                        </div>
                        <div class="form-group">
                            <label for="points">Points:</label>
                            <input type="number" id="points" name="points" required min="0">
                            <div class="error" id="points-error"></div>
                        </div>
                        <button type="submit" class="btn btn-primary">Update Points</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal" id="deadline-modal">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 id="deadline-modal-title">Add/Update Deadline</h2>
                    <button class="close-btn" id="close-deadline-modal">×</button>
                </div>
                <div class="modal-body">
                    <form id="deadline-form">
                        <input type="hidden" id="deadline-id" name="id">
                        <div class="form-group">
                            <label for="deadline-title">Title:</label>
                            <input type="text" id="deadline-title" name="title" required>
                            <div class="error" id="deadline-title-error"></div>
                        </div>
                        <div class="form-group">
                            <label for="deadline-date">Deadline Date:</label>
                            <input type="date" id="deadline-date" name="deadline_date" required>
                            <div class="error" id="deadline-date-error"></div>
                        </div>
                        <button type="submit" class="btn btn-primary">Save Deadline</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="loading-overlay" id="loadingOverlay">
            <div class="loading-spinner"></div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            // Sidebar navigation
            $('.nav-item').click(function(e) {
                e.preventDefault();
                if (!$(this).hasClass('logout')) {
                    $('.nav-item').removeClass('active');
                    $(this).addClass('active');
                    $('.section').removeClass('active');
                    $('#' + $(this).data('section')).addClass('active');
                }
            });

            // Show loading overlay
            function showLoading() {
                $('#loadingOverlay').show();
            }

            // Hide loading overlay
            function hideLoading() {
                $('#loadingOverlay').hide();
            }

            // Update points modal
            $('.update-points-btn').click(function() {
                const email = $(this).data('email');
                $('#points-email').val(email);
                $('#update-points-modal').show();
            });

            // Close points modal
            $('#close-points-modal').click(function() {
                $('#update-points-modal').hide();
                $('#update-points-form')[0].reset();
                $('#points-error').text('');
            });

            // Update points form submission
            $('#update-points-form').submit(function(e) {
                e.preventDefault();
                const email = $('#points-email').val();
                const points = $('#points').val();
                if (points < 0) {
                    $('#points-error').text('Points cannot be negative');
                    return;
                }
                showLoading();
                $.ajax({
                    url: 'update_points.php',
                    type: 'POST',
                    data: { email, points },
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            location.reload();
                        } else {
                            $('#points-error').text(response.message);
                        }
                    },
                    error: function() {
                        $('#points-error').text('An error occurred. Please try again.');
                    },
                    complete: function() {
                        hideLoading();
                    }
                });
            });

            // Add deadline modal
            $('#add-deadline-btn').click(function() {
                $('#deadline-modal-title').text('Add Deadline');
                $('#deadline-form')[0].reset();
                $('#deadline-id').val('');
                $('#deadline-modal').show();
            });

            // Update deadline modal
            $('.update-deadline-btn').click(function() {
                const id = $(this).data('id');
                showLoading();
                $.ajax({
                    url: 'get_deadline.php',
                    type: 'GET',
                    data: { id },
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            $('#deadline-id').val(response.data.id);
                            $('#deadline-title').val(response.data.title);
                            $('#deadline-date').val(response.data.deadline_date);
                            $('#deadline-modal-title').text('Update Deadline');
                            $('#deadline-modal').show();
                        } else {
                            alert(response.message);
                        }
                    },
                    complete: function() {
                        hideLoading();
                    }
                });
            });

            // Delete deadline
            $('.delete-deadline-btn').click(function() {
                if (!confirm('Are you sure you want to delete this deadline?')) return;
                const id = $(this).data('id');
                showLoading();
                $.ajax({
                    url: 'delete_deadline.php',
                    type: 'POST',
                    data: { id },
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            location.reload();
                        } else {
                            alert(response.message);
                        }
                    },
                    complete: function() {
                        hideLoading();
                    }
                });
            });

            // Deadline form submission
            $('#deadline-form').submit(function(e) {
                e.preventDefault();
                const id = $('#deadline-id').val();
                const title = $('#deadline-title').val();
                const deadline_date = $('#deadline-date').val();
                if (!title || !deadline_date) {
                    $('#deadline-title-error').text(!title ? 'Title is required' : '');
                    $('#deadline-date-error').text(!deadline_date ? 'Date is required' : '');
                    return;
                }
                showLoading();
                $.ajax({
                    url: 'update_deadline.php',
                    type: 'POST',
                    data: { id, title, deadline_date },
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            location.reload();
                        } else {
                            $('#deadline-title-error').text(response.message);
                        }
                    },
                    error: function() {
                        $('#deadline-title-error').text('An error occurred. Please try again.');
                    },
                    complete: function() {
                        hideLoading();
                    }
                });
            });
        });
    </script>
</body>
</html>