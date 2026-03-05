@extends('layouts.app')
@section('title', 'Orders')

@push('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
@endpush

@push('modals')

    {{-- Modal Tambah Order --}}
    <div class="modal fade" id="modalTambahOrder" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form method="POST" action="{{ route('order.store') }}">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">✦ Tambah Order</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Nama Customer</label>
                            <input type="text" list="listPelanggan" name="customer_name" class="form-control"
                                value="{{ old('customer_name') }}" autocomplete="off" required
                                placeholder="Ketik nama customer...">
                            <datalist id="listPelanggan">
                                @foreach($customers as $c)
                                    <option value="{{ $c->name }}">{{ $c->name }}</option>
                                @endforeach
                            </datalist>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Pesanan</label>
                            <select class="form-select" name="product_id" required>
                                @foreach($products as $p)
                                    <option value="{{ $p->id }}">{{ $p->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Jumlah</label>
                            <input type="number" class="form-control" name="quantity" min="1" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Metode Pembayaran</label>
                            <select class="form-select" name="via" required>
                                <option value="Cash">Cash</option>
                                <option value="Bank Transfer">Transfer</option>
                                <option value="QRIS">QRIS</option>
                                <option value="Gopay">Gopay</option>
                                <option value="Credit Card">Kartu Kredit</option>
                                <option value="Debit Card">Kartu Debit</option>
                            </select>
                        </div>
                        <div class="row g-3">
                            <div class="col-6">
                                <label class="form-label">Pajak (%)</label>
                                <div class="input-group">
                                    <input type="number" step="0.01" class="form-control" name="tax" value="0" required>
                                    <span class="input-group-text" style="font-size:0.85rem;">%</span>
                                </div>
                            </div>
                            <div class="col-6">
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
                        <button type="submit" class="btn btn-success btn-sm">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Modal Hapus --}}
    <div class="modal fade" id="modalHapusOrder" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content">
                <form id="formHapusOrder" method="POST">
                    @csrf @method('DELETE')
                    <div class="modal-header">
                        <h5 class="modal-title text-danger">Konfirmasi Hapus</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body" style="font-size:0.9rem;">
                        Apakah Anda yakin ingin menghapus order ini?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Modal Edit Status --}}
    <div class="modal fade" id="modalEditStatus" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content">
                <form id="formEditStatus" method="POST">
                    @csrf @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title">✦ Edit Status</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="edit_status_id" name="id_detail">
                        <label class="form-label">Status Baru</label>
                        <select class="form-select" id="edit_status_val" name="status" required>
                            <option value="pending">Pending</option>
                            <option value="completed">Completed</option>
                            <option value="cancelled">Cancelled</option>
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success btn-sm">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endpush

@section('content')

    <div class="page-header fade-up">
        <div>
            <h3>Orders</h3>
            <p class="subtitle">"Dan Dia telah memberikan kepadamu (keperluanmu) dan segala apa yang kamu mohonkan."</p>
        </div>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambahOrder">
            <i class="bx bx-plus me-1"></i> Tambah Order
        </button>
    </div>

    <div class="card fade-up-d1">
        <div class="card-body p-4">
            <div class="table-responsive">
                <table id="tabelOrder" class="table table-striped table-borderless">
                    <thead>
                        <tr class="highlight">
                            <th>Tanggal</th>
                            <th>Customer</th>
                            <th>Pesanan</th>
                            <th>Jumlah</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Via</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($saleItems as $item)
                            <tr>
                                <td style="font-size:0.82rem;color:var(--text-3);">
                                    {{ \Carbon\Carbon::parse($item->sale->sale_date)->format('d M Y') }}
                                </td>
                                <td class="fw-medium">{{ $item->sale->customer->name }}</td>
                                <td>{{ $item->product->name }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td class="fw-medium">Rp {{ number_format($item->total, 0, ',', '.') }}</td>
                                <td>
                                    <span class="status-badge status-{{ $item->sale->status }}">
                                        {{ ucfirst($item->sale->status) }}
                                    </span>
                                </td>
                                <td>
                                    <span
                                        style="font-size:0.82rem;color:var(--text-3);">{{ $item->sale->payment_method }}</span>
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-danger me-1" data-bs-toggle="modal"
                                        data-bs-target="#modalHapusOrder" data-set-delete="formHapusOrder"
                                        data-base-url="/order" data-id="{{ $item->sale->id }}">
                                        <ion-icon name="trash-outline" style="vertical-align:middle;"></ion-icon>
                                    </button>
                                    <button class="btn btn-sm btn-warning" data-bs-toggle="modal"
                                        data-bs-target="#modalEditStatus" data-set-edit-status data-id="{{ $item->sale->id }}"
                                        data-status="{{ $item->sale->status }}">
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
            $('#tabelOrder').DataTable({ pageLength: 10, lengthMenu: [5, 10, 25, 50], order: [[0, 'desc']] });
        });
      @if($errors->any()) window.__openModal = 'modalTambahOrder'; @endif
    </script>
@endpush