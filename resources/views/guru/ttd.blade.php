@extends('layouts.master')

@section('title', 'Tanda Tangan Digital')

@section('layoutContent')
<div class="row justify-content-center">
    <div class="col-md-7 col-lg-6">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <b>Tanda Tangan Digital</b>
            </div>
            <div class="card-body">
                <div class="mb-3 text-center">
                    <canvas id="ttd-canvas" width="400" height="120" style="border:1px solid #ccc;"></canvas>
                </div>
                <div class="mb-3 text-center">
                    @if(!empty($ttd_signature))
                        <div>
                            <span class="text-muted small">TTD Tersimpan:</span><br>
                            <img id="preview-ttd" src="{{ $ttd_signature }}" alt="TTD Tersimpan" style="max-width:300px;max-height:80px;border:1px solid #eee;" />
                        </div>
                    @else
                        <img id="preview-ttd" src="" style="display:none;max-width:300px;max-height:80px;border:1px solid #eee;" />
                    @endif
                </div>
                <div class="d-flex justify-content-between">
                    <button id="btn-clear" class="btn btn-outline-secondary">Bersihkan</button>
                    <button id="btn-simpan" class="btn btn-success">Simpan TTD</button>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
const canvas = document.getElementById('ttd-canvas');
const ctx = canvas.getContext('2d');
let drawing = false;
canvas.addEventListener('mousedown', e => { drawing = true; ctx.beginPath(); });
canvas.addEventListener('mouseup', e => { drawing = false; });
canvas.addEventListener('mouseout', e => { drawing = false; });
canvas.addEventListener('mousemove', function(e) {
    if (!drawing) return;
    const rect = canvas.getBoundingClientRect();
    ctx.lineTo(e.clientX - rect.left, e.clientY - rect.top);
    ctx.stroke();
});
document.getElementById('btn-clear').onclick = function() {
    ctx.clearRect(0, 0, canvas.width, canvas.height);
};
document.getElementById('btn-simpan').onclick = function() {
    const ttdData = canvas.toDataURL('image/png');
    fetch('/guru/ttd', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ ttd_signature: ttdData })
    })
    .then(res => res.json())
    .then(res => {
        // Tampilkan preview setelah simpan
        document.getElementById('preview-ttd').src = ttdData;
        document.getElementById('preview-ttd').style.display = '';
        alert(res.message || 'TTD berhasil disimpan!');
    })
    .catch(() => alert('Gagal simpan TTD'));
};
// Jika ada ttd_signature dari backend, tampilkan juga di canvas saat load
@if(!empty($ttd_signature))
window.onload = function() {
    const img = new Image();
    img.onload = function() {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        ctx.drawImage(img, 0, 0, canvas.width, canvas.height);
    };
    img.src = @json($ttd_signature);
};
@endif
</script>
@endsection
