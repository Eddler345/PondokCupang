@extends('layouts.app')

@section('content')
<style>
    .btn-outline-primary:hover {
        background-color: #007bff;
        color: white !important;
    }
    .btn-outline-danger:hover {
        background-color: #dc3545;
        color: white !important;
    }
    canvas {
        max-height: 260px;
    }
</style>

<div class="container-fluid py-4">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="d-flex align-items-center gap-3">
            <img src="{{ asset('img/logo.png') }}" alt="Logo" style="width:64px;height:64px;object-fit:cover;border-radius:8px;">
            <div>
                <h2 class="fw-bold text-primary mb-0">Admin Dashboard</h2>
                <p class="text-muted mb-0">Pantau aktivitas sistem dan data terkini</p>
            </div>
        </div>
        <div class="d-flex gap-2">
            <a href="/" class="btn btn-outline-primary rounded-pill px-3 fw-semibold">
                <i class="bi bi-house-door me-1"></i> Home
            </a>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-outline-danger rounded-pill px-3 fw-semibold">
                    <i class="bi bi-box-arrow-right me-1"></i> Logout
                </button>
            </form>
        </div>
    </div>

    {{-- Statistik Utama --}}
    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm p-3 bg-gradient bg-light">
                <div class="card-body text-center">
                    <h6 class="text-secondary">Total Pesanan</h6>
                    <h2 class="fw-bold text-success">{{ $totalOrders }}</h2>
                    <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-outline-success mt-2 rounded-pill">Lihat Pesanan</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm p-3 bg-gradient bg-light">
                <div class="card-body text-center">
                    <h6 class="text-secondary">Jumlah Jenis Ikan</h6>
                    <h2 class="fw-bold text-info">{{ $totalFish }}</h2>
                    <a href="{{ route('admin.fish.index') }}" class="btn btn-sm btn-outline-info mt-2 rounded-pill">Kelola Ikan</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm p-3 bg-gradient bg-light">
                <div class="card-body text-center">
                    <h6 class="text-secondary">Pengguna Terdaftar</h6>
                    <h2 class="fw-bold text-warning">{{ $totalUsers }}</h2>
                    <a href="{{ route('admin.users') }}" class="btn btn-sm btn-outline-warning mt-2 rounded-pill">Lihat User</a>
                </div>
            </div>
        </div>
    </div>

    {{-- Grafik --}}
    <div class="row g-4 mb-4">
        {{-- Chart Pesanan per Status --}}
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-primary text-white fw-semibold">
                    <i class="bi bi-clipboard-data me-1"></i> Statistik Pesanan
                </div>
                <div class="card-body">
                    <canvas id="orderChart" height="180"></canvas>
                </div>
            </div>
        </div>

        {{-- Chart Jumlah Ikan per Jenis --}}
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-info text-white fw-semibold">
                    <i class="bi bi-bar-chart me-1"></i> Jumlah Ikan per Jenis
                </div>
                <div class="card-body">
                    <canvas id="fishChart" height="180"></canvas>
                </div>
            </div>
        </div>
    </div>

    {{-- Tabel Pesanan --}}
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-gradient bg-primary text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="bi bi-list-task me-1"></i> Daftar Pesanan Terbaru</h5>
            <a href="{{ route('admin.orders.index') }}" class="btn btn-light btn-sm rounded-pill">Lihat Semua</a>
        </div>
        <div class="card-body p-0">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Pemesan</th>
                        <th>Ikan</th>
                        <th>Jumlah</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($latestOrders as $index => $order)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $order->user->name ?? '-' }}</td>
                            <td>{{ $order->bettaFish->name ?? '-' }}</td>
                            <td>{{ $order->quantity }}</td>
                            <td>{{ $order->created_at->format('Y-m-d') }}</td>
                            <td>
                                @php
                                    $color = match($order->status) {
                                        'pending' => 'secondary',
                                        'diproses' => 'warning text-dark',
                                        'selesai' => 'success',
                                        'dibatalkan' => 'danger',
                                        default => 'light'
                                    };
                                @endphp
                                <span class="badge bg-{{ $color }} px-3 py-2 rounded-pill">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('admin.orders.edit', $order->id) }}" class="btn btn-sm btn-outline-primary rounded-pill">
                                    <i class="bi bi-pencil"></i>Edit
                                </a>
                                <form action="{{ route('admin.orders.destroy', $order->id) }}" method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill"
                                        onclick="return confirm('Yakin hapus pesanan ini?')">
                                        <i class="bi bi-trash"></i> Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="text-center text-muted py-3">Belum ada pesanan</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

{{-- Chart.js --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener("DOMContentLoaded", () => {
    // Pesanan Chart
    const orderCtx = document.getElementById('orderChart');
    new Chart(orderCtx, {
        type: 'doughnut',
        data: {
            labels: ['Pending', 'Diproses', 'Selesai', 'Dibatalkan'],
            datasets: [{
                data: [
                    {{ $statusCount['pending'] ?? 0 }},
                    {{ $statusCount['diproses'] ?? 0 }},
                    {{ $statusCount['selesai'] ?? 0 }},
                    {{ $statusCount['dibatalkan'] ?? 0 }},
                ],
                backgroundColor: ['#6c757d', '#ffc107', '#28a745', '#dc3545'],
                borderWidth: 1,
                hoverOffset: 8
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { position: 'bottom' } }
        }
    });

    // Ikan Chart
    const fishCtx = document.getElementById('fishChart');
    new Chart(fishCtx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($fishNames) !!},
            datasets: [{
                label: 'Stok Ikan',
                data: {!! json_encode($fishStock) !!},
                backgroundColor: '#17a2b8'
            }]
        },
        options: {
            scales: { y: { beginAtZero: true } },
            plugins: { legend: { display: false } }
        }
    });
});
</script>
@endsection
