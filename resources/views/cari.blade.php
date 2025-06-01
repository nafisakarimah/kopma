@extends('layout.index')

@section('content')

<div class="container-fluid">
    <div class="row mb-3 px-xl-5">
        <div class="col-md-4">
            <form action="{{ route('cari') }}">
                <div class="input-group">
                    <input type="text" name="keyword" class="form-control" placeholder="Cari disini..." value="{{ $keyword }}">
                    <button class="btn btn-primary"><i class="fa fa-search"></i></button>
                </div>
            </form>
        </div>
    </div>

    <div class="row px-xl-5">
        @if(count($produk))
            @foreach ($produk as $item)
                <div class="col-lg-3 col-md-4 col-sm-6 pb-1">
                    <div class="product-item bg-light mb-4">
                        <div class="product-img position-relative overflow-hidden">
                            <img class="img-fluid w-100" src="{{ asset($item->gambar) }}" alt="">
                            <div class="product-action">
                                @auth
                                    @if(auth()->user()->level_id == '3')
                                        <form action="{{ route('user.favorit.save',$item->id) }}" method="post" class="d-inline-block">
                                            @csrf
                                            <button type="submit" class="btn btn-outline-danger btn-square{{ $item->favorit? ' active' : '' }}"><i class="far fa-heart active"></i></button>
                                        </form>
                                    @endif
                                @endauth
                                <a class="btn btn-info btn-square" href="{{ route('produk.detail',$item->slug) }}"><i class="fa fa-info"></i></a>
                            </div>
                        </div>
                        <div class="text-center py-4">
                            <a class="h6 text-decoration-none text-truncate" href="{{ route('produk.detail',$item->slug) }}">{{ $item->nama }}</a>
                            <div class="d-flex align-items-center justify-content-center mt-2">
                                <h5>Rp. {{ number_format($item->harga,0,',','.') }}</h5>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
        
    </div>

</div>

@endsection