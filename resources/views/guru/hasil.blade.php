@extends('layouts.master')
@section('title', 'Hasil Ujian')
@section('layoutContent')
<div class="card p-4">
	<h4>Hasil Ujian Siswa</h4>
	<div class="row mb-3">
		<div class="col-md-3">
			<label class="form-label">Siswa</label>
			<select id="filter-siswa" class="form-select">
				<option value="">Semua Siswa</option>
			</select>
		</div>
		<div class="col-md-3">
			<label class="form-label">Mata Pelajaran</label>
			<select id="filter-mapel" class="form-select">
				<option value="">Semua Mapel</option>
			</select>
		</div>
		<div class="col-md-3">
			<label class="form-label">Ujian</label>
			<select id="filter-ujian" class="form-select">
				<option value="">Semua Ujian</option>
			</select>
		</div>
		<div class="col-md-3 d-flex align-items-end">
			<button id="btn-filter" class="btn btn-primary w-100">Terapkan Filter</button>
		</div>
	</div>
	<div class="mb-3">
		<button id="btn-export-pdf" class="btn btn-danger me-2">Export PDF</button>
		<button id="btn-export-excel" class="btn btn-success">Export Excel</button>
	</div>
	<div class="table-responsive">
		<table class="table table-bordered" id="hasil-table">
			<thead>
				<tr>
					<th>No</th>
					<th>Nama Siswa</th>
					<th>Kelas</th>
					<th>Ujian</th>
					<th>Mata Pelajaran</th>
					<th>Nilai</th>
					<th>Status</th>
					<th>TTD</th>
				</tr>
			</thead>
			<tbody></tbody>
		</table>
	</div>
	   <div class="mt-4">
		   <label class="form-label">Tanda Tangan Guru (Canvas)</label>
		   <canvas id="ttd-canvas" width="300" height="100" style="border:1px solid #ccc;"></canvas>
		   <button id="btn-clear-ttd" class="btn btn-secondary btn-sm ms-2">Clear</button>
		   <div id="ttd-guru-preview" class="mt-2"></div>
	   </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
