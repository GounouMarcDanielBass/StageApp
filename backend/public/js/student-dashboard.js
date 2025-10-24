document.addEventListener('DOMContentLoaded', () => {
    if (window.location.pathname.endsWith('student-dashboard.html')) {
        const token = localStorage.getItem('auth_token');
        if (!token) {
            window.location.href = 'login.html';
            return;
        }

        fetchStudentData(token);
        fetchNotifications(token);
    }
});

async function fetchStudentData(token) {
    try {
        const response = await fetch('/api/student/dashboard', {
            headers: {
                'Authorization': `Bearer ${token}`,
                'Accept': 'application/json'
            }
        });

        if (!response.ok) {
            if (response.status === 401) {
                window.location.href = 'login.html';
            }
            throw new Error('Failed to fetch student data');
        }

        const data = await response.json();

        updateProfile(data.user);
        updateApplications(data.applications);
        updateDocuments(data.documents);

    } catch (error) {
        console.error('Error fetching student data:', error);
    }
}

async function fetchNotifications(token) {
    try {
        const response = await fetch('/api/notifications', {
            headers: {
                'Authorization': `Bearer ${token}`,
                'Accept': 'application/json'
            }
        });

        if (!response.ok) {
            throw new Error('Failed to fetch notifications');
        }

        const notifications = await response.json();
        updateNotifications(notifications);

    } catch (error) {
        console.error('Error fetching notifications:', error);
    }
}

function updateProfile(user) {
    const profileCard = document.querySelector('.card-title');
    if (profileCard && profileCard.textContent === 'Profil') {
        const cardBody = profileCard.parentElement;
        cardBody.querySelector('.card-text:nth-of-type(1)').innerHTML = `<strong>Nom:</strong> ${user.name}`;
        cardBody.querySelector('.card-text:nth-of-type(2)').innerHTML = `<strong>Email:</strong> ${user.email}`;
    }
}

function updateApplications(applications) {
    const applicationsTable = document.querySelector('table tbody');
    if (applicationsTable) {
        applicationsTable.innerHTML = '';
        applications.forEach(app => {
            const statusBadge = getStatusBadge(app.status);
            const row = `
                <tr>
                    <td>${app.offer}</td>
                    <td>${app.company}</td>
                    <td><span class="badge ${statusBadge}">${app.status}</span></td>
                </tr>
            `;
            applicationsTable.innerHTML += row;
        });
    }
}

function updateDocuments(documents) {
    const documentsList = document.querySelector('.list-group');
    if (documentsList) {
        documentsList.innerHTML = '';
        documents.forEach(doc => {
            const item = `
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    ${doc.name}
                    <span>
                        <a href="#" class="btn btn-sm btn-outline-primary">Télécharger</a>
                        <button class="btn btn-sm btn-outline-danger" onclick="confirmDelete('${doc.id}')">Supprimer</button>
                    </span>
                </li>
            `;
            documentsList.innerHTML += item;
        });
    }
}

function updateNotifications(notifications) {
    const notificationsList = document.getElementById('notifications-list');
    if (notificationsList) {
        notificationsList.innerHTML = '';
        notifications.forEach(notif => {
            const item = `
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    ${notif.message}
                    <span>
                        <small class="text-muted">${notif.created_at}</small>
                        ${!notif.read ? '<span class="badge bg-primary">New</span>' : ''}
                    </span>
                </li>
            `;
            notificationsList.innerHTML += item;
        });
    }
}

function getStatusBadge(status) {
    switch (status) {
        case 'accepted':
            return 'bg-success';
        case 'pending':
            return 'bg-warning text-dark';
        case 'rejected':
            return 'bg-danger';
        default:
            return 'bg-secondary';
    }
}

function confirmDelete(docId) {
    if (confirm('Are you sure you want to delete this document?')) {
        // Implement delete logic
        console.log('Deleting document:', docId);
    }
}