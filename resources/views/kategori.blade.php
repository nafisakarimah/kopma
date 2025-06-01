@extends('layout.index')
@section('theme-white',true)
@section('content')

<div class="container pt-5 pb-30">
    <div class="row">
        <div class="col-md-4 ml-auto">
            <form action="{{ route('kategori.detail',$slug_kategori) }}">
                <input type="text" name="cari" class="form-control border-2 border-primary rounded-pill text-primary placeholder:text-primary" placeholder="Cari Produk" value="{{ $cari }}">
            </form>
        </div>
    </div>
    @if(count($kategori))
        <nav>
            <div class="nav nav-tabs mb-4 border-0" id="nav-tab" role="tablist">
                @foreach ($kategori as $index => $item)
                    <a href="{{ route('kategori.detail',$item->slug) }}" class="btn btn-outline-primary mr-3 {{ $item->slug == $slug_kategori? 'active' : '' }} rounded-3 border-2">{{ $item->nama }}</a>
                @endforeach
            </div>
        </nav>
        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="nav-{{ $item->slug }}" role="tabpanel" aria-labelledby="nav-{{ $item->slug }}-tab">
                <div class="row mb-4">
                    @foreach ($produk as $produk)
                        <div class="col-lg-3 col-md-4 col-sm-6 pb-1">
                            <a href="{{ route('produk.detail',$produk->slug) }}" class="product-item bg-secondary mb-4 d-block rounded-3 text-decoration-none overflow-hidden" style="min-height: 420px">
                                <div class="product-img position-relative overflow-hidden">
                                    <img class="img-fluid w-100" src="{{ asset($produk->gambar) }}" alt="">
                                </div>
                                <div class="p-4 text-center">
                                    <h6 class="h6 text-decoration-none text-truncate ">{{ $produk->nama }}</h6>
                                    <h5 class="">Rp. {{ number_format($produk->harga,0,',','.') }}</h5>
                                    <p class="">{{ $produk->deskripsi }}</p>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
</div>

@endsection