# Sistem Absensi Berbasis QR Code

## Tentang Project

Sistem Absensi Berbasis QR Code adalah aplikasi berbasis website yang dibuat menggunakan Laravel untuk membantu proses pencatatan kehadiran secara digital.

Sistem ini menggantikan proses absensi manual dengan metode scan QR Code sehingga proses pencatatan kehadiran menjadi lebih cepat, praktis, dan data tersimpan secara otomatis di dalam database.

Aplikasi ini memiliki dua jenis pengguna yaitu Admin dan User dengan hak akses yang berbeda.


---

## Fitur Aplikasi

### Admin

- Login ke sistem
- Melihat dashboard absensi
- Mengelola data pengguna
- Membuat QR Code absensi
- Mengelola data kehadiran
- Melihat riwayat absensi pengguna
- Export laporan absensi ke Excel


### User

- Login akun
- Melakukan absensi dengan scan QR Code
- Melihat status absensi
- Melihat riwayat kehadiran


---

## Teknologi Yang Digunakan

- Laravel Framework
- PHP
- MySQL Database
- Blade Template Engine
- Bootstrap
- SB Admin 2
- QR Code Generator
- Laravel Excel


---

## Struktur Database

### Users

Menyimpan data akun pengguna.

Field utama:

- id
- name
- email
- password
- role


### Attendances

Menyimpan data kehadiran pengguna.

Field utama:

- id
- user_id
- date
- time_in
- status


### QR Tokens

Menyimpan token QR Code yang digunakan untuk proses absensi.

Field utama:

- id
- token
- expires_at


---

## Instalasi Project

Clone repository:

```bash
git clone https://github.com/username/nama-project.git
```

Masuk folder project:

```bash
cd nama-project
```


Install dependency Laravel:

```bash
composer install
```


Copy file environment:

```bash
cp .env.example .env
```


Generate application key:

```bash
php artisan key:generate
```


Setting database pada file `.env`:

```env
DB_DATABASE=nama_database
DB_USERNAME=root
DB_PASSWORD=
```


Jalankan migrasi database:

```bash
php artisan migrate
```


Jalankan aplikasi:

```bash
php artisan serve
```


Akses aplikasi:

```text
http://127.0.0.1:8000
```


---

## Role Pengguna

### Admin

Admin memiliki akses untuk mengelola sistem, pengguna, QR Code, dan laporan absensi.


### User

User memiliki akses untuk melakukan absensi dan melihat riwayat kehadiran.


---

## Export Data

Sistem mendukung export laporan absensi ke format Excel (.xlsx) sehingga data dapat digunakan sebagai laporan administrasi.


---

## Status Pengembangan

Fitur yang sudah tersedia:

- Authentication System
- Role Management
- Dynamic QR Code Attendance
- Attendance History
- Admin Dashboard
- Export Excel Report
- Database Management


---

## Developer

Project dibuat oleh:

Nama Developer

Program Studi Sistem Informasi


---

## Lisensi

Project ini dibuat untuk kebutuhan pembelajaran dan pengembangan sistem informasi berbasis website.