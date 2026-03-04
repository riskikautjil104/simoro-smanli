@extends('layouts.master')
@section('title', 'Pengajuan Ulang Akses Ujian')
@section('layoutContent')
<div class="container py-4">
    <div class="alert alert-danger">
        <b>Anda telah dikeluarkan dari ujian karena keluar tab atau pelanggaran lainnya.</b><br>
        Untuk melanjutkan ujian, silakan ajukan permohonan akses ulang ke admin/guru dengan alasan yang jelas.
    </div>
    <form id="formReapply" method="POST" action="{{ route('siswa.ujian.reapply', $exam->id) }}">
        @csrf
        <div class="mb-3">
            <label for="alasan" class="form-label">Alasan keluar ujian/tab:</label>
            <textarea name="alasan" id="alasan" class="form-control" rows="3" required>{{ $session->reapply_reason }}</textarea>
        </div>
        <button type="submit" class="btn btn-primary">Ajukan Ulang Akses Ujian</button>
    </form>
    @if($session->reapply_status == 1)
        <div class="alert alert-info mt-3">Pengajuan ulang sedang menunggu persetujuan admin/guru.</div>
    @elseif($session->reapply_status == 3)
        <div class="alert alert-danger mt-3">Pengajuan ulang ditolak. Silakan hubungi admin/guru.</div>
    @endif
</div>
@endsection
