@php
    // Helper function to convert image URLs to absolute paths for DomPDF rendering
    function convertImageUrlsForPDF($html) {
        if (!$html) return $html;
        
        $pattern = '/src=["\']([^"\']+)["\']/i';
        
        $html = preg_replace_callback($pattern, function($matches) {
            $src = $matches[1];
            
            // Skip data URIs (base64)
            if (strpos($src, 'data:') === 0) {
                return $matches[0];
            }

            // If absolute URL http://... or https://...
            if (strpos($src, 'http://') === 0 || strpos($src, 'https://') === 0) {
                $parsedPath = parse_url($src, PHP_URL_PATH);
                if ($parsedPath && strpos($parsedPath, '/storage/') === 0) {
                    $relPath = str_replace('/storage/', '', $parsedPath);
                    $fullPath = storage_path('app/public/' . $relPath);
                    if (file_exists($fullPath)) {
                        return 'src="' . $fullPath . '"';
                    }
                }
                return $matches[0];
            }
            
            // If relative /storage/...
            if (strpos($src, '/storage/') === 0) {
                $relPath = str_replace('/storage/', '', $src);
                $fullPath = storage_path('app/public/' . $relPath);
                if (file_exists($fullPath)) {
                    return 'src="' . $fullPath . '"';
                }
                $pubPath = public_path('storage/' . $relPath);
                if (file_exists($pubPath)) {
                    return 'src="' . $pubPath . '"';
                }
            } elseif (strpos($src, '/') === 0) {
                $fullPath = public_path(ltrim($src, '/'));
                if (file_exists($fullPath)) {
                    return 'src="' . $fullPath . '"';
                }
            }
            
            return $matches[0];
        }, $html);
        
        return $html;
    }
