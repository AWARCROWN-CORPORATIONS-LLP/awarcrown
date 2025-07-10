<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Awarcrown Corporations - Intern Application</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/fuse.js@7.0.0"></script>

    <style>


body {
    font-family: 'Segoe UI', Tahoma, sans-serif;
    background: #f3f2f1;
    margin: 0;
    padding: 0;
    color: #323130;
    line-height: 1.6;
}

/* Header */
header {
    background-color: #ffffff;
    color: #323130;
    text-align: center;
    padding: 18px 0;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    position: fixed;
    top: 0;
    width: 100%;
    z-index: 1000;
    display: flex;
    
    
}

header h1 {
    margin-top:10px;
    font-size: 22px;
    font-weight: 500;
}

/* Container */
.form-container {
    max-width: 740px;
    margin: 100px auto 40px;
    background: #ffffff;
    padding: 40px;
    border-radius: 12px;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
}

/* Headings */
h2 {
    color: #201f1e;
    font-size: 24px;
    font-weight: 600;
    text-align: center;
    margin-bottom: 30px;
}

h3 {
    font-size: 18px;
    color: #605e5c;
    font-weight: 600;
    margin: 24px 0 12px;
    border-left: 4px solid #0078d4;
    padding-left: 12px;
}

/* Labels and Inputs */
label {
    display: block;
    margin-bottom: 6px;
    font-weight: 500;
    color: #323130;
}

input,
select,
textarea {
    width: 100%;
    padding: 14px;
    height: 40px;
    font-size: 15px;
    border: 1px solid #c8c6c4;
    border-radius: 6px;
    background-color: #ffffff;
    color: #323130;
    transition: border 0.2s ease;
}

input:focus,
textarea:focus,
select:focus {
    border-color: #0078d4;
    outline: none;
    box-shadow: 0 0 0 2px rgba(0, 120, 212, 0.2);
}

textarea {
    resize: vertical;
    min-height: 100px;
}

/* File Input */
input[type="file"] {
    padding: 10px;
    font-size: 14px;
}

/* Button */
.submit-btn {
    background-color: #0078d4;
    color: #ffffff;
    padding: 14px;
    border: none;
    border-radius: 6px;
    font-size: 16px;
    font-weight: 600;
    cursor: pointer;
    width: 100%;
    transition: background-color 0.3s ease;
    margin-top: 20px;
}

.submit-btn:hover {
    background-color: #005a9e;
}

.submit-btn:disabled {
    background-color: #a6a6a6;
    cursor: not-allowed;
}

/* Error */
.error {
    border-color: #d13438;
}

.error-message {
    color: #a80000;
    font-size: 13px;
    margin-top: 4px;
    display: none;
}

/* Modal */
.modal {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(0, 0, 0, 0.4);
    z-index: 999;
    animation: fadeIn 0.3s ease-in-out;
}

.modal-content {
    background: #ffffff;
    max-width: 420px;
    margin: 120px auto;
    padding: 30px;
    border-radius: 8px;
    text-align: center;
    box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
    animation: popUp 0.3s ease-out;
}

.modal-btn {
    background-color: #0078d4;
    color: #ffff;
    padding: 10px 24px;
    border: none;
    border-radius: 6px;
    font-weight: 500;
    margin-top: 20px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.modal-btn:hover {
    background-color: #005a9e;
}

/* Submission Status */
#submissionStatus {
    text-align: center;
    font-weight: 500;
    font-size: 16px;
    color: #107c10;
    margin-top: 30px;
    display: none;
}

/* Loading Overlay */
.loading-overlay {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(255, 255, 255, 0.6);
    backdrop-filter: blur(3px);
    z-index: 998;
    text-align: center;
}

.spinner {
    width: 48px;
    height: 48px;
    border: 5px solid #f3f3f3;
    border-top: 5px solid #0078d4;
    border-radius: 50%;
    animation: spin 1s linear infinite;
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
}

