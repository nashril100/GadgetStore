@extends('layouts.app')

@section('title', 'Pengaturan')

@section('page_heading', 'Pengaturan akun')

@section('content')
    <div class="alert alert-info shadow-sm" role="status">
        <i class="fas fa-info-circle mr-1"></i>
        Pengaturan profil dan kata sandi dapat diperbarui melalui halaman profil.
    </div>

    <div class="row">
        <div class="col-lg-7 mb-4">
            <section class="card shadow-sm border-0 h-100">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-4">
                        <div class="icon-circle bg-primary text-white mr-3">
                            <i class="fas fa-user"></i>
                        </div>
                        <div>
                            <h2 class="h5 font-weight-bold text-gray-800 mb-1">Informasi akun</h2>
                            <p class="small text-gray-500 mb-0">Identitas akun yang sedang digunakan.</p>
                        </div>
                    </div>

                    <dl class="row mb-4">
                        <dt class="col-sm-4 text-gray-500">Nama</dt>
                        <dd class="col-sm-8 font-weight-bold">{{ auth()->user()->name }}</dd>
                        <dt class="col-sm-4 text-gray-500">Alamat email</dt>
                        <dd class="col-sm-8 font-weight-bold">{{ auth()->user()->email }}</dd>
                        <dt class="col-sm-4 text-gray-500">Peran akun</dt>
                        <dd class="col-sm-8">
                            <span class="badge badge-pill {{ auth()->user()->isAdmin() ? 'badge-primary' : 'badge-info' }}">
                                {{ auth()->user()->isAdmin() ? 'Administrator' : 'Pengguna' }}
                            </span>
                        </dd>
                        <dt class="col-sm-4 text-gray-500">Terdaftar sejak</dt>
                        <dd class="col-sm-8 mb-0">{{ auth()->user()->created_at->format('d/m/Y') }}</dd>
                    </dl>

                    <a href="{{ route('profile.edit') }}#profile-information" class="btn btn-primary">
                        <i class="fas fa-user-edit mr-1"></i> Ubah informasi profil
                    </a>
                </div>
            </section>
        </div>

        <div class="col-lg-5 mb-4">
            <section class="card shadow-sm border-0 h-100">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-4">
                        <div class="icon-circle bg-success text-white mr-3">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <div>
                            <h2 class="h5 font-weight-bold text-gray-800 mb-1">Keamanan akun</h2>
                            <p class="small text-gray-500 mb-0">Jaga akses akun tetap aman.</p>
                        </div>
                    </div>

                    <p class="text-gray-600">
                        Kata sandi tidak pernah ditampilkan. Anda dapat menggantinya dengan mengonfirmasi kata sandi saat ini.
                    </p>
                    <a href="{{ route('profile.edit') }}#password-change" class="btn btn-outline-primary">
                        <i class="fas fa-key mr-1"></i> Ubah kata sandi
                    </a>
                </div>
            </section>
        </div>

        <div class="col-12 mb-4">
            <section class="card shadow-sm border-0">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-3">
                        <div class="icon-circle bg-info text-white mr-3">
                            <i class="fas fa-lock"></i>
                        </div>
                        <div>
                            <h2 class="h5 font-weight-bold text-gray-800 mb-1">Akses dan peran</h2>
                            <p class="small text-gray-500 mb-0">Menu yang tersedia mengikuti hak akses akun Anda.</p>
                        </div>
                    </div>

                    @if (auth()->user()->isAdmin())
                        <p class="text-gray-600">Sebagai administrator, Anda dapat mengelola produk, kategori, dan informasi akun.</p>
                        <a href="{{ route('products.index') }}" class="btn btn-sm btn-outline-primary mr-2 mb-2">
                            <i class="fas fa-boxes mr-1"></i> Kelola produk
                        </a>
                        <a href="{{ route('categories.index') }}" class="btn btn-sm btn-outline-primary mb-2">
                            <i class="fas fa-tags mr-1"></i> Kelola kategori
                        </a>
                    @else
                        <p class="text-gray-600">Akun pengguna memiliki akses untuk melihat dashboard dan menjelajahi katalog produk.</p>
                        <a href="{{ route('products.index') }}" class="btn btn-sm btn-outline-primary">
                            <i class="fas fa-box-open mr-1"></i> Buka katalog
                        </a>
                    @endif
                </div>
            </section>
        </div>
    </div>
@endsection
