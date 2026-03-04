@extends('layouts.master')
@section('title', 'Hasil Ujian')
@section('layoutContent')
<div class="card p-4">
    <h4>Hasil Ujian: {{ $examSession->exam->title ?? '-' }}</h4>
    <table class="table table-bordered mt-3">
        <tr><th>Nama Ujian</th><td>{{ $examSession->exam->title ?? '-' }}</td></tr>
        <tr><th>Mata Pelajaran</th><td>{{ $examSession->exam->subject->name ?? '-' }}</td></tr>
        <tr><th>Tanggal</th><td>{{ $examSession->created_at ? $examSession->created_at->format('d-m-Y') : '-' }}</td></tr>
        <tr><th>Nilai</th><td>{{ $examSession->score ?? '-' }}</td></tr>
        <tr><th>Status</th><td>{{ $examSession->score !== null ? 'Sudah Diperiksa' : 'Belum Diperiksa' }}</td></tr>
    </table>
    <div class="mt-3">
        <a href="{{ route('siswa.ujian.hasil.pdf', $examSession->id) }}" target="_blank" class="btn btn-success">Cetak Hasil</a>
        <a href="{{ route('siswa.ujian.riwayat') }}" class="btn btn-secondary">Kembali</a>
    </div>
</div>
@endsection
