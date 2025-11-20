@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2>Tambah Ikan</h2>

    <form action="{{ route('admin.fish.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label>Nama Ikan</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Jenis</label>
            <input type="text" name="type" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Harga</label>
            <input type="number" name="price" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Stok</label>
            <input type="number" name="stock" class="form-control" value="0" min="0" required>
        </div>
        <div class="mb-3">
            <label>Gambar (opsional)</label>
            <input type="file" name="image" id="imageInput" class="form-control">
            <div class="mt-2">
                <img id="imagePreview" src="#" alt="Preview" style="max-width:200px; display:none;" />
            </div>
        </div>
        <div class="mb-3">
            <label>Deskripsi (opsional)</label>
            <textarea name="description" class="form-control" rows="3"></textarea>
        </div>
        <button class="btn btn-success">Simpan</button>
        <a href="{{ route('admin.fish.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const input = document.getElementById('imageInput');
    const preview = document.getElementById('imagePreview');
    input.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (!file) return;
        const reader = new FileReader();
        reader.onload = function(ev) {
            preview.src = ev.target.result;
            preview.style.display = 'block';
        }
        reader.readAsDataURL(file);
    });
});
</script>
@endpush
