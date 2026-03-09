# 📱 API Mobile App Siswa - Web Skola SMA5

Dokumentasi API ini digunakan untuk pengembangan aplikasi mobile siswa (Android/iOS).

---

## 🔐 Authentication

### Login
```
POST /api/login
```

**Request:**
```
json
{
  "email": "siswa@sekolah.sch.id",
  "password": "password123"
}
```

**Response:**
```
json
{
  "token": "1|abc123xyz...",
  "user": {
    "id": 1,
    "name": "Nama Siswa",
    "email": "siswa@sekolah.sch.id",
    "nis": "12345",
    "role": "student",
    "class_id": 1,
    "class_name": "X IPA 1"
  }
}
```

### Logout
```
POST /api/logout
Headers: Authorization: Bearer {token}
```

### Get Current User
```
GET /api/me
Headers: Authorization: Bearer {token}
```

---

## 👤 Profil Siswa

### Get Profil
```
GET /api/siswa/profile
Headers: Authorization: Bearer {token}
```

**Response:**
```
json
{
  "success": true,
  "data": {
    "id": 1,
    "name": "Nama Siswa",
    "email": "siswa@sekolah.sch.id",
    "nis": "12345",
    "phone": "081234567890",
    "class_id": 1,
    "class": { "id": 1, "name": "X IPA 1" },
    "ttd_signature": "data:image/png;base64,..."
  }
}
```

### Update Profil
```
PUT /api/siswa/profile
Headers: Authorization: Bearer {token}
```

**Request:**
```
json
{
  "name": "Nama Baru",
  "phone": "081234567890",
  "ttd_signature": "data:image/png;base64,..."
}
```

---

## 📝 Ujian - Daftar Ujian Aktif

### Get Ujian Aktif
```
GET /api/siswa/ujian/aktif
Headers: Authorization: Bearer {token}
```

**Response:**
```
json
{
  "success": true,
  "data": [
    {
      "id": 1,
      "nama": "Ujian Matematika Semester 1",
      "mapel": "Matematika",
      "mapel_id": 1,
      "tanggal": "2026-03-01T08:00:00",
      "durasi": 90,
      "jam_mulai": "08:00",
      "jam_selesai": "09:30",
      "status_logout": 0,
      "reapply_status": 0,
      "is_active": true
    }
  ]
}
```

---

## 📝 Ujian - Riwayat

### Get Riwayat Ujian
```
GET /api/siswa/ujian/riwayat
Headers: Authorization: Bearer {token}
```

**Response:**
```
json
{
  "success": true,
  "data": [
    {
      "id": 1,
      "exam_title": "Ujian Matematika",
      "subject": "Matematika",
      "score": 85,
      "tanggal": "01-03-2026 10:30",
      "status": "Selesai"
    }
  ]
}
```

---

## 📝 Ujian - Detail & Mulai

### Get Detail Ujian
```
GET /api/siswa/ujian/{id}
Headers: Authorization: Bearer {token}
```

