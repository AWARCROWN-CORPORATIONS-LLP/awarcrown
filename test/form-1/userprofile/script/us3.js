document.addEventListener("DOMContentLoaded", function () {
    const tabButtons = document.querySelectorAll(".tab-button");
    const tabContents = document.querySelectorAll(".tab-content");

    tabButtons.forEach(button => {
        button.addEventListener("click", () => {
            tabButtons.forEach(btn => btn.classList.remove("active"));
            tabContents.forEach(content => content.classList.remove("active"));
            button.classList.add("active");
            const tabId = button.getAttribute("data-tab");
            document.getElementById(tabId).classList.add("active");
        });
    });
});



  



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
              url: 'background_profile_update.php',
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



$(document).ready(function(){
    function loadIdeas() {
        $.ajax({
            url: "../shared_thoughts.php",
            method: "GET",
            dataType: "json",
            success: function(data) {
                let content = "<ul>";
                data.forEach(function(idea) {
                    content += "<li><strong>" + idea.idea + "</strong><br>" +
                               "<em>Tags:</em> " + idea.tags + "<br>" +
                               "<p>" + idea.description + "</p></li><hr>";
                });
                content += "</ul>";
                $("#shared-thoughts").html(content);
            },
            error: function() {
                $("#shared-thoughts").html("<p>Error fetching data.</p>");
            }
        });
    }

    // Load ideas on page load
    loadIdeas();

    // Optionally, refresh ideas every few seconds
    setInterval(loadIdeas, 5000); // Refresh every 5 seconds
});

