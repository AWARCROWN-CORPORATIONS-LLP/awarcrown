
  
      
        function login() {
            document.getElementById("login-form").style.left = "50px";
            document.getElementById("register-form").style.left = "450px";
            document.getElementById("buttons").style.left = "0px";
            document.getElementById("loginbutton").style.color = "white";
            document.getElementById("registerbutton").style.color = "black";
            document.getElementById("form-container").style.height = "500px";
        }

        document.getElementById("visibility-icon").addEventListener('click', function() {
            const passwordField = document.getElementById('login-password');
            const isPassword = passwordField.type === 'password';
            passwordField.type = isPassword ? 'text' : 'password';
            this.src = isPassword ? 'visibilityoff.png' :'passwordvisibilityon.png';
        });
        document.getElementById("visibility-icon-for-create-password").addEventListener('click', function() {
            const passwordField = document.getElementById('register-password');
            const isPassword = passwordField.type === 'password';
            passwordField.type = isPassword ? 'text' : 'password';
            this.src = isPassword ? 'visibilityoff.png' :'passwordvisibilityon.png';
        });
        document.getElementById("visibility-icon-for-cnfpassword").addEventListener('click', function() {
            const passwordField = document.getElementById('confirm-password');
            const isPassword = passwordField.type === 'password';
            passwordField.type = isPassword ? 'text' : 'password';
            this.src = isPassword ? 'visibilityoff.png' :'passwordvisibilityon.png';
        });

        // Disable submit button after form submission
        document.querySelector('form').addEventListener('submit', function() {
            document.querySelector('input[type="submit"]').disabled = true;
        });
        
        
        
        // new feature
        
document.addEventListener('DOMContentLoaded', function() {
    const loginUsername = document.getElementById('login-username');
    const loginPassword = document.getElementById('login-password');
   

    const loginUsernameError = document.createElement('p');
    loginUsernameError.className = 'error-message';
    loginUsername.parentElement.appendChild(loginUsernameError);

    const loginPasswordError = document.createElement('p');
    loginPasswordError.className = 'error-message';
    loginPassword.parentElement.appendChild(loginPasswordError);

    function validateUsername(input, errorElement) {
        if (input.value.length < 3) {
            errorElement.textContent = 'Username must be at least 3 characters long.';
            errorElement.style.display = 'block';
        } else {
            errorElement.textContent = '';
            errorElement.style.display = 'none';
        }
    }

    function validatePassword(input, errorElement) {
        const pattern = /^(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/;
        if (!pattern.test(input.value)) {
            errorElement.textContent = 'Password must be at least 8 characters long, include at least one capital letter, one special character, and one number.';
            errorElement.style.display = 'block';
        } else {
            errorElement.textContent = '';
            errorElement.style.display = 'none';
        }
    

    }

    loginUsername.addEventListener('input', () => validateUsername(loginUsername, loginUsernameError));
    loginPassword.addEventListener('input', () => validatePassword(loginPassword, loginPasswordError));

  
});
