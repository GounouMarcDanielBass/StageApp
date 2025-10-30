document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('loginForm');
    const togglePassword = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('password');
    const rememberMe = document.getElementById('rememberMe');

    // Gestion de l'affichage/masquage du mot de passe
    togglePassword.addEventListener('click', function() {
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);
        
        const icon = this.querySelector('i');
        icon.classList.toggle('fa-eye');
        icon.classList.toggle('fa-eye-slash');
    });

    // Restauration des identifiants sauvegardés
    if (localStorage.getItem('rememberedEmail')) {
        document.getElementById('email').value = localStorage.getItem('rememberedEmail');
        rememberMe.checked = true;
    }

    // Gestion de la soumission du formulaire
    form.addEventListener('submit', async function(e) {
        e.preventDefault();

        if (!form.checkValidity()) {
            e.stopPropagation();
            form.classList.add('was-validated');
            return;
        }

        const submitButton = form.querySelector('button[type="submit"]');
        const buttonText = submitButton.querySelector('.button-text');
        const spinner = submitButton.querySelector('.spinner-border');

        // Désactiver le bouton et afficher le spinner
        submitButton.disabled = true;
        buttonText.classList.add('d-none');
        spinner.classList.remove('d-none');

        const formData = {
            email: document.getElementById('email').value,
            password: passwordInput.value
        };

        try {
            const response = await fetch('/api/auth/login', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify(formData)
            });

            const data = await response.json();

            if (response.ok) {
                // Sauvegarder le token
                localStorage.setItem('auth_token', data.access_token);
                
                // Sauvegarder l'email si "Se souvenir de moi" est coché
                if (rememberMe.checked) {
                    localStorage.setItem('rememberedEmail', formData.email);
                } else {
                    localStorage.removeItem('rememberedEmail');
                }

                // Afficher un message de succès
                const alert = document.createElement('div');
                alert.className = 'alert alert-success alert-dismissible fade show mt-3';
                alert.innerHTML = `
                    <strong>Connexion réussie !</strong> Vous allez être redirigé vers votre tableau de bord.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                `;
                form.insertAdjacentElement('beforebegin', alert);

                // Rediriger vers le tableau de bord approprié selon le rôle
                setTimeout(() => {
                    switch(data.user.role) {
                        case 'admin':
                            window.location.href = 'admin-dashboard.html';
                            break;
                        case 'etudiant':
                            window.location.href = 'student-dashboard.html';
                            break;
                        case 'entreprise':
                            window.location.href = 'dashboard-entreprise.html';
                            break;
                        case 'encadrant':
                            window.location.href = 'dashboard-encadrant.html';
                            break;
                        default:
                            window.location.href = 'dashboard.html';
                    }
                }, 1500);
            } else {
                throw new Error(data.message || 'Identifiants invalides');
            }
        } catch (error) {
            // Afficher un message d'erreur
            const alert = document.createElement('div');
            alert.className = 'alert alert-danger alert-dismissible fade show mt-3';
            alert.innerHTML = `
                <strong>Erreur !</strong> ${error.message}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            `;
            form.insertAdjacentElement('beforebegin', alert);

            // Réinitialiser le formulaire
            passwordInput.value = '';
            form.classList.remove('was-validated');
        } finally {
            // Réactiver le bouton et masquer le spinner
            submitButton.disabled = false;
            buttonText.classList.remove('d-none');
            spinner.classList.add('d-none');
        }
    });
});