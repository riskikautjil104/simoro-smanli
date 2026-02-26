@extends('layouts.master')
@section('title', 'Tambah Soal')
@section('layoutContent')
<div class="card p-4 mb-4">
    <h4>Tambah Soal ke Bank Soal</h4>
    <form id="form-soal">
        <div class="row mb-3">
            <div class="col-md-4">
                <label class="form-label">Mata Pelajaran</label>
                <select name="subject_id" id="subject_id" class="form-select" required></select>
            </div>
            <div class="col-md-4">
                <label class="form-label">Tipe Soal</label>
                <select name="type" class="form-select" required>
                    <option value="">Pilih Tipe</option>
                    <option value="PG">Pilihan Ganda</option>
                    <option value="ESAI">Esai</option>
                </select>
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label">Pertanyaan</label>
            <textarea name="pertanyaan" class="form-control" required></textarea>
        </div>
        <div class="row mb-3">
            <div class="col-md-3">
                <label class="form-label">Opsi A</label>
                <input type="text" name="opsi_a" class="form-control" required>
            </div>
            <div class="col-md-3">
                <label class="form-label">Opsi B</label>
                <input type="text" name="opsi_b" class="form-control" required>
            </div>
            <div class="col-md-3">
                <label class="form-label">Opsi C</label>
                <input type="text" name="opsi_c" class="form-control" required>
            </div>
            <div class="col-md-3">
                <label class="form-label">Opsi D</label>
                <input type="text" name="opsi_d" class="form-control" required>
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label">Jawaban Benar</label>
            <select name="jawaban_benar" class="form-select" required>
                <option value="">Pilih Jawaban</option>
                <option value="A">A</option>
                <option value="B">B</option>
                <option value="C">C</option>
                <option value="D">D</option>
            </select>
        </div>
        <button type="submit" class="btn btn-success">Simpan Soal</button>
    </form>
    <div id="soal-alert" class="mt-3"></div>
</div>
<script>
function fetchSubjects() {
    fetch('/guru/soal/filters')
        .then(res => res.json())
        .then(data => {
            const subjectSel = document.getElementById('subject_id');
            subjectSel.innerHTML = '<option value="">Pilih Mapel</option>';
            data.subjects.forEach(m => {
                subjectSel.innerHTML += `<option value="${m.id}">${m.name}</option>`;
            });
        });
}
document.addEventListener('DOMContentLoaded', function() {
    fetchSubjects();
    document.getElementById('form-soal').addEventListener('submit', function(e) {
        e.preventDefault();
        const form = e.target;
        const data = Object.fromEntries(new FormData(form));
        fetch('/guru/soal/store', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify(data)
        })
        .then(res => res.json())
        .then(res => {
            const alertDiv = document.getElementById('soal-alert');
            if (res.success) {
                alertDiv.innerHTML = '<div class="alert alert-success">Soal berhasil ditambahkan!</div>';
                form.reset();
            } else {
                alertDiv.innerHTML = '<div class="alert alert-danger">Gagal menambah soal.</div>';
            }
        })
        .catch(() => {
            document.getElementById('soal-alert').innerHTML = '<div class="alert alert-danger">Terjadi kesalahan.</div>';
        });
    });
});
</script>
@endsection
