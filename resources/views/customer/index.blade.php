@extends('layouts.app')
@section('title', 'Customer')

@push('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
@endpush

@push('modals')

    {{-- Modal Tambah --}}
    <div class="modal fade" id="modalTambahCustomer" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form method="POST" action="{{ url('customer/store') }}">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">✦ Tambah Customer</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Nama</label>
                            <input type="text" class="form-control" name="name" value="{{ old('name') }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">No HP</label>
                            <input type="number" class="form-control" name="phone_number" value="{{ old('phone_number') }}"
                                required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Alamat</label>
                            <input type="text" class="form-control" name="address" value="{{ old('address') }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Deskripsi</label>
                            <input type="text" class="form-control" name="description" value="{{ old('description') }}">
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

    {{-- Modal Edit --}}
    <div class="modal fade" id="modalEditCustomer" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form id="formEditCustomer" method="POST">
                    @csrf @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title">✦ Edit Customer</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="edit_id_pelanggan" name="id_pelanggan">
                        <div class="mb-3">
                            <label class="form-label">Nama</label>
                            <input type="text" class="form-control" id="edit_nama" name="nama" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">No HP</label>
                            <input type="number" class="form-control" id="edit_no_hp" name="no_hp" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Deskripsi</label>
                            <input type="text" class="form-control" id="edit_deskripsi" name="deskripsi" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Alamat</label>
                            <input type="text" class="form-control" id="edit_alamat" name="alamat" required>
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
    <div class="modal fade" id="modalHapusCustomer" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content">
                <form id="formHapusCustomer" method="POST">
                    @csrf @method('DELETE')
                    <div class="modal-header">
                        <h5 class="modal-title text-danger">Konfirmasi Hapus</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body" style="font-size:0.9rem;">
                        Apakah Anda yakin ingin menghapus pelanggan ini?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endpush

@section('content')

    <div class="page-header fade-up">
        <div>
            <h3>Customer</h3>
            <p class="subtitle">"Dan Dia memberinya rezeki dari arah yang tidak disangka-sangkanya." (65:3)</p>
        </div>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambahCustomer">
            <i class="bx bx-plus me-1"></i> Tambah Customer
        </button>
    </div>

    <div class="card fade-up-d1">
        <div class="card-body p-4">
            <div class="table-responsive">
                <table id="tabelCustomer" class="table table-striped table-borderless">
                    <thead>
                        <tr class="highlight">
                            <th>Nama</th>
                            <th>No HP</th>
                            <th>Alamat</th>
                            <th>Deskripsi</th>
                            <th>Bergabung</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($customers as $customer)
                            <tr>
                                <td class="fw-medium">{{ $customer->name }}</td>
                                <td>{{ $customer->phone_number }}</td>
                                <td>{{ $customer->address }}</td>
                                <td>{{ $customer->description ?: '—' }}</td>
                                <td>{{ $customer->created_at }}</td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-danger me-1" data-bs-toggle="modal"
                                        data-bs-target="#modalHapusCustomer" data-set-delete="formHapusCustomer"
                                        data-base-url="/customer" data-id="{{ $customer->id }}">
                                        <ion-icon name="trash-outline" style="vertical-align:middle;"></ion-icon>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal"
                                        data-bs-target="#modalEditCustomer" data-set-edit-customer data-id="{{ $customer->id }}"
                                        data-nama="{{ $customer->name }}" data-no-hp="{{ $customer->phone_number }}"
                                        data-deskripsi="{{ $customer->description }}" data-alamat="{{ $customer->address }}">
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
            $('#tabelCustomer').DataTable({ pageLength: 10, lengthMenu: [5, 10, 25, 50] });
        });
      @if($errors->any()) window.__openModal = 'modalTambahCustomer'; @endif
    </script>
@endpush