.loading-text {
    position: fixed;
    top: calc(50% + 50px);
    left: 50%;
    transform: translateX(-50%);
    color: #0078d4;
    font-size: 16px;
    font-weight: 500;
}
.dropdown {
    position: absolute;
    width: 100%;
    max-width: 600px;
    border: 1px solid #ccc;
    background: white;
    z-index: 1000;
    border-radius: 4px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    display: none;
}

.option {
    padding: 8px 12px;
    cursor: pointer;
}

.option:hover,
.option.highlight {
    background-color: #f0f0f0;
}



/* Animations */
@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

@keyframes popUp {
    from { transform: scale(0.95); opacity: 0; }
    to { transform: scale(1); opacity: 1; }
}

@keyframes spin {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}

/* Responsive */
@media (max-width: 768px) {
    .form-container {
        margin: 90px 20px 30px;
        padding: 25px;
    }

    h2 {
        font-size: 20px;
    }

    input, select, textarea {
        font-size: 14px;
    }

    button {
        font-size: 15px;
    }
}

/* Footer 
footer {
    background: #f3f2f1;
    padding: 20px 0;
    text-align: center;
    font-size: 13px;
    color: #605e5c;
    margin-top: 60px;
}
*/
    </style>
</head>
<body>
    <header>
        <img src="https://cybertron7.in/images/black_logo.png" alt="company_logo" width="50" height="50">
        <h1>Awarcrown Corporations</h1>
    </header>

  <div class="form-container">
    <strong><h2 style="font-size: 22px;">Internship Application – Awarcrown Corporations LLP</h2></strong>
<br>
    <section class="role-description">
        <h3>About Us</h3>
        <p>
            <strong>Awarcrown Corporations LLP</strong> is a technology-driven company focused on building AI-powered platforms and innovative digital solutions. 
            We are currently seeking skilled and motivated <strong>interns</strong> to contribute to our development team across multiple domains.
        </p>

       <Strong> <h4>Open Internship Roles</h4></Strong>
        <ul>
            <li><strong>Android Developer:</strong> UI and app development using Kotlin and Jetpack Compose (including Navigation Compose).</li>
            <li><strong>Backend Developer:</strong> API and server-side development using Kotlin and Spring Boot.</li>
            <li><strong>Full-Stack Developer:</strong> End-to-end development involving both frontend and backend systems.</li>
        </ul>
    </section>

    <section class="tech-stack">
        <h4>Technology Stack</h4></Strong>
        <ul>
            <li><strong>Frontend:</strong> Kotlin – Jetpack Compose, Navigation Compose, XML (optional)</li>
            <li><strong>Backend:</strong> Kotlin, Spring Boot</li>
            <li><strong>Database:</strong> PostgreSQL (Relational), MongoDB (NoSQL), SQLite (Local Storage)</li>
        </ul>
    </section>

    <section class="requirements">
      <strong>  <h4>Eligibility & Requirements</h4></Strong>
        <ul>
            <li>Applicants should be currently pursuing <strong>B.Tech, BCA, MCA</strong>, or an equivalent technical degree.</li>
            <li>Basic knowledge in at least one of the following areas: Kotlin, Jetpack Compose, Spring Boot, or Database Management.</li>
            <li>Strong willingness to learn, collaborate, and contribute to production-grade projects.</li>
        </ul>
    </section>

    <section class="internship-details">
     <strong>   <h4>Internship Details</h4></Strong>
        <ul>
            <li><strong>Duration:</strong> 3 to 6 months</li>
            <li><strong>Time Commitment:</strong> 10–15 hours per week</li>
            <li><strong>Work Mode:</strong> Remote</li>
        </ul>
    </section>

    <section class="perks">
     <strong>   <h4>Benefits</h4></Strong>
        <ul>
            <li>Practical exposure to modern development practices and tech stacks.</li>
            <li>Mentorship from experienced engineers and team leads.</li>
            <li><strong>Certificate of Completion</strong> upon successful internship.</li>
        </ul>
        <p>
            <strong>Note:</strong> This is an <strong>unpaid internship</strong> focused on practical learning and skill enhancement.
        </p>
    </section>
