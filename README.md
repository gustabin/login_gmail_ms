# Secure Login System with Google and Microsoft OAuth

This project is a secure and modern login system built using **PHP**, **JavaScript**, **HTML5**, **CSS3**, **jQuery**, **AJAX**, **MySQL**, and **SweetAlert2**, with support for traditional email/password authentication and OAuth login using **Google** and **Microsoft** accounts.

## 🔐 Features

- Email and password login with hashed credentials.
- OAuth 2.0 login with Google and Microsoft accounts.
- Form validation and sanitization.
- SQL injection protection using prepared statements (`mysqli`).
- SweetAlert2 modals for feedback messages.
- Session management and dashboard redirection.
- Password recovery system with secure token and `PHPMailer`.
- Responsive design with Bootstrap.
- SEO-friendly HTML structure.
- Clean code using software architecture best practices.
- Environment variable support via `vlucas/phpdotenv`.

## 📂 Project Structure

/project-root
│
├── api/
│ ├── google_login.php
│ ├── google_callback.php
│ ├── microsoft_login.php
│ └── microsoft_callback.php
│
├── actions/
│ ├── login.php
│ ├── logout.php
│ ├── forgot_password.php
│ └── reset_password.php
│
├── config/
│ └── db.php
│
├── helpers/
│ ├── sanitize.php
│ └── mailer.php
│
├── public/
│ ├── index.html
│ ├── dashboard.html
│ ├── login.js
│ ├── style.css
│ └── bootstrap.min.css
│
├── .env
├── composer.json
└── README.md


## ⚙️ Setup Instructions

1. **Clone the repository**
   ```bash
   git clone https://github.com/your-username/login-app.git
   cd login-app

composer install

DB_HOST=localhost
DB_NAME=your_db_name
DB_USER=your_user
DB_PASS=your_password

Import the database schema
Use the provided schema.sql file to create the necessary tables in MySQL.

Set up Google and Microsoft OAuth credentials

Create OAuth apps on:

Google Cloud Console

Microsoft Azure Portal

Add your client_id and client_secret to the respective callback files.

Run the project using XAMPP
Make sure Apache and MySQL are running.

Visit
http://localhost/login-app/public/index.html

💬 Feedback and Contributions
Feel free to fork this repository, report issues, or contribute with pull requests. Suggestions and improvements are always welcome!

📄 License
This project is licensed under the MIT License.

