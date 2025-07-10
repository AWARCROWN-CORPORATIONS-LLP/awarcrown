<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


session_start();
define('INCLUDE_FLAG', true);
require 'config.php';

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: https://cybertron7.in/test/Vanguard/security/register.awc");
    exit();
}

// Process POST request
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_SESSION['username'];

    // Check the database connection
    if ($conn->connect_error) {
        error_log("Database connection failed: " . $conn->connect_error); // Log the error
        header("Location: https://cybertron7.in/test/Vanguard/security/dbconnectionerror.awc");
        exit();
    }

    // Prepare and execute the SQL query
    $stmt = $conn->prepare("UPDATE users SET policy = 1 WHERE username = ?");
    if ($stmt) {
        $stmt->bind_param("s", $username);
        if ($stmt->execute()) {
            
            
            header("Location: https://cybertron7.in/test/form-1/zone.awc");
            exit();
        } else {
             header("Location: https://cybertron7.in/test/Vanguard/security/dbconnectionerror.awc");
            error_log("SQL execution failed: " . $stmt->error); // Log SQL error
        }
        $stmt->close();
    } else {
        header("Location: https://cybertron7.in/test/Vanguard/security/dbconnectionerror.awc");
        error_log("SQL statement preparation failed: " . $conn->error);
        
    }

    // Close the database connection
    $conn->close();

    // Redirect to an error page if something goes wrong
    header("Location: https://cybertron7.in/test/Vanguard/security/dbconnectionerror.awc");
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="policy.css">
   

</head>


<body>
    <div class="policy">
  <h2><b>Terms of Use</b></h2>

<p>Welcome to the Awarcrown Corporations Internship Portal. These Terms of Use govern your access to and use of our online internship platform, including all content, functionality, and services provided on or through the Platform, designed to connect students and professionals with internship opportunities at Awarcrown Corporations and its partner organizations.</p>

<b>By accessing or using our Platform, you agree to be bound by these Terms. If you do not agree with these Terms, please do not use the Platform.</b>
<br>
<b>1. Acceptance of Terms</b>
<br>
<p>By accessing or using the Platform, you agree to comply with and be bound by these Terms, as well as our Privacy Policy, which is incorporated by reference. You must be at least 16 years of age to use the Platform and apply for internships. If you are using the Platform on behalf of an organization or educational institution, you represent that you have the authority to bind that organization to these Terms.</p>

<b>2. Modification of Terms</b>
<br>
<p>We reserve the right, at our sole discretion, to modify or update these Terms at any time. Any changes will become effective immediately upon posting the updated Terms on the Platform. It is your responsibility to review the Terms periodically for any changes. Continued use of the Platform following the posting of revised Terms constitutes your acceptance of those changes.</p>

<b>3. User Accounts</b>
<br>
<p>To access certain features of the Platform, such as applying for internships, tracking application status, or accessing exclusive resources, you must create an account.</p>
<b>You agree to:</b>
<ul>
    <li>Provide accurate, current, and complete information, including your resume, academic details, and other relevant qualifications, when creating an account or submitting an application.</li>
    <li>Maintain and promptly update your account information to ensure its accuracy, especially during the internship application process.</li>
    <li>Protect the confidentiality and security of your account credentials.</li>
    <li>Assume full responsibility for any activity that occurs under your account, including internship applications submitted through your profile.</li>
</ul>
<p><b>We reserve the right to terminate or suspend your account, without notice, for any reason, including but not limited to submission of false information, violation of these Terms, or inappropriate conduct during the internship application process.</b></p>

<b>4. Use of the Platform</b>
<br>
<p>You agree to use the Platform in a manner consistent with all applicable laws and regulations. The Platform is intended solely for personal, non-commercial use related to exploring and applying for internship opportunities.</p>
<b>You agree that you will not:</b>
<ul>
    <li>Use the Platform in any way that infringes on the rights of others, including submitting fraudulent applications or misrepresenting qualifications.</li>
    <li>Upload, post, or transmit any material that contains viruses, malware, or any other harmful code.</li>
    <li>Engage in any conduct that could disrupt, damage, or impair the Platform's functionality or the internship application process.</li>
    <li>Attempt to reverse-engineer, decompile, or disassemble any part of the Platform's code or functionality.</li>
    <li>Share your account credentials with others or permit unauthorized access to your account.</li>
    <li>Use the Platform to solicit or contact employers outside the intended internship application process.</li>
</ul>

<b>5. Internship Program Guidelines</b>
<br>
<p>The Awarcrown Corporations Internship Portal facilitates applications for internships offered by Awarcrown Corporations and its partner organizations. By using the Platform, you agree to the following:</p>
<ul>
    <li><b>Eligibility:</b> Internship opportunities may have specific eligibility criteria, such as academic qualifications, skills, or enrollment in an educational institution. You are responsible for ensuring you meet these criteria before applying.</li>
    <li><b>Application Process:</b> All applications must be submitted through the Platform. Incomplete or inaccurate applications may be rejected without notice.</li>
    <li><b>Conduct:</b> You agree to maintain professionalism during the application process, including in communications with Awarcrown Corporations or its partners.</li>
    <li><b>Selection:</b> Internship selections are at the sole discretion of Awarcrown Corporations or its partners. Submission of an application does not guarantee an internship offer.</li>
    <li><b>Confidentiality:</b> If selected for an internship, you may be required to sign a separate confidentiality agreement or other employment-related agreements.</li>