<form id="applicationForm" enctype="multipart/form-data">
    <div class="section">
       <strong> <h3>1. Basic Information</h3></Strong>

        <label>Full Name</label>
        <input type="text" name="name" required>
        <span class="error-message" id="name-error">Please enter a valid name</span>

        <label>Email Address</label>
        <input type="email" name="email" required>
        <span class="error-message" id="email-error">Please enter a valid email</span>

        <label>Phone Number</label>
        <input type="tel" name="phone" required>
        <span class="error-message" id="phone-error">Please enter a valid phone number</span>

        <label>Academic Program</label>
        <select name="program" required>
            <option value="">Select</option>
            <option value="B.Tech">B.Tech</option>
            <option value="BCA">BCA</option>
            <option value="MCA">MCA</option>
            <option value="Other">Other</option>
        </select>
        <span class="error-message" id="program-error">Please make a selection</span>

        <!-- ✅ New Fields Start -->
        <label>College Name</label>
        <input type="text" name="college" id="collegeInput" placeholder="Type your college..." autocomplete="off" />
<div id="collegeDropdown" class="dropdown"></div>
        <span class="error-message" id="college-error">Please enter your college name</span>

        <label>CGPA (up to current semester)</label>
        <input type="number" step="0.01" name="cgpa" min="0" max="10" required>
        <span class="error-message" id="cgpa-error">Please enter a valid CGPA</span>
        <!-- ✅ New Fields End -->
    </div>

    <div class="section">
        <h3>2. Role & Technical Skills</h3>

        <label>Preferred Role</label>
        <select name="role" required>
            <option value="">Select</option>
            <option value="Android Developer">Android Developer (Kotlin + Jetpack Compose)</option>
            <option value="Backend Developer">Backend Developer (Spring Boot + Kotlin)</option>
            <option value="Full-Stack Developer">Full-Stack Developer</option>
        </select>
        <span class="error-message" id="role-error">Please make a selection</span>

        <label>Technical Skills & Tools</label>
        <textarea name="tech_stack" placeholder="E.g., Kotlin, Jetpack Compose, Spring Boot, PostgreSQL, MongoDB, SQLite" required></textarea>
        <span class="error-message" id="tech_stack-error">Please list your technical skills</span>
    </div>

    <div class="section">
        <h3>3. Motivation & Availability</h3>

        <label>Why are you interested in this internship?</label>
        <textarea name="motivation" required></textarea>
        <span class="error-message" id="motivation-error">Please provide your motivation</span>

        <label>Estimated hours you can commit per week</label>
        <input type="number" name="hours" min="1" required>
        <span class="error-message" id="hours-error">Please enter a valid number</span>
    </div>

    <div class="section">
        <h3>4. Resume Upload</h3>

        <label>Upload Resume / CV (PDF format only, max 5MB)</label>
        <input type="file" name="resume" accept=".pdf" id="resumeInput" required>
        <span class="error-message" id="resume-error">Please upload a valid PDF file</span>
    </div>

    <button type="submit" id="submitBtn" class="submit-btn">Submit Application</button>
</form>

<div id="submissionStatus">You have already submitted your application.</div>

<div class="modal" id="responseModal">
    <div class="modal-content">
        <p id="modalMessage"></p>
        <button class="modal-btn" id="modalOk">OK</button>
    </div>
</div>

<div class="loading-overlay" id="loadingOverlay">
    <div class="spinner" id="spinner"></div>
    <div class="loading-text" id="loadingText">Submitting...</div>
