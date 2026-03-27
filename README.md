 # 🌐 GlobeHire — Global Job Recruitment System

<div align="center">

![GlobeHire Banner](https://img.shields.io/badge/GlobeHire-Recruitment%20System-6C63FF?style=for-the-badge&logo=globe&logoColor=white)

[![Laravel](https://img.shields.io/badge/Laravel-11-FF2D20?style=flat-square&logo=laravel&logoColor=white)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.2+-777BB4?style=flat-square&logo=php&logoColor=white)](https://php.net)
[![MySQL](https://img.shields.io/badge/MySQL-8.0-4479A1?style=flat-square&logo=mysql&logoColor=white)](https://mysql.com)
[![Bootstrap](https://img.shields.io/badge/Bootstrap-5-7952B3?style=flat-square&logo=bootstrap&logoColor=white)](https://getbootstrap.com)
[![AJAX](https://img.shields.io/badge/AJAX-Real--Time-F7DF1E?style=flat-square&logo=javascript&logoColor=black)](https://developer.mozilla.org/en-US/docs/Web/Guide/AJAX)

**A full-cycle, multi-role recruitment management platform built for global hiring workflows.**

</div>

---

## 📋 Table of Contents

- [Overview](#-overview)
- [Features by Role](#-features-by-role)
- [System Architecture](#-system-architecture)
- [Tech Stack](#-tech-stack)
- [Installation](#-installation)
- [Database Design](#-database-design)
- [Workflow](#-workflow)
- [Screenshots](#-screenshots)
- [License](#-license)

---

## 🔍 Overview

**GlobeHire** is a comprehensive end-to-end job recruitment system designed to manage the entire hiring lifecycle — from job posting and candidate application to interviews, contract signing, visa processing, and flight scheduling.

The platform supports **4 distinct user roles**, each with a dedicated dashboard, tailored permissions, and a purpose-built interface. Real-time updates are powered by AJAX, ensuring a smooth and responsive experience for all users.

> Built with **Laravel 11**, **MySQL**, **Bootstrap 5**, and **Vanilla JS/AJAX**.

---

## 👥 Features by Role

### 🔴 Admin
> Full system control and user management.

- Create new **Employer** and **Agent** accounts
- Activate or deactivate any user
- Delete users from the system
- View all registered users: Candidates, Agents, Employers
- Access platform-wide settings and reports

---

### 🟡 Employer
> Manage job listings, review candidates, and handle contracts.

- **Jobs**
  - Post new job listings
  - View and manage all posted jobs

- **Interviews**
  - View candidates who passed interviews
  - Shortlist candidates for hiring

- **Contracts**
  - Create employment contracts for shortlisted candidates
  - Review digitally signed contracts
  - Approve or reject signed contracts

---

### 🟢 Agent
> Handle candidate applications, conduct interviews, and manage post-hire logistics.

- **Applications**
  - View job applications assigned by the system
  - Shortlist or reject candidates

- **Interviews**
  - Schedule and conduct interviews
  - Mark interview outcomes: **Pass**, **Fail**, or **Postpone**
  - View upcoming and past interviews

- **Visa Processing**
  - Review visa documents submitted by shortlisted candidates
  - Approve or flag documents for further review

- **Flight Management**
  - View scheduled, departed, arrived, and cancelled flights
  - Schedule new flights for approved candidates
  - Reschedule existing flights

---

### 🔵 Candidate
> Apply for jobs and track your full hiring journey.

- **Job Search**
  - Browse all available job listings
  - Apply to jobs with a single click

- **Application Tracking**
  - Track application status (Pending, Shortlisted, Rejected)
  - View interview schedule and results (Pass/Fail)

- **Contracts**
  - Receive and review employment contracts
  - Sign contracts digitally
  - Track contract approval status

- **Visa & Travel**
  - Upload visa documents after contract approval
  - Track visa review status
  - View assigned flight details and travel schedule

---

## 🏗 System Architecture

```
┌─────────────────────────────────────────────────────────┐
│                     GlobeHire Platform                  │
├──────────┬──────────────┬──────────────┬────────────────┤
│  Admin   │   Employer   │    Agent     │   Candidate    │
│ Dashboard│  Dashboard   │  Dashboard   │   Dashboard    │
├──────────┴──────────────┴──────────────┴────────────────┤
│                   Laravel 11 Backend                    │
│              (Routes · Controllers · Models)            │
├─────────────────────────────────────────────────────────┤
│                    MySQL Database                       │
└─────────────────────────────────────────────────────────┘
```

### Key Architectural Decisions

| Concern | Approach |
|---|---|
| Authentication | Laravel Auth + Role-based Middleware |
| Real-time UI Updates | AJAX (no full-page reloads) |
| Authorization | Role-based access control (RBAC) |
| Digital Signatures | Canvas-based signature capture |
| File Uploads | Laravel Storage (Visa documents) |

---

## 🛠 Tech Stack

| Layer | Technology |
|---|---|
| **Backend Framework** | Laravel 11 |
| **Language** | PHP 8.2+ |
| **Database** | MySQL 8.0 |
| **Frontend** | HTML5, CSS3, Bootstrap 5 |
| **Interactivity** | Vanilla JavaScript + AJAX |
| **Templating** | Blade (Laravel) |
| **Authentication** | Laravel Breeze / Custom Auth |

---

## ⚙️ Installation

### Prerequisites
- PHP >= 8.2
- Composer
- MySQL 8.0+
- Node.js & NPM (optional, for assets)

### Steps

```bash
# 1. Clone the repository
git clone https://github.com/your-username/globehire.git
cd globehire

# 2. Install PHP dependencies
composer install

# 3. Copy environment file
cp .env.example .env

# 4. Generate application key
php artisan key:generate

# 5. Configure your .env file
# Set DB_DATABASE, DB_USERNAME, DB_PASSWORD

# 6. Run migrations and seeders
php artisan migrate --seed

# 7. Start the development server
php artisan serve
```

Visit `http://127.0.0.1:8000` to access the application.

### Default Users (Seeded)

| Role | Email | Password |
|---|---|---|
| Admin | admin@globehire.com | password |
| Employer | employer@globehire.com | password |
| Agent | agent@globehire.com | password |
| Candidate | candidate@globehire.com | password |

---

## 🗄 Database Design

### Core Entities

```
users              → id, name, email, role, status
jobs               → id, employer_id, title, description, status
applications       → id, job_id, candidate_id, agent_id, status
interviews         → id, application_id, agent_id, scheduled_at, status (upcoming/past/postponed/pass/fail)
contracts          → id, application_id, employer_id, file_path, status (created/signed/approved/rejected)
visa_documents     → id, application_id, candidate_id, document_path, status
flight_schedules   → id, application_id, agent_id, flight_date, status (scheduled/departed/arrived/cancelled/rescheduled)
```

---

## 🔄 Workflow

```
1. Admin creates Employer & Agent accounts
         │
         ▼
2. Employer posts a Job
         │
         ▼
3. Candidate browses & applies to the Job
         │
         ▼
4. Agent reviews Applications → Shortlists or Rejects candidates
         │
         ▼
5. Agent conducts Interview → Pass / Fail / Postpone
         │
         ▼
6. Employer reviews passed candidates → Shortlists for hiring
         │
         ▼
7. Employer creates Contract → Candidate receives it
         │
         ▼
8. Candidate digitally signs Contract
         │
         ▼
9. Employer approves or rejects the signed Contract
         │
         ▼
10. Approved Candidate uploads Visa Documents
         │
         ▼
11. Agent reviews Visa Documents
         │
         ▼
12. Agent schedules Flight for the Candidate
         │
         ▼
13. Candidate tracks Flight Status (Scheduled → Departed → Arrived)
```

---

## 📸 Screenshots

### Candidate Dashboard
![Candidate Dashboard](screenshots/candidate-dashboard.png)

### Agent Dashboard
![Agent Dashboard](screenshots/agent-dashboard.png)

### Employer Dashboard
![Employer Dashboard](screenshots/employer-dashboard.png)

### Admin Dashboard
![Admin Dashboard](screenshots/admin-dashboard.png)

---

## 📁 Project Structure

```
globehire/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/
│   │   │   ├── Employer/
│   │   │   ├── Agent/
│   │   │   └── Candidate/
│   │   └── Middleware/
│   │       └── RoleMiddleware.php
│   └── Models/
├── database/
│   ├── migrations/
│   └── seeders/
├── resources/
│   └── views/
│       ├── admin/
│       ├── employer/
│       ├── agent/
│       └── candidate/
├── routes/
│   └── web.php
└── public/
```

---

## 🔐 Security

- Role-based middleware protecting all routes
- CSRF protection on all forms
- Authenticated file access for visa documents
- Input validation on all user-submitted data

---

## 🚀 Future Enhancements

- [ ] Email & SMS notifications at each workflow stage
- [ ] Real-time chat between Agent and Candidate
- [ ] Analytics dashboard for Admin
- [ ] Mobile-responsive improvements
- [ ] PDF export for contracts and reports
- [ ] API support for mobile app integration

---

## 🧑‍💻 Author

**Your Name**
- GitHub: [@your-username](https://github.com/your-username)
- LinkedIn: [linkedin.com/in/your-profile](https://linkedin.com/in/your-profile)

---

## 📄 License

This project is licensed under the [MIT License](LICENSE).

---

<div align="center">
  Made with ❤️ using Laravel 11 · Bootstrap 5 · MySQL
</div>#   G l o b e H i r e  
 