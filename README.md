# CA Firm Landing Page + Inquiry Management System

A PHP web app built for a CA / Tax consultancy firm. Has a public-facing landing page where clients can submit inquiries, and an admin panel to manage those inquiries.

Built as part of a PHP Developer Internship assignment.

---

## Tech Used

- **PHP 8.x** — Core PHP, no framework
- **MySQL** — Database
- **PDO** — For all DB queries (prepared statements throughout)
- **Vanilla CSS + JS** — No libraries, everything written from scratch

---

## What It Does

### Public Side
- Landing page with info about the firm, services offered, and a contact/inquiry form
- Form collects: Full Name, Email, Mobile, City, Service, Message
- Server-side validation on all fields
- Shows a success/error flash message after submission

### Admin Panel (`/admin/login.php`)
- Secure login with bcrypt-hashed passwords
- Session-based auth — all admin routes are protected
- Dashboard showing total, new, contacted, and closed inquiry counts
- Inquiry list with search (name / email / mobile) and status filter
- Pagination (15 per page)
- Edit any inquiry's details and update its status
- Delete with a confirmation step so nothing gets deleted by accident

---

## Folder Structure

```
CA-Firm-CRM/
├── ca_firm.sql              ← run this first to set up the DB
├── config/
│   └── db.php               ← PDO connection, just require() wherever needed
├── includes/
│   ├── header.php           ← public site nav + flash messages
│   ├── footer.php
│   └── auth_guard.php       ← drop this at the top of any admin page
├── assets/
│   ├── css/
│   │   ├── style.css        ← public site styles
│   │   └── admin.css        ← admin panel styles
│   └── js/
│       └── main.js          ← mobile nav toggle, flash dismiss, form validation
├── index.php                ← public landing page
├── submit_inquiry.php       ← handles the form POST
└── admin/
    ├── login.php
    ├── logout.php
    ├── dashboard.php
    ├── inquiries.php
    ├── edit_inquiry.php
    ├── delete_inquiry.php
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

**2. Update DB credentials in `config/db.php`**

```php
$user = 'root';
$pass = 'your_password';
```

**3. Start a local server**

If you have PHP installed:
```bash
php -S localhost:8000
```

Or drop the folder into XAMPP's `htdocs` / MAMP's `htdocs` and access it from there.

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

- If you're on macOS and get a socket error with MySQL, change `localhost` to `127.0.0.1` in `config/db.php` — that forces a TCP connection instead of a Unix socket.
- The bcrypt hash in `ca_firm.sql` was generated with PHP's `password_hash('Admin@123', PASSWORD_BCRYPT)` so it works out of the box with `password_verify()`.
- Flash messages are stored in the session and cleared after being displayed once.
