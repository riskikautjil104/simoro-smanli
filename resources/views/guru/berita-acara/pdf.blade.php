<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Berita Acara - {{ $exam->title }}</title>
    <style>
        @page {
            margin: 1.5cm 1.5cm 2cm 1.5cm;
        }
        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 11pt;
            line-height: 1.35;
            color: #000;
        }
        /* Kop Surat */
        .kop-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 2px;
        }
        .kop-table td {
            vertical-align: middle;
            text-align: center;
        }
        .kop-title-1 { font-size: 12pt; font-weight: bold; text-transform: uppercase; margin: 0; }
        .kop-title-2 { font-size: 13pt; font-weight: bold; text-transform: uppercase; margin: 0; }
        .kop-title-3 { font-size: 14pt; font-weight: bold; text-transform: uppercase; margin: 0; letter-spacing: 1px; }
        .kop-address { font-size: 9pt; font-style: italic; margin: 0; }
        .kop-line {
            border-top: 2px solid #000;
            border-bottom: 1px solid #000;
            height: 2px;
            margin-top: 4px;
            margin-bottom: 15px;
        }

        /* Title Document */
        .doc-title {
            text-align: center;
            font-size: 12pt;
            font-weight: bold;
            text-transform: uppercase;
            text-decoration: underline;
            margin-bottom: 2px;
        }
        .doc-subtitle {
            text-align: center;
            font-size: 10pt;
            margin-bottom: 15px;
        }

        /* Meta Table */
        .meta-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 12px;
            font-size: 10.5pt;
        }
        .meta-table td {
            padding: 3px 0;
            vertical-align: top;
        }

        /* Content Table */
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
            font-size: 10pt;
        }
        .data-table th, .data-table td {
            border: 1px solid #000;
            padding: 5px 6px;
            vertical-align: middle;
        }
        .data-table th {
            background-color: #f2f2f2;
            text-align: center;
            font-weight: bold;
        }
        .text-center { text-align: center; }
        .text-end { text-align: right; }

        /* Catatan Box */
        .notes-box {
            border: 1px solid #000;
            padding: 6px 10px;
            min-height: 40px;
            margin-bottom: 20px;
            font-size: 10pt;
        }

        /* Signature Section */
        .ttd-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
            page-break-inside: avoid;
        }
        .ttd-table td {
            width: 50%;
            vertical-align: top;
            text-align: center;
            font-size: 10.5pt;
        }
        .ttd-space {
            height: 65px;
        }
        .ttd-img {
            max-height: 60px;
            max-width: 140px;
        }
    </style>
