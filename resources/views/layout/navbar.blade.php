
<nav class="navbar navbar-expand-md">
    <div class="container">
        @hasSection('theme-white')
        <a href="{{ route('home') }}" class="navbar-brand">
            <img src="{{ asset('assets/img/aciko.png') }}" alt="" width="50px"> <span class="fw-bold ml-2">Aciko</span>
        </a>
        @else
        <button class="navbar-toggler text-primary" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <i class="fa fa-bars fs-2x"></i>
        </button>
        <div class="collapse navbar-collapse order-2 order-md-1" id="navbarNav">
            <ul class="nav-menu">
                <li class="nav-menu-item">
                    <a href="{{ route('home') }}">Home</a>
                </li>
                <li class="nav-menu-item">
                    <a href="{{ route('kategori.detail','swalayan') }}">Belanja</a>
                </li>
                <li class="nav-menu-item">
                    <a href="{{ route('guskom') }}">Guskom</a>
                </li>
                <li class="nav-menu-item">
                    <a href="{{ route('feedback') }}">Feedback</a>
                </li>
                <li class="nav-menu-item">
                    <a href="{{ route('faq') }}">Faq</a>
                </li>
            </ul>
        </div>
        @endif
        <div class="ml-auto order-1 order-md-2">
            @guest
            <a href="{{ route('register') }}" class="btn btn-primary bnt-sm mr-2 py-1 px-4">Daftar</a>
            <a href="{{ route('login') }}" class="btn btn-primary bnt-sm py-1 px-4">Login</a>
            @endguest
            @auth
            <div class="dropdown d-inline-block">
                <a href="" class="nav-link dropdown-toggle" data-toggle="dropdown" aria-expanded="false" style="outline: none">
                    <span class="mr-2">Hi, {{ auth()->user()->nama }}</span> <i class="fa fa-user-circle"></i>
                </a>
                <div class="dropdown-menu bg-secondary">
                    @if (auth()->user()->role == '1')
                    <a class="dropdown-item" href="{{ route('admin.transaksi.index') }}">Dashboard</a>
                    {{-- <a class="dropdown-item" href="{{ route('admin.transaksi.index') }}">Transaksi</a> --}}
                    @elseif(auth()->user()->role == '2')
                    <a class="dropdown-item" href="{{ route('user.profil.index') }}">Profil</a>
                    <a class="dropdown-item" href="{{ route('user.transaksi.index') }}">Transaksi</a>
                    <a class="dropdown-item" href="{{ route('user.alamat-pengiriman.index') }}">Alamat Pengiriman</a>
                    @endif
                    <a class="dropdown-item" href="{{ route('logout') }}">Keluar</a>
                </div>
            </div>
            <a href="{{ route('user.keranjang.index') }}"><i class="fa fa-shopping-cart"></i></a>
            @endauth
        </div>
    </div>
</nav>
