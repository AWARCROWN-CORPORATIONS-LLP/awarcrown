<?php
session_start();


if (!isset($_SESSION['username']) || !isset($_SESSION['email'])) {
    header('Location: https://cybertron7.in/test/Vanguard/security/register.php');
    exit;
}

$username = $_SESSION['username'];
$email = $_SESSION['email'];

try {
    // Database connection
    $pdo = new PDO("mysql:host=localhost;dbname=ideaship", "awarcrownadmin", "Aditya@1299", [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);

    
    $stmt = $pdo->prepare("SELECT points FROM user_rewards WHERE email = ?");
    $stmt->execute([$email]);
    $reward = $stmt->fetch();
    $reward_points = $reward ? $reward['points'] : 0;

    // Fetch total number of interns
    $stmt = $pdo->query("SELECT COUNT(*) as total_interns FROM users");
    $total_interns = $stmt->fetch()['total_interns'];

    // Fetch recent announcements (limit to 3)
    $stmt = $pdo->query("SELECT title, content, created_at FROM announcements ORDER BY created_at DESC LIMIT 3");
    $announcements = $stmt->fetchAll();

    // Fetch upcoming deadlines
    $stmt = $pdo->query("SELECT title, deadline_date FROM deadlines WHERE deadline_date >= CURDATE() ORDER BY deadline_date ASC LIMIT 3");
    $deadlines = $stmt->fetchAll();

    // Fetch intern profiles
    $sql = "SELECT u.username, up.name, u.profile_picture, up.bio, up.linkedin, up.github, up.twitter, up.other_social_links,up.quote 
            FROM users u 
            JOIN user_profiles up ON u.user_id = up.user_id 
            WHERE up.is_profile_public = 1 AND u.username != ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$username]);
    $interns = $stmt->fetchAll();
    error_log("Fetched " . count($interns) . " intern profiles for display");
} catch (PDOException $e) {
    error_log("Database error: " . $e->getMessage());
    $error_message = "Unable to fetch data. Please try again later.";
    $interns = [];
    $reward_points = 0;
    $total_interns = 0;
    $announcements = [];
    $deadlines = [];
}

