document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('signupForm');
    const userTypeSelect = document.getElementById('userType');
    const entrepriseFields = document.getElementById('entrepriseFields');
    const etudiantFields = document.getElementById('etudiantFields');
    const encadrantFields = document.getElementById('encadrantFields');

    // Gestion de l'affichage des champs spécifiques
    userTypeSelect.addEventListener('change', function() {
        // Cacher tous les champs spécifiques
        entrepriseFields.classList.add('d-none');
        etudiantFields.classList.add('d-none');
        encadrantFields.classList.add('d-none');

        // Afficher les champs correspondants au type sélectionné
        switch(this.value) {
            case 'entreprise':
                entrepriseFields.classList.remove('d-none');
                break;
            case 'etudiant':
                etudiantFields.classList.remove('d-none');
                break;
            case 'encadrant':
                encadrantFields.classList.remove('d-none');
                break;
        }
    });

    // Validation et soumission du formulaire
    form.addEventListener('submit', async function(e) {
        e.preventDefault();

        if (!form.checkValidity()) {
            e.stopPropagation();
            form.classList.add('was-validated');
            return;
        }

        const submitButton = form.querySelector('button[type="submit"]');
        submitButton.disabled = true;
        submitButton.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Inscription en cours...';

        // Récupération des données du formulaire
        const formData = {
            type: userTypeSelect.value,
            name: `${document.getElementById('firstName').value} ${document.getElementById('lastName').value}`,
            email: document.getElementById('email').value,
            password: document.getElementById('password').value,
            password_confirmation: document.getElementById('confirmPassword').value
        };

        // Ajout des champs spécifiques selon le type
        switch(userTypeSelect.value) {
            case 'entreprise':
                formData.company_name = document.getElementById('companyName').value;
                formData.siret = document.getElementById('siret').value;
                break;
            case 'etudiant':
                formData.student_id = document.getElementById('studentId').value;
                formData.formation = document.getElementById('formation').value;
                break;
            case 'encadrant':
                formData.department = document.getElementById('department').value;
                formData.speciality = document.getElementById('speciality').value;
                break;
        }

        try {
            const response = await fetch('/api/auth/register', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify(formData)
            });

            const data = await response.json();

            if (response.ok) {
                // Afficher un message de succès
                const alert = document.createElement('div');
                alert.className = 'alert alert-success alert-dismissible fade show mt-3';
                alert.innerHTML = `
                    <strong>Inscription réussie !</strong> Vous allez être redirigé vers la page de connexion.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                `;
                form.insertAdjacentElement('beforebegin', alert);

                // Réinitialiser le formulaire
                form.reset();
                form.classList.remove('was-validated');

                // Rediriger vers la page de connexion après 2 secondes
                setTimeout(() => {
                    window.location.href = '/login.html';
                }, 2000);
            } else {
                throw new Error(data.message || 'Erreur lors de l\'inscription');
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
        } finally {
            // Réactiver le bouton
            submitButton.disabled = false;
            submitButton.innerHTML = 'S\'inscrire';
        }
    });

    // Validation du mot de passe
    const password = document.getElementById('password');
    const confirmPassword = document.getElementById('confirmPassword');

    function validatePassword() {
        if (password.value !== confirmPassword.value) {
            confirmPassword.setCustomValidity('Les mots de passe ne correspondent pas');
        } else {
            confirmPassword.setCustomValidity('');
        }
    }

    password.addEventListener('change', validatePassword);
    confirmPassword.addEventListener('change', validatePassword);
});