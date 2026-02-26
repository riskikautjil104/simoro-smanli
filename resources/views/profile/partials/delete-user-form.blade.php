<section>
    <div class="mb-4">
        <p class="text-muted mb-0">
            Setelah akun Anda dihapus, semua sumber daya dan data akan dihapus secara permanen. 
            Sebelum menghapus akun, silakan unduh data atau informasi yang ingin Anda simpan.
        </p>
    </div>

    <button 
        type="button" 
        class="btn btn-danger" 
        data-bs-toggle="modal" 
        data-bs-target="#confirmUserDeletion"
    >
        <i class="bi bi-trash me-1"></i>Hapus Akun
    </button>

    {{-- Delete Confirmation Modal --}}
    <div 
        class="modal fade" 
        id="confirmUserDeletion" 
        tabindex="-1" 
        aria-labelledby="confirmUserDeletionLabel" 
        aria-hidden="true"
        @if($errors->userDeletion->isNotEmpty()) data-bs-show="true" @endif
    >
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form method="post" action="{{ route('profile.destroy') }}">
                    @csrf
                    @method('delete')

                    <div class="modal-header border-0">
                        <h5 class="modal-title text-danger" id="confirmUserDeletionLabel">
                            <i class="bi bi-exclamation-triangle me-2"></i>Konfirmasi Penghapusan Akun
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <div class="alert alert-danger">
                            <strong>Peringatan!</strong> Tindakan ini tidak dapat dibatalkan.
                        </div>

                        <p class="mb-3">
                            Apakah Anda yakin ingin menghapus akun Anda? Setelah akun dihapus, 
                            semua sumber daya dan data akan dihapus secara permanen.
                        </p>

                        <div class="mb-3">
                            <label for="password" class="form-label fw-semibold">
                                Masukkan Password untuk Konfirmasi
                            </label>
                            <input 
                                type="password" 
                                class="form-control @error('password', 'userDeletion') is-invalid @enderror" 
                                id="password" 
                                name="password" 
                                placeholder="Password Anda"
                            >
                            @error('password', 'userDeletion')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="bi bi-x-circle me-1"></i>Batal
                        </button>
                        <button type="submit" class="btn btn-danger">
                            <i class="bi bi-trash me-1"></i>Ya, Hapus Akun Saya
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

@if($errors->userDeletion->isNotEmpty())
    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const modal = new bootstrap.Modal(document.getElementById('confirmUserDeletion'));
            modal.show();
        });
    </script>
    @endpush
@endif