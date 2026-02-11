**Prompt:**

Buatkan aplikasi web berbasis **Laravel 10+** dengan tampilan frontend menggunakan **Tailwind CSS**, mengikuti spesifikasi berikut:

### 🎨 **Desain & Tema**
- Tema warna utama: **merah, hitam, dan putih**.
- Gaya tampilan: **modern, eye-catching**, dan responsif.
- Gunakan logo dari file `public/logo.png` di seluruh halaman (termasuk di form, dashboard, dan kartu anggota).
- Font dan spacing harus konsisten dengan prinsip desain modern (gunakan Tailwind utility classes secara optimal).

---

### 🌐 **Frontend (Halaman Publik)**
1. **Halaman Depan (`/`)**:
   - Tampilkan **form pendaftaran anggota baru** (nama lengkap, email, nomor HP, alamat, tanggal lahir, dll).
   - Di bawah form, tampilkan **daftar card berita terbaru** (judul, ringkasan, tanggal publikasi, dan gambar opsional).
   - Form dan card berita harus responsive dan menarik secara visual.

2. **Autentikasi Pengguna**:
   - Dua role: **member** dan **admin**.
   - Setelah login, **member** hanya bisa melihat profil dan berita.
   - **Admin** diarahkan ke dashboard admin.

---

### 🖥️ **Dashboard Admin (`/admin`)**
Akses hanya untuk role **admin**. Fitur-fitur:
1. **CRUD Database Anggota**:
   - Tabel daftar anggota dengan filter/pencarian.
   - Form tambah/edit/hapus anggota.
   - Validasi input wajib.

2. **CRUD Berita**:
   - Buat, edit, hapus, dan tampilkan berita (dengan upload gambar opsional).
   - Tampilan preview berita seperti card di halaman depan.

3. **Import/Export Excel**:
   - Tombol **"Export ke Excel"** untuk mengunduh data anggota dalam format `.xlsx`.
   - Form **"Import dari Excel"** untuk menambah/memperbarui data anggota via file Excel.

4. **Cetak Kartu Tanda Anggota (PDF)**:
   - Setiap anggota memiliki tombol **"Cetak KTA"**.
   - PDF harus mencakup: foto (opsional), nama, ID anggota, masa berlaku, dan logo LSM (`logo.png`).
   - Desain KTA harus profesional, mencerminkan tema merah-hitam-putih.

---

### 🗃️ **Database**
- Gunakan struktur database seperti pada file contoh: `harimau.sql`.
- Pastikan migrasi dan seeder Laravel merefleksikan skema tersebut.
- Tabel utama: `users` (dengan kolom `role`), `anggota`, dan `berita`.

---

### 🔒 **Keamanan & Autentikasi**
- Gunakan Laravel Breeze atau Jetstream untuk autentikasi dasar.
- Implementasikan middleware role-based (`admin` vs `member`).
- Proteksi terhadap XSS dan SQL injection (gunakan Eloquent ORM dan validation bawaan Laravel).

---

### 📁 **File Tambahan**
- Logo: simpan di `public/logo.png` dan tampilkan di seluruh antarmuka.
- Contoh database: acuan struktur dari `harimau.sql` (pastikan field relevan seperti `id_anggota`, `nama`, `email`, `no_hp`, `alamat`, dll).

---

### 📦 **Output yang Diharapkan**
- Struktur proyek Laravel lengkap.
- Semua fitur berfungsi tanpa error.
- UI/UX konsisten, modern, dan sesuai tema warna LSM Hariman.

---

Prompt ini siap digunakan untuk briefing developer atau sebagai input ke AI code assistant. Jika Anda memerlukan versi dalam format Markdown untuk dokumentasi internal, saya juga bisa bantu.