# 🗄️ Panduan Migrasi Database BPKAD
## Dari Aiven (expired) → FreeSQLDatabase.com (Gratis Selamanya)

---

## 📋 Situasi
- **Database lama:** Aiven MySQL (trial ended / powered off)
- **Database baru:** FreeSQLDatabase.com — **GRATIS SELAMANYA**, tanpa kartu kredit
- **Limit:** 5MB storage (lebih dari cukup untuk data tamu skala BPKAD)

---

## 🚀 LANGKAH 1: Daftar Database Baru di FreeSQLDatabase.com

1. Buka **https://www.freesqldatabase.com**
2. Klik **"Sign Up"** / Register dengan email
3. Verifikasi email
4. Setelah login, klik **"Create Database"**
5. **CATAT** informasi koneksi yang diberikan:
   - `DB_HOST` → contoh: `sql.freedb.tech`
   - `DB_PORT` → biasanya `3306`
   - `DB_DATABASE` → nama database (contoh: `sql123456_bpkad`)
   - `DB_USERNAME` → username (contoh: `sql123456_bpkad`)
   - `DB_PASSWORD` → password yang diberikan

---

## 🗃️ LANGKAH 2: Import SQL ke Database Baru

1. Di dashboard FreeSQLDatabase, cari link **phpMyAdmin** atau akses via:
   `https://www.phpmyadmin.co` (gunakan credential dari langkah 1)
   
2. Login ke phpMyAdmin dengan credential di atas

3. Pilih database Anda di panel kiri

4. Klik tab **"Import"**

5. Upload file: `database/sql/setup_bpkad.sql` (ada di project ini)

6. Klik **"Go"** / **"Import"**

7. ✅ Selesai! Semua tabel sudah terbuat beserta akun admin.

---

## ⚙️ LANGKAH 3: Update Environment Variables di Vercel

1. Buka https://vercel.com → masuk ke project **project-bpkad**

2. Klik **Settings** → **Environment Variables**

3. **Update atau Tambah** variabel berikut (sesuaikan dengan data dari FreeSQLDatabase):

   | Key | Value (contoh) |
   |-----|----------------|
   | `DB_CONNECTION` | `mysql` |
   | `DB_HOST` | `sql.freedb.tech` |
   | `DB_PORT` | `3306` |
   | `DB_DATABASE` | `sql123456_bpkad` |
   | `DB_USERNAME` | `sql123456_bpkad` |
   | `DB_PASSWORD` | `(password dari FreeSQLDatabase)` |

4. Klik **Save**

5. Klik **Redeploy** (atau push commit baru ke GitHub agar otomatis deploy)

---

## 🔐 LANGKAH 4: Login ke Admin

Setelah deploy selesai:
- **URL:** https://project-bpkad.vercel.app/login
- **Email:** `admin@bpkad.go.id`  
- **Password:** `password`

> ⚠️ **SEGERA GANTI PASSWORD** setelah login pertama kali!

---

## 📌 Alternatif Layanan Database Gratis Lainnya

Jika FreeSQLDatabase tidak cocok, coba:

| Layanan | Type | Free Limit | Catatan |
|---------|------|-----------|---------|
| **db4free.net** | MySQL | 200MB | Paling populer, kadang lambat |
| **Filess.io** | MySQL | 10MB | Interface bagus |
| **Neon.tech** | PostgreSQL | 512MB | Butuh ganti ke `DB_CONNECTION=pgsql` |
| **Oracle Cloud Free** | MySQL | 50GB | Butuh kartu kredit verifikasi |

---

## ❓ Troubleshooting

**Q: Error "Too many connections"**  
A: Tambahkan di `.env` / Vercel env: `DB_POOL_SIZE=3`

**Q: Error SSL / Certificate**  
A: Tambahkan di `config/database.php` pada bagian mysql:
```php
'options' => [
    PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT => false,
],
```

**Q: Data tamu yang lama hilang?**  
A: Sayangnya karena Aiven sudah powered off, data tamu yang ada tidak bisa di-recover kecuali ada backup lokal. Hanya akun admin yang bisa disetup ulang.
