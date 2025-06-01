@extends('layout.panel')
@section('panel',true)

@section('content')

<h2 class="section-title position-relative text-uppercase mx-xl-5 mb-4"><span class="bg-secondary pr-3">Mobil Favorit</span></h2>
<div class="row px-xl-5">
    @if(count($favorit))
        @foreach ($favorit as $fav)
            <div class="col-lg-3 col-md-4 col-sm-6 pb-1">
                <div class="product-item bg-light mb-4">
                    <div class="product-img position-relative overflow-hidden">
                        <img class="img-fluid w-100" src="{{ asset($fav->produk->gambar) }}" alt="">
                        <div class="product-action">
                            <form action="{{ route('user.favorit.save',$fav->produk->id) }}" method="post" class="d-inline-block">
                                @csrf
                                <button type="submit" class="btn btn-outline-danger btn-square{{ $fav->produk->favorit? ' active' : '' }}"><i class="far fa-heart active"></i></button>
                            </form>
                            <a class="btn btn-info btn-square" href="{{ route('produk.detail',$fav->produk->slug) }}"><i class="fa fa-info"></i></a>
                        </div>
                    </div>
                    <div class="text-center py-4">
                        <a class="h6 text-decoration-none text-truncate" href="{{ route('produk.detail',$fav->produk->slug) }}">{{ $fav->produk->nama }}</a>
                        <div class="d-flex align-items-center justify-content-center mt-2">
                            <h5>Rp. {{ number_format($fav->produk->harga,0,',','.') }}</h5>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @else
            <div class="col-md-12">
                <div class="alert alert-warning text-center col-md-6">
                    Belum ada mobil yang terfavorit
                </div>
            </div>
    @endif
    
</div>

@endsection