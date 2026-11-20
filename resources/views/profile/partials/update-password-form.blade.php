<header class="mb-4">
    <h2 class="h5 font-weight-bold text-gray-800 mb-1">Ubah kata sandi</h2>
    <p class="small text-gray-500 mb-0">Gunakan kata sandi yang kuat dan tidak digunakan pada akun lain.</p>
</header>

<form method="POST" action="{{ route('password.update') }}">
    @csrf
    @method('PUT')

    <div class="form-group">
        <label for="current_password">Kata sandi saat ini</label>
        <input id="current_password" name="current_password" type="password"
            class="form-control @error('current_password', 'updatePassword') is-invalid @enderror"
            autocomplete="current-password" required>
        @error('current_password', 'updatePassword')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="password">Kata sandi baru</label>
            <input id="password" name="password" type="password"
                class="form-control @error('password', 'updatePassword') is-invalid @enderror"
                autocomplete="new-password" required>
            @error('password', 'updatePassword')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group col-md-6">
            <label for="password_confirmation">Konfirmasi kata sandi</label>
            <input id="password_confirmation" name="password_confirmation" type="password"
                class="form-control" autocomplete="new-password" required>
        </div>
    </div>

    <button type="submit" class="btn btn-primary">
        <i class="fas fa-key mr-1"></i> Perbarui kata sandi
    </button>
</form>
