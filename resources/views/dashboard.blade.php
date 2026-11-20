@extends('layouts.app')

@section('title', 'Dashboard')

@section('page_heading', 'Dashboard')

@push('styles')
    <style>
        .dashboard-hero {
            background: linear-gradient(120deg, #224abe 0%, #4e73df 58%, #6f8ff0 100%);
            border-radius: .75rem;
            overflow: hidden;
            position: relative;
        }

        .dashboard-hero::after {
            background: rgba(255, 255, 255, .08);
            border-radius: 50%;
            content: "";
            height: 19rem;
            position: absolute;
            right: -5rem;
            top: -10rem;
            width: 19rem;
        }

        .dashboard-hero-content {
            position: relative;
            z-index: 1;
        }

        .dashboard-hero-kicker {
            letter-spacing: .12em;
            opacity: .8;
        }

        .dashboard-hero-copy {
            opacity: .85;
        }

        .dashboard-stat-card {
            border-left: 4px solid transparent;
            border-radius: .65rem;
            transition: transform .18s ease, box-shadow .18s ease;
        }

        .dashboard-stat-card:hover {
            box-shadow: 0 .75rem 1.5rem rgba(58, 59, 69, .12) !important;
            transform: translateY(-3px);
        }

        .dashboard-stat-primary {
            border-left-color: #4e73df;
        }

        .dashboard-stat-success {
            border-left-color: #1cc88a;
        }

        .dashboard-stat-info {
            border-left-color: #36b9cc;
        }

        .dashboard-stat-warning {
            border-left-color: #f6c23e;
        }

        .dashboard-stat-icon {
            align-items: center;
            background: #f3f5fc;
            border-radius: .75rem;
            display: flex;
            font-size: 1.25rem;
            height: 3rem;
            justify-content: center;
            width: 3rem;
        }

        .dashboard-panel {
            border: 0;
            border-radius: .7rem;
            box-shadow: 0 .25rem 1.25rem rgba(58, 59, 69, .08);
        }

        .dashboard-chart {
            height: 270px;
            position: relative;
        }

        .dashboard-empty-state {
            align-items: center;
            background: #f8f9fc;
            border: 1px dashed #d1d3e2;
            border-radius: .65rem;
            color: #858796;
            display: flex;
            flex-direction: column;
            height: 100%;
            justify-content: center;
            min-height: 180px;
            padding: 1.5rem;
            text-align: center;
        }

        .dashboard-empty-state i {
            color: #b7b9cc;
            font-size: 1.75rem;
            margin-bottom: .75rem;
        }

        @media (max-width: 575.98px) {
            .dashboard-chart {
                height: 230px;
            }
        }
    </style>
@endpush

@section('content')
    @php
        $greeting = match (true) {
            now()->hour < 11 => 'Selamat pagi',
            now()->hour < 15 => 'Selamat siang',
            now()->hour < 18 => 'Selamat sore',
            default => 'Selamat malam',
        };
    @endphp

    <div class="dashboard-page pb-4">
        <section class="dashboard-hero text-white p-4 p-md-5 mb-4">
            <div class="dashboard-hero-content d-flex flex-column flex-md-row align-items-md-center justify-content-between">
                <div class="mb-3 mb-md-0">
                    <div class="dashboard-hero-kicker small text-uppercase font-weight-bold mb-2">
                        {{ auth()->user()->isAdmin() ? 'Panel administrator' : 'Panel pengguna' }}
                    </div>
                    <h2 class="h3 font-weight-bold mb-2">{{ $greeting }}, {{ auth()->user()->name }}!</h2>
                    <p class="dashboard-hero-copy mb-0">
                        @if (auth()->user()->isAdmin())
                            Kelola katalog, kategori, dan pantau kondisi persediaan toko.
                        @else
                            Jelajahi katalog dan pantau ketersediaan produk Gadget Store.
                        @endif
                    </p>
                    <div class="dashboard-hero-kicker small mt-3">
                        <i class="far fa-calendar-alt mr-1"></i> {{ now()->format('d/m/Y') }}
                    </div>
                </div>
                <div class="d-flex flex-wrap">
                    @if (auth()->user()->isAdmin())
                        <a href="{{ route('products.create') }}" class="btn btn-light text-primary font-weight-bold mr-2 mb-2">
                            <i class="fas fa-plus mr-1"></i> Tambah produk
                        </a>
                    @endif
                    <a href="{{ route('products.index') }}" class="btn btn-outline-light font-weight-bold mb-2">
                        <i class="fas fa-box-open mr-1"></i> Lihat katalog
                    </a>
                </div>
            </div>
        </section>

        <form action="{{ route('products.index') }}" method="GET" class="card dashboard-panel mb-4">
            <div class="card-body d-flex flex-column flex-md-row align-items-md-center">
                <div class="mr-md-4 mb-3 mb-md-0">
                    <div class="font-weight-bold text-gray-800">Cari di katalog</div>
                    <div class="small text-gray-500">Temukan produk berdasarkan nama, kode, atau merek.</div>
                </div>
                <div class="input-group">
                    <input type="search" name="q" class="form-control" placeholder="Contoh: Samsung atau PROD-001"
                        aria-label="Cari produk berdasarkan nama, kode, atau merek">
                    <div class="input-group-append">
                        <button class="btn btn-primary px-4" type="submit">
                            <i class="fas fa-search mr-1"></i> Cari
                        </button>
                    </div>
                </div>
            </div>
        </form>

        <div class="row">
            <div class="col-sm-6 col-xl-3 mb-3">
                <div class="card dashboard-stat-card dashboard-stat-primary h-100">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <div>
                            <div class="small text-uppercase font-weight-bold text-primary mb-2">Total produk</div>
                            <div class="h3 font-weight-bold text-gray-800 mb-0">{{ number_format($totalProducts) }}</div>
                            <div class="small text-gray-500 mt-1">produk terdaftar</div>
                        </div>
                        <div class="dashboard-stat-icon text-primary"><i class="fas fa-mobile-alt"></i></div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3 mb-3">
                <div class="card dashboard-stat-card dashboard-stat-success h-100">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <div>
                            <div class="small text-uppercase font-weight-bold text-success mb-2">Kategori</div>
                            <div class="h3 font-weight-bold text-gray-800 mb-0">{{ number_format($totalCategories) }}</div>
                            <div class="small text-gray-500 mt-1">kelompok produk</div>
                        </div>
                        <div class="dashboard-stat-icon text-success"><i class="fas fa-tags"></i></div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3 mb-3">
                <div class="card dashboard-stat-card dashboard-stat-info h-100">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <div>
                            <div class="small text-uppercase font-weight-bold text-info mb-2">Unit stok</div>
                            <div class="h3 font-weight-bold text-gray-800 mb-0">{{ number_format($totalStock) }}</div>
                            <div class="small text-gray-500 mt-1">unit tersedia</div>
                        </div>
                        <div class="dashboard-stat-icon text-info"><i class="fas fa-cubes"></i></div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3 mb-3">
                <div class="card dashboard-stat-card dashboard-stat-warning h-100">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <div>
                            <div class="small text-uppercase font-weight-bold text-warning mb-2">Stok menipis</div>
                            <div class="h3 font-weight-bold text-gray-800 mb-0">{{ number_format($lowStockProducts) }}</div>
                            <div class="small text-gray-500 mt-1">produk dengan stok ≤ 5</div>
                        </div>
                        <div class="dashboard-stat-icon text-warning"><i class="fas fa-exclamation-triangle"></i></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8 mb-4">
                <section class="card dashboard-panel h-100">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <div>
                                <h5 class="font-weight-bold text-gray-800 mb-1">Produk per kategori</h5>
                                <div class="small text-gray-500">Sebaran produk di setiap kategori</div>
                            </div>
                            <span class="dashboard-stat-icon text-primary"><i class="fas fa-chart-bar"></i></span>
                        </div>
                        @if ($totalProducts > 0)
                            <div class="dashboard-chart"><canvas id="categoryChart"></canvas></div>
                        @else
                            <div class="dashboard-empty-state">
                                <i class="fas fa-chart-bar"></i>
                                <div class="font-weight-bold">Belum ada data produk</div>
                                <div class="small">Grafik akan tampil setelah produk tersedia.</div>
                            </div>
                        @endif
                    </div>
                </section>
            </div>
            <div class="col-lg-4 mb-4">
                <section class="card dashboard-panel h-100">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <div>
                                <h5 class="font-weight-bold text-gray-800 mb-1">Kondisi stok</h5>
                                <div class="small text-gray-500">Jumlah produk berdasarkan stok</div>
                            </div>
                            <span class="dashboard-stat-icon text-info"><i class="fas fa-chart-pie"></i></span>
                        </div>
                        @if ($totalProducts > 0)
                            <div class="dashboard-chart"><canvas id="stockChart"></canvas></div>
                        @else
                            <div class="dashboard-empty-state">
                                <i class="fas fa-box-open"></i>
                                <div class="font-weight-bold">Belum ada data stok</div>
                                <div class="small">Grafik akan tampil setelah produk tersedia.</div>
                            </div>
                        @endif
                        <div class="small text-gray-500 text-center mt-2">Menipis 0–5 · Cukup 6–20 · Banyak &gt; 20 unit</div>
                    </div>
                </section>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8 mb-4">
                <section class="card dashboard-panel h-100">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <div>
                                <h5 class="font-weight-bold text-gray-800 mb-1">Unit stok per kategori</h5>
                                <div class="small text-gray-500">Total ketersediaan barang</div>
                            </div>
                            <span class="dashboard-stat-icon text-success"><i class="fas fa-chart-line"></i></span>
                        </div>
                        @if ($totalProducts > 0)
                            <div class="dashboard-chart"><canvas id="stockByCategoryChart"></canvas></div>
                        @else
                            <div class="dashboard-empty-state">
                                <i class="fas fa-chart-line"></i>
                                <div class="font-weight-bold">Belum ada data stok</div>
                                <div class="small">Grafik akan tampil setelah produk tersedia.</div>
                            </div>
                        @endif
                    </div>
                </section>
            </div>
            <div class="col-lg-4 mb-4">
                <section class="card dashboard-panel h-100">
                    <div class="card-body p-4 d-flex flex-column">
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <div>
                                <h5 class="font-weight-bold text-gray-800 mb-1">Nilai persediaan</h5>
                                <div class="small text-gray-500">Estimasi harga × stok</div>
                            </div>
                            <span class="dashboard-stat-icon text-primary"><i class="fas fa-wallet"></i></span>
                        </div>
                        <div class="h3 font-weight-bold text-primary mb-2">Rp {{ number_format($inventoryValue, 0, ',', '.') }}</div>
                        <p class="small text-gray-500 mb-4">Nilai estimasi barang yang tersedia, bukan omzet atau laba penjualan.</p>
                        @if ($totalProducts === 0)
                            <div class="alert alert-info small mt-auto mb-0">
                                <i class="fas fa-info-circle mr-1"></i> Belum ada produk untuk dihitung.
                            </div>
                        @elseif ($lowStockProducts > 0)
                            <div class="alert alert-warning small mt-auto mb-0">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                <strong>{{ number_format($lowStockProducts) }} produk</strong> perlu diperiksa.
                                <a href="#restock-panel" class="alert-link d-block mt-1">Lihat prioritas restock</a>
                            </div>
                        @else
                            <div class="alert alert-success small mt-auto mb-0">
                                <i class="fas fa-check-circle mr-1"></i> Semua produk memiliki stok lebih dari 5 unit.
                            </div>
                        @endif
                    </div>
                </section>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-8 mb-4">
                <section class="card dashboard-panel h-100">
                    <div class="card-body p-4">
                        <div class="d-flex flex-column flex-sm-row align-items-sm-center justify-content-between mb-3">
                            <div class="mb-2 mb-sm-0">
                                <h5 class="font-weight-bold text-gray-800 mb-1">Produk terbaru</h5>
                                <div class="small text-gray-500">Produk yang terakhir ditambahkan ke katalog</div>
                            </div>
                            <a href="{{ route('products.index') }}" class="btn btn-sm btn-outline-primary">
                                Lihat semua produk <i class="fas fa-arrow-right ml-1"></i>
                            </a>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Kode</th>
                                        <th>Nama produk</th>
                                        <th>Kategori</th>
                                        <th>Harga</th>
                                        <th class="text-right">Stok</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($latestProducts as $product)
                                        <tr>
                                            <td class="text-gray-500">{{ $product->product_code }}</td>
                                            <td class="font-weight-bold text-gray-800">{{ $product->name }}</td>
                                            <td>{{ $product->category->name }}</td>
                                            <td>Rp {{ number_format((float) $product->price, 0, ',', '.') }}</td>
                                            <td class="text-right">
                                                <span class="badge badge-pill {{ $product->stock <= 5 ? 'badge-warning' : 'badge-success' }}">
                                                    {{ number_format($product->stock) }} unit
                                                </span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center text-gray-500 py-4">
                                                Belum ada produk. Katalog akan tampil di sini setelah produk ditambahkan.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </section>
            </div>

            <div class="col-xl-4 mb-4">
                <section class="card dashboard-panel h-100" id="restock-panel">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-start justify-content-between mb-3">
                            <div>
                                <h5 class="font-weight-bold text-gray-800 mb-1">Produk perlu restock</h5>
                                <div class="small text-gray-500">
                                    Menampilkan {{ $restockProducts->count() }} dari {{ number_format($lowStockProducts) }}
                                    produk dengan stok maksimal 5 unit
                                </div>
                            </div>
                            <span class="dashboard-stat-icon {{ $lowStockProducts > 0 ? 'text-warning' : 'text-success' }}">
                                <i class="fas {{ $lowStockProducts > 0 ? 'fa-exclamation-triangle' : 'fa-check' }}"></i>
                            </span>
                        </div>

                        @forelse ($restockProducts as $product)
                            <div class="border-bottom py-3">
                                <div class="d-flex align-items-start justify-content-between">
                                    <div class="pr-2">
                                        <div class="font-weight-bold text-gray-800">{{ $product->name }}</div>
                                        <div class="small text-gray-500">
                                            {{ $product->product_code }} · {{ $product->category->name }}
                                        </div>
                                    </div>
                                    <span class="badge badge-pill {{ $product->stock === 0 ? 'badge-danger' : 'badge-warning' }}">
                                        {{ number_format($product->stock) }} unit
                                    </span>
                                </div>
                                @if (auth()->user()->isAdmin())
                                    <a href="{{ route('products.edit', $product) }}" class="small d-inline-block mt-2">
                                        <i class="fas fa-pen mr-1"></i> Perbarui stok
                                    </a>
                                @endif
                            </div>
                        @empty
                            <div class="dashboard-empty-state">
                                @if ($totalProducts === 0)
                                    <i class="fas fa-box-open"></i>
                                    <div class="font-weight-bold">Katalog masih kosong.</div>
                                    <div class="small">Tambahkan produk untuk mulai memantau stok.</div>
                                @else
                                    <i class="fas fa-check-circle"></i>
                                    <div class="font-weight-bold">Belum ada produk yang perlu ditambah.</div>
                                    <div class="small">Stok semua produk berada di atas batas minimum.</div>
                                @endif
                            </div>
                        @endforelse

                        @if ($restockProducts->isNotEmpty())
                            <a href="{{ route('products.index') }}" class="btn btn-sm btn-light btn-block mt-3">
                                Buka katalog <i class="fas fa-arrow-right ml-1"></i>
                            </a>
                        @endif
                    </div>
                </section>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        const categoryLabels = @json($categoryStats->pluck('name')->values());
        const productCounts = @json($categoryStats->pluck('product_count')->map(fn ($value) => (int) $value)->values());
        const stockTotals = @json($categoryStats->pluck('stock_total')->map(fn ($value) => (int) $value)->values());
        const stockStatus = @json($stockStatus);

        Chart.defaults.global.defaultFontFamily = "'Nunito', sans-serif";
        Chart.defaults.global.defaultFontColor = '#858796';

        const categoryCanvas = document.getElementById('categoryChart');
        if (categoryCanvas) {
            new Chart(categoryCanvas, {
                type: 'bar',
                data: {
                    labels: categoryLabels,
                    datasets: [{
                        label: 'Jumlah produk',
                        data: productCounts,
                        backgroundColor: 'rgba(78, 115, 223, .8)',
                        maxBarThickness: 42
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    legend: { display: false },
                    scales: {
                        yAxes: [{
                            ticks: { beginAtZero: true, precision: 0, padding: 10 },
                            gridLines: { color: 'rgba(133, 135, 150, .12)', drawBorder: false }
                        }],
                        xAxes: [{ gridLines: { display: false } }]
                    }
                }
            });
        }

        const stockCanvas = document.getElementById('stockChart');
        if (stockCanvas) {
            new Chart(stockCanvas, {
                type: 'doughnut',
                data: {
                    labels: ['Stok menipis', 'Stok cukup', 'Stok banyak'],
                    datasets: [{
                        data: stockStatus,
                        backgroundColor: ['#f6c23e', '#36b9cc', '#1cc88a'],
                        hoverBackgroundColor: ['#dda20a', '#2c9faf', '#17a673'],
                        borderWidth: 2,
                        borderColor: '#ffffff'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutoutPercentage: 72,
                    legend: {
                        position: 'bottom',
                        labels: { usePointStyle: true, padding: 18 }
                    }
                }
            });
        }

        const stockByCategoryCanvas = document.getElementById('stockByCategoryChart');
        if (stockByCategoryCanvas) {
            new Chart(stockByCategoryCanvas, {
                type: 'bar',
                data: {
                    labels: categoryLabels,
                    datasets: [{
                        label: 'Unit stok',
                        data: stockTotals,
                        backgroundColor: 'rgba(28, 200, 138, .78)',
                        maxBarThickness: 42
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    legend: { display: false },
                    scales: {
                        yAxes: [{
                            ticks: { beginAtZero: true, precision: 0, padding: 10 },
                            gridLines: { color: 'rgba(133, 135, 150, .12)', drawBorder: false }
                        }],
                        xAxes: [{ gridLines: { display: false } }]
                    }
                }
            });
        }
    </script>
@endpush