</div>
</div>


    <footer class="bg-white text-gray-500 text-center text-sm py-4 border-t">
    Powered by <strong class="text-gray-700">Awarcrown Corporations LLP</strong>
  </footer>

    <div id="cookieConsent" style="
        display: none;
        position: fixed;
        bottom: 0;
        left: 0;
        right: 0;
        background: #2c3e50;
        color: #fff;
        padding: 15px;
        text-align: center;
        z-index: 1500;
        font-size: 14px;
    ">
        We use cookies to enhance your experience. By continuing to visit this site you agree to our use of cookies.
        <button id="acceptCookies" style="margin-left: 15px; padding: 8px 16px; border: none; background: #4285f4; color: white; border-radius: 4px; cursor: pointer;">Got it!</button>
    </div>
<script src="https://cdn.jsdelivr.net/npm/fuse.js@7.0.0"></script>

    <script>
let collegeList = [];
let fuse;

fetch('college.txt')
    .then(response => response.text())
    .then(data => {
        collegeList = data.split('\n').map(name => ({
            name: name.trim().toLowerCase()  // 👈 lowercase all names at the start
        })).filter(obj => obj.name.length > 0);

        fuse = new Fuse(collegeList, {
            keys: ['name'],
            threshold: 0.4, // allow fuzzy matching
            ignoreLocation: true,
            includeScore: true,
            minMatchCharLength: 2
        });
    })
    .catch(error => console.error("Failed to load college list:", error));

const input = document.getElementById('collegeInput');
const dropdown = document.getElementById('collegeDropdown');
let selectedIndex = -1;

input.addEventListener('input', function () {
    const query = this.value.trim().toLowerCase();  // 👈 auto-lowercase input
    dropdown.innerHTML = '';
    selectedIndex = -1;

    if (!query || !fuse || query.length < 2) {
        dropdown.style.display = 'none';
        return;
    }

    const results = fuse.search(query, { limit: 10 });

    if (results.length === 0) {
        dropdown.style.display = 'none';
        return;
    }

    results.forEach(({ item }) => {
        const option = document.createElement('div');
        option.className = 'option';
        option.innerHTML = highlightMatch(item.name, query);
        option.addEventListener('mousedown', () => {
            input.value = capitalize(item.name);
            dropdown.innerHTML = '';
            dropdown.style.display = 'none';
        });
        dropdown.appendChild(option);
    });

    dropdown.style.display = 'block';
});

input.addEventListener('keydown', function (e) {
    const options = dropdown.querySelectorAll('.option');
    if (e.key === 'ArrowDown') {
        e.preventDefault();
        selectedIndex = (selectedIndex + 1) % options.length;
        highlightOption(options);
    } else if (e.key === 'ArrowUp') {
        e.preventDefault();
        selectedIndex = (selectedIndex - 1 + options.length) % options.length;
        highlightOption(options);
    } else if (e.key === 'Enter') {
        if (selectedIndex >= 0 && options[selectedIndex]) {
            input.value = capitalize(options[selectedIndex].textContent);
            dropdown.innerHTML = '';
            dropdown.style.display = 'none';
            e.preventDefault();
        }
    }
});

document.addEventListener('click', (e) => {
    if (!dropdown.contains(e.target) && e.target !== input) {
        dropdown.innerHTML = '';
        dropdown.style.display = 'none';
    }
});

function highlightOption(options) {
    options.forEach((option, i) => {
        option.classList.toggle('highlight', i === selectedIndex);
    });
}

function highlightMatch(text, query) {
    const regex = new RegExp(`(${query})`, 'gi');
    return text.replace(regex, '<strong>$1</strong>');
}

function capitalize(text) {
    return text.replace(/\b\w/g, l => l.toUpperCase());
}

function highlightOption(options) {
    options.forEach((option, i) => {
        option.classList.toggle('highlight', i === selectedIndex);
    });
}

function highlightMatch(text, query) {
    const regex = new RegExp(`(${query})`, 'gi');
    return text.replace(regex, '<strong>$1</strong>');
}

