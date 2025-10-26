# API Documentation

This document provides detailed information about the REST API endpoints for the Internship Management System.

## Base URL

```
http://localhost:8000/api
```

## Authentication

Most endpoints require authentication using JWT tokens. Include the token in the Authorization header:

```
Authorization: Bearer <your_jwt_token>
```

### Obtaining a Token

1. **Login**
   ```
   POST /api/auth/login
   Content-Type: application/json

   {
     "email": "user@example.com",
     "password": "password"
   }
   ```

2. **Register**
   ```
   POST /api/auth/register/{role}
   Content-Type: application/json

   {
     "name": "John Doe",
     "email": "user@example.com",
     "password": "password",
     "password_confirmation": "password"
   }
   ```
   Roles: `etudiant`, `entreprise`, `encadrant`, `admin`

## Endpoints

### Public Endpoints

#### Latest Offers
```
GET /api/latest-offers
```
Returns the most recent internship offers.

#### System Statistics
```
GET /api/stats
```
Returns general system statistics.

#### Testimonials
```
GET /api/testimonials
```
Returns testimonials (if implemented).

#### Contact Form
```
POST /api/contact
Content-Type: application/json

{
  "name": "John Doe",
  "email": "john@example.com",
  "message": "Your message here"
}
```

### Authenticated Endpoints

#### User Profile
```
GET /api/user
PUT /api/profile
Content-Type: application/json

{
  "name": "Updated Name",
  "email": "newemail@example.com"
}
DELETE /api/profile
```

#### Notifications
```
GET /api/notifications
PUT /api/notifications/{id}
DELETE /api/notifications/{id}
```

### Role-Based Endpoints

#### Students (Étudiants)

**Dashboard**
```
GET /api/etudiant/dashboard
```

**Applications**
```
GET /api/etudiant/candidatures
POST /api/etudiant/candidatures
Content-Type: application/json

{
  "offer_id": 1,
  "cover_letter": "My cover letter"
}
GET /api/applications/{id}  # Using CandidatureController
PUT /api/applications/{id}
DELETE /api/applications/{id}
```

**Profile**
```
GET /api/etudiant/profile
PUT /api/etudiant/profile
Content-Type: application/json

{
  "phone": "1234567890",
  "address": "123 Main St"
}
```

#### Companies (Entreprises)

**Dashboard**
```
GET /api/entreprise/dashboard
```

**Offers**
```
GET /api/entreprise/offers
POST /api/entreprise/offers
Content-Type: application/json

{
  "title": "Software Developer Intern",
  "description": "Internship description",
  "requirements": "Required skills",
  "start_date": "2024-01-01",
  "end_date": "2024-06-01"
}
PUT /api/entreprise/offers/{id}
DELETE /api/entreprise/offers/{id}
```

**Applications**
```
GET /api/entreprise/candidatures
PUT /api/entreprise/candidatures/{id}/status
Content-Type: application/json

{
  "status": "accepted|rejected|pending"
}
```

**Stages**
```
GET /api/entreprise/stages
POST /api/entreprise/stages
PUT /api/entreprise/stages/{id}
DELETE /api/entreprise/stages/{id}
```

#### Supervisors (Encadrants)

**Dashboard**
```
GET /api/encadrant/dashboard
```

**Stages**
```
GET /api/encadrant/stages
```

**Applications**
```
GET /api/encadrant/candidatures
PUT /api/encadrant/candidatures/{id}/status
```

**Evaluations**
```
GET /api/encadrant/evaluations
POST /api/encadrant/evaluations
Content-Type: application/json

{
  "student_id": 1,
  "stage_id": 1,
  "rating": 5,
  "comments": "Excellent work"
}
PUT /api/encadrant/evaluations/{id}
DELETE /api/encadrant/evaluations/{id}
```

#### Administrators

**Dashboard**
```
GET /api/admin/dashboard
```

**User Management**
```
GET /api/admin/users
GET /api/admin/entreprises
PUT /api/admin/entreprises/{id}/validate
GET /api/admin/encadrants
POST /api/admin/encadrants
```

**Documents**
```
GET /api/admin/documents
GET /api/admin/documents/{id}
PUT /api/admin/documents/{id}
DELETE /api/admin/documents/{id}
```

### Common Resources

#### Offers
```
GET /api/offers          # Public: List all offers
GET /api/offers/{id}     # Public: Show specific offer
POST /api/offers         # Companies only
PUT /api/offers/{id}     # Companies only
DELETE /api/offers/{id}  # Companies only
```

#### Stages
```
GET /api/stages          # Public: List all stages
GET /api/stages/{id}     # Public: Show specific stage
POST /api/stages         # Companies only
PUT /api/stages/{id}     # Companies only
DELETE /api/stages/{id}  # Companies only
```

#### Applications
```
GET /api/applications    # Students: Their applications, Companies: Received applications
GET /api/applications/{id}
PUT /api/applications/{id}  # Update status (Companies/Supervisors)
DELETE /api/applications/{id}  # Students only
```

## Response Format

All API responses follow a consistent format:

**Success Response:**
```json
{
  "success": true,
  "data": {
    // Response data
  },
  "message": "Operation successful"
}
```

**Error Response:**
```json
{
  "success": false,
  "message": "Error description",
  "errors": {
    "field": ["Error details"]
  }
}
```

## Error Codes

- 200: Success
- 201: Created
- 400: Bad Request
- 401: Unauthorized
- 403: Forbidden
- 404: Not Found
- 422: Validation Error
- 500: Internal Server Error

## Rate Limiting

API requests are rate-limited to prevent abuse. Contact administrators for higher limits if needed.

## Support

For API support or questions, please contact the development team.