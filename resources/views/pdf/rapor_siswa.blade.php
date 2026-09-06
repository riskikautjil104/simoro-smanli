<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Rapor Siswa - {{ $rapor->student->name }}</title>
    <style>
        @page {
            size: A4 portrait;
            margin: 1.5cm 1.5cm 1.5cm 1.5cm;
        }
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            font-size: 10pt;
            line-height: 1.4;
            color: #1a1a1a;
            margin: 0;
            padding: 0;
        }
        
        /* Kop Surat Resmi */
        .kop-table {
            width: 100%;
            border-collapse: collapse;
            border-bottom: 2.5px double #000;
            margin-bottom: 15px;
            padding-bottom: 8px;
        }
        .kop-table td {
            vertical-align: middle;
        }
        .kop-logo {
            width: 70px;
            text-align: center;
        }
        .kop-logo img {
            width: 65px;
            height: auto;
        }
        .kop-text {
            text-align: center;
        }
        .kop-text .instansi {
            font-size: 11pt;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin: 0;
        }
        .kop-text .dinas {
            font-size: 12pt;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin: 1px 0;
        }
        .kop-text .sekolah {
            font-size: 15pt;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #000;
            margin: 2px 0;
        }
        .kop-text .alamat {
            font-size: 8.5pt;
            color: #333;
            margin: 0;
        }

        /* Judul Dokumen */
        .judul-rapor {
            text-align: center;
            font-size: 12pt;
            font-weight: 800;
            text-transform: uppercase;
            margin: 10px 0 15px;
            letter-spacing: 0.5px;
            text-decoration: underline;
        }

        /* Biodata Siswa */
        .bio-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
            font-size: 9.5pt;
        }
        .bio-table td {
            padding: 2.5px 4px;
            vertical-align: top;
        }

        /* Tabel Nilai */
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        .data-table th, .data-table td {
            border: 1px solid #000;
            padding: 5px 7px;
            font-size: 9pt;
        }
        .data-table th {
            background-color: #f1f5f9;
            text-align: center;
            font-weight: bold;
        }
        .data-table td.text-center {
            text-align: center;
        }
        .data-table td.text-right {
            text-align: right;
        }

        /* Box Absensi & Catatan */
        .section-title {
            font-size: 9.5pt;
            font-weight: bold;
            margin: 8px 0 4px;
            text-transform: uppercase;
        }
        .catatan-box {
            border: 1px solid #000;
            padding: 8px;
            font-size: 9pt;
            min-height: 45px;
            margin-bottom: 15px;
            background-color: #fafafa;
        }

        /* Tanda Tangan */
        .ttd-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            page-break-inside: avoid;
        }
        .ttd-table td {
            vertical-align: top;
            text-align: center;
            font-size: 9pt;
            width: 33.3%;
        }
        .ttd-space {
            height: 60px;
        }
        .ttd-img {
            max-height: 55px;
            width: auto;
        }
        .nama-pejabat {
            font-weight: bold;
            text-decoration: underline;
        }
    </style>