document.addEventListener('click', (e) => {
    if (!dropdown.contains(e.target) && e.target !== input) {
        dropdown.innerHTML = '';
        dropdown.style.display = 'none';
    }
});

function highlightOption(options) {
    options.forEach((option, i) => {
        option.classList.toggle('highlight', i === selectedIndex);
    });
}

function setCookie(name, value, days) {
    const date = new Date();
    date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
    const expires = "expires=" + date.toUTCString();
    document.cookie = name + "=" + value + ";" + expires + ";path=/";
}

function getCookie(name) {
    const cname = name + "=";
    const decodedCookie = decodeURIComponent(document.cookie);
    const ca = decodedCookie.split(';');
    for (let c of ca) {
        c = c.trim();
        if (c.indexOf(cname) === 0) return c.substring(cname.length);
    }
    return "";
}

function sanitizeInput(input) {
    const div = document.createElement('div');
    div.textContent = input;
    return div.innerHTML;
}

function validateName(name) {
    return /^[a-zA-Z\s]{2,}$/.test(name);
}

function validateEmail(email) {
    return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
}

function validatePhone(phone) {
    const digitsOnly = phone.replace(/\D/g, '');
    return /^\+?[\d\s-]{10,20}$/.test(phone) && digitsOnly.length >= 10;
}

function validateText(text) {
    return text.trim().length > 0;
}

function validateNumber(num) {
    return Number(num) > 0 && Number.isInteger(Number(num));
}

function validateSelect(value) {
    return value !== "";
}

function validateCGPA(cgpa) {
    return /^\d+(\.\d{1,2})?$/.test(cgpa) && parseFloat(cgpa) >= 0 && parseFloat(cgpa) <= 10.0;
}

window.addEventListener("load", () => {
    const submitted = getCookie("applicationSubmitted");
    const form = document.getElementById('applicationForm');
    const status = document.getElementById('submissionStatus');
    
    if (submitted === "true") {
        form.style.display = 'none';
        status.style.display = 'block';
    }

    const cookieConsent = document.getElementById("cookieConsent");
    if (cookieConsent && !localStorage.getItem("cookiesAccepted")) {
        cookieConsent.style.display = "block";
        document.getElementById("acceptCookies").onclick = () => {
            localStorage.setItem("cookiesAccepted", "true");
            cookieConsent.style.display = "none";
        };
    }
});

const inputs = {
    name: document.querySelector('input[name="name"]'),
    email: document.querySelector('input[name="email"]'),
    phone: document.querySelector('input[name="phone"]'),
    program: document.querySelector('select[name="program"]'),
    role: document.querySelector('select[name="role"]'),
    tech_stack: document.querySelector('textarea[name="tech_stack"]'),
    motivation: document.querySelector('textarea[name="motivation"]'),
    hours: document.querySelector('input[name="hours"]'),
    college: document.querySelector('input[name="college"]'),
    cgpa: document.querySelector('input[name="cgpa"]')
};

Object.entries(inputs).forEach(([key, input]) => {
    input.addEventListener('input', function () {
        const errorSpan = document.getElementById(`${key}-error`);
        let isValid = true;
        let value = sanitizeInput(this.value);

        switch (key) {
            case 'name': isValid = validateName(value); break;
            case 'email': isValid = validateEmail(value); break;
            case 'phone': isValid = validatePhone(value); break;
            case 'program':
            case 'role': isValid = validateSelect(value); break;
            case 'tech_stack':
            case 'motivation':
            case 'college': isValid = validateText(value); break;
            case 'hours': isValid = validateNumber(value); break;
            case 'cgpa': isValid = validateCGPA(value); break;
        }

        if (!isValid && value) {
            this.classList.add('error');
            this.classList.remove('input-error-animate');
            void this.offsetWidth;
            this.classList.add('input-error-animate');
            errorSpan.style.display = 'block';
        } else {
            this.classList.remove('error', 'input-error-animate');
            errorSpan.style.display = 'none';
        }
    });
});