<script>
let hasilData = [];
let siswaData = [];
let mapelData = [];
let ujianData = [];
function renderTable(data) {
	const tbody = document.querySelector('#hasil-table tbody');
	tbody.innerHTML = '';
	data.forEach((hasil, idx) => {
		tbody.innerHTML += `
			<tr>
				<td>${idx+1}</td>
				<td>${hasil.student ? hasil.student.name : '-'}</td>
				<td>${hasil.exam && hasil.exam.school_class ? hasil.exam.school_class.name : '-'}</td>
				<td>${hasil.exam ? hasil.exam.title : '-'}</td>
				<td>${hasil.exam && hasil.exam.subject ? hasil.exam.subject.name : '-'}</td>
				<td>${hasil.score ?? '-'}</td>
				<td>${hasil.status ?? '-'}</td>
				<td><img src="${hasil.student && hasil.student.ttd_signature ? hasil.student.ttd_signature : ''}" alt="TTD" style="max-width:80px;max-height:40px;"></td>
			</tr>
		`;
	});
}
function applyFilters() {
	const siswaId = document.getElementById('filter-siswa').value;
	const mapelId = document.getElementById('filter-mapel').value;
	const ujianId = document.getElementById('filter-ujian').value;
	let filtered = hasilData;
	if (siswaId) filtered = filtered.filter(h => h.student && h.student.id == siswaId);
	if (mapelId) filtered = filtered.filter(h => h.exam && h.exam.subject && h.exam.subject.id == mapelId);
	if (ujianId) filtered = filtered.filter(h => h.exam && h.exam.id == ujianId);
	renderTable(filtered);
}
function fetchFilters() {
	fetch('/guru/hasil/filters')
		.then(res => res.json())
		.then(filter => {
			// Mapel
			const mapelSel = document.getElementById('filter-mapel');
			mapelSel.innerHTML = '<option value="">Semua Mapel</option>';
			filter.subjects.forEach(m => {
				mapelSel.innerHTML += `<option value="${m.id}">${m.name}</option>`;
			});
			// Ujian
			const ujianSel = document.getElementById('filter-ujian');
			ujianSel.innerHTML = '<option value="">Semua Ujian</option>';
			filter.exams.forEach(u => {
				ujianSel.innerHTML += `<option value="${u.id}">${u.title}</option>`;
			});
		});
}
document.addEventListener('DOMContentLoaded', function() {
	fetchFilters();
	fetch('/guru/hasil/list')
		.then(res => res.json())
		.then(data => {
			hasilData = data.results ?? data;
			// Kumpulkan siswa unik
			let siswaSet = new Map();
			hasilData.forEach(h => {
				if (h.student) siswaSet.set(h.student.id, h.student.name);
			});
			siswaData = Array.from(siswaSet, ([id, name]) => ({id, name}));
			// Isi dropdown siswa
			const siswaSel = document.getElementById('filter-siswa');
			siswaData.forEach(s => {
				siswaSel.innerHTML += `<option value="${s.id}">${s.name}</option>`;
			});
			renderTable(hasilData);
			// Tampilkan TTD guru jika ada
			if (data.guru_ttd) {
				let ttdGuru = document.getElementById('ttd-guru-img');
				if (!ttdGuru) {
					ttdGuru = document.createElement('img');
					ttdGuru.id = 'ttd-guru-img';
					ttdGuru.style.maxWidth = '120px';
					ttdGuru.style.maxHeight = '60px';
					ttdGuru.style.display = 'block';
					ttdGuru.className = 'mt-2';
					document.getElementById('ttd-guru-preview').appendChild(ttdGuru);
				}
				ttdGuru.src = data.guru_ttd;
			}
		});
	document.getElementById('btn-filter').addEventListener('click', applyFilters);
	// TTD Canvas
	const canvas = document.getElementById('ttd-canvas');
	const ctx = canvas.getContext('2d');
	let drawing = false;
	canvas.addEventListener('mousedown', e => { drawing = true; ctx.beginPath(); });
	canvas.addEventListener('mouseup', e => { drawing = false; });
	canvas.addEventListener('mouseout', e => { drawing = false; });
	canvas.addEventListener('mousemove', function(e) {
		if (!drawing) return;
		const rect = canvas.getBoundingClientRect();
		ctx.lineTo(e.clientX - rect.left, e.clientY - rect.top);
		ctx.stroke();
	});
	document.getElementById('btn-clear-ttd').addEventListener('click', function() {
		ctx.clearRect(0, 0, canvas.width, canvas.height);
	});
	// Export PDF
	document.getElementById('btn-export-pdf').addEventListener('click', function() {
		const { jsPDF } = window.jspdf;
		const doc = new jsPDF();
		doc.text('Hasil Ujian Siswa', 10, 10);
		let y = 20;
		hasilData.forEach((h, idx) => {
			doc.text(`${idx+1}. ${h.student ? h.student.name : '-'} | ${h.exam && h.exam.title ? h.exam.title : '-'} | ${h.score ?? '-'}`, 10, y);
			y += 8;
		});
		doc.save('hasil-ujian.pdf');
	});
	// Export Excel
	document.getElementById('btn-export-excel').addEventListener('click', function() {
		const ws = XLSX.utils.json_to_sheet(hasilData.map((h, idx) => ({
			No: idx+1,
			Siswa: h.student ? h.student.name : '-',
			Kelas: h.exam && h.exam.school_class ? h.exam.school_class.name : '-',
			Ujian: h.exam ? h.exam.title : '-',
			Mapel: h.exam && h.exam.subject ? h.exam.subject.name : '-',
			Nilai: h.score ?? '-',
			Status: h.status ?? '-'
		})));
		const wb = XLSX.utils.book_new();
		XLSX.utils.book_append_sheet(wb, ws, 'Hasil Ujian');
		XLSX.writeFile(wb, 'hasil-ujian.xlsx');
	});
});
</script>
@endsection