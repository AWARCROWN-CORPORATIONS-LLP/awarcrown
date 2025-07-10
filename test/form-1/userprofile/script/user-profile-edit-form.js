const profileUpload = document.getElementById('profile-upload');
const previewImage = document.getElementById('preview-image');
profileUpload.addEventListener('change', function (e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function (e) {
            previewImage.src = e.target.result;
        }
        reader.readAsDataURL(file);
    }
});

const bgprofileUpload = document.getElementById('bg-profile-upload');
const bgpreviewImage = document.getElementById('preview-bg-image');
bgprofileUpload.addEventListener('change', function (e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function (e) {
            bgpreviewImage.src = e.target.result;
        }
        reader.readAsDataURL(file);
    }
});
const interestsInput = document.getElementById('interests');
const interestsList = document.getElementById('interests-list');

interestsInput.addEventListener('keypress', function(e) {
    if (e.key === 'Enter') {
        e.preventDefault();
        const interest = this.value.trim();
        if (interest) {
            addInterest(interest);
            this.value = '';
        }
    }
});

function addInterest(interest) {
    const tag = document.createElement('span');
    tag.className = 'interest-tag';
    tag.innerHTML = `
        ${interest}
        <button type="button" onclick="this.parentElement.remove()">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="4">
                <line x1="18" y1="6" x2="6" y2="18"></line>
                <line x1="6" y1="6" x2="18" y2="18"></line>
            </svg>
        </button>
    `;
    interestsList.appendChild(tag);
}
const closebtn = document.getElementById("close-btn");
const form = document.getElementById("form-section");
closebtn.addEventListener("click",()=>{
    form.style.display = "none";
});