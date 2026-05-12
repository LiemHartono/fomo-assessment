# Fullstack Engineer Assessment - PT FOMO Inovasi Teknologi

Repositori ini berisi solusi untuk tes asesmen Fullstack Engineer yang mencakup implementasi API Toko Online dengan penanganan *concurrency* (*race condition*) serta program CLI berbasis eksplorasi matriks untuk permainan *Hidden Item*.

## Teknologi yang Digunakan
- **Framework:** Laravel 12
- **Bahasa:** PHP 8.2+
- **Database:** MySQL / SQLite
- **Testing:** PHPUnit

---

## Fitur & Implementasi

### Task 1: Online Store API
API ini dirancang untuk menangani sistem pemesanan ber-trafik tinggi pada skenario *flash sale*. 
- **Atomic Transactions:** Menjamin data `Order` dan `OrderItem` tersimpan secara utuh atau dibatalkan sepenuhnya jika terjadi kegagalan proses.
- **Race Condition Handling:** Menggunakan mekanisme **Pessimistic Locking** (`lockForUpdate`) di dalam *database transaction* untuk memastikan stok produk tidak pernah bernilai negatif meskipun diakses secara bersamaan oleh banyak pengguna (*concurrent requests*).
- **Standardized Response:** Menggunakan format pesan JSON dengan kode status HTTP yang sesuai (`201 Created` untuk sukses, `422 Unprocessable Entity` untuk validasi/stok habis).

### Task 2: Hidden Item Game (CLI)
Program berbasis terminal untuk mencari seluruh kemungkinan koordinat item tersembunyi berdasarkan aturan navigasi dinamis.
- **Dynamic Pathfinding Logic:** Menelusuri seluruh kombinasi pergerakan langkah yang valid (Utara $A \ge 1$, Timur $B \ge 1$, dan Selatan $C \ge 1$) dari titik awal tanpa menabrak rintangan (`#`) untuk menghasilkan daftar kemungkinan titik akhir.
- **Grid Visualization:** Menampilkan visualisasi peta *grid* secara otomatis di terminal dengan menyematkan simbol `$` pada setiap titik lokasi item yang valid (Poin Bonus).

---

## Cara Instalasi

1. **Clone repositori:**
   ```bash
   git clone https://github.com/LiemHartono/fomo-assessment.git
   cd fomo-assessment
   ```

2. **Instal dependensi:**
   ```bash
   composer install
   ```

3. **Konfigurasi Environment:**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
   *(Pastikan Anda telah menyesuaikan kredensial database pada file `.env`)*

4. **Migrasi & Seeding Database:**
   ```bash
   php artisan migrate
   php artisan db:seed --class=ProductSeeder
   ```

---

## Cara Menjalankan Tes & Program

### 1. Menjalankan Functional Test (Task 1)
Pengujian otomatis untuk memvalidasi logika penanganan pemesanan dan batas bawah stok produk saat *flash sale*.
```bash
php artisan test --filter=OrderRaceConditionTest
```

> **Catatan Pengujian Concurrency:**
> Functional test bawaan memvalidasi ketepatan implementasi *locking* dan batasan stok secara sekuensial. Untuk menyimulasikan *race condition* secara nyata dengan beban *high-concurrency* paralel di lingkungan lokal, disarankan menggunakan *load testing tools* seperti **k6**, **wrk**, atau **Apache JMeter** untuk menembak *endpoint* `POST /api/orders` secara bersamaan dalam satu waktu.

### 2. Menjalankan Game CLI (Task 2)
Program akan secara otomatis menghitung dan mencetak daftar koordinat akhir yang memenuhi syarat navigasi beserta visualisasi petanya.
```bash
php artisan game:find-item
