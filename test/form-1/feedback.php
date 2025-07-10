<?php 

if (!isset($_SESSION['username']) || empty($_SESSION['username'])) {
    echo "<script>
        alert('Vanguard Session Verification Failed. Login to continue.');
        window.location.href = 'https://cybertron7.in/test/Vanguard/security/register.awc';
    </script>";
    exit;
}

$username = $_SESSION['username'];
$email = $_SESSION['email'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback Form</title>
    
    <style>
        .success-box {
            background: #d4edda;
            color: #155724;
            padding: 20px;
            border-radius: 8px;
            border: 1px solid #c3e6cb;
            margin-top: 20px;
            display: none;
        }
        .error-box {
            background: #f8d7da;
            color: #721c24;
            padding: 20px;
            border-radius: 8px;
            border: 1px solid #f5c6cb;
            margin-top: 20px;
            display: none;
        }
       .loading-overlay {
       
        width: 100%;
        height: 100%;
        background-color: rgba(255, 255, 255, 0.8);
        display: none;
        justify-content: center;
        align-items: center;
        z-index: 1000;
    }

    .google-spinner {
    width: 50px;
    height: 50px;
    border: 5px solid rgba(0, 0, 255, 0.3);
    border-top-color: blue;
    border-radius: 50%;
    animation: spin 1s linear infinite;

    /* Centering Fix */
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
}


    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
    </style>
</head>
<body>
    <div class="container">
        <h1><b>Awarcrown Team</b></h1>
        <h2>Feedback/Report</h2>
        <form id="feedbackForm" method="POST">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>
            
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" readonly>
            
            <label for="feedbackType">Feedback Type:</label>
            <select id="feedbackType" name="feedbackType" required>
                <option value="general">General Feedback</option>
                <option value="bug">Report a Bug</option>
            </select>

            <label for="message">Message:</label>
            <textarea id="message" name="message" rows="4" required></textarea>
            
            <button type="submit">Submit</button>
             <div class="loading-overlay" id="loadingOverlay">
        <div class="loading-spinner"></div>
    </div>
        </form>
        <div id="responseMessage">
            <div id="successMessage" class="success-box"></div>
            <div id="errorMessage" class="error-box"></div>
        </div>
    </div>
     

    <script>
        function showLoading() {
            document.getElementById('loadingOverlay').style.display = 'flex';
        }
        window.addEventListener('load',function(){
            document.getElementById('loadingOverlay').style.display='none';
        })
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
      $(document).ready(function() {
    $('#feedbackForm').on('submit', function(e) {
        e.preventDefault();

        // Hide previous messages
        $('#successMessage, #errorMessage').hide();
        
        // Show loading spinner
        $('#loadingOverlay').fadeIn();

        $.ajax({
            url: 'feedbacksave.awc',
            type: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                $('#loadingOverlay').fadeOut(); // Hide loading spinner

                try {
                    if (!response) {
                        throw new Error("Empty response from server.");
                    }

                    const res = typeof response === "string" ? JSON.parse(response) : response;

                    if (res.success) {
                       $('#successMessage').html(`
    <div style="position: relative; padding: 15px; border: 1px solid #28a745; background: #d4edda; color: #155724; border-radius: 5px;">
        <button id="closeSuccessMessage" style="position: absolute; top: 5px; right: 10px; background: none; border: none; font-size: 18px; cursor: pointer;">&times;</button>
        <h2>Feedback Submitted Successfully!</h2>
        <p>Your Ticket ID: <strong>${res.ticketID}</strong></p>
        <p>${res.message}</p>
    </div>
`).fadeIn();

// Reset the form
$('#feedbackForm')[0].reset();

// Close button functionality
$('#closeSuccessMessage').click(function () {
    $('#successMessage').fadeOut();
});

                    } else {
                        console.error("Server Error Response:", res.message);
                        $('#errorMessage').html(`
                            <h2>Error</h2>
                            <p>${res.message}</p>
                        `).fadeIn();
                    }
                } catch (error) {
                    console.error("JSON Parse Error:", error);
                    console.error("Raw Server Response:", response);
                    $('#errorMessage').html(`
                        <h2>Error</h2>
                        <p>Unexpected response from server.</p>
                        <p>Check console for details.</p>
                    `).fadeIn();
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                $('#loadingOverlay').fadeOut(); // Hide loading spinner on failure
                console.error("AJAX Error:", textStatus, errorThrown);
                console.error("Server Response:", jqXHR.responseText);

                $('#errorMessage').html(`
                    <h2>Error</h2>
                    <p>AJAX Error: ${textStatus} - ${errorThrown}</p>
                    <p>Server Response: ${jqXHR.responseText}</p>
                `).fadeIn();
            }
        });
    });
});

    </script>
</body>
</html>