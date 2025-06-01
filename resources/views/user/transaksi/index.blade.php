@extends('layout.panel')
@section('content')

<h5>Transaksi</h5>

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

<div class="card card-body border-0 mb-3">
    <div class="row">
        <div class="col-md-2">
            <a href="{{ route('user.transaksi.index',['status' => '']) }}" class="btn d-block {{ ($_GET['status']?? '') == ''? 'btn-primary' : 'border border-primary' }}">Semua</a>
        </div>
        <div class="col-md-3">
            <a href="{{ route('user.transaksi.index',['status' => '0']) }}" class="btn d-block {{ ($_GET['status']?? '') == '0'? 'btn-primary' : 'border border-primary' }}">Menunggu dikonfirmasi</a>
        </div>
        <div class="col-md-2">
            <a href="{{ route('user.transaksi.index',['status' => '1']) }}" class="btn d-block {{ ($_GET['status']?? '') == '1'? 'btn-primary' : 'border border-primary' }}">Dalam Proses</a>
        </div>
        <div class="col-md-2">
            <a href="{{ route('user.transaksi.index',['status' => '2']) }}" class="btn d-block {{ ($_GET['status']?? '') == '2'? 'btn-primary' : 'border border-primary' }}">Selesai</a>
        </div>
        <div class="col-md-2">
            <a href="{{ route('user.transaksi.index',['status' => '3']) }}" class="btn d-block {{ ($_GET['status']?? '') == '3'? 'btn-primary' : 'border border-primary' }}">Batal</a>
        </div>
    </div>
</div>

<div class="card card-body rounded-3">
<div class="table-responsive">
    <table class="table datatable">
        <thead class="bg-primary text-white">
          <tr>
            <th class="rounded-l-3">Tanggal</th>
            <th>No Transaksi</th>
            <th>Total</th>
            <th>Status</th>
            <th class="rounded-r-3">#</th>
          </tr>
        </thead>
        <tbody>
            @if(count($data))
                @foreach ($data as $item)
                    <tr class="border-bottom">
                        <th>{{ $item->created_at }}</th>
                        <th>{{ $item->no_po }}</th>
                        <td class="font-weight-bold">Rp. {{ number_format($item->total,0,',','.') }}</td>
                        <td class="text-capitalize">
                            @if ($item->status == '0')
                                <span class="badge rounded-pill px-2 badge-info">Pesanan terkirim</span>
                            @elseif($item->status == '1')
                                <span class="badge px-2 badge-success" style="white-space: pre-wrap"><b>Pesanan sudah diterima oleh Koperasi</b> Pengemudi sedang menuju ke alamat pengiriman</span>
                            @elseif($item->status == '2')
                                <span class="badge rounded-pill px-2 badge-success">Pesanan Selesai</span>
                            @elseif($item->status == '3')
                                <span class="badge rounded-pill px-2 badge-danger">Pesanan Batal</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('user.transaksi.show',$item->id) }}" class="btn btn-info">Rincian</a>
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
      </table>
</div>
</div>
@endsection