@extends('layouts.master')
@section('title', 'Mata Pelajaran Saya')
@section('layoutContent')
<div class="card p-4">
	<h5 class="mb-3">Mata Pelajaran yang Anda Ampu</h5>
	<div class="table-responsive">
		<table class="table table-bordered align-middle" id="mapelTable">
			<thead class="table-light">
				<tr>
					<th>No</th>
					<th>Nama Mapel</th>
					<th>Kelas</th>
					<th>Jumlah Soal</th>
					<th>Jumlah Ujian</th>
				</tr>
			</thead>
			<tbody>
				<tr><td colspan="5" class="text-center">Memuat data...</td></tr>
			</tbody>
		</table>
	</div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
	fetch('/guru/mapel/list', {
		headers: { 'Accept': 'application/json' },
		credentials: 'same-origin'
	})
	.then(res => res.json())
	.then(data => {
		let rows = '';
		if (!data.length) rows = '<tr><td colspan="5" class="text-center">Belum ada mapel.</td></tr>';
		data.forEach((m, i) => {
			let kelas = Array.isArray(m.classes) ? m.classes.map(k => k.name).join(', ') : '-';
			let jumlahSoal = m.questions ? m.questions.length : 0;
			let jumlahUjian = m.exams ? m.exams.length : 0;
			rows += `<tr>
				<td>${i+1}</td>
				<td>${m.name}</td>
				<td>${kelas}</td>
				<td>${jumlahSoal}</td>
				<td>${jumlahUjian}</td>
			</tr>`;
		});
		document.querySelector('#mapelTable tbody').innerHTML = rows;
	});
});
</script>
@endpush