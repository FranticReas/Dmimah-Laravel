@extends('layouts.app')
@section('title', 'Stock')

@push('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
@endpush

@push('modals')

    {{-- Modal Tambah Stock --}}
    <div class="modal fade" id="modalTambahStock" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <form id="formTambahStock" method="POST" action="{{ route('stock.store') }}">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">✦ Tambah Stock</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row g-3">

                            <div class="col-md-6">
                                <label class="form-label">Nama Bahan</label>
                                <input type="text" class="form-control" name="name" id="ingredientInput"
                                    list="ingredientList" autocomplete="off" required
                                    placeholder="Ketik atau pilih bahan...">
                                <datalist id="ingredientList">
                                    @foreach($ingredients as $ingredient)
                                        <option value="{{ $ingredient->name }}" data-unit="{{ $ingredient->measurement_unit }}">
                                        </option>
                                    @endforeach
                                </datalist>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Supplier</label>
                                <input type="text" class="form-control" name="supplier_name" required>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Jumlah Pembelian</label>
                                <input type="number" class="form-control" name="quantity" required>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Isi per Pembelian</label>
                                <input type="number" step="0.01" class="form-control" name="unit" required>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Satuan</label>
                                <select name="measurement_unit" class="form-select" required>
                                    <option value="">— Satuan —</option>
                                    <option value="gram">Gram</option>
                                    <option value="liter">Liter</option>
                                    <option value="kg">Kg</option>
                                    <option value="pcs">Pcs</option>
                                    <option value="ml">Ml</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Harga Total (Rp)</label>
                                <div class="input-group">
                                    <span class="input-group-text" style="font-size:0.85rem;">Rp</span>
                                    <input type="number" step="0.01" class="form-control" name="price" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Stok Minimum</label>
                                <input type="number" step="0.01" class="form-control" name="min_stock" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Pajak (%)</label>
                                <div class="input-group">
                                    <input type="number" step="0.01" class="form-control" name="tax" value="0" required>
                                    <span class="input-group-text" style="font-size:0.85rem;">%</span>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Diskon (%)</label>
                                <div class="input-group">
                                    <input type="number" step="0.01" class="form-control" name="discount" value="0">
                                    <span class="input-group-text" style="font-size:0.85rem;">%</span>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success btn-sm">Simpan Stock</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Modal Hapus --}}
    <div class="modal fade" id="modalHapusStock" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content">
                <form id="formHapusStock" method="POST">
                    @csrf @method('DELETE')
                    <div class="modal-header">
                        <h5 class="modal-title text-danger">Konfirmasi Hapus</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body" style="font-size:0.9rem;">
                        Apakah Anda yakin ingin menghapus stok ini?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Modal Edit --}}
    <div class="modal fade" id="modalEditStok" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form id="formEditStok" method="POST">
                    @csrf @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title">✦ Edit Stok</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="edit_stok_id" name="id">
                        <div class="mb-3">
                            <label class="form-label">Nama Bahan</label>
                            <input type="text" class="form-control" id="edit_stok_nama" name="name" required>
                        </div>
                        <div class="row g-3">
                            <div class="col-4">
                                <label class="form-label">Jumlah</label>
                                <input type="number" step="0.01" class="form-control" id="edit_stok_quantity"
                                    name="quantity" required>
                            </div>
                            <div class="col-4">
                                <label class="form-label">Stok Minimum</label>
                                <input type="number" step="0.01" class="form-control" id="edit_stok_minstock"
                                    name="minimum_stock" required>
                            </div>
                            <div class="col-4">
                                <label class="form-label">Satuan</label>
                                <select class="form-select" id="edit_stok_unit" name="measurement_unit" required>
                                    <option value="">—</option>
                                    <option value="gram">Gram</option>
                                    <option value="liter">Liter</option>
                                    <option value="kg">Kg</option>
                                    <option value="pcs">Pcs</option>
                                    <option value="ml">Ml</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success btn-sm">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endpush

@section('content')

    <div class="page-header fade-up">
        <div>
            <h3>Stock</h3>
            <p class="subtitle">"Dan Dia memberinya rezeki dari arah yang tidak disangka-sangkanya." (65:3)</p>
        </div>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambahStock">
            <i class="bx bx-plus me-1"></i> Tambah Stock
        </button>
    </div>

    <div class="card fade-up-d1">
        <div class="card-body p-4">
            <div class="table-responsive">
                <table id="tabelStok" class="table table-striped table-borderless">
                    <thead>
                        <tr class="highlight">
                            <th>Nama Bahan</th>
                            <th>Jumlah</th>
                            <th>Min. Stock</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($stocks as $stock)
                            @php
                                $isLow = $stock->quantity <= $stock->minimum_stock;
                            @endphp
                            <tr>
                                <td class="fw-medium">{{ $stock->name }}</td>
                                <td>
                                    <span class="{{ $isLow ? 'text-danger fw-bold' : '' }}">
                                        {{ $stock->quantity }} {{ $stock->measurement_unit }}
                                    </span>
                                </td>
                                <td style="color:var(--text-3);font-size:0.85rem;">
                                    {{ $stock->minimum_stock }} {{ $stock->measurement_unit }}
                                </td>
                                <td>
                                    @if($isLow)
                                        <span class="status-badge status-cancelled">
                                            <ion-icon name="warning-outline" style="vertical-align:middle;"></ion-icon> Stok Rendah
                                        </span>
                                    @else
                                        <span class="status-badge status-completed">Aman</span>
                                    @endif
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-danger me-1" data-bs-toggle="modal"
                                        data-bs-target="#modalHapusStock" data-set-delete="formHapusStock"
                                        data-base-url="/stock" data-id="{{ $stock->id }}">
                                        <ion-icon name="trash-outline" style="vertical-align:middle;"></ion-icon>
                                    </button>
                                    <button class="btn btn-sm btn-warning" data-bs-toggle="modal"
                                        data-bs-target="#modalEditStok" data-set-edit-stok data-id="{{ $stock->id }}"
                                        data-name="{{ $stock->name }}" data-quantity="{{ $stock->quantity }}"
                                        data-minimum-stock="{{ $stock->minimum_stock }}"
                                        data-measurement="{{ $stock->measurement_unit }}">
                                        <ion-icon name="create-outline" style="vertical-align:middle;"></ion-icon>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#tabelStok').DataTable({ pageLength: 10, lengthMenu: [5, 10, 25, 50] });
        });
      @if($errors->any()) window.__openModal = 'modalTambahStock'; @endif
    </script>
@endpush