let isSubmissionSuccessful = false;

document.getElementById('applicationForm').addEventListener('submit', async function (e) {
    e.preventDefault();

    const form = this;
    const formData = new FormData(form);
    const submitBtn = document.getElementById('submitBtn');
    const loadingOverlay = document.getElementById('loadingOverlay');
    const spinner = document.getElementById('spinner');
    const loadingText = document.getElementById('loadingText');
    const modal = document.getElementById('responseModal');
    const modalMessage = document.getElementById('modalMessage');
    const status = document.getElementById('submissionStatus');

    const validations = [
        { field: 'name', value: sanitizeInput(inputs.name.value), validator: validateName },
        { field: 'email', value: sanitizeInput(inputs.email.value), validator: validateEmail },
        { field: 'phone', value: sanitizeInput(inputs.phone.value), validator: validatePhone },
        { field: 'program', value: inputs.program.value, validator: validateSelect },
        { field: 'role', value: inputs.role.value, validator: validateSelect },
        { field: 'tech_stack', value: sanitizeInput(inputs.tech_stack.value), validator: validateText },
        { field: 'motivation', value: sanitizeInput(inputs.motivation.value), validator: validateText },
        { field: 'hours', value: inputs.hours.value, validator: validateNumber },
        { field: 'college', value: sanitizeInput(inputs.college.value), validator: validateText },
        { field: 'cgpa', value: inputs.cgpa.value, validator: validateCGPA }
    ];

    let hasError = false;
    for (const { field, value, validator } of validations) {
        if (!validator(value)) {
            modalMessage.textContent = 'Please correct the highlighted errors before submitting.';
            modal.style.display = 'block';
            inputs[field].classList.add('error', 'input-error-animate');
            document.getElementById(`${field}-error`).style.display = 'block';
            hasError = true;
        }
    }

    if (hasError) return;

    const resumeInput = document.getElementById('resumeInput');
    if (resumeInput.files.length === 0 || resumeInput.files[0].type !== 'application/pdf' || resumeInput.files[0].size > 5 * 1024 * 1024) {
        modalMessage.textContent = 'Resume must be a valid PDF under 5MB.';
        modal.style.display = 'block';
        resumeInput.classList.add('error', 'input-error-animate');
        document.getElementById('resume-error').style.display = 'block';
        return;
    }

    submitBtn.disabled = true;
    submitBtn.textContent = 'Submitting...';
    loadingOverlay.style.display = 'block';
    spinner.style.display = 'block';
    loadingText.style.display = 'block';

    try {
        const response = await fetch('awc20250850_submission.awc', {
            method: 'POST',
            body: formData
        });

        if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);

        const data = await response.json();
        modalMessage.textContent = data.success
            ? 'Your application has been submitted. Click OK to join the WhatsApp group.'
            : 'Error: ' + data.message;
        modal.style.display = 'block';

        if (data.success) {
            isSubmissionSuccessful = true;
            setCookie("applicationSubmitted", "true", 30);
            form.reset();
            form.style.display = 'none';
            status.style.display = 'block';
        }
    } catch (error) {
        modalMessage.textContent = 'Submission failed. Please try again later.';
        modal.style.display = 'block';
        console.error('Submission error:', error);
    } finally {
        submitBtn.disabled = false;
        submitBtn.textContent = 'Submit Application';
        loadingOverlay.style.display = 'none';
        spinner.style.display = 'none';
        loadingText.style.display = 'none';
    }
});

document.getElementById('modalOk').addEventListener('click', function () {
    document.getElementById('responseModal').style.display = 'none';
    if (isSubmissionSuccessful) {
        window.location.href = 'https://chat.whatsapp.com/K4aL8P7sXTUB17kuMkjOLG';
    }
});

    </script>
</body>
</html>