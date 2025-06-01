@extends('layout.index')

@section('content')

<div class="container-fluid">
    <div class="row px-xl-5">
        <div class="col-lg-8 table-responsive mb-5">

            <h3 class="mb-3">Keranjang</h3>

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
            <div class="card border-0 shadow-sm mb-3">
                <div class="card-body">
                    <table class="table table-light table-borderless table-hover text-center mb-0">
                        <thead class="thead-dark">
                            <tr class="text-center">
                                <th style="width: 150px">Nama</th>
                                <th style="width: 150px;">Harga</th>
                                <th style="width: 150px;">Jumlah</th>
                                <th>Total</th>
                                <th style="width: 250px;">Ukuran</th>
                                <th>Hapus</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(count($keranjang))
                                @foreach ($keranjang as $item)
                                    <tr>
                                        <td class="align-middle"> {{ $item->produk->nama }}</td>
                                        <td class="align-middle">Rp. {{ number_format($item->produk->harga,0,',','.') }}</td>
                                        <td class="align-middle">
                                            <form action="{{ route('user.keranjang.update',$item->produk->id) }}" method="post">
                                                @csrf
                                                @method('put')
                                                <input type="hidden" name="ukuran" value="{{ $item->ukuran_produk_id }}">
                                                <div class="form-group mb-0">
                                                    <input type="number" name="jumlah" class="form-control form-control-sm" value="{{ $item->jumlah }}" min="1" max="{{ $item->produk->stok }}">
                                                    @error('jumlah')
                                                        <small class="text-danger">{{ $message }}</small>                                    
                                                    @enderror
                                                </div>
                                                <div class="text-right">
                                                    <button type="submit" class="btn btn-info rounded badge badge-info text-right">Simpan</button>
                                                </div>
                                            </form>
                                        </td>
                                        <td class="align-middle">Rp. {{ number_format($item->jumlah*$item->produk->harga,0,',','.') }}</td>
                                        <td class="align-middle">
                                            <form action="{{ route('user.keranjang.update',$item->produk->id) }}" method="post">
                                                @csrf
                                                @method('put')
                                                <input type="hidden" name="jumlah" value="{{ $item->jumlah }}">
                                                @if ($item->produk->kategori->ukuran == '1')
                                                <select name="ukuran" id="" class="form-control">
                                                    @foreach ($item->produk->ukuran as $u)
                                                    <option value="{{ $u->id }}" {{ $item->ukuran_produk_id == $u->id? 'selected' : '' }}>{{ $u->ukuran }}</option>
                                                    @endforeach
                                                </select>
                                                    @error('ukuran')
                                                        <small class="text-danger">{{ $message }}</small>                                    
                                                    @enderror
                                                    <div class="text-right">
                                                        <button type="submit" class="btn btn-info rounded badge badge-info text-right">Simpan</button>
                                                    </div>
                                                @endif
                                            </form>
                                        </td>
                                        <td class="align-middle">
                                            <form action="{{ route('user.keranjang.destroy',$item->id) }}" method="post" onsubmit="return confirm('Apakah anda yakin ingin menghapus data dari keranjang?')">
                                                @csrf
                                                @method('delete')
                                                <button class="btn btn-sm btn-danger"><i class="fa fa-times"></i></button>
                                            </form>
                                        </td>
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
                </div>
            </div>
            
        </div>
        <div class="col-lg-4">
            <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Detail Keranjang</span></h5>
            <div class="bg-light p-30 mb-5">
                <div class="pt-2">
                    <div class="d-flex justify-content-between mt-2">
                        <h5>Total</h5>
                        <h5>Rp. {{ number_format($total,0,',','.') }}</h5>
                    </div>
                    <a href="{{ route('user.checkout.index') }}" class="btn btn-block btn-primary font-weight-bold my-3 py-3{{ $total == 0? ' disabled' : '' }}">Checkout</a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection