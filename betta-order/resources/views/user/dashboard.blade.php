@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="d-flex align-items-center gap-3">
            <img src="{{ asset('img/logo.png') }}" alt="Logo" style="width:64px;height:64px;object-fit:cover;border-radius:8px;">
            <div>
                <h2 class="fw-bold text-dark mb-0">Dashboard Pelanggan</h2>
                <p class="text-muted mb-0">Selamat datang, {{ Auth::user()->name }}!</p>
            </div>
        </div>
        <div class="d-flex gap-2">
            <a href="/" class="btn btn-outline-primary rounded-pill px-4">
                <i class="bi bi-house-door me-1"></i> Home
            </a>
            <a href="{{ route('orders.index') }}" class="btn btn-info rounded-pill px-4">
                <i class="bi bi-list-check me-1"></i> Lihat Pesanan
            </a>
            <a href="{{ route('orders.create') }}" class="btn btn-primary rounded-pill px-4">
                <i class="bi bi-plus-circle me-1"></i> Pesan Ikan
            </a>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-outline-danger rounded-pill px-4">
                    <i class="bi bi-box-arrow-right me-1"></i> Logout
                </button>
            </form>
        </div>
    </div>

    {{-- Statistik User --}}
    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center p-4">
                    <div class="display-6 fw-bold text-primary mb-2">{{ $orderCount }}</div>
                    <div class="text-muted">Total Pesanan</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center p-4">
                    <div class="display-6 fw-bold text-warning mb-2">{{ $statusCount['pending'] }}</div>
                    <div class="text-muted">Menunggu</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center p-4">
                    <div class="display-6 fw-bold text-info mb-2">{{ $statusCount['diproses'] }}</div>
                    <div class="text-muted">Diproses</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center p-4">
                    <div class="display-6 fw-bold text-success mb-2">{{ $statusCount['selesai'] }}</div>
                    <div class="text-muted">Selesai</div>
                </div>
            </div>
        </div>
    </div>

    {{-- Grafik Status Pesanan --}}
    <div class="row g-4 mb-4">
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-pie-chart me-2"></i>
                        Statistik Pesanan Saya
                    </h5>
                </div>
                <div class="card-body">
                    <canvas id="orderChart" height="200"></canvas>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-info-circle me-2"></i>
                        Panduan Status
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="badge bg-warning text-dark me-2">Pending</div>
                        <div>Pesanan sudah dibuat dan menunggu konfirmasi admin</div>
                    </div>
                    <div class="d-flex align-items-center mb-3">
                        <div class="badge bg-info text-white me-2">Diproses</div>
                        <div>Pesanan sedang diproses oleh admin</div>
                    </div>
                    <div class="d-flex align-items-center mb-3">
                        <div class="badge bg-success me-2">Selesai</div>
                        <div>Pesanan telah selesai diproses</div>
                    </div>
                    <div class="d-flex align-items-center">
                        <div class="badge bg-danger me-2">Dibatalkan</div>
                        <div>Pesanan dibatalkan</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Tabel Pesanan --}}
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-0 py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="bi bi-clock-history me-2"></i>
                    Riwayat Pesanan
                </h5>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="px-4">No</th>
                            <th>Nama Ikan</th>
                            <th>Jumlah</th>
                            <th>Total Harga</th>
                            <th>Status</th>
                            <th>Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $index => $order)
                            <tr>
                                <td class="px-4">{{ $index + 1 }}</td>
                                <td>{{ $order->bettaFish->name }}</td>
                                <td>{{ $order->quantity }}</td>
                                <td>Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                                <td>
                                    @php
                                        $color = match($order->status) {
                                            'pending' => 'warning text-dark',
                                            'diproses' => 'info',
                                            'selesai' => 'success',
                                            'dibatalkan' => 'danger',
                                            default => 'secondary'
                                        };
                                    @endphp
                                    <span class="badge bg-{{ $color }} rounded-pill px-3">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </td>
                                <td>{{ $order->created_at->format('d M Y') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4">
                                    <img src="https://cdn-icons-png.flaticon.com/512/7486/7486744.png" alt="No Orders" style="width: 80px; opacity: 0.5" class="mb-3">
                                    <p class="text-muted mb-0">Belum ada pesanan</p>
                                    <a href="{{ route('orders.create') }}" class="btn btn-primary btn-sm rounded-pill mt-3">
                                        <i class="bi bi-plus-circle me-1"></i> Buat Pesanan Pertama
                                    </a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- Chart.js --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener("DOMContentLoaded", () => {
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
                backgroundColor: ['#ffc107', '#17a2b8', '#28a745', '#dc3545'],
                borderWidth: 0,
                hoverOffset: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 20,
                        usePointStyle: true,
                        pointStyle: 'circle'
                    }
                }
            }
        }
    });
});
</script>
@endsection