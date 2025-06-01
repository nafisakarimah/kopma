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

                <label for="filter" class="form-label smaller" >Tampilkan Berdasarkan</label> <br>
                <select name="filter" id="filter" class="form-control form-control-sm">
                    <option value="hari">Hari</option>
                    <option value="bulan">Bulan</option>
                </select>
            </div>

            <div class="col-md-2 col-sm-12 ">
                <button id="process-filtering" class="btn btn-warning mt-4">Terapkan</button>
            </div>

            <div class="col-md-3">
                <button id="download" class="btn btn-primary mt-4">Download PDF</button>
            </div>
        </div>

        <div>



            <br>
            <br>
        <button class="ml-1 btn btn-lg btn-primary">Status</button>
        </div>
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

            <br>
            <br>
        <div class="d-flex mt-4">

            <a href="#" class="btn btn-lg btn-primary" id="swalayan">Swalayan</a>
            <a href="#" class="btn btn-lg btn-outline-primary ml-2" id="gamashirt">Gamashirt</a>
        </div>
        <div class="row w-100 mt-3">
                <div class="col-12">
                        <h4 class="header-title" align="center">Statistik Penjualan</h4>
                        <canvas id="mataChart" width="500"></canvas>
                </div>
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


<div class="card card-body rounded-3">
<table class="table datatable">
    <thead class="bg-primary text-white">
      <tr>
        <th class="text-white rounded-l-3">Tanggal</th>
        <th class="text-white">No Transaksi</th>
        <th class="text-white">Pembeli</th>
        <th class="text-white">Total</th>
        <th class="text-white" width="80px">Status</th>
        <th class="text-white rounded-r-3">#</th>
      </tr>
    </thead>
    <tbody>
        @if(count($data))
            @foreach ($data as $item)
                <tr>
                    <th>{{ $item->created_at }}</th>
                    <th>{{ $item->no_po }}</th>
                    <td>{{ $item->user->nama }}</td>
                    <td class="font-weight-bold">Rp. {{ number_format($item->total,0,',','.') }}</td>
                    <td class="text-capitalize">
                        @if ($item->status == '0')
                            <span class="badge rounded-pill px-2 badge-info">Pesanan terkirim</span>
                        @elseif($item->status == '1')
                            <span class="badge rounded-pill px-2 badge-success"><b>Pesanan sudah diterima oleh Koperasi</b> <br> Pengemudi sedang menuju ke alamat pengiriman</span>
                        @elseif($item->status == '2')
                            <span class="badge rounded-pill px-2 badge-success">Pesanan Selesai</span>
                        @elseif($item->status == '3')
                            <span class="badge rounded-pill px-2 badge-danger">Pesanan Batal</span>
                        @endif
                    </td>
                    <td>
                        <form action="" method=""></form>
                        <a href="{{ route('admin.transaksi.show',$item->id) }}" class="btn btn-info">Rincian</a>
                    </td>
                </tr>
            @endforeach
        @endif
    </tbody>
  </table>

</div>
@endsection