**Response:**
```
json
{
  "success": true,
  "data": {
    "id": 1,
    "title": "Ujian Matematika Semester 1",
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

### Mulai Ujian
```
POST /api/siswa/ujian/{id}/mulai
Headers: Authorization: Bearer {token}
```

**Response:**
```
json
{
  "success": true,
  "message": "Ujian dimulai",
  "data": {
    "session_id": 1,
    "start_time": "2026-03-01 08:00:00"
  }
}
```

---

## 📝 Ujian - Submit Jawaban

### Submit Ujian
```
POST /api/siswa/ujian/{id}/submit
Headers: Authorization: Bearer {token}
```

**Request:**
```
json
{
  "answers": {
    "1": "Jakarta",
    "2": "B",
    "3": "true"
  }
}
```

**Response:**
```
json
{
  "success": true,
  "message": "Jawaban berhasil disubmit"
}
```

---

## 📝 Ujian - Logout dari Ujian

### Logout Ujian
```
POST /api/siswa/ujian/{id}/logout
Headers: Authorization: Bearer {token}
```

**Response:**
```
json
{
  "success": true,
  "message": "Logout berhasil, progress tersimpan"
}
```

---

## 📝 Ujian - Reapply (Minta Akses Ulang)

### Reapply Ujian
```
POST /api/siswa/ujian/{id}/reapply
Headers: Authorization: Bearer {token}
```

**Request:**
```
json
{
  "alasan": "Tidak sengaja logout, minta akses ulang"
}
```

**Response:**
```
json
{
  "success": true,
  "message": "Permintaan reapply berhasil dikirim"
}
```

---

## 📝 Ujian - Simpan Lokasi

### Simpan Lokasi (GPS)
```
POST /api/siswa/ujian/{id}/lokasi
Headers: Authorization: Bearer {token}
```

**Request:**
```
json
{
  "lat": -6.200000,
  "lng": 106.816666
}
```

**Response:**
```
json
{
  "success": true,
  "message": "Lokasi berhasil disimpan"
}
```

---

## 📝 Ujian - Hasil Ujian

### Get Hasil Ujian
```
GET /api/siswa/ujian/{id}/hasil
Headers: Authorization: Bearer {token}
```

**Response:**
```
json
{
  "success": true,
  "data": {
    "id": 1,
    "exam_title": "Ujian Matematika",
    "subject": "Matematika",
    "score": 85,
    "tanggal": "01-03-2026 10:30"
  }
}
```

---

## 📝 Ujian - Get Jawaban

### Get Jawaban Siswa
```
GET /api/siswa/ujian/{exam_id}/jawaban
Headers: Authorization: Bearer {token}
```

**Catatan:** Gunakan `exam_id` (ID ujian), bukan `session_id`!

**Response:**
```
json
{
  "success": true,
  "data": [
    {
      "question_id": 1,
      "question_text": "a",
      "answer": "D",
      "score": 0,
      "nilai_essay": 3
    },
    {
      "question_id": 2,
      "question_text": "res",
      "answer": "aa",
      "score": 4,
      "nilai_essay": 25
    },
    {
      "question_id": 6,
      "question_text": "a",
      "answer": "B",
      "score": 0,
      "nilai_essay": 4
    }
  ]
}
```

**Keterangan:**
- `score`: Nilai untuk soal pilihan ganda
- `nilai_essay`: Nilai untuk soal essay
- Jika `score` null, berarti belum dinilai oleh guru

---

## 💻 Contoh Kode (Flutter/Dart)

```
dart
class ApiService {
  static const baseUrl = 'https://web-skola-sma5.com/api';
  String? token;

  // Login
  Future<Map> login(String email, String password) async {
    final response = await http.post(
      Uri.parse('$baseUrl/login'),
      headers: {'Content-Type': 'application/json'},
      body: jsonEncode({'email': email, 'password': password}),
    );
    final data = jsonDecode(response.body);
    token = data['token'];
    return data;
  }

  // Get Active Exams
  Future<List> getActiveExams() async {
    final response = await http.get(
      Uri.parse('$baseUrl/siswa/ujian/aktif'),
      headers: {'Authorization': 'Bearer $token'},
    );
    return jsonDecode(response.body)['data'];
  }

  // Get Exam History
  Future<List> getExamHistory() async {
    final response = await http.get(
      Uri.parse('$baseUrl/siswa/ujian/riwayat'),
      headers: {'Authorization': 'Bearer $token'},
    );
    return jsonDecode(response.body)['data'];
  }

  // Get Exam Details
  Future<Map> getExamDetails(int examId) async {
    final response = await http.get(
      Uri.parse('$baseUrl/siswa/ujian/$examId'),
      headers: {'Authorization': 'Bearer $token'},
    );
    return jsonDecode(response.body)['data'];
  }

  // Start Exam
  Future<Map> startExam(int examId) async {
    final response = await http.post(
      Uri.parse('$baseUrl/siswa/ujian/$examId/mulai'),
      headers: {'Authorization': 'Bearer $token'},
    );
    return jsonDecode(response.body);
  }

  // Submit Exam
  Future<Map> submitExam(int examId, Map answers) async {
    final response = await http.post(
      Uri.parse('$baseUrl/siswa/ujian/$examId/submit'),
      headers: {'Authorization': 'Bearer $token'},
      body: jsonEncode({'answers': answers}),
    );
    return jsonDecode(response.body);
  }

