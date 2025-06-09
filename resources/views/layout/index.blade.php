@php

    use App\Models\Keranjang;

    $jumlah_keranjang = 0;

    if(auth()->user())
    {
        $jumlah_keranjang = Keranjang::where(['user_id' => auth()->id()])->count();
    }

@endphp

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>{{ env('APP_NAME') }}</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Free HTML Templates" name="keywords">
    <meta content="Free HTML Templates" name="description">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@200;300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="{{ asset('') }}assets/lib/animate/animate.min.css" rel="stylesheet">
    <link href="{{ asset('') }}assets/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

    <link rel="stylesheet" href="//cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{ asset('') }}assets/css/style.css" rel="stylesheet">
</head>

@hasSection('theme-white')
<body class="bg-white">
@else
<body>
@endif
    <!-- Topbar Start -->
    {{-- <div class="container-fluid">
        <div class="row align-items-center bg-tersier py-3 px-xl-5 d-none d-lg-flex">
            <div class="col-lg-2 col-6 text-right ml-auto">
                @auth
                <div class="dropdown">
                    <div class="user-profile" data-toggle="dropdown" aria-expanded="false">
                        <div class="profile-img">
                            <img src="{{ asset('assets/img/default.png') }}" alt="">
                        </div>
                        <span class="ml-2">
                            {{ auth()->user()->nama }}
                            @if (auth()->user()->member == '1')
                                <br>
                                <b>Poin: {{ auth()->user()->member_poin }}</b>
                            @endif
                        </span>
                    </div>
                    <ul class="dropdown-menu">
                        @if (auth()->user()->role == '1')
                        <li><a class="dropdown-item" href="{{ route('admin.transaksi.index') }}">Dashboard</a></li>
                        <li><a class="dropdown-item" href="{{ route('admin.transaksi.index') }}">Transaksi</a></li>
                        @elseif(auth()->user()->role == '2')
                        <li><a class="dropdown-item" href="{{ route('user.transaksi.index') }}">Transaksi</a></li>
                        <li><a class="dropdown-item" href="{{ route('user.alamat-pengiriman.index') }}">Alamat Pengiriman</a></li>
                        @endif
                        <li><a class="dropdown-item" href="{{ route('logout') }}">Keluar</a></li>
                    </ul>
                </div>
                @endauth
                @guest
                    <a href="{{ route('register') }}" class="btn btn-success mr-3">Daftar</a>
                    <a href="{{ route('login') }}" class="btn btn-outline-info">Masuk</a>
                @endguest
            </div>
        </div>
    </div> --}}
    <!-- Topbar End -->


    <!-- Navbar Start -->
    {{-- <div class="container-fluid bg-premier mb-30">
        <div class="row px-xl-5">
            <div class="col-lg-12">
                <nav class="navbar navbar-expand-lg navbar-dark py-3 py-lg-0 px-0">
                    <button type="button" class="navbar-toggler" id="btn-toggle-sidebar">
                        <i class="fas fa-th"></i>
                    </button>
                    <a href="{{ route('home') }}" class="text-decoration-none d-block d-lg-none">
                        <span class="h1 text-uppercase text-white bg-success px-2">E-</span>
                        <span class="h1 text-uppercase text-success bg-white px-2 ml-n1">COMMERCE</span>
                    </a>
                    <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
                        <div class="navbar-nav mr-auto py-0">
                            <a href="{{ route('home') }}" class="nav-item nav-link active">Beranda</a>
                            @auth
                            @if (auth()->user()->role == '1')
                            <a href="{{ route('admin.transaksi.index') }}" class="nav-item nav-link block d-md-none">Dashbaord</a>
                            <a href="{{ route('admin.transaksi.index') }}" class="nav-item nav-link block d-md-none">Transaksi</a>
                            @elseif(auth()->user()->role == '2')
                            <a href="{{ route('user.transaksi.index') }}" class="nav-item nav-link block d-md-none">Transaksi</a>
                            <a href="{{ route('user.alamat-pengiriman.index') }}" class="nav-item nav-link block d-md-none">Alamat Pengiriman</a>
                            @endif
                            <a href="{{ route('logout') }}" class="nav-item nav-link block d-md-none">Keluar</a>
                            @endauth

                        </div>
                        <div class="navbar-nav ml-auto py-0 d-none d-lg-block">
                            @auth
                                @if (auth()->user()->role == '2')
                                <a href="{{ route('user.keranjang.index') }}" class="btn px-0 ml-3">
                                    <i class="fas fa-shopping-cart text-primary"></i>
                                    <span class="badge text-secondary border border-secondary rounded-circle" style="padding-bottom: 2px;">{{ $jumlah_keranjang }}</span>
                                </a>
                                @endif
                            @endauth
                        </div>
                    </div>
                </nav>
            </div>
        </div>
    </div> --}}
    <!-- Navbar End -->

    @include('layout.navbar')

    <div style="min-height: 75vh;">
        @yield('content')
    </div>

    <!-- Footer Start -->
    <footer  class="text-primary py-4" style="background-color: #D1FFA3" >
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-4">
                            <h4 class="text-primary">Lokasi :</h4>
                            <p> 
                                Jl. Cik Di Tiro No.14, Terban, Kec. Gondokusuman, Kota Yogyakarta, Daerah Istimewa Yogyakarta 55223
                            </p>
                        </div>
                        <div class="col-md-8">
                            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3953.09020344319!2d110.3755899!3d-7.780260199999999!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e7a584a64a8c80d%3A0x8a3e45ee1d989b96!2sKoperasi%20Mahasiswa%20KOPMA%20UGM!5e0!3m2!1sid!2sid!4v1749084941927!5m2!1sid!2sid" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 ml-auto">
                    <h3 class="text-primary text-center mb-3">Follow us</h3>
                    <div class="row mb-3">
                        <div class="col-3">
                            <i class="fab fa-instagram fa-3x text-primary"></i>
                        </div>
                        <div class="col-3">
                            <i class="fab fa-facebook fa-3x text-primary"></i>
                        </div>
                        <div class="col-3">
                            <i class="fab fa-twitter fa-3x text-primary"></i>
                        </div>
                        <div class="col-3">
                            <i class="fab fa-linkedin fa-3x text-primary"></i>
                        </div>
                    </div>
                    <span><i class="fa fa-copyright fa-1x"></i> Koperasi KOPMA </span>
                </div>
            </div>
        </div>
    </footer>
    <!-- Footer End -->


    <!-- Back to Top -->
    <a href="#" class="btn btn-primary back-to-top"><i class="fa fa-angle-double-up"></i></a>


    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('') }}assets/lib/easing/easing.min.js"></script>
    <script src="{{ asset('') }}assets/lib/owlcarousel/owl.carousel.min.js"></script>

    <script src="//cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>

    <!-- Template Javascript -->
    <script src="{{ asset('') }}assets/js/main.js"></script>

    @stack('js')
</body>

</html>
