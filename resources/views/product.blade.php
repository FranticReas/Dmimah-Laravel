<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dmamah | Produk</title>
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

            <!-- Modal Tambah Produk -->
            <div class="modal fade" id="modalTambahProduk" tabindex="-1" aria-labelledby="modalTambahProdukLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalTambahProdukLabel">
                                Tambah Produk
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                        </div>
                        <form action="{{ route('product.store') }}" method="POST">
                            @csrf
                            <div class="modal-body">
                                {{-- Nama Produk --}}
                                <div class="mb-3">
                                    <label class="form-label">Nama Produk</label>
                                    <input type="text" class="form-control" name="name" value="{{ old('name') }}"
                                        required>
                                    @error('name')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                {{-- Harga --}}
                                <div class="mb-3">
                                    <label class="form-label">Harga</label>
                                    <input type="number" class="form-control" name="selling_price"
                                        value="{{ old('selling_price') }}" min="0" required>
                                    @error('selling_price')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">
                                    Simpan Produk
                                </button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                    Batal
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Modal Hapus Produk -->
            <div class="modal fade" id="modalHapusProduk" tabindex="-1" aria-labelledby="modalHapusProdukLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form method="POST" id="formHapusProduk">
                            @csrf
                            @method('DELETE')
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalHapusProdukLabel">
                                    Konfirmasi Hapus Produk
                                </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Tutup"></button>
                            </div>
                            <div class="modal-body">
                                Apakah Anda yakin ingin menghapus produk ini?
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

            <!--Menu Produk-->
            <main class="content px-3 py-4">
                <div class="container-fluid">
                    <div class="mb-3">
                        <h3 class="fw-bold fs-2 mb-3">Produk</h3>
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div>
                                <p class="fw-normal mb-0">"Dan Dia telah memberikan kepadamu (keperluanmu) dan segala
                                    apa yang kamu mohonkan kepadanya."</p>
                            </div>
                            <div>
                                <button type="button" class="btn btn-primary me-2" data-bs-toggle="modal"
                                    data-bs-target="#modalTambahProduk">+ Tambah Produk
                                </button>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <div class="col-md-20 grid-margin stretch-card">
                                <div class="card">
                                    <div class="card-body">
                                        <!--Table Laporan list Produk Terlaris-->
                                        <div class="table-responsive rounded">
                                            <table id="tabelProduk" class="table table-striped table-borderless py-4">
                                                <!-- Table Head Data Produk -->
                                                <thead>
                                                    <tr class="highlight">
                                                        <th>Nama Produk</th>
                                                        <th>Harga</th>
                                                        <th>Aksi</th>
                                                    </tr>
                                                </thead>

                                                <!--Data Produk-->
                                                <thead>
                                                </thead>
                                                <tbody>
                                                    <!--Menghubungkan Database-->
                                                    @foreach ($products as $product)
                                                        <tr>
                                                            <td>{{ $product->name }}</td>
                                                            <td>Rp {{ number_format($product->selling_price, 0, ',', '.') }}
                                                            </td>
                                                            <td>
                                                                <button class="btn btn-danger btn-sm"
                                                                    data-id="{{ $product->id }}"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#modalHapusProduk">
                                                                    Hapus
                                                                </button>
                                                                <a href="{{ route('product.edit', $product->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>

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
    <script src="{{ asset('js/script.js') }}"></script>
</body>

</html>