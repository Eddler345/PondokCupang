@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h3>Data Ikan Cupang</h3>
    <a href="{{ route('bettafish.create') }}" class="btn btn-primary mb-3">Tambah Ikan</a>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Tipe</th>
                <th>Harga</th>
                <th>Stok</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($fish as $f)
            <tr>
                <td>{{ $f->name }}</td>
                <td>{{ $f->type }}</td>
                <td>Rp {{ number_format($f->price, 0, ',', '.') }}</td>
                <td>{{ $f->stock }}</td>
                <td>
                    <a href="{{ route('bettafish.edit',$f->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('bettafish.destroy',$f->id) }}" method="POST" class="d-inline">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
