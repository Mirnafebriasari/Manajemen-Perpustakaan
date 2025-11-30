# Manajemen Perpustakaan Digital

Aplikasi Manajemen Perpustakaan Digital ini dirancang untuk mengelola koleksi buku, pengguna, dan transaksi peminjaman secara efisien melalui sistem berbasis role untuk Admin, Pegawai, Mahasiswa, dan Guest. Fitur utama meliputi pengelolaan data pengguna dan buku, proses peminjaman dan pengembalian dengan perhitungan denda otomatis, notifikasi sistem, rekomendasi buku, serta ulasan dari mahasiswa. Antarmuka mencakup katalog buku, halaman detail, dan dashboard khusus sesuai peran pengguna. Sistem juga dapat dikembangkan dengan fitur reservasi buku dan analitik laporan untuk kebutuhan perpustakaan yang lebih modern dan informatif.

---

## Rincian Alur Aplikasi

1. **Login / Registrasi**  
   - Admin login menggunakan akun yang diberikan.
   - Akun Pegawai dibuat dan dikelola oleh Admin melalui menu Manajemen Pengguna.
   - Mahasiswa dapat mendaftar menggunakan email universitas lalu login.  
   - Guest dapat langsung mengakses katalog tanpa login.

2. **Akses Dashboard Berdasarkan Role**  
   - **Admin:** Kelola pengguna, kelola buku, dan pantau seluruh aktivitas perpustakaan.  
   - **Pegawai:** Konfirmasi peminjaman/pengembalian buku dan mengelola stok.  
   - **Mahasiswa:** Melihat katalog, meminjam, memperpanjang, melihat riwayat, mengulas buku, dan memantau denda.  
   - **Guest:** Hanya dapat melihat katalog dan rekomendasi umum.

3. **Manajemen Pengguna (Admin)**  
   - Tambah, edit, dan hapus pengguna (pegawai & mahasiswa).  
   - Atur role dan validasi data pengguna.

4. **Manajemen Buku (Admin & Pegawai)**  
   - Tambah koleksi buku baru lengkap dengan detail (judul, penulis, stok, denda, dll).  
   - Edit atau hapus buku yang sudah tidak digunakan.  
   - Cek stok dan ketersediaan buku.

5. **Peminjaman Buku (Mahasiswa)**  
   - Cari buku melalui katalog atau fitur pencarian.  
   - Buka detail buku dan tekan tombol **“Pinjam Buku”** jika stok tersedia.  
   - Sistem mencatat transaksi dan mengirim notifikasi konfirmasi.

6. **Pengembalian & Denda (Pegawai)**  
   - Pegawai mengonfirmasi pengembalian.  
   - Sistem otomatis menghitung denda jika terlambat.  
   - Mahasiswa wajib melunasi agar bisa meminjam kembali.

7. **Perpanjangan Peminjaman (Mahasiswa)**  
   - Dapat memperpanjang selama belum lewat tanggal jatuh tempo.  
   - Sistem memperbarui tanggal pengembalian dan mengirim notifikasi.

8. **Notifikasi Sistem**  
   - Mahasiswa menerima pengingat jatuh tempo, pemberitahuan denda, dan konfirmasi transaksi.  
   - Pegawai dapat melihat log notifikasi yang dikirimkan.

9. **Review & Rekomendasi Buku (Mahasiswa)**  
   - Berikan rating dan komentar untuk buku yang telah dipinjam.  
   - Sistem menampilkan rekomendasi buku yang relevan dan populer.

10. **Fitur Opsional (Jika diaktifkan)**  
    - Reservasi Buku: Mahasiswa dapat memesan buku yang sedang dipinjam orang lain.  
    - Analitik & Laporan: Admin dapat melihat grafik peminjaman dan data statistik perpustakaan.

---

## Teknologi dan Alat yang Digunakan

- **XAMPP** — Server lokal yang menyediakan Apache, PHP, dan MySQL untuk menjalankan aplikasi.  
- **Composer** — Dependency manager untuk menginstal dan mengelola paket Laravel.  
- **Laravel** — Framework utama untuk pengembangan backend, routing, autentikasi, dan manajemen data.  
- **Visual Studio Code (VS Code)** — Code editor utama untuk menulis dan mengelola proyek.  
- **GitHub** — Platform untuk penyimpanan kode, version control, dan kolaborasi.

---

### Langkah-Langkah Penggunaan 

1.  **Clone Repositori:**
    ```bash
    git clone [https://github.com/Mirnafebriasari/Manajemen-Perpustakaan.git](https://github.com/Mirnafebriasari/Manajemen-Perpustakaan.git)
    ```

2.  **Masuk ke Direktori Proyek:**
    ```bash
    cd Manajemen-Perpustakaan
    ```

3.  **Instal Dependensi Laravel:**
    ```bash
    composer install
    ```

4.  **Buka XAMPP lalu start MySQL**
5.  **Masuk ke VS Code lalu buka terminal dan jalankan migrasi dan seeder database:**
    ```bash
    php artisan migrate --seed
    ```
6.  **Jalankan Server Aplikasi:**
    ```bash
    php artisan serve
    ```
7. **Jalankan Vite pada terminal lain:**
    ```bash
    npm run dev
    ```
8. **Jalankan symlink untuk menghubungkan folder penyimpanan file pribadi ke folder yang dapat diakses publik oleh browser. :**
    ```bash
    php artisan storage:link
    ```
    *Akses aplikasi di:* `http://127.0.0.1:8000/`

**Catatan Penting Mengenai Akses**
Setelah menjalankan perintah php artisan migrate --seed, Anda dapat mengakses sistem dengan kredensial berikut:
1. Akun Admin Utama: Gunakan kredensial yang telah diatur dalam file database/seeders/AdminSeeder.php. Akun ini adalah kunci utama untuk mengelola seluruh sistem perpustakaan.
2. Akun Mahasiswa: Selain menggunakan akun Admin, pengguna dapat langsung melakukan registrasi di halaman register untuk membuat akun Mahasiswa dan mulai menjelajahi fungsionalitas pengguna.
    

---

## Alur Penggunaan Berdasarkan Role

| Role | Fungsionalitas Utama |
| :--- | :--- |
| **Admin** | Kelola Pengguna, Kelola Buku, Pantau Aktivitas. |
| **Pegawai** | Konfirmasi Peminjaman/Pengembalian, Kelola Stok Buku. |
| **Mahasiswa** | Pinjam Buku, Perpanjang, Ulas Buku, Cek Denda. |

---
