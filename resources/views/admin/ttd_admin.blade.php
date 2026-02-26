@extends('layouts.master')

@section('title', 'Tanda Tangan Digital Admin')

@section('layoutContent')
<div class="container py-4">
    <h4>Atur Tanda Tangan Digital Admin</h4>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <form method="POST" action="{{ route('admin.ttd.update') }}">
        @csrf
        <div class="mb-3">
            <label><b>Tanda Tangan Digital (TTD):</b></label><br>
            <canvas id="ttdCanvas" width="300" height="100" style="border:1px solid #ccc; background:#fff; cursor:crosshair;"></canvas>
            <button type="button" class="btn btn-sm btn-warning" id="clearTtd">Bersihkan TTD</button>
            <input type="hidden" name="ttd_signature" id="ttdInput">
        </div>
        <button type="submit" class="btn btn-primary">Simpan TTD</button>
    </form>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ttdCanvas = document.getElementById('ttdCanvas');
    const ttdInput  = document.getElementById('ttdInput');
    const ctx       = ttdCanvas.getContext('2d');
    let drawing = false;

    // Load existing signature if any
    @if($user->ttd_signature)
        let img = new window.Image();
        img.onload = function() { ctx.drawImage(img, 0, 0, 300, 100); };
        img.src = @json($user->ttd_signature);
        ttdInput.value = img.src;
    @endif

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
});
</script>
@endpush
