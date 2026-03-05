@extends('layouts.app')
@section('title', 'Edit Produk — ' . $product->nama_produk)

@push('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
@endpush

@push('modals')

    {{-- Modal Tambah Bahan --}}
    <div class="modal fade" id="modalTambahBahan" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form method="POST" action="{{ route('product.bahan.store', $product->id) }}">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">✦ Tambah Bahan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Nama Bahan</label>
                            <select class="form-select" name="stock_id" required>
                                <option value="">— Pilih Bahan —</option>
                                @foreach($stocks as $stock)
                                    <option value="{{ $stock->id }}">{{ $stock->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Jumlah Dibutuhkan</label>
                            <input type="number" class="form-control" name="jumlah_dibutuhkan" min="1" required>
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

@endpush

@section('content')

    {{-- Breadcrumb --}}
    <nav aria-label="breadcrumb" class="mb-3 fade-up">
        <ol class="breadcrumb" style="font-size:0.82rem;">
            <li class="breadcrumb-item"><a href="{{ route('product.index') }}" style="color:var(--primary);">Produk</a></li>
            <li class="breadcrumb-item active">{{ $product->nama_produk }}</li>
        </ol>
    </nav>

    <div class="page-header fade-up">
        <div>
            <h3>{{ $product->nama_produk }}</h3>
            <p class="subtitle">Kelola komposisi bahan untuk produk ini</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('product.index') }}" class="btn btn-secondary btn-sm">
                <ion-icon name="arrow-back-outline" style="vertical-align:middle;"></ion-icon> Kembali
            </a>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambahBahan">
                <i class="bx bx-plus me-1"></i> Tambah Bahan
            </button>
        </div>
    </div>

    {{-- Info Card --}}
    <div class="row g-3 mb-4 fade-up-d1">
        <div class="col-auto">
            <div class="stat-card" style="min-width:160px;">
                <ion-icon name="cube-outline" class="stat-icon-bg"></ion-icon>
                <p class="stat-label">Total Bahan</p>
                <p class="stat-value">{{ $product->productIngredients->count() }}</p>
            </div>
        </div>
    </div>

    <div class="card fade-up-d2">
        <div class="card-body p-4">
            <p class="section-title">Komposisi Bahan</p>
            <div class="table-responsive">
                <table id="tabelProduk" class="table table-striped table-borderless">
                    <thead>
                        <tr class="highlight">
                            <th width="50">No</th>
                            <th>Nama Bahan</th>
                            <th>Jumlah Dibutuhkan</th>
                            <th width="160">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($product->productIngredients as $index => $item)
                            <tr>
                                <td style="color:var(--text-3);">{{ $index + 1 }}</td>
                                <td class="fw-medium">{{ $item->stock->name }}</td>
                                <td>
                                    <form action="{{ route('product-ingredient.update', $item->id) }}" method="POST"
                                        class="d-flex align-items-center gap-2" style="max-width:200px;">
                                        @csrf @method('PUT')
                                        <input type="number" name="jumlah_dibutuhkan" value="{{ $item->quantity_required }}"
                                            class="form-control form-control-sm" required>
                                        <button type="submit" class="btn btn-success btn-sm" style="white-space:nowrap;">
                                            <ion-icon name="checkmark-outline" style="vertical-align:middle;"></ion-icon>
                                        </button>
                                    </form>
                                </td>
                                <td>
                                    <form action="{{ route('product-ingredient.destroy', $item->id) }}" method="POST"
                                        onsubmit="return confirm('Yakin hapus bahan ini?')" class="d-inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <ion-icon name="trash-outline" style="vertical-align:middle;"></ion-icon> Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        @if($product->productIngredients->isEmpty())
                            <tr>
                                <td colspan="4" class="text-center py-5" style="color:var(--text-3);">
                                    <ion-icon name="cube-outline"
                                        style="font-size:2rem;opacity:0.3;display:block;margin:0 auto 0.5rem;"></ion-icon>
                                    Belum ada bahan. Tambahkan bahan untuk produk ini.
                                </td>
                            </tr>
                        @endif
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
            $('#tabelProduk').DataTable({ pageLength: 10 });
        });
    </script>
@endpush