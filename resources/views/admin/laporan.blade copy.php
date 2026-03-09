@extends('layouts.master')

@section('title', 'Laporan Hasil Ujian')

@section('layoutContent')
<div class="container py-4">
    <h4>Laporan Hasil Ujian (Dinamis & Detail)</h4>

    <div class="card mb-4">
        <div class="card-body">
            <form id="filterForm" class="row g-2">
                <div class="col-md-4">
                    <label>Ujian</label>
                    <select class="form-select" id="ujianSelect"></select>
                </div>
                <div class="col-md-4">
                    <label>Kelas</label>
                    <select class="form-select" id="kelasSelect"></select>
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <button type="button" class="btn btn-primary" id="btnFilter">
                        Tampilkan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-body">

            <div id="statistikBox" class="mb-3"></div>

            <div class="mb-3">
                <button class="btn btn-success btn-sm" id="btnExportExcel">
                    Export Excel
                </button>
                <button class="btn btn-danger btn-sm" id="btnExportPdf">
                    Export PDF
                </button>
                <button class="btn btn-secondary btn-sm" id="btnPreviewPdf">
                    Preview PDF
                </button>
            </div>

            <div class="mb-3">
                <label><b>Tanda Tangan Digital (TTD):</b></label><br>
                <canvas id="ttdCanvas" width="300" height="100"
                    style="border:1px solid #ccc; background:#fff; cursor:crosshair;">
                </canvas>
                <br>
                <button type="button" class="btn btn-sm btn-warning mt-2" id="clearTtd">
                    Bersihkan TTD
                </button>
                <input type="hidden" id="ttdInput">
            </div>

            <ul class="nav nav-tabs mb-3" id="laporanTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="tab-detail" data-bs-toggle="tab" data-bs-target="#tabDetail"
                        type="button" role="tab">Detail Ujian</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="tab-rekap" data-bs-toggle="tab" data-bs-target="#tabRekap"
                        type="button" role="tab">Rekap Per Siswa</button>
                </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane fade show active" id="tabDetail" role="tabpanel">
                    <table class="table table-bordered" id="laporanTable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Siswa</th>
                                <th>Kelas</th>
                                <th>Ujian</th>
                                <th>Nilai</th>
                                <th>Mulai</th>
                                <th>Selesai</th>
                                <th>Durasi</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
                <div class="tab-pane fade" id="tabRekap" role="tabpanel">
                    <table class="table table-bordered" id="rekapTable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Siswa</th>
                                <th>Kelas</th>
                                <th>Rata-rata Nilai</th>
                                <th>Ujian Diikuti</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection


