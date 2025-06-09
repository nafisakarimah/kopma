@extends('layout.panel')
@section('panel', true)

@section('content')

<h5>Transaksi</h5>

@if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

@if ($errors->has('error'))
    <div class="alert alert-danger">{{ $errors->first('error') }}</div>
@endif

<div class="card rounded-3 mb-4 p-4 shadow-sm" id="export-area">
    <div class="card-body">

        {{-- Filter Tanggal --}}
        <div class="row mb-4 hidden-pdf">
            <div class="col-md-2">
                <label class="form-label">From</label>
                <input id="from" class="form-control form-control-sm" type="date">
            </div>
            <div class="col-md-2">
                <label class="form-label">To</label>
                <input id="to" class="form-control form-control-sm" type="date">
            </div>
            <div class="col-md-2 d-flex align-items-end">
                <button id="process-filtering" class="btn btn-warning w-100">Terapkan</button>
            </div>
            <div class="col-md-3 d-flex align-items-end">
                <button id="download" class="btn btn-primary w-100">Download PDF</button>
            </div>
        </div>

        {{-- Chart --}}
        <div class="d-flex justify-content-around mb-4 flex-wrap hidden-pdf" id="charts-wrapper">
            @foreach (['Menunggu Konfirmasi', 'Dalam Proses', 'Selesai', 'Batal'] as $index => $label)
                <div class="text-center m-2">
                    <canvas id="chart{{ $index }}" width="120" height="120"></canvas>
                    <div>{{ $label }}</div>
                </div>
            @endforeach
        </div>

        <div class="mb-4 hidden-pdf">
            <canvas id="barChart" width="400" height="150"></canvas>
        </div>

        {{-- Filter Status --}}
        <div class="mb-3 hidden-pdf">
            <button class="btn btn-secondary filter-btn" data-filter="all">Semua</button>
            <button class="btn btn-warning filter-btn" data-filter="0">Menunggu</button>
            <button class="btn btn-primary filter-btn" data-filter="1">Dalam Proses</button>
            <button class="btn btn-success filter-btn" data-filter="2">Selesai</button>
            <button class="btn btn-danger filter-btn" data-filter="3">Batal</button>
        </div>

        {{-- Tabel --}}
        <table class="table table-bordered datatable">
            <thead class="bg-primary text-white">
                <tr>
                    <th>#</th>
                    <th>No Transaksi</th>
                    <th>Pembeli</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th class="hidden-pdf">#</th>
                </tr>
            </thead>
            <tbody>
                @php $no = 1; @endphp
                @foreach ($data as $trx)
                    <tr data-status="{{ $trx->status }}" data-date="{{ \Carbon\Carbon::parse($trx->created_at)->format('Y-m-d') }}">
                        <td>{{ $no++ }}</td>
                        <td>{{ $trx->no_po ?? '' }}</td>
                        <td>{{ optional($trx->user)->nama }}</td>
                        <td>Rp. {{ number_format($trx->total, 0, ',', '.') }}</td>
                        <td>
                            @switch($trx->status)
                                @case(0) <span class="badge bg-info" style="color:white;">Pesanan terkirim</span> @break
                                @case(1) <span class="badge bg-primary" style="color:white;">Diterima koperasi</span> @break
                                @case(2) <span class="badge bg-success" style="color:white;">Selesai</span> @break
                                @case(3) <span class="badge bg-danger" style="color:white;">Batal</span> @break
                            @endswitch
                        </td>
                        <td class="hidden-pdf">
                            <a href="{{ route('admin.transaksi.show', $trx->id) }}" class="btn btn-info btn-sm">Rincian</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>
</div>

