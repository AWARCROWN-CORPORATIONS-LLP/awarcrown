<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Intern Document Submission - Awarcrown Corporations</title>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <style>
    /* General Reset */
    * {
      box-sizing: border-box;
    }

    body {
      font-family: 'Roboto', Arial, sans-serif;
      background-color: #e8f0fe;
      margin: 0;
      padding: 20px;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      position: relative;
      background-repeat: repeat;
    }

    /* Watermark */
    body::before {
      content: '';
      position: fixed;
      top: 0; left: 0;
      width: 100%; height: 100%;
      background-image: url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' width='200' height='200' opacity='0.15'><text x='10' y='100' font-size='20' fill='%231565c0' transform='rotate(-45 100 100)'>Awarcrown Corporations</text></svg>");
      background-repeat: repeat;
      z-index: 0;
      pointer-events: none;
    }

    /* Loader overlay */
    #loading-overlay {
      position: fixed;
      top: 0; left: 0;
      width: 100vw;
      height: 100vh;
      backdrop-filter: blur(6px);
      background: rgba(255, 255, 255, 0.6);
      z-index: 9999;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    #loading-spinner {
      border: 6px solid #bbdefb;
      border-top: 6px solid #1565c0;
      border-radius: 50%;
      width: 60px;
      height: 60px;
      animation: spin 1s linear infinite;
    }

    @keyframes spin {
      0% { transform: rotate(0deg); }
      100% { transform: rotate(360deg); }
    }

    .container {
      background: rgba(255, 255, 255, 0.9);
      backdrop-filter: blur(5px);
      padding: 30px;
      border-radius: 16px;
      box-shadow: 0 8px 32px rgba(0, 0, 0, 0.15);
      width: 100%;
      max-width: 720px;
      z-index: 1;
    }

    h1 {
      text-align: center;
      color: #0d47a1;
      font-size: 2.2em;
      margin-bottom: 25px;
    }

    .form-group {
      margin-bottom: 18px;
    }

    label {
      display: block;
      margin-bottom: 6px;
      font-weight: 600;
      color: #333;
    }

    input[type="text"],
    input[type="email"],
    input[type="tel"],
    input[type="file"] {
      width: 100%;
      padding: 12px;
      border: 1px solid #bbdefb;
      border-radius: 10px;
      font-size: 1em;
      transition: border-color 0.3s, box-shadow 0.3s;
    }

    input:focus {
      outline: none;
      border-color: #1565c0;
      box-shadow: 0 0 8px rgba(21, 101, 192, 0.3);
    }

    input[type="file"] {
      padding: 5px;
    }

    .error {
      color: #d32f2f;
      font-size: 0.85em;
      margin-top: 4px;
      display: none;
    }

    .success, .error-message {
      text-align: center;
      padding: 12px;
      border-radius: 8px;
      margin-bottom: 20px;
      display: none;
    }

    .success {
      background-color: #e6fffa;
      color: #00695c;
    }

    .error-message {
      background-color: #ffebee;
      color: #b71c1c;
    }

    button {
      background-color: #1565c0;
      color: white;
      padding: 14px;
      border: none;
      border-radius: 10px;
      width: 100%;
      font-size: 1.1em;
      font-weight: bold;
      transition: background-color 0.3s, transform 0.2s;
    }

    button:hover {
      background-color: #0d47a1;
      transform: translateY(-2px);
    }

    button:disabled {
      background-color: #90caf9;
      cursor: not-allowed;
    }

    footer {
      text-align: center;
      margin-top: 40px;
      font-size: 0.9em;
      color: #666;
      z-index: 1;
    }

    footer a {
      color: #1565c0;
      text-decoration: none;
    }

    footer a:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>

  <!-- Loader Overlay -->
  <div id="loading-overlay">
    <div id="loading-spinner"></div>
  </div>

  <!-- Form Container -->
  <div class="container">
    <h1>Intern Document Submission(Batch 2)</h1>
    <div class="success" id="success">Form submitted successfully!</div>
    <div class="error-message" id="error">An error occurred. Please try again.</div>

    <form id="internForm" enctype="multipart/form-data">
        <div class="form-group">
    <label for="applicant_id">Application ID</label>
    <input type="text" id="applicant_id" name="applicant_id" required readonly />
    <span class="error" id="applicantiderror">Please enter a valid ID.</span>
  </div>
      <div class="form-group">
        <label for="fullName">Full Name</label>
        <input type="text" id="fullName" name="fullName" required />
        <span class="error" id="fullNameError">Please enter a valid name.</span>
      </div>

      <div class="form-group">
        <label for="email">Email Address</label>
        <input type="email" id="email" name="email" required />
        <span class="error" id="emailError">Please enter a valid email.</span>
      </div>

      <div class="form-group">
        <label for="phone">Phone Number</label>
        <input type="tel" id="phone" name="phone" required />
        <span class="error" id="phoneError">Please enter a valid phone number.</span>
      </div>

      <div class="form-group">
        <label for="address">Current Address</label>
        <input type="text" id="address" name="address" required />
        <span class="error" id="addressError">Please enter a valid address.</span>
      </div>

      <div class="form-group">
        <label for="emergencyContact">Emergency/Secondary Contact Name</label>
        <input type="text" id="emergencyContact" name="emergencyContact" required />
        <span class="error" id="emergencyContactError">Please enter a valid name.</span>
      </div>

      <div class="form-group">
        <label for="relationship">Relationship with Secondary Contact</label>
        <input type="text" id="relationship" name="relationship" required />
        <span class="error" id="relationshipError">Please enter a valid relationship.</span>
      </div>

      <div class="form-group">
        <label for="secondaryPhone">Secondary Contact Number</label>
        <input type="tel" id="secondaryPhone" name="secondaryPhone" required />
        <span class="error" id="secondaryPhoneError">Please enter a valid phone number.</span>
      </div>

      <div class="form-group">
        <label for="aadhar">Aadhar Card (PDF/JPG/PNG, Max 5MB)</label>
        <input type="file" id="aadhar" name="aadhar" accept=".pdf,.jpg,.jpeg,.png" required />
        <span class="error" id="aadharError">Upload a valid file (Max 5MB).</span>
      </div>

      <div class="form-group">
        <label for="resume">Updated Resume (PDF, Max 5MB)</label>
        <input type="file" id="resume" name="resume" accept=".pdf" required />
        <span class="error" id="resumeError">Upload a valid PDF (Max 5MB).</span>
      </div>

      <button type="submit" id="submitBtn">Submit</button>
    </form>
  </div>
