<section>
    <div class="mb-4">
        <p class="text-muted mb-0">
            Pastikan akun Anda menggunakan password yang panjang dan acak agar tetap aman.
        </p>
    </div>

    <form method="post" action="{{ route('password.update') }}">
        @csrf
        @method('put')

        {{-- Current Password --}}
        <div class="mb-3">
            <label for="update_password_current_password" class="form-label fw-semibold">
                Password Saat Ini
            </label>
            <input 
                type="password" 
                class="form-control @error('current_password', 'updatePassword') is-invalid @enderror" 
                id="update_password_current_password" 
                name="current_password" 
                autocomplete="current-password"
            >
            @error('current_password', 'updatePassword')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- New Password --}}
        <div class="mb-3">
            <label for="update_password_password" class="form-label fw-semibold">
                Password Baru
            </label>
            <input 
                type="password" 
                class="form-control @error('password', 'updatePassword') is-invalid @enderror" 
                id="update_password_password" 
                name="password" 
                autocomplete="new-password"
            >
            @error('password', 'updatePassword')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <small class="text-muted">Minimal 8 karakter, kombinasi huruf, angka, dan simbol.</small>
        </div>

        {{-- Confirm Password --}}
        <div class="mb-3">
            <label for="update_password_password_confirmation" class="form-label fw-semibold">
                Konfirmasi Password Baru
            </label>
            <input 
                type="password" 
                class="form-control @error('password_confirmation', 'updatePassword') is-invalid @enderror" 
                id="update_password_password_confirmation" 
                name="password_confirmation" 
                autocomplete="new-password"
            >
            @error('password_confirmation', 'updatePassword')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Submit Button --}}
        <div class="d-flex align-items-center gap-3">
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-shield-check me-1"></i>Update Password
            </button>

            @if (session('status') === 'password-updated')
                <span class="text-success" id="password-saved">
                    <i class="bi bi-check-circle-fill me-1"></i>Password berhasil diubah!
                </span>
            @endif
        </div>
    </form>
</section>

@if (session('status') === 'password-updated')
    @push('scripts')
    <script>
        setTimeout(() => {
            const message = document.getElementById('password-saved');
            if (message) {
                message.style.transition = 'opacity 0.5s';
                message.style.opacity = '0';
                setTimeout(() => message.remove(), 500);
            }
        }, 2000);
    </script>
    @endpush
@endif