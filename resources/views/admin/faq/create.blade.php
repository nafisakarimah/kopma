@extends('layout.panel')
@section('panel',true)

@section('content')

<h5 class="mb-3">Tambah Faq</h5>

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

<form action="{{ route('admin.faq.store') }}" method="post">
    @csrf
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="">Judul</label>
                <input type="text" name="judul" class="form-control" placeholder="Masukkan Judul" value="{{ old('judul') }}">
                @error('judul')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="form-group">
                <label for="">Urutan</label>
                <input type="number" name="urutan" class="form-control" placeholder="Urutan" value="{{ old('urutan') }}" min="1">
                @error('urutan')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="form-group">
                <label for="">Deskripsi</label>
                <textarea name="deskripsi" rows="2" class="form-control" placeholder="Masukkan Deskripsi">{{ old('deskripsi') }}</textarea>
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