

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Intern Submissions</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <style>
    iframe { width: 100%; height: 500px; border: none; }
    .table-responsive { margin-top: 20px; }
    .view-btn { cursor: pointer; color: #0d6efd; text-decoration: underline; }
    .loading { display: none; text-align: center; padding: 20px; }
    .search-container { margin-bottom: 20px; }
    .pagination { margin-top: 20px; }
  </style>
</head>
<body class="p-4">
  <div class="container">
    <h2>Intern Submissions</h2>
    <div class="search-container">
      <input type="text" id="searchInput" class="form-control" placeholder="Search by name or email...">
    </div>
    <div class="loading" id="loading">Loading...</div>
    <div class="table-responsive">
      <table class="table table-bordered table-hover" id="submissionsTable">
        <thead class="table-dark">
          <tr>
            <th>ID</th>
            <th>Application ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Address</th>
            <th>Emergency Contact</th>
            <th>Relationship</th>
            <th>Secondary Phone</th>
            <th>Aadhar</th>
            <th>Resume</th>
            <th>Created</th>
          </tr>
        </thead>
        <tbody id="submissionData"></tbody>
      </table>
    </div>
    <nav class="pagination">
      <ul class="pagination" id="pagination"></ul>
    </nav>
  </div>

  <!-- Viewer Modal -->
  <div class="modal fade" id="fileModal" tabindex="-1">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Document Viewer</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <iframe id="docFrame" src=""></iframe>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    const itemsPerPage = 10;
    let currentPage = 1;
    let allData = [];

    function displayData(data, page) {
      const tbody = document.getElementById('submissionData');
      tbody.innerHTML = '';
      const start = (page - 1) * itemsPerPage;
      const end = start + itemsPerPage;
      const paginatedData = data.slice(start, end);

      paginatedData.forEach(row => {
        const tr = document.createElement('tr');
        tr.innerHTML = `
          <td>${row.id}</td>
          <td>${row.applicant_id || 'N/A'}</td>
          <td>${row.full_name}</td>
          <td>${row.email}</td>
          <td>${row.phone}</td>
          <td>${row.address}</td>
          <td>${row.emergency_contact}</td>
          <td>${row.relationship}</td>
          <td>${row.secondary_phone}</td>
          <td><span class="view-btn" onclick="viewFile('${row.aadhar_path}')">View</span></td>
          <td><span class="view-btn" onclick="viewFile('${row.resume_path}')">View</span></td>
          <td>${new Date(row.created_at).toLocaleString()}</td>
        `;
        tbody.appendChild(tr);
      });

      updatePagination(data.length);
    }

    function updatePagination(totalItems) {
      const pageCount = Math.ceil(totalItems / itemsPerPage);
      const pagination = document.getElementById('pagination');
      pagination.innerHTML = '';

      for (let i = 1; i <= pageCount; i++) {
        const li = document.createElement('li');
        li.className = `page-item ${i === currentPage ? 'active' : ''}`;
        li.innerHTML = `<a class="page-link" href="#" onclick="changePage(${i})">${i}</a>`;
        pagination.appendChild(li);
      }
    }

    function changePage(page) {
      currentPage = page;
      const filteredData = filterData();
      displayData(filteredData, page);
    }

    function filterData() {
      const searchTerm = document.getElementById('searchInput').value.toLowerCase();
      return allData.filter(row => 
        row.full_name.toLowerCase().includes(searchTerm) || 
        row.email.toLowerCase().includes(searchTerm)
      );
    }

    function viewFile(path) {
      const url = encodeURIComponent(window.location.origin + '/test/awarcrown_interns/' + path);
      document.getElementById('docFrame').src = `https://drive.google.com/viewerng/viewer?embedded=true&url=${url}`;
      const fileModal = new bootstrap.Modal(document.getElementById('fileModal'));
      fileModal.show();
    }

    document.getElementById('searchInput').addEventListener('input', () => {
      currentPage = 1;
      const filteredData = filterData();
      displayData(filteredData, currentPage);
    });

    document.getElementById('loading').style.display = 'block';
    fetch('fetch_data.php')
      .then(res => {
        if (!res.ok) throw new Error('Network response was not ok');
        return res.json();
      })
      .then(data => {
        document.getElementById('loading').style.display = 'none';
        if (data.error) {
          alert('Error: ' + data.error);
          return;
        }
        allData = data;
        displayData(allData, currentPage);
      })
      .catch(error => {
        document.getElementById('loading').style.display = 'none';
        alert('Error fetching data: ' + error.message);
      });
  </script>
</body>
</html>