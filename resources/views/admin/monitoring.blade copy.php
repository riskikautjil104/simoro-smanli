@extends('layouts.master')

@section('title', 'Monitoring Ujian')

@section('layoutContent')
<div class="container py-4">
    <h4>Monitoring Ujian (Real-time)</h4>
    <div class="card">
        <div class="card-body">
            <table class="table table-bordered" id="monitoringTable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Ujian</th>
                        <th>Kelas</th>
                        <th>Jumlah Peserta</th>
                        <th>Peserta Selesai</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- Data monitoring akan di-render di sini --}}
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function loadMonitoring() {
    fetch('/admin/monitoring/data', { headers: { 'Accept': 'application/json' }, credentials: 'same-origin' })
        .then(res => res.json())
        .then(data => {
            let rows = '';
            if (!data.length) rows = '<tr><td colspan="7" class="text-center">Tidak ada ujian.</td></tr>';
            data.forEach((u, i) => {
                rows += `<tr>
                    <td>${i+1}</td>
                    <td>${u.nama}</td>
                    <td>${u.kelas}</td>
                    <td>${u.jumlah_peserta}</td>
                    <td>${u.peserta_selesai}</td>
                    <td><span class="badge bg-${u.status === 'Selesai' ? 'success' : (u.status === 'Sedang Berlangsung' ? 'warning' : 'secondary')}">${u.status}</span></td>
                    <td><a href="/admin/ujian/${u.id}/detail" class="btn btn-sm btn-info">Detail</a></td>
                </tr>`;
            });
            document.querySelector('#monitoringTable tbody').innerHTML = rows;
        });
}
setInterval(loadMonitoring, 5000); // polling tiap 5 detik
loadMonitoring(); // initial load
</script>
@endpush
