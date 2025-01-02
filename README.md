# Sampah Bijak

**Sistem Digital Pengelolaan Sampah Terintegrasi untuk Mendukung Ekonomi Sirkular dan Lingkungan Sehat**

## **Tech Stack**

| **Komponen**   | **Teknologi**        |
|----------------|----------------------|
| **Backend**    | Laravel              |
| **Frontend**   | Vue.js (dengan Inertia.js) |
| **Database**   | MySQL                |
| **Versioning** | Git                  |

---

## **Cara Instalasi**

### **1. Clone Repository**
```bash
git clone https://github.com/al-kawsar/sampahbijak.git
cd sampah-bijak
```

### **2. Install Dependencies**
#### Backend
```bash
composer install
```
#### Frontend
```bash
npm install
```

### **3. Konfigurasi Environment**
Buat file `.env` dan atur variabel berikut:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel_dinacom25
DB_USERNAME=root
DB_PASSWORD=your-password
```

### **4. Setup Database**
```bash
php artisan migrate --seed
```

### **5. Jalankan Aplikasi**
#### Backend & Frontend
```bash
npm run build
composer run dev
```

Akses aplikasi di [http://localhost:8000](http://localhost:8000).

---

## **Panduan Pengguna**
1. **Login/Registrasi**: Pengguna dapat membuat akun baru atau login menggunakan akun yang telah ada.
2. **Setor Sampah**: Rumah tangga dapat mencatat sampah yang mereka setorkan ke bank sampah.
3. **Lihat Statistik**: Pengguna dapat memantau statistik kontribusi mereka terhadap lingkungan.
4. **Edukasi**: Akses materi pembelajaran tentang pengelolaan sampah.