@endphp

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Hasil Ujian - {{ $exam->title ?? '-' }}</title>
    <style>
        @page {
            margin: 20px 25px 25px 25px;
        }
        * { box-sizing: border-box; }
        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
            color: #222;
            background: #fff;
            margin: 0;
            padding: 0;
        }

        /* ── HEADER KOP ── */
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
            margin-bottom: 12px;
        }

        /* ── TITLE ── */
        .doc-title {
            text-align: center;
            font-size: 13px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 12px;
            text-decoration: underline;
        }

        /* ── INFO GRID ── */
        .info-table-wrap {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 14px;
        }
        .info-table-wrap td {
            vertical-align: top;
        }
        .info-box {
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .info-box table {
            width: 100%;
            border-collapse: collapse;
        }
        .info-box table tr td {
            padding: 4px 8px;
            border-bottom: 1px solid #e0e0e0;
            vertical-align: middle;
            font-size: 10.5px;
        }
        .info-box table tr:last-child td { border-bottom: none; }
        .info-box table tr td:first-child {
            font-weight: bold;
            width: 95px;
            background: #f8f9fa;
            color: #444;
            white-space: nowrap;
        }
        .info-box table tr td:nth-child(2):before { content: ': '; }

        /* Score badge */
        .score-badge {
            display: inline-block;
            color: #fff;
            font-size: 14px;
            font-weight: bold;
            padding: 2px 10px;
            border-radius: 4px;
            text-align: center;
        }
        .score-badge.lulus { background: #1a7f3c; }
        .score-badge.gagal { background: #c0392b; }
        .status-checked {
            display: inline-block;
            background: #e6f4ea;
            color: #1e7e34;
            border: 1px solid #a8d5b5;
            border-radius: 4px;
            padding: 1px 8px;
            font-weight: bold;
            font-size: 10px;
        }
        .status-unchecked {
            display: inline-block;
            background: #fff3e0;
            color: #b26a00;
            border: 1px solid #f0c070;
            border-radius: 4px;
            padding: 1px 8px;
            font-weight: bold;
            font-size: 10px;
        }

        /* ── DETAIL TABLE ── */
        .section-title {
            font-size: 11.5px;
            font-weight: bold;
            margin-bottom: 5px;
            padding-left: 6px;
            border-left: 3px solid #0d6efd;
        }
        .detail-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 10px;
            margin-bottom: 15px;
        }
        .detail-table th {
            background: #2c3e50;
            color: #fff;
            padding: 5px 6px;
            text-align: center;
            border: 1px solid #555;
            font-size: 10px;
        }
        .detail-table td {
            padding: 5px 6px;
            border: 1px solid #ddd;
            vertical-align: top;
        }
        .detail-table tbody tr:nth-child(even) {
            background: #f9f9f9;
        }
        .detail-table td.center { text-align: center; }
        .detail-table td.option-col { color: #555; font-style: italic; }

        .benar {
            display: inline-block;
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
            border-radius: 3px;
            padding: 1px 6px;
            font-weight: bold;
            font-size: 9.5px;
        }
        .salah {
            display: inline-block;
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
            border-radius: 3px;
            padding: 1px 6px;
            font-weight: bold;
            font-size: 9.5px;
        }

        /* ── TTD TABLE ── */
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
            font-size: 10.5px;
        }
        .ttd-space {
            height: 55px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .ttd-img {
            max-height: 50px;
            max-width: 130px;
        }

        .print-note {
            margin-top: 15px;
            font-size: 9px;
            color: #888;
            text-align: center;
            border-top: 1px dashed #ccc;
            padding-top: 4px;
        }

        /* ── HTML CONTENT STYLING ── */
        .content-cell {
            word-break: break-word;
            overflow-wrap: break-word;
        }
        .content-cell img {
            max-width: 100%;
            height: auto;
            max-height: 160px;
            margin: 3px 0;
            display: block;
        }
        .content-cell p {
            margin: 0;
            line-height: 1.35;
        }
    </style>
</head>
<body>

    {{-- ── HEADER KOP SURAT ── --}}
    <table class="kop-table">
        <tr>
            <td style="width: 12%; text-align: left;">
                @if(file_exists(public_path('assets/img/icon.png')))
                    <img src="{{ public_path('assets/img/icon.png') }}" style="width: 55px; height: auto;" alt="Logo">
                @endif
            </td>
            <td style="width: 88%;">
                <div class="school-name">SMA NEGERI 5 PULAU MOROTAI</div>
                <div class="app-name">SIMORO SMANLI &mdash; Sistem Informasi Ujian Online Berbasis Komputer</div>
                <div class="school-address">Alamat: Jl. Siswa, Kab. Pulau Morotai, Maluku Utara &bull; Web: SIMORO SMANLI</div>
            </td>
        </tr>
    </table>
    <div class="sub-header-line-1"></div>
    <div class="sub-header-line-2"></div>

    {{-- ── DOCUMENT TITLE ── --}}
    <div class="doc-title">Lembar Hasil Ujian Siswa</div>

    {{-- ── INFO SECTION ── --}}
    <table class="info-table-wrap">
        <tr>
            <td style="width: 48%; padding-right: 6px;">
                {{-- Identitas Siswa --}}
                <div class="info-box">
                    <table>
                        <tr><td>Nama Siswa</td><td>{{ auth()->user()->name ?? '-' }}</td></tr>
                        <tr><td>NIS / NISN</td><td>{{ auth()->user()->nis ?? '-' }}</td></tr>
                        <tr><td>Kelas</td><td>{{ auth()->user()->class ? auth()->user()->class->name : '-' }}</td></tr>
                    </table>
                </div>
            </td>
            <td style="width: 52%; padding-left: 6px;">
                {{-- Identitas Ujian --}}
                <div class="info-box">
                    <table>
                        <tr><td>Nama Ujian</td><td>{{ $exam->title ?? '-' }}</td></tr>
                        <tr><td>Mata Pelajaran</td><td>{{ $exam->subject ? $exam->subject->name : '-' }}</td></tr>
                        <tr><td>Tanggal Ujian</td><td>{{ $examSession->start_time ? $examSession->start_time->format('d F Y, H:i') : ($examSession->created_at ? $examSession->created_at->format('d F Y') : '-') }} WIT</td></tr>
                        <tr>
                            <td>Nilai Akhir</td>
                            <td>
                                @if($examSession->score !== null)
                                    @php $scoreClass = $examSession->score >= 75 ? 'lulus' : 'gagal'; @endphp
                                    <span class="score-badge {{ $scoreClass }}">{{ number_format((float)$examSession->score, 1) }}</span>
                                    <span class="status-checked ms-1">&#10003; {{ $examSession->score >= 75 ? 'Tuntas' : 'Belum Tuntas' }}</span>
                                @else
                                    <span class="status-unchecked">&#9679; Belum Dinilai</span>
                                @endif
                            </td>
                        </tr>
                    </table>
                </div>
            </td>
        </tr>
    </table>

    {{-- ── PISAHKAN SOAL PG & ESSAY ── --}}
    @php
        $soalPG    = $questions->filter(fn($q) => $q->type !== 'essay');
        $soalEssay = $questions->filter(fn($q) => $q->type === 'essay');
        $noPG = 1;
        $noEssay = 1;
    @endphp

    {{-- ── TABEL PILIHAN GANDA ── --}}
    @if($soalPG->isNotEmpty())
    <div class="section-title">Bagian A &mdash; Pilihan Ganda</div>
    <table class="detail-table">
        <thead>
            <tr>
                <th style="width:28px">No</th>
                <th style="width:30%">Pertanyaan</th>
                <th>Opsi A</th>
                <th>Opsi B</th>
                <th>Opsi C</th>
                <th>Opsi D</th>
                <th style="width:65px">Jawaban Siswa</th>
                <th style="width:65px">Kunci</th>
                <th style="width:55px">Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($soalPG as $q)
            <tr>
                <td class="center">{{ $noPG++ }}</td>
                <td class="content-cell">{!! convertImageUrlsForPDF($q->pertanyaan ?? $q->question_text) !!}</td>
                <td class="option-col content-cell">{!! convertImageUrlsForPDF($q->opsi_a ?? '-') !!}</td>
                <td class="option-col content-cell">{!! convertImageUrlsForPDF($q->opsi_b ?? '-') !!}</td>
                <td class="option-col content-cell">{!! convertImageUrlsForPDF($q->opsi_c ?? '-') !!}</td>
                <td class="option-col content-cell">{!! convertImageUrlsForPDF($q->opsi_d ?? '-') !!}</td>
                <td class="center content-cell"><b>{!! convertImageUrlsForPDF($answers[$q->id]->answer ?? '-') !!}</b></td>
                <td class="center content-cell">{!! convertImageUrlsForPDF($q->jawaban_benar ?? $q->answer_key ?? '-') !!}</td>
                <td class="center">
                    @php
                        $userAns = isset($answers[$q->id]) ? strtoupper(trim($answers[$q->id]->answer)) : '';
                        $keyAns  = strtoupper(trim($q->jawaban_benar ?? $q->answer_key ?? ''));
                        $benar   = !empty($userAns) && ($userAns === $keyAns);
                    @endphp
                    @if(!empty($userAns))
                        @if($benar)
                            <span class="benar">Benar</span>
                        @else
                            <span class="salah">Salah</span>
                        @endif
                    @else
                        <span style="color:#888;">-</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif

    {{-- ── TABEL ESSAY ── --}}
    @if($soalEssay->isNotEmpty())
    <div class="section-title" style="border-left-color:#e67e22;">Bagian B &mdash; Essay / Uraian</div>
    <table class="detail-table">
        <thead>
            <tr>
                <th style="width:28px">No</th>
                <th style="width:40%">Pertanyaan</th>
                <th>Jawaban Anda</th>
                <th style="width:75px">Nilai Essay</th>
            </tr>
        </thead>
        <tbody>
            @foreach($soalEssay as $q)
            <tr>
                <td class="center">{{ $noEssay++ }}</td>
                <td class="content-cell">{!! convertImageUrlsForPDF($q->pertanyaan ?? $q->question_text) !!}</td>
                <td class="content-cell">{!! convertImageUrlsForPDF($answers[$q->id]->answer ?? '-') !!}</td>
                <td class="center">
                    @if(isset($answers[$q->id]->nilai_essay) && $answers[$q->id]->nilai_essay !== null)
                        <strong>{{ $answers[$q->id]->nilai_essay }}</strong>
                    @else
                        <span style="color:#aaa; font-size:9.5px;">Belum dinilai</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif

    {{-- ── TANDA TANGAN LEGALITAS (KEPALA SEKOLAH & GURU PENGAMPU) ── --}}
    <table class="ttd-table">
        <tr>
            <td>
                Mengetahui,<br>
                Kepala SMA Negeri 5 Pulau Morotai
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
            <td>
                Morotai, {{ now()->translatedFormat('d F Y') }}<br>
                Guru Mata Pelajaran,
                <div class="ttd-space">
                    @if(!empty($guru->ttd_signature))
                        <img src="{{ $guru->ttd_signature }}" class="ttd-img" alt="TTD Guru">
                    @else
                        <br><br>
                    @endif
                </div>
                <strong><u>{{ $guru->name ?? ($exam->subject ? $exam->subject->name : 'Guru Pengampu') }}</u></strong><br>
                NIP. {{ $guru->nip ?? ($guru->nik ?? '-') }}
            </td>
        </tr>
    </table>

    <div class="print-note">
        Dokumen Lembar Hasil Ujian Resmi ini diterbitkan secara elektronik oleh SIMORO SMANLI &bull; Dicetak pada: {{ now()->format('d/m/Y H:i') }} WIT
    </div>

</body>
</html>