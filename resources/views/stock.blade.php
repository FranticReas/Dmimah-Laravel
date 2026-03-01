<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dmamah | Stock</title>
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

            <!--Menu Utama Page Customer-->
            <main class="content px-3 py-4">
                <div class="container-fluid">
                    <div class="mb-3">
                        <h3 class="fw-bold fs-2 mb-2">
                            Stock
                        </h3>
                        {{-- Message Goes Here --}}
                        @if (Session::has('message'))
                            <p class="alert alert-success">{{ Session::get('message') }}</p>
                        @endif
                        <div class="d-flex align-items-center justify-content-between btn-add-stock">
                            <div class="fw-normal my-3 quotes-stock">"Dan Dia memberinya rezeki dari arah yang tidak
                                disangka-sangkanya."
                                (65:3)</div>
                            <div>
                                <button class="btn btn-primary me-2" data-bs-toggle="modal"
                                    data-bs-target="#modalTambahStock">
                                    <i class="bx bx-plus"></i> Tambah Stock
                                </button>
                            </div>
                            <!-- <div class=""> -->
                            <div class="modal fade" id="modalTambahStock" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form id="formTambahStock" method="POST" action="{{ route('stock.store') }}">
                                            @csrf

                                            <div class="modal-header">
                                                <h5 class="modal-title">Tambah Stock</h5>
                                                <button type="button" class="btn-close"
                                                    data-bs-dismiss="modal"></button>
                                            </div>

                                            <div class="modal-body">
                                                @if ($errors->any())
                                                    <div class="alert alert-danger mb-3">
                                                        <ul>
                                                            @foreach ($errors->all() as $error)
                                                                <li>{{ $error }}</li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                @endif
                                                <div class="mb-3">
                                                    <label class="form-label">Nama Bahan</label>
                                                    <input type="text" class="form-control" name="name"
                                                        id="ingredientInput" list="ingredientList" autocomplete="off"
                                                        required>

                                                    <datalist id="ingredientList">
                                                        @foreach ($ingredients as $ingredient)
                                                            <option value="{{ $ingredient->name }}"
                                                                data-unit="{{ $ingredient->measurement_unit }}">
                                                            </option>
                                                        @endforeach
                                                    </datalist>
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label">Jumlah Pembelian (berapa kali
                                                        beli?)</label>
                                                    <input type="number" class="form-control" name="quantity" required>
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label">Harga Total</label>
                                                    <input type="number" step="0.01" class="form-control" name="price"
                                                        required>
                                                </div>

                                                <div class="mb-3">
                                                    <div class="row">

                                                        <div class="col-4">
                                                            <label class="form-label">Isi per Pembelian</label>
                                                            <input type="number" step="0.01" class="form-control"
                                                                name="unit" required>
                                                        </div>

                                                        <div class="col-4">
                                                            <label class="form-label">Stok Minimum</label>
                                                            <input type="number" step="0.01" class="form-control"
                                                                name="min_stock" required>
                                                        </div>

                                                        <div class="col-4">
                                                            <label class="form-label">Satuan</label>
                                                            <select name="measurement_unit" id="measurementUnit"
                                                                class="form-select" required>
                                                                <option value="">-- Satuan --</option>
                                                                <option value="gram">Gram</option>
                                                                <option value="liter">Liter</option>
                                                                <option value="kg">Kg</option>
                                                                <option value="pcs">Pcs</option>
                                                                <option value="ml">Ml</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="mb-3">
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <label class="form-label">Pajak (%)</label>
                                                            <div class="input-group">
                                                                <input type="number" step="0.01" class="form-control"
                                                                    name="tax" required>
                                                                <span class="input-group-text">%</span>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <label class="form-label">Diskon (%)</label>
                                                            <div class="input-group">
                                                                <input type="number" step="0.01" class="form-control"
                                                                    name="discount">
                                                                <span class="input-group-text">%</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label">Supplier</label>
                                                    <input type="text" class="form-control" name="supplier_name"
                                                        required>
                                                </div>
                                            </div>

                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-success">Simpan</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="modal fade" id="modalHapusStock" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Konfirmasi Hapus</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>

                                        <div class="modal-body">
                                            Apakah Anda yakin ingin menghapus stok ini?
                                        </div>

                                        <div class="modal-footer">
                                            <form id="formHapusStock" method="POST">
                                                @csrf
                                                @method('DELETE')

                                                <button type="submit" class="btn btn-danger">
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Modal Edit Stok -->
                            <div class="modal fade" id="modalEditStok" tabindex="-1"
                                aria-labelledby="modalEditStokLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form id="formEditStok" method="POST">
                                            @csrf
                                            @method('PUT')

                                            <div class="modal-header">
                                                <h5 class="modal-title">Edit Stok</h5>
                                                <button type="button" class="btn-close"
                                                    data-bs-dismiss="modal"></button>
                                            </div>

                                            <div class="modal-body">
                                                <input type="hidden" id="edit_id" name="id">
                                                <div class="mb-3">
                                                    <label class="form-label">Nama</label>
                                                    <input type="text" class="form-control" id="edit_nama" name="name"
                                                        required>
                                                </div>

                                                <div class="mb-3">
                                                    <div class="row">
                                                        <input type="hidden" name="id" id="edit_id">
                                                        <div class="col-4">
                                                            <label class="form-label">Jumlah</label>
                                                            <input type="number" step="0.01" class="form-control"
                                                                name="quantity" id="edit_quantity" required>
                                                        </div>

                                                        <div class="col-4">
                                                            <label class="form-label">Stok Minimum</label>
                                                            <input type="number" step="0.01" class="form-control"
                                                                name="minimum_stock" id="edit_minimum_stock" required>
                                                        </div>

                                                        <div class="col-4">
                                                            <label class="form-label">Satuan</label>
                                                            <select name="measurement_unit" id="edit_measurement_unit"
                                                                class="form-select" required>
                                                                <option value="">-- Satuan --</option>
                                                                <option value="gram">Gram</option>
                                                                <option value="liter">Liter</option>
                                                                <option value="kg">Kg</option>
                                                                <option value="pcs">Pcs</option>
                                                                <option value="ml">Ml</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-success">Update</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- </div> -->
                        </div>
                        <div class="table-responsive">
                            <div class="col-md-20 grid-margin stretch-card">
                                <div class="card">
                                    <div class="card-body">
                                        <!--Table Laporan list Customer-->
                                        <div class="table-responsive rounded">
                                            <table id="tabelStok" class="table table-striped table-borderless py-4">
                                                <!--Table Head Customer-->
                                                <thead>
                                                    <tr class="highlight">

                                                        <th>Nama Bahan</th>
                                                        <th>Jumlah</th>
                                                        <th>Aksi</th>
                                                    </tr>
                                                </thead>
                                                <!--Data stock-->
                                                <thead>
                                                </thead>
                                                <tbody>
                                                    @foreach ($stocks as $stock)
                                                        <tr>
                                                            {{-- <td>{{ $stock->id }}</td> --}}
                                                            <td>{{ $stock->name }}</td>
                                                            <td>{{ $stock->quantity . ' ' . $stock->measurement_unit }}</td>
                                                            <td>
                                                                {{-- DELETE BUTTON --}}
                                                                <button type="button" class="btn btn-danger"
                                                                    data-bs-toggle="modal" data-bs-target="#modalHapusStock"
                                                                    data-id="{{ $stock->id }}">
                                                                    Hapus
                                                                </button>

                                                                {{-- EDIT BUTTON --}}
                                                                <button type="button" class="btn btn-warning"
                                                                    data-bs-toggle="modal" data-bs-target="#modalEditStok"
                                                                    data-id="{{ $stock->id }}"
                                                                    data-name="{{ $stock->name }}"
                                                                    data-quantity="{{ $stock->quantity }}"
                                                                    data-unit="{{ $stock->unit_price }}"
                                                                    data-minimum_stock="{{ $stock->minimum_stock }}"
                                                                    data-measurement="{{ $stock->measurement_unit }}">
                                                                    Edit
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

            <!--Footer Customer-->
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

    @if ($errors->any())
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                var myModal = new bootstrap.Modal(document.getElementById('modalTambahOrder'));
                myModal.show();
            });
        </script>
    @endif

    <!-- jQuery harus sebelum DataTables -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#tabelStok').DataTable({
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