<div id="customModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; 
    background:rgba(0,0,0,0.5); z-index:9999; justify-content:center; align-items:center;">
  <div style="background:#fff; padding:20px; border-radius:8px; max-width:400px; text-align:center;">
    <p id="modalMessage" style="margin-bottom:20px;"></p>
    <button onclick="closeModal()" style="padding:8px 16px;">OK</button>
  </div>
</div>
  <!-- Footer -->
  <footer>
    &copy; 2025 Awarcrown Corporations. All rights reserved.<br>
    For assistance, email <a href="mailto:awarcrowncorporations@gmail.com">awarcrowncorporations@gmail.com</a>
  </footer>


   



    <script>
    function showModal(message) {
    document.getElementById('modalMessage').textContent = message;
    document.getElementById('customModal').style.display = 'flex';
}

function closeModal() {
    document.getElementById('customModal').style.display = 'none';
}
  window.addEventListener('load', () => {
    document.getElementById('loading-overlay').style.display = 'none';
});

// Check jQuery
if (typeof jQuery === 'undefined') {
    alert('jQuery failed to load. Please check your internet connection.');
}

// Cookie utilities
function getCookie(name) {
    let matches = document.cookie.match(new RegExp("(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"));
    return matches ? decodeURIComponent(matches[1]) : undefined;
}

