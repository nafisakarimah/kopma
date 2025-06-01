@extends('layout.index')
@section('theme-white',true)
@section('content')

<div class="container-fluid">
    <div class="container pb-30">
        <form action="{{ route('user.checkout.send') }}" method="post">
            @csrf
                <h3 class="mb-4 border-left-9 pl-2 border-secondary">Keranjang</h3>

            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success')  }}
                </div>
            @endif

            @if ($errors->has('error'))
                <div class="alert alert-danger">
                    {!! $errors->first('error') !!}
                </div>
            @endif

            @if (count($alamat))
                <div class="p-30 mb-2 border-2 border-primary rounded-3 mb-5">
                    @foreach ($alamat as $index => $item)
                    <div class="row">
                        <div class="col-md-6">
                            <h3 class="text-primary mb-4">
                                <i class="fa fa-map-marker-alt"></i> <span>Alamat Pengiriman</span>
                            </h3>
                        </div>
                        <div class="col-md-6 text-right">
                            <a href="{{ route('user.alamat-pengiriman.index') }}" class="btn text-primary">Ubah</a>
                        </div>
                    </div>
                        <div class="custom-control custom-radio">
                            <input type="radio" id="alamat-{{ $item->id }}_" name="alamat" class="custom-control-input" value="{{ $item->id }}" {{ (old('alamat') == $item->id || $index == 0)? 'checked' : '' }}>
                            <label class="custom-control-label w-100" for="alamat-{{ $item->id }}_" style="cursor: pointer">
                                <div class="row align-items-center">
                                    <div class="col-md-4">
                                        <h5>{{ $item->nama }} <br> <small>(<b>{{ $item->no_telp }}</b>)</small></h5>
                                    </div>
                                    <div class="col-md-6">
                                        <span class="text-dark">{{ $item->alamat }}</span>
                                    </div>
                                    {{-- <div class="col-md-2 text-right">
                                        
                                    </div> --}}
                                </div>
                            </label>
                        </div>
                    @endforeach
                    @error('alamat')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            @else
            <div class="bg-light p-30 text-center">
                <h4>Alamatmu belum ada</h4>
                <a href="{{ route('user.alamat-pengiriman.create') }}" class="btn btn-primary rounded-3 btn-sm">
                Tambah Sekarang</a>
                @error('alamat')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            @endif
    
            <div class="row">
                <div class="col-lg-12 table-responsive mb-4">
    
                    <div class="card rounded-3 border-2 border-gray accordionmb-3">
                        <div class="card-body">
                            <table class="table table-borderless text-center mb-0">
                                <thead class="bg-primary text-white">
                                    <tr class="text-center border-0">
                                        <th style="width: 200px" class="rounded-l-3">Nama</th>
                                        {{-- <th style="width: 150px;">Harga</th> --}}
                                        <th style="width: 150px;">Ukuran</th>
                                        <th style="width: 150px;">Jumlah</th>
                                        {{-- <th>Hapus</th> --}}
                                        <th class="rounded-r-3" style="width: 250px;">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(count($keranjang))
                                        @foreach ($keranjang as $item)
                                            <tr class="border-bottom">
                                                <td class="align-middle"> 
                                                    <div class="d-flex align-items-center">
                                                        {{ $item->produk->nama }} 
                                                    <a href="{{ route('user.keranjang.destroy',$item->produk_id) }}" class="ml-3 text-danger d-inline-block" onclick="return confirm('Apakah anda yakin ingin menghapus keranjang?')"><i class="fa fa-trash-alt"></i></a>
                                                    </div>
                                                </td>
                                                {{-- <td class="align-middle">Rp. {{ number_format($item->produk->harga,0,',','.') }}</td> --}}
                                                <td class="align-middle">
                                                    @if ($item->produk->kategori->ukuran == '1')
                                                        <select name="keranjang[{{ $loop->index }}][ukuran]" id="" class="form-control">
                                                            @foreach ($item->produk->ukuran as $u)
                                                            <option value="{{ $u->id }}" {{ $item->ukuran_produk_id == $u->id? 'selected' : '' }}>{{ $u->ukuran }}</option>
                                                            @endforeach
                                                        </select>
                                                        @error('ukuran')
                                                            <small class="text-danger">{{ $message }}</small>                                    
                                                        @enderror
                                                    @endif
                                                </td>
                                                <td class="align-middle">
                                                    <input type="hidden" name="keranjang[{{ $loop->index }}][id]" value="{{ $item->id }}">
                                                    <div class="form-group mb-0">
                                                        <input type="number" name="keranjang[{{ $loop->index }}][jumlah]" class="form-control form-control-sm" value="{{ $item->jumlah }}" min="1" max="{{ $item->produk->kategori->ukuran == '1'?'' : $item->produk->stok }}">
                                                        @error('jumlah')
                                                            <small class="text-danger">{{ $message }}</small>                                    
                                                        @enderror
                                                    </div>
                                                </td>
                                                {{-- <td class="align-middle">
                                                    <a href="{{ route('user.keranjang.destroy',$item->produk_id) }}" class="btn btn-sm btn-danger" onclick="return confirm('Apakah anda yakin ingin menghapus keranjang?')"><i class="fa fa-times"></i></a>
                                                </td> --}}
                                                <td class="align-middle text-right">Rp. {{ number_format($item->jumlah*$item->produk->harga,0,',','.') }}</td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="5" align="center">
                                                Belum ada produk di keranjang
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                            <div class="text-right fw-bold">
                                <span class="mr-4">Total: </span> <span>Rp. {{ number_format($total,0,',','.') }}</span>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
            <div class="text-right">
                <button type="submit" class="btn btn-secondary rounded-pill font-weight-bold my-3 py-2 px-5{{ $total == 0? ' disabled' : '' }}">Checkout</button>
            </div>
        </form>
    </div>
</div>

@endsection