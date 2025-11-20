@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
  <div class="col-md-5">
    <div class="card shadow-sm border-0">
      <div class="card-body">
        <h4 class="text-center mb-4">Masuk ke Akun</h4>

        <form method="POST" action="{{ route('login') }}">
          @csrf
          <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input id="email" type="email" name="email" class="form-control" required autofocus>
          </div>

          <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input id="password" type="password" name="password" class="form-control" required>
          </div>

          <div class="d-grid">
            <button type="submit" class="btn btn-primary">Masuk</button>
          </div>

          <div class="text-center mt-3">
            <small>Belum punya akun? <a href="{{ route('register') }}">Daftar</a></small>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
