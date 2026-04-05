# 📡 API Mobile Siswa - Dokumentasi Lengkap

## 🔗 Base URL

```
https://domain-anda.com/api
```

---

## 📡 Public Endpoints

### 1. Get App Config

Mengambil konfigurasi aplikasi secara dinamis untuk mobile app.

```
GET /api/config
```

**Headers:**
```
Content-Type: application/json
```

**Response Success (200):**
```json
{
  "success": true,
  "data": {
    "app_name": "Web Skola SMA5",
    "school_name": "SMA 5",
    "tagline": "Sistem Ujian Online",
    "location": "",
    "theme": {
      "primary": "#0d6efd",
      "secondary": "#6c757d",
      "background": "#ffffff",
      "surface": "#f8f9fa",
      "error": "#dc3545",
      "success": "#198754",
      "text_primary": "#212529",
      "text_secondary": "#6c757d"
    },
    "features": {
      "show_onboarding": true,
      "show_notifications": true,
      "enable_location_tracking": true
    },
    "version": "1.0.0",
    "maintenance_mode": false,
    "maintenance_message": ""
  }
}
```

---

## 🔐 Autentikasi

### 2. Login

```
POST /api/login
```

**Request:**
```json
{
  "email": "siswa@email.com",
  "password": "password123"
}
```

**Response:**
```json
{
  "token": "1|abc123...",
  "user": {
    "id": 1,
    "name": "Nama Siswa",
    "email": "siswa@email.com",
    "role": "student"
  }
}
```

### 3. Logout

```
POST /api/logout
```

**Headers:**
```
Authorization: Bearer {token}
```

### 4. Get Current User

```
GET /api/me
```

**Headers:**
```
Authorization: Bearer {token}
```

---

## 👨‍🎓 Endpoint Siswa (Requires Auth)

### 5. Get Profile

```
GET /api/siswa/profile
```

**Response:**
```json
{
  "success": true,
  "data": {
    "id": 1,
    "name": "Nama Siswa",
    "email": "siswa@email.com",
    "nis": "12345678",
    "role": "student",
    "class_id": 1,
    "class_name": "XII IPA 1",
    "ttd_signature": "data:image/png;base64,..."
  }
}
```

### 6. Update Profile

```
PUT /api/siswa/profile
```

**Request:**
```json
{
  "name": "Nama Baru",
  "phone": "081234567890",
  "ttd_signature": "data:image/png;base64,..."
}
```

### 7. Dashboard

```
GET /api/siswa/dashboard
```

**Response:**
```json
{
  "success": true,
  "data": {
    "siswa": { "id": 1, "nama": "Siswa", "nis": "123456" },
    "kelas": { "id": 1, "nama": "XII IPA 1", "tingkat": 12 },
    "mapel": [
      { "id": 1, "nama_mapel": "Matematika", "kode": "MTK" }
    ],
    "ujian_mendatang": [
      { "id": 1, "nama": "Ujian Tengah Semester", "mapel": "Matematika", "tanggal": "2026-04-01 09:00", "durasi": 90 }
    ],
    "stats": {
      "total_ujian": 5,
      "ujian_selesai": 3,
      "nilai_rata_rata": 82.5
    }
  }
}
```

### 8. Ujian Aktif

```
GET /api/siswa/ujian/aktif
```

**Response:**
```json
{
  "success": true,
  "data": [
    {
      "id": 1,
      "nama": "Ujian Matematika",
      "mapel": "Matematika",
      "mapel_id": 1,
      "tanggal": "2026-03-15 10:00:00",
      "durasi": 90,
      "status_logout": 0,
      "reapply_status": 0,
      "is_active": true
    }
  ]
}
```

### 9. Ujian Riwayat

```
GET /api/siswa/ujian/riwayat
```

**Response:**
```json
{
  "success": true,
  "data": [
    {
      "id": 1,
      "exam_id": 1,
      "nama": "Ujian Matematika",
      "mapel": "Matematika",
      "nilai": 85,
      "tanggal": "15-03-2026 10:00",
      "status": "Selesai"
    }
  ]
}
```

### 10. Ujian Detail

```
GET /api/siswa/ujian/{id}
```

