@extends('layout.index')
@section('theme-white',true)
@section('content')

<!-- Shop Detail Start -->
<div class="container pb-5">
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

    <nav>
        <div class="nav nav-tabs mb-4 border-0" id="nav-tab" role="tablist">
            @foreach ($kategori as $index => $item)
                <a href="{{ route('kategori.detail',$item->slug) }}" class="btn btn-outline-primary mr-3 {{ $item->slug == $produk->kategori->slug? 'active' : '' }} rounded-3 border-2">{{ $item->nama }}</a>
            @endforeach
        </div>
    </nav>

    <div class="row">
        <div class="col-lg-5 mb-30">
            <div id="product-carousel" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner bg-light shadow">
                    <div class="carousel-item active">
                        <img class="w-100 h-100" src="{{ url('uploads/'.$produk->gambar) }}" alt="{{ $produk->nama }}">
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-7 h-auto mb-30">
            <div class="h-100 bg-light p-30">
                <div class="row">
                    <div class="col-11">
                        <h5 class="font-weight-bold">{{ $produk->nama }}</h5>
                    </div>
                </div>
                <h5 class="mb-4">Rp. {{ number_format($produk->harga,0,',','.') }}</h5>
                {{-- @if ($produk->kategori->ukuran == '1')
                <span>
                    Ukuran:
                        @foreach ($produk->ukuran as $item)
                            <small class="badge badge-secondary">{{ $item->ukuran }}</small>
                        @endforeach
                    </span>
                @endif --}}
                <p class="mb-4">{{ $produk->deskripsi }}</p>
                @if ($produk->kategori->ukuran == '0')
                <span><b>Sisa Stok:</b> {{ $produk->stok }}</span>
                @endif
                {{-- @auth
                @if(auth()->user()->role == '2') --}}
                <form action="{{ route('user.keranjang.store',$produk->id) }}" method="post" class="pt-2">
                    @csrf
                    <div class="d-flex align-items-center mb-4">
                        @if ($produk->kategori->ukuran == '1')
                            <div class="form-group mr-3 col-4 p-0">
                                <label for="">Ukuran</label><br>
                                @foreach ($produk->ukuran as $item)
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" id="ukuran-{{ $item->id }}" name="ukuran" class="custom-control-input" value="{{ $item->id }}" {{ old('ukuran') == $item->id? 'checked' : '' }}>
                                        <label class="custom-control-label" for="ukuran-{{ $item->id }}"><small class="badge badge-secondary">{{ $item->ukuran }}</small> <small class="text-muted">Stok: {{ $item->stok }}</small></label>
                                    </div>
                                @endforeach
                                <br>
                                @error('ukuran')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        @endif
                        <div class="form-group mr-3 col-2 p-0">
                            <label for="">Jumlah</label>
                            <div class="quantity qty-input">
                                <button type="button" class="btn btn-sm btn-minus"><i class="fa fa-minus"></i></button>
                                <input type="number" name="jumlah" class="form-control text-center" placeholder="Masukkan Jumlah" value="1" min="1">
                                <button type="button" class="btn btn-sm btn-plus"><i class="fa fa-plus"></i></button>
                            </div>
                            @error('jumlah')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <button class="btn btn-primary px-3 mt-3 w-full"><i class="fa fa-shopping-cart mr-1"></i> Tambahkan Ke Keranjang</button>
                </form>
                {{-- @endif
                @endauth --}}
            </div>
        </div>
    </div>
</div>
<!-- Shop Detail End -->

@endsection
