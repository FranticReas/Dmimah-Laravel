@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')

    {{-- Welcome Banner --}}
    <div class="welcome-banner fade-up">
        <h3>Selamat datang, {{ auth()->user()->name }}! 👋</h3>
        <p>"Dan Dia memberinya rezeki dari arah yang tidak disangka-sangkanya." — QS. 65:3</p>
    </div>

    {{-- Stat Cards --}}
    <div class="row g-3 mb-4" id="stat-cards">
        <div class="col-6 col-lg-3 fade-up-d1">
            <div class="stat-card">
                <ion-icon name="receipt-outline" class="stat-icon-bg"></ion-icon>
                <p class="stat-label">Order Hari Ini</p>
                <p class="stat-value">{{ $orders->where('created_at', now()->toDateString())->count() }}</p>
            </div>
        </div>
        <div class="col-6 col-lg-3 fade-up-d2">
            <div class="stat-card">
                <ion-icon name="cart-outline" class="stat-icon-bg"></ion-icon>
                <p class="stat-label">Total Order</p>
                <p class="stat-value">{{ $orders->count() }}</p>
                <span class="stat-badge {{ $percentageIncrease >= 0 ? 'up' : 'down' }}">
                    {{ $percentageIncrease >= 0 ? '▲' : '▼' }} {{ number_format(abs($percentageIncrease), 1) }}% vs bulan
                    lalu
                </span>
            </div>
        </div>
        <div class="col-6 col-lg-3 fade-up-d3">
            <div class="stat-card">
                <ion-icon name="cash-outline" class="stat-icon-bg"></ion-icon>
                <p class="stat-label">Omzet Bulan Ini</p>
                <p class="stat-value" style="font-size:1.35rem;">Rp {{ number_format($currentRevenue, 0, ',', '.') }}</p>
                <span class="stat-badge {{ $percentageIncreaseRev >= 0 ? 'up' : 'down' }}">
                    {{ $percentageIncreaseRev >= 0 ? '▲' : '▼' }} {{ number_format(abs($percentageIncreaseRev), 1) }}% vs
                    bulan lalu
                </span>
            </div>
        </div>
        <div class="col-6 col-lg-3 fade-up-d4">
            <div class="stat-card">
                <ion-icon name="people-outline" class="stat-icon-bg"></ion-icon>
                <p class="stat-label">Total Pelanggan</p>
                <p class="stat-value">{{ $customers->count() }}</p>
                <span class="stat-badge {{ $percentageIncreaseCust >= 0 ? 'up' : 'down' }}">
                    {{ $percentageIncreaseCust >= 0 ? '▲' : '▼' }} {{ number_format(abs($percentageIncreaseCust), 1) }}% vs
                    bulan lalu
                </span>
            </div>
        </div>
    </div>

    {{-- Charts Row --}}
    <div class="row g-4 mb-4">

        {{-- Line Chart --}}
        <div class="col-12 col-lg-7 fade-up-d1">
            <div class="chart-card p-3 h-100">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="mb-0 fw-bold" style="color:var(--primary);font-size:0.75rem;letter-spacing:0.08em;">
                        📈 PENJUALAN PER BULAN
                    </h6>
                    <div class="d-flex align-items-center gap-2">
                        <div id="zoom-btns" class="d-flex">
                            <button onclick="setZoom(7,this)" class="zoom-btn">1W</button>
                            <button onclick="setZoom(30,this)" class="zoom-btn">1M</button>
                            <button onclick="setZoom(90,this)" class="zoom-btn">3M</button>
                            <button onclick="setZoom(null,this)" class="zoom-btn active">Max</button>
                        </div>
                        <div class="dropdown">
                            <button class="export-btn dropdown-toggle" data-bs-toggle="dropdown">Export</button>
                            <ul class="dropdown-menu dropdown-menu-end shadow"
                                style="font-size:0.82rem;border-radius:12px;">
                                <li><a class="dropdown-item" href="#" onclick="downloadPNG()">
                                        <ion-icon name="download-outline"></ion-icon> Download PNG</a></li>
                                <li><a class="dropdown-item" href="#" onclick="exportCSV()">
                                        <ion-icon name="document-text-outline"></ion-icon> Download CSV</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <canvas id="dashboard-chart" height="180" data-labels="{{ json_encode($allMonths) }}"
                    data-income="{{ json_encode($incomeValues) }}" data-expense="{{ json_encode($expenseValues) }}">
                </canvas>
            </div>
        </div>

        {{-- Bar Chart --}}
        <div class="col-12 col-lg-5 fade-up-d2">
            <div class="card h-100">
                <div class="card-body p-4">
                    <p class="section-title">📊 Laporan Penjualan</p>
                    <canvas id="bar-chart-grouped" height="220"></canvas>
                </div>
            </div>
        </div>
    </div>

    {{-- Products Table --}}
    <div class="row fade-up-d3">
        <div class="col-12">
            <div class="card">
                <div class="card-body p-4">
                    <p class="section-title">🏆 Produk Terlaris</p>
                    <div class="table-responsive">
                        <table class="table table-striped table-borderless">
                            <thead>
                                <tr class="highlight">
                                    <th>Produk</th>
                                    <th>Harga</th>
                                    <th>Jumlah Terjual</th>
                                    <th>Proporsi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $totalSold = $products->sum(fn($p) => $orders->where('product_id', $p->id)->sum('quantity')); @endphp
                                @foreach($products as $product)
                                    @php $sold = $orders->where('product_id', $product->id)->sum('quantity'); @endphp
                                    <tr>
                                        <td class="fw-medium">{{ $product->name }}</td>
                                        <td>Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                                        <td>
                                            <span class="status-badge"
                                                style="background:rgba(150,17,98,0.1);color:var(--primary);">
                                                {{ $sold }}
                                            </span>
                                        </td>
                                        <td style="min-width:120px;">
                                            @php $pct = $totalSold > 0 ? round($sold / $totalSold * 100) : 0; @endphp
                                            <div style="background:#f5e8f0;border-radius:99px;height:6px;">
                                                <div
                                                    style="width:{{ $pct }}%;background:var(--primary);border-radius:99px;height:6px;">
                                                </div>
                                            </div>
                                            <small style="font-size:0.72rem;color:var(--text-3);">{{ $pct }}%</small>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/hammerjs@2.0.8/hammer.min.js"></script>
    <script src="https://unpkg.com/chartjs-plugin-zoom@2.0.1/dist/chartjs-plugin-zoom.min.js"></script>
    <script>
        let lineChart;
        const allMonths = @json($allMonths);
        const incomeVals = @json($incomeValues);
        const expenseVals = @json($expenseValues);

        document.addEventListener('DOMContentLoaded', () => {
            // Line Chart
            const lc = document.getElementById('dashboard-chart');
            if (lc) {
                lineChart = new Chart(lc.getContext('2d'), {
                    type: 'line',
                    data: {
                        labels: allMonths,
                        datasets: [
                            {
                                label: 'Pemasukan',
                                data: incomeVals,
                                borderColor: '#2e8b57',
                                backgroundColor: 'rgba(46,139,87,0.07)',
                                borderWidth: 2.5,
                                pointRadius: 4,
                                pointHoverRadius: 6,
                                pointBackgroundColor: '#2e8b57',
                                tension: 0.4,
                                fill: true,
                            },
                            {
                                label: 'Pengeluaran',
                                data: expenseVals,
                                borderColor: '#c0392b',
                                backgroundColor: 'rgba(192,57,43,0.07)',
                                borderWidth: 2,
                                pointRadius: 3,
                                pointHoverRadius: 5,
                                pointBackgroundColor: '#c0392b',
                                tension: 0.4,
                                fill: true,
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        interaction: { mode: 'index', intersect: false },
                        plugins: {
                            legend: { position: 'bottom', labels: { font: { size: 11 }, boxWidth: 12 } },
                            tooltip: {
                                backgroundColor: '#fff',
                                titleColor: '#961162',
                                bodyColor: '#555',
                                borderColor: 'rgba(150,17,98,0.15)',
                                borderWidth: 1,
                                padding: 10,
                                callbacks: { label: ctx => '  Rp ' + ctx.parsed.y.toLocaleString('id-ID') }
                            },
                            zoom: {
                                zoom: { wheel: { enabled: true }, pinch: { enabled: true }, mode: 'x' },
                                pan: { enabled: true, mode: 'x' },
                            }
                        },
                        scales: {
                            x: { grid: { display: false }, ticks: { font: { size: 10 } } },
                            y: {
                                grid: { color: 'rgba(150,17,98,0.05)' },
                                ticks: { font: { size: 10 }, callback: v => 'Rp ' + v.toLocaleString('id-ID') }
                            }
                        }
                    }
                });
            }

            // Bar Chart
            const bc = document.getElementById('bar-chart-grouped');
            if (bc) {
                new Chart(bc.getContext('2d'), {
                    type: 'bar',
                    data: {
                        labels: @json($labels),
                        datasets: [{
                            label: 'Jumlah Terjual',
                            data: @json($values),
                            backgroundColor: 'rgba(150,17,98,0.85)',
                            hoverBackgroundColor: '#c03a8a',
                            borderRadius: 8,
                            borderSkipped: false,
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: { display: false },
                            tooltip: {
                                backgroundColor: '#fff',
                                titleColor: '#961162',
                                bodyColor: '#555',
                                borderColor: 'rgba(150,17,98,0.15)',
                                borderWidth: 1,
                                padding: 10,
                            }
                        },
                        scales: {
                            x: { grid: { display: false }, ticks: { font: { size: 10 } } },
                            y: {
                                beginAtZero: true,
                                grid: { color: 'rgba(150,17,98,0.05)' },
                                ticks: { stepSize: 10, font: { size: 10 } }
                            }
                        }
                    }
                });
            }
        });

        function setZoom(days, btn) {
            document.querySelectorAll('#zoom-btns .zoom-btn').forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            if (!lineChart) return;
            if (days === null) {
                lineChart.data.labels = allMonths;
                lineChart.data.datasets[0].data = incomeVals;
                lineChart.data.datasets[1].data = expenseVals;
            } else {
                lineChart.data.labels = allMonths.slice(-days);
                lineChart.data.datasets[0].data = incomeVals.slice(-days);
                lineChart.data.datasets[1].data = expenseVals.slice(-days);
            }
            lineChart.update();
        }

        function downloadPNG() {
            if (!lineChart) return;
            const a = document.createElement('a');
            a.href = lineChart.canvas.toDataURL('image/png');
            a.download = 'penjualan.png';
            a.click();
        }

        function exportCSV() {
            const rows = [['Bulan', 'Pemasukan', 'Pengeluaran']];
            allMonths.forEach((m, i) => rows.push([m, incomeVals[i] ?? 0, expenseVals[i] ?? 0]));
            const blob = new Blob([rows.map(r => r.join(',')).join('\n')], { type: 'text/csv' });
            const a = document.createElement('a');
            a.href = URL.createObjectURL(blob);
            a.download = 'penjualan.csv';
            a.click();
        }
    </script>
@endpush