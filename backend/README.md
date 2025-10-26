# Internship Management System

A comprehensive web-based platform for managing internships, connecting students, companies, supervisors, and administrators. Built with Laravel for the backend API and static HTML/CSS/JavaScript for the frontend.

## Features

### User Roles
- **Administrators**: Manage users, validate companies, assign supervisors, view system statistics.
- **Students (Étudiants)**: Apply for internships, track applications, upload documents, view evaluations.
- **Companies (Entreprises)**: Post internship offers, manage applications, evaluate interns, track stages.
- **Supervisors (Encadrants)**: Monitor student progress, validate reports, conduct evaluations.

### Core Functionality
- **Authentication & Security**: JWT-based authentication with Google 2FA support.
- **Internship Offers**: Companies can create and manage internship listings.
- **Applications**: Students can apply to offers and track their status.
- **Stage Management**: Track internship progress, evaluations, and reports.
- **Document Management**: Upload and manage documents for applications and reports.
- **Evaluations**: Supervisors and companies can evaluate student performance.
- **Notifications**: Real-time notifications for application status, messages, and updates.
- **Dashboards**: Role-specific dashboards with statistics and activity feeds.
- **Messaging**: Communication between users.
- **Profile Management**: Update personal information and settings.

## Requirements

- PHP 8.2 or higher
- Composer
- Node.js and npm
- MySQL or compatible database
- Web server (Apache/Nginx) or Laravel's built-in server

## Installation

1. **Clone the Repository**
   ```bash
   git clone <repository-url>
   cd gestion-stage-final/backend
   ```

2. **Install PHP Dependencies**
   ```bash
   composer install
   ```

3. **Install Node Dependencies**
   ```bash
   npm install
   ```

4. **Environment Configuration**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

   Update `.env` file with your database credentials and other settings:
   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=internship_db
   DB_USERNAME=your_username
   DB_PASSWORD=your_password

   JWT_SECRET=your_jwt_secret
   ```

5. **Database Setup**
   ```bash
   php artisan migrate
   php artisan db:seed  # Optional: Populate with sample data
   ```

6. **Build Assets**
   ```bash
   npm run build  # For production
   # or
   npm run dev    # For development
   ```

## Usage

1. **Start the Development Server**
   ```bash
   composer run dev
   ```
   This runs the Laravel server, queue worker, and Vite dev server concurrently.

2. **Access the Application**
   - Frontend: Open `http://localhost:8000` in your browser
   - API: Available at `http://localhost:8000/api`

3. **Register Users**
   - Visit the signup page and create accounts for different roles.
   - Enable 2FA for enhanced security.

4. **Role-Based Access**
   - Login and access role-specific dashboards and features.

## API Endpoints

The API provides RESTful endpoints for all core functionalities. All authenticated routes require JWT token in the Authorization header.

### Authentication
- `POST /api/auth/login` - User login
- `POST /api/auth/register/{role}` - User registration
- `POST /api/auth/logout` - User logout
- `POST /api/auth/2fa/generate` - Generate 2FA secret
- `POST /api/auth/2fa/verify` - Verify 2FA code

### Students (Étudiants)
- `GET /api/etudiant/dashboard` - Student dashboard data
- `GET /api/etudiant/candidatures` - View applications
- `POST /api/etudiant/candidatures` - Submit new application
- `GET /api/etudiant/profile` - Get profile
- `PUT /api/etudiant/profile` - Update profile

### Companies (Entreprises)
- `GET /api/entreprise/dashboard` - Company dashboard data
- `GET /api/entreprise/offers` - Manage internship offers
- `POST /api/entreprise/offers` - Create new offer
- `GET /api/entreprise/applications` - View applications
- `PUT /api/entreprise/applications/{id}/status` - Update application status

### Supervisors (Encadrants)
- `GET /api/encadrant/dashboard` - Supervisor dashboard data
- `GET /api/encadrant/stages` - View assigned stages
- `POST /api/encadrant/evaluations` - Create evaluation
- `PUT /api/encadrant/evaluations/{id}` - Update evaluation

### Administrators
- `GET /api/admin/dashboard` - Admin dashboard data
- `GET /api/admin/users` - Manage users
- `GET /api/admin/entreprises` - Validate companies
- `GET /api/admin/encadrants` - Manage supervisors

### Public Endpoints
- `GET /api/latest-offers` - Get latest internship offers
- `GET /api/stats` - System statistics
- `POST /api/contact` - Submit contact form

For complete API documentation, refer to the generated Swagger/OpenAPI docs or individual controller files.

## Project Structure

```
backend/
├── app/
│   ├── Http/Controllers/     # API and web controllers
│   ├── Models/               # Eloquent models
│   └── Services/             # Business logic services
├── database/
│   ├── migrations/           # Database migrations
│   ├── seeders/              # Data seeders
│   └── factories/            # Model factories for testing
├── public/                   # Static assets and frontend files
│   ├── css/                  # Stylesheets
│   ├── js/                   # JavaScript files
│   ├── images/               # Image assets
│   └── index.html            # Frontend entry point
├── resources/
│   └── views/                # Blade templates (if any)
├── routes/
│   ├── api.php               # API routes
│   └── web.php               # Web routes
├── config/                   # Configuration files
├── composer.json             # PHP dependencies
└── package.json              # Node.js dependencies
```

## Documentation

- **[API Documentation](API.md)**: Detailed API endpoints and usage examples
- **[User Guide](USER_GUIDE.md)**: Comprehensive guide for end-users on how to use the system

## Contributing

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## Support

For support, email support@yourcompany.com or create an issue in the repository.

## Changelog

### Version 1.0.0
- Initial release with core internship management features
- JWT authentication with 2FA
- Role-based access control
- Responsive frontend design