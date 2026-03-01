<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dmamah | Dashboard</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body>
    <!--Pembungkus Class Wrapper dengan Display Flex-->
    <div class="wrapper">
        <!--SideBar Web-->
        <aside id="sidebar">
            <!--Logo Icon Hamburger Sidebar-->
            <div class="d-flex justify-content-between p-4">
                <div class="sidebar-logo">
                    <a href="{{ route('dashboard.index') }}">
                        <img src="{{ asset('images/logodonat.png') }}" alt="logo putih" class="logo-img">
                    </a>
                </div>
                <button class="toggle-btn border-0" type="button">
                    <ion-icon id="icon" name="menu"></ion-icon>
                </button>
            </div>
            <!--List Menu SideBar-->
            <ul class="sidebar-nav">
                <li class="sidebar-item">
                    <a href="{{ route('dashboard.index') }}" class="sidebar-link d-flex align-items-center gap-2">
                        <ion-icon name="home"></ion-icon>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="{{ route('customer.index') }}" class="sidebar-link d-flex align-items-center gap-2">
                        <ion-icon name="people"></ion-icon>
                        <span>Customer</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="{{ route('product.index') }}" class="sidebar-link d-flex align-items-center gap-2">
                        <ion-icon name="cube"></ion-icon>
                        <span>Produk</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="{{ route('order.index') }}" class="sidebar-link d-flex align-items-center gap-2">
                        <ion-icon name="cart"></ion-icon>
                        <span>Orders</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="{{ route('stock.index') }}" class="sidebar-link d-flex align-items-center gap-2">
                        <ion-icon name="clipboard"></ion-icon>
                        <span>Stock</span>
                    </a>
                </li>
            </ul>
            <div class="sidebar-footer mb-3">
                <a href="{{ route('logout') }}" class="sidebar-link d-flex align-items-center gap-2">
                    <ion-icon name="log-out-outline"></ion-icon>
                    <span>Logout</span>
                </a>
            </div>
        </aside>

        <!--Konten Utama-->
        <div class="main">
            <!--Navbar-->
            <nav class="navbar navbar-expand px-4 py-3">
                <!-- Logo kiri -->
                <div class="d-flex align-items-center me-3">
                    <a href="{{ route('dashboard.index') }}">
                        <img src="{{ asset('images/logodonat1.png') }}" alt="Logo Donat" class="logo-navbar-toggle">
                    </a>
                </div>
                <!--Navbar samping Kanan: Foto Profile-->
                <div class="navbar-collapse collapse">
                    <ul class="navbar-nav ms-auto">
                        <!--Username-->
                        <li>
                            <p class="mt-2 me-3 fw-bold">{{ auth()->user()->name }}</p>
                        </li>
                        <!--Foto Profile-->
                        <li class="nav-item dropdown">
                            <a href="#" data-bs-toggle="dropdown" class="nav-icon pe-md-0">
                                <img src="{{ asset('images/mybini.jpeg') }}"
                                    class="avatar img-fluid rounded-circle my-1" alt="user avatar">
                            </a>
                            <div class="dropdown-menu dropdown-menu-end rounded-0 border-0 shadow mt-3">
                                <a href="{{ route('logout') }}" class="dropdown-item">
                                    <ion-icon name="log-out-outline"></ion-icon>
                                    <span>Logout</span>
                                </a>
                                <a href="{{ route('register') }}" class="dropdown-item">
                                    <ion-icon name="log-out-outline"></ion-icon>
                                    <span>Register</span>
                                </a>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>

            <!--Menu Utama DashBoard-->
            <main class="content px-3 py-4">
                <div class="container-fluid">
                    <div class="mb-3">
                        <!--Kalimat Selamat Datang Pembuka di DashBoard-->
                        <h3 class="fw-bold fs-2 mb-2">
                            Selamat datang, {{ auth()->user()->name }}!
                        </h3>

                        <!--TagLine Website-->
                        <p class="fw-normal pb-3">"Dan Dia memberinya rezeki dari arah yang tidak disangka-sangkanya."
                            (65:3)</p>
                        <!--Buat Row utk manajemen layout-->
                        <div class="row">
                            <div class="col-12 col-lg-6">
                                <!--Chart Penjualan-->
                                <div class="card shadow mb-4"
                                    style="background: #fff0f5; border-radius: 8px; border: 1px solid #f0c0d0;">
                                    <div class="card-body p-3">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <h6 class="fw-bold mb-0"
                                                style="color: #961162; font-size: 0.85rem; letter-spacing: 0.05em;">
                                                PENJUALAN PER BULAN
                                            </h6>
                                            <!-- Tombol Zoom + Export -->
                                            <div class="d-flex align-items-center gap-2">
                                                <!-- Zoom buttons -->
                                                <div class="btn-group btn-group-sm">
                                                    <button onclick="setZoom(7, this)" class="zoom-btn">1W</button>
                                                    <button onclick="setZoom(30, this)" class="zoom-btn">1M</button>
                                                    <button onclick="setZoom(90, this)" class="zoom-btn">3M</button>
                                                    <button onclick="setZoom(null, this)"
                                                        class="zoom-btn active">Max</button>
                                                </div>
                                                <!-- Export dropdown -->
                                                <div class="dropdown">
                                                    <button class="btn btn-sm dropdown-toggle"
                                                        style="background:#961162; color:white; border:none; font-size:0.75rem;"
                                                        data-bs-toggle="dropdown">
                                                        Export
                                                    </button>
                                                    <ul class="dropdown-menu dropdown-menu-end shadow"
                                                        style="font-size:0.8rem; min-width:160px;">
                                                        <li><a class="dropdown-item" href="#" onclick="exportPNG()">
                                                                <ion-icon name="image-outline"></ion-icon> Copy PNG
                                                            </a></li>
                                                        <li><a class="dropdown-item" href="#" onclick="downloadPNG()">
                                                                <ion-icon name="download-outline"></ion-icon> Download
                                                                PNG
                                                            </a></li>
                                                        <li><a class="dropdown-item" href="#" onclick="exportCSV()">
                                                                <ion-icon name="document-text-outline"></ion-icon>
                                                                Download CSV
                                                            </a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <canvas id="dashboard-chart" height="160"
                                            data-labels="{{ json_encode($allMonths) }}"
                                            data-income="{{ json_encode($incomeValues) }}"
                                            data-expense="{{ json_encode($expenseValues) }}">
                                        </canvas>
                                        <div class="d-flex justify-content-between mt-1"
                                            style="color: #c06090; font-size: 0.7rem;">
                                            <span id="label-start"></span>
                                            <span id="label-end"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6 grid-margin transparent">
                                <!--Buat Laporan Dalam Bentuk Row-->
                                <div class="row">
                                    <!--Info Laporan Oder Hari ini-->
                                    <div class="col-md-6 mb-4 stretch-card transparent">
                                        <div class="card card-stat shadow">
                                            <div class="card-body">
                                                <p class="mb-3 ms-2 fw-bold">Order hari ini</p>
                                                <h2 class="mb-2 ms-2 fw-bold">
                                                    {{ $orders->where('created_at', now()->toDateString())->count() }}
                                                </h2>
                                            </div>
                                        </div>
                                    </div>
                                    <!--Info Laporan Total Order-->
                                    <div class="col-md-6 mb-4 stretch-card transparent">
                                        <div class="card card-stat shadow">
                                            <div class="card-body">
                                                <p class="mb-3 ms-2 fw-bold">Total order</p>
                                                <h2 class="mb-2 ms-2 fw-bold">
                                                    {{ $orders->count() }}
                                                </h2>
                                                <span
                                                    class="badge {{ $percentageIncrease >= 0 ? 'text-success' : 'text-danger' }}"
                                                    style="font-size: 1.1rem;">
                                                    {{ number_format($percentageIncrease, 1) }}%
                                                    @if($percentageIncrease >= 0)
                                                        Meningkat dari bulan lalu
                                                    @else
                                                        Menurun dari bulan lalu
                                                    @endif
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--Buat dalam bentuk Laporan tiap Row (Baris Baru)-->
                                <div class="row">
                                    <!--Info Laporan Omzet-->
                                    <div class="col-md-6 mb-4 mb-lg-0 stretch-card transparent">
                                        <div class="card card-stat shadow">
                                            <div class="card-body">
                                                <p class="mb-3 ms-2 fw-bold">Omzet bulan ini</p>
                                                <h2 class="mb-2 ms-2 fw-bold">
                                                    Rp {{ number_format($currentRevenue, 0, ',', '.') }}
                                                </h2>
                                                <span
                                                    class="badge {{ $percentageIncreaseRev >= 0 ? 'text-success' : 'text-danger' }}"
                                                    style="font-size: 1.1rem;">
                                                    {{ number_format(abs($percentageIncreaseRev), 1) }}%
                                                    {{ $percentageIncreaseRev >= 0 ? 'Meningkat dari bulan lalu' : 'Menurun dari bulan lalu' }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <!--Info Laporan Total Pelanggan-->
                                    <div class="col-md-6 stretch-card transparent">
                                        <div class="card card-stat shadow">
                                            <div class="card-body">
                                                <p class="mb-3 ms-2 fw-bold">Total pelanggan</p>
                                                <h2 class="mb-2 ms-2 fw-bold">
                                                    {{ $customers->count() }}
                                                </h2>
                                                <span
                                                    class="badge {{ $percentageIncreaseCust >= 0 ? 'text-success' : 'text-danger' }}"
                                                    style="font-size: 1.1rem;">
                                                    {{ number_format($percentageIncreaseCust, 1) }}%
                                                    @if($percentageIncreaseCust >= 0)
                                                        Meningkat dari bulan lalu
                                                    @else
                                                        Menurun dari bulan lalu
                                                    @endif
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--row bawah (Laporan Produk Terlaris dan Laporan Penjualan)-->
                        <div class="row mt-4">
                            <div class="col-md-7 grid-margin stretch-card">
                                <div class="card">
                                    <div class="card-body">
                                        <h3 class="fw-bold fs-4 my-3">
                                            Produk Terlaris
                                        </h3>
                                        <!--Table Laporan list Produk Terlaris-->
                                        <div class="table-responsive rounded">
                                            <table class="table table-striped table-borderless">
                                                <!--Table Head Produk Terlaris-->
                                                <thead>
                                                    <tr class="highlight">
                                                        <th>Produk</th>
                                                        <th>Harga</th>
                                                        <th>Jumlah Terjual</th>
                                                    </tr>
                                                </thead>
                                                <!--Data Produk terlaris-->
                                                <tbody>
                                                    @foreach ($products as $product)
                                                        <tr>
                                                            <td>{{ $product->name }}</td>
                                                            <td>Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                                                            <td>{{ $orders->where('product_id', $product->id)->sum('quantity') }}
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--Laporan Penjualan Donat dan Kue dalam bentuk grafik batang per bulan-->
                            <div class="col-12 col-md-5">
                                <div class="card">
                                    <div class="card-body">
                                        <h3 class="fw-bold fs-4 my-3">
                                            Laporan Penjualan
                                        </h3>
                                        <canvas id="bar-chart-grouped" width="800" height="450"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>

            <!--Footer DashBoard-->
            <footer class="footer">
                <div class="container-fluid">
                    <div class="row text-light">
                        <div class="col-6 text-start">
                            <a href="{{ route('dashboard.index') }}">
                                <img src="{{ asset('images/logodonat.png') }}" alt="logo putih" class="logo-img">
                            </a>
                        </div>
                        <div class="col-6 text-end text-light d-none d-md-block">
                            <ul class="list-inline mt-2">
                                <li class="list-inline-item">
                                    <a href="https://dmimahdonuts.carrd.co/" class="text-light" target="_blank"
                                        rel="noopener">
                                        dmimahdonuts.carrd.co
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    {{-- 1. Chart.js DULU --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/hammerjs@2.0.8/hammer.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-zoom@2.0.1/dist/chartjs-plugin-zoom.min.js"></script>

    {{-- 2. Bootstrap --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO"
        crossorigin="anonymous"></script>

    {{-- 3. script.js --}}
    <script src="{{ asset('js/script.js') }}"></script>

    {{-- 4. Bar chart inline PALING BAWAH --}}
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const barCanvas = document.getElementById('bar-chart-grouped');
            if (barCanvas) {
                const labels = @json($labels);
                const values = @json($values);
                new Chart(barCanvas.getContext('2d'), {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{ label: 'Jumlah Terjual', data: values, backgroundColor: "rgb(150, 17, 98)", borderRadius: 5 }]
                    },
                    options: { responsive: true, scales: { y: { beginAtZero: true, ticks: { stepSize: 10 } } } }
                });
            }
        });
    </script>

    {{-- 5. Ionicons paling akhir --}}
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>
</body>

</html>