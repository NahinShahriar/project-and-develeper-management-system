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

🏗 Migrate database
bash
Copy
Edit
php artisan migrate
If password_resets table is missing:

bash
Copy
Edit
php artisan make:migration create_password_resets_table
Define:

php
Copy
Edit
Schema::create('password_resets', function (Blueprint $table) {
    $table->string('email')->index();
    $table->string('token');
    $table->timestamp('created_at')->nullable();
});
Then:

bash
Copy
Edit
php artisan migrate
🧑‍💻 Seed admin user (optional)
bash
Copy
Edit
php artisan tinker
>>> \App\Models\User::create(['name'=>'Admin','email'=>'admin@example.com','password'=>bcrypt('password')]);
▶ Run the app
bash
Copy
Edit
php artisan serve
Visit: http://127.0.0.1:8000

📌 Main Routes
URL	Purpose
/	Welcome page
/dashboard	Dashboard (after login)
/users	Manage users (admin)
/projects	Manage projects
/tasks	Manage tasks
/profile	View profile
/profile/change-password	Change password
/password/reset/{token}	Set/reset password via email link

✉ Password Reset Flow
Admin adds user (with random password & token)

Sends email with reset link

User clicks → opens custom password_set page

User sets new password → updates in users table

🧩 Planned Next Features
Role & permissions (admin vs user)

Task due dates & reminders

File attachments

Email notifications on updates

📝 License
MIT

✒ Author
Made with ❤️ by Your Nadid

yaml
Copy
Edit

---

✅ **How to use:**
- Copy everything above.
- Save it as: `README.md`  
- Place in your project root (same level as `artisan`, `app/`, etc).
- Customize:
  - Replace `your-username` with your GitHub username.
  - Add real screenshots inside `screenshots/` folder (create it).
  - Change project name if you want.

---

If you'd like:  
> ✅ **“Make also a `.env.example` template & folder tree”**  
Just tell me — and I’ll do it too! 🚀



