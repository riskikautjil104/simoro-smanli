@extends('layouts.master')
@section('title', 'Periksa Jawaban')

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

        .panel-card {
            background: #fff;
            border-radius: 16px;
            border: 1px solid var(--border-color);
            box-shadow: var(--shadow-sm);
            overflow: hidden;
            margin-bottom: 20px;
        }

        .panel-card-header {
            padding: 16px 20px;
            border-bottom: 1px solid var(--border-color);
            background: #f0f4ff;
            display: flex;
            align-items: center;
            gap: 8px;
            font-weight: 700;
            font-size: 0.9rem;
            color: var(--text-main);
        }

        .panel-card-header i {
            color: var(--primary);
        }

        .panel-card-body {
            padding: 20px;
        }

        .filter-select {
            height: 44px;
            border-radius: 12px;
            border: 1.5px solid var(--border-color);
            font-size: 0.875rem;
            padding: 0 16px;
            transition: var(--transition);
        }

        .filter-select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(13, 110, 253, 0.1);
            outline: none;
        }

        /* Soal card */
        .soal-card {
            background: #fff;
            border-radius: 14px;
            border: 1px solid var(--border-color);
            padding: 18px;
            margin-bottom: 14px;
            transition: var(--transition);
            border-left: 4px solid transparent;
        }

        .soal-card:hover {
            border-color: rgba(13, 110, 253, 0.2);
            border-left-color: var(--primary);
            box-shadow: 0 4px 16px rgba(13, 110, 253, 0.08);
        }

        .soal-card.essay {
            border-left-color: rgba(111, 66, 193, 0.4);
        }

        .soal-card.pg {
            border-left-color: rgba(13, 110, 253, 0.4);
        }

        .soal-badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            font-size: 0.7rem;
            font-weight: 700;
            padding: 3px 9px;
            border-radius: 20px;
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        .badge-pg {
            background: rgba(13, 110, 253, 0.1);
            color: #0d6efd;
        }

        .badge-essay {
            background: rgba(111, 66, 193, 0.1);
            color: #6f42c1;
        }

        .soal-text {
            font-size: 0.9rem;
            font-weight: 600;
            color: var(--text-main);
            margin-bottom: 10px;
            line-height: 1.5;
        }

        .soal-text img {
            max-width: 100%;
            height: auto;
            max-height: 300px;
            border-radius: 6px;
            margin: 8px 0;
            display: block;
        }

        .jawaban-row {
            display: flex;
            align-items: flex-start;
            gap: 8px;
            margin-bottom: 6px;
            font-size: 0.85rem;
        }

        .jawaban-row .label {
            font-weight: 700;
            color: var(--text-muted);
            min-width: 110px;
            font-size: 0.78rem;
        }

        .jawaban-row .value {
            color: var(--text-main);
        }

        .jawaban-row .value img {
            max-width: 100%;
            height: auto;
            max-height: 250px;
            border-radius: 6px;
            margin: 6px 0;
            display: block;
        }

        .jawaban-benar {
            color: #198754 !important;
            font-weight: 700;
        }

        .jawaban-salah {
            color: #dc3545 !important;
        }

        .nilai-essay-wrap {
            margin-top: 12px;
            padding-top: 12px;
            border-top: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .nilai-essay-wrap label {
            font-size: 0.78rem;
            font-weight: 700;
            color: var(--text-muted);
            white-space: nowrap;
        }

        .nilai-essay-input {
            width: 100px;
            height: 36px;
            border-radius: 8px;
            border: 1.5px solid var(--border-color);
            font-size: 0.875rem;
            padding: 0 12px;
            transition: var(--transition);
        }

        .nilai-essay-input:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(13, 110, 253, 0.1);
            outline: none;
        }

        /* Nilai total card */
        .nilai-total-card {
            background: linear-gradient(135deg, rgba(13, 110, 253, 0.06), rgba(13, 202, 240, 0.04));
            border: 1.5px solid rgba(13, 110, 253, 0.15);
            border-radius: 14px;
            padding: 18px 20px;
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .nilai-total-icon {
            width: 48px;
            height: 48px;
            background: linear-gradient(135deg, #0d6efd, #0dcaf0);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 1.2rem;
            flex-shrink: 0;
            box-shadow: 0 4px 14px rgba(13, 110, 253, 0.3);
        }

        .nilai-total-label {
            font-size: 0.78rem;
            font-weight: 600;
            color: var(--text-muted);
            margin-bottom: 2px;
        }

        .nilai-total-input {
            width: 100px;
            height: 38px;
            border-radius: 10px;
            border: 1.5px solid rgba(13, 110, 253, 0.2);
            font-size: 1rem;
            font-weight: 700;
            padding: 0 12px;
            color: var(--primary);
            transition: var(--transition);
        }

        .nilai-total-input:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(13, 110, 253, 0.1);
            outline: none;
        }

        .btn-simpan-soal {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 10px 20px;
            background: var(--primary);
            color: #fff;
            border: none;
            border-radius: 50px;
            font-size: 0.85rem;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            font-family: 'Poppins', sans-serif;
        }

        .btn-simpan-soal:hover {
            background: #0b5ed7;
            transform: translateY(-1px);
            box-shadow: 0 4px 16px rgba(13, 110, 253, 0.3);
        }

        .btn-simpan-soal:disabled {
            opacity: .6;
            pointer-events: none;
        }

        .btn-simpan-nilai {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 10px 22px;
            background: linear-gradient(135deg, #198754, #20c997);
            color: #fff;
            border: none;
            border-radius: 50px;
            font-size: 0.85rem;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            font-family: 'Poppins', sans-serif;
        }

        .btn-simpan-nilai:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 16px rgba(32, 201, 151, 0.3);
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

        #jawaban-container {
            display: none;
        }
    </style>
@endpush

@section('layoutContent')

    <div class="page-header">
        <div class="page-header-content">
            <h4><i class="bi bi-check2-square me-2"></i>Periksa Jawaban Siswa</h4>
            <p>Beri nilai essay dan simpan hasil penilaian jawaban siswa</p>
        </div>
    </div>

    {{-- Pilih Ujian & Siswa --}}
    <div class="panel-card">
        <div class="panel-card-header"><i class="bi bi-funnel"></i> Pilih Ujian & Siswa</div>
        <div class="panel-card-body">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Ujian</label>
                    <select id="ujian-select" class="form-select filter-select w-100">
                        <option value="">-- Pilih Ujian --</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Siswa</label>
                    <select id="peserta-select" class="form-select filter-select w-100" disabled>
                        <option value="">-- Pilih Siswa --</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    {{-- Jawaban --}}
    <div id="jawaban-container">

        <div class="panel-card">
            <div class="panel-card-header">
                <i class="bi bi-card-list"></i> Jawaban Siswa
                <span id="peserta-label"
                    style="font-weight:400;color:var(--text-muted);font-size:0.82rem;margin-left:8px;"></span>
            </div>
            <div class="panel-card-body">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
                    <button id="math-toggle-btn" class="math-toggle-btn" style="display: none;">
                        <i class="bi bi-eye"></i> <span class="toggle-text">Tampilkan LaTeX Raw</span>
                    </button>
                </div>
                <div id="jawaban-list"></div>

                <div class="d-flex justify-content-end mt-2">
                    <button id="btn-simpan-nilai-per-soal" class="btn-simpan-soal">
                        <i class="bi bi-save"></i> Simpan Nilai Per Soal
                    </button>
                </div>
            </div>
        </div>

        <div class="panel-card">
            <div class="panel-card-header"><i class="bi bi-trophy"></i> Nilai Akhir</div>
            <div class="panel-card-body">
                <div class="nilai-total-card mb-4">
                    <div class="nilai-total-icon"><i class="bi bi-award"></i></div>
                    <div>
                        <div class="nilai-total-label">Total Nilai Siswa</div>
                        <input type="number" id="input-nilai" class="nilai-total-input" min="0" max="100"
                            placeholder="0" readonly>
                        <div id="nilai-breakdown" style="font-size:.78rem;color:var(--text-muted);margin-top:6px;"></div>
                    </div>
                </div>
                <div style="font-size:.82rem;color:var(--text-muted);">
                    Nilai akhir dihitung otomatis (PG + Essay). Penilaian manual hanya untuk soal Essay.
                </div>
            </div>
        </div>

    </div>

    <style>
        /* Math display toggle */
        .math-raw {
            background: #f5f5f5;
            padding: 2px 6px;
            border-radius: 3px;
            font-family: 'Courier New', monospace;
            font-size: 0.85em;
            color: #666;
            display: inline-block;
        }

        /* Toggle button untuk math display */
        .math-toggle-btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 12px;
            background: rgba(13, 110, 253, 0.08);
            border: 1px solid rgba(13, 110, 253, 0.2);
            border-radius: 6px;
            font-size: 0.78rem;
            font-weight: 600;
            color: #0d6efd;
            cursor: pointer;
            transition: 0.2s;
            margin-bottom: 12px;
        }

        .math-toggle-btn:hover {
            background: rgba(13, 110, 253, 0.15);
            border-color: rgba(13, 110, 253, 0.3);
        }

        .math-toggle-btn.active {
            background: #0d6efd;
            color: white;
        }

        /* Hide rendered math when showing LaTeX */
        body.show-latex-raw .MathJax {
            display: none !important;
        }

        body.show-latex-raw .math-raw {
            display: inline-block !important;
        }

        /* Math formula wrapper */
        .math-latex-wrapper {
            display: inline;
        }

        .math-rendered {
            display: inline;
        }

        body.show-latex-raw .math-rendered {
            display: none !important;
        }

        body.show-latex-raw .math-raw {
            display: inline-block !important;
            background: #f5f5f5;
            padding: 2px 6px;
            border-radius: 3px;
            font-family: 'Courier New', monospace;
            font-size: 0.85em;
            color: #666;
            white-space: pre-wrap;
            word-wrap: break-word;
        }
    </style>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-svg.js" async></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        var ujianList = [];
        var pesertaList = [];
        var selectedUjian = null;
        var selectedPeserta = null;
        var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        /* ── Load ujian ── */
        fetch('/guru/ujian/list', {
                headers: {
                    'Accept': 'application/json'
                }
            })
            .then(function(r) {
                return r.ok ? r.json() : [];
            })
            .then(function(data) {
                ujianList = data;
                var sel = document.getElementById('ujian-select');
                data.forEach(function(u) {
                    sel.innerHTML += '<option value="' + u.id + '">' + (u.title || u.nama || '') + (u.subject ?
                        ' (' + u.subject.name + ')' : '') + '</option>';
                });
            })
            .catch(function() {
                Swal.fire('Error', 'Gagal mengambil data ujian.', 'error');
            });

        /* ── Pilih ujian ── */
        document.getElementById('ujian-select').addEventListener('change', function() {
            selectedUjian = this.value;
            selectedPeserta = null;

            var pesertaSel = document.getElementById('peserta-select');
            pesertaSel.innerHTML = '<option value="">-- Pilih Siswa --</option>';
            pesertaSel.disabled = !selectedUjian;
            document.getElementById('jawaban-container').style.display = 'none';

            if (!selectedUjian) return;

            fetch('/guru/ujian/' + selectedUjian + '/peserta', {
                    headers: {
                        'Accept': 'application/json'
                    }
                })
                .then(function(r) {
                    return r.ok ? r.json() : [];
                })
                .then(function(data) {
                    pesertaList = data;
                    data.forEach(function(p) {
                        pesertaSel.innerHTML += '<option value="' + p.user.id + '">' + p.user.name +
                            '</option>';
                    });
                    pesertaSel.disabled = false;
                })
                .catch(function() {
                    Swal.fire('Error', 'Gagal mengambil data peserta.', 'error');
                });
        });

        /* ── Pilih peserta ── */
        document.getElementById('peserta-select').addEventListener('change', function() {
            selectedPeserta = this.value;
            if (!selectedUjian || !selectedPeserta) {
                document.getElementById('jawaban-container').style.display = 'none';
                return;
            }

            var pesertaObj = pesertaList.find(function(p) {
                return p.user && p.user.id == selectedPeserta;
            });
            
            var pesertaName = pesertaObj && pesertaObj.user ? pesertaObj.user.name : '';
            document.getElementById('peserta-label').textContent = pesertaName ? '— ' + pesertaName : '';

            fetch('/guru/ujian/' + selectedUjian + '/peserta/' + selectedPeserta + '/jawaban', {
                    headers: {
                        'Accept': 'application/json'
                    }
                })
                .then(function(r) {
                    if (!r.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return r.json();
                })
                .then(function(data) {
                    console.log('Jawaban data:', data); // Debug
                    
                    document.getElementById('jawaban-container').style.display = 'block';

                    var list = document.getElementById('jawaban-list');
                    var totalScore = 0;
                    var html = '';

                    // Helper: wrap LaTeX dengan math-raw span untuk toggle display
                    function wrapLatexFormulas(text) {
                        if (!text) return text;
                        // Replace $$...$$  dengan wrapped version
                        return text.replace(/\$\$(.*?)\$\$/g, function(match, formula) {
                            return '<span class="math-latex-wrapper">' +
                                '<span class="math-rendered">$$' + formula + '$$</span>' +
                                '<span class="math-raw" data-formula="$$' + formula + '$$">$$' + formula + '$$</span>' +
                                '</span>';
                        });
                    }

                    // Validasi array
                    if (!Array.isArray(data) || data.length === 0) {
                        list.innerHTML = '<div class="empty-state"><div class="empty-icon"><i class="bi bi-inbox"></i></div><h6>Belum ada jawaban dari siswa</h6></div>';
                        document.getElementById('jawaban-container').style.display = 'block';
                        return;
                    }

                    data.forEach(function(j, idx) {
                        var tipe = '-';
                        var isEssay = false;
                        var isPG = false;
                        
                        // Validasi question exists
                        if (j.question) {
                            var qType = j.question.type || '';
                            isEssay = qType === 'essay';
                            isPG = qType === 'multiple_choice';
                            tipe = isEssay ? 'Essay' : isPG ? 'PG' : qType;
                        }

                        // Kunci jawaban - prioritas ke answer_key, lalu jawaban_benar
                        var correctKey = j.question ? (j.question.answer_key || j.question.jawaban_benar || '') : '';
                        var siswaJawab = j.answer || '-';
                        
                        // Cek jawaban benar untuk PG
                        var isCorrect = false;
                        if (isPG && correctKey && siswaJawab) {
                            isCorrect = siswaJawab.toString().toUpperCase() === correctKey.toString().toUpperCase();
                        }
                        
                        var scoreVal = j.nilai_essay != null ? j.nilai_essay : '';
                        if (scoreVal !== '' && !isNaN(scoreVal)) {
                            totalScore += parseFloat(scoreVal);
                        }

                        // Pertanyaan - prioritas ke question_text, lalu pertanyaan
                        var qText = j.question ? (j.question.question_text || j.question.pertanyaan || 'Soal #' + (idx + 1)) : 'Soal #' + (idx + 1);

                        // Kelas soal
                        var cardClass = isEssay ? 'essay' : (isPG ? 'pg' : '');
                        var badgeClass = isEssay ? 'badge-essay' : 'badge-pg';
                        var badgeIcon = isEssay ? 'pencil-square' : 'ui-radios';
                        
                        // Badge jawaban
                        var jawabanBadge = '';
                        if (isPG) {
                            jawabanBadge = isCorrect ? 
                                ' <i class="bi bi-check-circle-fill"></i>' : 
                                ' <i class="bi bi-x-circle-fill"></i>';
                        }

                        html += '<div class="soal-card ' + cardClass + '">' +
                            '<span class="soal-badge ' + badgeClass + '">' +
                            '<i class="bi bi-' + badgeIcon + '"></i> ' +
                            tipe +
                            '</span>' +
                            '<div class="soal-text">' + (idx + 1) + '. ' + wrapLatexFormulas(qText) + '</div>' +
                            '<div class="jawaban-row"><span class="label">Jawaban Siswa:</span>' +
                            '<span class="value ' + (isPG ? (isCorrect ? 'jawaban-benar' : 'jawaban-salah') : '') + '">' +
                            wrapLatexFormulas(siswaJawab) + jawabanBadge +
                            '</span>' +
                            '</div>';
                        
                        // Tampilkan kunci jawaban untuk PG
                        if (isPG && correctKey) {
                            html += '<div class="jawaban-row"><span class="label">Kunci Jawaban:</span><span class="value jawaban-benar">' +
                                wrapLatexFormulas(correctKey) + '</span></div>';
                        }
                        
                        // Tampilkan input nilai untuk Essay
                        if (isEssay) {
                            html += '<div class="nilai-essay-wrap">' +
                                '<label>Nilai Essay:</label>' +
                                '<input type="number" class="nilai-essay-input score-input" data-answer-id="' +
                                j.id + '" value="' + scoreVal + '" min="0" max="100" placeholder="0">' +
                                '</div>';
                        }
                        
                        html += '</div>';
                    });

                    list.innerHTML = html;

                    // Setup toggle button untuk LaTeX/Visual
                    var toggleBtn = document.getElementById('math-toggle-btn');
                    if (html && html.includes('math-latex-wrapper')) {
                        toggleBtn.style.display = 'inline-flex';
                        
                        var isShowingRaw = false;
                        toggleBtn.addEventListener('click', function() {
                            isShowingRaw = !isShowingRaw;
                            if (isShowingRaw) {
                                document.body.classList.add('show-latex-raw');
                                toggleBtn.classList.add('active');
                                toggleBtn.querySelector('.toggle-text').textContent = 'Tampilkan Visual';
                            } else {
                                document.body.classList.remove('show-latex-raw');
                                toggleBtn.classList.remove('active');
                                toggleBtn.querySelector('.toggle-text').textContent = 'Tampilkan LaTeX Raw';
                            }
                        });
                    } else {
                        toggleBtn.style.display = 'none';
                    }

                    // Trigger MathJax rendering
                    if (window.MathJax) {
                        window.MathJax.typesetPromise().catch(function(e) { console.log(e); });
                    }

                    /* Hitung nilai (client-side preview) */
                    var pgCount = 0;
                    var essayCount = 0;
                    var correctPgCount = 0;
                    var essaySum = 0;
                    data.forEach(function(j) {
                        var qType = j.question ? (j.question.type || '') : '';
                        var isEssayLocal = qType === 'essay';
                        var isPgLocal = qType === 'multiple_choice' || qType === 'pg';
                        if (isPgLocal) {
                            pgCount++;
                            var correctKeyLocal = j.question ? (j.question.answer_key || j.question.jawaban_benar || '') : '';
                            var siswaJawabLocal = j.answer || '';
                            if (correctKeyLocal && siswaJawabLocal &&
                                siswaJawabLocal.toString().toUpperCase() === correctKeyLocal.toString().toUpperCase()) {
                                correctPgCount++;
                            }
                        }
                        if (isEssayLocal) {
                            essayCount++;
                            var v = j.nilai_essay != null && !isNaN(j.nilai_essay) ? parseFloat(j.nilai_essay) : 0;
                            essaySum += v;
                        }
                    });

                    var bobotPg = 50, bobotEssay = 50;
                    if (pgCount === 0) { bobotPg = 0; bobotEssay = 100; }
                    else if (essayCount === 0) { bobotPg = 100; bobotEssay = 0; }
                    var nilaiPerPg = pgCount > 0 ? (bobotPg / pgCount) : 0;
                    var nilaiPerEssay = essayCount > 0 ? (bobotEssay / essayCount) : 0;
                    var nilaiPg = correctPgCount * nilaiPerPg;
                    var nilaiEssay = 0;
                    if (essayCount > 0) {
                        // clamp per soal sesuai aturan (max nilai per essay = nilaiPerEssay)
                        data.forEach(function(j) {
                            var qType = j.question ? (j.question.type || '') : '';
                            if (qType !== 'essay') return;
                            var v = j.nilai_essay != null && !isNaN(j.nilai_essay) ? parseFloat(j.nilai_essay) : 0;
                            nilaiEssay += Math.min(v, nilaiPerEssay);
                        });
                    }
                    var computedTotal = nilaiPg + nilaiEssay;
                    if (computedTotal > 100) computedTotal = 100;

                    document.getElementById('input-nilai').value = computedTotal ? computedTotal.toFixed(2) : '';
                    document.getElementById('nilai-breakdown').textContent =
                        'PG: ' + nilaiPg.toFixed(2) + ' · Essay: ' + nilaiEssay.toFixed(2) +
                        ' (Bobot ' + bobotPg + '/' + bobotEssay + ')';

                    /* Score input live update (hanya re-calc breakdown & total) */
                    document.querySelectorAll('.score-input').forEach(function(inp) {
                        inp.addEventListener('input', function() {
                            // Recompute essay part only; PG part tetap dari jawaban
                            var essaySumLocal = 0;
                            document.querySelectorAll('.score-input').forEach(function(i) {
                                var v = i.value !== '' && !isNaN(i.value) ? parseFloat(i.value) : 0;
                                essaySumLocal += Math.min(v, nilaiPerEssay);
                            });
                            var totalLocal = nilaiPg + essaySumLocal;
                            if (totalLocal > 100) totalLocal = 100;
                            document.getElementById('input-nilai').value = totalLocal ? totalLocal.toFixed(2) : '';
                            document.getElementById('nilai-breakdown').textContent =
                                'PG: ' + nilaiPg.toFixed(2) + ' · Essay: ' + essaySumLocal.toFixed(2) +
                                ' (Bobot ' + bobotPg + '/' + bobotEssay + ')';
                        });
                    });

                    /* Jika sudah ada score tersimpan, tampilkan sebagai referensi */
                    var existingScore = pesertaObj && pesertaObj.score != null ? pesertaObj.score : null;
                    if (existingScore !== null && existingScore !== undefined && existingScore !== '') {
                        document.getElementById('input-nilai').value = parseFloat(existingScore).toFixed(2);
                    }
                })
                .catch(function(err) {
                    console.error('Error fetching answers:', err);
                    Swal.fire('Error', 'Gagal mengambil jawaban siswa: ' + err.message, 'error');
                });
        });

        /* ── Simpan nilai per soal ── */
        document.getElementById('btn-simpan-nilai-per-soal').addEventListener('click', function() {
            var btn = this;
            var inputs = document.querySelectorAll('.score-input');
            var scores = [];
            var total = 0;

            inputs.forEach(function(inp) {
                if (inp.value !== '' && !isNaN(inp.value)) total += parseFloat(inp.value);
                scores.push({
                    answer_id: inp.getAttribute('data-answer-id'),
                    score: inp.value
                });
            });

            btn.disabled = true;
            btn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Menyimpan...';

            fetch('/guru/ujian/' + selectedUjian + '/peserta/' + selectedPeserta + '/nilai-per-soal', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        scores: scores
                    })
                })
                .then(function(r) {
                    return r.json();
                })
                .then(function(res) {
                    if (res && res.total !== undefined && res.total !== null) {
                        var totalNum = parseFloat(res.total);
                        if (Number.isFinite(totalNum)) {
                            document.getElementById('input-nilai').value = totalNum.toFixed(2);
                        }
                        if (res.nilai_pg !== undefined && res.nilai_essay !== undefined) {
                            var pgNum = parseFloat(res.nilai_pg);
                            var esNum = parseFloat(res.nilai_essay);
                            if (Number.isFinite(pgNum) && Number.isFinite(esNum)) {
                                document.getElementById('nilai-breakdown').textContent =
                                    'PG: ' + pgNum.toFixed(2) + ' · Essay: ' + esNum.toFixed(2) + ' (server)';
                            }
                        }
                    }
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: res.message || 'Nilai per soal berhasil disimpan.',
                        timer: 1500,
                        showConfirmButton: false
                    });
                })
                .catch(function() {
                    Swal.fire('Error', 'Gagal simpan nilai per soal.', 'error');
                })
                .finally(function() {
                    btn.disabled = false;
                    btn.innerHTML = '<i class="bi bi-save"></i> Simpan Nilai Per Soal';
                });
        });

        // Simpan nilai akhir manual dinonaktifkan (nilai dihitung otomatis dari PG + Essay)
    </script>
@endpush
