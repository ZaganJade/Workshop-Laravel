@extends('layouts.app')

@section('title', 'Inventaris Barang')

@section('content')
<div class="modern-page-header">
    <h3>
        <div class="modern-header-icon">
            <i class="mdi mdi-cube-outline"></i>
        </div>
        Katalog Inventaris Barang
    </h3>
    <div class="d-flex gap-2">
        <button type="button" id="btnPrintTnj" disabled
                class="btn btn-inverse-success font-weight-bold" style="border-radius: 12px; padding: 12px 20px;">
            <i class="mdi mdi-printer me-1"></i> <span id="btnPrintText">Print Label TNJ</span>
        </button>
        <button type="button" onclick="openModal('modalTambahBarang')" class="btn btn-gradient-primary font-weight-bold" style="border-radius: 12px; padding: 12px 20px;">
            <i class="mdi mdi-plus me-1"></i> Tambah Barang
        </button>
    </div>
</div>

<div class="card">
    <div class="card-body p-4">
        <div class="table-responsive">
            <table id="barangTable" class="display w-100">
                <thead>
                    <tr>
                        <th style="width: 40px;" class="text-center">
                            <div class="form-check m-0 p-0 d-flex justify-content-center">
                                <input type="checkbox" id="selectAll" class="form-check-input" style="width: 18px; height: 18px; border: 2px solid #cbd5e1; cursor: pointer;">
                            </div>
                        </th>
                        <th style="width: 100px;">ID Barang</th>
                        <th>Nama Barang</th>
                        <th>Harga Satuan</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody id="barangTableBody">
                    @foreach($barang as $item)
                    <tr class="barang-row">
                        <td class="text-center">
                            <div class="form-check m-0 p-0 d-flex justify-content-center">
                                <input type="checkbox" class="barang-checkbox form-check-input" 
                                       value="{{ $item->id_barang }}" 
                                       data-nama="{{ $item->nama }}" 
                                       data-harga="{{ $item->harga }}"
                                       style="width: 18px; height: 18px; border: 2px solid #cbd5e1; cursor: pointer;">
                            </div>
                        </td>
                        <td>
                            <span class="badge bg-dark text-white font-weight-bold px-3 py-2" style="border-radius: 8px; font-size: 0.75rem;">
                                {{ $item->id_barang }}
                            </span>
                        </td>
                        <td>
                            <span class="font-weight-bold text-dark" style="font-size: 1rem;">{{ $item->nama }}</span>
                        </td>
                        <td>
                            <span class="badge bg-light text-success border border-success-subtle px-3 py-2" style="border-radius: 8px; font-size: 0.85rem; font-weight: 700;">
                                Rp {{ number_format($item->harga, 0, ',', '.') }}
                            </span>
                        </td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-2">
                                <button type="button" 
                                        class="btn btn-inverse-info btn-icon btn-sm btn-edit-barang"
                                        data-id="{{ $item->id_barang }}"
                                        data-nama="{{ $item->nama }}"
                                        data-harga="{{ $item->harga }}"
                                        title="Edit">
                                    <i class="mdi mdi-pencil"></i>
                                </button>
                                <button type="button" class="btn btn-inverse-danger btn-icon btn-sm" onclick="alert('Fitur hapus dinonaktifkan untuk demo ini.')" title="Hapus">
                                    <i class="mdi mdi-delete"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Modals Container --}}
<div id="modalContainer">
    {{-- Modal: Print Label TNJ --}}
    @include('admin.barang.Feature.modals_print_tnj')

    {{-- Modal: Tambah & Edit Barang --}}
    @include('admin.barang.Feature.modals_tambah_barang')
</div>

@endsection

@push('js')
<script>
    $(document).ready(function() {
        // Initialize DataTable
        var table = $('#barangTable').DataTable({
            responsive: true,
            columnDefs: [
                { orderable: false, targets: 0 }
            ],
            language: {
                search: "Cari barang:",
                lengthMenu: "Tampilkan _MENU_ entri",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ barang",
                paginate: {
                    first: "Awal",
                    last: "Akhir",
                    next: "Lanjut",
                    previous: "Kembali"
                }
            }
        });

        // Sync Select All logic with DataTables (handles all pages if possible, but here we just keep the IDs)
    });

    function openModal(id) {
        const modal = new bootstrap.Modal(document.getElementById(id));
        modal.show();
    }
</script>
<script src="{{ asset('js/barang.js') }}"></script>
@endpush
