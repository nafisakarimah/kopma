@extends('layout.panel')
@section('panel',true)

@section('content')

<h5>Edit</h5>

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

<form action="{{ route('admin.produk.update',$produk->id) }}" method="post" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="row">
        <div class="col-md-6 mb-3">
            <div class="form-group">
                <label for="">Kategori</label>
                <select name="kategori" id="" class="form-control">
                    <option value="">Pilih Kategori</option>
                    @foreach ($kategori as $item)
                        <option value="{{ $item->id }}" {{ $produk->kategori_id == $item->id? 'selected' : '' }}>{{ $item->nama }}</option>
                    @endforeach
                </select>
                @error('kategori')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
        </div>
        <div class="col-md-6 mb-3">
            <label for="">Gambar</label>
            <small class="text-warning">Pilih gambar untuk mengubah</small>
            <div class="row mb-3">
                <div class="col-md-4">
                    <div class="img-thumbnail">
                        <img src="{{ asset($produk->gambar) }}" alt="No Image" width="100%" id="image-product-show">
                    </div>
                </div>
            </div>
            <div class="custom-file">
                <input type="file" name="gambar" accept=".jpg,.png" class="custom-file-input upload-viewer" id="gambar-mobil" data-target="#image-product-show">
                <label class="custom-file-label" for="gambar-mobil">Choose file</label>
            </div>
            @error('gambar')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="">Nama</label>
                <input type="text" name="nama" class="form-control" placeholder="Masukkan Nama" value="{{ $produk->nama }}">
                @error('nama')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="">Harga</label>
                <input type="number" name="harga" class="form-control" placeholder="Masukkan Harga" value="{{ $produk->harga }}">
                @error('harga')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
        </div>
        <div class="col-md-6 {{ $produk->kategori->ukuran == '1'? '' : 'collapse' }}" id="produk-ukuran-konten">
            <div class="form-group">
                <label for="">Ukuran</label>
                <div class="row">
                    <div class="col-md-9">
                        <div class="text-right">
                            <button type="button" class="btn btn-sm btn-primary" id="tambah-ukuran">Tambah Ukuran</button>
                        </div>
                        <table class="table table-borderless" width="500px">
                            <thead>
                                <tr class="border-0">
                                    <th>Ukuran</th>
                                    <th width="200px">Stok</th>
                                    <th width="100">#</th>
                                </tr>
                            </thead>
                            <tbody id="body-ukuran">
                                @if ($produk->kategori->ukuran)
                                    @foreach ($produk->ukuran as $item)
                                        <tr>
                                            <td><input type="text" name="ukuran[0][ukuran]" class="form-control" placeholder="Ukuran" value="{{ $item->ukuran }}"></td>
                                            <td><input type="number" name="ukuran[0][stok]" class="form-control" placeholder="Stok" value="{{ $item->stok }}"></td>
                                            <td>
                                                @if ($loop->index > 0)
                                                <button type="button" class="btn btn-sm btn-danger ukuran-hapus">Hapus</button>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 {{ $produk->kategori->ukuran == '1'? 'collapse' : '' }}" id="produk-nonukuran-konten">
            <div class="form-group">
                <label for="">Stok</label>
                <input type="number" name="stok" class="form-control" placeholder="Masukkan Stok" value="{{ $produk->stok }}">
                @error('stok')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
        </div>
        <div class="col-md-8">
            <div class="form-group">
                <label for="">Deskripsi</label>
                <textarea name="deskripsi" rows="2" class="form-control" placeholder="Masukkan Deskripsi">{{ $produk->deskripsi }}</textarea>
                @error('deskripsi')
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

@push('js')

<script>

    let kategori = {!! json_encode($kategori) !!}

    function getKategori(id){
        let result = null
        $.each(kategori, function(i,val){
            if(val.id == id)
            {
                result = val
            }
        })
        return result
    }

    $(document).on('change', '[name="kategori"]', function(){
        let valueKategori = getKategori($(this).val())
        if(valueKategori && valueKategori.ukuran == '1')
        {
            $('#produk-ukuran-konten').collapse('show')
            $('#produk-nonukuran-konten').collapse('hide')
        }else{
            $('#produk-ukuran-konten').collapse('hide')
            $('#produk-nonukuran-konten').collapse('show')
        }
    })
    
    $(document).on('click', '#tambah-ukuran', function(e){
        e.preventDefault();
        let index = $('#body-ukuran tr').length
        let content = `<tr>
                            <td><input type="text" name="ukuran[${index}][ukuran]" class="form-control" placeholder="Ukuran"></td>
                            <td><input type="number" name="ukuran[${index}][stok]" class="form-control" placeholder="Stok"></td>
                            <td>
                                <button type="button" class="btn btn-sm btn-danger ukuran-hapus">Hapus</button>
                            </td>
                        </tr>`
        $('#body-ukuran').append(content)
    })

    $(document).on('click', '#body-ukuran .ukuran-hapus', function(e){
        e.preventDefault();
        $(this).parents('tr').remove()
    })

</script>
    
@endpush