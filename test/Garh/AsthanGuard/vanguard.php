
<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin||Cybertron7</title>
    <link rel="stylesheet" href="adminconsoleloginstylesheet.css">
    <style>
        .error { 
            color: red;
            font-size:20px;
        
            margin:10px;
            
        }
        .success { color: green; }
    </style>
</head>

<body>
    <!-- Display error or success messages -->
   <div id="message">
        <?php
        if (isset($_GET['error'])) {
            $error = $_GET['error'];
            if ($error == 'password_mismatch') {
                echo "<p class='error'>Error: Password and confirm password do not match.</p>";
            } elseif ($error == 'weak_password') {
                echo "<p class='error'>Error:Password must be at least 8 characters long, include at least one capital letter, one special character, and one number.</p>";
            } elseif ($error == 'username_taken') {
                echo "<p class='error'>Error: Username already taken.</p>";
            } elseif ($error == 'invalid_email') {
                echo "<p class='error'>Error: Please enter a valid email address.</p>";
            } elseif ($error == 'database_error') {
                echo "<p class='error'>Error: There was a problem with the database.</p>";
            }
             elseif($error == 'email_taken'){
                echo "<p class='error'>Error: Email already taken.</p>";
            }
            elseif ($error=='invalid_login'){
                echo "<p class='error'>Error: Invalid login credentials.</p>";
            }
        } elseif (isset($_GET['success']) && $_GET['success'] == 'registration') {
            echo "<p class='success'>New record created successfully!</p>";
        }
        ?>
    

    <div class="login-page">
        <div class="company-container">
            <div class="image-container">
                <img src="adminloginpageimages/black_logo.png" alt="Company Logo">
            </div>
            <h1 class="cybertron7-name">Cybertron7</h1>
        </div>

        <div class="form-container" id="form-container">
            <div class="button-container">
                <div id="buttons"></div>
                <button type="button" class="toggle-btn" onclick="login()" id="loginbutton">Admin-Login</button>
            </div>

            <!-- Login Form -->
            <div id="login-form" class="input-details">
                <form action="adminloginconformation.awc" method="post">
                    <div class="input-box">
                        <input type="text" id="login-username" name="username" required>
                        <label for="login-username">Enter your username</label>
                    </div>
                    <div class="input-box">
                        <input type="password" id="login-password" name="password" required>
                        <label for="login-password">Enter your password</label>
                        <img src="passwordvisibilityon.png" alt="Toggle visibility" class="visibility-icon" id="visibility-icon">
                    </div>
                    <input type="submit" value="Login" class="form-submit" id="userlogin-submit">
                 
                 
                   
                </form>
            </div>

           
<script src="adminconsoleloginjs.js"></script>
</body>
</html>
