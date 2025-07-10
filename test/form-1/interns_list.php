<?php



$username = $_SESSION['username'];
$email = $_SESSION['email'];

try {
    $pdo = new PDO("mysql:host=localhost;dbname=ideaship", "awarcrownadmin", "Aditya@1299", [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);

    $sql = "SELECT u.username, up.name, u.profile_picture, up.bio, up.linkedin, up.github, up.twitter, up.other_social_links 
            FROM users u 
            JOIN user_profiles up ON u.user_id = up.user_id 
            WHERE up.is_profile_public = 1 AND u.username != ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$username]);
    $interns = $stmt->fetchAll();
    error_log("Fetched " . count($interns) . " intern profiles for display"); // Debugging
} catch (PDOException $e) {
    error_log("Error fetching interns: " . $e->getMessage());
    $error_message = "Unable to fetch intern profiles. Please try again later.";
    $interns = [];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Interns List</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
    <style>
        .interns-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            padding: 20px;
        }
        .intern-card {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
        }
        .intern-card:hover {
            transform: translateY(-5px);
        }
        .intern-card img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 10px;
        }
        .intern-card h3 {
            margin: 0;
            font-size: 1.2em;
            color: #333;
        }
        .intern-card p {
            margin: 5px 0;
            color: #666;
        }
        .social-links a {
            color: #3498db;
            text-decoration: none;
            margin-right: 10px;
        }
        .social-links a:hover {
            text-decoration: underline;
        }
        .no-interns, .error-message {
            color: #666;
            font-style: italic;
            padding: 20px;
        }
    </style>
</head>
<body>
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
                        <div class="social-links">
                            <?php if (!empty($intern['linkedin'])): ?>
                                <a href="<?php echo htmlspecialchars($intern['linkedin']); ?>" target="_blank">LinkedIn</a>
                            <?php endif; ?>
                            <?php if (!empty($intern['github'])): ?>
                                <a href="<?php echo htmlspecialchars($intern['github']); ?>" target="_blank">GitHub</a>
                            <?php endif; ?>
                            <?php if (!empty($intern['twitter'])): ?>
                                <a href="<?php echo htmlspecialchars($intern['twitter']); ?>" target="_blank">Twitter</a>
                            <?php endif; ?>
                            <?php $other_links = json_decode($intern['other_social_links'] ?? '[]', true); ?>
                            <?php if (is_array($other_links)): ?>
                                <?php foreach ($other_links as $link): ?>
                                    <?php if (!empty($link['name']) && !empty($link['url'])): ?>
                                        <a href="<?php echo htmlspecialchars($link['url']); ?>" target="_blank"><?php echo htmlspecialchars($link['name']); ?></a>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>