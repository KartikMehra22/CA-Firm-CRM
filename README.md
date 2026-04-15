# Sharma & Associates — CA Firm CRM

> **PHP Developer Internship Assignment · Round 1**
> A backend-focused web application for a CA / Tax Consultancy company.

---

## Tech Stack

| Layer      | Technology                              |
|------------|-----------------------------------------|
| Language   | Core PHP 8.x (no framework)             |
| Database   | MySQL 8 via PDO, prepared statements    |
| Frontend   | Vanilla HTML5, CSS3, minimal JavaScript |
| Auth       | Session-based, `password_hash` / `password_verify` (bcrypt) |

---

## Project Structure

```
CA-Firm-CRM/
├── ca_firm.sql              ← DB schema + seed admin
├── config/
│   └── db.php               ← PDO connection factory
├── includes/
│   ├── header.php           ← Public site header & nav
│   ├── footer.php           ← Public site footer
│   └── auth_guard.php       ← Admin session guard
├── assets/
│   ├── css/
│   │   ├── style.css        ← Public design system (Navy + Gold)
│   │   └── admin.css        ← Admin panel styles
│   └── js/
│       └── main.js          ← Mobile nav, flash dismiss, validation
├── index.php                ← Public landing page
├── submit_inquiry.php       ← Inquiry form POST handler
└── admin/
    ├── login.php            ← Admin login
    ├── logout.php           ← Session destroy
    ├── dashboard.php        ← Stats: total / new / contacted / closed
    ├── inquiries.php        ← List with search, filter, pagination
    ├── edit_inquiry.php     ← Full CRUD edit + status update
    ├── delete_inquiry.php   ← Confirm + delete
    └── includes/
        ├── admin_header.php ← Sidebar + topbar shell
        └── admin_footer.php ← Closes layout
```

---

## Setup Instructions

### 1. Clone / Copy the project

```bash
git clone <repo-url>
# or extract the ZIP into your htdocs / www / Sites folder
```

### 2. Import the database

```bash
mysql -u root -p < ca_firm.sql
# Or open phpMyAdmin → Import → select ca_firm.sql
```

### 3. Configure database credentials

Open **`config/db.php`** and set your MySQL user and password:

```php
$user = 'root';
$pass = 'your_password_here';
```

### 4. Configure your web server

**Apache (XAMPP / MAMP):**  
Place the project in `htdocs/CA-Firm-CRM/` and ensure `mod_rewrite` is on.

URL paths in this project use absolute `/` roots.  
Recommended: create a virtual host pointing to the project root, e.g. `ca-firm.local`.

**PHP Built-in Server (quick test):**

```bash
cd CA-Firm-CRM
php -S localhost:8000
```

Then visit `http://localhost:8000`

---

## Admin Credentials

| Field    | Value              |
|----------|--------------------|
| URL      | `/admin/login.php` |
| Email    | `admin@cafirm.com` |
| Password | `Admin@123`        |

---

## Features

### Public Site
- ✅ Responsive landing page (Navy + Gold theme)
- ✅ Hero section with stats
- ✅ 6 service cards
- ✅ Why-choose-us section
- ✅ Inquiry form with client + server-side validation
- ✅ Flash success/error message on submission

### Admin Panel
- ✅ Secure login (bcrypt, session regeneration)
- ✅ Protected routes via auth guard
- ✅ Dashboard with 4 real-time stat cards
- ✅ Inquiry list — search by name/email/mobile
- ✅ Filter by status (new / contacted / closed)
- ✅ Pagination (15 per page)
- ✅ Edit all inquiry fields + status
- ✅ Delete with confirmation (POST-confirm pattern)
- ✅ Flash messages throughout
- ✅ Fully mobile-responsive sidebar

---

## Security Notes

- All DB queries use **PDO prepared statements** — no raw SQL interpolation
- Passwords hashed with **`password_hash(PASSWORD_BCRYPT)`**
- Session ID regenerated on login to prevent session fixation
- All user output escaped with `htmlspecialchars`
- `PDO::ATTR_EMULATE_PREPARES = false` enforced
- Users never see raw PHP errors or DB messages

---

*Submitted by: [Your Name] · PHP Developer Internship · April 2026*
