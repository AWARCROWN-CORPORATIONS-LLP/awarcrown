<?php
session_start();

if (!isset($_SESSION['username']) || empty($_SESSION['username'])) {
    echo "<script>
        alert('Vanguard Session Verification Failed. Login to continue.');
        window.location.href = 'https://cybertron7.in/test/Vanguard/security/register.awc';
    </script>";
    exit;
}

require_once 'config.php';

$username = $_SESSION['username'];
$sql = "SELECT * FROM users LEFT JOIN user_profiles ON users.user_id = user_profiles.user_id WHERE users.username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->num_rows > 0 ? $result->fetch_assoc() : [];
$stmt->close();

$target_dir = 'userprofile/uploadProfile/';
$profile_picture_path = !empty($row['profile_picture']) ? $target_dir . htmlspecialchars($row['profile_picture']) : "default-profile.png";
$username = htmlspecialchars($row['username'] ?? 'default_user');
$name = htmlspecialchars($row['name'] ?? '');
$email = htmlspecialchars($row['email'] ?? '');
$phone = htmlspecialchars($row['phone'] ?? '');
$bio = htmlspecialchars($row['bio'] ?? '');
$quote = htmlspecialchars($row['quote'] ?? '');
$location = htmlspecialchars($row['location'] ?? '');
$linkedin = htmlspecialchars($row['linkedin'] ?? '');
$github = htmlspecialchars($row['github'] ?? '');
$twitter = htmlspecialchars($row['twitter'] ?? '');
$other_social_links = json_decode($row['other_social_links'] ?? '[]', true);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Profile</title>
    <!-- CropperJS CSS -->
<link href="https://unpkg.com/cropperjs/dist/cropper.min.css" rel="stylesheet" />

    <style>
        .profile-image {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #aaa;
        }
        .form-group, .form-input-section {
            margin-bottom: 1rem;
        }
        .image-upload {
            cursor: pointer;
            padding: 5px 10px;
            background-color: gray;
            color: white;
            border-radius: 5px;
            display: inline-block;
            margin-top: 5px;
        }
    </style>
</head>
<body>

<div class="container">
    <main class="form-main">
        <section class="form-section" id="form-section">
            <h1>Edit Profile</h1>

            <form id="upload-form" enctype="multipart/form-data" method="POST" action="https://cybertron7.in/test/form-1/userprofile/uploadprofile.awc">
                <div class="profile-image-container">
                    <img src="<?php echo $profile_picture_path; ?>" alt="Profile Preview" class="profile-image" id="profile-preview">
                    <?php if ($profile_picture_path !== "default-profile.png"): ?>
                        <button type="button" id="delete-button" class="btn btn-danger" data-url="https://cybertron7.in/test/form-1/userprofile/uploadprofile.awc?delete=true">Delete</button>
                    <?php endif; ?>
                    <div class="buttons-section">
                        <label for="profile-upload" class="image-upload">Edit Image</label>
                        <input type="file" id="profile-upload" name="image" hidden accept="image/*">
                        <!-- Cropping Modal -->
<div id="cropper-modal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:#000000aa; justify-content:center; align-items:center; z-index:9999;">
    <div style="background:#fff; padding:20px; border-radius:10px; max-width:90%; max-height:90%;">
        <h3>Crop Your Profile Picture</h3>
        <div>
            <img id="cropper-image" style="max-width:100%; max-height:400px;" />
        </div>
        <div style="margin-top:10px; text-align:right;">
            <button id="crop-btn">Crop & Preview</button>
            <button onclick="closeCropper()">Cancel</button>
        </div>
    </div>
