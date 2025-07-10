  // Show success or error popups
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


async function updateStatus(id, status) {
    try {
        const response = await fetch('update_status.awc', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `id=${id}&status=${status}`
        });

        const data = await response.json();
        if (data.success) {
            showPopup(data.message, false);
            document.getElementById(`status-${id}`).textContent = status;
        } else {
            showPopup(data.message);
        }
    } catch (error) {
        showPopup('Error updating status: ' + error.message);
    }
}