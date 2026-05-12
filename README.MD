# 🎓 Form Kehadiran Mahasiswa

Aplikasi web sederhana untuk mencatat kehadiran mahasiswa. Dibangun dengan **PHP native**, **Tailwind CSS v4**, dan **JavaScript (AJAX)**. Proyek ini adalah tugas perkuliahan yang menerapkan konsep **Separation of Concerns (SOC)** dan keamanan dasar seperti **CSRF token**.

---

## 🧠 Tentang Proyek Ini

Bayangkan Anda seorang dosen atau asisten laboratorium yang perlu merekam kehadiran mahasiswa setiap pertemuan. Anda bisa menggunakan aplikasi ini untuk:

- **Mengisi nama mahasiswa** dan memilih status kehadirannya (Hadir, Izin, Sakit, Tidak Hadir).
- **Mendapatkan pesan otomatis** sesuai status (misal: *"Semoga cepat sembuh"* untuk yang sakit).
- **Semua data diproses tanpa perlu reload halaman** – karena menggunakan AJAX, jadi terasa cepat dan modern.
- **Tetap aman dari serangan CSRF** – setiap form memiliki token rahasia yang hanya diketahui server.

Tampilannya dibuat **glassmorphism** (seperti kaca buram) dengan gradien warna hijau stabilo yang segar. Notifikasi hasil akan muncul di atas form dengan latar buram, tapi tulisannya jelas.

Proyek ini dikerjakan dengan **struktur folder yang rapi** – kode logika (controller), tampilan (view), dan fungsi bantu (helper) dipisahkan, sehingga mudah dipelajari dan dikembangkan.

---

## 🛠️ Yang Perlu Kamu Siapkan Sebelum Menjalankan

Pastikan komputer/laptop kamu sudah terinstall:

| Software | Fungsi | Cara Cek |
|----------|--------|----------|
| **XAMPP** (Linux) | Web server (Apache) + PHP | `sudo /opt/lampp/lampp status` |
| **Node.js** (minimal v16) | Menjalankan Tailwind CSS CLI via npm | `node -v` |
| **npm** | Package manager untuk Tailwind | `npm -v` |
| **Git** (opsional) | Untuk clone repositori | `git --version` |

> 📌 Jika belum punya, instal dulu. Untuk Fedora:  
> `sudo dnf install nodejs npm git -y`  
> XAMPP download dari [apachefriends.org](https://www.apachefriends.org) (pilih versi Linux).


## 📁 Struktur Folder Final Proyek
form-kehadiran/
├── public/
│ ├── index.php # pintu masuk semua request (router)
│ ├── css/
│ │ └── output.css # hasil build Tailwind
│ └── js/
│ └── script.js # kode JavaScript (AJAX, validasi)
├── src/
│ ├── controllers/
│ │ └── kehadiranController.php # logika bisnis (swich-case)
│ ├── views/
│ │ └── form.php # tampilan HTML + CSS
│ ├── utils/
│ │ └── helpers.php # fungsi CSRF, logging, JSON
│ └── css/
│ └── input.css # source Tailwind
├── package.json # daftar dependensi npm
├── package-lock.json
└── README.md


---

## 🚀 Langkah-Langkah Menjalankan Proyek (Step by Step)

Ikuti urutan di bawah ini dengan seksama. Semua perintah dijalankan di terminal (kecuali disebutkan lain).

### 1. Letakkan proyek di folder htdocs XAMPP
sudo mkdir -p /opt/lampp/htdocs/form-kehadiran
cd /opt/lampp/htdocs/form-kehadiran

### 2. Instal dependensi Tailwind CSS via npm
npm install

### 3. Build CSS Tailwind (jalankan watch mode)
npm run dev
Jika belum ada script dev, buka package.json dan tambahkan:
"scripts": {
  "dev": "npx @tailwindcss/cli -i ./src/css/input.css -o ./public/css/output.css --watch"
}

### 4. Konfigurasi Virtual Host di XAMPP
Agar bisa diakses dengan domain formkehadiran.test.
Edit file konfigurasi Apache:
sudo nano /opt/lampp/etc/extra/httpd-vhosts.conf

Tambahkan di paling akhir:
<VirtualHost *:80>
    ServerAdmin admin@formkehadiran.test
    DocumentRoot "/opt/lampp/htdocs/form-kehadiran/public"
    ServerName formkehadiran.test
    ServerAlias www.formkehadiran.test
    ErrorLog "/opt/lampp/logs/formkehadiran-error_log"
    CustomLog "/opt/lampp/logs/formkehadiran-access_log" common
    <Directory "/opt/lampp/htdocs/form-kehadiran/public">
        Options Indexes FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>

Simpan (Ctrl+X, Y, Enter).

Edit file hosts:
sudo nano /etc/hosts

Tambahkan baris:
127.0.0.1   formkehadiran.test
simpan.

Restart Apache:
sudo /opt/lampp/lampp restart

### 5. Berikan izin folder (agar Apache bisa membaca & menulis log)
sudo chown -R daemon:daemon /opt/lampp/htdocs/form-kehadiran
sudo chmod -R 755 /opt/lampp/htdocs/form-kehadiran/public
sudo mkdir -p /opt/lampp/htdocs/form-kehadiran/logs
sudo chmod 755 /opt/lampp/htdocs/form-kehadiran/logs

### 6. Akses aplikasi di browser
Buka browser (Firefox/Chrome) dan ketik:
http://formkehadiran.test
```bash

---

🐞 Troubleshooting
Masalah                                     Solusi
Error                                       403 Forbidden	Pastikan public/ memiliki izin 755 dan file index.php ada.
CSS                                         tidak tampil	npm run dev sudah berjalan? File public/css/output.css harus ada. Jalankan build sekali tanpa watch: npx @tailwindcss/cli -i ./src/css/   input.css -o ./public/css/output.css
Call                                        to undefined function regenerateCsrfToken()	Buka src/utils/helpers.php – pastikan fungsi itu ada. Jangan mendefinisikannya lagi di index.php.
Virtual                                     host tidak terdeteksi	Restart Apache, cek /etc/hosts dan httpd-vhosts.conf benar.
AJAX                                        tidak jalan	Buka console browser (F12) lihat error. Pastikan header X-CSRF-Token dikirim.
```bash

---