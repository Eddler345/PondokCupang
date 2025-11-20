@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2>Edit Ikan</h2>

    <form action="{{ route('admin.fish.update', $fish->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label>Nama Ikan</label>
            <input type="text" name="name" value="{{ $fish->name }}" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Jenis</label>
            <input type="text" name="type" value="{{ $fish->type }}" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Harga</label>
            <input type="number" name="price" value="{{ $fish->price }}" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Stok</label>
            <input type="number" name="stock" value="{{ $fish->stock }}" class="form-control" min="0" required>
        </div>
        <div class="mb-3">
            <label>Gambar Saat Ini</label>
            @if($fish->image)
                <div class="mb-2">
                    <img src="{{ asset('storage/'.$fish->image) }}" alt="{{ $fish->name }}" style="max-width: 200px;">
                </div>
                <div class="mb-3">
                    <button type="button" onclick="document.getElementById('deleteImageForm').submit();" class="btn btn-sm btn-outline-danger">Hapus Gambar</button>
                </div>
            @else
                <div class="text-muted mb-2">Tidak ada gambar</div>
            @endif
            <label>Ganti Gambar (opsional)</label>
            <input type="file" name="image" id="imageInput" class="form-control">
            <div class="mt-2">
                <img id="imagePreview" src="#" alt="Preview" style="max-width:200px; display:none;" />
            </div>
        </div>
        <div class="mb-3">
            <label>Deskripsi (opsional)</label>
            <textarea name="description" class="form-control" rows="3">{{ $fish->description }}</textarea>
        </div>
        <div class="d-flex gap-2">
            <button class="btn btn-primary">Update</button>
            <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </form>

    {{-- Form untuk menghapus gambar --}}
    <form id="deleteImageForm" action="{{ route('admin.fish.deleteImage', $fish->id) }}" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>
</div>

{{-- Tampilkan pesan error jika ada --}}
@if($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const input = document.getElementById('imageInput');
    const preview = document.getElementById('imagePreview');
    input && input.addEventListener('change', function(e) {
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
