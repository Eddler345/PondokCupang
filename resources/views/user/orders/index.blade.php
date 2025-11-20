@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <div>
                <h4 class="mb-0">📋 Pesanan Saya</h4>
                <p class="mb-0 small">Daftar pesanan ikan cupang Anda</p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('user.dashboard') }}" class="btn btn-outline-light">
                    <i class="bi bi-arrow-left"></i> Kembali ke Dashboard
                </a>
                <a href="{{ route('orders.create') }}" class="btn btn-light">
                    <i class="bi bi-plus-circle"></i> Buat Pesanan Baru
                </a>
            </div>
        </div>

        <div class="card-body p-0">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show m-3" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if($orders->isEmpty())
                <div class="text-center py-5">
                    <img src="{{ asset('img/empty-order.png') }}" alt="Tidak ada pesanan" style="max-width: 200px; opacity: 0.5;">
                    <p class="text-muted mt-3">Anda belum memiliki pesanan.</p>
                    <a href="{{ route('orders.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-circle"></i> Buat Pesanan Pertama Anda
                    </a>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th>No</th>
                                <th>Ikan</th>
                                <th>Jumlah</th>
                                <th>Total Harga</th>
                                <th>Status</th>
                                <th>Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $index => $order)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>
                                        @if($order->bettaFish)
                                            <div class="d-flex align-items-center gap-2">
                                                @if($order->bettaFish->image)
                                                    <img src="{{ asset('storage/'.$order->bettaFish->image) }}" 
                                                        alt="{{ $order->bettaFish->name }}" 
                                                        class="rounded-circle"
                                                        style="width: 40px; height: 40px; object-fit: cover;">
                                                @endif
                                                <div>
                                                    <div class="fw-bold">{{ $order->bettaFish->name }}</div>
                                                    <div class="small text-muted">{{ $order->bettaFish->type }}</div>
                                                </div>
                                            </div>
                                        @else
                                            <span class="text-muted">Ikan tidak tersedia</span>
                                        @endif
                                    </td>
                                    <td>{{ $order->quantity }}</td>
                                    <td>Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                                    <td>
                                        @php
                                            $statusClass = match($order->status) {
                                                'pending' => 'bg-secondary',
                                                'diproses' => 'bg-warning text-dark',
                                                'selesai' => 'bg-success',
                                                'dibatalkan' => 'bg-danger',
                                                default => 'bg-light text-dark'
                                            };
                                        @endphp
                                        <span class="badge {{ $statusClass }} px-3 py-2">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <div>{{ $order->created_at->format('d M Y') }}</div>
                                        <div class="small text-muted">{{ $order->created_at->format('H:i') }}</div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection