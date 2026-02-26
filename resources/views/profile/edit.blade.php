@extends('layouts.master')

@section('title', 'Edit Profile')

@section('layoutContent')
<div class="container py-4">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            {{-- Page Header --}}
            <div class="mb-4">
                <h2 class="fw-bold">Pengaturan Profil</h2>
                <p class="text-muted">Kelola informasi akun dan keamanan Anda</p>
            </div>

            {{-- Profile Information Card --}}
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0"><i class="bi bi-person-circle me-2"></i>Informasi Profil</h5>
                </div>
                <div class="card-body">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            {{-- Update Password Card --}}
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0"><i class="bi bi-shield-lock me-2"></i>Ubah Password</h5>
                </div>
                <div class="card-body">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            {{-- Delete Account Card --}}
            <div class="card shadow-sm border-danger mb-4">
                <div class="card-header bg-white border-bottom border-danger">
                    <h5 class="mb-0 text-danger"><i class="bi bi-exclamation-triangle me-2"></i>Zona Berbahaya</h5>
                </div>
                <div class="card-body">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</div>
@endsection