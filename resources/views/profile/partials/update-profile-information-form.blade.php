<section>
    <div class="mb-4">
        <p class="text-muted mb-0">
            Perbarui informasi profil dan alamat email akun Anda.
        </p>
    </div>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}">
        @csrf
        @method('patch')

        {{-- Name Field --}}
        <div class="mb-3">
            <label for="name" class="form-label fw-semibold">Nama Lengkap</label>
            <input 
                type="text" 
                class="form-control @error('name') is-invalid @enderror" 
                id="name" 
                name="name" 
                value="{{ old('name', $user->name) }}" 
                required 
                autofocus 
                autocomplete="name"
            >
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Email Field --}}
        <div class="mb-3">
            <label for="email" class="form-label fw-semibold">Email</label>
            <input 
                type="email" 
                class="form-control @error('email') is-invalid @enderror" 
                id="email" 
                name="email" 
                value="{{ old('email', $user->email) }}" 
                required 
                autocomplete="username"
            >
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror

        {{-- NIP & NIK Field (untuk Guru, Kepala Sekolah, Admin) --}}
        @if(in_array($user->role, ['admin', 'teacher', 'kepala_sekolah']))
        <div class="row g-3 mb-3">
            <div class="col-md-6">
                <label for="nip" class="form-label fw-semibold">NIP</label>
                <input 
                    type="text" 
                    class="form-control @error('nip') is-invalid @enderror" 
                    id="nip" 
                    name="nip" 
                    value="{{ old('nip', $user->nip) }}" 
                    placeholder="Contoh: 198001012005011001"
                >
                @error('nip')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-6">
                <label for="nik" class="form-label fw-semibold">NIK</label>
                <input 
                    type="text" 
                    class="form-control @error('nik') is-invalid @enderror" 
                    id="nik" 
                    name="nik" 
                    value="{{ old('nik', $user->nik) }}" 
                    placeholder="Nomor Induk Kependudukan (16 digit)"
                >
                @error('nik')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
        @endif

        {{-- Phone Field --}}
        <div class="mb-3">
            <label for="phone" class="form-label fw-semibold">Nomor WhatsApp / HP</label>
            <input 
                type="text" 
                class="form-control @error('phone') is-invalid @enderror" 
                id="phone" 
                name="phone" 
                value="{{ old('phone', $user->phone) }}" 
                placeholder="Contoh: 081234567890"
            >
            @error('phone')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Tanda Tangan Digital (untuk Admin, Guru, Kepala Sekolah) --}}
        @if(in_array($user->role, ['admin', 'teacher', 'kepala_sekolah']))
        <div class="mb-4 p-3 bg-light rounded-3 border">
            <label class="form-label fw-bold text-dark d-flex align-items-center justify-content-between">
                <span><i class="bi bi-vector-pen me-1 text-primary"></i> Tanda Tangan Digital (TTD)</span>
                @if($user->ttd_signature)
                    <span class="badge bg-success"><i class="bi bi-check-circle me-1"></i> TTD Terpasang</span>
                @else
                    <span class="badge bg-secondary">Belum Diatur</span>
                @endif
            </label>
            <p class="text-muted small mb-2">Tanda tangan ini akan otomatis digunakan pada dokumen resmi (Berita Acara, Laporan Nilai, dan Lembar Hasil Ujian).</p>
            
            <div class="d-flex align-items-center gap-3 flex-wrap">
                @if($user->ttd_signature)
                <div class="border rounded bg-white p-2 text-center" style="width:160px;height:80px;display:flex;align-items:center;justify-content:center;">
                    <img src="{{ $user->ttd_signature }}" style="max-height:65px;max-width:140px;" alt="TTD Saya">
                </div>
                @endif
                <div>
                    @if($user->role === 'kepala_sekolah')
                        <a href="{{ route('kepala-sekolah.ttd.edit') }}" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                            <i class="bi bi-pencil me-1"></i> Gambar / Upload TTD Baru
                        </a>
                    @elseif($user->role === 'teacher')
                        <a href="{{ route('guru.ttd.edit') }}" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                            <i class="bi bi-pencil me-1"></i> Gambar / Upload TTD Baru
                        </a>
                    @else
                        <a href="{{ route('admin.ttd.edit') }}" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                            <i class="bi bi-pencil me-1"></i> Gambar / Upload TTD Baru
                        </a>
                    @endif
                </div>
            </div>
        </div>
        @endif

        {{-- Submit Button --}}
        <div class="d-flex align-items-center gap-3">
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-save me-1"></i>Simpan Perubahan
            </button>

            @if (session('status') === 'profile-updated')
                <span class="text-success" id="saved-message">
                    <i class="bi bi-check-circle-fill me-1"></i>Tersimpan!
                </span>
            @endif
        </div>
    </form>
</section>

@if (session('status') === 'profile-updated')
    @push('scripts')
    <script>
        setTimeout(() => {
            const message = document.getElementById('saved-message');
            if (message) {
                message.style.transition = 'opacity 0.5s';
                message.style.opacity = '0';
                setTimeout(() => message.remove(), 500);
            }
        }, 2000);
    </script>
    @endpush
@endif