{{-- Template PDF (disembunyikan) --}}
{{-- pdf-template --}}
<div id="pdf-template" style="display: none; font-family: Arial, sans-serif;">
    <h4 style="text-align: center; margin-bottom: 10px;">Laporan Transaksi</h4>

    {{-- Pie Charts kecil di atas --}}
    <div id="pdf-piecharts" style="display: flex; justify-content: center; gap: 15px; margin-bottom: 15px;"></div>

    {{-- Bar Chart full width di bawah --}}
    <div id="pdf-barchart" style="margin-top: 15px;"></div>

    <table border="1" cellpadding="6" cellspacing="0" width="100%" style="border-collapse: collapse; font-size: 12px;">
        <thead>
            <tr style="background-color: #f2f2f2;">
                <th>#</th>
                <th>No Transaksi</th>
                <th>Pembeli</th>
                <th>Total</th>
                <th>Status</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @php $no = 1; @endphp
            @foreach ($data as $trx)
                <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ $trx->no_po ?? '-' }}</td>
                    <td>{{ optional($trx->user)->nama }}</td>
                    <td>Rp. {{ number_format($trx->total, 0, ',', '.') }}</td>
                    <td>
                        @switch($trx->status)
                            @case(0) Menunggu @break
                            @case(1) Proses @break
                            @case(2) Selesai @break
                            @case(3) Batal @break
                        @endswitch
                    </td>
                    <td>{{ \Carbon\Carbon::parse($trx->created_at)->format('d-m-Y') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>


@endsection

@push('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>

<script>
    let chartInstances = {};
    let barChartInstance = null;
    const colors = { 0: '#4a90e2', 1: '#f5a623', 2: '#7ed321', 3: '#ff0000' };
    const statusLabels = { 0: 'Menunggu', 1: 'Proses', 2: 'Selesai', 3: 'Batal' };

    function parseDate(dateString) {
        const parts = dateString.split("-");
        return new Date(parts[0], parts[1] - 1, parts[2]);
    }

    function getFilteredStatusCounts(from, to) {
        let counts = { 0: 0, 1: 0, 2: 0, 3: 0 };
        let total = 0;

        $('table.datatable tbody tr').each(function () {
            const rowDate = $(this).data('date');
            const status = $(this).data('status');
            const date = parseDate(rowDate);

            if ((!from || date >= parseDate(from)) && (!to || date <= parseDate(to))) {
                $(this).show();
                counts[status]++;
                total++;
            } else {
                $(this).hide();
            }
        });

        return { counts, total };
    }

    function updateCharts(from, to) {
        const { counts, total } = getFilteredStatusCounts(from, to);

        Object.keys(counts).forEach(id => {
            const percent = total > 0 ? Math.round((counts[id] / total) * 100) : 0;

            if (chartInstances[id]) chartInstances[id].destroy();

            chartInstances[id] = new Chart(document.getElementById(`chart${id}`), {
                type: 'doughnut',
                data: {
                    datasets: [{
                        data: [percent, 100 - percent],
                        backgroundColor: [colors[id], '#e8eaed'],
                        borderWidth: 0
                    }]
                },
                options: {
                    cutout: '75%',
                    responsive: false,
                    plugins: {
                        tooltip: { enabled: false },
                        legend: { display: false },
                        datalabels: {
                            display: true,
                            formatter: (value) => value === percent ? `${value}%` : '',
                            color: '#666',
                            font: { size: 16, weight: 'bold' }
                        }
                    }
                },
                plugins: [ChartDataLabels]
            });
        });

        // Bar chart
        const barData = Object.values(counts);
        if (barChartInstance) barChartInstance.destroy();

        barChartInstance = new Chart(document.getElementById('barChart'), {
            type: 'bar',
            data: {
                labels: Object.values(statusLabels),
                datasets: [{
                    label: 'Jumlah Transaksi',
                    data: barData,
                    backgroundColor: Object.keys(colors).map(k => colors[k]),
                    borderRadius: 5,
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: false },
                    datalabels: {
                        anchor: 'end',
                        align: 'top',
                        color: '#444',
                        font: { weight: 'bold' },
                        formatter: v => v > 0 ? v : ''
                    }
                },
                scales: {
                    y: { beginAtZero: true, ticks: { stepSize: 1, precision: 0 } }
                }
            },
            plugins: [ChartDataLabels]
        });
    }

    function cloneCanvasToPdf() {
    const pdfPieDiv = document.getElementById('pdf-piecharts');
    const pdfBarDiv = document.getElementById('pdf-barchart');

    pdfPieDiv.innerHTML = ''; // Kosongkan dulu
    pdfBarDiv.innerHTML = '';

    // Clone semua pie chart (canvas chart0..chart3)
    for(let i=0; i<4; i++) {
        const originalCanvas = document.getElementById(`chart${i}`);
        const imgData = originalCanvas.toDataURL('image/png');

        const img = document.createElement('img');
        img.src = imgData;
        img.style.width = '80px';   // Ukuran kecil supaya gak besar
        img.style.margin = '0 8px';
        img.alt = `Pie Chart ${i}`;

        pdfPieDiv.appendChild(img);
    }

    // Clone bar chart full width
    const barCanvas = document.getElementById('barChart');
    const barImgData = barCanvas.toDataURL('image/png');

    const barImg = document.createElement('img');
    barImg.src = barImgData;
    barImg.style.width = '100%';
    barImg.style.marginTop = '10px';
    barImg.alt = 'Bar Chart';

    pdfBarDiv.appendChild(barImg);
}


    $(document).ready(function () {
        updateCharts(null, null);

        $('#process-filtering').on('click', function () {
            const from = $('#from').val();
            const to = $('#to').val();
            updateCharts(from, to);
        });

        $('.filter-btn').on('click', function () {
            const filter = $(this).data('filter');
            $('table.datatable tbody tr').each(function () {
                const status = $(this).data('status');
                $(this).toggle(filter === 'all' || status == filter);
            });
        });

        $('#download').on('click', function () {
            // Clone chart canvas ke dalam pdf-template
            cloneCanvasToPdf();

            const pdfElement = document.getElementById('pdf-template');
            pdfElement.style.display = 'block';

            const opt = {
                margin: 0.3,
                filename: 'laporan-transaksi.pdf',
                image: { type: 'jpeg', quality: 0.98 },
                html2canvas: { scale: 2, useCORS: true },
                jsPDF: { unit: 'in', format: 'a4', orientation: 'portrait' }
            };

            html2pdf().set(opt).from(pdfElement).save().then(() => {
                pdfElement.style.display = 'none';
            });
        });
    });
</script>
@endpush
