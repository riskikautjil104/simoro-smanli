@extends('layouts.master')
@section('title', 'Tambah Soal Batch')
@section('layoutContent')
<div class="card p-4 mb-4">
    <h4>Tambah Soal ke Ujian</h4>
    <form id="form-batch-soal">
        <div class="row mb-3">
            <div class="col-md-4">
                <label class="form-label">Mata Pelajaran</label>
                <select name="subject_id" id="subject_id" class="form-select" required></select>
            </div>
            <div class="col-md-4">
                <label class="form-label">Kelas</label>
                <select name="class_id" id="class_id" class="form-select" required></select>
            </div>
            <div class="col-md-4">
                <label class="form-label">Ujian</label>
                <select name="exam_id" id="exam_id" class="form-select" required></select>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label">Jumlah Soal Pilihan Ganda</label>
                <input type="number" name="jumlah_pg" class="form-control" min="0" value="0">
            </div>
            <div class="col-md-6">
                <label class="form-label">Jumlah Soal Esai</label>
                <input type="number" name="jumlah_esai" class="form-control" min="0" value="0">
            </div>
        </div>
        <button type="button" class="btn btn-primary" id="btn-generate">Generate Form Soal</button>
        <div id="generated-soal"></div>
        <button type="submit" class="btn btn-success mt-3 d-none" id="btn-submit">Simpan Semua Soal</button>
    </form>
    <div id="soal-alert" class="mt-3"></div>
</div>
<script>
let subjectsData = [];
let examsData = [];
let kelasData = [];
function fetchFilters() {
    fetch('/guru/soal/filters')
        .then(res => res.json())
        .then(data => {
            subjectsData = data.subjects;
            examsData = data.exams;
            // Kumpulkan kelas dari subjects
            let kelasSet = new Map();
            data.subjects.forEach(m => {
                (m.classes || []).forEach(k => kelasSet.set(k.id, k.name));
            });
            data.exams.forEach(e => {
                if (e.school_class) kelasSet.set(e.school_class.id, e.school_class.name);
            });
            kelasData = Array.from(kelasSet, ([id, name]) => ({id, name}));
            // Isi dropdown
            const kelasSel = document.getElementById('class_id');
            kelasSel.innerHTML = '<option value="">Pilih Kelas</option>';
            kelasData.forEach(k => {
                kelasSel.innerHTML += `<option value="${k.id}">${k.name}</option>`;
            });
            const mapelSel = document.getElementById('subject_id');
            mapelSel.innerHTML = '<option value="">Pilih Mapel</option>';
            subjectsData.forEach(m => {
                mapelSel.innerHTML += `<option value="${m.id}">${m.name}</option>`;
            });
            const ujianSel = document.getElementById('exam_id');
            ujianSel.innerHTML = '<option value="">Pilih Ujian</option>';
            examsData.forEach(u => {
                ujianSel.innerHTML += `<option value="${u.id}" data-mapel="${u.subject_id}" data-kelas="${u.class_id}">${u.title}</option>`;
            });
            // Event: ketika exam dipilih, isi mapel & kelas otomatis
            ujianSel.addEventListener('change', function() {
                const selected = examsData.find(e => e.id == this.value);
                if (selected) {
                    mapelSel.value = selected.subject_id;
                    kelasSel.value = selected.class_id;
                }
            });
        });
}
function generateSoalForm() {
    const jumlah_pg = parseInt(document.querySelector('[name="jumlah_pg"]').value) || 0;
    const jumlah_esai = parseInt(document.querySelector('[name="jumlah_esai"]').value) || 0;
    let html = '';
    if (jumlah_pg > 0) {
        html += '<h5 class="mt-4">Soal Pilihan Ganda</h5>';
        for (let i = 1; i <= jumlah_pg; i++) {
            html += `<div class="border rounded p-3 mb-3"><b>Soal PG #${i}</b>
                <div class="mb-2"><label>Pertanyaan</label><textarea name="pg_pertanyaan_${i}" class="form-control" required></textarea></div>
                <div class="row mb-2">
                    <div class="col-md-3"><label>Opsi A</label><input type="text" name="pg_opsi_a_${i}" class="form-control" required></div>
                    <div class="col-md-3"><label>Opsi B</label><input type="text" name="pg_opsi_b_${i}" class="form-control" required></div>
                    <div class="col-md-3"><label>Opsi C</label><input type="text" name="pg_opsi_c_${i}" class="form-control" required></div>
                    <div class="col-md-3"><label>Opsi D</label><input type="text" name="pg_opsi_d_${i}" class="form-control" required></div>
                </div>
                <div><label>Jawaban Benar</label>
                    <select name="pg_jawaban_benar_${i}" class="form-select" required>
                        <option value="">Pilih Jawaban</option>
                        <option value="A">A</option>
                        <option value="B">B</option>
                        <option value="C">C</option>
                        <option value="D">D</option>
                    </select>
                </div>
            </div>`;
        }
    }
    if (jumlah_esai > 0) {
        html += '<h5 class="mt-4">Soal Esai</h5>';
        for (let i = 1; i <= jumlah_esai; i++) {
            html += `<div class="border rounded p-3 mb-3"><b>Soal Esai #${i}</b>
                <div class="mb-2"><label>Pertanyaan</label><textarea name="esai_pertanyaan_${i}" class="form-control" required></textarea></div>
            </div>`;
        }
    }
    document.getElementById('generated-soal').innerHTML = html;
    document.getElementById('btn-submit').classList.toggle('d-none', (jumlah_pg+jumlah_esai) === 0);
}
document.addEventListener('DOMContentLoaded', function() {
    fetchFilters();
    document.getElementById('btn-generate').addEventListener('click', generateSoalForm);
    document.getElementById('form-batch-soal').addEventListener('submit', function(e) {
        e.preventDefault();
        const form = e.target;
        const fd = new FormData(form);
        const data = Object.fromEntries(fd.entries());
        fetch('/guru/soal/batch', {
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
                alertDiv.innerHTML = '<div class="alert alert-success">Semua soal berhasil ditambahkan!</div>';
                form.reset();
                document.getElementById('generated-soal').innerHTML = '';
                document.getElementById('btn-submit').classList.add('d-none');
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