</ul>

<b>6. Content and Intellectual Property</b>
<br>
<p>All content available on the Platform, including but not limited to text, images, graphics, videos, internship listings, application forms, and resources, is the exclusive property of Awarcrown Corporations or its content providers and is protected by intellectual property laws. Unauthorized use, copying, distribution, modification, or creation of derivative works from any content on the Platform is strictly prohibited without our express written permission.</p>

<b>7. Payments and Subscriptions</b>
<br>
<p>Access to the Platform is currently free for internship applicants. Certain premium features, such as priority application processing or access to exclusive resources, may be offered for a fee in the future. By purchasing any paid services, you agree to pay the applicable fees. All payments are final and non-refundable, except as required by law or as otherwise stated in these Terms. Awarcrown Corporations reserves the right to introduce or change fees for any services at any time.</p>

<b>8. Privacy and Data Security</b>
<br>
<p>Your privacy is important to us. We collect, use, and protect your personal information, including resume details and application data, in accordance with our Privacy Policy. By using the Platform, you consent to the collection and use of your information as outlined in the Privacy Policy, including the transfer of this information to other countries for storage, processing, and use by Awarcrown Corporations.</p>

<b>9. Data Collection and Use</b>
<br>
<p>We may collect various types of information from you, including but not limited to personal data (e.g., name, contact details, academic records), usage data, and information collected through cookies or other tracking technologies. This data is used to manage internship applications, improve the Platform, provide a personalized experience, and communicate with you regarding your account or internship opportunities.</p>

<b>10. Data Security</b>
<br>
<p>We implement appropriate technical and organizational measures to protect your data against unauthorized access, loss, alteration, or destruction. However, no security system is infallible, and we cannot guarantee the absolute security of your data.</p>

<b>11. Data Sharing</b>
<br>
<p>We do not sell or rent your personal data to third parties. We may share your information with trusted partners, such as employers or educational institutions, who assist us in operating the Platform, processing internship applications, or servicing you, provided those parties agree to keep this information confidential.</p>

<b>12. Third-Party Links and Services</b>
<br>
<p>The Platform may contain links to third-party websites or services, such as employer websites or external job boards, that are not owned or controlled by Awarcrown Corporations. We are not responsible for the content, privacy policies, or practices of any third-party websites or services. You access these third-party websites or services at your own risk, and we encourage you to review the terms and policies of any third-party websites you visit.</p>

<b>13. Termination</b>
<br>
<p>We reserve the right to terminate or suspend your access to the Platform, without notice or liability, for any reason, including but not limited to your breach of these Terms or misuse of the internship application process. Upon termination, your right to access the Platform will immediately cease. Any provisions of these Terms that by their nature should survive termination shall continue to remain in effect, including but not limited to intellectual property rights, disclaimers, limitations of liability, and indemnification.</p>

<b>14. Limitation of Liability</b>
<br>
<p>To the fullest extent permitted by law, Awarcrown Corporations, its affiliates, and their respective officers, directors, employees, and agents shall not be liable for any direct, indirect, incidental, special, consequential, or punitive damages arising out of or related to your use of the Platform or participation in the internship program, even if Awarcrown Corporations has been advised of the possibility of such damages.</p>

<b>15. Indemnification</b>
<br>
<p>You agree to indemnify, defend, and hold harmless Awarcrown Corporations, its affiliates, and their respective officers, directors, employees, and agents from and against any and all claims, liabilities, damages, losses, costs, expenses, or fees (including reasonable attorneys' fees) arising from your use of the Platform, submission of false information, or your violation of these Terms.</p>

<b>16. Governing Law</b>
<br>
<p>These Terms and any disputes arising out of or related to these Terms or the use of the Platform shall be governed by and construed in accordance with the laws of India, without regard to its conflict of law principles.</p>

<b>17. Contact Information</b>
<br>
<p>If you have any questions or concerns regarding these Terms, our Privacy Policy, or the internship program, please contact us at:</p>

<b>Awarcrown Corporations</b><br>
<a href="mailto:awarcrowncorporations@gmail.com">awarcrowncorporations@gmail.com</a>
<br>
<input type="checkbox" name="Acceptance" onclick="toggleSubmit()" id="policy"> By clicking this, you are agreeing to the terms and conditions of Awarcrown Corporations.
<br>
<form method="post" action="policy.awc" >
        <p>Please read and accept our terms and conditions.</p>
        <input type="submit" value="I Accept" id="submit" disabled>
    </form>
</div>


    
</body>
<script>
   function toggleSubmit() {
    const checkbox = document.getElementById('policy');
            const submitButton = document.getElementById('submit');

            
            if (checkbox.checked) {
                submitButton.disabled = false;
                
                
            } else {
               
                submitButton.disabled = true;
                
              
            }
        }

   

       
</script>

</html>