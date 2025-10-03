document.addEventListener('DOMContentLoaded', function() {
    const token = localStorage.getItem('jwt_token');

    if (!token) {
        window.location.href = 'login.html';
        return;
    }

    fetch('http://127.0.0.1:8000/api/student/dashboard', {
        method: 'GET',
        headers: {
            'Accept': 'application/json',
            'Authorization': 'Bearer ' + token
        }
    })
    .then(response => {
        if (response.status === 401) {
            // Token expired or invalid
            localStorage.removeItem('jwt_token');
            window.location.href = 'login.html';
            return;
        }
        return response.json();
    })
    .then(data => {
        if (data) {
            document.getElementById('userName').textContent = data.user.name;
            document.getElementById('userEmail').textContent = data.user.email;

            // Populate Applications
            const applicationsTableBody = document.getElementById('applicationsTableBody');
            applicationsTableBody.innerHTML = '';
            if (data.applications.length > 0) {
                data.applications.forEach(app => {
                    const row = applicationsTableBody.insertRow();
                    row.insertCell(0).textContent = app.offer.title;
                    row.insertCell(1).textContent = app.offer.company.name;
                    row.insertCell(2).textContent = app.status;
                    row.insertCell(3).textContent = new Date(app.created_at).toLocaleDateString();
                });
            } else {
                const row = applicationsTableBody.insertRow();
                row.insertCell(0).colSpan = 4;
                row.insertCell(0).textContent = 'No applications found.';
            }


            // Populate Documents
            const documentsTableBody = document.getElementById('documentsTableBody');
            documentsTableBody.innerHTML = '';
            if (data.documents.length > 0) {
                data.documents.forEach(doc => {
                    const row = documentsTableBody.insertRow();
                    row.insertCell(0).textContent = doc.name;
                    row.insertCell(1).textContent = new Date(doc.created_at).toLocaleDateString();
                    const downloadLink = document.createElement('a');
                    downloadLink.href = doc.path; // Assuming doc.path is a full URL or relative path
                    downloadLink.textContent = 'Download';
                    row.insertCell(2).appendChild(downloadLink);
                });
            } else {
                const row = documentsTableBody.insertRow();
                row.insertCell(0).colSpan = 3;
                row.insertCell(0).textContent = 'No documents found.';
            }
        }
    })
    .catch(error => {
        console.error('Error fetching student dashboard data:', error);
        // Optionally redirect to login or show an error message
        // window.location.href = 'login.html';
    });
});