@extends('layout.auth')

@section('content')

<div class="container mb-5">
    <div class="d-flex align-items-center" style="min-height: 90vh">
        <div class="row w-100">
            <div class="col-md-4 text-center">
                <img src="{{ asset('assets/img/maskot mirror 1.png') }}" alt="" width="300px" class="ml-auto mt-5">
            </div>
            <div class="col-md-6 ml-auto">
                <div class="tab-content" id="myTabContent">
                    <div class="card border-0">
                        <div class="card-body">
                            <div class="text-center mb-4">
                                <h3>Silahkan Register di Aciko </h3>
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
                            <form action="{{ route('register.send') }}" method="post">
                                @csrf
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="" class="fw-bold">Nama</label>
                                            <input type="text" value="{{ old('nama') }}" name="nama" class="form-control rounded-3 border-primary" placeholder="Masukkan Nama Lengkap"> 
                                            @error('nama')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="" class="fw-bold">No Hp</label>
                                            <input type="text" value="{{ old('no_telp') }}" name="no_telp" class="form-control rounded-3 border-primary" placeholder="Masukkan No Hp"> 
                                            @error('no_telp')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="" class="fw-bold">Email</label>
                                            <input type="email" value="{{ old('email') }}" name="email" class="form-control rounded-3 border-primary" placeholder="Masukkan Email"> 
                                            @error('email')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="" class="fw-bold">Alamat</label>
                                            <textarea value="{{ old('alamat') }}" name="alamat" rows="2" class="form-control rounded-3 border-primary" placeholder="Masukkan alamat lengkap">{{ old('alamat') }}</textarea>
                                            @error('alamat')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group input-password">
                                            <label for="" class="fw-bold">Password</label>
                                            <input type="password" name="password" class="form-control rounded-3 border-primary" placeholder="Masukkan password" autocomplete="new-password"> 
                                            @error('password')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group input-password">
                                            <label for="" class="fw-bold">Konfirmasi Password</label>
                                            <input type="password" name="password_confirmation" class="form-control rounded-3 border-primary" placeholder="Konfirmasi password" autocomplete="new-password"> 
                                            @error('password_confirmation')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <label class="form-check">
                                            <input class="form-check-input" type="checkbox" value="0" name="member">
                                            <span class="form-check-label">
                                                Member kopma?
                                            </span>
                                        </label>
                                    </div>
                                    <div class="col-md-12 d-none" id="input-nak">
                                        <div class="form-group">
                                            <label for="">NAK</label>
                                            <input type="text" value="{{ old('nak') }}" name="nak" class="form-control rounded-3 border-primary" placeholder="Masukkan NAK"> 
                                            @error('nak')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <button class="btn btn-primary w-100">
                                    Daftar
                                </button>
                            </form>
                            <div class="text-center mt-3">
                                <p>sudah punya akun? <a href="{{ route('login') }}" class="text-info">login disini</a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('js')
    <script>
        $(document).on('change', '[name="member"]', function(){
            $(this).val(this.checked? 1 : 0)
            if(this.checked)
            {
                $('#input-nak').removeClass('d-none')
            }else{
                $('#input-nak').addClass('d-none')
            }
        })
    </script>
@endpush