@extends('layouts.app')

@section('title', 'Profil')

@section('page_heading', 'Profil & Keamanan')

@section('content')
    <div class="row">
        <div class="col-lg-8 mb-4">
            <section class="card shadow-sm border-0 h-100" id="profile-information">
                <div class="card-body p-4">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </section>
        </div>

        <div class="col-lg-4 mb-4">
            <section class="card shadow-sm border-0 h-100">
                <div class="card-body p-4">
                    <div class="text-center mb-4">
                        <div class="text-primary mb-2"><i class="fas fa-user-circle fa-4x"></i></div>
                        <h2 class="h5 font-weight-bold text-gray-800 mb-1">{{ $user->name }}</h2>
                        <span class="badge badge-pill badge-primary">
                            {{ $user->isAdmin() ? 'Administrator' : 'Pengguna' }}
                        </span>
                    </div>
                    <dl class="mb-0">
                        <dt class="small text-gray-500">Alamat email</dt>
                        <dd class="font-weight-bold text-gray-800 mb-3">{{ $user->email }}</dd>
                        <dt class="small text-gray-500">Bergabung sejak</dt>
                        <dd class="font-weight-bold text-gray-800 mb-0">{{ $user->created_at->format('d/m/Y') }}</dd>
                    </dl>
                </div>
            </section>
        </div>
    </div>

    @if (session('status') === 'profile-updated')
        <div class="alert alert-success" role="status">Informasi profil berhasil diperbarui.</div>
    @elseif (session('status') === 'password-updated')
        <div class="alert alert-success" role="status">Kata sandi berhasil diperbarui.</div>
    @endif

    <section class="card shadow-sm border-0 mb-4" id="password-change">
        <div class="card-body p-4">
            @include('profile.partials.update-password-form')
        </div>
    </section>

    <section class="card border-danger shadow-sm mb-4">
        <div class="card-body p-4">
            @include('profile.partials.delete-user-form')
        </div>
    </section>
@endsection
