@extends('layouts.app')
@section('title', 'Produk')

@push('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
@endpush

@push('modals')

    {{-- Modal Tambah Produk --}}
    <div class="modal fade" id="modalTambahProduk" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="{{ route('product.store') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">✦ Tambah Produk</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Nama Produk</label>
                            <input type="text" class="form-control" name="name" value="{{ old('name') }}" required>
                            @error('name')<small class="text-danger">{{ $message }}</small>@enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Harga Jual</label>
                            <div class="input-group">
                                <span class="input-group-text" style="font-size:0.85rem;">Rp</span>
                                <input type="number" class="form-control" name="selling_price"
                                    value="{{ old('selling_price') }}" min="0" required>
                            </div>
                            @error('selling_price')<small class="text-danger">{{ $message }}</small>@enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary btn-sm">Simpan Produk</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Modal Hapus Produk --}}
    <div class="modal fade" id="modalHapusProduk" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content">
                <form id="formHapusProduk" method="POST">
                    @csrf @method('DELETE')
                    <div class="modal-header">
                        <h5 class="modal-title text-danger">Konfirmasi Hapus</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body" style="font-size:0.9rem;">
                        Apakah Anda yakin ingin menghapus produk ini?
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
            <h3>Produk</h3>
            <p class="subtitle">"Dan Dia telah memberikan kepadamu (keperluanmu) dan segala apa yang kamu mohonkan."</p>
        </div>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambahProduk">
            <i class="bx bx-plus me-1"></i> Tambah Produk
        </button>
    </div>

    <div class="card fade-up-d1">
        <div class="card-body p-4">
            <div class="table-responsive">
                <table id="tabelProduk" class="table table-striped table-borderless">
                    <thead>
                        <tr class="highlight">
                            <th>Nama Produk</th>
                            <th>Harga Jual</th>
                            <th>Bahan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $product)
                            <tr>
                                <td class="fw-medium">{{ $product->name }}</td>
                                <td>Rp {{ number_format($product->selling_price, 0, ',', '.') }}</td>
                                <td>
                                    <span style="font-size:0.8rem;color:var(--text-3);">
                                        {{ $product->productIngredients->count() ?? 0 }} bahan
                                    </span>
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-danger me-1" data-bs-toggle="modal"
                                        data-bs-target="#modalHapusProduk" data-set-delete="formHapusProduk"
                                        data-base-url="/product" data-id="{{ $product->id }}">
                                        <ion-icon name="trash-outline" style="vertical-align:middle;"></ion-icon>
                                    </button>
                                    <a href="{{ route('product.edit', $product->id) }}" class="btn btn-sm btn-warning">
                                        <ion-icon name="construct-outline" style="vertical-align:middle;"></ion-icon> Bahan
                                    </a>
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
            $('#tabelProduk').DataTable({ pageLength: 10, lengthMenu: [5, 10, 25, 50] });
        });
    </script>
@endpush