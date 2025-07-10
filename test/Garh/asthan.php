<?php
session_name('Admin_session');
session_start();

if (!isset($_SESSION['username'])) {
    echo '<script>alert("Unauthorized access"); window.location.href = "https://cybertron7.in/test/Garh/AsthanGuard/vanguard.php";</script>';
    exit();
}

$name = $_SESSION['name'];
$email = $_SESSION['email'];
$position = $_SESSION['position'];
$postionapproval = $_SESSION['postionapproval'];
$document = $_SESSION['document'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | Cybertron7</title>
    <link rel="icon" href="Login/images/black_logo.png">
    <link rel="stylesheet" href="adminconsolestylesheet.css">
   

    <script src="https://cybertron7.in/test/Garh/admin.js" defer>
       
    </script>
</head>
<style>
    .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 1000;
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

<body>
    <nav>
        <div class="logo-heading">
            <a href="https://cybertron7.in">Cybertron7</a>
        </div>
    </nav>

    <aside>
        <div class="aside-buttons">
            <button onclick="viewProfile()">Profile</button>
         <!--   <button onclick="contactUs()">Contact Us</button>-->
            <button onclick="viewFeedback()">Feedback</button>
            <button onclick="viewInternApplications()">Intern Applications</button>
       <!--     <button onclick="manageTasks()">Task Manager</button>-->
         <!--   <button onclick="viewAnnouncements()">Announcements</button>-->
         <!--   <button onclick="viewResources()">Resources</button>-->
            <form action="adminlogout.php" method="post">
                <abbr title="Logout">
                    <button type="submit">Logout</button>
                </abbr>
            </form>
        </div>
        <div class="Admin-title">
            <h2>Cybertron7 Admin</h2>
        </div>
    </aside>

    <div id="warning" class="warning" style="display: none;">
        <p><strong>Warning:</strong> This dashboard is optimized for laptops and desktops. Please use a larger screen for the best experience.</p>
    </div>

    <main>
        <div>
            <input type="text" id="search-box" placeholder="Search..." onkeyup="searchUsers()" style="display: none;" />
        </div>
        <button id="close-btn" onclick="toggleView(null)" style="display: none; background-color: #d93025; color: white; padding: 10px; border: none; border-radius: 4px; cursor: pointer; margin-bottom: 10px;">
            Close
        </button>

        <div id="user-table" class="usersdetails" style="display: none;"></div>
        <div id="intern-applications" class="usersdetails" style="display: none;"></div>
        <div id="task-manager" class="usersdetails" style="display: none;"></div>
        <div id="announcements" class="usersdetails" style="display: none;"></div>
        <div id="resources" class="usersdetails" style="display: none;"></div>
    </main>

    <div class="Profile-session" style="display: none;">
        <div class="profile-content">
            <h2 id="user-name" style="color: #1a73e8; text-align: center;">Welcome <?php echo htmlspecialchars($name); ?>!</h2>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($email); ?></p>
            <p><strong>Position:</strong> <?php echo htmlspecialchars($position); ?></p>
            <p><strong>Status:</strong> <span style="color: #188038;"><?php echo htmlspecialchars($postionapproval); ?></span></p>
           
        </div>
    </div>
    <div class="loading-overlay" id="loadingOverlay">
        <div class="loading-spinner"></div>
    </div>
</body>
 <script>
        function showLoading() {
            document.getElementById('loadingOverlay').style.display = 'flex';
        }
        window.addEventListener('load',function(){
            document.getElementById('loadingOverlay').style.display='none';
        })
    </script>

</html>