</head>
<body>

    {{-- KOP SURAT RESMI --}}
    <table class="kop-table">
        <tr>
            <td style="width: 15%;">
                @if(file_exists(public_path('assets/img/icon.png')))
                    <img src="{{ public_path('assets/img/icon.png') }}" style="width: 65px; height: auto;" alt="Logo">
                @endif
            </td>
            <td style="width: 85%;">
                <div class="kop-title-1">PEMERINTAH PROVINSI MALUKU UTARA</div>
                <div class="kop-title-2">DINAS PENDIDIKAN DAN KEBUDAYAAN</div>
                <div class="kop-title-3">SMA NEGERI 5 PULAU MOROTAI</div>
                <div class="kop-address">Alamat: Jl. Siswa, Kab. Pulau Morotai, Maluku Utara | Web: SIMORO SMANLI</div>
            </td>
        </tr>
    </table>
    <div class="kop-line"></div>

    {{-- JUDUL BERITA ACARA --}}
    <div class="doc-title">BERITA ACARA PELAKSANAAN UJIAN (CBT)</div>
    <div class="doc-subtitle">Nomor: ...... / BA-CBT / SMAN.5 / {{ now()->format('Y') }}</div>

    {{-- NARASI & IDENTITAS UJIAN --}}
    <p style="margin-bottom: 10px; text-align: justify;">
        Pada hari ini <strong>{{ now()->translatedFormat('l') }}</strong>, tanggal <strong>{{ now()->translatedFormat('d F Y') }}</strong>, telah diselenggarakan Ujian Berbasis Komputer (CBT) pada SMA Negeri 5 Pulau Morotai dengan rincian data sebagai berikut:
    </p>

    <table class="meta-table">
        <tr>
            <td style="width: 25%;"><strong>Nama Ujian</strong></td>
            <td style="width: 2%;">:</td>
            <td style="width: 73%;">{{ $exam->title }}</td>
        </tr>
        <tr>
            <td><strong>Mata Pelajaran</strong></td>
            <td>:</td>
            <td>{{ $exam->subject ? $exam->subject->name : '-' }}</td>
        </tr>
        <tr>
            <td><strong>Kelas / Rombel</strong></td>
            <td>:</td>
            <td>{{ $exam->schoolClass ? $exam->schoolClass->name : '-' }}</td>
        </tr>
        <tr>
            <td><strong>Guru Pengampu</strong></td>
            <td>:</td>
            <td>{{ $guru->name ?? '-' }} (NIP: {{ $guru->nip ?? '-' }})</td>
        </tr>
        <tr>
            <td><strong>Waktu Pelaksanaan</strong></td>
            <td>:</td>
            <td>{{ $exam->start_time ? $exam->start_time->format('d/m/Y H:i') : '-' }} s/d {{ $exam->end_time ? $exam->end_time->format('H:i') : '-' }} WIT ({{ $exam->duration ?? 0 }} Menit)</td>
        </tr>
        <tr>
            <td><strong>Rekapitulasi Kehadiran</strong></td>
            <td>:</td>
            <td>
                Total Siswa Masuk: <strong>{{ count($sessions) }}</strong> orang | 
                Selesai: <strong>{{ collect($sessions)->where('status', 'Selesai')->count() }}</strong> orang | 
                Belum Selesai: <strong>{{ collect($sessions)->where('status', 'Belum Selesai')->count() }}</strong> orang
            </td>
        </tr>
    </table>

    {{-- TABEL PRESENSI SISWA --}}
    <div style="font-weight: bold; margin-bottom: 5px; font-size: 10.5pt;">DAFTAR HADIR & STATUS PENGERJAAN SISWA:</div>
    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 6%;">No</th>
                <th style="width: 32%;">Nama Lengkap Siswa</th>
                <th style="width: 16%;">NIS / NISN</th>
                <th style="width: 14%;">Waktu Mulai</th>
                <th style="width: 14%;">Waktu Selesai</th>
                <th style="width: 18%;">Status / TTD</th>
            </tr>
        </thead>
        <tbody>
            @forelse($sessions as $s)
            <tr>
                <td class="text-center">{{ $s['no'] }}</td>
                <td>{{ $s['nama'] }}</td>
                <td class="text-center">{{ $s['nis'] }}</td>
                <td class="text-center">{{ $s['start_time'] }}</td>
                <td class="text-center">{{ $s['end_time'] }}</td>
                <td class="text-center">
                    @if($s['status'] === 'Selesai')
                        <strong style="color: #0b7036;">SELESAI</strong>
                    @else
                        <span style="color: #9c6500;">BELUM</span>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center" style="padding: 15px;">Tidak ada data peserta ujian.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    {{-- CATATAN PELAKSANAAN --}}
    <div style="font-weight: bold; margin-bottom: 3px; font-size: 10pt;">Catatan Kejadian Selama Ujian:</div>
    <div class="notes-box">
        Pelaksanaan ujian berlangsung dengan tertib, lancar, dan mematuhi seluruh tata tertib ujian sekolah.
    </div>

    {{-- TANDA TANGAN --}}
    <table class="ttd-table">
        <tr>
            <td>
                Mengetahui,<br>
                Kepala SMA Negeri 5 Pulau Morotai
                <div class="ttd-space" style="text-align: center;">
                    @if(!empty($kepsek->ttd_signature))
                        <img src="{{ $kepsek->ttd_signature }}" class="ttd-img" alt="TTD Kepala Sekolah">
                    @else
                        <br><br><br>
                    @endif
                </div>
                <strong><u>{{ $kepsek->name ?? 'Kepala Sekolah' }}</u></strong><br>
                NIP. {{ $kepsek->nip ?? ($kepsek->nik ?? '-') }}
            </td>
            <td>
                Morotai, {{ now()->translatedFormat('d F Y') }}<br>
                Guru Mata Pelajaran / Pengawas,
                <div class="ttd-space" style="text-align: center;">
                    @if(!empty($guru->ttd_signature))
                        <img src="{{ $guru->ttd_signature }}" class="ttd-img" alt="TTD Guru">
                    @else
                        <br><br><br>
                    @endif
                </div>
                <strong><u>{{ $guru->name ?? 'Guru Pengampu' }}</u></strong><br>
                NIP. {{ $guru->nip ?? ($guru->nik ?? '-') }}
            </td>
        </tr>
    </table>

</body>
</html>
