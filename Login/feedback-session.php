<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback Form</title>
    <link rel="icon" href="https://cybertron7.in/images/black_logo.png" />
    <link rel="stylesheet" href="feedback.css">
      <script src="feedback.js" defer></script>
</head>
<style>
    .loading-screen {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.8);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
        }
        .loading-screen img {
            width: 200px; /* Adjust the size as needed */
            height: 200px; /* Adjust the size as needed */
        }
</style>
<body>
     <div class="loading-screen" id="loading-screen">
        <img src="https://cybertron7.in/images/newload.gif" alt="Loading" width="150px" height="150px">
    </div>
    <div class="container">
        <h1>Awarcrown Corporations</h1>
        <h2>Feedback Form</h2>
        <form id="feedbackForm" action="feedbacksave.awc" method="POST">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>
            
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
            
            <label for="feedbackType">Feedback Type:</label>
            <select id="feedbackType" name="feedbackType" required>
                <option value="general">General Feedback</option>
                <option value="bug">Report a Bug</option>
            </select>

            <label for="message">Message:</label>
            <textarea id="message" name="message" rows="4" required></textarea>
            
            <button type="submit">Submit</button>
            <button type="button" onclick="window.location.href='https://www.cybertron7.in';">Back</button>
        </form>
        <div id="responseMessage"></div>
    </div>
  
</body>
<script>
    
document.addEventListener("DOMContentLoaded", function() {
    const loadingScreen = document.getElementById("loading-screen");

    // Hide loading screen after page loads
    window.onload = function() {
        loadingScreen.style.display = "none";
    };

    // Show loading screen when form is submitted
    document.getElementById("feedbackForm").addEventListener("submit", function(event) {
        loadingScreen.style.display = "flex";
    });
});

</script>
</html>
