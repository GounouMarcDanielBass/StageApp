# 📘 TRAE Project Rules – Internship Management Platform

## 🧠 General Behavior

- Always respond in **English** unless explicitly asked otherwise.
- Act as a **technical co-pilot** with contextual awareness of the internship platform.
- Prioritize **clarity**, **efficiency**, and **security** in all code and architectural suggestions.
- When asked for help, explain your reasoning before providing code or solutions.

## 🧩 Project Scope & Philosophy

- This is **not a basic CRUD app**; it is a **multi-role, workflow-driven platform**.
- The system must reflect **real-world internship processes** with role-specific dashboards, document workflows, and secure communication.
- Emphasize **modular design**, **role-based access control**, and **workflow automation**.

## 👥 User Roles & Logic

Define logic and access boundaries for each role:

### Non-connected Users

- Can access public pages: Home, Offers, About, FAQ.
- Cannot apply for internships or access dashboards.

### Students

- Must complete profile before applying.
- Can upload/download documents (CV, motivation letter, reports).
- Track application status and receive evaluations.

### Companies (Supervisors)

- Must be validated by Admin before posting offers.
- Can manage offers, review applications, and evaluate interns.

### Encadrants (Teachers)

- Validate intermediate reports and final evaluations.
- Communicate with students and companies.

### Administrators

- Full access to all features.
- Manage sessions, users, statistics, and platform settings.

## 🛠️ Technologies & Standards

- **Frontend**: HTML5, CSS3, Bootstrap, JavaScript
- **Backend**: PHP (Laravel)
- **Database**: MySQL
- **Authentication**: JWT
- Use **MVC architecture**, **RESTful APIs**, and **secure session handling**.

## 🔐 Security & Privacy

- Enforce **2FA for administrators**.
- Lock accounts after 5 failed login attempts.
- Encrypt sensitive documents and personal data.
- Comply with **GDPR** and local data protection laws.
- Sessions expire after 30 minutes of inactivity.

## 📁 Document Management

- Max file size: 5 MB
- Accepted formats: PDF, DOCX, JPG, PNG
- Maintain version history and encryption for sensitive files.
- Auto-generate documents (attestation, convention) where applicable.

## 🔄 Workflow Automation

- Internship flow:
  1. Offer published by company → validated by admin
  2. Student applies → company accepts/refuses
  3. Admin assigns encadrant → convention validated
  4. Student submits reports → encadrant validates
  5. Final evaluation → admin closes stage and generates attestation

## 📊 Dashboards & Statistics

- Each role has a **custom dashboard**:
  - Students: personal stats, document tracking
  - Companies: offer history, candidate tracking
  - Encadrants: student progress, evaluation tools
  - Admins: global stats, session management, user control

## 📣 Notifications & Communication

- Use **email + internal alerts** for key events.
- Implement **simple messaging system** between students, encadrants, and companies.
- Notify users of deadlines, evaluations, and document updates.

## 🧪 Testing & Validation

- Write **unit tests** for critical logic (auth, workflows, document handling).
- Use **mocking** for external services (email, document generation).
- Validate edge cases (e.g., expired sessions, invalid file formats).

## 🧭 UI/UX Guidelines

- Public homepage: 4 menus (Home, Offers, About, FAQ), 2 buttons (Login, Signup)
- Logged-in homepage: 5 menus (Home, Offers, Dashboard, FAQ), profile avatar with dropdown (Edit Profile, Settings, Logout)
- Ensure **responsive design**, **accessibility**, and **role-based navigation**

## 🧑‍💻 Developer Etiquette

- Keep code **clean**, **commented**, and **modular**
- Prefer **reusability** and **scalability**
- Ask for clarification when requirements are ambiguous
- Respect cultural context when referencing Cameroonian institutions or workflows

## 🚫 Limitations

- Do not generate unsafe, unethical, or non-compliant code.
- Avoid assumptions—ask for clarification when needed.
- Never expose sensitive data or bypass security protocols.
