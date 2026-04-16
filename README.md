# CA Firm Landing Page + Inquiry Management System

A PHP web app built for a CA / Tax consultancy firm. Has a public-facing landing page where clients can submit inquiries, and a full admin panel to manage those inquiries.

Built as part of a PHP Developer Internship assignment.

---

## Tech Used

- **PHP 8.x** — Core PHP, no framework
- **MySQL** — Database
- **PDO** — All DB queries use prepared statements
- **Vanilla CSS + JS** — No libraries, everything written from scratch

---

## Features

### Public Site
- Professional landing page — Hero, Services, Why Us, Testimonials, Contact Form
- Animated number counters in hero section (Intersection Observer)
- WhatsApp floating CTA button
- Inquiry form with client-side + server-side validation
- Form fields repopulate on validation error — user never loses what they typed
- Honeypot anti-spam on inquiry form (silent fake-success for bots)
- Flash success/error messages after form submit

### Admin Panel (`/admin/login.php`)
- Secure login with bcrypt-hashed passwords
- Session regeneration on login (prevents session fixation)
- All admin routes protected by auth guard
- Dashboard with real-time counts: total, new, contacted, closed
- Inquiry list with search (name / email / mobile) and status filter
- **Inline status change** — change status directly from the table, no need to open edit page
- **Export to CSV** — downloads current filtered results as a CSV file (Excel-compatible UTF-8)
- **Change Password** — secure change with old password verification
- Full inquiry edit (all fields + status)
- Delete with confirmation step
- Pagination (15 per page)
- Mobile-responsive sidebar with overlay

---

## Folder Structure

```
CA-Firm-CRM/
├── ca_firm.sql              (run this first to set up the DB)
├── config/
│   └── db.php               (PDO connection)
├── includes/
│   ├── header.php           (public site nav + flash messages)
│   ├── footer.php
│   └── auth_guard.php       (session check for admin pages)
├── assets/
│   ├── css/
│   │   ├── style.css        (public site styles)
│   │   └── admin.css        (admin panel styles)
│   └── js/
│       └── main.js          (logic & initialization)
├── index.php                (public landing page)
├── submit_inquiry.php       (form POST handler)
└── admin/
    ├── login.php
    ├── logout.php
    ├── dashboard.php
    ├── inquiries.php         (list with search & filter)
    ├── edit_inquiry.php
    ├── delete_inquiry.php
    ├── update_status.php     (status change handler)
    ├── export_csv.php        (downloads CSV)
    ├── change_password.php   (admin password change)
    └── includes/
        ├── admin_header.php
        └── admin_footer.php
```

---

## Setup

**1. Import the database**

```bash
mysql -u root -p < ca_firm.sql
```

Or open phpMyAdmin (Import) select `ca_firm.sql`.

**2. Update DB credentials in `config/db.php`**

```php
$user = 'root';
$pass = 'your_password';
```

**3. Start a local server**

```bash
php -S localhost:8000
```

Or use XAMPP / MAMP — place the folder in `htdocs` and access it from there.

**4. Open in browser**

- Public site: `http://localhost:8000`
- Admin login: `http://localhost:8000/admin/login.php`

---

## Admin Login

```
Email:    admin@cafirm.com
Password: Admin@123
```

---

## Notes

- On macOS, use `127.0.0.1` instead of `localhost` in `config/db.php` to avoid the MySQL Unix socket error.
- The bcrypt hash in `ca_firm.sql` was generated with `password_hash('Admin@123', PASSWORD_BCRYPT)` — works out of the box with `password_verify()`.
- CSV export respects the current search and status filter, and includes a UTF-8 BOM so Excel opens it correctly without encoding issues.
- The honeypot field is invisible to real users but bots fill it automatically. If filled, the request is silently fake-succeeded so bots don't retry.
