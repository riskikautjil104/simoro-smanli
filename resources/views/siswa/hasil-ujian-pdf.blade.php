@php
    // Helper function to convert image URLs to absolute paths for PDF rendering
    function convertImageUrlsForPDF($html) {
        if (!$html) return $html;
        
        // Pattern untuk img src dengan berbagai format
        $pattern = '/src=["\']([^"\']+)["\']/i';
        
        $html = preg_replace_callback($pattern, function($matches) {
            $src = $matches[1];
            
            // Skip external URLs dan data URIs
            if (strpos($src, 'http') === 0 || strpos($src, 'data:') === 0) {
                return $matches[0];
            }
            
            // Convert relative paths to absolute
            if (strpos($src, '/storage/') === 0) {
                // /storage/uploads/... -> file://public_path('storage/app/public/uploads/...')
                $path = str_replace('/storage/', '', $src);
                $absolutePath = public_path('storage/' . $path);
                if (file_exists($absolutePath)) {
                    return 'src="' . $absolutePath . '"';
                }
            } elseif (strpos($src, '/') === 0) {
                // /assets/... -> file://public_path('assets/...')
                $absolutePath = public_path(ltrim($src, '/'));
                if (file_exists($absolutePath)) {
                    return 'src="' . $absolutePath . '"';
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
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #222;
            background: #fff;
            padding: 30px 40px;
        }

        /* ── HEADER ── */
        .header {
            display: flex;
            align-items: center;
            gap: 16px;
            padding-bottom: 12px;
            border-bottom: 3px solid #222;
            margin-bottom: 4px;
        }
        .header img { width: 70px; height: auto; }
        .header-text .school-name {
            font-size: 18px;
            font-weight: bold;
            letter-spacing: 0.5px;
        }
        .header-text .app-name {
            font-size: 13px;
            color: #555;
        }
        .header-text .school-address {
            font-size: 11px;
            color: #777;
            margin-top: 2px;
        }
        .sub-header-line {
            border-bottom: 1px solid #222;
            margin-bottom: 16px;
        }

        /* ── TITLE ── */
        .doc-title {
            text-align: center;
            font-size: 15px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 16px;
            text-decoration: underline;
        }

        /* ── INFO GRID ── */
        .info-section {
            display: flex;
            gap: 16px;
            margin-bottom: 20px;
        }
        .info-box {
            flex: 1;
            border: 1px solid #ccc;
            border-radius: 4px;
            overflow: hidden;
        }
        .info-box table {
            width: 100%;
            border-collapse: collapse;
        }
        .info-box table tr td {
            padding: 5px 10px;
            border-bottom: 1px solid #e0e0e0;
            vertical-align: top;
        }
        .info-box table tr:last-child td { border-bottom: none; }
        .info-box table tr td:first-child {
            font-weight: bold;
            width: 110px;
            background: #f5f5f5;
            color: #444;
            white-space: nowrap;
        }
        .info-box table tr td:nth-child(2):before { content: ': '; }

        /* Score badge */
        .score-badge {
            display: inline-block;
            color: #fff;
            font-size: 22px;
            font-weight: bold;
            padding: 4px 18px;
            border-radius: 6px;
            min-width: 60px;
            text-align: center;
        }
        .score-badge.lulus  { background: #1a7f3c; }
        .score-badge.gagal  { background: #c0392b; }
        .status-checked {
            display: inline-block;
            background: #e6f4ea;
            color: #1e7e34;
            border: 1px solid #a8d5b5;
            border-radius: 4px;
            padding: 2px 10px;
            font-weight: bold;
            font-size: 11px;
        }
        .status-unchecked {
            display: inline-block;
            background: #fff3e0;
            color: #b26a00;
            border: 1px solid #f0c070;
            border-radius: 4px;
            padding: 2px 10px;
            font-weight: bold;
            font-size: 11px;
        }

        /* ── DETAIL TABLE ── */
        .section-title {
            font-size: 13px;
            font-weight: bold;
            margin-bottom: 6px;
            padding-left: 4px;
            border-left: 4px solid #1a73e8;
            padding-left: 8px;
        }
        .detail-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 11px;
        }
        .detail-table th {
            background: #2c3e50;
            color: #fff;
            padding: 7px 8px;
            text-align: center;
            border: 1px solid #555;
            font-size: 11px;
        }
        .detail-table td {
            padding: 6px 8px;
            border: 1px solid #ddd;
            vertical-align: top;
        }
        .detail-table tbody tr:nth-child(even) {
            background: #f9f9f9;
        }
        .detail-table tbody tr:hover {
            background: #eef4ff;
        }
        .detail-table td.center { text-align: center; }
        .detail-table td.option-col { color: #555; font-style: italic; }

        .benar {
            display: inline-block;
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
            border-radius: 3px;
            padding: 1px 8px;
            font-weight: bold;
            font-size: 10px;
        }
        .salah {
            display: inline-block;
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
            border-radius: 3px;
            padding: 1px 8px;
            font-weight: bold;
            font-size: 10px;
        }
        .essay-tag {
            display: inline-block;
            background: #e8f0fe;
            color: #1a73e8;
            border-radius: 3px;
            padding: 1px 8px;
            font-size: 10px;
        }

        /* ── FOOTER ── */
        .footer {
            margin-top: 30px;
            display: flex;
            justify-content: flex-end;
        }
        .signature-box {
            text-align: center;
            font-size: 11px;
        }
        .signature-box .sig-line {
            margin-top: 60px;
            border-top: 1px solid #333;
            padding-top: 4px;
            min-width: 180px;
        }
        .print-note {
            margin-top: 20px;
            font-size: 10px;
            color: #aaa;
            text-align: center;
        }

        /* ── HTML CONTENT STYLING ── */
        .content-cell {
            word-break: break-word;
            overflow-wrap: break-word;
        }
        .content-cell img {
            max-width: 100%;
            height: auto;
            max-height: 200px;
            margin: 4px 0;
            display: block;
        }
        .content-cell p {
            margin: 0;
            line-height: 1.4;
        }
        .content-cell ul,
        .content-cell ol {
            margin: 4px 0;
            padding-left: 16px;
        }
        .content-cell li {
            margin: 2px 0;
        }
    </style>
</head>
<body>

    {{-- ── HEADER ── --}}
    <div class="header">
        <img src="{{ public_path('assets/logo.png') }}" alt="Logo Sekolah">
        <div class="header-text">
            <div class="school-name">SMA Negeri 5 Kab Pulau Morotai</div>
            <div class="app-name">SIMORO SMANLI &mdash; Sistem Informasi Ujian Online</div>
            <div class="school-address">Jl. Sabatai Tua Alamat No. 123, Morotai &bull; Telp. (0435) 000-0000</div>
        </div>
    </div>
    <div class="sub-header-line"></div>

    {{-- ── DOCUMENT TITLE ── --}}
    <div class="doc-title">Lembar Hasil Ujian</div>

    {{-- ── INFO SECTION ── --}}
    <div class="info-section">
        {{-- Identitas Siswa --}}
        <div class="info-box">
            <table>
                <tr><td>Nama Siswa</td><td>{{ auth()->user()->name ?? '-' }}</td></tr>
                <tr><td>NIS</td><td>{{ auth()->user()->nis ?? '-' }}</td></tr>
                <tr><td>Kelas</td><td>{{ auth()->user()->class->name ?? '-' }}</td></tr>
            </table>
        </div>

        {{-- Identitas Ujian --}}
        <div class="info-box">
            <table>
                <tr><td>Nama Ujian</td><td>{{ $exam->title ?? '-' }}</td></tr>
                <tr><td>Mata Pelajaran</td><td>{{ $exam->subject->name ?? '-' }}</td></tr>
                <tr><td>Tanggal</td><td>{{ $examSession->created_at ? $examSession->created_at->format('d-m-Y') : '-' }}</td></tr>
                <tr>
                    <td>Nilai</td>
                    <td>
                        @if($examSession->score !== null)
                            @php $scoreClass = $examSession->score >= 60 ? 'lulus' : 'gagal'; @endphp
                            <span class="score-badge {{ $scoreClass }}">{{ $examSession->score }}</span>
                        @else
                            -
                        @endif
                    </td>
                </tr>
                <tr>
                    <td>Status</td>
                    <td>
                        @if($examSession->score !== null)
                            <span class="status-checked">&#10003; Sudah Diperiksa</span>
                        @else
                            <span class="status-unchecked">&#9679; Belum Diperiksa</span>
                        @endif
                    </td>
                </tr>
            </table>
        </div>
    </div>

    {{-- ── PISAHKAN SOAL PG & ESSAY ── --}}
    @php
        $soalPG    = $questions->filter(fn($q) => $q->type !== 'essay');
        $soalEssay = $questions->filter(fn($q) => $q->type === 'essay');
        $noPG = 1;
        $noEssay = 1;
    @endphp

    {{-- ── TABEL PILIHAN GANDA ── --}}
    @if($soalPG->isNotEmpty())
    <div class="section-title" style="border-left-color:#2c3e50;">Bagian A &mdash; Pilihan Ganda</div>
    <table class="detail-table" style="margin-bottom: 24px;">
        <thead>
            <tr>
                <th style="width:32px">No</th>
                <th style="width:28%">Pertanyaan</th>
                <th>Opsi A</th>
                <th>Opsi B</th>
                <th>Opsi C</th>
                <th>Opsi D</th>
                <th style="width:80px">Jawaban Anda</th>
                <th style="width:80px">Kunci Jawaban</th>
                <th style="width:70px">Status</th>
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
                <td class="center content-cell">{!! convertImageUrlsForPDF($answers[$q->id]->answer ?? '-') !!}</td>
                <td class="center content-cell"><b>{!! convertImageUrlsForPDF($q->jawaban_benar ?? $q->answer_key ?? '-') !!}</b></td>
                <td class="center">
                    @php
                        $benar = isset($answers[$q->id]) && ($answers[$q->id]->answer == ($q->jawaban_benar ?? $q->answer_key));
                    @endphp
                    @if(isset($answers[$q->id]))
                        @if($benar)
                            <span class="benar">Benar</span>
                        @else
                            <span class="salah">Salah</span>
                        @endif
                    @else
                        -
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif

    {{-- ── TABEL ESSAY ── --}}
    @if($soalEssay->isNotEmpty())
    <div class="section-title" style="border-left-color:#e67e22;">Bagian B &mdash; Essay</div>
    <table class="detail-table">
        <thead>
            <tr>
                <th style="width:32px">No</th>
                <th style="width:35%">Pertanyaan</th>
                <th>Jawaban Anda</th>
                <th style="width:80px">Nilai Essay</th>
            </tr>
        </thead>
        <tbody>
            @foreach($soalEssay as $q)
            <tr>
                <td class="center">{{ $noEssay++ }}</td>
                <td class="content-cell">{!! convertImageUrlsForPDF($q->pertanyaan ?? $q->question_text) !!}</td>
                <td class="content-cell">{!! convertImageUrlsForPDF($answers[$q->id]->answer ?? '-') !!}</td>
                <td class="center">
                    @if(isset($answers[$q->id]->nilai_essay))
                        <strong>{{ $answers[$q->id]->nilai_essay }}</strong>
                    @else
                        <span style="color:#aaa; font-size:10px;">Belum dinilai</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif

    {{-- ── FOOTER / SIGNATURE ── --}}
    <div class="footer">
        <div class="signature-box">
            <div>Morotai, {{ now()->format('d F Y') }}</div>
            <div>Guru Mata Pelajaran</div>
            <div class="sig-line">{{ $exam->subject->name ?? 'Guru' }}</div>
        </div>
    </div>

    <div class="print-note">
        Dokumen ini dicetak secara otomatis oleh SIMORO SMANLI &bull; {{ now()->format('d-m-Y H:i') }}
    </div>

</body>
</html>