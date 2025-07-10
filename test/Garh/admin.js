 // Sticky shadow on scroll
 window.addEventListener('scroll', function () {
    const nav = document.querySelector('nav');
    nav.style.boxShadow = window.scrollY > 0 ? "0 1px 3px rgba(0, 0, 0, 0.1)" : "none";
});

// Toggle visibility of different sections
function toggleView(viewId) {
    const sections = ['user-table', 'search-box', 'close-btn', 'Profile-session', 'intern-applications', 'task-manager', 'announcements', 'resources'];
    sections.forEach(id => {
        const el = id === 'Profile-session' ? document.getElementsByClassName(id)[0] : document.getElementById(id);
        if (el) el.style.display = id === viewId ? 'block' : 'none';
    });
}

// Search users dynamically
function searchUsers() {
    const searchQuery = document.getElementById('search-box').value.toLowerCase();
    const tableRows = document.querySelectorAll('#user-table tr');
    let found = false;

    tableRows.forEach(row => {
        if (row.textContent.toLowerCase().includes(searchQuery)) {
            row.style.display = '';
            found = true;
        } else {
            row.style.display = 'none';
        }
    });

    if (!found) {
        document.getElementById('user-table').innerHTML = '<p class="no-data">No users found matching your query.</p>';
    }
}

// Check device compatibility
function checkDevice() {
    const warning = document.getElementById('warning');
    if (window.innerWidth <= 1024) {
        warning.style.display = 'block';
        document.body.classList.add('hide-content');
    } else {
        warning.style.display = 'none';
        document.body.classList.remove('hide-content');
    }
}

// Show popup modal for success or error
function showPopup(message, isError = true) {
    const modal = document.createElement('div');
    modal.className = 'modal';
    modal.innerHTML = `
        <div class="modal-content">
            <p class="${isError ? 'error' : 'success'}">${message}</p>
            <button onclick="closePopup()" class="modal-btn">OK</button>
        </div>
    `;
    document.body.appendChild(modal);
    modal.style.display = 'block';
}

function closePopup() {
    const modal = document.querySelector('.modal');
    if (modal) modal.remove();
}

// Fetch data and display in the target section
async function fetchData(endpoint, targetId) {
    try {
        toggleView(targetId);
        const targetElement = document.getElementById(targetId);
        targetElement.innerHTML = '<p class="no-data">Loading...</p>';

        const response = await fetch(endpoint);
        if (!response.ok) throw new Error(`HTTP error! Status: ${response.status}`);

        const data = await response.text();
        targetElement.innerHTML = data.trim() ? data : '<p class="no-data">No data available.</p>';

        // Re-evaluate inline scripts if any
        const scripts = targetElement.getElementsByTagName('script');
        for (let script of scripts) {
            eval(script.innerHTML);
        }
    } catch (error) {
        showPopup('Error loading data: ' + error.message);
    }
}

// Update status and show confirmation
async function updateStatus(id, status) {
    try {
        const response = await fetch('update_status.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `id=${id}&status=${status}`
        });

        const data = await response.json();
        if (data.success) {
            showPopup(data.message, false);
            document.getElementById(`status-${id}`).textContent = status;
            setTimeout(() => fetchData('announcement.php', 'announcements'), 1000);
        } else {
            showPopup(data.message);
        }
    } catch (error) {
        showPopup('Error updating status: ' + error.message);
    }
}

// Button action functions
function viewProfile() { toggleView('Profile-session'); }
function contactUs() { alert("Contact us feature coming soon!"); }
function viewFeedback() { fetchData('feedbacks_fetch.php', 'user-table'); }
function viewInternApplications() { fetchData('interns_applications.php', 'intern-applications'); }
function manageTasks() { fetchData('task_manager.php', 'task-manager'); }
function viewAnnouncements() { fetchData('announcement.php', 'announcements'); }
function viewResources() { fetchData('resources.php', 'resources'); }

// Check device compatibility on load and resize
window.addEventListener('load', checkDevice);
window.addEventListener('resize', checkDevice);