$name = '';
$bio = '';
$phone = '';
$location = '';
$linkedin = '';
$github = '';
$twitter = '';
$quote = '';
$row = ['is_profile_public' => true]; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Internship Portal</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link href="style.css" rel="stylesheet" defer>
    <link rel="icon" href="https://cybertron7.in/images/black_logo.png" />

    <link rel="stylesheet" href="userprofile/stylesheet/userprofile.css" defer>
   
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
  <link href="show_profile.css" rel="stylesheet" defer>
   
    <link href="style_videos.css" rel="stylesheet" defer>
     <script src="script.js"></script>
    
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
            position: fixed;
            top: 50%;
            left: 50%;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        .dashboard-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        .stat-card {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            text-align: center;
            transition: transform 0.3s ease;
        }
        .stat-card:hover {
            transform: translateY(-5px);
        }
        .stat-card h3 {
            margin: 0;
            font-size: 1.2em;
            color: #333;
        }
        .stat-card p {
            margem: 10px 0 0;
            font-size: 2em;
            color: #3498db;
        }
        .announcements, .deadlines {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .announcements h2, .deadlines h2 {
            margin-top: 0;
            font-size: 1.5em;
            color: #333;
        }
        .announcement-item, .deadline-item {
            border-bottom: 1px solid #eee;
            padding: 10px 0;
        }
        .announcement-item:last-child, .deadline-item:last-child {
            border-bottom: none;
        }
        .announcement-item h3, .deadline-item h3 {
            margin: 0;
            font-size: 1.2em;
        }
        .announcement-item p, .deadline-item p {
            margin: 5px 0 0;
            color: #666;
        }
        .warning {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: #f8d7da;
            color: #721c24;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            z-index: 1001; /* Higher than content */
            text-align: center;
            max-width: 90%;
            width: 400px;
        }

        .hide-content .container {
            display: none !important;
        }
        
        @media screen and (max-width: 1024px) {
            .warning {
                display: block;
            }
            .container {
                display: none;
            }
        }
    </style>
</head>
<script>
    function checkDevice() {
    const isMobile = window.innerWidth <= 1024;

    if (isMobile) {
        // Redirect to the error page
        window.location.href = 'https://cybertron7.in/test/Vanguard/security/sc_error.awc';
    } else {
        // Optional: Continue showing your page content
        const warning = document.getElementById('warning');
        const container = document.querySelector('.container');
        if (warning) warning.style.display = 'none';
        if (container) container.style.display = 'block';
        document.body.classList.remove('hide-content');
    }
}

// Run on page load
window.addEventListener('load', checkDevice);
// Run on window resize
window.addEventListener('resize', checkDevice);


</script>
<body>
    <div id="warning" class="warning">
        <p><strong>Warning:</strong> This website is optimized for laptops and desktops. For a better experience, please use a laptop or desktop.</p>
    </div>
    <div class="container">
        <div class="top-nav">
            <div class="nav-brand">
                <img src="images/logo-2.png" alt="logo" style = "height : 40px;">
                <a href="https://cybertron7.in" style="color: #ffff; text-decoration: none;">Awarcrown Corporations</a>
            </div>
            <div class="user-info">
                <span><?php echo htmlspecialchars($username); ?></span>
            </div>
        </div>
        <div class="main-content">
            <div class="sidebar">
                <nav class="sidebar-nav">
                    <a href="#" class="nav-item active" data-section="dashboard">
                        <i class="material-icons">dashboard</i>
                        <span>Dashboard</span>
                    </a>
                    <a href="#" class="nav-item" data-section="view-status">
                        <i class="material-icons">visibility</i>
                        <span>View Application Status</span>
                    </a>
                    <a href="#" class="nav-item" data-section="interview-schedule">
                        <i class="material-icons">event</i>
                        <span>Interview Schedule</span>
                    </a>
                    <a href="#" class="nav-item" data-section="internship-resources">
                        <i class="material-icons">school</i>
                        <span>Internship Resources</span>
                    </a>
                    <a href="#" class="nav-item" data-section="interns-list">
                        <i class="material-icons">group</i>
                        <span>Other Interns</span>
                    </a>
                    <a href="#" class="nav-item" data-section="profile">
                        <i class="material-icons">person</i>
                        <span>Profile</span>
                    </a>
                    <a href="#" class="nav-item has-submenu" id="help-support-toggle">
                        <i class="material-icons">help</i>
                        <span>Help & Support</span>
                        <i class="material-icons expand-icon">expand_more</i>
                    </a>
                    <div class="submenu" id="help-support-submenu">
                        <a href="#" class="nav-item" data-section="faq">
                            <i class="material-icons">live_help</i>
                            <span>FAQs</span>
                        </a>
                    </div>
                    <a href="#" class="nav-item" data-section="view-tickets">
                        <i class="material-icons">support</i>
                        <span>Feedback-report</span>
                    </a>
                  <a href="#" class="nav-item logout" onclick="logoutUser()">
    <i class="material-icons">exit_to_app</i>
    <span>Logout</span>
</a>
                </nav>
            </div>
            <div class="content-area">
                <div class="section active" id="dashboard">
                    <h1>Dashboard</h1>
                    <p>Welcome to your internship portal dashboard, <?php echo htmlspecialchars($username); ?>!</p>
                    <div class="dashboard-stats">
                        <div class="stat-card">
                            <h3>Reward Points</h3>
                            <p><?php echo htmlspecialchars($reward_points); ?></p>
                        </div>
                        <div class="stat-card">
                            <h3>Total Interns</h3>
                            <p><?php echo htmlspecialchars($total_interns); ?></p>
                        </div>
                    </div>
                    <div class="announcements">
                        <h2>Recent Announcements</h2>
                        <?php foreach ($announcements as $announcement): ?>
                            <div class="announcement-item">
                                <h3><?php echo htmlspecialchars($announcement['title']); ?></h3>
                                <p><?php echo htmlspecialchars($announcement['content']); ?></p>
                                <p><small><?php echo date('F j, Y', strtotime($announcement['created_at'])); ?></small></p>
                            </div>
                        <?php endforeach; ?>
                        <?php if (empty($announcements)): ?>
                            <p>No recent announcements.</p>
                        <?php endif; ?>
                    </div>
                    <div class="deadlines">
                        <h2>Upcoming Deadlines</h2>
                        <?php foreach ($deadlines as $deadline): ?>
                            <div class="deadline-item">
                                <h3><?php echo htmlspecialchars($deadline['title']); ?></h3>
                                <p>Deadline: <?php echo date('F j, Y', strtotime($deadline['deadline_date'])); ?></p>
                            </div>
                        <?php endforeach; ?>
                        <?php if (empty($deadlines)): ?>
                            <p>No upcoming deadlines.</p>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="section" id="interview-schedule">
                    <h1>Interview Schedule</h1>
                    <div class="schedule-container">
                        <p class="info-message">Interview details will be shared once your details are verified.</p>
                    </div>
                </div>
                <div class="section" id="internship-resources">
                    <h1>Internship Resources</h1>
                    <div class="resources-container">
                        <?php
                        if (file_exists('resources.php')) {
                            include 'resources.php';
                        } else {
                            echo '<p>Error: Resources file not found.</p>';
                        }
                        ?>
                    </div>
                </div>
                <div class="section" id="view-tickets">
                    <?php
                    if (file_exists('feedback.php')) {
                        include 'feedback.php';
                    } else {
                        echo '<p>Error: Feedback file not found.</p>';
                    }
                    ?>
                </div>
                <div class="section" id="new-ticket" style="display: none;">
                    <h1>Submit a Support Ticket</h1>
                    <div class="form-container">
                        <form id="new-ticket-form" novalidate>
                            <div class="form-group">
                                <label for="ticket-subject">Subject:</label>
                                <input type="text" id="ticket-subject" name="subject" required placeholder="e.g., Application Issue">
                                <div class="error" id="ticket-subject-error"></div>
                            </div>
                            <div class="form-group">
                                <label for="ticket-description">Description:</label>
                                <textarea id="ticket-description" name="description" rows="5" required placeholder="Describe your issue..."></textarea>
                                <div class="error" id="ticket-description-error"></div>
                            </div>
                            <div class="button-group">
                                <button type="button" class="btn btn-secondary" id="cancel-ticket-btn">Cancel</button>
                                <button type="submit" class="btn btn-success">Submit Ticket</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="section" id="view-status">
                    <h1>Application Status</h1>
                    <div class="status-container">
                        <div class="form-group">
                            <label for="app-number">Enter Application Number:</label>
                            <input type="text" id="app-number" name="app-number" placeholder="e.g., AWC-202504XXXX">
                            <div class="error" id="app-number-error"></div>
                        </div>
                        <button class="btn btn-primary" id="check-status-btn">Check Status</button>
                        <div id="status-result" class="status-result"></div>
                    </div>
                </div>
                <div class="section" id="interns-list">
                    <h1>Meet Other Interns</h1>
                    <?php if (isset($error_message)): ?>
                        <div class="error-message"><?php echo htmlspecialchars($error_message); ?></div>
                    <?php elseif (empty($interns)): ?>
                        <p class="no-interns">No public intern profiles available.</p>
                    <?php else: ?>
                        <div class="interns-container">
                            <?php foreach ($interns as $intern): ?>
                                <div class="intern-card">
                                    <img src="<?php echo !empty($intern['profile_picture']) ? 'userprofile/uploadProfile/' . htmlspecialchars($intern['profile_picture']) : 'https://cybertron7.in/test/form-1/default-profile.png'; ?>" 
                                         alt="Profile Picture" 
                                         onerror="this.src='https://cybertron7.in/test/form-1/default-profile.png'">
                                    <h3><?php echo htmlspecialchars($intern['name'] ?? 'No Name Provided'); ?></h3>
                                    <p><strong>Username:</strong> <?php echo htmlspecialchars($intern['username']); ?></p>
                                    <p><strong>Bio:</strong> <?php echo htmlspecialchars($intern['bio'] ?? 'No bio available'); ?></p>
                                    <p><strong>Quote:</strong><?php echo htmlspecialchars($intern['quote']?? 'No quote available');?></p>
                                    <div class="social-links_other">
                                        <?php if (!empty($intern['linkedin'])): ?>
                                            <a href="<?php echo htmlspecialchars($intern['linkedin']); ?>" target="_blank" title="LinkedIn">
                                                <i class="fab fa-linkedin"></i>
                                            </a>
                                        <?php endif; ?>
                                        <?php if (!empty($intern['github'])): ?>
                                            <a href="<?php echo htmlspecialchars($intern['github']); ?>" target="_blank" title="GitHub">
                                                <i class="fab fa-github"></i>
                                            </a>
                                        <?php endif; ?>
                                        <?php if (!empty($intern['twitter'])): ?>
                                            <a href="<?php echo htmlspecialchars($intern['twitter']); ?>" target="_blank" title="Twitter">
                                                <i class="fab fa-twitter"></i>
                                            </a>
                                        <?php endif; ?>
                                        <?php $other_links = json_decode($intern['other_social_links'] ?? '[]', true); ?>
                                        <?php if (is_array($other_links)): ?>
                                            <?php foreach ($other_links as $link): ?>
                                                <?php if (!empty($link['name']) && !empty($link['url'])): 
                                                    $name = strtolower($link['name']);
                                                    $icons = [
                                                        'facebook' => 'fab fa-facebook',
                                                        'instagram' => 'fab fa-instagram',
                                                        'youtube' => 'fab fa-youtube',
                                                        'behance' => 'fab fa-behance',
                                                        'dribbble' => 'fab fa-dribbble',
                                                        'website' => 'fas fa-globe',
                                                    ];
                                                    $icon = $icons[$name] ?? 'fas fa-link';
                                                ?>
                                                    <a href="<?php echo htmlspecialchars($link['url']); ?>" target="_blank" title="<?php echo htmlspecialchars($link['name']); ?>">
                                                        <i class="<?php echo $icon; ?>"></i>
                                                    </a>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="section" id="profile">
                    <?php
                    if (file_exists('show_profile.php')) {
                        
                        include 'show_profile.php';
                        echo '';
                    } else {
                        echo '<p>Error: Profile file not found.</p>';
                    }
                    ?>
                </div>
                <div class="modal" id="edit-profile-modal" style="display: none;">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h2>Edit Profile</h2>
                            <button class="close-btn" id="close-modal-btn">×</button>
                        </div>
                        <div class="modal-body" id="profile-content">
                            <div class="loading-overlay" id="loadingOverlay">
                                <div class="loading-spinner"></div>
                            </div>
                            <form id="edit-profile-form" enctype="multipart/form-data" novalidate>
                                <div class="form-group">
                                    <label for="name">Name:</label>
                                    <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($name); ?>" required>
                                    <div class="error" id="name-error"></div>
                                </div>
                                <div class="form-group">
                                    <label for="bio">Bio:</label>
                                    <textarea id="bio" name="bio" rows="4"><?php echo htmlspecialchars($bio); ?></textarea>
                                    <div class="error" id="bio-error"></div>
                                </div>
                                <div class="form-group">
                                    <label for="phone">Phone:</label>
                                    <input type="tel" id="phone" name="phone" value="<?php echo htmlspecialchars($phone); ?>" pattern="[0-9]{10}">
                                    <div class="error" id="phone-error"></div>
                                </div>
                                <div class="form-group">
                                    <label for="location">Location:</label>
                                    <input type="text" id="location" name="location" value="<?php echo htmlspecialchars($location); ?>">
                                    <div class="error" id="location-error"></div>
                                </div>
                                <div class="form-group">
                                    <label for="linkedin">LinkedIn URL:</label>
                                    <input type="url" id="linkedin" name="linkedin" value="<?php echo htmlspecialchars($linkedin); ?>">
                                    <div class="error" id="linkedin-error"></div>
                                </div>
                                <div class="form-group">
                                    <label for="github">GitHub URL:</label>
                                    <input type="url" id="github" name="github" value="<?php echo htmlspecialchars($github); ?>">
                                    <div class="error" id="github-error"></div>
                                </div>
                                <div class="form-group">
                                    <label for="twitter">Twitter URL:</label>
                                    <input type="url" id="twitter" name="twitter" value="<?php echo htmlspecialchars($twitter); ?>">
                                    <div class="error" id="twitter-error"></div>
                                </div>
                                <div class="form-group">
                                    <label for="profile-picture">Profile Picture:</label>
                                    <input type="file" id="profile-picture" name="profile_picture" accept="image/*">
                                    <div class="error" id="profile-picture-error"></div>
                                </div>
                                <div class="form-group">
                                    <label for="is_profile_public">Share Profile with Other Interns:</label>
                                    <input type="checkbox" id="is_profile_public" name="is_profile_public" <?php echo ($row['is_profile_public'] ?? true) ? 'checked' : ''; ?>>
                                    <span class="checkbox-label">Allow other interns to view my profile</span>
                                    <div class="error" id="is_profile_public-error"></div>
                                </div>
                                <div class="button-group">
                                    <button type="button" class="btn btn-secondary" id="cancel-edit-btn">Cancel</button>
                                    <button type="submit" class="btn btn-success">Save Changes</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="section" id="faq">
                    <h1>Frequently Asked Questions (FAQs)</h1>
                    <div class="faq-container">
                        <div class="faq-item">
                            <h3>1. What is the duration of the internship?</h3>
                            <p>The internship lasts for 6 months, typically running from June to November.</p>
                        </div>
                        <div class="faq-item">
                            <h3>2. Is this a paid internship?</h3>
                            <p>No, this is an unpaid internship. It focuses on providing valuable experience and skill development.</p>
                        </div>
                        <div class="faq-item">
                            <h3>3. What type of internship is offered?</h3>
                            <p>This is a remote internship, allowing you to work from anywhere with an internet connection.</p>
                        </div>
                        <div class="faq-item">
                            <h3>4. Who is eligible to apply?</h3>
                            <p>Students currently enrolled in a college or university, in any year of study, are eligible to apply.</p>
                        </div>
                        <div class="faq-item">
                            <h3>5. What roles are available in the internship?</h3>
                            <p>Available roles include Team Leader + Developer and Developer, across various domains like UI/UX, Backend, Frontend, etc.</p>
                        </div>
                        <div class="faq-item">
                            <h3>6. How can I check my application status?</h3>
                            <p>You can check your application status by entering your application number in the "View Application Status" section of the portal.</p>
                        </div>
                        <div class="faq-item">
                            <h3>7. Will I receive a certificate upon completion?</h3>
                            <p>Yes, a certificate of completion will be provided to interns who successfully complete the program.</p>
                        </div>
                        <div class="faq-item">
                            <h3>8. What resources will be provided during the internship?</h3>
                            <p>Resources such as training materials, project guidelines, and access to necessary tools will be available once the internship starts.</p>
                        </div>
                        <div class="faq-item">
                            <h3>9. How are interviews scheduled?</h3>
                            <p>Interview details will be shared via email once your application is verified. Check the "Interview Schedule" section for updates.</p>
                        </div>
                        <div class="faq-item">
                            <h3>10. Can I contact support if I have issues?</h3>
                            <p>Yes, you can reach out through the "Feedback report" section or contact us through email (support@cybertron7.in)</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function showLoading() {
            document.getElementById('loadingOverlay').style.display = 'flex';
        }
        window.addEventListener('load', function() {
            document.getElementById('loadingOverlay').style.display = 'none';
        });

        // Sidebar navigation
        document.querySelectorAll('.nav-item').forEach(item => {
            item.addEventListener('click', function(e) {
                e.preventDefault();
                if (!this.classList.contains('has-submenu') && !this.classList.contains('logout')) {
                    document.querySelectorAll('.nav-item').forEach(nav => nav.classList.remove('active'));
                    this.classList.add('active');
                    document.querySelectorAll('.section').forEach(section => section.classList.remove('active'));
                    const sectionId = this.getAttribute('data-section');
                    document.getElementById(sectionId).classList.add('active');
                }
            });
        });

        // Help & Support submenu toggle
        document.getElementById('help-support-toggle').addEventListener('click', function(e) {
            e.preventDefault();
            const submenu = document.getElementById('help-support-submenu');
            submenu.style.display = submenu.style.display === 'block' ? 'none' : 'block';
        });

        // Edit profile button
        const editProfileBtn = document.getElementById('edit-profile-btn');
        if (editProfileBtn) {
            editProfileBtn.addEventListener('click', function() {
                document.getElementById('edit-profile-modal').style.display = 'block';
            });
        }

        // Close modal
        const closeModalBtn = document.getElementById('close-modal-btn');
        if (closeModalBtn) {
            closeModalBtn.addEventListener('click', function() {
                document.getElementById('edit-profile-modal').style.display = 'none';
            });
        }

        // Cancel edit
        const cancelEditBtn = document.getElementById('cancel-edit-btn');
        if (cancelEditBtn) {
            cancelEditBtn.addEventListener('click', function() {
                document.getElementById('edit-profile-modal').style.display = 'none';
            });
        }
        function logoutUser() {
    
    window.location.href = "https://cybertron7.in/test/Vanguard/security/logout.php";
}
    </script>
   
</body>
</html>