</head>
<body>

    {{-- KOP SURAT --}}
    <table class="kop-table">
        <tr>
            <td class="kop-logo">
                @php
                    $logoPath = public_path('assets/img/icon.png');
                @endphp
                @if(file_exists($logoPath))
                    <img src="{{ $logoPath }}" alt="Logo">
                @endif
            </td>
            <td class="kop-text">
                <div class="instansi">PEMERINTAH PROVINSI MALUKU UTARA</div>
                <div class="dinas">DINAS PENDIDIKAN DAN KEBUDAYAAN</div>
                <div class="sekolah">SMA NEGERI 5 KABUPATEN PULAU MOROTAI</div>
                <div class="alamat">Jalan Siswa, Desa Morodadi, Kec. Morotai Selatan, Kab. Pulau Morotai, Maluku Utara 97771</div>
                <div class="alamat">Website: https://sma-n5-morotai.id | Email: info@sma-n5-morotai.id</div>
            </td>
        </tr>
    </table>

    {{-- JUDUL --}}
    <div class="judul-rapor">LAPORAN CAPAIAN HASIL BELAJAR PESERTA DIDIK</div>

    {{-- BIODATA --}}
    <table class="bio-table">
        <tr>
            <td style="width: 18%;"><strong>Nama Siswa</strong></td>
            <td style="width: 2%;">:</td>
            <td style="width: 40%;"><strong>{{ strtoupper($rapor->student->name) }}</strong></td>
            <td style="width: 18%;"><strong>Kelas</strong></td>
            <td style="width: 2%;">:</td>
            <td style="width: 20%;">{{ $rapor->schoolClass->name }}</td>
        </tr>
        <tr>
            <td><strong>NIS / NISN</strong></td>
            <td>:</td>
            <td>{{ $rapor->student->nis ?? '-' }} / {{ $rapor->student->nik ?? '-' }}</td>
            <td><strong>Semester</strong></td>
            <td>:</td>
            <td>{{ $rapor->semester }}</td>
        </tr>
        <tr>
            <td><strong>Nama Sekolah</strong></td>
            <td>:</td>
            <td>SMA Negeri 5 Pulau Morotai</td>
            <td><strong>Tahun Pelajaran</strong></td>
            <td>:</td>
            <td>{{ $rapor->tahun_ajaran }}</td>
        </tr>
    </table>

    {{-- TABEL NILAI MAPEL --}}
    <div class="section-title">A. Nilai Capaian Kompetensi Mata Pelajaran</div>
    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 5%;">No</th>
                <th style="width: 32%;">Mata Pelajaran</th>
                <th style="width: 11%;">Nilai Tugas</th>
                <th style="width: 11%;">Nilai CBT</th>
                <th style="width: 11%;">Nilai Akhir</th>
                <th style="width: 30%;">Capaian Pembelajaran</th>
            </tr>
        </thead>
        <tbody>
            @php $totalNilai = 0; $count = count($rapor->scores); @endphp
            @forelse($rapor->scores as $i => $s)
            @php $totalNilai += $s->nilai_akhir; @endphp
            <tr>
                <td class="text-center">{{ $i + 1 }}</td>
                <td>
                    <strong>{{ $s->subject->name }}</strong>
                    <br><small style="color:#555;">Guru: {{ $s->subject->teacher->name ?? '-' }}</small>
                </td>
                <td class="text-center">{{ number_format($s->nilai_tugas, 1) }}</td>
                <td class="text-center">{{ number_format($s->nilai_cbt, 1) }}</td>
                <td class="text-center"><strong>{{ number_format($s->nilai_akhir, 1) }}</strong></td>
                <td><small>{{ $s->capaian_kompetensi ?: 'Menunjukkan penguasaan capaian pembelajaran yang baik pada kompetensi dasar.' }}</small></td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center">Belum ada mata pelajaran tercatat.</td>
            </tr>
            @endforelse
            @if($count > 0)
            <tr style="background-color: #f8fafc; font-weight: bold;">
                <td colspan="4" class="text-right">Rata-rata Nilai Semester :</td>
                <td class="text-center">{{ number_format($totalNilai / $count, 2) }}</td>
                <td></td>
            </tr>
            @endif
        </tbody>
    </table>

    {{-- TABEL PRESENSI --}}
    <table style="width: 100%; border-collapse: collapse; margin-bottom: 10px;">
        <tr>
            <td style="width: 45%; vertical-align: top; padding-right: 15px;">
                <div class="section-title">B. Ketidakhadiran</div>
                <table class="data-table">
                    <tr>
                        <td style="width: 65%;">Sakit (S)</td>
                        <td class="text-center" style="width: 35%;">{{ $rapor->sakit }} hari</td>
                    </tr>
                    <tr>
                        <td>Izin (I)</td>
                        <td class="text-center">{{ $rapor->izin }} hari</td>
                    </tr>
                    <tr>
                        <td>Tanpa Keterangan (A)</td>
                        <td class="text-center">{{ $rapor->tanpa_keterangan }} hari</td>
                    </tr>
                </table>
            </td>
            <td style="width: 55%; vertical-align: top;">
                <div class="section-title">C. Status Akhir Semester</div>
                <div class="catatan-box" style="padding: 12px; font-weight: bold; color: #0284c7;">
                    {{ $rapor->status_kenaikan ?: 'Aktif Mengikuti Pembelajaran Semester ' . $rapor->semester }}
                </div>
            </td>
        </tr>
    </table>

    {{-- CATATAN WALI KELAS --}}
    <div class="section-title">D. Catatan Wali Kelas</div>
    <div class="catatan-box">
        {{ $rapor->catatan_wali_kelas ?: 'Tingkatkan terus motivasi belajar dan pertahankan prestasi yang telah dicapai pada semester ini.' }}
    </div>

    {{-- PENGESAHAN & TANDA TANGAN --}}
    <table class="ttd-table">
        <tr>
            <td>
                Mengetahui,<br>
                Orang Tua / Wali Murid
                <div class="ttd-space"></div>
                <div class="nama-pejabat">( ........................................ )</div>
            </td>
            <td>
                {{-- Spacer --}}
            </td>
            <td>
                Morotai Selatan, {{ $rapor->tanggal_rapor ? \Carbon\Carbon::parse($rapor->tanggal_rapor)->translatedFormat('d F Y') : date('d F Y') }}<br>
                Wali Kelas,
                <div class="ttd-space" style="display: flex; align-items: center; justify-content: center;">
                    @if($rapor->waliKelas && $rapor->waliKelas->ttd_signature)
                        @php
                            $waliTtdPath = storage_path('app/public/' . str_replace('/storage/', '', $rapor->waliKelas->ttd_signature));
                        @endphp
                        @if(file_exists($waliTtdPath))
                            <img src="{{ $waliTtdPath }}" class="ttd-img" alt="TTD Wali Kelas">
                        @endif
                    @endif
                </div>
                <div class="nama-pejabat">{{ $rapor->waliKelas->name ?? '-' }}</div>
                <div>NIP. {{ $rapor->waliKelas->nip ?? '-' }}</div>
            </td>
        </tr>
        <tr>
            <td colspan="3" style="padding-top: 15px;">
                Mengetahui,<br>
                Kepala SMA Negeri 5 Pulau Morotai
                <div class="ttd-space" style="display: flex; align-items: center; justify-content: center;">
                    @if($kepsek && $kepsek->ttd_signature)
                        @php
                            $kepsekTtdPath = storage_path('app/public/' . str_replace('/storage/', '', $kepsek->ttd_signature));
                        @endphp
                        @if(file_exists($kepsekTtdPath))
                            <img src="{{ $kepsekTtdPath }}" class="ttd-img" alt="TTD Kepsek">
                        @endif
                    @endif
                </div>
                <div class="nama-pejabat">{{ $kepsek->name ?? 'Kepala Sekolah' }}</div>
                <div>NIP. {{ $kepsek->nip ?? '-' }}</div>
            </td>
        </tr>
    </table>

</body>
</html>
