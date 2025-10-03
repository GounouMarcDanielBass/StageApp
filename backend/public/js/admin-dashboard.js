document.addEventListener('DOMContentLoaded', function () {
    const token = localStorage.getItem('token');
    if (!token) {
        window.location.href = 'login.html';
    }

    fetch('/api/admin/dashboard', {
        headers: {
            'Authorization': `Bearer ${token}`
        }
    })
    .then(response => {
        if (response.status === 401 || response.status === 403) {
            window.location.href = 'login.html';
        }
        return response.json();
    })
    .then(data => {
        document.getElementById('users-count').textContent = data.users_count;
        document.getElementById('companies-count').textContent = data.companies_count;
        document.getElementById('internships-count').textContent = data.internships_count;

        const recentActivities = document.getElementById('recent-activities');
        data.recent_activities.forEach((activity, index) => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${index + 1}</td>
                <td>${activity.user}</td>
                <td>${activity.activity}</td>
                <td>${activity.date}</td>
            `;
            recentActivities.appendChild(row);
        });
    });
});