@extends('layout.panel')
@section('content')

<h5>Profil Saya</h5>

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

<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="d-flex align-items-center mb-3 justify-content-center">
                <div class="foto-profil mx-4 border">
                    <img src="{{ url($data->foto? 'uploads/'.$data->foto : 'assets/img/fotoguest.png') }}" alt="" id="image-viewer-target">
                </div>
                @if ($data->member == '1' && $data->role == '2')
                <div class="border-2 border-primary py-2 px-4 rounded">
                    {{ $data->member_poin? $data->member_poin : 0 }} Point
                </div>
                @endif
            </div>
            <div class="col-md-6 mb-3 mx-auto">
                <form action="{{ route('user.update_foto') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <div class="custom-file">
                            <input type="file" name="foto" accept=".jpg,.png" class="custom-file-input upload-viewer" data-target="#image-viewer-target">
                            <label class="custom-file-label" for="fotoku">Choose file</label>
                        </div>
                        @error('foto')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="text-right">
                        <button class="btn btn-primary">Ubah Foto</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-md-8 mx-auto mb-3">
            <form action="" method="post">
                @csrf
                @method('put')
                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="" class="fw-bold">Nama</label>
                                    <input type="text" value="{{ $data->nama }}" name="nama" class="form-control border-2 rounded-3 border-primary" placeholder="Masukkan Nama Lengkap"> 
                                    @error('nama')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            @if ($data->member == '1')
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="" class="fw-bold">NAK</label>
                                    <input type="text" value="{{ $data->nak }}" name="nak" class="form-control border-2 rounded-3 border-primary" placeholder="Masukkan Email"> 
                                    @error('nak')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="" class="fw-bold">No Hp</label>
                            <input type="text" value="{{ $data->no_telp }}" name="no_telp" class="form-control border-2 rounded-3 border-primary" placeholder="Masukkan No Hp"> 
                            @error('no_telp')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="" class="fw-bold">Email</label>
                            <input type="email" value="{{ $data->email }}" name="email" class="form-control border-2 rounded-3 border-primary" placeholder="Masukkan Email" disabled> 
                            @error('email')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group input-password">
                            <label for="" class="fw-bold">Password</label>
                            <input type="password" name="password" class="form-control border-2 rounded-3 border-primary" placeholder="Masukkan password" autocomplete="new-password"> 
                            @error('password')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="" class="fw-bold">Alamat</label>
                            <textarea value="{{ $data->alamat }}" name="alamat" rows="2" class="form-control border-2 rounded-3 border-primary" placeholder="Masukkan alamat lengkap">{{ $data->alamat }}</textarea>
                            @error('alamat')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="text-left">
                    <button class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
        @if ($data->member == '0')
        <div class="col-md-8 mx-auto">
            <p class="text-dark"><b>Member kopma? Daftarkan NAK untuk dapat poin belanja</b></p>
            <form action="{{ route('user.profil.update-nak') }}" method="post">
                @csrf
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <div class="form-group mb-0">
                            <input type="text" value="{{ $data->nak }}" name="nak" class="form-control border-2 rounded-3 border-primary" placeholder="Masukkan NAK"> 
                            @error('nak')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <button class="btn btn-primary">Kirim NAK</button>
                    </div>
                </div>
            </form>
        </div>
        @endif
    </div>
    
</div>

@endsection