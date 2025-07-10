<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Manage Interns</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
        }
        .table-container {
            max-height: 400px;
            overflow-y: auto;
        }
        .btn-primary {
            background-color: #1a73e8;
            transition: background-color 0.3s;
        }
        .btn-primary:hover {
            background-color: #1557b0;
        }
    </style>
</head>
<body class="bg-gray-100 min-h-screen">
    <div class="container mx-auto p-6">
        <h1 class="text-2xl font-bold text-gray-800 mb-6 text-center">Admin Panel - Manage Interns</h1>

        <!-- Add Intern Form -->
        <div class="bg-white p-6 rounded-lg shadow-lg mb-8">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Add New Intern</h2>
            <form id="intern-form" enctype="multipart/form-data" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="intern_id" class="block text-sm font-medium text-gray-700">Intern ID</label>
                        <input type="text" name="intern_id" id="intern_id" class="mt-1 block w-full p-2 border border-gray-300 rounded-md" required>
                    </div>
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                        <input type="text" name="name" id="name" class="mt-1 block w-full p-2 border border-gray-300 rounded-md" required>
                    </div>
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" name="email" id="email" class="mt-1 block w-full p-2 border border-gray-300 rounded-md" required>
                    </div>
                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700">Phone</label>
                        <input type="text" name="phone" id="phone" class="mt-1 block w-full p-2 border border-gray-300 rounded-md">
                    </div>
                    <div>
                        <label for="resume" class="block text-sm font-medium text-gray-700">Resume (PDF)</label>
                        <input type="file" name="resume" id="resume" accept=".pdf" class="mt-1 block w-full p-2 border border-gray-300 rounded-md">
                    </div>
                    <div>
                        <label for="address" class="block text-sm font-medium text-gray-700">Address</label>
                        <input type="text" name="address" id="address" class="mt-1 block w-full p-2 border border-gray-300 rounded-md">
                    </div>
                    <div>
                        <label for="guardian_name" class="block text-sm font-medium text-gray-700">Guardian Name</label>
                        <input type="text" name="guardian_name" id="guardian_name" class="mt-1 block w-full p-2 border border-gray-300 rounded-md">
                    </div>
                    <div>
                        <label for="guardian_phone" class="block text-sm font-medium text-gray-700">Guardian Phone</label>
                        <input type="text" name="guardian_phone" id="guardian_phone" class="mt-1 block w-full p-2 border border-gray-300 rounded-md">
                    </div>
                    <div>
                        <label for="college_name" class="block text-sm font-medium text-gray-700">College Name</label>
                        <input type="text" name="college_name" id="college_name" class="mt-1 block w-full p-2 border border-gray-300 rounded-md">
                    </div>
                    <div>
                        <label for="nda_document" class="block text-sm font-medium text-gray-700">NDA Document (PDF)</label>
                        <input type="file" name="nda_document" id="nda_document" accept=".pdf" class="mt-1 block w-full p-2 border border-gray-300 rounded-md">
                    </div>
                    <div>
                        <label for="offer_letter" class="block text-sm font-medium text-gray-700">Offer Letter (PDF)</label>
                        <input type="file" name="offer_letter" id="offer_letter" accept=".pdf" class="mt-1 block w-full p-2 border border-gray-300 rounded-md">
                    </div>
                </div>
                <button type="submit" class="btn-primary w-full py-2 px-4 text-white rounded-md">Add Intern</button>
            </form>
            <div id="form-message" class="text-red-500 text-sm mt-4 hidden"></div>
        </div>

        <!-- Interns Table -->
        <div class="bg-white p-6 rounded-lg shadow-lg">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Interns List</h2>
            <div class="table-container">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Intern ID</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="interns-table" class="bg-white divide-y divide-gray-200"></tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('intern-form').addEventListener('submit', async (e) => {
    e.preventDefault();
    const formData = new FormData(e.target);

    try {
        const response = await fetch('api.php?action=add_intern', {
            method: 'POST',
            body: formData
        });
        const data = await response.json();
        const messageDiv = document.getElementById('form-message');
        messageDiv.textContent = data.message;
        messageDiv.classList.remove('hidden');
        messageDiv.classList.toggle('text-red-500', !data.success);
        messageDiv.classList.toggle('text-green-500', data.success);
        if (data.success) {
            e.target.reset();
            loadInterns();
        }
    } catch (error) {
        showFormMessage('An error occurred. Please try again.');
    }
});

async function loadInterns() {
    try {
        const response = await fetch('api.php?action=get_interns');
        const data = await response.json();
        const tableBody = document.getElementById('interns-table');
        tableBody.innerHTML = '';
        data.interns.forEach(intern => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td class="px-4 py-2">${intern.intern_id}</td>
                <td class="px-4 py-2">${intern.name}</td>
                <td class="px-4 py-2">${intern.email}</td>
                <td class="px-4 py-2">
                    <a href="api.php?action=download_resume&intern_id=${intern.intern_id}" class="text-blue-600 hover:underline">Resume</a> |
                    <a href="api.php?action=download_nda&intern_id=${intern.intern_id}" class="text-blue-600 hover:underline">NDA</a> |
                    <a href="api.php?action=download_offer_letter&intern_id=${intern.intern_id}" class="text-blue-600 hover:underline">Offer Letter</a>
                </td>
            `;
            tableBody.appendChild(row);
        });
    } catch (error) {
        console.error('Error loading interns:', error);
    }
}

function showFormMessage(message, isSuccess = false) {
    const messageDiv = document.getElementById('form-message');
    messageDiv.textContent = message;
    messageDiv.classList.remove('hidden');
    messageDiv.classList.toggle('text-red-500', !isSuccess);
    messageDiv.classList.toggle('text-green-500', isSuccess);
}

document.addEventListener('DOMContentLoaded', loadInterns);
    </script>
</body>
</html>