function setCookie(name, value, days) {
    let expires = "";
    if (days) {
        let date = new Date();
        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
        expires = "; expires=" + date.toUTCString();
    }
    document.cookie = name + "=" + (value || "") + expires + "; path=/";
}

if (getCookie('formSubmitted') === 'true') {
    $('#internForm').hide();
    $('#success').show().text('You have already submitted the form.');
}

$('#internForm').on('submit', function (e) {
    e.preventDefault();
    let isValid = true;

    $('.error').hide();
    $('#success, #error').hide();
   const applicant_id = $('#applicant_id').val();
if (!/^[a-zA-Z0-9]+$/.test(applicant_id) || applicant_id.length < 15) {
  $('#applicantiderror').show();
  isValid = false;
}


    // Validate fields
    const fullName = $('#fullName').val();
    if (!/^[a-zA-Z\s]+$/.test(fullName) || fullName.length < 2) {
        $('#fullNameError').show();
        isValid = false;
    }

    const email = $('#email').val();
    if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
        $('#emailError').show();
        isValid = false;
    }

    const phone = $('#phone').val();
    const secondaryPhone = $('#secondaryPhone').val();
    if (!/^\d{10}$/.test(phone)) {
        $('#phoneError').show();
        isValid = false;
    }
    if (!/^\d{10}$/.test(secondaryPhone)) {
        $('#secondaryPhoneError').show();
        isValid = false;
    }

    const address = $('#address').val();
    if (address.length < 5) {
        $('#addressError').show();
        isValid = false;
    }

    const emergencyContact = $('#emergencyContact').val();
    if (!/^[a-zA-Z\s]+$/.test(emergencyContact) || emergencyContact.length < 2) {
        $('#emergencyContactError').show();
        isValid = false;
    }

    const relationship = $('#relationship').val();
    if (!/^[a-zA-Z\s]+$/.test(relationship) || relationship.length < 2) {
        $('#relationshipError').show();
        isValid = false;
    }

    const aadhar = $('#aadhar')[0].files[0];
    if (!aadhar || !['application/pdf', 'image/jpeg', 'image/png'].includes(aadhar.type) || aadhar.size > 5 * 1024 * 1024) {
        $('#aadharError').show();
        isValid = false;
    }

    const resume = $('#resume')[0].files[0];
    if (!resume || resume.type !== 'application/pdf' || resume.size > 5 * 1024 * 1024) {
        $('#resumeError').show();
        isValid = false;
    }

    if (isValid) {
        // UI Loading
        $('#submitBtn').prop('disabled', true).text('Submitting...');
        $('#loader').show();

        let formData = new FormData(this);

        $.ajax({
            url: 'submit.awc',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function (response) {
                $('#loader').hide();
                $('#submitBtn').prop('disabled', false).text('Submit');

                if (response.success) {
                    $('#internForm').hide();
                    $('#success').show().text(response.success);
                    setCookie('formSubmitted', 'true', 30);
                } else {
                    showModal(response.error || 'Unknown error occurred.');
                }
            },
            error: function (xhr, status, error) {
                $('#loader').hide();
                $('#submitBtn').prop('disabled', false).text('Submit');
                let msg = "Failed to submit the form. Please check your connection.";
                if (xhr.status) {
                    msg += ` [${xhr.status}] ${xhr.statusText}`;
                }
                showModal(msg);
            }
        });
    }
});
    function generateApplicationId(batchNumber) {
      const prefix = "AWC";
      const year = new Date().getFullYear();
      const batchCode = String(4 + (batchNumber - 1) * 4).padStart(2, '0');
      const uniqueNumber = Math.floor(Math.random() * 1000000).toString().padStart(6, '0');

      return `${prefix}${year}${batchCode}${uniqueNumber}`;
    }

    // Auto-generate Application ID for batch 2
    const appIdInput = document.getElementById("applicant_id");
    appIdInput.value = generateApplicationId(2);

    </script>
</body>
</html>