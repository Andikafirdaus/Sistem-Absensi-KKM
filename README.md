# 📌 Sistem Absensi KKM Berbasis QR Code

Sistem Absensi KKM adalah aplikasi berbasis website yang digunakan untuk membantu proses pencatatan kehadiran anggota KKM secara digital menggunakan teknologi QR Code.

Dengan adanya sistem ini, proses absensi menjadi lebih cepat, mudah, dan data kehadiran dapat tersimpan secara otomatis.

---

# 👥 Role Pengguna

Sistem memiliki 2 jenis pengguna:

## 1. Administrator

Administrator bertugas mengelola seluruh data sistem.

Fitur Administrator:

- Mengelola akun anggota KKM
- Membuat akun anggota
- Mengubah data anggota
- Mengubah password anggota apabila lupa
- Generate QR Code absensi
- Melihat data absensi
- Export laporan absensi Excel
- Monitoring aktivitas sistem


## 2. Anggota KKM

Anggota digunakan untuk melakukan absensi harian.

Fitur Anggota:

- Login akun
- Scan QR Code absensi
- Melihat riwayat absensi
- Mengubah profil pribadi


---

# 🔐 Cara Login Anggota KKM

Setiap anggota akan mendapatkan akun yang dibuat oleh Administrator.

Data login berupa:

```
Email    : diberikan oleh Administrator
Password : diberikan oleh Administrator
```

Langkah login:

1. Buka website Sistem Absensi KKM

2. Masukkan email dan password yang sudah diberikan

3. Klik tombol:

```
Login
```

4. Setelah berhasil, anggota akan masuk ke halaman Dashboard.

---

# 📷 Cara Melakukan Absensi QR Code

Setelah berhasil login:

1. Pilih menu:

```
Scan QR Absen
```

2. Browser akan meminta izin kamera.

Pilih:

```
Izinkan / Allow
```

3. Kamera akan terbuka.

4. Arahkan kamera HP ke QR Code yang diberikan oleh Administrator.

5. Tunggu sampai proses scan berhasil.

6. Jika berhasil, sistem akan otomatis menyimpan:

- Nama anggota
- Tanggal absensi
- Jam absensi
- Status kehadiran

---

# ⚠️ Kamera Tidak Muncul?

Apabila kamera tidak muncul ketika melakukan scan:

Lakukan langkah berikut:

## Android / Chrome

1. Klik ikon gembok di samping alamat website

![Izin Kamera](docs/izin-kamera.png)


2. Pilih Permission / Izin Situs

3. Aktifkan Camera → Allow

![Allow Kamera](docs/allow-camera.png)
4. Refresh halaman

5. Buka kembali menu Scan QR


---

# 📅 Riwayat Absensi

Anggota dapat melihat data kehadiran melalui menu:

```
Riwayat Absensi
```

Informasi yang tersedia:

- Tanggal hadir
- Jam absensi
- Status absensi


---

# 🔑 Lupa Password

Sistem tidak menggunakan reset password melalui email.

Apabila anggota lupa password:

Silakan hubungi:

- Ketua KKM
- Sekretaris KKM
- Administrator Sistem

Administrator akan membantu melakukan perubahan password akun.

---

# 📊 Status Kehadiran

Keterangan status:

🟢 Hadir

Anggota melakukan absensi sesuai waktu yang ditentukan.


🟡 Terlambat

Anggota melakukan absensi melewati batas waktu yang ditentukan.


---

# 💻 Teknologi Yang Digunakan

Aplikasi dibangun menggunakan:

- Laravel Framework
- MySQL Database
- Bootstrap
- JavaScript
- QR Code Scanner
- Laravel Excel

---

# 📌 Tentang Sistem

Sistem Absensi KKM dibuat untuk membantu kegiatan Kuliah Kerja Mahasiswa dalam melakukan digitalisasi proses absensi.

Tujuan utama:

- Mengurangi absensi manual
- Mempermudah rekap data
- Mempercepat proses kehadiran
- Menyediakan laporan yang lebih rapi

---

# Developer

Dikembangkan sebagai bagian dari kegiatan KKM untuk mendukung penggunaan teknologi informasi dalam kegiatan organisasi.

© 2026 Sistem Absensi KKM
