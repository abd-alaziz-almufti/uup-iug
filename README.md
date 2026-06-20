# UUP-IUG (University User Portal - Islamic University of Gaza)

[![Laravel](https://img.shields.io/badge/Laravel-12.x-FF2D20?style=for-the-badge&logo=laravel)](https://laravel.com)
[![Filament](https://img.shields.io/badge/Filament-4.x-FBAE3C?style=for-the-badge&logo=filamentphp)](https://filamentphp.com)
[![Livewire](https://img.shields.io/badge/Livewire-3.x-FB70A9?style=for-the-badge&logo=livewire)](https://livewire.laravel.com)

A comprehensive student and administrative portal designed for the Islamic University of Gaza (IUG) to streamline academic inquiries, student services, and administrative management.

## 🚀 Features

### 🎓 Student Services
- **🎟️ Advanced Ticket System**: Submit, track, and manage academic inquiries with department-specific routing.
- **📢 Academic Announcements**: Stay updated with the latest news and university announcements.
- **📁 Academic Guides**: Access necessary documents and guides for students.
- **❓ FAQ System**: Quick answers to common student questions.
- **👤 Profile Management**: Manage student profile details and submit edit requests for sensitive information.

### 🛡️ Administrative Portal (Filament-powered)
- **📊 Real-time Dashboard**: Overview of ticket statuses, recent activities, and pending requests.
- **🎫 Ticket Management**: Comprehensive tools for staff to reply to and resolve student inquiries.
- **👥 User & Role Management**: Granular access control using Filament Shield (Roles: Admin, Dean, Faculty, Student, etc.).
- **📋 Content Management**: Manage Announcements, FAQs, Guides, and Academic Data (Colleges, Departments, Courses).

---

## 🛠️ Tech Stack

- **Framework**: [Laravel 12+](https://laravel.com)
- **Admin Panel**: [Filament 4+](https://filamentphp.com)
- **Frontend**: [Livewire 3](https://livewire.laravel.com) & Blade
- **Styling**: [Tailwind CSS](https://tailwindcss.com)
- **Database**: SQLite (Default) / MySQL

---

## ⚙️ Installation

To set up the project locally, follow these steps:

1. **Clone the repository**:
   ```bash
   git clone <repository-url>
   cd uup-iug
   ```

2. **Run the setup script**:
   This project includes a convenient setup script that handles composer installation, environment setup, key generation, and migrations.
   ```bash
   composer setup
   ```

3. **Seeding (Optional)**:
   If you need sample data:
   ```bash
   php artisan db:seed
   ```

---

## 💻 Development

Start the development server with all necessary background processes (Queue, Logs, Vite):

```bash
composer dev
```

This command runs the following concurrently:
- PHP Development Server (`php artisan serve`)
- Queue Listener
- Tail Logs (`php artisan pail`)
- Vite Dev Server (`npm run dev`)

---

## 📄 License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
