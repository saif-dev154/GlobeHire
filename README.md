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
- [Security](#-security)
- [Future Enhancements](#-future-enhancements)
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
