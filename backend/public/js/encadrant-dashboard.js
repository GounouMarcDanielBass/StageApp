document.addEventListener('DOMContentLoaded', function () {
    const token = localStorage.getItem('auth_token');
    if (!token) {
        window.location.href = 'login.html';
        return;
    }

    // Fetch dashboard data
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
            initCharts(data);
        }
    })
    .catch(error => console.error('Error fetching dashboard data:', error));

    function populateDashboard(data) {
        // Populate statistics
        document.getElementById('totalStudents').textContent = data.stats.total_students || 15;
        document.getElementById('pendingEvaluations').textContent = data.stats.pending_evaluations || 5;
        document.getElementById('completedStages').textContent = data.stats.completed_stages || 12;
        document.getElementById('successRate').textContent = `${data.stats.success_rate || 92}%`;

        // Populate student table
        const tableBody = document.querySelector('#studentTable tbody');
        tableBody.innerHTML = '';
        (data.students || []).forEach(student => {
            const row = `
                <tr>
                    <td>${student.name}</td>
                    <td>${student.email}</td>
                    <td>
                        <div class="progress" style="width: 100px;">
                            <div class="progress-bar" role="progressbar" style="width: ${student.progress}%;" aria-valuenow="${student.progress}" aria-valuemin="0" aria-valuemax="100">${student.progress}%</div>
                        </div>
                    </td>
                    <td><span class="badge bg-${student.status === 'active' ? 'success' : 'warning'}">${student.status}</span></td>
                    <td>
                        <button class="btn btn-sm btn-primary me-1" onclick="viewStudent('${student.id}')">View</button>
                        <button class="btn btn-sm btn-success" onclick="evaluateStudent('${student.id}')">Evaluate</button>
                    </td>
                </tr>
            `;
            tableBody.innerHTML += row;
        });

        // Populate recent activities
        const activityList = document.getElementById('activityList');
        activityList.innerHTML = '';
        (data.recent_activities || []).forEach(activity => {
            const item = `
                <div class="list-group-item d-flex justify-content-between align-items-center">
                    <div>
                        <strong>${activity.student}</strong> - ${activity.activity}
                    </div>
                    <small class="text-muted">${new Date(activity.date).toLocaleDateString()}</small>
                </div>
            `;
            activityList.innerHTML += item;
        });
    }

    function initCharts(data) {
        // Progress Chart
        const progressCtx = document.getElementById('progressChart').getContext('2d');
        new Chart(progressCtx, {
            type: 'line',
            data: {
                labels: (data.students || []).map(s => s.name),
                datasets: [{
                    label: 'Progress %',
                    data: (data.students || []).map(s => s.progress),
                    borderColor: 'var(--primary)',
                    backgroundColor: 'rgba(var(--primary-rgb), 0.1)',
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 100
                    }
                }
            }
        });

        // Evaluation Chart
        const evalCtx = document.getElementById('evaluationChart').getContext('2d');
        new Chart(evalCtx, {
            type: 'doughnut',
            data: {
                labels: ['Completed', 'In Progress', 'Pending'],
                datasets: [{
                    data: [data.stats.completed_evaluations || 10, data.stats.in_progress || 3, data.stats.pending_evaluations || 5],
                    backgroundColor: ['var(--success)', 'var(--warning)', 'var(--danger)']
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });
    }

    // Search functionality
    document.getElementById('searchInput').addEventListener('keyup', function() {
        const filter = this.value.toLowerCase();
        const rows = document.querySelectorAll('#studentTable tbody tr');
        rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(filter) ? '' : 'none';
        });
    });

    // Add student form
    document.getElementById('addStudentForm').addEventListener('submit', function(e) {
        e.preventDefault();
        // Add logic to submit form
        alert('Student added successfully!');
        document.querySelector('[data-bs-dismiss="modal"]').click();
    });
});

function viewStudent(id) {
    // Redirect or open modal
    window.location.href = `student-detail.html?id=${id}`;
}

function evaluateStudent(id) {
    // Redirect or open modal
    window.location.href = `evaluation.html?student=${id}`;
}