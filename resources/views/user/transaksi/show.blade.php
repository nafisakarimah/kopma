@extends('layout.panel')
@section('panel',true)

@section('content')

<h5>Detail Transaksi </h5>

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

<div class="row mb-3">
    <div class="col-md-6">
        @if ($transaksi->status == '0')
            <span class="badge rounded-pill px-2 badge-info">Pesanan terkirim</span>
        @elseif($transaksi->status == '1')
            <span class="badge rounded-pill px-2 badge-success"><b>Pesanan sudah diterima oleh Koperasi</b> Pengemudi sedang menuju ke alamat pengiriman</span>
        @elseif($transaksi->status == '2')
            <span class="badge rounded-pill px-2 badge-success">Pesanan Selesai</span> <br>
            @if ($transaksi->bukti_barang_sampai)
                <a href="{{ asset($transaksi->bukti_barang_sampai) }}">Lihat Bukti Barang Terkirim</a>
            @endif
        @elseif($transaksi->status == '3')
            <span class="badge rounded-pill px-2 badge-danger">Pesanan Batal</span>
        @endif
        
    </div>
    <div class="col-md-6 text-right">
        <button class="btn btn-dark" id="print">Cetak / Download</button>
    </div>
</div>


<div id="print-area">
    <div class="row mb-3">
        <div class="col-md-6">
            <table class="table">
                <tr>
                    <th>Tanggal</th>
                    <td>{{ $transaksi->created_at }}</td>
                </tr>
                <tr>
                    <th>No Transaksi</th>
                    <td>{{ $transaksi->no_po }}</td>
                </tr>
            </table>
        </div>
        <div class="col-md-6 ml-auto">
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="mb-2 font-weight-bold text-dark">Alamat Penerima</h5>
                    <div class="row mb-3">
                        <div class="col-lg-12 col-md-12 col-12">
                            <div class="form-group mb-2">
                                <div class="row">
                                    <div class="col-md-2 col-3 text-dark">
                                        <b>Nama</b>
                                    </div>
                                    <div class="col-1 text-right">
                                        :
                                    </div>
                                    <div class="col-8 col-md-9">
                                        <div class="text-muted">{{ $transaksi->alamat->nama }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-12">
                            <div class="form-group mb-2">
                                <div class="row">
                                    <div class="col-md-2 col-3 text-dark">
                                        <b>No HP</b>
                                    </div>
                                    <div class="col-1 text-right">
                                        :
                                    </div>
                                    <div class="col-8 col-md-9">
                                        <div class="text-muted">{{ $transaksi->alamat->no_telp }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-12">
                            <div class="form-group mb-0">
                                <div class="row">
                                    <div class="col-md-2 col-3 text-dark">
                                        <b>Alamat</b>
                                    </div>
                                    <div class="col-1 text-right">
                                        :
                                    </div>
                                    <div class="col-8 col-md-9">
                                        <div class="text-muted">{{ $transaksi->alamat->alamat }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <table class="table">
                <tr>
                    <th>Total</th>
                    <td>Rp.
                        {{ number_format($transaksi->total,0,',','.') }}
                    </td>
                </tr>
            </table>
        </div>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Ukuran</th>
                <th>Jumlah</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transaksi->detail as $item)
                <tr>
                    <th>{{ $loop->iteration }}</th>
                    <td>{{ $item->produk->nama }}</td>
                    <td>
                        {!! $item->ukuran? '<small class="badge badge-secondary">'.$item->ukuran->ukuran.'</small>': '-' !!}
                    </td>
                    <td>{{ $item->jumlah }}</td>
                    <td>Rp. {{ number_format(($item->total),0,',','.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>



@endsection


@push('js')
<script>

    $(document).on('click','#print',function(e){
        e.preventDefault();
        let oldContent = $('body').html()

        let newContent = $('#print-area').html()

        $('body').html(newContent)

        window.print()

        $('body').html(oldContent)

    })

</script>
@endpush