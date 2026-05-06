# MindMap App

Aplikasi web untuk membuat dan mengelola peta pikiran (mind map) yang dibangun dengan Laravel.

## Persyaratan Sistem

Sebelum menginstal aplikasi ini, pastikan sistem Anda memenuhi persyaratan berikut:

- PHP >= 8.1
- Composer
- MySQL/MariaDB atau PostgreSQL
- Node.js dan NPM (untuk mengompilasi aset frontend)
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
php artisan migrate
```

### 6. Seed Database (Opsional)

Jika Anda ingin mengisi database dengan data contoh:

```bash
php artisan db:seed
```

### 7. Kompilasi Aset Frontend

Kompilasi aset CSS dan JavaScript:

```bash
npm run build
```

### 8. Jalankan Aplikasi

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

Proyek ini dilisensikan under MIT License.
