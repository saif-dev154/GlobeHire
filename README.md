<div align="center">

# 🌐 GlobeHire

### Global Job Recruitment System

[![Laravel](https://img.shields.io/badge/Laravel-11-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.2+-777BB4?style=for-the-badge&logo=php&logoColor=white)](https://php.net)
[![MySQL](https://img.shields.io/badge/MySQL-8.0-4479A1?style=for-the-badge&logo=mysql&logoColor=white)](https://mysql.com)
[![Bootstrap](https://img.shields.io/badge/Bootstrap-5-7952B3?style=for-the-badge&logo=bootstrap&logoColor=white)](https://getbootstrap.com)
[![License](https://img.shields.io/badge/License-MIT-green?style=for-the-badge)](LICENSE)

**A full-cycle, multi-role recruitment management platform built for global hiring workflows.**

[Features](#-features-by-role) · [Tech Stack](#-tech-stack) · [Installation](#-installation) · [Workflow](#-workflow) · [Screenshots](#-screenshots)

</div>

---

## 📌 Overview

**GlobeHire** is a comprehensive end-to-end recruitment system that manages the entire hiring lifecycle — from job posting and candidate application all the way through interview scheduling, digital contract signing, visa document processing, and international flight coordination.

The platform supports **4 distinct user roles**, each with a dedicated dashboard, tailored permissions, and a purpose-built interface. Real-time status updates are powered by AJAX for a smooth, responsive experience.

---

## 👥 Features by Role

<details>
<summary><strong>🔴 Admin — Full system control</strong></summary>

<br>

- Create and manage **Employer** and **Agent** accounts
- Activate or deactivate any user account
- Delete users from the system
- View all registered users: Candidates, Agents, Employers
- Access platform-wide settings and reports

</details>

<details>
<summary><strong>🟡 Employer — Manage jobs, candidates & contracts</strong></summary>

<br>

**Jobs**
- Post and manage job listings with skills, salary, visa sponsorship, and agent assignment

**Interviews**
- View candidates who passed interviews
- Shortlist candidates for hiring

**Contracts**
- Create employment contracts for shortlisted candidates
- Review digitally signed contracts
- Approve or reject signed contracts

</details>

<details>
<summary><strong>🟢 Agent — Handle applications, interviews & logistics</strong></summary>

<br>

**Applications**
- View and manage job applications assigned by the system
- Shortlist or reject candidates with remarks

**Interviews**
- Schedule video interviews with meeting links
- Mark outcomes: **Pass**, **Fail**, or **Postpone**
- View upcoming and past interviews with real-time progress

**Visa Processing**
- Review 14 visa document fields submitted by candidates
- Approve or reject each document individually with remarks

**Flight Management**
- Schedule flights with airline details, tickets, and sponsorship letters
- Track and update travel status in real time

</details>

<details>
<summary><strong>🔵 Candidate — Apply, track & travel</strong></summary>

<br>

**Job Search**
- Browse all active international job listings
- Apply with a full profile, resume, and cover letter

**Application Tracking**
- Track status: Pending → Shortlisted → Interview → Hired
- View interview schedule and results

**Contracts**
- Receive and review employment contracts
- Sign contracts digitally using a canvas-based signature pad

**Visa & Travel**
- Upload visa documents after contract approval
- Track review status per document
- View assigned flight details and live travel status

</details>

---

## 🏗 System Architecture

```
┌──────────────────────────────────────────────────────────────┐
│                       GlobeHire Platform                     │
├────────────┬──────────────┬──────────────┬───────────────────┤
│   Admin    │   Employer   │    Agent     │     Candidate     │
│ Dashboard  │  Dashboard   │  Dashboard   │    Dashboard      │
├────────────┴──────────────┴──────────────┴───────────────────┤
│               Laravel 11 — Routes · Controllers · Models     │
├──────────────────────────────────────────────────────────────┤
│                        MySQL 8.0 Database                    │
└──────────────────────────────────────────────────────────────┘
```

| Concern | Approach |
|---|---|
| Authentication | Laravel Auth + Role-based Middleware |
| Real-time UI | AJAX (no full-page reloads) |
| Authorization | Role-based Access Control (RBAC) |
| Digital Signatures | Canvas-based signature capture |
| File Uploads | Laravel Storage (public disk) |

---

## 🛠 Tech Stack

| Layer | Technology |
|---|---|
| Backend Framework | Laravel 11 |
| Language | PHP 8.2+ |
| Database | MySQL 8.0 |
| Frontend | HTML5, CSS3, Bootstrap 5 |
| Interactivity | Vanilla JavaScript + AJAX |
| Templating | Blade (Laravel) |
| Authentication | Custom Auth + Role Middleware |

---

## ⚙️ Installation

### Prerequisites

- PHP >= 8.2
- Composer
- MySQL 8.0+
- Node.js & NPM *(optional, for assets)*

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

# 5. Configure your database in .env
# DB_DATABASE=globehire
# DB_USERNAME=root
# DB_PASSWORD=

# 6. Run migrations and seeders
php artisan migrate --seed

# 7. Link storage
php artisan storage:link

# 8. Start the development server
php artisan serve
```

Visit `http://127.0.0.1:8000`

### Default Seeded Accounts

| Role | Email | Password |
|---|---|---|
| Admin | admin@globehire.com | password |
| Employer | employer@globehire.com | password |
| Agent | agent@globehire.com | password |
| Candidate | candidate@globehire.com | password |

---

## 🗄 Database Design

```
users
  └── id, name, email, role, status, password

jobs
  └── id, employer_id, title, location, description,
      required_skills, salary, job_type, status,
      application_start_date, application_deadline,
      visa_sponsor, agent_ids

applications
  └── id, job_id, candidate_id, assigned_agent_id,
      status, full_name, resume_path, skills, remarks

interviews
  └── id, application_id, agent_id,
      interview_date, start_time, end_time,
      meeting_link, status (pending/pass/fail/postponed), remarks

contracts
  └── id, interview_id, employer_id,
      contract_date, start_date, deadline, salary,
      body, status (created/signed/approved/rejected),
      signature_path, remarks

visa_documents
  └── id, candidate_id, contract_id,
      passport_scan, national_id, passport_photo,
      education_certificates, police_clearance,
      medical_certificate, offer_letter, resume_cv,
      [field]_status, [field]_remarks, status

flight_schedules
  └── id, visa_document_id,
      airline, flight_number,
      departure_airport, arrival_airport,
      departure_datetime, arrival_datetime,
      ticket_path, sponsorship_letter_path,
      travel_status
```

---

## 🔄 Workflow

```
1.  Admin creates Employer & Agent accounts
           ↓
2.  Employer posts a Job (with assigned agents)
           ↓
3.  Candidate browses & applies
           ↓
4.  Agent reviews applications → Shortlist / Reject
           ↓
5.  Agent schedules Interview → Pass / Fail / Postpone
           ↓
6.  Employer reviews passed candidates → Shortlists for hiring
           ↓
7.  Employer creates Contract
           ↓
8.  Candidate digitally signs Contract
           ↓
9.  Employer approves or rejects signed Contract
           ↓
10. Candidate uploads 14 Visa Documents
           ↓
11. Agent reviews each Visa Document field
           ↓
12. Agent schedules Flight (ticket + sponsorship letter)
           ↓
13. Candidate tracks Flight Status in real time
```

---

## 📸 Screenshots

| Admin Dashboard | Employer Dashboard |
|---|---|
| ![Admin](screenshots/admin-dashboard.png) | ![Employer](screenshots/employer-dashboard.png) |

| Agent Dashboard | Candidate Dashboard |
|---|---|
| ![Agent](screenshots/agent-dashboard.png) | ![Candidate](screenshots/candidate-dashboard.png) |

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

- ✅ Role-based middleware protecting all routes
- ✅ CSRF protection on all forms
- ✅ Authenticated file access for visa documents
- ✅ Input validation on all user-submitted data
- ✅ Duplicate application prevention
- ✅ Ownership checks on all sensitive resources

---

## 🚀 Future Enhancements

- [ ] Email & SMS notifications at each workflow stage
- [ ] Real-time chat between Agent and Candidate
- [ ] Analytics dashboard for Admin
- [ ] PDF export for contracts and reports
- [ ] API support for mobile app integration
- [ ] Google OAuth login

---

## 🧑‍💻 Author

**Muhammad Saif Ur Rehman**

[![LinkedIn](https://img.shields.io/badge/LinkedIn-Connect-0A66C2?style=flat-square&logo=linkedin&logoColor=white)](https://linkedin.com/in/muhammad-saif-ur-rehman-983775341)
[![GitHub](https://img.shields.io/badge/GitHub-Follow-181717?style=flat-square&logo=github&logoColor=white)](https://github.com/saif-dev154)
[![Fiverr](https://img.shields.io/badge/Fiverr-Hire%20Me-1DBF73?style=flat-square&logo=fiverr&logoColor=white)](https://fiverr.com)

> CEO & Founder of **SkillLeo SMC PVT LTD** · Laravel & PHP Developer · 6+ years experience

---

## 📄 License

This project is licensed under the [MIT License](LICENSE).

---

<div align="center">

Made with ❤️ by **Muhammad Saif Ur Rehman** 

*Laravel 11 · Bootstrap 5 · MySQL 8 · PHP 8.2*

</div>