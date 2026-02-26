@extends('layouts.master')
@section('title', 'Buat Ujian')
@section('layoutContent')
<div class="card p-4">
	<h4>Daftar Ujian Saya</h4>
	<div class="table-responsive">
		<table class="table table-bordered" id="ujian-table">
			<thead>
				<tr>
					<th>No</th>
					<th>Judul Ujian</th>
					<th>Mata Pelajaran</th>
					<th>Kelas</th>
					<th>Waktu Mulai</th>
					<th>Waktu Selesai</th>
					<th>Durasi (menit)</th>
					<th>Status</th>
				</tr>
			</thead>
			<tbody></tbody>
		</table>
	</div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
	fetch('/guru/ujian/list')
		.then(res => res.json())
		.then(data => {
			const tbody = document.querySelector('#ujian-table tbody');
			tbody.innerHTML = '';
			data.forEach((ujian, idx) => {
				tbody.innerHTML += `
					<tr>
						<td>${idx+1}</td>
						<td>${ujian.title}</td>
						<td>${ujian.subject ? ujian.subject.name : '-'}</td>
						<td>${ujian.school_class ? ujian.school_class.name : '-'}</td>
						<td>${ujian.start_time || '-'}</td>
						<td>${ujian.end_time || '-'}</td>
						<td>${ujian.duration || '-'}</td>
						<td>${ujian.status || '-'}</td>
					</tr>
				`;
			});
		});
});
</script>
@endsection