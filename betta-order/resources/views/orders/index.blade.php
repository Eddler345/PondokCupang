@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold mb-0 text-primary">📦 Kelola Pesanan</h2>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary rounded-pill">
                <i class="bi bi-arrow-left me-1"></i> Kembali ke Dashboard
            </a>
        </div>
    </div>

    <table class="table table-hover shadow-sm align-middle">
        <thead class="table-primary text-center">
            <tr>
                <th>No</th>
                <th>Pemesan</th>
                <th>Ikan</th>
                <th>Jumlah</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody class="text-center">
            @foreach ($orders as $index => $order)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $order->user->name ?? 'User tidak ditemukan' }}</td>
                    <td>{{ $order->bettaFish->name ?? 'Tidak ditemukan' }}</td>
                    <td>{{ $order->quantity }}</td>
                    <td>
                        @php
                            $statusClass = match($order->status) {
                                'pending' => 'bg-secondary text-white',
                                'diproses' => 'bg-warning text-dark',
                                'selesai' => 'bg-success text-white',
                                'dibatalkan' => 'bg-danger text-white',
                                default => 'bg-light text-dark'
                            };
                        @endphp
                        <span class="badge px-3 py-2 {{ $statusClass }}">
                            {{ ucfirst($order->status) }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('admin.orders.edit', $order->id) }}" class="btn btn-sm btn-info">
                            <i class="bi bi-pencil-square"></i> Edit
                        </a>
                        <form action="{{ route('admin.orders.destroy', $order->id) }}" method="POST" class="d-inline">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('Hapus pesanan ini?')">
                                <i class="bi bi-trash"></i> Hapus
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