**Response:**
```json
{
  "success": true,
  "data": {
    "id": 1,
    "title": "Ujian Matematika",
    "subject": "Matematika",
    "duration": 90,
    "remaining_seconds": 5400,
    "questions": [
      {
        "id": 1,
        "question_text": "Apa ibu kota Indonesia?",
        "type": "multiple_choice",
        "options": ["Jakarta", "Bandung", "Surabaya", "Medan"]
      }
    ]
  }
}
```

### 11. Mulai Ujian

```
POST /api/siswa/ujian/{id}/mulai
```

**Response:**
```json
{
  "success": true,
  "message": "Ujian dimulai",
  "data": {
    "session_id": 1,
    "start_time": "2026-03-15 10:00:00",
    "duration_minutes": 90
  }
}
```

### 12. Submit Jawaban

```
POST /api/siswa/ujian/{id}/submit
```

**Request:**
```json
{
  "answers": {
    "1": "A",
    "2": "B",
    "3": "C"
  }
}
```

### 13. Logout dari Ujian

```
POST /api/siswa/ujian/{id}/logout
```

### 14. Request Reapply

```
POST /api/siswa/ujian/{id}/reapply
```

**Request:**
```json
{
  "alasan": "Saya logout tidak sengaja"
}
```

### 15. Simpan Lokasi

```
POST /api/siswa/ujian/{id}/lokasi
```

**Request:**
```json
{
  "lat": -6.2088,
  "lng": 106.8456
}
```

### 16. Hasil Ujian

```
GET /api/siswa/ujian/{id}/hasil
```

**Response:**
```json
{
  "success": true,
  "data": {
    "id": 1,
    "exam_title": "Ujian Matematika",
    "subject": "Matematika",
    "score": 85,
    "tanggal": "15-03-2026 10:00"
  }
}
```

### 17. Get Jawaban

```
GET /api/siswa/ujian/{id}/jawaban
```

### 18. Cetak Hasil Lengkap

```
GET /api/siswa/ujian/{id}/cetak
```

**Response:**
```json
{
  "success": true,
  "data": {
    "siswa": { "id": 1, "nama": "Siswa", "nis": "123", "kelas": "XII IPA 1" },
    "ujian": { "id": 1, "nama": "Ujian Matematika", "mapel": "Matematika", "tanggal": "15-03-2026 10:00", "durasi": 90 },
    "ringkasan": {
      "nilai_total": 85,
      "total_soal_pg": 40,
      "total_soal_essay": 5,
      "jawaban_benar": 35,
      "jawaban_salah": 5,
      "belum_dinilai": 0,
      "status_penilaian": "Sudah Dinilai"
    },
    "soal": [
      {
        "id": 1,
        "nomor": 1,
        "pertanyaan": "Apa ibu kota Indonesia?",
        "tipe": "multiple_choice",
        "opsi_a": "Jakarta",
        "opsi_b": "Bandung",
        "opsi_c": "Surabaya",
        "opsi_d": "Medan",
        "jawaban_siswa": "A",
        "jawaban_benar": "A",
        "nilai_pg": 2.5,
        "nilai_essay": null,
        "status": "Benar",
        "is_correct": true
      }
    ]
  }
}
```

---

## ⚙️ Konfigurasi via .env

Untuk mengubah konfigurasi mobile app, tambahkan di file `.env`:

```env
# App Info
APP_NAME_MOBILE=Web Skola SMA5
SCHOOL_NAME=SMA 5 Morotai
APP_TAGLINE=Sistem Ujian Online
SCHOOL_LOCATION=Pulau Morotai, Maluku Utara
APP_VERSION=1.0.0

# Theme Colors
THEME_PRIMARY=#0d6efd
THEME_SECONDARY=#6c757d
THEME_BACKGROUND=#ffffff
THEME_SURFACE=#f8f9fa
THEME_ERROR=#dc3545
THEME_SUCCESS=#198754
THEME_TEXT_PRIMARY=#212529
THEME_TEXT_SECONDARY=#6c757d

# Features
FEATURE_SHOW_ONBOARDING=true
FEATURE_SHOW_NOTIFICATIONS=true
FEATURE_LOCATION_TRACKING=true

# Maintenance
MAINTENANCE_MODE=false
MAINTENANCE_MESSAGE=System under maintenance
```

---

**Last Updated:** Maret 2026

