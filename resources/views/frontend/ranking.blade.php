<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ranking Ujian Siswa · SIMORO SMAN LI</title>

    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="SIMORO SMANLI - SMA Negeri 5 Morotai">
    <meta property="og:description" content="Portal resmi Sistem Ujian Online dan Informasi Akademik SMA Negeri 5 Morotai, Maluku Utara.">
    <meta property="og:image" content="{{ asset('assets/frondend/assets/img/og-image.jpg') }}">

    <link href="{{ asset('assets/frondend/assets/img/favicon.svg') }}" rel="icon" type="image/svg+xml">
    <link rel="shortcut icon" href="{{ asset('assets/frondend/assets/img/favicon.ico') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/frondend/assets/img/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/frondend/assets/img/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/frondend/assets/img/favicon-16x16.png') }}">
    <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('assets/frondend/assets/img/favicon-96x96.png') }}">
    <link rel="manifest" href="{{ asset('assets/frondend/assets/img/site.webmanifest') }}">

    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">


    <style>
        /* ── Reset & Base ── */
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: Inter, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            background: #f0f4f8;
            color: #1f2937;
            line-height: 1.6;
            min-height: 100vh;
        }

        /* ── Layout Wrapper ── */
        .page-wrapper {
            max-width: 820px;
            margin: 0 auto;
            padding: 20px 16px 40px;
        }

        /* ── Hero Header ── */
        .hero {
            background: linear-gradient(135deg, #185FA5 0%, #534AB7 100%);
            border-radius: 20px;
            padding: 28px 24px 24px;
            color: #fff;
            margin-bottom: 16px;
            position: relative;
            overflow: hidden;
        }
        .hero::before {
            content: '';
            position: absolute;
            width: 220px; height: 220px;
            background: rgba(255,255,255,.07);
            border-radius: 50%;
            top: -80px; right: -60px;
            pointer-events: none;
        }
        .hero::after {
            content: '';
            position: absolute;
            width: 120px; height: 120px;
            background: rgba(255,255,255,.04);
            border-radius: 50%;
            bottom: -40px; left: 10px;
            pointer-events: none;
        }
        .hero-inner {
            position: relative;
            display: flex;
            align-items: flex-start;
            gap: 14px;
        }
        .hero-icon {
            width: 44px; height: 44px;
            background: rgba(255,255,255,.15);
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
        }
        .hero-icon svg { width: 22px; height: 22px; }
        .hero-brand {
            font-size: 11px;
            color: rgba(255,255,255,.7);
            letter-spacing: .8px;
            font-weight: 600;
            text-transform: uppercase;
            margin-bottom: 3px;
        }
        .hero-title {
            font-size: clamp(18px, 5vw, 24px);
            font-weight: 700;
            color: #fff;
            line-height: 1.2;
        }
        .hero-sub {
            font-size: 13px;
            color: rgba(255,255,255,.75);
            margin-top: 6px;
        }

        /* ── Card ── */
        .card {
            background: #fff;
            border-radius: 16px;
            border: 1px solid #e5e7eb;
            overflow: hidden;
            box-shadow: 0 1px 4px rgba(0,0,0,.06);
        }

        /* ── Selector ── */
        .selector-wrap {
            padding: 16px 20px;
            border-bottom: 1px solid #f0f0f0;
        }
        .selector-label {
            font-size: 12px;
            font-weight: 600;
            color: #6b7280;
            letter-spacing: .4px;
            text-transform: uppercase;
            margin-bottom: 8px;
        }
        #examSelect {
            width: 100%;
            background: #f8fafc;
            border: 1.5px solid #e5e7eb;
            border-radius: 10px;
            padding: 11px 14px;
            font-size: 14px;
            color: #1f2937;
            outline: none;
            transition: border-color .2s, box-shadow .2s;
            cursor: pointer;
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%236b7280' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 12px center;
            padding-right: 36px;
        }
        #examSelect:focus {
            border-color: #185FA5;
            box-shadow: 0 0 0 3px rgba(24,95,165,.1);
            background-color: #fff;
        }

        /* ── Table Header ── */
        .table-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 12px 20px;
            background: #f8fafc;
            border-bottom: 1px solid #f0f0f0;
        }
        .table-header-title {
            display: flex;
            align-items: center;
            gap: 7px;
            font-size: 14px;
            font-weight: 600;
            color: #1f2937;
        }
        .table-header-title svg { color: #185FA5; }
        .count-badge {
            font-size: 12px;
            color: #6b7280;
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 20px;
            padding: 3px 10px;
            font-weight: 500;
        }

        /* ── Table ── */
        .table-scroll { overflow-x: auto; -webkit-overflow-scrolling: touch; }
        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 420px;
        }
        thead th {
            background: #f8fafc;
            font-size: 11px;
            font-weight: 600;
            color: #9ca3af;
            text-transform: uppercase;
            letter-spacing: .5px;
            padding: 10px 16px;
            text-align: left;
            border-bottom: 1px solid #f0f0f0;
            white-space: nowrap;
        }
        thead th:last-child { text-align: right; }
        tbody tr {
            border-bottom: 1px solid #fafafa;
            transition: background .15s;
        }
        tbody tr:last-child { border-bottom: none; }
        tbody tr:hover { background: #f8fafc; }
        tbody tr.top-row { background: #fafbff; }
        tbody td {
            padding: 12px 16px;
            vertical-align: middle;
        }
        tbody td:last-child { text-align: right; }

        /* ── Rank Medal ── */
        .rank-medal {
            width: 32px; height: 32px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center; justify-content: center;
            font-size: 13px;
            font-weight: 700;
            flex-shrink: 0;
        }
        .rank-1 { background: linear-gradient(135deg,#FFD700,#FFA500); color: #5a3800; }
        .rank-2 { background: linear-gradient(135deg,#D0D0D0,#A8A8A8); color: #3a3a3a; }
        .rank-3 { background: linear-gradient(135deg,#CD7F32,#a85f1a); color: #fff; }
        .rank-n { background: #f0f4ff; color: #185FA5; border: 1.5px solid #c7d8f0; }

        /* ── Avatar ── */
        .avatar {
            width: 34px; height: 34px;
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-size: 12px;
            font-weight: 700;
            flex-shrink: 0;
        }

        /* ── Siswa Cell ── */
        .siswa-cell {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .siswa-name {
            font-size: 14px;
            color: #1f2937;
            display: flex;
            align-items: center;
            gap: 6px;
            flex-wrap: wrap;
        }
        .best-tag {
            font-size: 10px;
            padding: 2px 7px;
            background: #FEF3C7;
            color: #92400e;
            border-radius: 20px;
            font-weight: 600;
        }

        /* ── Nilai Badge ── */
        .nilai-badge {
            display: inline-block;
            padding: 4px 14px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 700;
        }
        .nilai-a { background: #d1fae5; color: #065f46; }
        .nilai-b { background: #dbeafe; color: #1e40af; }
        .nilai-c { background: #fef3c7; color: #92400e; }
        .nilai-d { background: #fee2e2; color: #991b1b; }

        /* ── Kelas Cell ── */
        .kelas-text {
            font-size: 13px;
            color: #6b7280;
        }

        /* ── Empty & Loading State ── */
        .state-cell {
            text-align: center;
            padding: 48px 20px;
        }
        .state-icon {
            width: 48px; height: 48px;
            background: #f0f4f8;
            border-radius: 14px;
            display: inline-flex;
            align-items: center; justify-content: center;
            margin-bottom: 12px;
        }
        .state-title {
            font-size: 15px;
            font-weight: 600;
            color: #374151;
            margin-bottom: 4px;
        }
        .state-sub {
            font-size: 13px;
            color: #9ca3af;
        }

        /* ── Footer ── */
        .page-footer {
            text-align: center;
            margin-top: 20px;
            font-size: 11px;
            color: #9ca3af;
            letter-spacing: .3px;
        }

        /* ── No exam state ── */
        .no-exam-card {
            background: #fff;
            border-radius: 16px;
            border: 1px solid #e5e7eb;
            padding: 48px 24px;
            text-align: center;
        }

        /* ── Responsive ── */
        @media (max-width: 480px) {
            .page-wrapper { padding: 14px 12px 32px; }
            .hero { padding: 20px 16px 18px; border-radius: 14px; }
            .card { border-radius: 14px; }
            thead th { font-size: 10px; padding: 8px 12px; }
            tbody td { padding: 10px 12px; }
            .avatar { width: 30px; height: 30px; font-size: 11px; border-radius: 8px; }
            .rank-medal { width: 28px; height: 28px; font-size: 12px; }
            .siswa-name { font-size: 13px; }
        }
        @media (max-width: 640px) {

    table thead {
        display: none;
    }

    table, tbody {
        display: block;
    }

    table tr {
        display: block;
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 14px;
        margin-bottom: 12px;
        padding: 14px;
        box-shadow: 0 1px 3px rgba(0,0,0,.05);
    }

    table td {
        display: none; /* sembunyikan semua td default */
    }

    .mobile-only {
        display: block !important;
        width: 100%;
    }

    .row-top {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 10px;
    }

    .row-bottom {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .kelas-wrap {
        display: flex;
        flex-direction: column;
    }

    .label-mobile {
        font-size: 11px;
        color: #9ca3af;
    }

    .value-mobile {
        font-size: 14px;
        font-weight: 600;
        color: #374151;
    }

    .nilai-wrap {
        text-align: right;
    }

    .nilai-wrap .nilai-badge {
        font-size: 14px;
        padding: 6px 16px;
    }
}
@media (max-width: 640px) {

    .row-bottom {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 12px;
        margin-top: 8px;
    }

    .kelas-wrap {
        flex: 1; /* biar dorong nilai ke kanan tapi tetap dalam card */
        min-width: 0;
    }

    .nilai-wrap {
        flex-shrink: 0; /* jangan sampai keluar */
        text-align: right;
    }

    .nilai-wrap .nilai-badge {
        display: inline-block;
        min-width: 48px;
        text-align: center;
    }
}
.nilai-wrap .nilai-badge {
    font-size: 15px;
    padding: 6px 14px;
}
@media (max-width: 640px) {
    table {
        min-width: 100% !important;
    }
}
@media (max-width: 640px) {
    .table-scroll {
        overflow-x: hidden; /* matiin scroll horizontal */
    }

    table tr {
        width: 100%;
        overflow: hidden; /* penting biar isi gak keluar */
    }
}
@media (max-width: 640px) {
    body {
        overflow-x: hidden;
    }
}
.mobile-only {
    display: none !important;
}
@media (max-width: 640px) {
    .mobile-only {
        display: block !important;
    }
}
@media (min-width: 641px) {
    .mobile-only {
        display: none !important;
    }
}
td.mobile-only {
    width: 100%;
}
    </style>
</head>
<body>

<div class="page-wrapper">

    {{-- ── Hero ── --}}
    <div class="hero" style="margin-bottom:20px">
        <div class="hero-inner">
            <div class="hero-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M6 9H4.5a2.5 2.5 0 0 1 0-5H6"/>
                    <path d="M18 9h1.5a2.5 2.5 0 0 0 0-5H18"/>
                    <path d="M4 22h16"/>
                    <path d="M10 14.66V17c0 .55-.47.98-.97 1.21C7.85 18.75 7 20.24 7 22"/>
                    <path d="M14 14.66V17c0 .55.47.98.97 1.21C16.15 18.75 17 20.24 17 22"/>
                    <path d="M18 2H6v7a6 6 0 0 0 12 0V2Z"/>
                </svg>
            </div>
            <div>
                <div class="hero-brand">SIMORO · SMAN LI</div>
                <div class="hero-title">Ranking Ujian Siswa</div>
                <div class="hero-sub">Lihat peringkat siswa berdasarkan hasil ujian</div>
            </div>
        </div>
    </div>

    {{-- ── No Active Exams ── --}}
    @if($activeExams->isEmpty())
    <div class="no-exam-card">
        <div class="state-icon" style="margin:0 auto 12px">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#9ca3af" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                <path d="M6 9H4.5a2.5 2.5 0 0 1 0-5H6"/>
                <path d="M18 9h1.5a2.5 2.5 0 0 0 0-5H18"/>
                <path d="M18 2H6v7a6 6 0 0 0 12 0V2Z"/>
                <path d="M4 22h16"/>
            </svg>
        </div>
        <div class="state-title">Belum ada ujian aktif</div>
        <div class="state-sub">Ranking akan muncul setelah ujian selesai dan dinilai.</div>
    </div>

    @else

    {{-- ── Main Card ── --}}
    <div class="card">

        {{-- Exam Selector --}}
        <div class="selector-wrap">
            <div class="selector-label">Pilih ujian</div>
            <select id="examSelect">
                <option value="">-- Pilih ujian untuk melihat ranking --</option>
                @foreach($activeExams as $exam)
                <option value="{{ $exam['id'] }}"
                        data-has-ranking="{{ $exam['has_ranking'] ? 'true' : 'false' }}"
                        {{ request('exam_id') == $exam['id'] ? 'selected' : '' }}>
                    {{ $exam['title'] }} · {{ $exam['subject'] }} ({{ $exam['class'] }}) · {{ $exam['end_time'] }}
                </option>
                @endforeach
            </select>
        </div>

        {{-- Ranking Table (hidden until exam selected) --}}
        <div id="rankingSection" style="display:none">
            <div class="table-header">
                <div class="table-header-title">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#185FA5" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M6 9H4.5a2.5 2.5 0 0 1 0-5H6"/>
                        <path d="M18 9h1.5a2.5 2.5 0 0 0 0-5H18"/>
                        <path d="M18 2H6v7a6 6 0 0 0 12 0V2Z"/>
                    </svg>
                    <span id="examTitleHeader">Ranking nilai</span>
                </div>
                <span class="count-badge" id="rankingCount">0 peserta</span>
            </div>

            <div class="table-scroll">
                <table>
                    <thead>
                        <tr>
                            <th style="width:64px">Rank</th>
                            <th>Nama siswa</th>
                            <th style="width:110px">Kelas</th>
                            <th style="width:90px;text-align:right">Nilai</th>
                        </tr>
                    </thead>
                    <tbody id="rankingTableBody">
                        <tr>
                            <td colspan="4" class="state-cell">
                                <div class="state-icon" style="margin:0 auto 10px">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#9ca3af" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M6 9H4.5a2.5 2.5 0 0 1 0-5H6"/>
                                        <path d="M18 9h1.5a2.5 2.5 0 0 0 0-5H18"/>
                                        <path d="M18 2H6v7a6 6 0 0 0 12 0V2Z"/>
                                    </svg>
                                </div>
                                <div class="state-title">Pilih ujian terlebih dahulu</div>
                                <div class="state-sub">Ranking akan ditampilkan di sini</div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Empty default state --}}
        <div id="emptyState">
            <div class="state-cell">
                <div class="state-icon" style="margin:0 auto 10px">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#9ca3af" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/>
                    </svg>
                </div>
                <div class="state-title">Pilih ujian terlebih dahulu</div>
                <div class="state-sub">Ranking akan ditampilkan setelah ujian dipilih</div>
            </div>
        </div>

    </div>
    @endif

    <div class="page-footer">SIMORO &middot; Sistem Ujian dan Monitoring Sekolah &middot; SMAN LI</div>
</div>

<script>
(function () {
    var examSelect   = document.getElementById('examSelect');
    var rankSection  = document.getElementById('rankingSection');
    var emptyState   = document.getElementById('emptyState');
    var tableBody    = document.getElementById('rankingTableBody');
    var rankCount    = document.getElementById('rankingCount');
    var examTitle    = document.getElementById('examTitleHeader');

    if (!examSelect) return;

    /* Avatar colour pairs [bg, text] */
    var avatarColors = [
        ['#dbeafe','#1e40af'],
        ['#d1fae5','#065f46'],
        ['#ede9fe','#4c1d95'],
        ['#fef3c7','#92400e'],
        ['#fee2e2','#991b1b'],
        ['#e0f2fe','#075985']
    ];

    function getInitials(name) {
        return (name || 'S').trim().split(' ').slice(0, 2).map(function(w){ return w[0]; }).join('').toUpperCase();
    }

    function rankMedal(n) {
        var cls = n === 1 ? 'rank-1' : n === 2 ? 'rank-2' : n === 3 ? 'rank-3' : 'rank-n';
        return '<div class="rank-medal ' + cls + '">' + n + '</div>';
    }

    function nilaiBadge(v) {
        var cls = v >= 85 ? 'nilai-a' : v >= 70 ? 'nilai-b' : v >= 55 ? 'nilai-c' : 'nilai-d';
        return '<span class="nilai-badge ' + cls + '">' + v + '</span>';
    }

    function loadingState() {
        tableBody.innerHTML = '<tr><td colspan="4" class="state-cell">'
            + '<div class="state-icon" style="margin:0 auto 10px">'
            + '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#9ca3af" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">'
            + '<path d="M21 12a9 9 0 1 1-6.219-8.56"/></svg></div>'
            + '<div class="state-title">Memuat ranking...</div>'
            + '<div class="state-sub">Harap tunggu sebentar</div>'
            + '</td></tr>';
    }

    // function renderRows(data) {
    //     var html = '';
    //     data.forEach(function(s, i) {
    //         var rankNum  = i + 1;
    //         var c        = avatarColors[i % avatarColors.length];
    //         var initials = getInitials(s.nama);
    //         var isTop    = rankNum <= 3;
    //         var bestTag  = rankNum === 1 ? ' <span class="best-tag">terbaik</span>' : '';
    //         var nameW    = isTop ? 'font-weight:600' : 'font-weight:400';

    //         html += '<tr class="' + (isTop ? 'top-row' : '') + '">'
    //             + '<td>' + rankMedal(rankNum) + '</td>'
    //             + '<td><div class="siswa-cell">'
    //             + '<div class="avatar" style="background:' + c[0] + ';color:' + c[1] + '">' + initials + '</div>'
    //             + '<span class="siswa-name" style="' + nameW + '">' + s.nama + bestTag + '</span>'
    //             + '</div></td>'
    //             + '<td><span class="kelas-text">' + s.kelas + '</span></td>'
    //             + '<td>' + nilaiBadge(s.nilai) + '</td>'
    //             + '</tr>';
    //     });
    //     return html;
    // }
function renderRows(data) {
    var html = '';

    data.forEach(function(s, i) {
        var rankNum  = i + 1;
        var c        = avatarColors[i % avatarColors.length];
        var initials = getInitials(s.nama);
        var isTop    = rankNum <= 3;
        var bestTag  = rankNum === 1 ? ' <span class="best-tag">terbaik</span>' : '';
        var nameW    = isTop ? 'font-weight:600' : 'font-weight:400';

        html += '<tr class="' + (isTop ? 'top-row' : '') + '">';

        /* DESKTOP (tetap normal) */
        html += '<td>' + rankMedal(rankNum) + '</td>';
        html += '<td><div class="siswa-cell">'
            + '<div class="avatar" style="background:' + c[0] + ';color:' + c[1] + '">' + initials + '</div>'
            + '<span class="siswa-name" style="' + nameW + '">' + s.nama + bestTag + '</span>'
            + '</div></td>';
        html += '<td><span class="kelas-text">' + s.kelas + '</span></td>';
        html += '<td>' + nilaiBadge(s.nilai) + '</td>';

        /* MOBILE CARD (tambahan, disembunyikan di desktop via CSS) */
        html += '<td class="mobile-only">'
    + '<div class="row-top">'
        + rankMedal(rankNum)
        + '<div class="avatar" style="background:' + c[0] + ';color:' + c[1] + '">' + initials + '</div>'
        + '<div class="siswa-name" style="' + nameW + '">' + s.nama + bestTag + '</div>'
    + '</div>'

    + '<div class="row-bottom">'
    + '<div class="kelas-wrap">'
        + '<span class="label-mobile">Kelas</span>'
        + '<span class="value-mobile">' + s.kelas + '</span>'
    + '</div>'

    + '<div class="nilai-wrap">'
        + '<span class="label-mobile">Nilai</span>'
        + '<div>' + nilaiBadge(s.nilai) + '</div>'
    + '</div>'
+ '</div>'
+ '</td>';

        html += '</tr>';
    });

    return html;
}
    examSelect.addEventListener('change', function () {
        var examId = this.value;

        if (!examId) {
            rankSection.style.display  = 'none';
            emptyState.style.display   = 'block';
            return;
        }

        rankSection.style.display = 'block';
        emptyState.style.display  = 'none';
        loadingState();

        /* Update title from selected option text */
        var optText = this.options[this.selectedIndex].text;
        examTitle.textContent = optText.split('·')[0].trim() || 'Ranking nilai';

        fetch('/ranking/' + examId, {
            headers: { 'Accept': 'application/json' }
        })
        .then(function(r) { return r.json(); })
        .then(function(data) {
            if (!data || data.length === 0) {
                tableBody.innerHTML = '<tr><td colspan="4" class="state-cell">'
                    + '<div class="state-icon" style="margin:0 auto 10px">'
                    + '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#9ca3af" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">'
                    + '<path d="M6 9H4.5a2.5 2.5 0 0 1 0-5H6"/>'
                    + '<path d="M18 9h1.5a2.5 2.5 0 0 0 0-5H18"/>'
                    + '<path d="M18 2H6v7a6 6 0 0 0 12 0V2Z"/></svg></div>'
                    + '<div class="state-title">Belum ada ranking</div>'
                    + '<div class="state-sub">Tidak ada siswa yang telah dinilai.</div>'
                    + '</td></tr>';
                rankCount.textContent = '0 peserta';
                return;
            }
            tableBody.innerHTML = renderRows(data);
            rankCount.textContent = data.length + ' peserta';
        })
        .catch(function() {
            tableBody.innerHTML = '<tr><td colspan="4" class="state-cell">'
                + '<div class="state-title" style="color:#991b1b">Gagal memuat ranking</div>'
                + '<div class="state-sub">Periksa koneksi dan coba lagi</div>'
                + '</td></tr>';
        });
    });

    /* Auto-trigger if exam_id already in URL (dari Blade request()) */
    if (examSelect.value) {
        examSelect.dispatchEvent(new Event('change'));
    }
})();
</script>
</body>
</html>