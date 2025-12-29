# 🎯 Skill Exchange Platform

Platform berbagi dan pertukaran keahlian antar pengguna dengan fitur manajemen konten lengkap.

![Laravel](https://img.shields.io/badge/Laravel-12.x-red.svg)
![PHP](https://img.shields.io/badge/PHP-8.2+-blue.svg)
![License](https://img.shields.io/badge/License-MIT-green.svg)

---

## 📋 Deskripsi

**Skill Exchange** adalah aplikasi web yang memungkinkan pengguna untuk berbagi keahlian, mencari partner belajar, dan mengelola portofolio serta tujuan pembelajaran mereka. Aplikasi ini dilengkapi dengan panel admin untuk manajemen konten secara menyeluruh.

---

## 🛠️ Teknologi yang Digunakan

| Kategori               | Teknologi              |
| ---------------------- | ---------------------- |
| **Backend Framework**  | Laravel 12.x           |
| **Bahasa Pemrograman** | PHP 8.2+               |
| **Database**           | SQLite / MySQL         |
| **Authentication**     | Laravel Sanctum        |
| **Frontend**           | Blade Templates + Vite |
| **Styling**            | CSS                    |
| **Package Manager**    | Composer & NPM         |

---

## ✨ 6 Fitur CRUD Utama

### 1. 📝 **Posts (Postingan)**

Pengguna dapat membuat postingan untuk menawarkan atau mencari keahlian tertentu.

| Operasi    | Deskripsi                                                                                |
| ---------- | ---------------------------------------------------------------------------------------- |
| **Create** | Membuat postingan baru dengan tipe "open" (menawarkan skill) atau "need" (mencari skill) |
| **Read**   | Melihat daftar semua postingan di dashboard dengan filter dan pencarian                  |
| **Update** | Mengedit postingan yang sudah dibuat                                                     |
| **Delete** | Menghapus postingan sendiri atau oleh admin                                              |

---

### 2. 💼 **Portfolios (Portofolio)**

Showcase keahlian dan proyek yang pernah dikerjakan pengguna.

| Operasi    | Deskripsi                                                             |
| ---------- | --------------------------------------------------------------------- |
| **Create** | Menambah portofolio dengan judul, deskripsi, link, dan skills terkait |
| **Read**   | Melihat daftar portofolio di halaman profil                           |
| **Update** | Mengedit detail portofolio                                            |
| **Delete** | Menghapus portofolio beserta file terkait                             |

---

### 3. 🎯 **Learning Goals (Tujuan Pembelajaran)**

Pengguna dapat menetapkan dan melacak target pembelajaran.

| Operasi    | Deskripsi                                                            |
| ---------- | -------------------------------------------------------------------- |
| **Create** | Membuat tujuan pembelajaran baru dengan target tanggal dan status    |
| **Read**   | Melihat daftar tujuan pembelajaran dengan filter status              |
| **Update** | Mengupdate progress dan status (not_started, in_progress, completed) |
| **Delete** | Menghapus tujuan pembelajaran                                        |

---

### 4. 🏷️ **Skills (Keahlian)**

Manajemen keahlian/skill yang tersedia di platform (Admin Only).

| Operasi    | Deskripsi                                          |
| ---------- | -------------------------------------------------- |
| **Create** | Admin menambah skill baru dengan nama dan kategori |
| **Read**   | Melihat daftar semua skills yang tersedia          |
| **Update** | Admin mengedit detail skill                        |
| **Delete** | Admin menghapus skill (jika tidak digunakan)       |

---

### 5. 📚 **Topics (Topik)**

Kategori topik untuk mengelompokkan postingan (Admin Only).

| Operasi    | Deskripsi                   |
| ---------- | --------------------------- |
| **Create** | Admin membuat topik baru    |
| **Read**   | Melihat daftar semua topik  |
| **Update** | Admin mengedit detail topik |
| **Delete** | Admin menghapus topik       |

---

### 6. 👥 **Users (Pengguna)**

Manajemen akun pengguna oleh administrator.

| Operasi    | Deskripsi                                             |
| ---------- | ----------------------------------------------------- |
| **Create** | Admin membuat akun pengguna baru                      |
| **Read**   | Admin melihat daftar semua pengguna                   |
| **Update** | Admin mengedit data pengguna (nama, email, role, dll) |
| **Delete** | Admin menghapus akun pengguna                         |

---

## 🔄 Flow Penggunaan Aplikasi

```
┌─────────────────────────────────────────────────────────────┐
│                     LANDING PAGE (/)                        │
│                    [Login] [Register]                       │
└─────────────────────────────────────────────────────────────┘
                              │
                              ▼
┌─────────────────────────────────────────────────────────────┐
│                    REGISTER / LOGIN                         │
│              Daftar akun baru atau masuk                    │
└─────────────────────────────────────────────────────────────┘
                              │
              ┌───────────────┴───────────────┐
              │                               │
              ▼                               ▼
┌────────────────────────┐      ┌────────────────────────────┐
│     USER DASHBOARD     │      │      ADMIN DASHBOARD       │
│  • Browse Posts        │      │  • Statistik Platform      │
│  • Create Posts        │      │  • Manage Users            │
│  • Filter & Search     │      │  • Manage Posts            │
└────────────────────────┘      │  • Manage Portfolios       │
              │                 │  • Manage Skills           │
              ▼                 │  • Manage Topics           │
┌────────────────────────┐      └────────────────────────────┘
│    USER FEATURES       │
├────────────────────────┤
│ 📝 Manage Posts        │
│ 💼 Manage Portfolios   │
│ 🎯 Learning Goals      │
│ 👤 Edit Profile        │
│ 🏷️ Manage Skills       │
└────────────────────────┘
```

### Alur Pengguna Biasa:

1. **Register/Login** - Buat akun atau masuk ke sistem
2. **Dashboard** - Lihat semua postingan dari pengguna lain
3. **Create Post** - Buat postingan untuk menawarkan atau mencari skill
4. **Profile** - Kelola profil, tambah portfolio, dan kelola skills pribadi
5. **Learning Goals** - Tetapkan dan lacak target pembelajaran

### Alur Administrator:

1. **Login** - Masuk dengan akun admin
2. **Admin Dashboard** - Lihat statistik platform
3. **Manage Data** - Kelola users, posts, portfolios, skills, dan topics

---

## 🚀 Cara Instalasi

### Prerequisites

-   **PHP >= 8.2.12** (Tested and compatible with PHP 8.2.12+)
-   Composer (latest version)
-   Node.js & NPM (Node 16+ recommended)
-   Git

### Langkah Instalasi

#### 1. Clone Repository

```bash
git clone https://github.com/USERNAME/skill-exchange.git
cd skill-exchange
```

#### 2. Install Dependencies

```bash
# Install PHP dependencies
composer install

# Install Node.js dependencies
npm install
```

#### 3. Konfigurasi Environment

```bash
# Copy file environment
cp .env.example .env

# Generate application key
php artisan key:generate
```

#### 4. Setup Database

**Opsi 1: MySQL (Recommended)**

```bash
# 1. Buat database MySQL
mysql -u root -p
CREATE DATABASE db_skill_exchange;
EXIT;

# 2. Konfigurasi sudah ada di .env (pastikan sesuai dengan setup MySQL Anda)
# DB_CONNECTION=mysql
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=db_skill_exchange
# DB_USERNAME=root
# DB_PASSWORD=
```

**Opsi 2: SQLite (Alternative)**

```bash
# Ubah DB_CONNECTION di .env menjadi sqlite
# DB_CONNECTION=sqlite

# Buat file database SQLite
touch database/database.sqlite
# Untuk Windows PowerShell gunakan:
# New-Item database/database.sqlite -ItemType File
```

#### 5. Jalankan Migrasi & Seeder

```bash
# Jalankan migrasi database
php artisan migrate

# (Opsional) Jalankan seeder untuk data dummy
php artisan db:seed
```

#### 6. Build Assets

```bash
# Development
npm run dev

# Atau untuk production
npm run build
```

#### 7. Jalankan Aplikasi

```bash
php artisan serve
```

Aplikasi akan berjalan di: **http://localhost:8000**

---

## 📁 Struktur Folder Utama

```
skill-exchange/
├── App/
│   ├── Http/Controllers/     # Controller untuk logic aplikasi
│   ├── Models/               # Model Eloquent (User, Post, Skill, dll)
│   └── ...
├── database/
│   ├── migrations/           # File migrasi database
│   └── seeders/              # Seeder untuk data awal
├── resources/
│   └── views/                # Blade templates
├── routes/
│   └── web.php               # Definisi routing
└── public/                   # Assets publik
```

---

## 🔐 Akun Default (Setelah Seeding)

| Role  | Email             | Password |
| ----- | ----------------- | -------- |
| Admin | admin@example.com | password |
| User  | user@example.com  | password |

> ⚠️ **Catatan**: Ubah password default setelah instalasi untuk keamanan.

---

## 📄 REST API Endpoints

Aplikasi ini juga menyediakan REST API untuk akses data secara programmatic:

| Endpoint              | Method | Deskripsi                   |
| --------------------- | ------ | --------------------------- |
| `/api/posts`          | GET    | Daftar semua postingan      |
| `/api/portfolios`     | GET    | Daftar semua portofolio     |
| `/api/learning-goals` | GET    | Daftar semua learning goals |
| `/api/users`          | GET    | Daftar semua pengguna       |
| `/api/skills`         | GET    | Daftar semua skills         |
| `/api/topics`         | GET    | Daftar semua topics         |

---

## 📝 License

This project is licensed under the MIT License.
