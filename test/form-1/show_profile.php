<?php
// Ensure database connection is available
require_once 'database/config.php';


if (!isset($_SESSION['username']) || empty($_SESSION['username'])) {
    echo "<script>
        alert('Vanguard Session Verification Failed. Login to continue.');
        window.location.href = 'https://cybertron7.in/test/Vanguard/security/register.awc';
    </script>";
    exit;
}


$username = $_SESSION['username'];
$email = $_SESSION['email'] ?? '';

// Fetch user profile data with error handling
try {
    $sql = "SELECT * FROM users LEFT JOIN user_profiles ON users.user_id = user_profiles.user_id WHERE users.username = ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        throw new Exception("Database prepare failed: " . $conn->error);
    }
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->num_rows > 0 ? $result->fetch_assoc() : [];
    $stmt->close();
} catch (Exception $e) {
    $error_message = "Error fetching profile: " . $e->getMessage();
    $row = [];
}

// Set defaults if no data found
$user_id = $row['user_id'] ?? null;
$target_dir = 'userprofile/uploadProfile/';
$profile_picture_path = !empty($row['profile_picture']) ? $target_dir . htmlspecialchars($row['profile_picture']) : "https://cybertron7.in/test/form-1/default-profile.png";
$username = htmlspecialchars($row['username'] ?? 'Unknown User');
$name = htmlspecialchars($row['name'] ?? 'No Name Provided');
$email = htmlspecialchars($row['email'] ?? 'No Email Provided');
$phone = htmlspecialchars($row['phone'] ?? 'Not Set');
$bio = htmlspecialchars($row['bio'] ?? 'No bio available');
$quote = htmlspecialchars($row['quote'] ?? '');
$location = htmlspecialchars($row['location'] ?? 'Location not specified');
$linkedin = htmlspecialchars($row['linkedin'] ?? '');
$github = htmlspecialchars($row['github'] ?? '');
$twitter = htmlspecialchars($row['twitter'] ?? '');
$other_social_links = json_decode($row['other_social_links'] ?? '[]', true);

// Fetch internship applications with error handling
try {
    $internship_sql = "SELECT applicant_id, company, status FROM interns WHERE email = ?";
    $internship_stmt = $conn->prepare($internship_sql);
    if (!$internship_stmt) {
        throw new Exception("Database prepare failed: " . $conn->error);
    }
    $internship_stmt->bind_param("s", $email);
    $internship_stmt->execute();
    $internship_result = $internship_stmt->get_result();
    $internships = $internship_result->fetch_all(MYSQLI_ASSOC);
    $internship_stmt->close();
} catch (Exception $e) {
    $internship_error = "Error fetching internships: " . $e->getMessage();
    $internships = [];
}
?>


 
   
   

<div class="profile-container">
    <aside class="profile-sidebar">
        <div class="avatar-container">
            <img src="<?php echo $profile_picture_path; ?>" 
                 alt="Profile Picture" 
                 class="avatar-image"
                 onerror="this.src='https://cybertron7.in/test/form-1/default-profile.png'">
        </div>
        <div class="profile-card">
            <h1 class="profile-header"><?php echo $name; ?></h1>
            <p class="username-text"><?php echo $username; ?></p>
            <?php if ($quote): ?>
                <p class="info-text">"<?php echo $quote; ?>"</p>
            <?php else: ?>
                <p class="info-text no-data">No quote set</p>
            <?php endif; ?>
            <?php if (isset($error_message)): ?>
                <div class="error-message"><?php echo $error_message; ?></div>
            <?php endif; ?>
        </div>
        <button class="btn btn-primary" id="edit-profile-btn">Edit Profile</button>
    </aside>

    <main class="profile-main">
        <div class="profile-card">
            <h2 class="profile-header">Internship Applications</h2>
            <?php if (isset($internship_error)): ?>
                <div class="error-message"><?php echo $internship_error; ?></div>
            <?php elseif (empty($internships)): ?>
                <p class="no-data">No applications found</p>
            <?php else: ?>
                <table class="internship-table">
                    <thead>
                        <tr>
                            <th>Application ID</th>
                            <th>Company</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($internships as $internship): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($internship['applicant_id'] ?? 'N/A'); ?></td>
                                <td><?php echo htmlspecialchars($internship['company'] ?? 'Unknown'); ?></td>
                                <td>
                                    <span class="status-badge status-<?php echo strtolower($internship['status'] ?? 'unknown'); ?>">
                                        <?php echo htmlspecialchars($internship['status'] ?? 'Unknown'); ?>
                                    </span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>

        <div class="profile-card">
            <h2 class="profile-header">About</h2>
            <div class="info-label">Bio</div>
            <p class="info-text"><?php echo $bio; ?></p>
            
            <div class="info-label">Email</div>
            <p class="info-text"><?php echo $email; ?></p>
            
            <div class="info-label">Phone</div>
            <p class="info-text"><?php echo $phone; ?></p>
            
            <div class="info-label">Location</div>
            <p class="info-text"><?php echo $location; ?></p>

            <?php if ($linkedin || $github || $twitter || !empty($other_social_links)): ?>
                <div class="info-label">Social Links</div>
                <div class="social-links">
                    <?php if ($linkedin): ?>
                        <div class="social-link">
                            <span>LinkedIn:</span>
                            <a href="<?php echo $linkedin; ?>" target="_blank"><?php echo $linkedin; ?></a>
                        </div>
                    <?php endif; ?>
                    <?php if ($github): ?>
                        <div class="social-link">
                            <span>GitHub:</span>
                            <a href="<?php echo $github; ?>" target="_blank"><?php echo $github; ?></a>
                        </div>
                    <?php endif; ?>
                    <?php if ($twitter): ?>
                        <div class="social-link">
                            <span>Twitter:</span>
                            <a href="<?php echo $twitter; ?>" target="_blank"><?php echo $twitter; ?></a>
                        </div>
                    <?php endif; ?>
                    <?php if (empty($linkedin) && empty($github) && empty($twitter) && empty($other_social_links)): ?>
                        <p class="no-data">No social links provided</p>
                    <?php endif; ?>
                    <?php foreach ($other_social_links as $link): ?>
                        <?php if (!empty($link['name']) && !empty($link['url'])): ?>
                            <div class="social-link">
                                <span><?php echo htmlspecialchars($link['name']); ?>:</span>
                                <a href="<?php echo htmlspecialchars($link['url']); ?>" target="_blank"><?php echo htmlspecialchars($link['url']); ?></a>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="info-label">Social Links</div>
                <p class="no-data">No social links provided</p>
            <?php endif; ?>
        </div>
    </main>
</div>

<script>
document.querySelector('.avatar-image')?.addEventListener('load', function() {
    console.log('Profile picture loaded');
});
document.querySelector('.avatar-image')?.addEventListener('error', function() {
    console.log('Failed to load profile picture, using default');
});
</script>
