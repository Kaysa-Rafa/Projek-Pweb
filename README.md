# 🏰 Hive Workshop - Warcraft III Resource Sharing Platform

**Hive Workshop** adalah aplikasi web berbasis **Laravel** yang dirancang sebagai platform komunitas untuk berbagi dan mengunduh resource custom untuk game Warcraft III, seperti Model, Map, Skin, dan Icon.

Project ini dibuat sebagai bagian dari tugas **Pemrograman Web (PWeb)**.

---

## 🚀 Fitur Utama

* **User Authentication**: Sistem Login dan Register yang aman.
* **Resource Management**:
    * Upload file resource (dukungan format `.w3x`, `.mdx`, `.blp`, `.zip`, dll).
    * Auto-Approve system (resource langsung terbit setelah upload).
    * Edit dan Hapus resource sendiri.
    * Download resource dengan tracking jumlah unduhan.
* **Categories**: Pengelompokan resource berdasarkan kategori (Models, Maps, Spells, dll).
* **Dark Mode**: Antarmuka yang nyaman dengan dukungan tema Gelap/Terang (Switchable).
* **Responsive Design**: Tampilan rapi menggunakan **Bootstrap 5**.
* **Admin Dashboard**: Panel khusus admin untuk memantau user dan resource.

---

## 🛠️ Teknologi yang Digunakan

* **Framework**: [Laravel 11](https://laravel.com/)
* **Database**: MySQL / SQLite
* **Frontend**: Blade Templates, Bootstrap 5, FontAwesome
* **Styling**: Custom CSS dengan Dark Mode support

---

## 💻 Cara Instalasi (Localhost)

Ikuti langkah ini untuk menjalankan project di komputer Anda:

1.  **Clone Repositori**
    ```bash
    git clone [https://github.com/Kaysa-Rafa/Projek-Pweb.git](https://github.com/Kaysa-Rafa/Projek-Pweb.git)
    cd Projek-Pweb
    ```

2.  **Install Dependencies**
    ```bash
    composer install
    npm install
    npm run build
    ```

3.  **Setup Environment**
    * Duplikasi file `.env.example` menjadi `.env`.
    * Atur koneksi database di file `.env` (bisa pakai MySQL atau SQLite).

4.  **Generate Key & Storage**
    ```bash
    php artisan key:generate
    php artisan storage:link
    ```

5.  **Migrasi & Seeding Database**
    (Ini akan membuat tabel dan mengisi data dummy awal)
    ```bash
    php artisan migrate:fresh --seed
    ```

6.  **Jalankan Server**
    ```bash
    php artisan serve
    ```
    Buka browser dan akses: `http://127.0.0.1:8000`

---

## 🔑 Akun Demo (Seeder)

Setelah menjalankan `php artisan migrate:fresh --seed`, Anda bisa login menggunakan akun berikut:

| Role | Email | Password |
| :--- | :--- | :--- |
| **Admin** | `admin@hiveworkshop.com` | `password` |
| **User** | `user@hiveworkshop.com` | `password` |

---

## 📸 Struktur Folder Penting

* `app/Models` - Definisi database (Resource, User, Category).
* `app/Http/Controllers` - Logika utama (ResourceController, dll).
* `resources/views` - Tampilan antarmuka (Blade).
* `database/migrations` - Struktur tabel database.
* `routes/web.php` - Definisi rute URL.

---

## 👤 Author

* **Kaysa Rafa Aditya Putra Negara**
* Project PWeb 2025

---