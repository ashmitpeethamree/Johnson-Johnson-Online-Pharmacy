# Online Pharmacy — Full Working Project

## Overview
This project is a full, minimal but working online pharmacy web application using:
- PHP (PDO) for server-side logic, authentication, validation, CRUD
- HTML + CSS + JS for frontend; client-side validation + CSRF token fetch
- Session-based cart, orders, prescription upload handling
- CSRF protection, password hashing, prepared statements

**Important:** You uploaded your database file to: `/mnt/data/pharmacy.sql`.
Import it into MySQL/MariaDB first (the provided SQL will create tables expected by the app):
```
mysql -u root -p < /mnt/data/pharmacy.sql
```

## Install / Run (local dev)
1. Import database: `mysql -u root -p < /mnt/data/pharmacy.sql`
2. Adjust DB creds in `src/config.php`.
3. Place `public/` under your webroot (e.g. `/var/www/html/online_pharmacy/public`)
   and keep `src/` and `assets/` accessible by PHP (one level above or inside public with include paths updated).
4. Ensure `uploads/` is writable by webserver.
5. Visit `http://localhost/online_pharmacy/public/index.html`

## Files
- public/: frontend pages
- assets/: css/js
- src/: PHP backend endpoints and helpers
- uploads/: uploaded prescriptions (must be writable)
- sql_import.txt: path to the uploaded SQL file

## Notes
- This is a demonstration app; audit security (CSP, rate limiting, full validation) before production.
- The code uses prepared statements and basic hardening, but further production hardening is required.