@push('js')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js">

    </script>
    <script>
        var statusProgress1 = document.getElementById("status_1")
        var statusProgress2 = document.getElementById("status_2")
        var statusProgress3 = document.getElementById("status_3")
        var statusProgress4 = document.getElementById("status_4")

        var myChartCircle = new Chart(statusProgress1, {
            type: 'doughnut',
            data: {
                datasets: [{
                    label: 'Menunggu Konfirmasi',
                    percent: <?= $newPresentase ?> ,
                    backgroundColor: ['#5283ff','#e3e5e8']
                    }]
            },
            plugins: [
                {
                beforeInit: (chart) => {
                    const dataset = chart.data.datasets[0];
                    chart.data.labels = [dataset.label];
                    dataset.data = [dataset.percent, 100 - dataset.percent];
                }
                },

                {
                    beforeDraw: function(chart) {
                        var width = chart.width,
                            height = chart.height,
                            ctx = chart.ctx;

                        ctx.restore();
                        var fontSize = (height / 150).toFixed(2);
                        ctx.font = fontSize + "em sans-serif";
                        ctx.fillStyle = "#9b9b9b";
                        ctx.textBaseline = "middle";

                        var text = "<?= $newPresentase ?>%",
                            textX = Math.round((width - ctx.measureText(text).width) / 2),
                            textY = height / 2;

                        ctx.fillText(text, textX, textY);
                        ctx.save();
                    },

                },


        ],
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutoutPercentage: 85,
                rotation: Math.PI / 2,
                plugins: {
                title: {
                    display: true,
                     text: 'New'
                }
                }
            },
            tooltips: {
                filter: tooltipItem => tooltipItem.index == 0
                }
            });

        var myChartCircle2 = new Chart(statusProgress2, {
            type: 'doughnut',
            data: {
                datasets: [{
                    label: 'Dalam Proses',
                    percent: <?= $ongoingPresentase ?>,
                    backgroundColor: ['#fa9e25','#e3e5e8']
                    }]
            },
            plugins: [
                {
                beforeInit: (chart) => {
                    const dataset = chart.data.datasets[0];
                    chart.data.labels = [dataset.label];
                    dataset.data = [dataset.percent, 100 - dataset.percent];
                }
                },

                {
                    beforeDraw: function(chart) {
                        var width = chart.width,
                            height = chart.height,
                            ctx = chart.ctx;

                        ctx.restore();
                        var fontSize = (height / 150).toFixed(2);
                        ctx.font = fontSize + "em sans-serif";
                        ctx.fillStyle = "#9b9b9b";
                        ctx.textBaseline = "middle";

                        var text = "<?= $ongoingPresentase ?>%",
                            textX = Math.round((width - ctx.measureText(text).width) / 2),
                            textY = height / 2;

                        ctx.fillText(text, textX, textY);
                        ctx.save();
                    },

                },


        ],
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutoutPercentage: 85,
                rotation: Math.PI / 2,
                plugins: {
                legend: {
                    display:false,
                },
                title: {
                    display: false,
                }
                }
            },
            tooltips: {
                filter: tooltipItem => tooltipItem.index == 0
                }
            });

        var myChartCircle3 = new Chart(statusProgress3, {
            type: 'doughnut',
            data: {
                datasets: [{
                    label: 'Selesai',
                    percent: <?= $donePresentase ?>,
                    backgroundColor: ['#71f55d','#e3e5e8']
                    }]
            },
            plugins: [
                {
                beforeInit: (chart) => {
                    const dataset = chart.data.datasets[0];
                    chart.data.labels = [dataset.label];
                    dataset.data = [dataset.percent, 100 - dataset.percent];
                }
                },

                {
                    beforeDraw: function(chart) {
                        var width = chart.width,
                            height = chart.height,
                            ctx = chart.ctx;

                        ctx.restore();
                        var fontSize = (height / 150).toFixed(2);
                        ctx.font = fontSize + "em sans-serif";
                        ctx.fillStyle = "#9b9b9b";
                        ctx.textBaseline = "middle";

                        var text = "<?= $donePresentase ?>%",
                            textX = Math.round((width - ctx.measureText(text).width) / 2),
                            textY = height / 2;

                        ctx.fillText(text, textX, textY);
                        ctx.save();
                    },

                },


        ],
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutoutPercentage: 85,
                rotation: Math.PI / 2,
                plugins: {
                legend: {
                    display:false,
                },
                title: {
                    display: false,
                }
                }
            },
            tooltips: {
                filter: tooltipItem => tooltipItem.index == 0
                }
            });


            var myChartCircle4 = new Chart(statusProgress4, {
            type: 'doughnut',
            data: {
                datasets: [{
                    label: 'Batal',
                    percent: <?= $cancelledPresentase ?>,
                    backgroundColor: ['#FF0000','#e3e5e8']
                    }]
            },
            plugins: [
                {
                beforeInit: (chart) => {
                    const dataset = chart.data.datasets[0];
                    chart.data.labels = [dataset.label];
                    dataset.data = [dataset.percent, 100 - dataset.percent];
                }
                },

                {
                    beforeDraw: function(chart) {
                        var width = chart.width,
                            height = chart.height,
                            ctx = chart.ctx;

                        ctx.restore();
                        var fontSize = (height / 150).toFixed(2);
                        ctx.font = fontSize + "em sans-serif";
                        ctx.fillStyle = "#9b9b9b";
                        ctx.textBaseline = "middle";

                        var text = "<?= $cancelledPresentase ?>%",
                            textX = Math.round((width - ctx.measureText(text).width) / 2),
                            textY = height / 2;

                        ctx.fillText(text, textX, textY);
                        ctx.save();
                    },

                },


        ],
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutoutPercentage: 85,
                rotation: Math.PI / 2,
                plugins: {
                legend: {
                    display:false,
                },
                title: {
                    display: false,
                }
                }
            },
            tooltips: {
                filter: tooltipItem => tooltipItem.index == 0
                }
            });


    </script>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script type="text/javascript" src="{{ asset('assets/lib/html2canvas/html2canvas.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.debug.js" integrity="sha384-NaWTHo/8YCBYJ59830LTz/P4aQZK1sS0SneOgAvhsIl3zBu8r9RevNg5lHCHAuQ/" crossorigin="anonymous"></script>
    <script>
        const myArray = Object.values(@json($datasets));
        var data = {
            labels: @json($labels),
            datasets:myArray
        };

        var config = {
        type: 'bar',
        data: data,
        options: {
            plugins: {
            title: {
                display: true,
                text: 'Data penjualan barang'
            },
            },
            responsive: true,
            scales: {
            x: {
                stacked: true,
            },
            y: {
                stacked: true
            }
            }
        }
        };

        var ctx = document.getElementById("mataChart").getContext('2d');
        var myChart = new Chart(ctx, config);

        $("#from").on('change',(e) => {
            $("#to").attr({"min":e.target.value})
        })

        $("#to").on('change',(e) => {

            console.log(e.target.value);
        })

        $("#filter").on('change',(e) => {
            console.log(e.target.value);

        })


        $("#process-filtering").on('click',(e) => {

            if($("#from").val() && $("#to")){
                let url = "<?= url('admin/transaksi/') ?>/filter?from="+$("#from").val()+"&to="+$("#to").val()+"&basedOn="+$("#filter").val()

                $.get(url, function (e) {

                    const myArray = Object.values(e.datasets)
                    data.datasets = myArray
                    data.labels = e.label
                    myChart.update()
                });
            }

        })
        $("#download").on('click',(e) => {
            window.print()
        })


         $("#swalayan").on("click",function (e) {
            $("#gamashirt").removeClass("btn-primary")
            $("#gamashirt").addClass("btn-outline-primary")
            $("#swalayan").removeClass("btn-outline-primary")
            $("#swalayan").addClass("btn-primary")

             let url = "<?= url('admin/transaksi/') ?>/filter?from="+$("#from").val()+"&to="+$("#to").val()+"&basedOn="+$("#filter").val()+"&category=swalayan"

                $.get(url, function (e) {

                     const myArray = Object.values(e.datasets);
                    console.log(myArray);
                    data.datasets = myArray;
                    data.labels = e.label

                    myChart.update()
                });


        })
        $("#gamashirt").on("click",function (e) {
            $("#gamashirt").removeClass("btn-outline-primary")
            $("#gamashirt").addClass("btn-primary")

            $("#swalayan").removeClass("btn-primary")
            $("#swalayan").addClass("btn-outline-primary")

            let url = "<?= url('admin/transaksi/') ?>/filter?from="+$("#from").val()+"&to="+$("#to").val()+"&basedOn="+$("#filter").val()+"&category=gamashirt"

                $.get(url, function (e) {

                    const myArray = Object.values(e.datasets);
                    console.log(myArray);
                    data.datasets = myArray;
                    data.labels = e.label

                    myChart.update()
                });

        })

        let date = new Date()
        let from = date.getFullYear().toString() + '-' + (date.getMonth() + 1).toString().padStart(2, 0) + '-' + "01";
        let to = date.getFullYear().toString() + '-' + (date.getMonth() + 1).toString().padStart(2, 0) + '-' + date.getDate().toString().padStart(2, 0);

        $("#from").val(from)
        $("#to").val(to)


    </script>

@endpush
