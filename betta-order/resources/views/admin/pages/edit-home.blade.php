@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2>Edit Halaman Beranda</h2>

    <form action="{{ route('admin.pages.home.update') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>Judul</label>
            <input type="text" name="title" value="{{ $page->title ?? '' }}" class="form-control">
        </div>
        <div class="mb-3">
            <label>Konten</label>
            <textarea name="content" class="form-control" rows="6">{{ $page->content ?? '' }}</textarea>
        </div>
        <div class="d-flex gap-2">
            <button class="btn btn-primary">Simpan</button>
            <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </form>
</div>
@endsection