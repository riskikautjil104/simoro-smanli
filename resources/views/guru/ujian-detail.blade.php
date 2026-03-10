@extends('layouts.master')

@section('title', 'Detail Ujian')

@push('styles')
    <style>
        .page-header {
            background: linear-gradient(135deg, var(--primary), var(--accent));
            border-radius: 16px;
            padding: 24px 28px;
            color: #fff;
            position: relative;
            overflow: hidden;
            margin-bottom: 24px;
        }

        .page-header::before {
            content: '';
            position: absolute;
            width: 220px;
            height: 220px;
            background: rgba(255, 255, 255, 0.07);
            border-radius: 50%;
            top: -60px;
            right: -60px;
            pointer-events: none;
        }

        .page-header-content {
            position: relative;
            z-index: 2;
        }

        .page-header h4 {
            font-size: 1.3rem;
            font-weight: 700;
            margin: 0 0 4px;
        }

        .page-header p {
            font-size: 0.85rem;
            opacity: 0.85;
            margin: 0;
        }

        .btn-back {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            background: rgba(255, 255, 255, 0.2);
            color: #fff !important;
            border: 1.5px solid rgba(255, 255, 255, 0.4);
            padding: 8px 18px;
            border-radius: 50px;
            font-size: 0.82rem;
            font-weight: 600;
            text-decoration: none;
            backdrop-filter: blur(8px);
            transition: var(--transition);
        }

        .btn-back:hover {
            background: rgba(255, 255, 255, 0.32);
            transform: translateY(-1px);
            color: #fff !important;
        }

        .info-card {
            background: #fff;
            border-radius: 16px;
            border: 1px solid var(--border-color);
            box-shadow: var(--shadow-sm);
            padding: 24px;
            margin-bottom: 24px;
        }

        .info-card h5 {
            font-size: 1.05rem;
            font-weight: 700;
            color: var(--text-main);
            margin-bottom: 16px;
            padding-bottom: 12px;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .info-card h5 i {
            color: var(--primary);
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
            gap: 16px;
        }

        .info-item label {
            font-size: 0.7rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: var(--text-muted);
            display: block;
            margin-bottom: 4px;
        }

        .info-item span {
            font-size: 0.9rem;
            font-weight: 600;
            color: var(--text-main);
        }

        .stat-pills {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 16px;
        }

        .stat-pill {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(13, 110, 255, 0.07);
            border: 1px solid rgba(13, 110, 255, 0.12);
            border-radius: 50px;
            padding: 8px 16px;
            font-size: 0.82rem;
            font-weight: 600;
            color: var(--primary);
        }

        .stat-pill i {
            font-size: 1rem;
        }

        .table-card {
            background: #fff;
            border-radius: 16px;
            border: 1px solid var(--border-color);
            box-shadow: var(--shadow-sm);
            overflow: hidden;
            margin-bottom: 24px;
        }

        .table-card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 16px 20px;
            border-bottom: 1px solid var(--border-color);
            background: #f0f4ff;
        }

        .table-card-header h6 {
            font-size: 0.9rem;
            font-weight: 700;
            color: var(--text-main);
            margin: 0;
            display: flex;
            align-items: center;
            gap: 7px;
        }

        .table-card-header h6 i {
            color: var(--primary);
        }

        .table-card .table {
            margin: 0;
            font-size: 0.85rem;
        }

        .table-card .table thead th {
            background: #f8faff;
            font-weight: 600;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.4px;
            padding: 12px 16px;
            border-bottom: 1px solid var(--border-color);
            color: var(--text-main);
            white-space: nowrap;
        }

        .table-card .table tbody td {
            padding: 12px 16px;
            vertical-align: middle;
            border-bottom: 1px solid rgba(13, 110, 253, 0.04);
            color: var(--text-main);
        }

        .table-card .table tbody tr:last-child td {
            border-bottom: none;
        }

        .table-card .table tbody tr:hover {
            background: rgba(13, 110, 253, 0.025);
        }

        .siswa-avatar {
            width: 32px;
            height: 32px;
            background: linear-gradient(135deg, var(--secondary), #198754);
            border-radius: 8px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-weight: 700;
            font-size: 0.72rem;
            flex-shrink: 0;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            font-size: 0.72rem;
            font-weight: 700;
            padding: 4px 9px;
            border-radius: 20px;
        }

        .status-aktif {
            background: rgba(32, 201, 151, 0.1);
            color: #198754;
        }

        .status-selesai {
            background: rgba(108, 117, 125, 0.1);
            color: #6c757d;
        }

        .status-belum {
            background: rgba(255, 193, 7, 0.1);
            color: #856404;
        }

        .nilai-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 52px;
            padding: 5px 12px;
            border-radius: 20px;
            font-weight: 700;
            font-size: 0.85rem;
        }

        .nilai-a {
            background: rgba(32, 201, 151, 0.12);
            color: #198754;
        }

        .nilai-b {
            background: rgba(13, 110, 253, 0.1);
            color: var(--primary);
        }

        .nilai-c {
            background: rgba(255, 193, 7, 0.15);
            color: #856404;
        }

        .nilai-d {
            background: rgba(220, 53, 69, 0.1);
            color: #dc3545;
        }

        .nilai-na {
            background: #f0f4ff;
            color: #94a3b8;
        }

        .btn-act {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 6px 12px;
            border-radius: 8px;
            font-size: 0.78rem;
            font-weight: 600;
            border: none;
            cursor: pointer;
            transition: var(--transition);
            font-family: 'Poppins', sans-serif;
        }

        .btn-act-detail {
            background: rgba(13, 202, 240, 0.1);
            color: #0a9bba;
            text-decoration: none;
        }

        .btn-act-detail:hover {
            background: var(--accent);
            color: #fff;
            transform: translateY(-1px);
        }

        .empty-state {
            text-align: center;
            padding: 48px 24px;
        }

        .empty-state .empty-icon {
            width: 68px;
            height: 68px;
            background: rgba(13, 110, 253, 0.07);
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 1.7rem;
            color: var(--primary);
            margin-bottom: 14px;
        }

        .empty-state h6 {
            font-weight: 700;
            margin-bottom: 5px;
        }

        .empty-state p {
            font-size: 0.83rem;
            color: var(--text-muted);
            margin: 0;
        }
    </style>
