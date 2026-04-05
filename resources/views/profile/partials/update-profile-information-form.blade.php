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

            {{-- Email Verification Alert --}}
            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="alert alert-warning mt-3 mb-0">
                    <small>
                        <i class="bi bi-exclamation-circle me-1"></i>
                        Email Anda belum diverifikasi.
                        <button 
                            form="send-verification" 
                            class="btn btn-link btn-sm p-0 align-baseline text-decoration-underline"
                        >
                            Klik di sini untuk mengirim ulang email verifikasi.
                        </button>
                    </small>

                    @if (session('status') === 'verification-link-sent')
                        <div class="mt-2">
                            <small class="text-success fw-semibold">
                                <i class="bi bi-check-circle me-1"></i>
                                Link verifikasi baru telah dikirim ke email Anda.
                            </small>
                        </div>
                    @endif
                </div>
            @endif
        </div>

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