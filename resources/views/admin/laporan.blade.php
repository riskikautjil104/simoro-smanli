@extends('layouts.master')

@section('title', 'Laporan Hasil Ujian')

@section('layoutContent')
<div class="container py-4">
    <h4>Laporan Hasil Ujian</h4>
    <div class="card">
        <div class="card-body">
            <form class="row g-3 mb-3" id="filterLaporan">
                <div class="col-md-4">
                    <label for="ujianLaporan" class="form-label">Ujian</label>
                    <select class="form-control" id="ujianLaporan" name="ujian_id">
                        {{-- Opsi ujian --}}
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="kelasLaporan" class="form-label">Kelas</label>
                    <select class="form-control" id="kelasLaporan" name="kelas_id">
                        {{-- Opsi kelas --}}
                    </select>
                </div>
                <div class="col-md-4 align-self-end">
                    <button type="submit" class="btn btn-primary">Tampilkan</button>
                </div>
            </form>
            <table class="table table-bordered" id="laporanTable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Siswa</th>
                        <th>Kelas</th>
                        <th>Nilai</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- Data laporan akan di-render di sini --}}
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// TODO: AJAX untuk filter dan tampilkan laporan hasil ujian
</script>
@endpush
