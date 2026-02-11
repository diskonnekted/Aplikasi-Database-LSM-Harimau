# Aplikasi Database & Pelaporan LSM Harimau

**Hak Cipta © 2026 LSM Harimau. All Rights Reserved.**

> ⚠️ **PEMBERITAHUAN VERSI BETA**
>
> Aplikasi ini saat ini berada dalam **Tahap Beta (Pengujian)**. Beberapa fitur mungkin masih dalam pengembangan atau penyempurnaan. Kami terus berupaya meningkatkan stabilitas dan fungsionalitas sistem. Mohon laporkan setiap bug atau kendala yang Anda temukan kepada tim pengembang untuk perbaikan segera.

Aplikasi ini adalah sistem manajemen terpadu yang dibangun untuk kebutuhan operasional Lembaga Swadaya Masyarakat (LSM) Harimau. Sistem ini mengintegrasikan manajemen keanggotaan, pelaporan masyarakat, dan portal informasi dalam satu platform yang efisien dan modern.

## 🚀 Fitur Utama

### 1. Manajemen Keanggotaan (Member Management)
Sistem pendataan anggota yang komprehensif mulai dari pendaftaran hingga penerbitan kartu identitas.
-   **Pendaftaran Anggota Baru**: Form registrasi online dengan validasi data lengkap.
-   **Database Wilayah Terintegrasi**: Pemilihan alamat menggunakan data wilayah Indonesia lengkap (Provinsi, Kota/Kabupaten, Kecamatan, Desa/Kelurahan) hingga tingkat RT/RW.
-   **Verifikasi Anggota**: Alur verifikasi oleh admin sebelum anggota resmi aktif.
-   **Kartu Tanda Anggota (KTA) Digital**:
    -   Generate KTA otomatis dalam format PDF.
    -   Dilengkapi **QR Code** unik untuk verifikasi keaslian anggota.
    -   Desain KTA yang profesional siap cetak.
-   **Export Data**: Fitur export data anggota ke format Excel untuk kebutuhan arsip dan pelaporan offline.

### 2. Sistem Pelaporan Masyarakat (Public Reporting)
Wadah bagi masyarakat dan anggota untuk menyampaikan aspirasi atau pengaduan secara transparan.
-   **Formulir Pengaduan**: Antarmuka pelaporan yang mudah digunakan dengan dukungan upload bukti (Foto/PDF).
-   **Opsi Privasi**: Pelapor dapat memilih untuk mempublikasikan laporan atau merahasiakannya (Anonim).
-   **Pelacakan Status**: Monitoring status laporan secara real-time (Pending -> Escalated -> Disposition -> Investigation -> Resolved).
-   **Alur Penanganan Laporan**:
    -   **Disposisi**: Pimpinan dapat mendisposisikan laporan ke pengurus wilayah terkait.
    -   **Investigasi**: Input hasil investigasi lapangan oleh tim yang ditunjuk.
    -   **Penyelesaian**: Dokumentasi penyelesaian akhir laporan.
-   **Transparansi Publik**: Menampilkan daftar laporan yang telah diselesaikan (jika diizinkan pelapor) sebagai bentuk transparansi kinerja LSM.

### 3. Portal Informasi & Berita
-   **Manajemen Berita**: CMS sederhana untuk mempublikasikan kegiatan, press release, dan artikel LSM.
-   **Halaman Profil & Tata Tertib**: Informasi statis mengenai profil organisasi dan aturan keanggotaan.

### 4. Manajemen Pengguna & Hak Akses
-   **Role-Based Access Control**: Pemisahan hak akses antara Administrator, Pengurus, dan Anggota Biasa.
-   **Dashboard Admin**: Ringkasan statistik anggota dan laporan masuk dalam bentuk grafik visual.

## 🛠️ Teknologi yang Digunakan

Aplikasi ini dibangun menggunakan teknologi web modern untuk menjamin performa, keamanan, dan kemudahan pengembangan:

-   **Backend**: [Laravel Framework](https://laravel.com) (PHP) - Framework PHP terpopuler yang aman dan robust.
-   **Frontend**:
    -   [Blade Templates](https://laravel.com/docs/blade): Templating engine bawaan Laravel.
    -   [Tailwind CSS](https://tailwindcss.com): Utility-first CSS framework untuk desain UI yang modern dan responsif.
    -   [Alpine.js](https://alpinejs.dev): Framework JavaScript ringan untuk interaktivitas UI (Dropdown wilayah, modal, dll).
-   **Database**: MySQL / MariaDB.
-   **Libraries Utama**:
    -   `laravolt/indonesia`: Database wilayah Indonesia lengkap.
    -   `barryvdh/laravel-dompdf`: Generator PDF untuk KTA.
    -   `simplesoftwareio/simple-qrcode`: Generator QR Code.
    -   `maatwebsite/excel`: Export/Import data Excel.

## 📦 Instalasi & Pengaturan

Ikuti langkah-langkah berikut untuk menjalankan aplikasi di lingkungan lokal (Localhost):

### Prasyarat
-   PHP >= 8.2
-   Composer
-   Node.js & NPM
-   MySQL Database

### Langkah Instalasi
1.  **Clone Repository**
    ```bash
    git clone https://github.com/diskonnekted/Aplikasi-Database-LSM-Harimau.git
    cd Aplikasi-Database-LSM-Harimau
    ```

2.  **Install Dependencies**
    ```bash
    composer install
    npm install
    ```

3.  **Konfigurasi Environment**
    Salin file `.env.example` menjadi `.env` dan sesuaikan konfigurasi database Anda.
    ```bash
    cp .env.example .env
    ```
    Buka file `.env` dan atur:
    ```
    DB_DATABASE=lsmharimau
    DB_USERNAME=root
    DB_PASSWORD=
    ```

4.  **Generate Application Key**
    ```bash
    php artisan key:generate
    ```

5.  **Migrasi Database & Seeding**
    Jalankan migrasi untuk membuat tabel dan mengisi data wilayah Indonesia (proses ini mungkin memakan waktu beberapa saat karena banyaknya data wilayah).
    ```bash
    php artisan migrate --seed
    php artisan laravolt:indonesia:seed
    ```

6.  **Compile Assets**
    ```bash
    npm run build
    ```

7.  **Jalankan Server**
    ```bash
    php artisan serve
    ```
    Aplikasi dapat diakses di `http://localhost:8000`.

## 📄 Lisensi & Hak Cipta

**Hak Cipta © 2026 LSM Harimau.**

Seluruh kode sumber, desain, dan aset dalam aplikasi ini adalah properti intelektual dari LSM Harimau. Dilarang keras menyalin, memodifikasi, mendistribusikan ulang, atau menggunakan bagian manapun dari aplikasi ini untuk tujuan komersial tanpa izin tertulis dari LSM Harimau.

---
*Dibuat dan dikembangkan oleh Clasnet Group untuk LSM Harimau.*
