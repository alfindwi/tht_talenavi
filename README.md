# 📝 Talenavi - Backend Developer Take Home Test

Ini adalah hasil pengerjaan untuk tes praktik Backend Developer dari Talenavi, diselesaikan menggunakan **Laravel 12** dan **PostgreSQL**.

## ✅ Fitur yang Diselesaikan

1. **Create Todo**  
   Endpoint untuk menambahkan todo baru.

2. **Export Todo ke Excel**  
   Endpoint untuk mengekspor todo berdasarkan filter ke dalam file Excel.

3. **Chart Data**  
   Endpoint untuk mengambil data summary (status, priority, assignee) dalam format JSON untuk kebutuhan grafik.

---

## 🚀 Cara Menjalankan Project

### 1. Clone Repository
```bash
git clone https://github.com/username/nama-project.git
cd nama-project
```

### 2. Install Dependencies
```bash
composer install
```

### 3. Copy File Environment dan Konfigurasi

```bash
cp .env.example .env
```
### 4. Atur .env (contoh konfigurasi PostgreSQL)
```bash
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=namadb
DB_USERNAME=username
DB_PASSWORD=password
```
### 5. Generate App Key
```bash
php artisan key:generate
```

### 6. Jalankan Migrasi
```bash
php artisan migrate
```
### 7. Jalankan Server
```bash
php artisan serve
```
