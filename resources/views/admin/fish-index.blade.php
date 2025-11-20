@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0 fw-bold text-primary">🐠 Daftar Ikan Cupang</h2>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary rounded-pill">
                <i class="bi bi-arrow-left me-1"></i> Kembali
            </a>
            <a href="{{ route('admin.fish.create') }}" class="btn btn-success mb-3 rounded-pill shadow-sm">
                <i class="bi bi-plus-circle"></i> Tambah Ikan
            </a>
        </div>
    </div>

    {{-- Pesan sukses --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-primary">
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Jenis</th>
                        <th>Harga</th>
                        <th>Stok</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($fish as $index => $f)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $f->name }}</td>
                            <td>{{ $f->type }}</td>
                            <td>Rp {{ number_format($f->price, 0, ',', '.') }}</td>
                            <td>
                                <span class="badge {{ $f->stock > 10 ? 'bg-success' : ($f->stock > 0 ? 'bg-warning text-dark' : 'bg-danger') }}">
                                    {{ $f->stock }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('admin.fish.edit', $f->id) }}" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                                    <i class="bi bi-pencil"></i> Edit
                                </a>
                                <form action="{{ route('admin.fish.destroy', $f->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger rounded-pill px-3"
                                            onclick="return confirm('Yakin ingin hapus ikan ini?')">
                                        <i class="bi bi-trash"></i> Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-3">Belum ada data ikan</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