</div>

                        <button type="submit" class="upload-btn">Upload</button>
                    </div>
                </div>
            </form>

            <form action="userprofile/uploadProfileSubmission.awc" class="edit-form" method="POST" id="profile-form">
                <div class="form-group">
                    <label for="is_profile_public">Share Profile with Other Interns:</label>
                    <input type="checkbox" id="is_profile_public" name="is_profile_public" <?php echo ($row['is_profile_public'] ?? true) ? 'checked' : ''; ?>>
                    <span class="checkbox-label">Allow other interns to view my profile</span>
                </div>

                <div class="name-username-section">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" id="name" name="name" value="<?php echo $name; ?>">
                    </div>
                    <div class="form-group">
                        <label for="username">@ Username</label>
                        <input type="text" id="username" name="username" value="<?php echo $username; ?>" readonly>
                    </div>
                </div>

                <div class="form-input-section">
                    <label for="quote">Favorite Quote</label>
                    <input type="text" id="quote" name="quote" maxlength="200" value="<?php echo $quote; ?>">
                </div>

                <div class="form-input-section">
                    <label for="bio">Bio</label>
                    <textarea id="bio" name="bio" maxlength="500"><?php echo $bio; ?></textarea>
                </div>

                <div class="form-input-section">
                    <label>Phone Number</label>
                    <input type="tel" id="phone" name="phone" value="<?php echo $phone; ?>">
                </div>

                <div class="form-input-section">
                    <label>Email</label>
                    <input type="email" id="email" name="email" value="<?php echo $email; ?>" readonly>
                </div>

                <div class="form-input-section">
                    <label>Location</label>
                    <input type="text" id="location" name="location" value="<?php echo $location; ?>">
                </div>

                <div class="form-input-section">
                    <label>Social Links</label>
                    <input type="url" id="linkedin" name="linkedin" placeholder="LinkedIn URL" value="<?php echo $linkedin; ?>">
                    <input type="url" id="github" name="github" placeholder="GitHub URL" value="<?php echo $github; ?>">
                    <input type="url" id="twitter" name="twitter" placeholder="Twitter URL" value="<?php echo $twitter; ?>">
                    <div id="other-social-links-container">
                        <?php foreach ($other_social_links as $index => $link): ?>
                            <div class="other-social-link">
                                <input type="text" name="other_social_links_name[]" placeholder="Social Platform" value="<?php echo htmlspecialchars($link['name'] ?? ''); ?>">
                                <input type="url" name="other_social_links_url[]" placeholder="URL" value="<?php echo htmlspecialchars($link['url'] ?? ''); ?>">
                                <button type="button" class="remove-link">Remove</button>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <button type="submit" class="btn-save">Save Changes</button>
            </form>
        </section>
    </main>
</div>
<!-- CropperJS JS -->
<script src="https://unpkg.com/cropperjs"></script>

<script>
// Live image preview
document.getElementById('profile-upload').addEventListener('change', function () {
    const file = this.files[0];
    if (file) {
        const preview = document.getElementById('profile-preview');
        preview.src = URL.createObjectURL(file);
    }
});

// Delete profile image
document.addEventListener('click', function(e) {
    if (e.target.id === 'delete-button') {
        fetch(e.target.dataset.url, { method: 'GET' })
            .then(response => response.json())
            .then(data => {
                alert(data.message);
                if (data.success) location.reload();
            })
            .catch(error => alert('Delete failed.'));
    }
});

// Add new social link field
document.getElementById('add-anthr-btn')?.addEventListener('click', function() {
    const container = document.getElementById('other-social-links-container');
    const div = document.createElement('div');
    div.className = 'other-social-link';
    div.innerHTML = `
        <input type="text" name="other_social_links_name[]" placeholder="Social Platform">
        <input type="url" name="other_social_links_url[]" placeholder="URL">
        <button type="button" class="remove-link">Remove</button>
    `;
    container.appendChild(div);
});

// Remove social link
document.addEventListener('click', function(e) {
    if (e.target.classList.contains('remove-link')) {
        e.target.parentElement.remove();
    }
});
</script>
<script>
let cropper;
const cropperModal = document.getElementById('cropper-modal');
const cropperImage = document.getElementById('cropper-image');
const profilePreview = document.getElementById('profile-preview');
const profileUpload = document.getElementById('profile-upload');

profileUpload.addEventListener('change', function (e) {
    const file = e.target.files[0];
    if (!file) return;

    const reader = new FileReader();
    reader.onload = function (event) {
        cropperImage.src = event.target.result;
        cropperModal.style.display = 'flex';

        if (cropper) {
            cropper.destroy();
        }

        cropper = new Cropper(cropperImage, {
            aspectRatio: 1,
            viewMode: 1,
            autoCropArea: 1,
        });
    };
    reader.readAsDataURL(file);
});

document.getElementById('crop-btn').addEventListener('click', function () {
    const canvas = cropper.getCroppedCanvas({
        width: 300,
        height: 300,
    });

    // Show cropped image preview
    profilePreview.src = canvas.toDataURL('image/png');

    // Replace file input with cropped image data
    canvas.toBlob(blob => {
        const croppedFile = new File([blob], "cropped.png", { type: 'image/png' });
        const dataTransfer = new DataTransfer();
        dataTransfer.items.add(croppedFile);
        profileUpload.files = dataTransfer.files;
    });

    closeCropper();
});

function closeCropper() {
    cropperModal.style.display = 'none';
    if (cropper) cropper.destroy();
}
</script>


</body>
</html>
