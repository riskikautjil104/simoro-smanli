@extends('layouts.master')

@section('title', 'Tanda Tangan Digital Admin')

@push('styles')
<style>
.page-header {
    background: linear-gradient(135deg, var(--primary), var(--accent));
    border-radius: 16px;
    padding: 24px 28px;
    color: #fff;
    margin-bottom: 24px;
}
.ttd-canvas-wrap {
    border: 2px dashed #cbd5e1;
    border-radius: 14px;
    background: #f8fafc;
    position: relative;
    overflow: hidden;
    touch-action: none;
    width: 100%;
    max-width: 500px;
    margin: 0 auto;
}
#ttdCanvas {
    display: block;
    width: 100%;
    height: 180px;
    cursor: crosshair;
}
.ttd-preview-box {
    width: 180px;
    height: 90px;
    border: 1.5px solid #e2e8f0;
    border-radius: 10px;
    background: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 6px;
}
.ttd-preview-box img {
    max-height: 100%;
    max-width: 100%;
    object-fit: contain;
}
</style>
@endpush

@section('layoutContent')

<div class="page-header">
    <h4 class="fw-bold mb-1"><i class="bi bi-vector-pen me-2"></i>Tanda Tangan Digital Administrator</h4>
    <p class="mb-0 text-white-50">Atur tanda tangan digital resmi untuk disematkan pada laporan hasil ujian dan dokumen sistem</p>
</div>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show shadow-sm rounded-4" role="alert">
    <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

<div class="row g-4">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
            <h5 class="fw-bold mb-3"><i class="bi bi-pencil me-2 text-primary"></i>Buat / Gambar Tanda Tangan</h5>
            <p class="text-muted small mb-3">Tanda tangani area di bawah menggunakan mouse atau layar sentuh (HP/Tablet):</p>

            <div class="ttd-canvas-wrap mb-3 shadow-inner">
                <canvas id="ttdCanvas" width="500" height="180"></canvas>
            </div>

            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-4">
                <button type="button" class="btn btn-outline-danger btn-sm rounded-pill px-3" id="btnClearCanvas">
                    <i class="bi bi-eraser me-1"></i> Bersihkan Canvas
                </button>
                <div class="d-flex align-items-center gap-2">
                    <span class="text-muted small">Atau Upload Gambar:</span>
                    <input type="file" id="uploadTtdFile" accept="image/png,image/jpeg" class="form-control form-control-sm rounded-pill" style="max-width: 220px;">
                </div>
            </div>

            <form method="POST" action="{{ route('admin.ttd.update') }}" id="formTtdAdmin">
                @csrf
                <input type="hidden" name="ttd_signature" id="ttdSignatureInput" value="{{ $user->ttd_signature }}">

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary rounded-pill px-4 shadow-sm" id="btnSimpanTtd">
                        <i class="bi bi-save me-1"></i> Simpan Tanda Tangan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card border-0 shadow-sm rounded-4 p-4 bg-white text-center">
            <h6 class="fw-bold mb-3"><i class="bi bi-shield-check me-2 text-success"></i>TTD Aktif Saat Ini</h6>
            <div class="ttd-preview-box mx-auto mb-3">
                @if($user->ttd_signature)
                    <img src="{{ $user->ttd_signature }}" id="activeTtdImg" alt="TTD Admin">
                @else
                    <span class="text-muted small" id="activeTtdPlaceholder">Belum ada TTD</span>
                @endif
            </div>
            <div class="fw-bold text-dark">{{ $user->name }}</div>
            <div class="text-muted small">Administrator SIMORO</div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const canvas = document.getElementById('ttdCanvas');
    const ctx    = canvas.getContext('2d');
    const input  = document.getElementById('ttdSignatureInput');
    const upload = document.getElementById('uploadTtdFile');
    const btnClear = document.getElementById('btnClearCanvas');
    let isDrawing = false;
    let hasDrawn  = false;

    ctx.strokeStyle = '#000';
    ctx.lineWidth   = 2.5;
    ctx.lineCap     = 'round';
    ctx.lineJoin    = 'round';

    @if($user->ttd_signature)
        let img = new Image();
        img.onload = function() {
            ctx.drawImage(img, 0, 0, canvas.width, canvas.height);
            hasDrawn = true;
        };
        img.src = @json($user->ttd_signature);
    @endif

    function getPos(e) {
        const rect = canvas.getBoundingClientRect();
        const scaleX = canvas.width / rect.width;
        const scaleY = canvas.height / rect.height;
        if (e.touches && e.touches[0]) {
            return {
                x: (e.touches[0].clientX - rect.left) * scaleX,
                y: (e.touches[0].clientY - rect.top) * scaleY
            };
        }
        return {
            x: (e.clientX - rect.left) * scaleX,
            y: (e.clientY - rect.top) * scaleY
        };
    }

    function startDraw(e) {
        e.preventDefault();
        isDrawing = true;
        hasDrawn  = true;
        const pos = getPos(e);
        ctx.beginPath();
        ctx.moveTo(pos.x, pos.y);
    }

    function moveDraw(e) {
        if (!isDrawing) return;
        e.preventDefault();
        const pos = getPos(e);
        ctx.lineTo(pos.x, pos.y);
        ctx.stroke();
    }

    function endDraw(e) {
        if (isDrawing) {
            isDrawing = false;
            input.value = canvas.toDataURL('image/png');
        }
    }

    // Mouse events
    canvas.addEventListener('mousedown', startDraw);
    canvas.addEventListener('mousemove', moveDraw);
    window.addEventListener('mouseup', endDraw);

    // Touch events
    canvas.addEventListener('touchstart', startDraw, { passive: false });
    canvas.addEventListener('touchmove', moveDraw, { passive: false });
    window.addEventListener('touchend', endDraw);

    // Clear
    btnClear.addEventListener('click', function() {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        input.value = '';
        hasDrawn = false;
    });

    // Upload image
    upload.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (!file) return;
        const reader = new FileReader();
        reader.onload = function(evt) {
            const uploadedImg = new Image();
            uploadedImg.onload = function() {
                ctx.clearRect(0, 0, canvas.width, canvas.height);
                ctx.drawImage(uploadedImg, 0, 0, canvas.width, canvas.height);
                input.value = canvas.toDataURL('image/png');
                hasDrawn = true;
            };
            uploadedImg.src = evt.target.result;
        };
        reader.readAsDataURL(file);
    });

    // Submit form check
    document.getElementById('formTtdAdmin').addEventListener('submit', function(e) {
        if (hasDrawn) {
            input.value = canvas.toDataURL('image/png');
        }
    });
});
</script>
@endpush
