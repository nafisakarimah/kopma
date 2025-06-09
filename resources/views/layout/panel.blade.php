
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

<body class="bg-white">

    <div class="panel-wrapper">

        @include('layout.sidebar')

        <div class="panel-content-wrapper">
            @include('layout.panel-navbar')
            @yield('content')
                    <!-- Footer Start -->
            <div class="text-primary py-4 mx-n3 mb-n3 mt-5" style="background-color: #D1FFA3">
                <div class="container">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-4">
                                    <h4 class="text-primary">Lokasi :</h4>
                                    <p>Jl. Cik Di Tiro No.14, Terban, Kec. Gondokusuman, Kota Yogyakarta, Daerah Istimewa Yogyakarta 55223</p>
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
            </div>
            <!-- Footer End -->
        </div>

    </div>

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
