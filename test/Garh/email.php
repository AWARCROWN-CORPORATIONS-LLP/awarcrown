


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Sending System - Awarcrown Corporations</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: #f4f7fa;
            color: #333;
        }

        .container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #1a73e8;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
            font-weight: 600;
            margin-bottom: 5px;
            color: #444;
        }

        input[type="text"],
        input[type="email"],
        textarea,
        input[type="file"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
        }

        textarea {
            resize: vertical;
            min-height: 150px;
        }

        button {
            padding: 10px 20px;
            background-color: #1a73e8;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #1557b0;
        }

        .toggle-section {
            cursor: pointer;
            color: #1a73e8;
            margin-bottom: 10px;
            font-weight: 600;
        }

        .hidden {
            display: none;
        }

        .email-preview {
            margin-top: 20px;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
            background: #f9f9f9;
        }

        .email-preview h3 {
            margin-bottom: 10px;
        }

        .email-list {
            margin-top: 30px;
        }

        .email-item {
            padding: 15px;
            border-bottom: 1px solid #eee;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .email-item button {
            margin-left: 10px;
            padding: 5px 10px;
            font-size: 14px;
        }

        .error {
            color: #d32f2f;
            font-size: 14px;
            margin-top: 5px;
        }

        .success {
            color: #388e3c;
            font-size: 14px;
            margin-top: 5px;
        }

        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 12px;
            color: #777;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Email Sending System - Awarcrown Corporations</h1>
        <form id="emailForm" enctype="multipart/form-data">
            <div class="form-group">
                <label for="to">To</label>
                <input type="email" id="to" name="to" required multiple>
            </div>
            <div class="toggle-section" onclick="toggleSection('ccSection')">Add CC</div>
            <div id="ccSection" class="hidden form-group">
                <label for="cc">CC</label>
                <input type="email" id="cc" name="cc" multiple>
            </div>
            <div class="toggle-section" onclick="toggleSection('bccSection')">Add BCC</div>
            <div id="bccSection" class="hidden form-group">
                <label for="bcc">BCC</label>
                <input type="email" id="bcc" name="bcc" multiple>
            </div>
            <div class="form-group">
                <label for="subject">Subject</label>
                <input type="text" id="subject" name="subject" required>
            </div>
            <div class="form-group">
                <label for="header">Custom Header (Optional)</label>
                <input type="text" id="header" name="header" placeholder="e.g., X-Priority: 1">
            </div>
            <div class="form-group">
                <label for="body">Body</label>
                <textarea id="body" name="body" required></textarea>
            </div>
            <div class="form-group">
                <label for="attachments">Attachments</label>
                <input type="file" id="attachments" name="attachments[]" multiple>
            </div>
            <button type="button" onclick="previewEmail()">Preview Email</button>
            <button type="button" onclick="saveDraft()">Save Draft</button>
            <button type="submit">Send Email</button>
        </form>
        <div id="preview" class="email-preview hidden"></div>
        <div id="message"></div>
        <div class="email-list" id="emailList"></div>
        <div class="footer">Powered by Awarcrown Corporations</div>
    </div>

    <script>
        function toggleSection(sectionId) {
            const section = document.getElementById(sectionId);
            section.classList.toggle('hidden');
        }

        function previewEmail() {
            const to = document.getElementById('to').value;
            const cc = document.getElementById('cc').value;
            const bcc = document.getElementById('bcc').value;
            const subject = document.getElementById('subject').value;
            const body = document.getElementById('body').value;
            const header = document.getElementById('header').value;

            const preview = `
                <h3>Email Preview</h3>
                <p><strong>From:</strong> awarcrowncorporations@gmail.com</p>
                <p><strong>To:</strong> ${to}</p>
                ${cc ? `<p><strong>CC:</strong> ${cc}</p>` : ''}
                ${bcc ? `<p><strong>BCC:</strong> ${bcc}</p>` : ''}
                <p><strong>Subject:</strong> ${subject}</p>
                ${header ? `<p><strong>Custom Header:</strong> ${header}</p>` : ''}
                <p><strong>Body:</strong></p>
                <p>${body.replace(/\n/g, '<br>')}</p>
                <p><strong>Footer:</strong> Powered by Awarcrown Corporations</p>
            `;
            const previewDiv = document.getElementById('preview');
            previewDiv.innerHTML = preview;
            previewDiv.classList.remove('hidden');
        }

        async function saveDraft() {
            const formData = new FormData(document.getElementById('emailForm'));
            formData.append('action', 'save_draft');
            try {
                const response = await fetch('email_handler.php', {
                    method: 'POST',
                    body: formData
                });
                const result = await response.json();
                showMessage(result.message, result.success ? 'success' : 'error');
                if (result.success) loadEmails();
            } catch (error) {
                showMessage('Error saving draft', 'error');
            }
        }

        async function sendEmail(event) {
            event.preventDefault();
            const formData = new FormData(document.getElementById('emailForm'));
            formData.append('action', 'send_email');
            try {
                const response = await fetch('email_handler.php', {
                    method: 'POST',
                    body: formData
                });
                const result = await response.json();
                showMessage(result.message, result.success ? 'success' : 'error');
                if (result.success) {
                    document.getElementById('emailForm').reset();
                    loadEmails();
                }
            } catch (error) {
                showMessage('Error sending email', 'error');
            }
        }

        async function loadEmails() {
            try {
                const response = await fetch('email_handler.php?action=get_emails');
                const emails = await response.json();
                const emailList = document.getElementById('emailList');
                emailList.innerHTML = '<h3>Sent and Draft Emails</h3>';
                emails.forEach(email => {
                    emailList.innerHTML += `
                        <div class="email-item">
                            <div>
                                <strong>To:</strong> ${email.to}<br>
                                <strong>Subject:</strong> ${email.subject}<br>
                                <strong>Status:</strong> ${email.status}
                            </div>
                            <div>
                                <button onclick="editEmail(${email.id})">Edit</button>
                                <button onclick="deleteEmail(${email.id})">Delete</button>
                            </div>
                        </div>
                    `;
                });
            } catch (error) {
                showMessage('Error loading emails', 'error');
            }
        }

        async function editEmail(id) {
            try {
                const response = await fetch(`email_handler.php?action=get_email&id=${id}`);
                const email = await response.json();
                document.getElementById('to').value = email.to;
                document.getElementById('cc').value = email.cc || '';
                document.getElementById('bcc').value = email.bcc || '';
                document.getElementById('subject').value = email.subject;
                document.getElementById('header').value = email.header || '';
                document.getElementById('body').value = email.body;
                showMessage('Email loaded for editing', 'success');
            } catch (error) {
                showMessage('Error loading email', 'error');
            }
        }

        async function deleteEmail(id) {
            if (confirm('Are you sure you want to delete this email?')) {
                try {
                    const response = await fetch(`email_handler.php?action=delete_email&id=${id}`);
                    const result = await response.json();
                    showMessage(result.message, result.success ? 'success' : 'error');
                    if (result.success) loadEmails();
                } catch (error) {
                    showMessage('Error deleting email', 'error');
                }
            }
        }

        function showMessage(message, type) {
            const messageDiv = document.getElementById('message');
            messageDiv.innerHTML = `<div class="${type}">${message}</div>`;
            setTimeout(() => messageDiv.innerHTML = '', 3000);
        }

        document.getElementById('emailForm').addEventListener('submit', sendEmail);
        window.onload = loadEmails;
    </script>
</body>
</html>
