  

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


    document.getElementById('share-profile-btn').addEventListener('click', function () {
        const shareLink = `${window.location.origin}/feed/profile_view/public_profile?user=<?php echo $username; ?>`;
        navigator.clipboard.writeText(shareLink).then(() => {
            alert('Profile link copied to clipboard!');
        }).catch(err => {
            console.error('Failed to copy text: ', err);
        });
    });

        document.getElementById('delete-button')?.addEventListener('click', function () {
            if (confirm('Are you sure you want to delete your profile picture?')) {
                window.location.href = '?delete=true';
            }
        });
        document.getElementById('delete-button-background')?.addEventListener('click', function () {
            if (confirm('Are you sure you want to delete your background profile picture?')) {
                window.location.href = 'background_profile_update.php?delete=true';
            }
        });


        //using ajax handle submission of background profile avoid page reload 
       $(document).ready(function () {
        $('#background_profile_update').on('submit', function (e) {
            e.preventDefault(); // Prevent the default form submission

            $.ajax({
                url: '../userprofile/main/background_profile_update.php',
                type: 'POST',
                data: new FormData(this),
                contentType: false,
                processData: false,
                success: function (response) {
                    alert(response);
                },
                error: function (xhr, status, error) {
                    alert('Error uploading file: ' + error);
                }
            });
        });
    });
function editbutton(){
    window.location.href="../main/stage2.php";

}

  