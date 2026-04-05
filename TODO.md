# Fix Guru Gak Bisa Lihat Ujian

## ✅ 1. Diagnosis Selesai
- Admin: `Exam::get()` → semua ujian
- Guru: `Exam::whereIn('subject_id', guru_subject_ids)` → cuma miliknya

## 🔍 2. Cek Data Database (RUN NOW)
```bash
# Ganti GURU_ID dengan ID guru test
php artisan tinker
```
```php
// Cek guru punya subject apa
$guruId = 2; // ganti ID guru
App\Models\Subject::where('teacher_id', $guruId)->get(['id','name']);

// Cek exam guru
App\Models\Exam::whereIn('subject_id', 
  App\Models\Subject::where('teacher_id', $guruId)->pluck('id')
)->with('subject.schoolClass')->get();
```

## 🛠️ 3. Fix Subject Assignment (jika kosong)
```sql
-- Assign subject ke guru (contoh ID 1-5 subjects, guru ID 2)
UPDATE subjects SET teacher_id = 2 WHERE id IN (1,2,3);
```

## 🧪 4. Test
```
1. Login guru → /guru/ujian
2. Harus muncul table ujian  
3. Click detail → /guru/ujian/{id}/detail OK
```
`php artisan cache:clear && php artisan view:clear`

## 📋 Next Steps
- [ ] Run query cek guru subjects
- [ ] Assign subjects ke guru  
- [ ] Test guru dashboard
- [ ] Done!
