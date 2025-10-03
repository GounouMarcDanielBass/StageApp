document.addEventListener('DOMContentLoaded', function () {
    const token = localStorage.getItem('token');
    if (!token) {
        window.location.href = 'login.html';
        return;
    }

    fetch('/api/company/dashboard', {
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
    .catch(error => console.error('Error fetching company dashboard data:', error));

    function populateDashboard(data) {
        // Populate statistics
        document.querySelector('.card-text.fs-3').textContent = data.active_offers_count;
        document.querySelectorAll('.card-text.fs-3')[1].textContent = data.applications_count;
        document.querySelectorAll('.card-text.fs-3')[2].textContent = data.interns_count;

        // Populate recent applications table
        const applicationsTable = document.querySelector('.table.table-hover tbody');
        applicationsTable.innerHTML = ''; // Clear existing rows

        data.recent_applications.forEach(app => {
            const row = `
                <tr>
                    <td>${app.student_name}</td>
                    <td>${app.offer_title}</td>
                    <td>${new Date(app.date).toLocaleDateString()}</td>
                    <td><span class="badge bg-${getBadgeClass(app.status)}">${app.status}</span></td>
                    <td>
                        <a href="#" class="btn btn-sm btn-outline-primary">Voir</a>
                        ${app.status === 'En attente' ? 
                        `<a href="#" class="btn btn-sm btn-outline-success">Accepter</a>
                         <a href="#" class="btn btn-sm btn-outline-danger">Refuser</a>` : ''}
                    </td>
                </tr>
            `;
            applicationsTable.innerHTML += row;
        });
    }

    function getBadgeClass(status) {
        switch (status) {
            case 'En attente':
                return 'warning text-dark';
            case 'Accepté':
                return 'success';
            case 'Refusé':
                return 'danger';
            default:
                return 'secondary';
        }
    }
});