@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">🛒 Buat Pesanan Baru</h4>
                    <p class="mb-0 small">Silakan pilih ikan cupang yang Anda inginkan</p>
                </div>

                <div class="card-body">
                    <form action="{{ route('orders.store') }}" method="POST">
                        @csrf
                        
                        {{-- Pilih Ikan --}}
                        <div class="mb-4">
                            <label for="betta_fish_id" class="form-label fw-bold">Pilih Ikan Cupang</label>
                            <select name="betta_fish_id" id="betta_fish_id" class="form-select" required>
                                <option value="">-- Pilih Ikan --</option>
                                @foreach($fishes as $fish)
                                    <option value="{{ $fish->id }}" 
                                        data-price="{{ $fish->price }}"
                                        {{ old('betta_fish_id') == $fish->id ? 'selected' : '' }}>
                                        {{ $fish->name }} - Rp {{ number_format($fish->price, 0, ',', '.') }}
                                        (Stok: {{ $fish->stock }})
                                    </option>
                                @endforeach
                            </select>
                            @error('betta_fish_id')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Jumlah --}}
                        <div class="mb-4">
                            <label for="quantity" class="form-label fw-bold">Jumlah</label>
                            <input type="number" name="quantity" id="quantity" class="form-control" 
                                value="{{ old('quantity', 1) }}" min="1" required>
                            @error('quantity')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Total Harga --}}
                        <div class="mb-4">
                            <label class="form-label fw-bold">Total Harga:</label>
                            <div class="h4" id="totalPrice">Rp 0</div>
                        </div>

                        {{-- Tombol --}}
                        <div class="d-flex gap-2">
                            <a href="{{ route('orders.index') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-cart-plus"></i> Buat Pesanan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Get elements
    var selectElement = document.getElementById('betta_fish_id');
    var quantityElement = document.getElementById('quantity');
    var totalPriceElement = document.getElementById('totalPrice');

    // Function to format price to Rupiah
    function formatRupiah(number) {
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0,
            maximumFractionDigits: 0
        }).format(number);
    }

    // Function to calculate and update total price
    function calculateTotal() {
        var selectedOption = selectElement.options[selectElement.selectedIndex];
        var price = selectedOption ? parseInt(selectedOption.getAttribute('data-price')) || 0 : 0;
        var quantity = parseInt(quantityElement.value) || 0;
        var total = price * quantity;
        totalPriceElement.textContent = formatRupiah(total);
    }

    // Add event listeners
    selectElement.addEventListener('change', calculateTotal);
    quantityElement.addEventListener('input', calculateTotal);

    // Calculate initial total
    calculateTotal();
});
</script>
@endpush
@endsection