@endpush

@section('layoutContent')

    <div class="page-header">
        <div class="page-header-content d-flex align-items-center justify-content-between flex-wrap gap-3">
            <div>
                <h4><i class="bi bi-file-earmark-text me-2"></i>Detail Ujian</h4>
                <p>{{ $exam->title ?? 'Ujian' }} - {{ $exam->subject->name ?? '-' }}</p>
            </div>
            <a href="{{ route('guru.ujian') }}" class="btn-back">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    {{-- Info Ujian --}}
    <div class="info-card">
        <h5><i class="bi bi-info-circle"></i> Informasi Ujian</h5>
        <div class="info-grid">
            <div class="info-item"><label>Nama Ujian</label><span>{{ $exam->title ?? '-' }}</span></div>
            <div class="info-item"><label>Mata Pelajaran</label><span>{{ $exam->subject->name ?? '-' }}</span></div>
            <div class="info-item"><label>Kelas</label><span>{{ $exam->schoolClass->name ?? '-' }}</span></div>
            <div class="info-item"><label>Waktu Mulai</label><span>{{ $exam->start_time ?? '-' }}</span></div>
            <div class="info-item"><label>Waktu Selesai</label><span>{{ $exam->end_time ?? '-' }}</span></div>
            <div class="info-item">
                <label>Durasi</label><span>{{ $exam->duration ? $exam->duration . ' menit' : '-' }}</span></div>
        </div>
        <div class="stat-pills">
            <div class="stat-pill"><i class="bi bi-people"></i> {{ $totalPeserta }} Peserta</div>
            <div class="stat-pill"><i class="bi bi-check-circle"></i> {{ $pesertaSelesai }} Selesai</div>
        </div>
    </div>

    {{-- Tabel Peserta --}}
    <div class="table-card">
        <div class="table-card-header">
            <h6><i class="bi bi-people"></i> Daftar Peserta Ujian</h6>
        </div>
        <div class="table-responsive">
            <table class="table" id="pesertaTable">
                <thead>
                    <tr>
                        <th style="width:48px;">No</th>
                        <th>Siswa</th>
                        <th>Mulai</th>
                        <th>Selesai</th>
                        <th>Durasi</th>
                        <th>Nilai</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody id="pesertaTbody">
                    <tr>
                        <td colspan="8">
                            <div class="empty-state">
                                <div class="empty-icon"><i class="bi bi-hourglass-split"></i></div>
                                <h6>Memuat data...</h6>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        var ujianId = {{ $exam->id }};

        function nilaiBadge(nilai) {
            if (nilai === null || nilai === undefined || nilai === '') return '<span class="nilai-badge nilai-na">—</span>';
            var n = parseFloat(nilai);
            var cls = n >= 85 ? 'nilai-a' : n >= 70 ? 'nilai-b' : n >= 55 ? 'nilai-c' : 'nilai-d';
            return '<span class="nilai-badge ' + cls + '">' + nilai + '</span>';
        }

        function statusBadge(status) {
            if (!status) return '<span class="status-badge status-belum">Belum Mulai</span>';
            var s = status.toLowerCase();
            if (s.includes('selesai') || s.includes('done'))
            return '<span class="status-badge status-selesai"><i class="bi bi-check-circle"></i> Selesai</span>';
            if (s.includes('aktif') || s.includes('running'))
            return '<span class="status-badge status-aktif"><i class="bi bi-play-circle"></i> Aktif</span>';
            return '<span class="status-badge status-belum"><i class="bi bi-clock"></i> ' + status + '</span>';
        }

        // Load participants
        fetch('/guru/ujian/' + ujianId + '/peserta', {
                headers: {
                    'Accept': 'application/json'
                }
            })
            .then(function(r) {
                return r.ok ? r.json() : [];
            })
            .then(function(data) {
                var tbody = document.getElementById('pesertaTbody');
                if (!data.length) {
                    tbody.innerHTML =
                        '<tr><td colspan="8"><div class="empty-state"><div class="empty-icon"><i class="bi bi-people"></i></div><h6>Belum ada peserta</h6></div></td></tr>';
                    return;
                }
                var rows = '';
                data.forEach(function(p, i) {
                    var inisial = p.user ? p.user.name.substring(0, 2).toUpperCase() : 'S';
                    var nama = p.user ? p.user.name : '-';
                    var nilai = p.score !== undefined && p.score !== null ? p.score : '';
                    var status = p.end_time ? 'Selesai' : (p.is_active ? 'Aktif' : 'Belum Mulai');

                    var btnPeriksa = p.end_time ?
                        '<a class="btn-act btn-act-detail" href="/guru/ujian/' + ujianId + '/peserta/' + (p
                            .user ? p.user.id : '') +
                        '/jawaban"><i class="bi bi-clipboard-check"></i> Periksa</a>' :
                        '<span style="color:#ccc;font-size:.75rem;">Belum ujian</span>';

                    rows += '<tr>' +
                        '<td>' + (i + 1) + '</td>' +
                        '<td><div class="d-flex align-items-center gap-2"><div class="siswa-avatar">' +
                        inisial + '</div><span style="font-weight:600;">' + nama + '</span></div></td>' +
                        '<td style="font-size:.8rem;">' + (p.start_time || '-') + '</td>' +
                        '<td style="font-size:.8rem;">' + (p.end_time || '-') + '</td>' +
                        '<td style="font-size:.8rem;">' + (p.start_time && p.end_time ? Math.round((new Date(p
                            .end_time) - new Date(p.start_time)) / 60000) + ' menit' : '-') + '</td>' +
                        '<td>' + nilaiBadge(nilai) + '</td>' +
                        '<td>' + statusBadge(status) + '</td>' +
                        '<td>' + btnPeriksa + '</td>' +
                        '</tr>';
                });
                tbody.innerHTML = rows;
            })
            .catch(function() {
                document.getElementById('pesertaTbody').innerHTML =
                    '<tr><td colspan="8"><div class="empty-state"><div class="empty-icon" style="background:rgba(220,53,69,.08);color:#dc3545;"><i class="bi bi-exclamation-circle"></i></div><h6>Gagal memuat data</h6></div></td></tr>';
            });
    </script>
@endpush
