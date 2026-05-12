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

---

## 📁 Struktur Folder Final Proyek
