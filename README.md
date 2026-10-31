# Student Management System (SMS EduPortal)

A modern, full-featured web-based **Student Management System** developed with **PHP 8**, **Laravel 9**, **MySQL (SQL)**, and styled after a **Canva UI/UX Design Blueprint**.

---

## 🎨 Phase 1: Canva UI/UX Design System

The application interface is styled after a Canva design blueprint:
- **Visual Mockups**: High-resolution Canva presentation layouts for Executive Dashboard and Individual Student Academic Profile.
- **Color Palette Tokens**:
  - `Deep Navy` (`#1E1B4B`) — Sidebar navigation rail
  - `Electric Indigo` (`#4F46E5`) — Brand primary accent and active actions
  - `Ocean Cyan` (`#06B6D4` / `#0D9488`) — Analytics and trends
  - `Emerald Green` (`#10B981`) — Success tags, 90%+ attendance, paid status
  - `Warm Gold` (`#F59E0B`) — Dean's list tags and partial invoices
  - `Crisp Cloud` (`#F8FAFC`) — Content canvas background
- **Interactive UI Artifact**: Live prototype with tab switcher and 1-click HEX copier.

---

## 🚀 Phase 2: Complete Laravel Implementation

### Core Modules & Features

1. **Executive Analytics Dashboard (`/`)**
   - KPI metric cards: Total Students, Active Courses, Total Fees Collected, Today's Attendance Rate.
   - Monthly Student Enrollment Trends bar chart (Jul–Oct).
   - Recent Student Registrations table with avatars, roll numbers, department badges, and quick action links.
   - Quick operations shortcuts.

2. **Student Directory & Management (`/students`)**
   - Filterable student roster (live search by name/email/roll no, department filter, enrollment status filter).
   - Full CRUD: Register student with validation, Edit profile, and Delete.
   - Auto-enrollment into semester-appropriate department courses upon registration.

3. **Student Academic Profile (`/students/{id}`)**
   - Hero profile banner with roll number, department, semester, tags (`Top Performer`, `Dean's List`, `Active`).
   - SVG Circular Radial Donut Gauge displaying overall attendance rate (e.g., `96%`).
   - Semester Examination Grades Table with letter grades (`A+`, `A`, `B+`), GPA point values, and faculty remarks.
   - Enrolled Courses cards with credit weights and instructors.
   - Fee invoice history and modal for course enrollment and grade recording.

4. **Printable Student ID Card (`/students/{id}/id-card`)**
   - High-fidelity dual-sided student badge (Front & Back) with barcode simulation, school crest, emergency contacts, and print stylesheet.

5. **Courses & Curriculum (`/courses`)**
   - Department-based subject catalog with credit points, semester assignment, and instructor details.
   - Real-time capacity bar showing enrolled vs available seats.
   - Course detail roster displaying all enrolled students.

6. **Daily Attendance Register (`/attendance`)**
   - Filter attendance by course and calendar date.
   - Session participation statistics: Present, Absent, Late, Excused, and percentage rate.
   - 1-Click bulk helpers: `Mark All Present`, `Mark All Absent`.

7. **Examinations & Gradebook (`/grades`)**
   - Assessment tracking: Final Exams, Midterms, Assignments, Quizzes.
   - Auto-calculation of letter grades (`A+` to `F`) and GPA points (`4.00` scale).

8. **Fees & Billing Office (`/fees`)**
   - Financial summaries: Total Billed, Total Collected, and Outstanding Balance.
   - Filter invoices by status (`Paid`, `Partial`, `Unpaid`).
   - Payment recording modal supporting multiple payment channels (Online, Wire Transfer, Cash, Cheque).
   - Official printable fee receipt (`/fees/{id}/receipt`) with institutional header, itemized breakdown, and verified bursar stamp.

---

## 🛠️ Technology Stack & Environment

- **Backend**: PHP 8.0.30, Laravel Framework 9.52.23
- **Database**: MySQL (Database: `student_management`)
- **Frontend**: Blade Templating, Tailwind CSS, Google Fonts (`Plus Jakarta Sans` & `Inter`), SVG Icons
- **Server**: Laravel Built-in Artisan Server

---

## 📋 Database Schema & Relationships

- `departments` ──< `students` (1 to Many)
- `departments` ──< `courses` (1 to Many)
- `students` >──< `courses` (Many to Many via `enrollments`)
- `students` ──< `attendances` (1 to Many)
- `students` ──< `grades` (1 to Many)
- `students` ──< `fee_invoices` (1 to Many)

---

## 💻 How to Run the Project

The application is already migrated, seeded, and actively running on your system:

### 1. Database Connection
Ensure MySQL is running (e.g. via XAMPP Control Panel on port 3306). The `.env` file is pre-configured:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=student_management
DB_USERNAME=root
DB_PASSWORD=
```

### 2. Start Application Server
You can launch the server anytime using the workspace wrapper:
```cmd
artisan.cmd serve --port=8000
```
Open **[http://127.0.0.1:8000](http://127.0.0.1:8000)** in your web browser.

### 3. Convenience CLI Wrappers
You can run PHP, Composer, and Artisan commands directly in the project folder without manual PATH setup:
```cmd
php.bat -v
composer.bat -V
artisan.cmd migrate:status
```
