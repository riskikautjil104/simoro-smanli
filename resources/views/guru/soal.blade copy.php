@extends('layouts.master')
@section('title', 'Bank Soal')
@section('layoutContent')
<div class="card p-4">
	<h4>Bank Soal Saya</h4>
	<div class="row mb-3">
		<div class="col-md-3">
			<label for="filter-kelas" class="form-label">Kelas</label>
			<select id="filter-kelas" class="form-select">
				<option value="">Semua Kelas</option>
			</select>
		</div>
		<div class="col-md-3">
			<label for="filter-mapel" class="form-label">Mata Pelajaran</label>
			<select id="filter-mapel" class="form-select">
				<option value="">Semua Mapel</option>
			</select>
		</div>
		<div class="col-md-3">
			<label for="filter-ujian" class="form-label">Ujian</label>
			<select id="filter-ujian" class="form-select">
				<option value="">Semua Ujian</option>
			</select>
		</div>
		<div class="col-md-3 d-flex align-items-end">
			<button id="btn-filter" class="btn btn-primary w-100">Terapkan Filter</button>
		</div>
	</div>
	<div class="table-responsive">
		<table class="table table-bordered" id="soal-table">
			<thead>
				<tr>
					<th>No</th>
					<th>Mata Pelajaran</th>
					<th>Kelas</th>
					<th>Ujian</th>
					<th>Pertanyaan</th>
					<th>Tipe</th>
					<th>Opsi A</th>
					<th>Opsi B</th>
					<th>Opsi C</th>
					<th>Opsi D</th>
					<th>Jawaban Benar</th>
				</tr>
			</thead>
			<tbody></tbody>
		</table>
	</div>
</div>
<script>
let soalData = [];
let examsData = [];
let subjectsData = [];
let kelasData = [];

function renderSoalTable(data) {
	const tbody = document.querySelector('#soal-table tbody');
	tbody.innerHTML = '';
	data.forEach((soal, idx) => {
		// Cari info ujian dan kelas
		let ujian = examsData.find(e => e.id === soal.exam_id);
		let kelas = ujian && ujian.school_class ? ujian.school_class.name : '-';
		let ujianTitle = ujian ? ujian.title : '-';
		tbody.innerHTML += `
			<tr>
				<td>${idx+1}</td>
				<td>${soal.subject ? soal.subject.name : '-'}</td>
				<td>${kelas}</td>
				<td>${ujianTitle}</td>
				<td>${soal.pertanyaan || soal.question_text || '-'}</td>
				<td>${soal.type || '-'}</td>
				<td>${soal.opsi_a || '-'}</td>
				<td>${soal.opsi_b || '-'}</td>
				<td>${soal.opsi_c || '-'}</td>
				<td>${soal.opsi_d || '-'}</td>
				<td>${soal.jawaban_benar || soal.answer_key || '-'}</td>
			</tr>
		`;
	});
}

function applyFilters() {
	const kelasId = document.getElementById('filter-kelas').value;
	const mapelId = document.getElementById('filter-mapel').value;
	const ujianId = document.getElementById('filter-ujian').value;
	let filtered = soalData;
	if (kelasId) {
		filtered = filtered.filter(s => {
			let ujian = examsData.find(e => e.id === s.exam_id);
			return ujian && ujian.school_class && ujian.school_class.id == kelasId;
		});
	}
	if (mapelId) {
		filtered = filtered.filter(s => s.subject_id == mapelId);
	}
	if (ujianId) {
		filtered = filtered.filter(s => s.exam_id == ujianId);
	}
	renderSoalTable(filtered);
}

document.addEventListener('DOMContentLoaded', function() {
	// Ambil filter data
	fetch('/guru/soal/filters')
		.then(res => res.json())
		.then(filter => {
			subjectsData = filter.subjects;
			examsData = filter.exams;
			// Kumpulkan kelas dari subjects
			let kelasSet = new Map();
			filter.subjects.forEach(m => {
				(m.classes || []).forEach(k => kelasSet.set(k.id, k.name));
			});
			filter.exams.forEach(e => {
				if (e.school_class) kelasSet.set(e.school_class.id, e.school_class.name);
			});
			kelasData = Array.from(kelasSet, ([id, name]) => ({id, name}));
			// Isi dropdown
			const kelasSel = document.getElementById('filter-kelas');
			kelasData.forEach(k => {
				kelasSel.innerHTML += `<option value="${k.id}">${k.name}</option>`;
			});
			const mapelSel = document.getElementById('filter-mapel');
			subjectsData.forEach(m => {
				mapelSel.innerHTML += `<option value="${m.id}">${m.name}</option>`;
			});
			const ujianSel = document.getElementById('filter-ujian');
			examsData.forEach(u => {
				ujianSel.innerHTML += `<option value="${u.id}">${u.title}</option>`;
			});
		});
	// Ambil data soal
	fetch('/guru/soal/list')
		.then(res => res.json())
		.then(data => {
			soalData = data;
			renderSoalTable(soalData);
		});
	document.getElementById('btn-filter').addEventListener('click', applyFilters);
});
</script>
@endsection