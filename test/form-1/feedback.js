document.addEventListener('DOMContentLoaded', function() {
    const emojis = document.querySelectorAll('.emoji');
    const ratingInput = document.getElementById('ratingInput');
    let selectedRating = 0;

    emojis.forEach(emoji => {
        emoji.addEventListener('click', function() {
            selectedRating = this.dataset.value;
            ratingInput.value = selectedRating;
            updateRatingDisplay();
        });

        emoji.addEventListener('mouseover', function() {
            const value = this.dataset.value;
            updateRatingDisplay(value);
        });

        emoji.addEventListener('mouseout', function() {
            updateRatingDisplay();
        });
    });

   

    document.getElementById('feedbackForm').addEventListener('submit', function(event) {
        // Optionally handle form validation or processing here
        // For now, the form will be submitted normally
    });
});
