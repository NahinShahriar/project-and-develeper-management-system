# 📦 Project Management System

> Simple Laravel project management app with manual user invite, custom password reset page, profile & tasks management — styled with Bootstrap.

![Laravel](https://img.shields.io/badge/Laravel-8.x-red?style=flat&logo=laravel)
![PHP](https://img.shields.io/badge/PHP-%3E=7.0-blue?logo=php)
<!-- ![License](https://img.shields.io/badge/license-MIT-brightgreen) -->

---

## ✨ Features
- ✅ Admin can manually add users & send set-password email
- ✅ Custom password reset page
- ✅ User login, logout, profile, change password
- ✅ Projects CRUD
- ✅ Tasks CRUD & status updates
- ✅ Clean Bootstrap 5 UI

---

<!-- ## 📸 Screenshots
*(Add real screenshots here)*

| Dashboard | Change Password |
|--|--|
| ![](screenshots/dashboard.png) | ![](screenshots/change_password.png) |

--- -->

## ⚙ Built With
- Laravel 8.x
- PHP >= 7.0
- MySQL / MariaDB
- Blade templates
- Bootstrap 5

---

## 🚀 Getting Started

### 📥 Clone & install
```bash
git clone https://github.com/NahinShahriar/project-management-system.git
cd project-management-system
composer install
###🛠 Setup .env
cp .env.example .env
php artisan key:generate
 ##Edit env
DB_DATABASE=project_management_system
DB_USERNAME=root
DB_PASSWORD=secret

MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_username
MAIL_PASSWORD=your_password
MAIL_FROM_ADDRESS=admin@example.com
MAIL_FROM_NAME="Project Management"

