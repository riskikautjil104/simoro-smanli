@extends('layouts.master')
@section('title', 'Tambah Ujian')
@section('layoutContent')
<div class="card p-4 mb-4">
    <h4>Buat Ujian Baru</h4>
    <form id="form-ujian">
        <div class="row mb-3">
            <div class="col-md-4">
                <label class="form-label">Judul Ujian</label>
                <input type="text" name="title" class="form-control" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">Mata Pelajaran</label>
                <select name="subject_id" id="subject_id" class="form-select" required></select>
            </div>
            <div class="col-md-4">
                <label class="form-label">Kelas</label>
                <select name="class_id" id="class_id" class="form-select" required></select>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4">
                <label class="form-label">Waktu Mulai</label>
                <input type="datetime-local" name="start_time" class="form-control" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">Waktu Selesai</label>
                <input type="datetime-local" name="end_time" class="form-control" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">Durasi (menit)</label>
                <input type="number" name="duration" class="form-control" min="1" required>
            </div>
        </div>
        <button type="submit" class="btn btn-success">Simpan Ujian</button>
    </form>
    <div id="ujian-alert" class="mt-3"></div>
</div>
<script>
function fetchSubjectsAndClasses() {
    fetch('/guru/soal/filters')
        .then(res => res.json())
        .then(data => {
            const subjectSel = document.getElementById('subject_id');
            subjectSel.innerHTML = '<option value="">Pilih Mapel</option>';
            data.subjects.forEach(m => {
                subjectSel.innerHTML += `<option value="${m.id}">${m.name}</option>`;
            });
            subjectSel.addEventListener('change', function() {
                const selected = data.subjects.find(m => m.id == this.value);
                const classSel = document.getElementById('class_id');
                classSel.innerHTML = '<option value="">Pilih Kelas</option>';
                if (selected && selected.classes) {
                    selected.classes.forEach(k => {
                        classSel.innerHTML += `<option value="${k.id}">${k.name}</option>`;
                    });
                }
            });
        });
}
document.addEventListener('DOMContentLoaded', function() {
    fetchSubjectsAndClasses();
    document.getElementById('form-ujian').addEventListener('submit', function(e) {
        e.preventDefault();
        const form = e.target;
        const data = Object.fromEntries(new FormData(form));
        fetch('/guru/ujian/store', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify(data)
        })
        .then(res => res.json())
        .then(res => {
            const alertDiv = document.getElementById('ujian-alert');
            if (res.success) {
                alertDiv.innerHTML = '<div class="alert alert-success">Ujian berhasil dibuat!</div>';
                form.reset();
            } else {
                alertDiv.innerHTML = '<div class="alert alert-danger">Gagal membuat ujian.</div>';
            }
        })
        .catch(() => {
            document.getElementById('ujian-alert').innerHTML = '<div class="alert alert-danger">Terjadi kesalahan.</div>';
        });
    });
});
</script>
@endsection
