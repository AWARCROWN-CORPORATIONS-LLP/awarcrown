<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Upload Certificate</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    
  <form id="uploadForm" class="bg-white p-6 rounded shadow-md w-96" enctype="multipart/form-data">
      
    <h2 class="text-xl font-semibold mb-4">Upload Certificate</h2>
    
    <label class="block mb-2 text-sm">Applicant ID</label>
    <input type="text" name="applicant_id" id="applicant_id" class="w-full border border-gray-300 p-2 rounded mb-4" required>

    <label class="block mb-2 text-sm">Select Certificate (PDF only)</label>
    <input type="file" name="certificate" id="certificate" accept=".pdf" class="w-full mb-4" required>

    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Upload</button>

    <div id="response" class="mt-4 text-sm"></div>
  </form>

  <script>
    document.getElementById("uploadForm").addEventListener("submit", function(e) {
      e.preventDefault();

      const form = e.target;
      const formData = new FormData(form);

      fetch("https://cybertron7.in/test/verify/upload_certificate.awc", {
        method: "POST",
        body: formData
      })
      .then(response => response.json())
      .then(data => {
        const responseDiv = document.getElementById("response");
        if (data.success) {
          responseDiv.innerHTML = `<span class="text-green-600">Upload successful! Path: ${data.certificate_path}</span>`;
        } else {
          responseDiv.innerHTML = `<span class="text-red-600">Error: ${data.message}</span>`;
        }
      })
      .catch(error => {
        document.getElementById("response").innerHTML = `<span class="text-red-600">Upload failed: ${error.message}</span>`;
      });
    });
  </script>
</body>
</html>
