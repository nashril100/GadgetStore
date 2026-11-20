<header class="mb-4">
    <h2 class="h5 font-weight-bold text-gray-800 mb-1">Informasi profil</h2>
    <p class="small text-gray-500 mb-0">Perbarui nama dan alamat email yang digunakan pada akun Anda.</p>
</header>

<form method="POST" action="{{ route('profile.update') }}">
    @csrf
    @method('PATCH')

    <div class="form-group">
        <label for="name">Nama lengkap</label>
        <input id="name" name="name" type="text" value="{{ old('name', $user->name) }}"
            class="form-control @error('name') is-invalid @enderror" autocomplete="name" required autofocus>
        @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group">
        <label for="email">Alamat email</label>
        <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}"
            class="form-control @error('email') is-invalid @enderror" autocomplete="email" required>
        @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <button type="submit" class="btn btn-primary">
        <i class="fas fa-save mr-1"></i> Simpan profil
    </button>
</form>
