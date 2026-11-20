<header class="mb-3">
    <h2 class="h5 font-weight-bold text-danger mb-1">Hapus akun</h2>
    <p class="small text-gray-600 mb-0">
        Tindakan ini permanen dan akan menghapus akun Anda. Konfirmasi dengan kata sandi sebelum melanjutkan.
    </p>
</header>

@if ($errors->userDeletion->isNotEmpty())
    <div class="alert alert-danger" role="alert">
        Kata sandi tidak valid. Silakan coba lagi.
    </div>
@endif

<button type="button" class="btn btn-outline-danger" data-toggle="modal" data-target="#deleteAccountModal">
    <i class="fas fa-trash-alt mr-1"></i> Hapus akun saya
</button>

<div class="modal fade" id="deleteAccountModal" tabindex="-1" role="dialog" aria-labelledby="deleteAccountModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="POST" action="{{ route('profile.destroy') }}">
                @csrf
                @method('DELETE')

                <div class="modal-header">
                    <h5 class="modal-title" id="deleteAccountModalLabel">Konfirmasi penghapusan akun</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Data akun Anda akan dihapus secara permanen. Masukkan kata sandi untuk mengonfirmasi.</p>
                    <label for="delete_account_password">Kata sandi</label>
                    <input id="delete_account_password" name="password" type="password"
                        class="form-control @error('password', 'userDeletion') is-invalid @enderror"
                        autocomplete="current-password" required>
                    @error('password', 'userDeletion')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Ya, hapus akun</button>
                </div>
            </form>
        </div>
    </div>
</div>
