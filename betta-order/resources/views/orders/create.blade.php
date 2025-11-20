@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-dark mb-0">🛒 Buat Pesanan Baru</h2>
            <p class="text-muted mb-0">Silakan pilih ikan cupang yang Anda inginkan</p>
        </div>
        <a href="{{ route('user.dashboard') }}" class="btn btn-outline-primary rounded-pill px-4">
            <i class="bi bi-arrow-left me-1"></i> Kembali
        </a>
    </div>

    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    @if ($errors->any())
                        <div class="alert alert-danger mb-4">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('user.orders.store') }}" method="POST">
                        @csrf
                        
                        {{-- Pilih Ikan --}}
                        <div class="mb-4">
                            <label for="betta_fish_id" class="form-label fw-semibold">Pilih Ikan Cupang</label>
                            <select name="betta_fish_id" id="betta_fish_id" 
                                   class="form-select @error('betta_fish_id') is-invalid @enderror" required>
                                <option value="">-- Pilih Ikan --</option>
                                @foreach($fishes as $fish)
                                    <option value="{{ $fish->id }}" 
                                            data-price="{{ $fish->price }}"
                                            data-stock="{{ $fish->stock }}">
                                        {{ $fish->name }} - Rp {{ number_format($fish->price, 0, ',', '.') }}
                                        (Stok: {{ $fish->stock }})
                                    </option>
                                @endforeach
                            </select>
                            @error('betta_fish_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Jumlah --}}
                        <div class="mb-4">
                            <label for="quantity" class="form-label fw-semibold">Jumlah</label>
                            <input type="number" name="quantity" id="quantity" 
                                   class="form-control @error('quantity') is-invalid @enderror"
                                   min="1" value="1" required>
                            @error('quantity')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted" id="stockInfo"></small>
                        </div>

                        {{-- Preview Total --}}
                        <div class="mb-4 p-3 bg-light rounded">
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="fw-semibold">Total Harga:</span>
                                <span class="h4 mb-0 fw-bold" id="totalPrice">Rp 0</span>
                            </div>
                        </div>

                        {{-- Tombol Submit --}}
                        <div class="d-flex gap-2">
                            <a href="{{ route('user.orders.index') }}" class="btn btn-outline-secondary rounded-pill px-4 align-self-start">
                                <i class="bi bi-arrow-left me-1"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-primary btn-lg rounded-pill">
                                <i class="bi bi-cart-check me-2"></i>
                                Buat Pesanan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Script untuk menghitung total --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    const fishSelect = document.getElementById('betta_fish_id');
    const quantityInput = document.getElementById('quantity');
    const totalPriceElement = document.getElementById('totalPrice');
    const stockInfoElement = document.getElementById('stockInfo');

    function updateTotal() {
        const selectedOption = fishSelect.options[fishSelect.selectedIndex];
        if (selectedOption.value) {
            const price = parseInt(selectedOption.dataset.price);
            const stock = parseInt(selectedOption.dataset.stock);
            const quantity = parseInt(quantityInput.value);
            
            // Update max quantity based on stock
            quantityInput.max = stock;
            stockInfoElement.textContent = `Stok tersedia: ${stock}`;
            
            if (quantity > stock) {
                quantityInput.value = stock;
            }
            
            const total = price * quantity;
            totalPriceElement.textContent = `Rp ${total.toLocaleString('id-ID')}`;
        } else {
            totalPriceElement.textContent = 'Rp 0';
            stockInfoElement.textContent = '';
        }
    }

    fishSelect.addEventListener('change', updateTotal);
    quantityInput.addEventListener('input', updateTotal);
});
</script>
@endsection
