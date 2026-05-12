# Fullstack Engineer Assessment - PT FOMO Inovasi Teknologi

Repositori ini berisi solusi untuk tes asesmen Fullstack Engineer yang mencakup implementasi API Toko Online dengan penanganan *race condition* dan program CLI untuk permainan *Hidden Item*.

## Teknologi yang Digunakan
- **Framework:** Laravel 12
- **Bahasa:** PHP 8.2+
- **Database:** MySQL
- **Testing:** PHPUnit

---

## Fitur & Implementasi

### Task 1: Online Store API
API ini dirancang untuk mensimulasikan sistem pesanan pada saat *flash sale*. 
- **Atomic Transactions:** Menjamin pesanan dan item pesanan tersimpan secara utuh atau tidak sama sekali.
- **Race Condition Handling:** Menggunakan mekanisme **Pessimistic Locking** (`lockForUpdate`) untuk memastikan stok produk tidak pernah bernilai negatif meskipun diakses secara bersamaan oleh banyak pengguna.
- **Standardized Response:** Menggunakan format JSON dengan kode respon HTTP yang sesuai (201 Created, 422 Unprocessable Entity, dll).

### Task 2: Hidden Item Game (CLI)
Program berbasis terminal untuk mencari koordinat item tersembunyi berdasarkan langkah navigasi.
- **Pathfinding Logic:** Menghitung koordinat akhir berdasarkan input langkah Utara, Timur, dan Selatan dengan mempertimbangkan hambatan (#).
- **Grid Visualization:** Menampilkan peta grid dengan simbol `$` sebagai penanda lokasi kemungkinan item (Poin Bonus).

---

## Cara Instalasi

1. **Clone repositori:**
   ```bash
   git clone [https://github.com/LiemHartono/fomo-assessment.git](https://github.com/LiemHartono/fomo-assessment.git)
   cd fomo-assessment

2. **Instal dependensi:**
   ```bash
   composer install

3. **Konfigurasi Environment:**
   ```bash
   cp .env.example .env
   php artisan key:generate

4. **Konfigurasi Environment:**
   ```bash
   php artisan migrate
   php artisan db:seed --class=ProductSeeder\

## Cara Menjalankan Tes & Program

1. **Menjalankan Functional Test (Task 1)**
   ```bash
   php artisan test --filter=OrderRaceConditionTest

2. **Menjalankan Game CLI (Task 2)**
   ```bash
   # Format: php artisan game:find-item {A} {B} {C}
   # Contoh: 1 langkah Utara, 2 langkah Timur, 1 langkah Selatan
   php artisan game:find-item 1 2 1


## Kontak
Nama: Liem Hartono
Repositori: https://github.com/LiemHartono/fomo-assessment

