@extends('layout.panel')
@section('panel',true)

@section('content')

<h5 class="mb-3">Tambah Guskom</h5>

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

<form action="{{ route('admin.guskom.store') }}" method="post"  enctype="multipart/form-data">
    @csrf
    <div class="row">
        <div class="col-md-6">
            <div class="form-group mb-3">
                <label for="">Gambar</label>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <div class="img-thumbnail">
                            <img src="{{ url('assets/img/default.jpg') }}" alt="No Image" width="100%" id="image-product-show">
                        </div>
                    </div>
                </div>
                <div class="custom-file">
                    <input type="file" name="gambar" accept=".jpg,.png" class="custom-file-input upload-viewer" id="upload-image" data-target="#image-product-show">
                    <label class="custom-file-label" for="upload-image">Choose file</label>
                </div>
                <script>
                    document.getElementById('upload-image').addEventListener('change', function(event) {
                        const input = event.target;
                        const targetImg = document.querySelector(input.dataset.target);

                        if (input.files && input.files[0]) {
                            const reader = new FileReader();
                            reader.onload = function(e) {
                                targetImg.src = e.target.result;
                            };
                            reader.readAsDataURL(input.files[0]);
                        } else {
                            targetImg.src = "{{ url('assets/img/default.jpg') }}";
                        }
                    });
                </script>

                @error('gambar')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="form-group">
                <label for="">Nama guskom</label>
                <input type="text" name="nama" class="form-control" placeholder="Masukkan Nama guskom" value="{{ old('nama') }}">
                @error('nama')
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
