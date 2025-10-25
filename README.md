# Internship Management Platform

A comprehensive web application built with Laravel for managing internships, connecting students, companies, supervisors, and administrators. This platform facilitates the entire internship process from job posting to evaluation and completion.

## Table of Contents

- [Project Overview](#project-overview)
- [Features](#features)
- [Installation Instructions](#installation-instructions)
  - [XAMPP Setup](#xampp-setup)
  - [Prerequisites](#prerequisites)
  - [Installation Steps](#installation-steps)
- [Database Setup](#database-setup)
- [Seeding the Database](#seeding-the-database)
- [Running the Application](#running-the-application)
- [API Details](#api-details)
  - [Authentication](#authentication)
  - [Endpoints](#endpoints)
- [Usage Instructions](#usage-instructions)
- [User Credentials](#user-credentials)
- [Troubleshooting](#troubleshooting)
- [Contributing Guidelines](#contributing-guidelines)

## Project Overview

This platform is designed to streamline the internship management process in educational institutions. It provides role-based access for different user types:

- **Students (Étudiants)**: Apply for internships, track applications, view stages, and receive evaluations.
- **Companies (Entreprises)**: Post internship offers, manage applications, and oversee internship progress.
- **Supervisors (Encadrants)**: Monitor student progress, evaluate internships, and communicate with students.
- **Administrators (Admins)**: Oversee the entire system, manage users, and access comprehensive statistics.

The application uses Laravel 12 with JWT authentication, two-factor authentication (2FA), and a SQLite database for easy local development.

## Features

- **User Management**: Role-based authentication with JWT tokens and optional 2FA.
- **Internship Offers**: Companies can create and manage job postings.
- **Applications**: Students can apply to offers with motivation letters and CVs.
- **Stages Management**: Track internship progress from start to completion.
- **Evaluations**: Supervisors can evaluate student performance.
- **Notifications**: Real-time notifications for updates and messages.
- **Messaging**: Direct communication between students and supervisors.
- **Dashboards**: Role-specific dashboards with statistics and activities.
- **Document Management**: Upload and manage documents related to internships.
- **Security**: Account lockout on failed login attempts, secure password hashing.

## Installation Instructions

### XAMPP Setup

Since this is a PHP-based Laravel application, you need a local PHP environment. XAMPP is recommended for beginners as it provides Apache, MySQL, and PHP in one package.

1. Download and install XAMPP from [apachefriends.org](https://www.apachefriends.org/index.html).
2. Start the Apache and MySQL modules from the XAMPP control panel.
3. Ensure PHP 8.2 or higher is installed (check via `php -v` in command prompt).

### Prerequisites

- PHP 8.2 or higher
- Composer (PHP dependency manager)
- Node.js and npm (for frontend assets, optional for basic functionality)
- SQLite (default) or MySQL if changing database configuration

### Installation Steps

1. Clone the repository or download the project files to your local machine.

2. Navigate to the project directory (root of the project):

   ```
   cd d:/gestion stage final
   ```

3. Navigate to the backend directory and install PHP dependencies:

   ```
   cd backend
   composer install
   ```

4. Copy the environment file and configure it:

   ```
   cp .env.example .env
   ```

   Update `.env` file with your settings (default SQLite is fine for local development):

   ```
   APP_NAME="Internship Platform"
   APP_ENV=local
   APP_KEY=  # Will be generated
   APP_DEBUG=true
   APP_URL=http://localhost

   DB_CONNECTION=sqlite
   # DB_HOST=127.0.0.1
   # DB_DATABASE=laravel
   # DB_USERNAME=root
   # DB_PASSWORD=

   # JWT Configuration (default settings)
   JWT_SECRET=  # Will be generated

   # 2FA and other settings as needed
   ```

5. Generate application key:

   ```
   php artisan key:generate
   ```

6. (Optional) Install frontend dependencies if using Vite for assets:

   ```
   npm install
   npm run build  # or npm run dev for development
   ```

## Database Setup

The application uses SQLite by default, which requires no additional setup. If you prefer MySQL:

1. Create a database in XAMPP MySQL.

2. Update `.env` file:

   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=your_database_name
   DB_USERNAME=root
   DB_PASSWORD=
   ```

3. Run migrations to create tables:

   ```
   php artisan migrate
   ```

The database schema includes the following key tables:

- **Roles**: User roles (admin, etudiant, entreprise, encadrant)
- **Users**: User accounts with authentication details
- **Etudiants**: Student-specific information (student_id, formation)
- **Entreprises**: Company details (name, description, address, etc.)
- **Offres/Offers**: Internship offers with status (pending, active, closed)
- **Candidatures/Applications**: Student applications to offers
- **Stages**: Internship instances with start/end dates and status
- **Evaluations**: Performance evaluations for internships
- **Notifications**: System notifications for users
- **Messages**: Communication between users
- **Documents**: Files related to internships

## Seeding the Database

To populate the database with sample data:

1. Run the seeder:

   ```
   php artisan db:seed
   ```

   This will create:

   - Roles and users for each role (admin, etudiant, entreprise, encadrant)
   - Sample students, companies, supervisors, and offers
   - Applications, stages, evaluations, notifications, and messages

2. (Optional) Run specific seeders if needed:

   ```
   php artisan db:seed --class=RoleSeeder
   php artisan db:seed --class=UserSeeder
   php artisan db:seed --class=ComprehensiveSeeder
   ```

## Running the Application

1. Start the Laravel development server:

   ```
   php artisan serve
   ```

   The application will be available at `http://localhost:8000`.

2. (Optional) If using Vite for frontend assets:

   ```
   npm run dev
   ```

   This will compile and serve frontend assets.

3. Access the application:

   - Frontend: Visit `http://localhost:8000` in your browser.
   - API: API endpoints are available under `/api/` prefix.

## API Details

The application provides a RESTful API with JWT authentication.

### Authentication

- **JWT Tokens**: Use Bearer token in the `Authorization` header for protected routes.
- **Login**: POST to `/api/auth/login` with `email`, `password`, and optional `two_factor_code`.
- **Register**: POST to `/api/auth/register/{role}` with role-specific fields.
- **2FA**: Enable two-factor authentication via `/api/auth/2fa/*` endpoints.

Example Login Request:

```json
POST /api/auth/login
{
  "email": "admin@example.com",
  "password": "password"
}
```

Response includes `access_token` for subsequent requests.

### Endpoints

#### Public Endpoints
- `GET /api/latest-offers`: Latest internship offers
- `GET /api/stats`: Platform statistics
- `GET /api/testimonials`: User testimonials
- `POST /api/contact`: Submit contact form

#### Authenticated Endpoints (Role-Based)
- **Students** (`/api/etudiant/*`): Statistics, activities, stages, candidatures, profile
- **Companies** (`/api/entreprise/*`): Statistics, activities, stages, candidatures, offers, profile
- **Supervisors** (`/api/encadrant/*`): Statistics, activities, stages, candidatures, evaluations, profile
- **Admins** (`/api/admin/*`): Dashboard, users, documents, entreprises, etudiants, encadrants

#### Resources
- `GET /api/offers`: List offers (public/auth)
- `POST /api/offers`: Create offer (companies)
- `GET /api/applications`: List applications (students/companies)
- `POST /api/applications`: Submit application (students)
- `PUT /api/applications/{id}/status`: Update application status (companies/supervisors)
- `GET /api/stages`: List stages
- `POST /api/stages`: Create stage (companies)
- `GET /api/evaluations`: List evaluations (supervisors/students/admins)
- `POST /api/evaluations`: Create evaluation (supervisors)
- `GET /api/notifications`: List notifications
- `GET /api/profile`: Get user profile
- `PUT /api/profile`: Update profile
- `DELETE /api/profile`: Delete account

All authenticated endpoints require `Authorization: Bearer <token>` header.

## Usage Instructions

1. **Registration**:
   - Visit the registration page or use API to create accounts for students, companies, supervisors, or admins.
   - Provide role-specific information (e.g., student_id for students, company details for companies).

2. **Login**:
   - Use email and password.
   - If 2FA is enabled, provide the code from your authenticator app.

3. **Dashboards**:
   - Access role-specific dashboards for overviews, statistics, and quick actions.

4. **Internship Process**:
   - Companies post offers.
   - Students apply with CV and motivation letter.
   - Companies review and accept/reject applications.
   - Accepted applications become stages.
   - Supervisors evaluate stages.
   - Track progress via notifications and messaging.

5. **Security**:
   - Enable 2FA for enhanced security.
   - Monitor failed login attempts (account locks after 5 failures).

## User Credentials

After seeding, use the following credentials for testing:

- **Password**: `password` (default for all seeded users)
- **Emails**: Generated fake emails (e.g., check the database for exact values via `php artisan tinker`)

Example seeded users:
- Admin: Any user with role 'admin' (e.g., first admin user)
- Student: Any user with role 'etudiant'
- Company: Any user with role 'entreprise'
- Supervisor: Any user with role 'encadrant'

To view exact emails:
```
php artisan tinker
User::where('role_id', 1)->pluck('email')  # For admins
```

## Troubleshooting

- **Database Connection Issues**: Ensure `.env` file has correct DB settings. For SQLite, check if `database/database.sqlite` exists.
- **Migration Errors**: Run `php artisan migrate:fresh` to reset and re-run migrations.
- **Permission Errors**: Ensure storage and bootstrap/cache directories are writable.
- **JWT Issues**: Check JWT secret in `.env` and ensure token expiration is handled.
- **2FA Problems**: Verify Google2FA package installation and secret generation.
- **Asset Loading**: If frontend assets don't load, run `npm run build` or `npm run dev`.
- **Server Not Starting**: Check for port conflicts (default 8000) and PHP errors in console.

For more help, check Laravel logs in `storage/logs`.

## Contributing Guidelines

1. Fork the repository.
2. Create a feature branch: `git checkout -b feature/your-feature`.
3. Commit changes: `git commit -m 'Add your feature'`.
4. Push to branch: `git push origin feature/your-feature`.
5. Open a pull request.

- Follow Laravel coding standards.
- Write tests for new features.
- Update documentation as needed.
- Ensure migrations and seeders are included.

## License

This project is licensed under the MIT License.