  // Logout from Exam
  Future<Map> logoutExam(int examId) async {
    final response = await http.post(
      Uri.parse('$baseUrl/siswa/ujian/$examId/logout'),
      headers: {'Authorization': 'Bearer $token'},
    );
    return jsonDecode(response.body);
  }

  // Get Exam Result
  Future<Map> getExamResult(int examId) async {
    final response = await http.get(
      Uri.parse('$baseUrl/siswa/ujian/$examId/hasil'),
      headers: {'Authorization': 'Bearer $token'},
    );
    return jsonDecode(response.body)['data'];
  }

  // Get Student Answers
  Future<List> getExamAnswers(int examId) async {
    final response = await http.get(
      Uri.parse('$baseUrl/siswa/ujian/$examId/jawaban'),
      headers: {'Authorization': 'Bearer $token'},
    );
    return jsonDecode(response.body)['data'];
  }

  // Get Profile
  Future<Map> getProfile() async {
    final response = await http.get(
      Uri.parse('$baseUrl/siswa/profile'),
      headers: {'Authorization': 'Bearer $token'},
    );
    return jsonDecode(response.body)['data'];
  }

  // Update Profile
  Future<Map> updateProfile(Map data) async {
    final response = await http.put(
      Uri.parse('$baseUrl/siswa/profile'),
      headers: {
        'Authorization': 'Bearer $token',
        'Content-Type': 'application/json',
      },
      body: jsonEncode(data),
    );
    return jsonDecode(response.body);
  }
}
```

---

## ⚠️ Catatan Penting

1. **Base URL:** `https://web-skola-sma5.com/api` (sesuaikan dengan server)
2. **Semua endpoint (kecuali login) memerlukan token**
3. **Format Token:** Bearer Token (Laravel Sanctum)
4. **Role Student:** Endpoint `/api/siswa/*` khusus untuk role student
5. **Exam Session:** Setiap ujian harus di-start dulu sebelum akses soal

---

## 📱 Flow Lengkap Ujian Mobile

```
1. LOGIN
   POST /api/login
   → Simpan token

2. CEK UJIAN AKTIF
   GET /api/siswa/ujian/aktif
   → Tampilkan list ujian

3. MULAI UJIAN
   POST /api/siswa/ujian/{id}/mulai
   → Dapat session_id

4. AMBIL SOAL
   GET /api/siswa/ujian/{id}
   → Tampilkan soal + timer

5. (Opsional) SIMPAN LOKASI
   POST /api/siswa/ujian/{id}/lokasi
   → Simpan GPS

6. SUBMIT JAWABAN
   POST /api/siswa/ujian/{id}/submit
   → Kirim semua jawaban

7. LIHAT HASIL
   GET /api/siswa/ujian/{id}/hasil
   → Tampilkan nilai
```

---

## 🔧 Troubleshooting

### Error: "Unauthenticated"
- Pastikan token sudah disimpan
- Pastikan header `Authorization: Bearer {token}` ada

### Error: "Hasil ujian belum diperiksa"
- Belum ada nilai karena guru belum memeriksa

### Error: "Ujian sudah dimulai"
- Gunakan endpoint `/api/siswa/ujian/{id}` untuk lanjut

### Error: "Ujian belum dimulai atau sudah berakhir"
- Ujian sudah expired (tanggal sudah lewat)
- Hubungi admin untuk perbarui tanggal ujian
- Atau hapus exam session lama agar bisa ikut ujian ulang

### Catatan Penting untuk Developer Mobile:
1. **Waktu Ujian:** Jika `remaining_seconds` sudah 0, berarti waktu ujian habis
2. **Durasi:** `duration` dalam menit, `remaining_seconds` dalam detik
3. **Soal Kosong:** Jika soal kosong, cek apakah ujian punya soal atau bukan
4. **Session Idle:** Jika siswa logout dari ujian, harus reapply untuk akses ulang

---

**Last Updated:** Maret 2026
**Version:** 1.0
