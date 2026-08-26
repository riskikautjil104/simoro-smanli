<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $title ?? 'Data Kelulusan Siswa' }}</title>
    <style>
        @page {
            margin: 20px 25px 25px 25px;
        }
        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
            color: #222;
            margin: 0;
            padding: 0;
        }

        /* ── KOP SURAT ── */
        .kop-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 4px;
        }
        .kop-table td {
            vertical-align: middle;
        }
        .school-name {
            font-size: 15px;
            font-weight: bold;
            letter-spacing: 0.5px;
            color: #111;
        }
        .app-name {
            font-size: 11px;
            color: #444;
            font-weight: bold;
        }
        .school-address {
            font-size: 9.5px;
            color: #666;
            margin-top: 2px;
        }
        .sub-header-line-1 {
            border-top: 2px solid #222;
            margin-top: 6px;
        }
        .sub-header-line-2 {
            border-top: 1px solid #222;
            margin-top: 2px;
            margin-bottom: 14px;
        }

        .doc-title {
            text-align: center;
            font-size: 13px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 3px;
            text-decoration: underline;
        }
        .doc-subtitle {
            text-align: center;
            font-size: 10.5px;
            color: #555;
            margin-bottom: 14px;
        }

        table.data-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 10.5px;
            margin-top: 10px;
        }
        table.data-table th {
            background-color: #2c3e50;
            color: #fff;
            border: 1px solid #555;
            padding: 6px 8px;
            text-align: left;
            font-size: 10px;
        }
        table.data-table td {
            border: 1px solid #ddd;
            padding: 5px 8px;
            vertical-align: middle;
        }
        table.data-table tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .text-center { text-align: center; }

        .badge-lulus {
            background: #d4edda;
            color: #155724;
            padding: 2px 6px;
            border-radius: 3px;
            font-weight: bold;
            display: inline-block;
        }
        .badge-tidak {
            background: #f8d7da;
            color: #721c24;
            padding: 2px 6px;
            border-radius: 3px;
            font-weight: bold;
            display: inline-block;
        }

        /* ── TTD TABLE ── */
        .ttd-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 25px;
            page-break-inside: avoid;
        }
        .ttd-table td {
            vertical-align: top;
            font-size: 10.5px;
        }
        .ttd-space {
            height: 55px;
        }
        .ttd-img {
            max-height: 50px;
            max-width: 130px;
        }
        .print-note {
            margin-top: 20px;
            font-size: 9px;
            color: #888;
            border-top: 1px dashed #ccc;
            padding-top: 4px;
            text-align: center;
        }
    </style>
</head>
<body>

    {{-- KOP SURAT --}}
    <table class="kop-table">
        <tr>
            <td style="width: 12%; text-align: left;">
                @if(file_exists(public_path('assets/img/icon.png')))
                    <img src="{{ public_path('assets/img/icon.png') }}" style="width: 55px; height: auto;" alt="Logo">
                @endif
            </td>
            <td style="width: 88%;">
                <div class="school-name">PEMERINTAH PROVINSI MALUKU UTARA</div>
                <div class="school-name" style="font-size: 16px;">SMA NEGERI 5 PULAU MOROTAI</div>
                <div class="school-address">Alamat: Jl. Sabatai Tua, Kab. Pulau Morotai, Maluku Utara &bull; Akreditasi: A</div>
            </td>
        </tr>
    </table>
    <div class="sub-header-line-1"></div>
    <div class="sub-header-line-2"></div>

    <div class="doc-title">{{ $title ?? 'DAFTAR KELULUSAN SISWA' }}</div>
    <div class="doc-subtitle">{!! $subtitle ?? 'Tahun Pelajaran ' . (date('Y')-1) . '/' . date('Y') !!}</div>

    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 5%;" class="text-center">No</th>
                <th style="width: 20%;">NISN / NIS</th>
                <th style="width: 32%;">Nama Lengkap</th>
                <th style="width: 15%;">Kelas Asal</th>
                <th style="width: 13%;" class="text-center">Angkatan</th>
                <th style="width: 15%;" class="text-center">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($graduations as $index => $grad)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td><strong>{{ $grad->nisn }}</strong></td>
                <td>{{ $grad->name }}</td>
                <td>{{ $grad->class_name ?? '-' }}</td>
                <td class="text-center">{{ $grad->angkatan ?? '-' }}</td>
                <td class="text-center">
                    @if($grad->status == 'Lulus')
                        <span class="badge-lulus">LULUS</span>
                    @else
                        <span class="badge-tidak">TIDAK LULUS</span>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center" style="padding: 20px; color: #888;">Tidak ada data siswa.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    {{-- TANDA TANGAN KEPALA SEKOLAH --}}
    <table class="ttd-table">
        <tr>
            <td style="width: 60%;"></td>
            <td style="width: 40%; text-align: center;">
                Morotai, {{ now()->translatedFormat('d F Y') }}<br>
                Kepala SMA Negeri 5 Pulau Morotai,
                <div class="ttd-space">
                    @if(!empty($kepsek->ttd_signature))
                        <img src="{{ $kepsek->ttd_signature }}" class="ttd-img" alt="TTD Kepala Sekolah">
                    @else
                        <br><br>
                    @endif
                </div>
                <strong><u>{{ $kepsek->name ?? 'Drs. H. Ahmad Dahlan, M.Pd.' }}</u></strong><br>
                NIP. {{ $kepsek->nip ?? ($kepsek->nik ?? '-') }}
            </td>
        </tr>
    </table>

    <div class="print-note">
        Dokumen resmi diterbitkan oleh Sistem Informasi CBT SMA Negeri 5 Pulau Morotai (SIMORO SMANLI) &bull; Dicetak: {{ now()->format('d/m/Y H:i') }} WIT
    </div>

</body>
</html>
