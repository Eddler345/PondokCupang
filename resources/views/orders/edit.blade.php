@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">✏️ Edit Pesanan</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.orders.update', $order->id) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- Pilih Ikan --}}
                <div class="mb-3">
                    <label for="betta_fish_id" class="form-label fw-semibold">Pilih Ikan</label>
                    <select name="betta_fish_id" id="betta_fish_id" class="form-select" required>
                        @foreach ($fish as $item)
                            <option value="{{ $item->id }}" 
                                {{ $item->id == $order->betta_fish_id ? 'selected' : '' }}>
                                {{ $item->name }} - Rp {{ number_format($item->price, 0, ',', '.') }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Jumlah --}}
                <div class="mb-3">
                    <label for="quantity" class="form-label fw-semibold">Jumlah</label>
                    <input type="number" name="quantity" id="quantity" 
                        class="form-control" min="1" value="{{ $order->quantity }}" required>
                </div>

                {{-- Status --}}
                <div class="mb-3">
                    <label for="status" class="form-label fw-semibold">Status</label>
                    <select name="status" id="status" class="form-select" required>
                        <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="diproses" {{ $order->status == 'diproses' ? 'selected' : '' }}>Diproses</option>
                        <option value="selesai" {{ $order->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                        <option value="dibatalkan" {{ $order->status == 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                    </select>
                </div>

                {{-- Tombol --}}
                <div class="d-flex justify-content-between">
                    <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary px-4">Kembali</a>
                    <button type="submit" class="btn btn-success px-4">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
