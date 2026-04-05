<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Hasil Ujian - SIMORO</title>

    <style>
        @page {
            margin: 25px 30px;
        }

        body {
            font-family: "Times New Roman", serif;
            font-size: 11px;
            margin: 0;
        }

        /* ================= KOP ================= */
        .kop-wrapper {
            width: 100%;
            position: relative;
            margin-bottom: 10px;
        }

        .kop-table {
            width: 100%;
        }

        .kop-table td {
            vertical-align: middle;
        }

        .logo {
            width: 70px;
        }

        .kop-text {
            text-align: center;
        }

        .kop-text h2 {
            margin: 0;
            font-size: 16px;
            font-weight: bold;
        }

        .kop-text h3 {
            margin: 2px 0;
            font-size: 13px;
            font-weight: normal;
        }

        .garis1 {
            border-top: 3px solid #000;
            margin-top: 8px;
        }

        .garis2 {
            border-top: 1px solid #000;
            margin-top: 2px;
            margin-bottom: 15px;
        }

        /* ================= JUDUL ================= */
        .judul {
            text-align: center;
            font-size: 13px;
            font-weight: bold;
            text-decoration: underline;
            margin-bottom: 15px;
        }

        /* ================= INFO ================= */
        .info-table {
            margin-bottom: 15px;
        }

        .info-table td {
            padding: 3px 5px;
        }

        /* ================= TABEL ================= */
        table.laporan {
            border-collapse: collapse;
            width: 100%;
            table-layout: fixed;
        }

        table.laporan th,
        table.laporan td {
            border: 1px solid #000;
            padding: 5px;
            word-wrap: break-word;
            overflow-wrap: break-word;
        }

        table.laporan th {
            background-color: #f2f2f2;
            font-weight: bold;
            text-align: center;
        }

        table.laporan td {
            text-align: center;
        }

        table.laporan td.nama {
            text-align: left;
        }

        /* ================= TTD ================= */
        .ttd-wrapper {
            width: 100%;
            margin-top: 50px;
        }

        .ttd-box {
            width: 250px;
            float: right;
            text-align: center;
        }

        .ttd-box img {
            width: 150px;
            height: auto;
        }

        .footer-note {
            clear: both;
            margin-top: 80px;
            font-size: 10px;
        }
    </style>
</head>
<body>

    <!-- ================= KOP SURAT ================= -->
    <div class="kop-wrapper">
        <table class="kop-table">
            <tr>
                <!-- Logo Kiri (Kabupaten) -->
                <td width="15%" style="text-align:left;">
                    <img src="{{ public_path('assets/img/icon.png') }}" class="logo">
                </td>

                <!-- Tengah -->
                <td width="70%" class="kop-text">
                    <h2>SISTEM INFORMASI UJIAN</h2>
                    <h3>SIMORO - SMAN 5 MOROTAI</h3>
                    <h3>Kabupaten Pulau Morotai</h3>
                </td>

                <!-- Logo Kanan (Aplikasi) -->
                <td width="15%" style="text-align:right;">
                    <img src="{{ public_path('assets/img/icon.png') }}" class="logo">
                </td>
            </tr>
        </table>

        <div class="garis1"></div>
        <div class="garis2"></div>
    </div>

    <!-- ================= JUDUL ================= -->
    <div class="judul">
        LAPORAN RESMI HASIL UJIAN SISWA
    </div>

    <!-- ================= INFO DOKUMEN ================= -->
    <table class="info-table">
        <tr>
            <td width="130">Nomor Dokumen</td>
            <td width="10">:</td>
            <td>SIMORO/{{ date('Ymd') }}/LHU</td>
        </tr>
        <tr>
            <td>Tanggal Cetak</td>
            <td>:</td>
            <td>{{ date('d F Y H:i') }}</td>
        </tr>
        <tr>
            <td>Filter Ujian</td>
            <td>:</td>
            <td>{{ request('ujian_nama') ?? 'Semua Ujian' }}</td>
        </tr>
        <tr>
            <td>Filter Kelas</td>
            <td>:</td>
            <td>{{ request('kelas_nama') ?? 'Semua Kelas' }}</td>
        </tr>
    </table>

    <!-- ================= TABEL LAPORAN ================= -->
    <table class="laporan">
        <thead>
            <tr>
                <th style="width:5%;">No</th>
                <th style="width:20%;">Nama Siswa</th>
                <th style="width:10%;">Kelas</th>
                <th style="width:20%;">Ujian</th>
                <th style="width:8%;">Nilai</th>
                <th style="width:12%;">Mulai</th>
                <th style="width:12%;">Selesai</th>
                <th style="width:13%;">Durasi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($data as $i => $d)
            <tr>
                <td>{{ $i+1 }}</td>
                <td class="nama">{{ $d['nama'] }}</td>
                <td>{{ $d['kelas'] }}</td>
                <td>{{ $d['ujian'] }}</td>
                <td>{{ $d['nilai'] ?? '-' }}</td>
                <td>{{ $d['mulai'] ?? '-' }}</td>
                <td>{{ $d['selesai'] ?? '-' }}</td>
                <td>{{ $d['durasi'] ?? '-' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="8">Data tidak tersedia</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <!-- ================= TTD ================= -->
    <div class="ttd-wrapper">
        <div class="ttd-box">
            Morotai, {{ date('d F Y') }}<br>
            Administrator SIMORO<br><br>

            @if(!empty(request('ttd')))
                <img src="{{ request('ttd') }}">
            @else
                <br><br><br>
            @endif

            <br>
            <b>(_________________________)</b><br>
            NIP. -
        </div>
    </div>

    <!-- ================= FOOTER ================= -->
    <div class="footer-note">
        Dokumen ini dihasilkan secara otomatis oleh Sistem Informasi Ujian (SIMORO).<br>
        Dokumen ini sah tanpa tanda tangan basah.
    </div>

</body>
</html>