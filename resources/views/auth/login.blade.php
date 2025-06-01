@extends('layout.auth')

@section('content')

<div class="container mb-5">
    <div class="text-right py-5">
        <span class="text-primary mr-2">belum punya akun? yuk, daftar jadi anggota</span> <a href="{{ route('register') }}" class="btn btn-primary">Sign Up</a>
    </div>
    <div class="d-flex align-items-center" style="min-height: 70vh">
        <div class="row w-100">
            <div class="col-md-6 text-center">
                <img src="{{ asset('assets/img/maskot mirror 1.png') }}" alt="" width="300px" class="ml-auto">
            </div>
            <div class="col-md-5 ml-auto">
                <div class="card border-0">
                    <div class="card-body">
    
                        <div class="mb-5">
                            <h3 class="text-center">Hello, Kopmania</h3>
                            <h6 class="text-center">Selamat Datang di Aciko </h6>
                        </div>
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif
    
                        @if ($errors->has('error'))
                            <div class="alert alert-danger">
                                {{ $errors->first('error') }}
                            </div>
                        @endif
    
                        <form action="" method="post">
                            @csrf
                            <div class="form-group">
                                <label for="" class="fw-bold">Email / no hp</label>
                                <input type="text" name="username" class="form-control border-primary rounded-3" placeholder="Masukkan email / no hp" value="{{ old('username') }}"> 
                                @error('username')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group input-password">
                                <label for="" class="fw-bold">Password</label>
                                <input type="password" name="password" class="form-control border-primary rounded-3" placeholder="Masukkan password" autocomplete="new-password"> 
                                @error('password')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                 <button class="btn btn-block w-100 rounded-pill btn-primary">
                                    Login
                                 </button>
                            </div>
                        </form>
                        {{-- <div class="text-center">
                            <p>Lupa Password? <a href="" data-toggle="modal" data-target="#ModalForgot" class="text-info">klik disini</a></p>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<div class="modal fade" id="ModalForgot" tabindex="-1" aria-labelledby="ModalForgotLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content rounded-3 text-dark">
        <div class="modal-body p-5">
            <small>Masukan email yang terdaftar untuk bisa atur ulang kata sandi.</small>
            <div class="mb-3">
                <label for="" class="fw-bold">Email Kamu</label>
                <input type="email" name="email" class="form-control border-primary rounded-3" placeholder="Masukkan email disini" autocomplete="new-password"> 
            </div>
            <button class="btn btn-block w-100 rounded-pill btn-primary">
                Kirim
             </button>
        </div>
        <div class="text-center">
            <p>Ingat password? <a href="{{ route('login') }}" class="text-info">Masuk disini</a></p>
        </div>
      </div>
    </div>
  </div>
@endsection