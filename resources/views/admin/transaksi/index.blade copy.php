@extends('layout.panel')
@section('panel',true)

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

<div class="card rounded-3 mb-3 p-4" id="print">
    <div class="card-body">


        <div class="row w-100 my-4">
            <div class="col-md-2 col-sm-12">
                <label for="tgl_mulai" class="form-label">From</label> <br>
                <input id="from" class="form-control form-control-sm" type="date" name="tgl_mulai" id="tgl_mulai">
            </div>
            <div class="col-md-2 col-sm-12 ">

                <label for="tgl_akhir" class="form-label">To</label> <br>
                <input id="to" class="form-control form-control-sm" type="date" name="tgl_akhir" id="tgl_akhir">
            </div>


            <div class="col-md-2 col-sm-12 ">
                <button id="process-filtering" class="btn btn-warning mt-4">Terapkan</button>
            </div>

            <div class="col-md-3">
                <button id="download" class="btn btn-primary mt-4">Download PDF</button>
            </div>
        </div>

        <div>



            <div class="row my-4">
                <div class="col-md-3 col-sm-12">
                    <canvas id="status_1" width="300px" height="200px"></canvas>
                </div>

                <div class="col-md-3 col-sm-12">
                    <canvas id="status_2" width="300px" height="200px"></canvas>

                </div>

                <div class="col-md-3 col-sm-12">
                    <canvas id="status_3" width="300px" height="200px"></canvas>

                </div>

                <div class="col-md-3 col-sm-12">
                    <canvas id="status_4" width="300px" height="200px"></canvas>

                </div>
            </div>

        </div>

        <div class="card card-body border-0 mb-3">
            <div class="row">
                <div class="col-md-2">
                    <a href="{{ route('admin.transaksi.index',['status' => '']) }}" class="btn d-block {{ ($_GET['status']?? '') == ''? 'btn-primary' : 'border border-primary' }}">Semua</a>
                </div>
                <div class="col-md-3">
                    <a href="{{ route('admin.transaksi.index',['status' => '0']) }}" class="btn d-block {{ ($_GET['status']?? '') == '0'? 'btn-primary' : 'border border-primary' }}">Menunggu dikonfirmasi</a>
                </div>
                <div class="col-md-2">
                    <a href="{{ route('admin.transaksi.index',['status' => '1']) }}" class="btn d-block {{ ($_GET['status']?? '') == '1'? 'btn-primary' : 'border border-primary' }}">Dalam Proses</a>
                </div>
                <div class="col-md-2">
                    <a href="{{ route('admin.transaksi.index',['status' => '2']) }}" class="btn d-block {{ ($_GET['status']?? '') == '2'? 'btn-primary' : 'border border-primary' }}">Selesai</a>
                </div>
                <div class="col-md-2">
                    <a href="{{ route('admin.transaksi.index',['status' => '3']) }}" class="btn d-block {{ ($_GET['status']?? '') == '3'? 'btn-primary' : 'border border-primary' }}">Batal</a>
                </div>
            </div>
        </div>


        @endsection


        @push('js')


        @endpush
