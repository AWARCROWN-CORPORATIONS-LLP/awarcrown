<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Awarcrown Corporations - Core Team Application</title>
    <style>
       /* Global Styles */
body {
    font-family: 'Segoe UI', Roboto, Tahoma, sans-serif;
    background: #f9fbfd;
    margin: 0;
    padding: 0;
    min-height: 100vh;
    color: #2c3e50;
    line-height: 1.6;
}

/* Header */
header {
    background-color: #ffffff;
    color: #2c3e50;
    text-align: center;
    padding: 18px 0;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.06);
    position: fixed;
    top: 0;
    width: 100%;
    z-index: 1000;
    transition: all 0.3s ease-in-out;
}

header h1 {
    margin: 0;
    font-size: 24px;
    font-weight: 600;
    margin-top:5px;
}

/* Form Container */
.form-container {
    max-width: 720px;
    margin: 100px auto 40px;
    background: #fff;
    padding: 40px 30px;
    border-radius: 14px;
    box-shadow: 0 6px 30px rgba(0, 0, 0, 0.06);
    transition: all 0.3s ease-in-out;
}

/* Headings */
h2 {
    color: #1e2d3b;
    font-weight: 600;
    font-size: 24px;
    text-align: center;
    margin-bottom: 30px;
}

h3 {
    color: #34495e;
    font-size: 18px;
    font-weight: 600;
    margin-bottom: 16px;
    border-left: 4px solid #4285f4;
    padding-left: 10px;
}

/* Form Elements */
label {
    display: block;
    margin: 12px 0 6px;
    font-weight: 500;
}

input,
select,
textarea {
    width: 100%;
    padding: 14px 16px;
    font-size: 15px;
    border: 1px solid #d0d7de;
    border-radius: 8px;
    background: #fff;
    transition: all 0.3s ease;
}

input:focus,
textarea:focus,
select:focus {
    border-color: #4285f4;
    outline: none;
    box-shadow: 0 0 0 3px rgba(66, 133, 244, 0.1);
}

textarea {
    resize: vertical;
    min-height: 120px;
}

input[type="file"] {
    padding: 10px;
}

/* Button */
button {
    background-color: #4285f4;
    color: #fff;
    padding: 14px;
    border: none;
    border-radius: 8px;
    font-size: 16px;
    font-weight: 600;
    cursor: pointer;
    width: 100%;
    transition: background-color 0.3s ease;
}

button:hover {
    background-color: #3367d6;
}

button:disabled {
    background-color: #b0c4de;
    cursor: not-allowed;
}

/* Error Styles */
.error {
    border-color: #e74c3c;
}

.error-message {
    color: #e74c3c;
    font-size: 13px;
    margin-top: -8px;
    margin-bottom: 10px;
    display: none;
}

.modal {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(0, 0, 0, 0.45);
    z-index: 1100;
    animation: fadeIn 0.3s ease-in-out;
}

.modal-content {
    background: #fff;
    max-width: 450px;
    margin: 120px auto;
    padding: 30px;
    border-radius: 10px;
    text-align: center;
    box-shadow: 0 6px 24px rgba(0, 0, 0, 0.15);
    animation: popUp 0.3s ease-out;
}

.modal-btn {
    background-color: #4285f4;
    color: #fff;
    padding: 10px 24px;
    border: none;
    border-radius: 6px;
    font-weight: 500;
    margin-top: 20px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.modal-btn:hover {
    background-color: #3367d6;
}

.loading-overlay {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(255, 255, 255, 0.6);
    backdrop-filter: blur(4px);
    z-index: 1090;
    text-align: center;
}

.spinner {
    width: 50px;
    height: 50px;
    border: 6px solid #f3f3f3;
    border-top: 6px solid #4285f4;
    border-radius: 50%;
    animation: spin 1s linear infinite;
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    z-index: 1091;
}

.loading-text {
    position: fixed;
    top: calc(50% + 50px);
    left: 50%;
    transform: translateX(-50%);
    color: #4285f4;
    font-size: 17px;
    font-weight: 500;
    z-index: 1091;
    margin-top:10px;
    margin-left:35px;
}

#submissionStatus {
    text-align: center;
    font-weight: 500;
    font-size: 16px;
    color: #2e7d32;
    margin-top: 30px;
    display: none;
}

