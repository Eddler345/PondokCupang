<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Pemesanan Ikan Cupang</title>

    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
        .hero {
            background: linear-gradient(to right, #007bff, #00c6ff);
            color: white;
            padding: 100px 0;
            text-align: center;
        }
        .hero h1 {
            font-weight: 700;
            font-size: 2.8rem;
        }
        .hero p {
            font-size: 1.2rem;
            margin-top: 10px;
        }
        .btn-main {
            background-color: white;
            color: #007bff;
            border-radius: 25px;
            padding: 10px 25px;
            font-weight: 600;
            transition: 0.3s;
        }
        .btn-main:hover {
            background-color: #0056b3;
            color: white;
        }
        .section-title {
            font-weight: 700;
            margin-bottom: 40px;
            color: #333;
        }
        .fish-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .fish-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.2);
        }
        footer {
            background-color: #f8f9fa;
            text-align: center;
            padding: 20px 0;
            margin-top: 60px;
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm fixed-top">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center gap-2 fw-bold text-primary" href="#">
                <img src="{{ asset('img/logo.png') }}" alt="Logo" style="width:48px;height:48px;object-fit:cover;border-radius:8px;">
                <span>Pondok Cupang Bengkulu</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    @if (Route::has('login'))
                        @auth
                           
                        @else
                            <li class="nav-item">
                                <a href="{{ route('login') }}" class="btn btn-outline-primary me-2 px-3">Masuk</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('register') }}" class="btn btn-primary px-3">Daftar</a>
                            </li>
                        @endauth
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    @php $home = \App\Models\Page::firstWhere('key','home'); @endphp
    <section class="hero">
        <div class="container">
            <h1>{{ $home->title ?? 'Selamat Datang di Sistem Pemesanan Ikan Cupang' }}</h1>
            <p>{{ $home->content ?? 'Temukan berbagai jenis ikan cupang berkualitas tinggi langsung dari breeder terbaik.' }}</p>
            <a href="{{ route('register') }}" class="btn btn-main mt-3">Mulai Sekarang</a>
        </div>
    </section>

    <!-- Showcase Section -->
    <section class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="text-center section-title mb-0">Jenis Ikan Cupang Populer</h2>
            @auth
                @if(auth()->user()->role === 'admin')
                    <a href="{{ route('admin.fish.create') }}" class="btn btn-success">Tambah Ikan</a>
                @endif
            @endauth
        </div>
        <div class="row g-4">
            @php $fishes = \App\Models\BettaFish::all(); @endphp
            @forelse($fishes as $fish)
                <div class="col-md-4">
                    <div class="card fish-card border-0 shadow-sm">
                        @if($fish->image)
                            <img src="{{ asset('storage/'.$fish->image) }}" class="card-img-top" alt="{{ $fish->name }}">
                        @else
                            <img src="{{ asset('img/betta.jpeg') }}" class="card-img-top" alt="{{ $fish->name }}">
                        @endif
                        <div class="card-body text-center">
                            <h5 class="card-title">{{ $fish->name }}</h5>
                            <p class="text-muted">{{ \Illuminate\Support\Str::limit($fish->description ?? '-', 120) }}</p>
                            @auth
                                @if(auth()->user()->role === 'admin')
                                    <div class="mt-3">
                                        <a href="{{ route('admin.fish.edit', $fish->id) }}" class="btn btn-sm btn-outline-primary me-2">Edit</a>
                                    </div>
                                @endif
                            @endauth
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center">
                    <p class="text-muted">Belum ada data ikan.</p>
                </div>
            @endforelse
        </div>
    </section>

    <!-- Info Section -->
    <section class="container mt-5 text-center">
        <h2 class="section-title">Kenapa Memilih Kami?</h2>
        <div class="row justify-content-center">
            <div class="col-md-4">
                <h5 class="fw-bold text-primary">🐠 Pilihan Terbaik</h5>
                <p>Ikan cupang berkualitas tinggi dari breeder berpengalaman.</p>
            </div>
            <div class="col-md-4">
                <h5 class="fw-bold text-primary">🚚 Pengiriman Aman</h5>
                <p>Kami memastikan ikan dikirim dengan aman dan cepat ke tempatmu.</p>
            </div>
            <div class="col-md-4">
                <h5 class="fw-bold text-primary">💬 Layanan Responsif</h5>
                <p>Tim kami siap membantu kapan saja kamu butuh bantuan.</p>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <p class="mb-0">@pondok_cupang_bengkulu — Sistem Pemesanan Ikan Cupang</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
