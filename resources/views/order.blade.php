<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dmamah | Order</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
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

            <!-- Modal Tambah Order -->
            <div class="modal fade" id="modalTambahOrder" tabindex="-1" aria-labelledby="modalTambahOrderLabel"
                aria-hidden="true">

                <div class="modal-dialog">
                    <div class="modal-content">
                        @if (Session::has('message'))
                            <p class="alert alert-success">{{ Session::get('message') }}</p>
                        @endif
                        <form method="POST" action="{{ route('order.store') }}">
                            @csrf

                            <div class="modal-header">
                                <h5 class="modal-title">Tambah Order</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>

                            <div class="modal-body">

                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <!-- Customer -->
                                <div class="mb-3">
                                    <label class="form-label">Nama Customer</label>

                                    <input type="text" list="listPelanggan" name="customer_name" class="form-control"
                                        value="{{ old('customer_name') }}" autocomplete="off" required>

                                    <datalist id="listPelanggan">
                                        @foreach ($customers as $customer)
                                            <option value="{{ $customer->name }}">{{ $customer->name }}</option>
                                        @endforeach
                                    </datalist>
                                </div>

                                <!-- Produk -->
                                <div class="mb-3">
                                    <label class="form-label">Pesanan</label>

                                    <select class="form-select" name="product_id" required>
                                        @foreach ($products as $product)
                                            <option value="{{ $product->id }}">
                                                {{ $product->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Jumlah -->
                                <div class="mb-3">
                                    <label class="form-label">Jumlah</label>
                                    <input type="number" class="form-control" name="quantity" min="1" required>
                                </div>

                                <!-- Via -->
                                <div class="mb-3">
                                    <label class="form-label">Via</label>
                                    <select class="form-select" name="via" required>
                                        <option value="Cash">Cash</option>
                                        <option value="Bank Transfer">Transfer</option>
                                        <option value="QRIS">QRIS</option>
                                        <option value="Gopay">Gopay</option>
                                        <option value="Credit Card">Kartu Kredit</option>
                                        <option value="Debit Card">Kartu Debit</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <div class="row">
                                        <div class="col-6">
                                            <label class="form-label">Pajak (%)</label>
                                            <div class="input-group">
                                                <input type="number" step="0.01" class="form-control" name="tax"
                                                    required>
                                                <span class="input-group-text">%</span>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <label class="form-label">Diskon (%)</label>
                                            <div class="input-group">
                                                <input type="number" step="0.01" class="form-control" name="discount">
                                                <span class="input-group-text">%</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="submit" class="btn btn-success">
                                    Simpan
                                </button>
                            </div>

                        </form>

                    </div>
                </div>
            </div>

            <!-- Modal Hapus Order -->
            <div class="modal fade" id="modalHapusOrder" tabindex="-1" aria-labelledby="modalHapusOrderLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form method="POST" id="formHapusOrder">
                            @csrf
                            @method('DELETE')
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalHapusOrderLabel">
                                    Konfirmasi Hapus Order
                                </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Tutup"></button>
                            </div>
                            <div class="modal-body">
                                Apakah Anda yakin ingin menghapus order ini?
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-danger">
                                    Hapus
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Edit Status Order -->
            <div class="modal fade" id="modalEditStatus" tabindex="-1" aria-labelledby="modalEditStatusLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form id="formEditStatus" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="modal-header">
                                <h5 class="modal-title" id="modalEditStatusLabel">Edit Status Order</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Tutup"></button>
                            </div>

                            <div class="modal-body">
                                <!-- Input untuk ID Order -->
                                <input type="hidden" id="id_detail" name="id_detail">
                                <div class="mb-3">
                                    <label for="status" class="form-label">Status Baru</label>
                                    <select class="form-select" id="status" name="status" required>
                                        <option value="pending">Pending</option>
                                        <option value="completed">Completed</option>
                                        <option value="cancelled">Cancelled</option>
                                    </select>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-success">Simpan Perubahan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!--Menu Produk-->
            <!--Menu Order-->
            <main class="content px-3 py-4">
                <div class="container-fluid">
                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <h3 class="fw-bold fs-2 mb-2">
                                Order
                            </h3>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <p class="fw-normal my-3">"Dan Dia telah memberikan kepadamu (keperluanmu) dan segala apa
                                yang kamu mohonkan kepadanya."</p>
                            <div>
                                <button class="btn btn-primary me-2" data-bs-toggle="modal"
                                    data-bs-target="#modalTambahOrder">
                                    <i class="bx bx-plus"></i> Tambah Order
                                </button>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <div class="col-md-20 grid-margin stretch-card">
                                <div class="card">
                                    <div class="card-body">
                                        <!--Table Laporan list Produk Terlaris-->
                                        <div class="table-responsive rounded">
                                            <table id="tabelOrder" class="table table-striped table-borderless py-4">
                                                <!--Table Head Produk Terlaris-->
                                                <thead>
                                                    <tr class="highlight">
                                                        <th>Tanggal</th>
                                                        <th>Nama (Customer)</th>
                                                        <th>Pesanan</th>
                                                        <th>Jumlah</th>
                                                        <th>Harga Total</th>
                                                        <th>Status</th>
                                                        <th>Via</th>
                                                        <th>Aksi</th>
                                                    </tr>
                                                </thead>
                                                <!--Data stock-->
                                                <tbody>
                                                    @foreach ($saleItems as $item)
                                                        <tr>
                                                            <td>{{ $item->sale->sale_date }}</td>
                                                            <td>{{ $item->sale->customer->name }}</td>
                                                            <td>{{ $item->product->name }}</td>
                                                            <td>{{ $item->quantity }}</td>
                                                            <td>Rp {{ number_format($item->total, 0, ',', '.') }}</td>
                                                            <td>
                                                                <span @class([
                                                                    'badge',
                                                                    'bg-warning' => $item->sale->status == 'pending',
                                                                    'bg-success' => $item->sale->status == 'completed',
                                                                    'bg-danger' => $item->sale->status == 'cancelled',
                                                                ])>
                                                                    {{ ucfirst($item->sale->status) }}
                                                                </span>
                                                            </td>
                                                            <td>{{ $item->sale->payment_method }}</td>
                                                            <td>
                                                                <button type="button" class="btn btn-danger"
                                                                    data-bs-toggle="modal" data-bs-target="#modalHapusOrder"
                                                                    data-id="{{ $item->sale->id }}"
                                                                    onclick="setDeleteId('{{ $item->sale->id }}')">
                                                                    Hapus
                                                                </button>

                                                                <button type="button" class="btn btn-warning"
                                                                    data-bs-toggle="modal" data-bs-target="#modalEditStatus"
                                                                    onclick="setEditStatus('{{ $item->sale->id }}', '{{ $item->sale->status }}')">
                                                                    Edit Status
                                                                </button>
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

    <!-- jQuery harus sebelum DataTables -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#tabelProduk').DataTable({
                pageLength: 5,
                lengthMenu: [5, 10, 25, 50]
            });
        });
    </script>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Bootstrap Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Ionicons -->
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

    <!-- Script JS kamu sendiri -->
    @if ($errors->any())
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                var myModal = new bootstrap.Modal(document.getElementById('modalTambahOrder'));
                myModal.show();
            });
        </script>
    @endif
    <script src="{{ asset('js/script.js') }}"></script>
</body>

</html>