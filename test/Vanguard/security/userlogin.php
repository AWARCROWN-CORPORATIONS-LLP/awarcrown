<?php

if (!defined('ACCESS_GRANTED')) {
    //header("HTTP/1.1 403 Forbidden");
header("Location: https://cybertron7.in/test/Vanguard/security/unauthorisedaccess.awc");
exit();
    
}

$captchaVerified = false; 
$loginMessage = ''; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
   
    if (!isset($_POST['g-recaptcha-response']) || empty($_POST['g-recaptcha-response'])) {
        $loginMessage = "Error: Missing or empty reCAPTCHA response.";
    } else {
        $recaptcha_token = $_POST['g-recaptcha-response'];
        $secret_key = '6LfHCqAqAAAAACDtW7Fs17NP9aytzRKiUanvuh0z';

        
        $url = 'https://www.google.com/recaptcha/api/siteverify';
        $data = [
            'secret' => $secret_key,
            'response' => $recaptcha_token,
            'remoteip' => $_SERVER['REMOTE_ADDR'], 
        ];

        // Use cURL for HTTP request
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            $error_msg = curl_error($ch);
            curl_close($ch);
            $loginMessage = "Error: Unable to connect to reCAPTCHA API. cURL error: $error_msg";
        } else {
            curl_close($ch);
            $result = json_decode($response, true);

            if ($result && $result['success']) {
                $captchaVerified = true;
                $loginMessage = "CAPTCHA verified successfully. Proceed with login.";
            } else {
                $error_reason = isset($result['error-codes']) ? implode(', ', $result['error-codes']) : "Unknown reason";
                $loginMessage = "CAPTCHA verification failed. Reason: $error_reason";
            }
        }
    }
}
?>

<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register||Login</title>
    <link rel="stylesheet" href="userlogin.css">
    <link rel="icon" href="images/black_logo.png">
        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
        <script src="userlogin.js" defer></script>
       

        

    <style>
        .error { 
            color: red;
            font-size:20px;
        
            margin:10px;
            
        }
        .success { color: green; }
          #footer {
            position: absolute;
            bottom: 20px;
            right: 20px;
            font-size: 18px;
            color: #8e8789;
            background: transprent;
            padding: 5px 10px;
            border-radius: 5px;
            animation: slideIn 0.5s ease-out 0.4s;
            animation-fill-mode: backwards;
            z-index: 1111111;
         
            font-weight:800;
        }
    </style>
</head>
<script src="userlogin.js" defer></script>

<body>
   
 <!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register||Login</title>
    <link rel="stylesheet" href="userlogin.css">
    <link rel="icon" href="https://cybertron7.in/images/black_logo.png" />
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>

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
    <div class="login-page">
        <div class="company-container">
            <div class="image-container">
                <img src="https://cybertron7.in/images/black_logo.png" alt="Company Logo">
            </div>
            <h1 class="cybertron7-name">Awarcrown Corporations</h1>
        </div>

        <div class="form-container" id="form-container">
            <div class="button-container">
                <div id="buttons"></div>
                <button type="button" class="toggle-btn" onclick="login()" id="loginbutton" >Login</button>
                <button type="button" class="toggle-btn" onclick="register()" id="registerbutton" >Register</button>
            </div>

            <div id="login-form" class="input-details">
                <form action="login.awc" method="POST" onsubmit="handleSubmit(event)">

                    <div class="input-box">
                        <input type="text" id="login-username" name="username" required>
                        <label for="login-username">Enter your username</label>
                    </div>
                    <div class="input-box">
                        <input type="password" id="login-password" name="password" required>
                        <label for="login-password">Enter your password</label>
                    </div>
                    <label class="rememberme"><input type="checkbox" name="remember"> Remember Me</label>

                    <div class="g-recaptcha" data-sitekey="6LfHCqAqAAAAAFTwwL9sekqUYUEqBRi-80JwSpUD" data-callback="onCaptchaVerified" required></div>
                    
                    <input type="submit" value="Login" class="form-submit" id="userlogin-submit" disabled>
                    <a href="forget_password.php?access=true">Forget Password?</a>
                </form>
            </div>

            <!-- Register Form -->
            <div id="register-form" class="input-details">
                <form action="register.awc" method="post" onsubmit="handleSubmit(event)">
                    <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>">

                    <div class="input-box">
                        <input type="text" id="register-username" name="username" required>
                        <label for="register-username">Enter your username</label>
                    </div>
                    <div class="input-box">
                        <input type="password" id="register-password" name="password" required>
                        <label for="register-password">Enter your password</label>
                    </div>
                    <div class="input-box">
                        <input type="password" id="confirm-password" name="conformpassword" required>
                        <label for="confirm-password">Confirm your password</label>
                    </div>
                    <div class="input-box">
                        <input type="text" id="name" name="name" required>
                        <label for="name">Enter your name</label>
                    </div>
                    <div class="input-box">
                        <input type="email" id="email" name="email" required>
                        <label for="email">Enter your Email</label>
                    </div>
                    <div class="g-recaptcha" data-sitekey="6LfHCqAqAAAAAFTwwL9sekqUYUEqBRi-80JwSpUD" data-callback="onCaptchaVerified" required></div>
               
                    <input type="submit" value="Register" class="form-submit" id="userregister-submit" disabled>
                </form>
            </div>
        </div>
    </div>
    <div id="footer"><b>Powered by<br>Awarcrown Corporations</b></div>

</body>


</html>













