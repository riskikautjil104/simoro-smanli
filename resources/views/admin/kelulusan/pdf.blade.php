<!DOCTYPE html>
<html>
<head>
    <title>Data Pengumuman Kelulusan Siswa</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #333; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        h2 { text-align: center; margin-bottom: 5px; }
        .subtitle { text-align: center; color: #666; margin-bottom: 20px; }
    </style>
</head>
<body>
    <h2>Data Pengumuman Kelulusan Siswa</h2>
    <div class="subtitle">SMA Negeri 5 Morotai</div>
    <table>
        <thead>
            <tr>
                <th style="width: 5%; text-align: center;">No</th>
                <th style="width: 25%;">NISN</th>
                <th style="width: 45%;">Nama Siswa</th>
                <th style="width: 25%;">Status Kelulusan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($graduations as $index => $grad)
            <tr>
                <td style="text-align: center;">{{ $index + 1 }}</td>
                <td>{{ $grad->nisn }}</td>
                <td>{{ $grad->name }}</td>
                <td>{{ $grad->status }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="4" style="text-align: center;">Tidak ada data kelulusan</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
