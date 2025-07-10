<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>403</title>
    <link rel="stylesheet" href="error-page.css">
    <meta name="robots" content="noindex, nofollow">

</head>
<style>
 
body {
    font-family: Arial, sans-serif;
    background-color: white;
    text-align: center;
    margin: 0;
    padding: 0;
    display: flex;
    flex-direction: column;
    min-height: 100vh;
}


header {
    background-color: rgb(31, 31, 90);
    color: #fff;
    padding: 5px;
    font-family: serif;
}

.header-content {
    display: flex;
}


.logo {
    width: 80px;
    height: 80px;
    margin-right:5px;
}
@media (max-width: 768px) {
    .logo{
        width : 60px;
        height : 60px;
    }
    .header-content{
        padding : 10px 0px;
        align-items : center;
    }
}

.cmp-name {
    font-size: 28px;
    font-weight: bold;
    color: #d0dfe7;
    padding: 0px;
    margin-right:20px;
}


.error-container {
    max-width: 600px;
    margin: 5px auto;
}


.logo-error {
    width: 200px;
    margin-bottom: 20px;
    margin-top:120px;
}


.error-code {
    font-size: 30px;
    color: #dc3545;
}

.error-message {
    font-size: 14px;
    color: #6c757d;
}


.error-description {
    font-size: 18px;
    color: #6c757d;
    margin-top: 10px;
    margin-bottom:0px;
}


a {
    color: #007bff;
    text-decoration: none;
}

/* Footer styles */
footer {
    margin-top: auto; /* Ensures the footer is pushed to the bottom */
    background-color: rgb(31, 31, 90);
    color: #d0dfe7;
    padding: 37px;
    text-align: center;
}

/* Footer paragraph margin */
footer p {
    margin-top: -10px;
}

/* Footer link styling */
footer a {
    color: #007bff;
    text-decoration: none;
}

/* Hover effect for footer links */
footer a:hover {
    text-decoration: underline;
}

/* Footer social links container */
.footer-social a {
    margin: 0 10px;
}

/* Footer social icon styling */
.footer-social img {
    width: 30px;
    height: 30px;
}

/* Footer bottom section */
.footer-bottom {
    margin-top: 20px;
}

/* Footer bottom paragraph styling */
.footer-bottom p {
    margin: 0;
    font-size: 14px;
}
</style>
<body>
    <header>
        <div class="header-content">
            <img src="https://cybertron7.in/images/Screenshot__146_-removebg-preview.png" alt="Cybertron7 logo" class="logo">
            <h1 class="cmp-name">Awarcrown Corporations</h1>
        </div>
    </header>
    <div class="error-container">
        <img src="https://cdn.vectorstock.com/i/500p/16/00/warning-sign-no-cell-phone-not-allowed-calls-vector-50841600.jpg
        " alt="loading" class="logo-error">
        <div class="error-msg-img-container">
            <div class="error-code">Vanguard-Access Restricted on Small Screens</div>
        </div>
        <div class="error-message"> 
        
           <br><b>For security and performance reasons, this page is only accessible on devices with larger screens.
Kindly switch to a laptop or desktop for the best experience.</b></a>.
           
        </div>
       
       Report this error to our developer's team <a href="mailto:support@cybertron7.in">contact support</a>.

    </div>

    <footer>
        
        <p>&copy; 2025 Awarcrown Corporations LLP. All rights reserved.</p>
        <div class="footer-social">
            <a href="https://www.instagram.com/cybertron7.in/" target="_blank"><img src="https://cybertron7.in/images/instagram.svg" alt="Instagram"></a>
            <a href="https://chat.whatsapp.com/JTHXEzPfPad2oLl94D87WD" target="_blank"><img src="https://cybertron7.in/images/whatsapp.svg" alt="Whatsapp"></a>
            <a href="https://www.linkedin.com/company/cybertron7/" target="_blank"><img src="https://cybertron7.in/images/linkedin.svg" alt="LinkedIn"></a>
        </div>
        <!-- <p>Contact us<a href="mailto: support@cybertron7.in" target="_blank">cybertron7.in</a></p> -->
    </footer>
</body>
<script>
    function checkDevice() {
    const isMobile = window.innerWidth > 1024;

    if (isMobile) {
        // Redirect to the error page
        window.location.href = 'https://cybertron7.in/test/Vanguard/security/register.awc';
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
</html>