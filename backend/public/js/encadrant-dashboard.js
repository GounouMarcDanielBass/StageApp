document.addEventListener('DOMContentLoaded', function () {
    const token = localStorage.getItem('token');
    if (!token) {
        window.location.href = 'login.html';
        return;
    }

    fetch('/api/encadrant/dashboard', {
        headers: {
            'Authorization': `Bearer ${token}`
        }
    })
    .then(response => {
        if (response.status === 401) {
            window.location.href = 'login.html';
            return;
        }
        return response.json();
    })
    .then(data => {
        if (data) {
            populateDashboard(data);
        }
    })
    .catch(error => console.error('Error fetching encadrant dashboard data:', error));

    function populateDashboard(data) {
        // Populate statistics
        document.querySelector('.card-text.fs-3').textContent = data.supervised_students_count;
        document.querySelectorAll('.card-text.fs-3')[1].textContent = data.pending_reports_count;
        document.querySelectorAll('.card-text.fs-3')[2].textContent = data.final_evaluations_count;

        // Populate documents to validate table
        const documentsTable = document.querySelector('.table.table-hover tbody');
        documentsTable.innerHTML = ''; // Clear existing rows

        data.documents_to_validate.forEach(doc => {
            const row = `
                <tr>
                    <td>${doc.student_name}</td>
                    <td>${doc.document_type}</td>
                    <td>${new Date(doc.submission_date).toLocaleDateString()}</td>
                    <td>
                        <a href="#" class="btn btn-sm btn-outline-primary">Télécharger</a>
                        <a href="#" class="btn btn-sm btn-outline-success">Valider</a>
                    </td>
                </tr>
            `;
            documentsTable.innerHTML += row;
        });
    }
});