@keyframes spin {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}

@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

@keyframes popUp {
    from { transform: scale(0.95); opacity: 0; }
    to { transform: scale(1); opacity: 1; }
}

@media (max-width: 768px) {
    header h1 {
        font-size: 20px;
        margin-top:5px;
    }

    .form-container {
        margin: 90px 0px 30px;
        padding: 20px 20px;
    }

    h2 {
        font-size: 20px;
    }

    input,
    select,
    textarea {
        font-size: 14px;
        padding: 12px;
    }

    button {
        font-size: 15px;
        padding: 12px;
    }

    .modal-content {
        width: 90%;
        margin-top: 100px;
    }
}

@keyframes shake {
    0% { transform: translateX(0); }
    20% { transform: translateX(-6px); }
    40% { transform: translateX(6px); }
    60% { transform: translateX(-6px); }
    80% { transform: translateX(6px); }
    100% { transform: translateX(0); }
}

.input-error-animate {
    animation: shake 0.4s ease-in-out;
}
    </style>
</head>
<body>
    <header style="display:flex;">
        <img src="https://cybertron7.in/images/black_logo.png" alt="company_logo" width=50px height=50px>
        <h1 style="font-weight:500">Awarcrown Corporations</h1>
    </header>
 
    <div class="form-container">
        <h2>Core Team Application Form</h2>
  
        <section class="role-description">
            <h3>Join Awarcrown Corporations LLP – Build the Future with Us!</h3>
            <p>
                <strong>Awarcrown Corporations LLP</strong> is a forward-thinking tech startup pioneering AI-driven solutions 
                for automation and operational efficiency. We’re assembling a passionate 
                <strong>core team</strong> to shape the future of software and strategy and 
                <b><em>we want you to be a part of it</em>.</b> 
            </p>
            <h4>👩‍💻 Your Role:</h4>
            <ul>
                <li>Develop and code innovative software modules for intelligent systems.</li>
                <li>Conduct market research to identify emerging tech trends and business opportunities.</li>
                <li>Collaborate with the team to integrate insights into impactful AI-driven solutions.</li>
            </ul>
        </section>

        <section class="requirements">
            <h4>🎯 What We’re Looking For:</h4>
            <ul>
                <li>Pursuing or completed <strong>B.Tech / MCA</strong> (or equivalent).</li>
                <li>Proficient in at least <strong>one programming language</strong> (for software roles) and interested in <strong>market research</strong>.</li>
                <li>Proactive mindset, analytical thinking, and a drive to contribute meaningfully to a growing startup.</li>
            </ul>
        </section>

        <section class="internship-details">
            <h4>📅 Internship Details:</h4>
            <ul>
                <li><strong>Duration:</strong> 6 months</li>
                <li><strong>Commitment:</strong> 15 hours/week</li>
                <li><strong>Mode:</strong> Fully remote</li>
            </ul>
        </section>

        <section class="perks">
            <h4>🎉 Perks & Takeaways:</h4>
            <ul>
                <li>Be part of our <strong>founding core team</strong> with direct mentorship from partners.</li>
                <li>Gain real-world experience in <strong>software development and market analysis</strong>.</li>
                <li>Receive a <strong>completion certificate</strong> to strengthen your professional portfolio.</li>
            </ul>
            <p>
                <strong>Note:</strong> This is an <strong>unpaid internship</strong>, focused on learning, collaboration, and building impactful experience.
            </p>
        </section>

        <form id="applicationForm" enctype="multipart/form-data">
            <div class="section">
                <h3>1. Basic Info</h3>
                <label>Name</label>
                <input type="text" name="name" required>
                <span class="error-message" id="name-error">Please enter a valid name</span>
                <label>Email</label>
                <input type="email" name="email" required>
                <span class="error-message" id="email-error">Please enter a valid email</span>
                <label>Phone</label>
                <input type="tel" name="phone" required>
                <span class="error-message" id="phone-error">Please enter a valid phone number</span>
                <label>GitHub / Portfolio (optional)</label>
                <input type="url" name="portfolio">
                <span class="error-message" id="portfolio-error">Please enter a valid URL</span>
            </div>

            <div class="section">
                <h3>2. Skills & Experience</h3>
                <label>Main Coding Languages / Tech Stack</label>
                <textarea name="tech_stack" required></textarea>
                <span class="error-message" id="tech_stack-error">Please enter your tech stack</span>
                <label>Have you built a project from scratch before?</label>
                <select name="project_from_scratch" required>
                    <option value="">Select</option>
                    <option value="Yes">Yes</option>
                    <option value="No">No</option>
                </select>
                <span class="error-message" id="project_from_scratch-error">Please make a selection</span>
                <label>Years of experience in coding</label>
                <select name="experience" required>
                    <option value="">Select</option>
                    <option value="0-1">0–1</option>
                    <option value="1-2">1–2</option>
                    <option value="2-4">2–4</option>
                    <option value="5+">5+</option>
                </select>
                <span class="error-message" id="experience-error">Please make a selection</span>
            </div>

            <div class="section">
                <h3>3. Adaptability & Ownership</h3>
                <label>Are you open to working on a new project from A to Z?</label>
                <select name="new_project" required>
                    <option value="">Select</option>
                    <option value="Yes">Yes</option>
                    <option value="No">No</option>
                </select>
                <span class="error-message" id="new_project-error">Please make a selection</span>
                <label>Can you take ownership of tasks independently?</label>
                <select name="ownership" required>
                    <option value="">Select</option>
                    <option value="Yes">Yes</option>
                    <option value="No">No</option>
                    <option value="Somewhat">Somewhat</option>
                </select>
                <span class="error-message" id="ownership-error">Please make a selection</span>
                <label>How do you handle changes or feedback during a project?</label>
                <textarea name="feedback" required></textarea>
                <span class="error-message" id="feedback-error">Please provide a response</span>
            </div>

            <div class="section">
                <h3>4. Availability</h3>
                <label>How many hours per week can you dedicate?</label>
                <input type="number" name="hours" min="1" required>
                <span class="error-message" id="hours-error">Please enter a number greater than 0</span>
                <label>Are you available for team discussions in our working hours?</label>
                <select name="discussion" required>
                    <option value="">Select</option>
                    <option value="Yes">Yes</option>
                    <option value="No">No</option>
                </select>
                <span class="error-message" id="discussion-error">Please make a selection</span>
            </div>

            <div class="section">
                <h3>5. Optional</h3>
                <label>Why do you want to join this core team?</label>
                <textarea name="reason"></textarea>
                <label>Upload Resume / CV (PDF only)</label>
                <input type="file" name="resume" accept=".pdf" id="resumeInput" required>
            </div>

            <button type="submit" id="submitBtn">Submit Application</button>
        </form>
        <div id="submissionStatus">You have already submitted your application.</div>
    </div>

    <div class="modal" id="responseModal">
        <div class="modal-content">
            <p id="modalMessage"></p>
            <button class="modal-btn" id="modalOk">OK</button>
        </div>
    </div>

    <div class="loading-overlay" id="loadingOverlay">
        <div class="spinner" id="spinner" style="display: none;"></div>
        <div class="loading-text" id="loadingText" style="display: none;">Submitting...</div>
    </div>
    <footer style="background: #f8f9fa; padding: 20px 0; text-align: center; font-size: 14px; color: #666; margin-top: 60px;">
        <p>© <span id="year"></span> Awarcrown Corporations. All rights reserved.</p>
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

    <script>
        // Cookie handling
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
            for(let i = 0; i < ca.length; i++) {
                let c = ca[i];
                while (c.charAt(0) == ' ') {
                    c = c.substring(1);
                }
                if (c.indexOf(cname) == 0) {
                    return c.substring(cname.length, c.length);
                }
            }
            return "";
        }

        // Validation functions
        function validateName(name) {
            return /^[a-zA-Z\s]{2,}$/.test(name);
        }

        function validateEmail(email) {
            return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
        }

        function validatePhone(phone) {
            const digitsOnly = phone.replace(/\D/g, ''); // Remove non-digit characters
            return /^\+?[\d\s-]{10,20}$/.test(phone) && digitsOnly.length >= 10;
        }

        function validateUrl(url) {
            if (!url) return true;
            return /^(https?:\/\/)?([\w-]+\.)+[\w-]+(\/[\w- .\/?%&=]*)?$/.test(url);
        }

        function validateText(text) {
            return text.trim().length > 0;
        }

        function validateNumber(num) {
            return num > 0;
        }

        function validateSelect(value) {
            return value !== "";
        }

        // Check submission status on page load
        window.onload = function() {
            const submitted = getCookie("applicationSubmitted");
            const form = document.getElementById('applicationForm');
            const status = document.getElementById('submissionStatus');
            if (submitted === "true") {
                form.style.display = 'none';
                status.style.display = 'block';
            }
            document.getElementById("year").textContent = new Date().getFullYear();
        };

        // Cookie Consent
        window.addEventListener("load", () => {
            if (!localStorage.getItem("cookiesAccepted")) {
                document.getElementById("cookieConsent").style.display = "block";
            }

            document.getElementById("acceptCookies").onclick = () => {
                localStorage.setItem("cookiesAccepted", "true");
                document.getElementById("cookieConsent").style.display = "none";
            };
        });

        // Real-time validation
        const inputs = {
            name: document.querySelector('input[name="name"]'),
            email: document.querySelector('input[name="email"]'),
            phone: document.querySelector('input[name="phone"]'),
            portfolio: document.querySelector('input[name="portfolio"]'),
            tech_stack: document.querySelector('textarea[name="tech_stack"]'),
            project_from_scratch: document.querySelector('select[name="project_from_scratch"]'),
            experience: document.querySelector('select[name="experience"]'),
            new_project: document.querySelector('select[name="new_project"]'),
            ownership: document.querySelector('select[name="ownership"]'),
            feedback: document.querySelector('textarea[name="feedback"]'),
            hours: document.querySelector('input[name="hours"]'),
            discussion: document.querySelector('select[name="discussion"]')
        };

        Object.entries(inputs).forEach(([key, input]) => {
            input.addEventListener('input', function() {
                const errorSpan = document.getElementById(`${key}-error`);
                let isValid = true;

                switch(key) {
                    case 'name':
                        isValid = validateName(this.value);
                        break;
                    case 'email':
                        isValid = validateEmail(this.value);
                        break;
                    case 'phone':
                        isValid = validatePhone(this.value);
                        break;
                    case 'portfolio':
                        isValid = validateUrl(this.value);
                        break;
                    case 'tech_stack':
                    case 'feedback':
                        isValid = validateText(this.value);
                        break;
                    case 'hours':
                        isValid = validateNumber(this.value);
                        break;
                    case 'project_from_scratch':
                    case 'experience':
                    case 'new_project':
                    case 'ownership':
                    case 'discussion':
                        isValid = validateSelect(this.value);
                        break;
                }

                if (!isValid && this.value) {
                    this.classList.add('error');
                    errorSpan.style.display = 'block';
                } else {
                    this.classList.remove('error');
                    errorSpan.style.display = 'none';
                }
            });
        });

        // Track successful submission
        let isSubmissionSuccessful = false;

        // Form submission
        document.getElementById('applicationForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const form = this;
            const formData = new FormData(form);
            const submitBtn = document.getElementById('submitBtn');
            const loadingOverlay = document.getElementById('loadingOverlay');
            const spinner = document.getElementById('spinner');
            const loadingText = document.getElementById('loadingText');
            const modal = document.getElementById('responseModal');
            const modalMessage = document.getElementById('modalMessage');
            const body = document.body;
            const status = document.getElementById('submissionStatus');

            // Validate all required fields
            const validations = [
                { field: 'name', value: inputs.name.value, validator: validateName },
                { field: 'email', value: inputs.email.value, validator: validateEmail },
                { field: 'phone', value: inputs.phone.value, validator: validatePhone },
                { field: 'portfolio', value: inputs.portfolio.value, validator: validateUrl },
                { field: 'tech_stack', value: inputs.tech_stack.value, validator: validateText },
                { field: 'project_from_scratch', value: inputs.project_from_scratch.value, validator: validateSelect },
                { field: 'experience', value: inputs.experience.value, validator: validateSelect },
                { field: 'new_project', value: inputs.new_project.value, validator: validateSelect },
                { field: 'ownership', value: inputs.ownership.value, validator: validateSelect },
                { field: 'feedback', value: inputs.feedback.value, validator: validateText },
                { field: 'hours', value: inputs.hours.value, validator: validateNumber },
                { field: 'discussion', value: inputs.discussion.value, validator: validateSelect }
            ];

            for (const { field, value, validator } of validations) {
                if (!validator(value)) {
                    modalMessage.textContent = 'Please fix the errors in the form.';
                    modal.style.display = 'block';
                    return;
                }
            }

            // File validation
            const resumeInput = document.getElementById('resumeInput');
            if (resumeInput.files.length > 0) {
                const file = resumeInput.files[0];
                if (file.type !== 'application/pdf') {
                    modalMessage.textContent = 'Please upload a PDF file only.';
                    modal.style.display = 'block';
                    return;
                }
                if (file.size > 5 * 1024 * 1024) {
                    modalMessage.textContent = 'File size must be less than 5MB.';
                    modal.style.display = 'block';
                    return;
                }
            }

            // Show loading state with spinner and text
            submitBtn.disabled = true;
            submitBtn.textContent = 'Submitting...';
            loadingOverlay.style.display = 'block';
            spinner.style.display = 'block';
            loadingText.style.display = 'block';
            body.classList.add('blur');

            fetch('submit_core_team.awc', {
                method: 'POST',
                body: formData
            })
            .then(response => {
                if (!response.ok) throw new Error('Network response was not ok');
                return response.json();
            })
            .then(data => {
                modalMessage.textContent = data.success 
                    ? 'Application submitted successfully! You\'ll be redirected to our WhatsApp group after clicking OK.' 
                    : 'Error: ' + data.message;
                modal.style.display = 'block';
                if (data.success) {
                    isSubmissionSuccessful = true; // Set flag for successful submission
                    setCookie("applicationSubmitted", "true", 30); 
                    form.style.display = 'none';
                    status.style.display = 'block';
                    form.reset();
                } else {
                    isSubmissionSuccessful = false; // Ensure flag is false on failure
                }
            })
            .catch(error => {
                modalMessage.textContent = 'Submission failed. Please try again.';
                modal.style.display = 'block';
                isSubmissionSuccessful = false; // Ensure flag is false on error
                console.error('Error:', error);
            })
            .finally(() => {
                submitBtn.disabled = false;
                submitBtn.textContent = 'Submit Application';
                loadingOverlay.style.display = 'none';
                spinner.style.display = 'none';
                loadingText.style.display = 'none';
                body.classList.remove('blur');
            });
        });

        // Modal OK button handler with redirect
        document.getElementById('modalOk').addEventListener('click', function() {
            document.getElementById('responseModal').style.display = 'none';
            if (isSubmissionSuccessful) {
                // Redirect to WhatsApp group link
                window.location.href = 'https://chat.whatsapp.com/K4aL8P7sXTUB17kuMkjOLG'; // Replace with actual WhatsApp group link
            }
        });
    </script>
</body>
</html>