@extends('layouts.app')

@section('title', 'Riwayat aktivitas')

@section('page_heading', 'Riwayat aktivitas')

@section('content')
    <div class="row">
        <div class="col-xl-9 mb-4">
            <section class="card shadow-sm border-0">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-3">
                        <div class="icon-circle bg-primary text-white mr-3">
                            <i class="fas fa-history"></i>
                        </div>
                        <div>
                            <h2 class="h5 font-weight-bold text-gray-800 mb-1">Aktivitas katalog terbaru</h2>
                            <p class="small text-gray-500 mb-0">Produk dan kategori yang terakhir dibuat atau diperbarui.</p>
                        </div>
                    </div>

                    <div class="alert alert-light border small text-gray-600">
                        Riwayat ini memakai waktu perubahan data katalog. Sistem belum mencatat nama pelaku atau data yang sudah dihapus.
                    </div>

                    @forelse ($activities as $activity)
                        <article class="d-flex align-items-start border-bottom py-3">
                            <div class="icon-circle {{ $activity['color'] }} text-white mr-3 flex-shrink-0">
                                <i class="fas {{ $activity['icon'] }}"></i>
                            </div>
                            <div class="flex-grow-1">
                                <div class="font-weight-bold text-gray-800">{{ $activity['action'] }}</div>
                                <div>{{ $activity['name'] }}</div>
                                <div class="small text-gray-500">{{ $activity['detail'] }}</div>
                                <time class="small text-gray-500" datetime="{{ $activity['occurred_at']->toIso8601String() }}">
                                    {{ $activity['occurred_at']->format('d/m/Y H:i') }}
                                </time>
                            </div>
                            <a href="{{ $activity['url'] }}" class="btn btn-sm btn-outline-primary ml-2"
                                aria-label="Lihat {{ $activity['name'] }}">
                                <i class="fas fa-arrow-right"></i>
                            </a>
                        </article>
                    @empty
                        <div class="text-center text-gray-500 py-5">
                            <i class="fas fa-clipboard-list fa-2x mb-3"></i>
                            <h3 class="h6 font-weight-bold">Belum ada aktivitas katalog</h3>
                            <p class="small mb-0">Aktivitas akan muncul setelah produk atau kategori dibuat.</p>
                        </div>
                    @endforelse
                </div>
            </section>
        </div>

        <div class="col-xl-3 mb-4">
            <section class="card shadow-sm border-0 h-100">
                <div class="card-body p-4">
                    <h2 class="h6 font-weight-bold text-gray-800">Jelajahi katalog</h2>
                    <p class="small text-gray-500">Buka daftar produk untuk melihat informasi terbaru.</p>
                    <a href="{{ route('products.index') }}" class="btn btn-primary btn-block">
                        <i class="fas fa-box-open mr-1"></i> Buka produk
                    </a>

                    @if (auth()->user()->isAdmin())
                        <a href="{{ route('categories.index') }}" class="btn btn-outline-primary btn-block mt-2">
                            <i class="fas fa-tags mr-1"></i> Buka kategori
                        </a>
                    @endif
                </div>
            </section>
        </div>
    </div>
@endsection
