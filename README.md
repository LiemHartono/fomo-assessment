# Fullstack Engineer Assessment - PT FOMO Inovasi Teknologi

Repositori ini berisi solusi untuk tes asesmen Fullstack Engineer yang mencakup implementasi API Toko Online dengan penanganan *race condition* dan program CLI untuk permainan *Hidden Item*.

## Teknologi yang Digunakan
- **Framework:** Laravel 11
- **Bahasa:** PHP 8.2+
- **Database:** MySQL/MariaDB
- **Testing:** PHPUnit

---

## Fitur & Implementasi

### Task 1: Online Store API
API ini dirancang untuk mensimulasikan sistem pesanan pada saat *flash sale*. 
- [cite_start]**Atomic Transactions:** Menjamin pesanan dan item pesanan tersimpan secara utuh atau tidak sama sekali[cite: 20].
- [cite_start]**Race Condition Handling:** Menggunakan mekanisme **Pessimistic Locking** (`lockForUpdate`) untuk memastikan stok produk tidak pernah bernilai negatif meskipun diakses secara bersamaan oleh banyak pengguna[cite: 23, 32].
- [cite_start]**Standardized Response:** Menggunakan format JSON dengan kode respon HTTP yang sesuai (201 Created, 422 Unprocessable Entity, dll)[cite: 27, 29].

### Task 2: Hidden Item Game (CLI)
Program berbasis terminal untuk mencari koordinat item tersembunyi berdasarkan langkah navigasi.
- [cite_start]**Pathfinding Logic:** Menghitung koordinat akhir berdasarkan input langkah Utara, Timur, dan Selatan dengan mempertimbangkan hambatan (#) [cite: 55-61].
- [cite_start]**Grid Visualization:** Menampilkan peta grid dengan simbol `$` sebagai penanda lokasi kemungkinan item (Poin Bonus)[cite: 63].

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
