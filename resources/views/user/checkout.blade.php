@extends('layout.index')

@section('content')

<!-- Checkout Start -->
<div class="container-fluid">
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
    <form action="" method="POST">
        @csrf
        <div class="row px-xl-5">
            <div class="col-lg-8">
                <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Info</span></h5>
                @if (count($alamat))
                    <div class="mb-3 text-right">
                        <a href="{{ route('user.alamat-pengiriman.create') }}" class="btn btn-success btn-sm">
                            Tambah</a>
                    </div>
                    @error('alamat')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                    @foreach ($alamat as $item)
                    <div class="bg-light p-30 mb-2">
                        <div class="custom-control custom-radio">
                            <input type="radio" id="alamat-{{ $item->id }}_" name="alamat" class="custom-control-input" value="{{ $item->id }}">
                            <label class="custom-control-label w-100" for="alamat-{{ $item->id }}_" style="cursor: pointer">
                                <div class="row">
                                    <div class="col-md-10">
                                        <h5>{{ $item->nama }} (<b>{{ $item->no_telp }}</b>)</h5>
                                        <span class="text-muted">{{ $item->alamat }}</span>
                                    </div>
                                    <div class="col-md-2 text-right">
                                        <a href="{{ route('user.alamat-pengiriman.edit',$item->id) }}" class="btn btn-sm btn-info">Edit</a>
                                    </div>
                                </div>
                            </label>
                        </div>
                    </div>
                    @endforeach
                @else
                <div class="bg-light p-30 text-center">
                    <h4>Alamatmu belum ada</h4>
                    <a href="{{ route('user.alamat-pengiriman.create') }}" class="btn btn-success btn-sm">
                    Tambah Sekarang</a>
                    @error('alamat')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                @endif
            </div>
            <div class="col-lg-4">
                <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Order Total</span></h5>
                <div class="bg-light p-30 mb-5">
                    <div class="border-bottom">
                        <h6 class="mb-3">Produk</h6>
                        @if(count($keranjang))
                            @foreach ($keranjang as $item)
                                <div class="mb-3">
                                    <div class="d-flex justify-content-between mb-1">
                                        <p class="mb-0">{{ $item->produk->nama }} 
                                            @if ($item->produk->kategori->ukuran == '1')
                                                <small>(Ukuran: <small class="badge badge-secondary">{{ $item->ukuran->ukuran }}</small>)</small>
                                            @endif
                                        </p>
                                        <p class="mb-0">Rp. {{ number_format(($item->produk->harga * $item->jumlah),0,',','.') }}</p>
                                    </div>
                                    <small class="text-muted mb-0 d-block">
                                        Jumlah : {{ $item->jumlah }}
                                    </small>
                                </div>
                            @endforeach
                        @endif
                    </div>
                    <div class="border-bottom pt-3 pb-2">
                        <div class="d-flex justify-content-between mb-3">
                            <h6>Subtotal</h6>
                            <h6>Rp. {{ number_format($total,0,',','.') }}</h6>
                        </div>
                    </div>
                    <div class="pt-2 mb-3">
                        <div class="d-flex justify-content-between mt-2">
                            <h5>Total</h5>
                            <h5>Rp. {{ number_format($total,0,',','.') }}</h5>
                        </div>
                    </div>
                        <button class="btn btn-block btn-primary font-weight-bold py-3{{ $total == 0? ' disabled' : '' }}" type="submit">Pesan Sekarang</button>
                </div>
            </div>
        </div>
    </form>
</div>
<!-- Checkout End -->

@endsection