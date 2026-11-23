# 🗄️ Panduan Migrasi Database BPKAD
## Dari Aiven (expired) → TiDB Cloud Serverless (Gratis Selamanya)

---

## ✨ Kenapa TiDB Cloud?

| Fitur | TiDB Cloud Serverless (Free) |
|-------|------------------------------|
| Harga | **Gratis selamanya** |
| Storage | **5 GB** |
| Compute | 250 juta RU / bulan |
| Kartu kredit | ❌ Tidak wajib |
| MySQL kompatibel | ✅ Ya (100%) |
| SSL | ✅ Otomatis (wajib) |
| Region | Singapore tersedia ✅ |

---

## 🚀 LANGKAH 1: Daftar & Buat Cluster TiDB Cloud

1. Buka → **https://tidbcloud.com**
2. Klik **"Sign Up"** → bisa pakai Google/GitHub
3. Setelah masuk, klik **"Create Cluster"**
4. Pilih tipe: **Serverless** (Free)
5. Isi nama cluster, misal: `bpkad-db`
6. Region: pilih **Singapore** (paling dekat)
7. Klik **"Create"** → tunggu ~30 detik

---

## 🔑 LANGKAH 2: Ambil Credential Koneksi

1. Di halaman cluster, klik **"Connect"**
2. Pilih **"General"** → pilih **"PHP"** atau **"MySQL CLI"**
3. **CATAT** semua nilai berikut:

   | Variabel | Contoh nilai |
   |----------|-------------|
   | `DB_HOST` | `gateway01.ap-southeast-1.prod.aws.tidbcloud.com` |
   | `DB_PORT` | `4000` |
   | `DB_DATABASE` | `test` _(bisa diganti)_ |
   | `DB_USERNAME` | `xxxxxxxx.root` |
   | `DB_PASSWORD` | `(password yang digenerate)` |

4. Klik **"Download CA cert"** → simpan file `isrgrootx1.pem`
   - Upload file ini ke folder `storage/app/` di project
   - Atau gunakan path CA system: `/etc/ssl/certs/ca-certificates.crt`

---

## 🗃️ LANGKAH 3: Import SQL ke Database TiDB

### Cara A — via MySQL CLI (jika ada di komputer):
```bash
mysql --connect-timeout=15 -u '<username>' -h '<host>' -P 4000 -D test \
  --ssl-mode=VERIFY_IDENTITY --ssl-ca=isrgrootx1.pem \
  -p'<password>' < database/sql/setup_bpkad.sql
```

### Cara B — via phpMyAdmin / Chat2DB (Recommended):
1. Buka **https://dev.mysql.com/downloads/workbench/** atau gunakan **TablePlus** / **DBeaver**
2. Buat koneksi baru dengan credential TiDB
3. Aktifkan SSL → pilih file `isrgrootx1.pem` sebagai CA
4. Buka dan jalankan file `database/sql/setup_bpkad.sql`

### Cara C — via TiDB Cloud Web Console (Termudah):
1. Di dashboard cluster TiDB, klik **"Chat2Query"** (SQL Editor online)
2. Copy-paste isi file `database/sql/setup_bpkad.sql`
3. Klik **"Run"**

---

## ⚙️ LANGKAH 4: Update Environment Variables di Vercel

1. Buka **https://vercel.com** → project **project-bpkad**
2. Klik **Settings** → **Environment Variables**
3. **Hapus** variabel DB lama (Aiven), lalu **Tambah** yang baru:

   | Key | Value |
   |-----|-------|
   | `DB_CONNECTION` | `mysql` |
   | `DB_HOST` | `gateway01.ap-southeast-1.prod.aws.tidbcloud.com` |
   | `DB_PORT` | `4000` |
   | `DB_DATABASE` | `test` |
   | `DB_USERNAME` | `xxxxxxxx.root` |
   | `DB_PASSWORD` | `(password TiDB)` |
   | `TIDB_SSL_VERIFY` | `false` |
   | `MYSQL_ATTR_SSL_CA` | `/etc/ssl/certs/ca-certificates.crt` |

4. Klik **Save** → lalu klik **Redeploy**

> 💡 Nilai `MYSQL_ATTR_SSL_CA` untuk Vercel (Linux) adalah `/etc/ssl/certs/ca-certificates.crt`  
> Ini sudah tersedia otomatis di server Vercel, tidak perlu upload file apapun!

---

## 🔐 LANGKAH 5: Login ke Admin

Setelah deploy selesai:
- **URL:** https://project-bpkad.vercel.app/login
- **Email:** `admin@bpkad.go.id`
- **Password:** `password`

> ⚠️ **SEGERA GANTI PASSWORD** setelah login pertama kali melalui menu pengaturan!

---

## 📌 Troubleshooting SSL TiDB Cloud

**Q: Error `SSL connection error: ASN: bad other signature confirmation`**  
A: Pastikan `MYSQL_ATTR_SSL_CA` di-set ke `/etc/ssl/certs/ca-certificates.crt`

**Q: Error `SQLSTATE[HY000] [2002] Connection refused`**  
A: Periksa `DB_HOST` dan `DB_PORT` (TiDB pakai port **4000**, bukan 3306)

**Q: Error `Access denied for user`**  
A: Username TiDB Cloud formatnya `xxxxx.root` (ada prefix sebelum titik), pastikan tidak salah copy

---

## 📂 File yang sudah disiapkan di project:

- [`database/sql/setup_bpkad.sql`](database/sql/setup_bpkad.sql) — Script SQL lengkap semua tabel + admin
- [`config/database.php`](config/database.php) — Sudah diupdate support TiDB SSL
- [`vercel.json`](vercel.json) — Sudah diupdate env `DB_CONNECTION` dan `TIDB_SSL_VERIFY`
