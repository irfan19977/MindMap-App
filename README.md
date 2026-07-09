# 🧠 MindMap App

**MindMap App** adalah platform pembelajaran berbasis web yang membantu pengguna memahami materi secara bertahap (*step by step*) melalui **Mind Map**, latihan soal, kuis interaktif, sistem *unlock* materi, dan **AI Learning Assistant**. Aplikasi ini dirancang untuk memberikan pengalaman belajar yang lebih terstruktur, interaktif, dan efektif.

---

## 👥 Tim Pengembang

| No | Nama |
|----|-------------------------------|
| 1. | **Irfan Adi Prastyo** |
| 2. | **Faishal Danurweda Bisma Wibowo** |
| 3. | **Muhammad Fadhli Robbi Elhami** |
| 4. | **Arkan Thaariq Asadullah** |
| 5. | **Muhammad Mishaal** |

---

## ✨ Fitur

- 🧠 **Interactive Mind Map** – Membuat dan mempelajari materi menggunakan visualisasi peta konsep.
- 📚 **Structured Learning** – Materi disusun secara bertahap (*step by step*).
- 🔓 **Unlock Materi** – Materi selanjutnya terbuka setelah pengguna menyelesaikan materi sebelumnya.
- 📝 **Latihan Soal** – Menguji pemahaman pengguna melalui latihan interaktif.
- 🎯 **Quiz** – Evaluasi pembelajaran pada setiap materi.
- 🤖 **AI Learning Assistant** – Chat AI yang dapat menjawab pertanyaan seputar materi pembelajaran.
- 📈 **Learning Progress** – Memantau perkembangan belajar pengguna.
- 💾 **Auto Save** – Menyimpan perubahan secara otomatis.
- 📱 **Responsive Design** – Tampilan yang dapat diakses melalui desktop maupun perangkat mobile.

---

## 🗄️ Database Diagram

Rancangan struktur database dapat diakses melalui tautan berikut:

> **DB Diagram:** https://dbdiagram.io/d/PROJEK-LOMBA-6a4f56b54ac62e474c64dc7a

---

## Persyaratan Sistem

Sebelum menginstal aplikasi ini, pastikan sistem Anda memenuhi persyaratan berikut:

- PHP >= 8.1
- Composer
- MySQL/MariaDB atau PostgreSQL
- Web Server (Apache, Nginx, atau Laravel Valet)

## Cara Instalasi

Ikuti langkah-langkah berikut untuk menginstal aplikasi ini di komputer Anda:

### 1. Clone Repository

```bash
git clone https://github.com/username/MindMap-App.git
cd MindMap-App
```

### 2. Install Dependencies

Install dependensi PHP dengan Composer:

```bash
composer install
```

Install dependensi JavaScript dengan NPM:

```bash
npm install
```

### 3. Konfigurasi Environment

Salin file environment example:

```bash
cp .env.example .env
```

Generate application key:

```bash
php artisan key:generate
```

### 4. Konfigurasi Database

Buka file `.env` dan konfigurasi koneksi database Anda:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=mindmap_app
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

### 5. Migrasi Database

Jalankan migrasi database untuk membuat tabel yang diperlukan:

```bash
php artisan migrate:fresh --seed
```

### 6. Jalankan Aplikasi

Jalankan server development:

```bash
php artisan serve
```

Aplikasi akan dapat diakses di `http://localhost:8000`

## Fitur

- ✅ Membuat mind map baru
- ✅ Mengedit dan menghapus mind map
- ✅ Menambahkan node dan sub-node
- ✅ Drag and drop untuk mengatur posisi node
- ✅ Simpan perubahan secara otomatis
- ✅ Export mind map ke berbagai format

## Lisensi

Copyright (c) 2026 **Santri Berkreasi**. Hak cipta dilindungi.

Perangkat lunak ini bersifat proprietary. Dilarang menyalin, memodifikasi, mendistribusikan, atau menggunakan perangkat lunak ini tanpa izin tertulis dari Santri Berkreasi. Lihat file [LICENSE](LICENSE) untuk detail lengkap.
