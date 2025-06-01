@extends('layout.panel')
@section('panel',true)

@section('content')

<h5 class="mb-3">Edit Guskom</h5>

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

<form action="{{ route('admin.guskom.update',$guskom->id) }}" method="post" enctype="multipart/form-data">
    @csrf
    @method('put')
    <div class="row">
        <div class="col-md-6">
            <div class="form-group mb-3">
                <label for="">Gambar</label>
                <small class="text-warning">Pilih gambar untuk mengubah</small>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <div class="img-thumbnail">
                            <img src="{{ url('uploads/'.$guskom->gambar) }}" alt="No Image" width="100%" id="image-product-show">
                        </div>
                    </div>
                </div>
                <div class="custom-file">
                    <input type="hidden" name="gambar_old" value="{{ $guskom->gambar }}" id="gambar_old">
                    <input type="file" name="gambar" accept=".jpg,.png" class="custom-file-input upload-viewer"  data-target="#image-product-show">
                    <label class="custom-file-label" for="gambar-mobil">Choose file</label>
                </div>
                @error('gambar')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="form-group">
                <label for="">Nama guskom</label>
                <input type="text" name="nama" class="form-control" placeholder="Masukkan Nama guskom" value="{{ $guskom->nama }}">
                @error('nama')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="form-group">
                <label for="">Deskripsi</label>
                <textarea name="deskripsi" rows="2" class="form-control" placeholder="Masukkan Deskripsi">{{ $guskom->deskripsi }}</textarea>
                @error('deskripsi')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="text-right">
                <button class="btn btn-success">Simpan</button>
            </div>
        </div>
    </div>

</form>
@endsection
