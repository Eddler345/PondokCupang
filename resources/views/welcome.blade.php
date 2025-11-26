<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">
            <img src="{{ asset('storage/logo-cupang.png') }}" alt="Pondok Cupang Bengkulu" style="height: 30px;">
            Pondok Cupang Bengkulu
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#contactMenu" aria-controls="contactMenu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-end" id="contactMenu">
            <ul class="navbar-nav gap-2 align-items-center">
                
                <li class="nav-item">
                    <a href="http://wa.me/+6285379254149" target="_blank" class="nav-link p-0" title="Hubungi via WhatsApp">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/6/6b/WhatsApp.svg" alt="WhatsApp" style="width: 30px; height: 30px;">
                    </a>
                </li>
                
                <li class="nav-item">
                    <a href="https://www.instagram.com/pondok_cupang_bengkulu?igsh=MTd6YjB0enZtcWwzeA==" target="_blank" class="nav-link p-0" title="Kunjungi Instagram">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/9/95/Instagram_logo_2022.svg" alt="Instagram" style="width: 30px; height: 30px;">
                    </a>
                </li>
                
                {{-- Tombol Login dan Daftar (Selalu tampil di sini, disembunyikan/dimunculkan oleh hamburger) --}}
                @if (Route::has('login'))
                    @auth
                        <li class="nav-item">
                            <a href="{{ url('/dashboard') }}" class="btn btn-outline-primary ms-3 px-3">Dashboard</a>
                        </li>
                    @else
                        <li class="nav-item">
                            <a href="{{ route('login') }}" class="btn btn-outline-primary ms-3 me-2 px-3">Masuk</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('register') }}" class="btn btn-primary px-3">Daftar</a>
                        </li>
                    @endauth
                @endif
            </ul>
        </div>
    </div>
</nav>
