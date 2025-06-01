@extends('layout.panel')
@section('panel',true)

@section('content')

<h5>Tambah</h5>

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

<form action="{{ route('user.alamat-pengiriman.store') }}" method="post">
    @csrf
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="">Nama</label>
                <input type="text" name="nama" class="form-control" placeholder="Masukkan Nama" value="{{ old('nama') }}">
                @error('nama')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="form-group">
                <label for="">No Telp</label>
                <input type="text" name="no_telp" class="form-control" placeholder="Masukkan No Telp" value="{{ old('no_telp') }}">
                @error('no_telp')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="form-group">
                <label for="">Alamat</label>
                <textarea name="alamat" rows="2" class="form-control" placeholder="Masukkan Alamat">{{ old('alamat') }}</textarea>
                @error('alamat')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
        </div>        
    </div>
    <div class="text-right">
        <button class="btn btn-success">Simpan</button>
    </div>
    
</form>
@endsection