@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
    // Tab event
    document.getElementById('tab-rekap').addEventListener('click', loadRekap);

    // Filter change event: update rekap setiap filter berubah
    document.getElementById('ujianSelect').addEventListener('change', loadRekap);
    document.getElementById('kelasSelect').addEventListener('change', loadRekap);

    // ===============================
    // TTD CANVAS
    // ===============================
    const ttdCanvas = document.getElementById('ttdCanvas');
    const ttdInput  = document.getElementById('ttdInput');
    const ctx       = ttdCanvas.getContext('2d');
    let drawing = false;

    // Load TTD admin dari backend (AJAX)
    fetch('/admin/ttd/json')
        .then(res => res.json())
        .then(data => {
            if (data.ttd_signature) {
                let img = new window.Image();
                img.onload = function() { ctx.drawImage(img, 0, 0, 300, 100); saveTtd(); };
                img.src = data.ttd_signature;
            }
        });

    ttdCanvas.addEventListener('mousedown', function(e) {
        drawing = true;
        ctx.beginPath();
        ctx.moveTo(e.offsetX, e.offsetY);
    });
    ttdCanvas.addEventListener('mousemove', function(e) {
        if (drawing) {
            ctx.lineTo(e.offsetX, e.offsetY);
            ctx.stroke();
        }
    });
    ttdCanvas.addEventListener('mouseup', function() {
        drawing = false;
        saveTtd();
    });
    ttdCanvas.addEventListener('mouseleave', function() {
        drawing = false;
    });
    document.getElementById('clearTtd').onclick = function() {
        ctx.clearRect(0, 0, ttdCanvas.width, ttdCanvas.height);
        saveTtd();
    };
    function saveTtd() {
        ttdInput.value = ttdCanvas.toDataURL('image/png');
    }


    // ===============================
    // LOAD FILTER OPTIONS
    // ===============================
    function loadFilterOptions() {

        fetch('/admin/ujian/list')
            .then(res => res.json())
            .then(data => {
                let opt = '<option value="">Semua Ujian</option>';
                data.forEach(u => {
                    opt += `<option value="${u.id}">${u.nama}</option>`;
                });
                document.getElementById('ujianSelect').innerHTML = opt;

                // Setelah ujian selesai di-load, load kelas
                fetch('/admin/kelas/list')
                    .then(res => res.json())
                    .then(data => {
                        let opt = '<option value="">Semua Kelas</option>';
                        data.forEach(k => {
                            opt += `<option value="${k.id}">${k.name}</option>`;
                        });
                        document.getElementById('kelasSelect').innerHTML = opt;

                        // Setelah filter selesai, baru panggil loadLaporan dan loadRekap
                        loadLaporan();
                        loadRekap();
                    })
                    .catch(err => console.error('Error load kelas:', err));
            })
            .catch(err => console.error('Error load ujian:', err));
    }


    // ===============================
    // LOAD LAPORAN
    // ===============================
    function loadLaporan() {

        const ujianId = document.getElementById('ujianSelect').value;
        const kelasId = document.getElementById('kelasSelect').value;

        fetch(`/admin/laporan/data?ujian_id=${ujianId}&kelas_id=${kelasId}`)
            .then(res => res.json())
            .then(resp => {

                let rows = '';

                if (resp.data && resp.data.length > 0) {
                    resp.data.forEach((d, i) => {
                        rows += `
                            <tr>
                                <td>${i+1}</td>
                                <td>${d.nama ?? '-'}</td>
                                <td>${d.kelas ?? '-'}</td>
                                <td>${d.ujian ?? '-'}</td>
                                <td>${d.nilai ?? '-'}</td>
                                <td>${d.mulai ?? '-'}</td>
                                <td>${d.selesai ?? '-'}</td>
                                <td>${d.durasi ?? '-'}</td>
                            </tr>
                        `;
                    });
                } else {
                    rows = `
                        <tr>
                            <td colspan="8" class="text-center">
                                Data tidak ditemukan
                            </td>
                        </tr>
                    `;
                }

                document.querySelector('#laporanTable tbody').innerHTML = rows;


                // ===============================
                // STATISTIK AMAN
                // ===============================
                if (resp.statistik) {

                    const rata = resp.statistik.rata_rata !== null
                        ? Number(resp.statistik.rata_rata).toFixed(2)
                        : '-';

                    document.getElementById('statistikBox').innerHTML = `
                        <b>Jumlah Peserta:</b> ${resp.statistik.jumlah_peserta ?? '-'} |
                        <b>Rata-rata:</b> ${rata} |
                        <b>Tertinggi:</b> ${resp.statistik.nilai_tertinggi ?? '-'} |
                        <b>Terendah:</b> ${resp.statistik.nilai_terendah ?? '-'}
                    `;
                }

            })
            .catch(err => {
                console.error('Error load laporan:', err);
                alert('Terjadi kesalahan saat mengambil data');
            });
    }

    function loadRekap() {
        const ujianId = document.getElementById('ujianSelect').value;
        const kelasId = document.getElementById('kelasSelect').value;
        // Hanya fetch jika filter tidak kosong
        if (!ujianId || !kelasId) {
            document.querySelector('#rekapTable tbody').innerHTML = '<tr><td colspan="5" class="text-center">Pilih ujian dan kelas terlebih dahulu</td></tr>';
            return;
        }
        fetch(`/admin/laporan/rekap-siswa?ujian_id=${ujianId}&kelas_id=${kelasId}`)
            .then(res => res.json())
            .then(resp => {
                let rows = '';
                if (resp.data && resp.data.length > 0) {
                    resp.data.forEach((d, i) => {
                        let nilai = '-';
                        if (typeof d.rata_rata !== 'undefined') {
                            nilai = d.rata_rata !== null ? Number(d.rata_rata).toFixed(2) : '-';
                        } else if (typeof d.nilai !== 'undefined') {
                            nilai = d.nilai !== null ? Number(d.nilai).toFixed(2) : '-';
                        }
                        rows += `<tr>
                            <td>${i+1}</td>
                            <td>${d.nama ?? '-'}</td>
                            <td>${d.kelas ?? '-'}</td>
                            <td>${nilai}</td>
                            <td>${d.ujian ?? '-'}</td>
                        </tr>`;
                    });
                } else {
                    rows = `<tr><td colspan="5" class="text-center">Data tidak ditemukan</td></tr>`;
                }
                document.querySelector('#rekapTable tbody').innerHTML = rows;
            })
            .catch(err => {
                console.error('Error load rekap:', err);
                document.querySelector('#rekapTable tbody').innerHTML = '<tr><td colspan="5" class="text-center">Terjadi kesalahan saat mengambil data rekap</td></tr>';
            });
    }


    // ===============================
    // BUTTON EVENTS
    // ===============================
    document.getElementById('btnFilter').onclick = loadLaporan;

    document.getElementById('btnExportExcel').onclick = function() {
        const ujianId = document.getElementById('ujianSelect').value;
        const kelasId = document.getElementById('kelasSelect').value;
        window.open(`/admin/laporan/export-excel?ujian_id=${ujianId}&kelas_id=${kelasId}`);
    };

    document.getElementById('btnExportPdf').onclick = function() {
        const ujianId = document.getElementById('ujianSelect').value;
        const kelasId = document.getElementById('kelasSelect').value;
        let ttd = document.getElementById('ttdInput').value;
        if (ttd === '' || ttd.endsWith('base64,iVBORw0KGgoAAAANSUhEUgAAASwAAABkCAYAAAB')) {
            fetch('/admin/ttd/json').then(res => res.json()).then(data => {
                if (data.ttd_signature) ttd = data.ttd_signature;
                window.open(`/admin/laporan/export-pdf?ujian_id=${ujianId}&kelas_id=${kelasId}&ttd=${encodeURIComponent(ttd)}`);
            });
        } else {
            window.open(`/admin/laporan/export-pdf?ujian_id=${ujianId}&kelas_id=${kelasId}&ttd=${encodeURIComponent(ttd)}`);
        }
    };

    document.getElementById('btnPreviewPdf').onclick = function() {
        const ujianId = document.getElementById('ujianSelect').value;
        const kelasId = document.getElementById('kelasSelect').value;
        let ttd = document.getElementById('ttdInput').value;
        // Jika canvas kosong, ambil ttd admin dari backend
        if (ttd === '' || ttd.endsWith('base64,iVBORw0KGgoAAAANSUhEUgAAASwAAABkCAYAAAB')) { // PNG kosong
            fetch('/admin/ttd/json').then(res => res.json()).then(data => {
                if (data.ttd_signature) ttd = data.ttd_signature;
                window.open(`/admin/laporan/preview-pdf?ujian_id=${ujianId}&kelas_id=${kelasId}&ttd=${encodeURIComponent(ttd)}`);
            });
        } else {
            window.open(`/admin/laporan/preview-pdf?ujian_id=${ujianId}&kelas_id=${kelasId}&ttd=${encodeURIComponent(ttd)}`);
        }
    };


    // ===============================
    // INIT LOAD
    // ===============================
    loadFilterOptions();

});
</script>
@endpush