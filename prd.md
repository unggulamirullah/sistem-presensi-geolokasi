PRODUCT REQUIREMENTS DOCUMENT (PRD)
AI Implementation Directive (For Antigravity IDE)
Perhatian untuk AI (Antigravity IDE):
Gunakan dokumen ini sebagai sumber kebenaran utama (Single Source of Truth). Proyek ini wajib dikembangkan menggunakan ekosistem Laravel (versi 12) dan PHP 8.3+. Semua pembuatan struktur folder, sintaks, routing, controller, middleware, dan ORM (Eloquent) harus mematuhi standar best practice Laravel terbaru.

Project Title
Sistem Presensi Karyawan Berbasis Geolokasi (Web Application)

Project Overview
Sistem Presensi Karyawan Berbasis Geolokasi adalah aplikasi web yang dibangun dengan Laravel untuk mencatat kehadiran karyawan berdasarkan lokasi GPS secara real-time. Sistem memastikan bahwa karyawan hanya dapat melakukan presensi ketika berada dalam radius yang ditentukan dari lokasi kantor.

Aplikasi memiliki dua jenis pengguna:

Admin

Karyawan

Tujuan utama sistem adalah meningkatkan akurasi data kehadiran, mengurangi manipulasi absensi, mempermudah monitoring, serta pembuatan laporan kehadiran otomatis.

Objectives
Memungkinkan karyawan melakukan presensi masuk dan pulang melalui antarmuka web.

Memvalidasi lokasi pengguna menggunakan GPS (dengan pencegahan Fake GPS).

Membatasi presensi berdasarkan perhitungan radius kantor.

Menyediakan dashboard monitoring kehadiran.

Menyediakan laporan presensi yang dapat diekspor.

Technology Stack
Backend:

Laravel 12

PHP 8.3+

Frontend:

Laravel Blade

Bootstrap 5

Database:

MySQL

Maps:

OpenStreetMap

LeafletJS

Authentication:

Laravel Authentication (Breeze / UI / Fortify)

Hosting Infrastructure (Development & Deployment):

Local: Laragon (Auto Virtual Host & SSL Enabled)

Production: Serverless/Free Tier Cloud (Render.com/Koyeb) dengan eksternal MySQL Server (Aiven) dan External Cron Job Pinger.

User Roles
Admin
Hak akses:

Login

Kelola data karyawan

Kelola lokasi kantor

Kelola radius presensi

Melihat data presensi

Melihat lokasi presensi pada peta

Export laporan

Dashboard statistik

Karyawan
Hak akses:

Login

Melakukan presensi masuk

Melakukan presensi pulang

Melihat riwayat presensi pribadi

Melihat status kehadiran

Core Features
Authentication
Login

Input: Email, Password

Output: Redirect sesuai role

Logout

Mengakhiri sesi pengguna.

Data Karyawan
Field: id, nama, email, nomor_pegawai, jabatan, departemen, password, status_aktif, created_at, updated_at

Fitur:

Tambah, Edit, Hapus, Cari karyawan

Pengaturan Lokasi Kantor
Field: nama_lokasi, latitude, longitude, radius_meter

Fitur:

Menentukan titik pusat koordinat kantor dan radius toleransi presensi.

Contoh: Lat: -7.795580, Long: 110.369490, Radius: 100 meter.

Presensi Masuk
Alur:

Karyawan login ke dashboard web.

Sistem meminta izin Browser Geolocation API.

Sistem mengambil koordinat pengguna dan mengecek tingkat akurasi GPS (accuracy).

Sistem menghitung jarak koordinat karyawan ke koordinat kantor menggunakan Haversine Formula.

Jika dalam radius dan akurasi GPS valid: Presensi berhasil, simpan ke database.

Jika di luar radius atau terdeteksi manipulasi: Presensi ditolak, tampilkan pesan error.

Data yang disimpan:
user_id, tanggal, jam_masuk, latitude_masuk, longitude_masuk, jarak_ke_kantor, status

Presensi Pulang
Alur Normal:
Karyawan menekan tombol pulang, sistem memvalidasi lokasi, lalu menyimpan jam dan koordinat pulang.

Alur Auto-Checkout (Lupa Absen):
Sistem memiliki endpoint API khusus atau perintah Console Command yang akan dieksekusi oleh Task Scheduling / External Cron Job (cron-job.org) setiap pukul 23:59. Jika ada karyawan yang memiliki jam_masuk namun jam_pulang masih kosong (null), sistem otomatis menutup sesi presensi harian tersebut dan menandai status pulang sebagai "Tidak Checkout".

Data yang disimpan:
jam_pulang, latitude_pulang, longitude_pulang

Dashboard Admin
Menampilkan: Total karyawan, Hadir hari ini, Terlambat, Belum hadir, Persentase kehadiran.
Visualisasi: Card statistik, Grafik kehadiran bulanan, Tabel presensi terbaru.

Riwayat Presensi
Filter: Tanggal, Bulan, Tahun, Nama karyawan.
Tampilan: Tabel, Pagination, Export.

Peta Lokasi Presensi
Admin dapat melihat sebaran titik presensi karyawan berbanding dengan titik pusat kantor menggunakan marker pada peta OpenStreetMap (LeafletJS).

Export Laporan
Format: Excel (.xlsx), PDF.
Sistem Unduh: Memanfaatkan Stream Download Laravel untuk mencegah penghapusan file di penyimpanan ephemeral pada server hosting gratis.
Filter: Harian, Mingguan, Bulanan, Tahunan.

Database Design
(Semua timestamps menggunakan default timezone server lokal / Asia/Jakarta pada konfigurasi Laravel).

users
id, name, email, password, role, created_at, updated_at

employees
id, user_id, employee_number, department, position, status, created_at, updated_at

office_locations
id, office_name, latitude, longitude, radius_meter, created_at, updated_at

attendances
id, employee_id, attendance_date, check_in_time, check_out_time, check_in_latitude, check_in_longitude, check_out_latitude, check_out_longitude, distance_meter, status, created_at, updated_at

Attendance Rules
Status Kehadiran:

Hadir

Terlambat

Izin

Sakit

Alpha

Tidak Checkout

Jam Kerja (Timezone Lokal):

Batas Masuk: 08:00

Jam Pulang: 17:00

Terlambat: Presensi masuk dicatat lebih dari pukul 08:00

Security Requirements
Password Hashing (Bcrypt, bawaan Laravel).

CSRF Protection di semua form.

Session Authentication.

Role Based Access Control (Middleware Laravel).

Validasi Geolocation (Anti Fake GPS): Memblokir presensi jika akurasi lokasi berada di atas batas toleransi meter wajar untuk mencegah Mock Location.

Perlindungan Endpoint Auto-Checkout dengan Secret Token.

UI Requirements
Tema: Modern, Professional, Responsive
Halaman: Login, Dashboard Admin, Dashboard Karyawan, Data Karyawan, Presensi, Riwayat Presensi, Pengaturan Lokasi, Laporan.

Future Enhancements
(Fitur ini tidak masuk dalam MVP saat ini, mohon diabaikan oleh AI dalam pengerjaan tahap awal)

Mobile Application

Selfie Verification

Face Recognition

QR Code Attendance

Success Criteria
Sistem Laravel dapat berjalan sempurna di lingkungan local (Laragon) maupun produksi gratis.

Kalkulasi jarak menggunakan formula Haversine berjalan akurat.

Task scheduling / Auto-checkout berfungsi untuk mereset hari.

Ekspor laporan berjalan secara streaming.