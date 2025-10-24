
function checkAuth() {
    const token = localStorage.getItem('auth_token');
    const guestNav = document.getElementById('guest-nav');
    const userNav = document.getElementById('user-nav');
    const userName = document.getElementById('user-name');

    if (token) {
        // Verify token validity with the backend
        fetch('/api/me', {
            headers: {
                'Authorization': `Bearer ${token}`
            }
        })
        .then(response => {
            if (response.ok) {
                return response.json();
            }
            throw new Error('Token is invalid');
        })
        .then(user => {
            // Token is valid, show user nav
            guestNav.classList.add('d-none');
            userNav.classList.remove('d-none');
            userName.textContent = user.name;
        })
        .catch(error => {
            // Token is invalid or expired, show guest nav
            localStorage.removeItem('auth_token');
            guestNav.classList.remove('d-none');
            userNav.classList.add('d-none');
        });
    } else {
        // No token, show guest nav
        guestNav.classList.remove('d-none');
        userNav.classList.add('d-none');
    }
}

function logout() {
    const token = localStorage.getItem('auth_token');
    fetch('/api/logout', {
        method: 'POST',
        headers: {
            'Authorization': `Bearer ${token}`
        }
    })
    .finally(() => {
        localStorage.removeItem('auth_token');
        window.location.href = 'login.html';
    });
}

// Automatically refresh token before it expires
setInterval(() => {
    const token = localStorage.getItem('auth_token');
    if (token) {
        fetch('/api/refresh', {
            method: 'POST',
            headers: {
                'Authorization': `Bearer ${token}`
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.access_token) {
                localStorage.setItem('auth_token', data.access_token);
            }
        });
    }
}, 1000 * 60 * 55); // Refresh every 55 minutes

document.addEventListener('DOMContentLoaded', function() {
    checkAuth();

    const logoutButton = document.getElementById('logout-button');
    if (logoutButton) {
        logoutButton.addEventListener('click', function(e) {
            e.preventDefault();
            logout();
        });
    }
});
