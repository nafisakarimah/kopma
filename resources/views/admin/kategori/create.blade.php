@extends('layout.panel')
@section('panel',true)

@section('content')

<h5 class="mb-3">Tambah Kategori</h5>

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

<form action="{{ route('admin.kategori.store') }}" method="post">
    @csrf
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="">Nama Kategori</label>
                <input type="text" name="nama" class="form-control" placeholder="Masukkan Nama Kategori" value="{{ old('nama') }}">
                @error('nama')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <label class="form-check">
                <input class="form-check-input" type="checkbox" value="0" name="ukuran">
                <span class="form-check-label">
                    Dengan Ukuran
                </span>
            </label>
            <div class="text-right">
                <button class="btn btn-success">Simpan</button>
            </div>
        </div>
    </div>
    
</form>
@endsection

@push('js')
    <script>
        $(document).on('change', '[name="ukuran"]', function(){
            $(this).val(this.checked? 1 : 0)
        })
    </script>
@endpush