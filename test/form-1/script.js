$(document).ready(function() {
    class ModalManager {
        constructor() {
            this.modal = this.createModal();
        }

        createModal() {
            const modal = document.createElement('div');
            modal.className = 'custom-modal hidden';
            modal.innerHTML = `
                <div class="modal-content">
                    <h3 class="modal-title"></h3>
                    <p class="modal-message"></p>
                    <button class="modal-close">Close</button>
                </div>
            `;
            modal.querySelector('.modal-close').addEventListener('click', () => this.hide());
            document.body.appendChild(modal);
            return modal;
        }

        show(title, message) {
            this.modal.querySelector('.modal-title').textContent = title;
            this.modal.querySelector('.modal-message').textContent = message;
            this.modal.classList.remove('hidden');
        }

        hide() {
            this.modal.classList.add('hidden');
        }
    }

    class FormManager {
        constructor() {
            this.form = document.getElementById('internship-form');
            this.steps = [...document.querySelectorAll('.form-step')];
            this.progress = document.querySelector('.progress');
            this.currentStep = 0;
            this.modal = new ModalManager();

            if (!this.validateElements()) return;

            this.setupEventListeners();
            this.loadFormData();
            this.updateProgress();
        }

        validateElements() {
            if (!this.form || !this.steps.length || !this.progress) {
                this.modal.show('Error', 'Required DOM elements not found');
                return false;
            }
            return true;
        }

        setupEventListeners() {
            this.form.addEventListener('submit', (e) => this.handleSubmit(e));
            this.bindStepNavigation();
            this.bindInputHandlers();
            this.bindCheckboxHandlers();
        }

        bindStepNavigation() {
            document.querySelectorAll('.next-btn').forEach(btn =>
                btn.addEventListener('click', () => this.nextStep()));
            document.querySelectorAll('.prev-btn').forEach(btn =>
                btn.addEventListener('click', () => this.prevStep()));
        }

        bindInputHandlers() {
            const handlers = {
                college: (e) => this.handleCollegeInput(e.target.value),
                domain: () => this.showDomainOptions()
            };
            Object.entries(handlers).forEach(([id, handler]) => {
                const element = document.getElementById(id);
                if (element) element.addEventListener(id === 'college' ? 'input' : 'change', handler);
            });
        }

        bindCheckboxHandlers() {
            document.querySelectorAll('.checkbox-container').forEach(container =>
                container.addEventListener('click', (e) => {
                    const checkbox = container.querySelector('input[type="checkbox"]');
                    if (checkbox && e.target !== checkbox) checkbox.checked = !checkbox.checked;
                }));
        }

        async validateStep() {
            const inputs = this.steps[this.currentStep].querySelectorAll('[required]');
            let isValid = true;

            for (const input of inputs) {
                const errorElement = document.getElementById(`${input.id}-error`);
                if (!errorElement) continue;

                const { value } = input;
                errorElement.style.display = 'none';

                if (!value.trim()) {
                    errorElement.textContent = 'This field is required';
                    errorElement.style.display = 'block';
                    isValid = false;
                } else if (input.type === 'email' && !this.isValidEmail(value)) {
                    errorElement.textContent = 'Please enter a valid email';
                    errorElement.style.display = 'block';
                    isValid = false;
                } else if (input.type === 'tel' && !this.isValidPhone(value)) {
                    errorElement.textContent = 'Please enter a valid 10-digit phone number';
                    errorElement.style.display = 'block';
                    isValid = false;
                }
            }

            if (this.currentStep === 2) {
                const anyLanguageChecked = [...document.querySelectorAll('input[name="language[]"]')]
                    .some(cb => cb.checked);
                const languageError = document.getElementById('language-error');
                if (languageError) {
                    languageError.style.display = anyLanguageChecked ? 'none' : 'block';
                    isValid = anyLanguageChecked && isValid;
                }
            }

            return isValid;
        }

        async nextStep() {
            if (await this.validateStep() && this.currentStep < this.steps.length - 1) {
                this.toggleStep(this.currentStep, this.currentStep + 1);
            }
        }

        prevStep() {
            if (this.currentStep > 0) {
                this.toggleStep(this.currentStep, this.currentStep - 1);
            }
        }

        toggleStep(from, to) {
            this.steps[from].classList.remove('active');
            this.currentStep = to;
            this.steps[to].classList.add('active');
            this.updateProgress();
        }

        updateProgress() {
            this.progress.style.width = `${(this.currentStep / (this.steps.length - 1)) * 100}%`;
        }

        async handleCollegeInput(query) {
            const suggestionBox = document.getElementById('collegeSuggestions');
            if (!suggestionBox || query.length < 3) {
                if (suggestionBox) suggestionBox.innerHTML = '';
                return;
            }

            const suggestions = await this.fetchCollegeSuggestions(query);
            this.displaySuggestions(suggestions, suggestionBox);
        }

        async fetchCollegeSuggestions(query) {
            try {
                const response = await fetch('college.txt');
                const text = await response.text();
                const colleges = text.split('\n').map(line => line.trim()).filter(line => line);
                return colleges.filter(college => college.toLowerCase().includes(query.toLowerCase()));
            } catch (error) {
                console.error("Error fetching college names:", error);
                return [];
            }
        }

        displaySuggestions(suggestions, suggestionBox) {
            suggestionBox.innerHTML = suggestions.map(college => `
                <li>${college}</li>
            `).join('');
            
            suggestionBox.querySelectorAll('li').forEach(li =>
                li.addEventListener('click', () => {
                    document.getElementById('college').value = li.textContent;
                    suggestionBox.innerHTML = '';
                }));
        }

        showDomainOptions() {
            const domain = document.getElementById('domain')?.value;
            const optionsDiv = document.getElementById('domain-options');
            if (!optionsDiv || !domain) return;

            const domainOptions = {
                uiux: ["Figma", "Adobe XD", "Sketch"],
                backend: ["Node.js + Express.js", "Django", "Spring Boot"],
                frontend: ["React Native", "Vue.js", "Angular"],
                database: ["SQL", "MongoDB", "PostgreSQL"],
                git: ["GitHub", "GitLab", "Bitbucket"],
                security: ["Data Encryption", "OWASP Standards", "Penetration Testing"],
                tester: ["Manual Testing", "Selenium", "Cypress"]
            };

            optionsDiv.innerHTML = (domainOptions[domain] || []).map(option => `
                <div class="checkbox-container">
                    <input type="checkbox" name="domainOptions[]" value="${option}">
                    <span class="checkbox-mark"></span>
                    <span class="checkbox-label">${option}</span>
                </div>
            `).join('');

            this.bindCheckboxHandlers();
        }

        async handleSubmit(e) {
            e.preventDefault();
            if (!(await this.validateStep())) return;

            const formData = this.getFormData();
            this.saveFormData(formData);

            try {
                const response = await fetch('https://cybertron7.in/test/form-1/submit_application.php', {
                    method: 'POST',
                    body: new FormData(this.form)
                });
                const result = await response.json();

                this.modal.show(result.success ? 'Success' : 'Error', result.message);
                if (result.success) {
                    this.resetForm();
                }
            } catch (error) {
                this.modal.show('Error', `Submission failed: ${error.message}`);
            }
        }

        getFormData() {
            const formData = Object.fromEntries(new FormData(this.form));
            formData.domainOptions = formData.domainOptions || [];
            formData.language = formData.language || [];
            formData.recordResponse = !!this.form.querySelector('#recordResponse')?.checked;
            return formData;
        }

        saveFormData(formData) {
            localStorage.setItem('formData', JSON.stringify(formData));
        }

        loadFormData() {
            const data = JSON.parse(localStorage.getItem('formData') || '{}');
            Object.entries(data).forEach(([key, value]) => {
                if (Array.isArray(value)) {
                    value.forEach(val => {
                        const checkbox = this.form.querySelector(`input[name="${key}[]"][value="${val}"]`);
                        if (checkbox) checkbox.checked = true;
                    });
                } else if (key === 'recordResponse') {
                    const checkbox = this.form.querySelector('#recordResponse');
                    if (checkbox) checkbox.checked = value;
                } else {
                    const element = this.form.querySelector(`[name="${key}"]`);
                    if (element) element.value = value;
                }
            });
        }

        resetForm() {
            this.form.reset();
            this.currentStep = 0;
            this.steps.forEach(step => step.classList.remove('active'));
            this.steps[0].classList.add('active');
            this.updateProgress();
            localStorage.removeItem('formData');
        }

        isValidEmail(email) {
            return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
        }

        isValidPhone(phone) {
            return /^[0-9]{10}$/.test(phone);
        }
    }

    class ProfileManager {
        constructor(modalManager) {
            this.modalManager = modalManager;
            this.setupProfileModal();
        }

        setupProfileModal() {
            const editProfileBtn = document.getElementById('edit-profile-btn');
            const modal = document.getElementById('edit-profile-modal');
            const closeBtn = document.getElementById('close-modal-btn');
            const content = document.getElementById('profile-content');

            if (!editProfileBtn || !modal || !closeBtn || !content) return;

            editProfileBtn.addEventListener('click', () => this.loadProfile(modal, content));
            closeBtn.addEventListener('click', () => this.closeModal(modal, content));
            modal.addEventListener('click', (e) => {
                if (e.target === modal) this.closeModal(modal, content);
            });
        }

        async loadProfile(modal, content) {
            modal.style.display = 'flex';
            content.innerHTML = '<p>Loading profile data...</p>';

            try {
                const response = await fetch('userprofile/userprofile.php', {
                    method: 'GET',
                    credentials: 'same-origin',
                    headers: { 'Accept': 'text/html', 'X-Requested-With': 'XMLHttpRequest' }
                });
                if (!response.ok) throw new Error(`HTTP error! Status: ${response.status}`);
                const data = await response.text();
                content.innerHTML = data;
                this.initializeProfileForm();
            } catch (error) {
                console.error('Fetch Error:', error);
                content.innerHTML = `<p>Error loading profile: ${error.message}</p>`;
            }
        }

        closeModal(modal, content) {
            modal.style.display = 'none';
            content.innerHTML = '<p>Loading profile data...</p>';
        }

        initializeProfileForm() {
            const elements = {
                editForm: document.getElementById('edit-profile-form'),
                addOtherBtn: document.getElementById('add-anthr-btn'),
                container: document.getElementById('other-social-links-container'),
                profileUpload: document.getElementById('profile-picture'),
                deleteButton: document.getElementById('delete-button'),
                visibilityCheckbox: document.getElementById('is_profile_public')
            };

            if (elements.addOtherBtn && elements.container) {
                elements.addOtherBtn.addEventListener('click', (e) => this.addSocialLink(e, elements.container));
            }

            if (elements.profileUpload) {
                elements.profileUpload.addEventListener('change', (e) => this.previewImage(e));
            }

            if (elements.deleteButton) {
                elements.deleteButton.addEventListener('click', () => this.handleDelete());
            }

            if (elements.editForm) {
                elements.editForm.addEventListener('submit', (e) => this.handleProfileSubmit(e));
            }

            // Bind visibility checkbox handler
            if (elements.visibilityCheckbox) {
                elements.visibilityCheckbox.addEventListener('change', (e) => {
                    const errorElement = document.getElementById('is_profile_public-error');
                    if (errorElement) errorElement.style.display = 'none';
                });
            }
        }

        previewImage(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = (event) => {
                    const preview = document.getElementById('profile-preview');
                    if (preview) preview.src = event.target.result;
                };
                reader.readAsDataURL(file);
            }
        }

        async handleProfileSubmit(e) {
            e.preventDefault();
            const form = e.target;
            const formData = new FormData(form);
            const errorElement = document.getElementById('is_profile_public-error');

            // Validate visibility checkbox (optional, as it's not required)
            if (errorElement) errorElement.style.display = 'none';

            try {
                const response = await fetch('edit_profile.php', {
                    method: 'POST',
                    body: formData,
                    credentials: 'same-origin',
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                });
                const data = await response.json();

                if (data.success) {
                    this.modalManager.show('Success', data.message || 'Profile updated successfully');
                    window.location.reload();
                } else {
                    this.modalManager.show('Error', data.error || 'Failed to update profile');
                }
            } catch (error) {
                console.error('Profile Submit Error:', error);
                this.modalManager.show('Error', 'An error occurred while updating your profile');
            }
        }

        async handleUpload(e) {
            e.preventDefault();
            await this.submitForm('userprofile/uploadprofile.php', new FormData(e.target));
        }

        async handleDelete() {
            if (!confirm('Are you sure you want to delete your profile picture?')) return;
            await this.submitForm('userprofile/uploadprofile.php?delete=true', null, 'POST');
        }

        addSocialLink(e, container) {
            e.preventDefault();
            const div = document.createElement('div');
            div.className = 'social-link-group';
            div.innerHTML = `
                <input type="text" name="social_name[]" placeholder="Social Media Name">
                <input type="url" name="social_url[]" placeholder="Social Media URL">
                <button type="button" class="remove-link">Remove</button>
            `;
            div.querySelector('.remove-link').addEventListener('click', () => div.remove());
            container.appendChild(div);
        }

        async submitForm(url, formData = null, method = 'POST') {
            try {
                const options = {
                    method: method,
                    credentials: 'same-origin',
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                };

                if (formData) {
                    options.body = formData;
                }

                const response = await fetch(url, options);
                const data = await response.json();

                if (data.success) {
                    this.modalManager.show('Success', data.message);
                    window.location.reload();
                } else {
                    this.modalManager.show('Error', data.message || 'An error occurred');
                }
            } catch (error) {
                console.error('Request Failed:', error);
                this.modalManager.show('Error', 'An error occurred while processing your request');
            }
        }
    }

    class App {
        constructor() {
            this.formManager = new FormManager();
            this.profileManager = new ProfileManager(this.formManager.modal);
            this.setupNavigation();
            this.setupApplicationForm();
            this.setupStatusCheck();
        }

        setupNavigation() {
            document.querySelectorAll('.nav-item').forEach(item => {
                item.addEventListener('click', (e) => {
                    if (!item.classList.contains('logout') && !item.classList.contains('has-submenu')) {
                        e.preventDefault();
                        this.switchSection(item.getAttribute('data-section'));
                    }
                });
            });

            // Help & Support submenu toggle
            const helpSupportToggle = document.getElementById('help-support-toggle');
            const helpSupportSubmenu = document.getElementById('help-support-submenu');
            const expandIcon = helpSupportToggle?.querySelector('.expand-icon');

            if (helpSupportToggle && helpSupportSubmenu && expandIcon) {
                helpSupportToggle.addEventListener('click', (e) => {
                    e.preventDefault();
                    const isExpanded = helpSupportSubmenu.style.display === 'flex';
                    helpSupportSubmenu.style.display = isExpanded ? 'none' : 'flex';
                    expandIcon.textContent = isExpanded ? 'expand_more' : 'expand_less';
                    expandIcon.style.transform = isExpanded ? 'rotate(0deg)' : 'rotate(180deg)';
                });
            }
        }

        switchSection(sectionId) {
            document.querySelectorAll('.nav-item').forEach(nav => nav.classList.remove('active'));
            document.querySelector(`.nav-item[data-section="${sectionId}"]`)?.classList.add('active');
            document.querySelectorAll('.section').forEach(sec => sec.classList.remove('active'));
            const targetSection = document.querySelector(`#${sectionId}`);
            if (targetSection) targetSection.classList.add('active');
        }

        setupApplicationForm() {
            const registerBtn = document.getElementById('register-btn');
            const applyNav = document.querySelector('.nav-item[data-section="apply-internship"]');
            if (registerBtn) {
                registerBtn.addEventListener('click', () => {
                    document.getElementById('internship-info').style.display = 'none';
                    document.getElementById('internship-form-container').style.display = 'block';
                });
            }
            if (applyNav) {
                applyNav.addEventListener('click', () => {
                    document.getElementById('internship-info').style.display = 'block';
                    document.getElementById('internship-form-container').style.display = 'none';
                });
            }
        }

        setupStatusCheck() {
            const checkStatusBtn = document.getElementById('check-status-btn');
            if (!checkStatusBtn) return;

            checkStatusBtn.addEventListener('click', async () => {
                const appNumber = document.getElementById('app-number')?.value.trim();
                const errorElement = document.getElementById('app-number-error');
                const resultElement = document.getElementById('status-result');

                if (!appNumber || !errorElement || !resultElement) {
                    if (errorElement) {
                        errorElement.textContent = 'Please enter an application number';
                        errorElement.style.display = 'block';
                    }
                    return;
                }

                errorElement.style.display = 'none';
                resultElement.innerHTML = '';

                try {
                    const response = await fetch('get_status.awc', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                        body: `applicant_id=${encodeURIComponent(appNumber)}`
                    });
                    const data = await response.json();

                    if (data.success) {
                        resultElement.innerHTML = `
                            <h3>Application Details</h3>
                            <p><strong>Application Number:</strong> ${data.data.applicant_id}</p>
                            <p><strong>Company Name:</strong> ${data.data.company_name}</p>
                            <p><strong>Name:</strong> ${data.data.name}</p>
                            <p><strong>Status:</strong> <span class="status-${data.data.status.toLowerCase().replace(' ', '-')}">${data.data.status}</span></p>
                            <p><strong>Submitted On:</strong> ${new Date(data.data.submitted_on).toLocaleDateString()}</p>
                        `;
                    } else {
                        this.formManager.modal.show('Error', data.message);
                    }
                } catch (error) {
                    this.formManager.modal.show('Error', 'An error occurred. Please try again.');
                    console.error('Error:', error);
                }
            });
        }
    }

    // Initialize the app
    new App();

    // Preview button for internship form
    document.getElementById('preview-btn')?.addEventListener('click', function() {
        let details = `
            <p><strong>Email:</strong> ${document.getElementById('email').value}</p>
            <p><strong>Contact Number:</strong> ${document.getElementById('contact').value}</p>
            <p><strong>WhatsApp:</strong> ${document.getElementById('whatsapp').value}</p>
            <p><strong>First Name:</strong> ${document.getElementById('firstName').value}</p>
            <p><strong>Last Name:</strong> ${document.getElementById('lastName').value}</p>
            <p><strong>College:</strong> ${document.getElementById('college').value}</p>
            <p><strong>Year of Study:</strong> ${document.getElementById('year').value}</p>
            <p><strong>Branch:</strong> ${document.getElementById('branch').value}</p>
            <p><strong>Position Interested:</strong> ${document.getElementById('position').value}</p>
            <p><strong>Domain:</strong> ${document.getElementById('domain').value}</p>
            <p><strong>Languages Comfortable In:</strong> ${Array.from(document.querySelectorAll('input[name="language[]"]:checked')).map(e => e.value).join(', ')}</p>
            <p><strong>Reason for Joining:</strong> ${document.getElementById('reason').value}</p>
        `;
        document.getElementById('preview-details').innerHTML = details;
        document.getElementById('preview-box').style.display = 'block';
    });

    document.getElementById('close-preview')?.addEventListener('click', function() {
        document.getElementById('preview-box').style.display = 'none';
    });
});