@extends('layouts.app')

@section('title', 'Tambah Barang - DataTables')

@push('css')
<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
@include('admin.tambah-barang.css.tambah-barang-common')
@include('admin.tambah-barang.css.datatables-style')
@endpush

@section('content')

<div class="tb-page-header">
    <h3>
        <span class="page-title-icon bg-gradient-primary text-white me-2" style="display:inline-flex;align-items:center;justify-content:center;width:36px;height:36px;border-radius:8px;background:linear-gradient(135deg,#7c3aed,#6d28d9);">
            <i class="mdi mdi-cart-plus" style="color:#fff;font-size:1.1rem;"></i>
        </span>
        Tambah Barang
        <span class="tb-badge">DataTables</span>
    </h3>
    <button type="button" class="tb-btn-add" id="btnOpenModal">
        <i class="mdi mdi-plus"></i> Tambah Barang
    </button>
</div>

{{-- Tab Navigation --}}
<div class="tb-nav-tabs">
    <a href="{{ url('/admin/tambah-barang/html') }}" class="tb-nav-tab">
        <i class="mdi mdi-table"></i> HTML Table
    </a>
    <a href="{{ url('/admin/tambah-barang/datatables') }}" class="tb-nav-tab active">
        <i class="mdi mdi-table-large"></i> DataTables
    </a>
</div>

{{-- Table Card --}}
<div class="tb-card">
    <table class="tb-table display" id="myTable" style="width:100%;">
        <thead>
            <tr>
                <th style="width:80px;">ID</th>
                <th>Nama Barang</th>
                <th style="width:200px;">Harga</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>

{{-- Modal --}}
<div class="tb-modal-overlay" id="modalTambah">
    <div class="tb-modal">
        <h4><i class="mdi mdi-package-variant-closed"></i> Tambah Barang Baru</h4>
        <form id="formTambah" novalidate>
            <label for="inputNama">Nama Barang <span style="color:#ef4444;">*</span></label>
            <input type="text" id="inputNama" placeholder="Masukkan nama barang..." required>

            <label for="inputHarga">Harga Barang <span style="color:#ef4444;">*</span></label>
            <input type="number" id="inputHarga" placeholder="Masukkan harga barang..." required min="0">

            <div class="tb-modal-footer">
                <button type="button" class="tb-btn-cancel" id="btnBatal">Batal</button>
                <button type="submit" class="tb-btn-save" id="btnSimpan">
                    <i class="mdi mdi-content-save"></i> Simpan
                </button>
            </div>
        </form>
    </div>
</div>

@endsection

@push('js')
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script>
$(document).ready(function() {

    let dataBarang = [];
    let idCounter = 1;

    // Initialize DataTable
    let table = $('#myTable').DataTable({
        language: {
            emptyTable: 'Belum ada data barang. Klik "+ Tambah Barang" untuk menambahkan.',
            search: 'Cari:',
            lengthMenu: 'Tampilkan _MENU_ data',
            info: 'Menampilkan _START_ sampai _END_ dari _TOTAL_ data',
            infoEmpty: 'Menampilkan 0 sampai 0 dari 0 data',
            paginate: {
                first: 'Pertama',
                last: 'Terakhir',
                next: 'Selanjutnya',
                previous: 'Sebelumnya'
            }
        }
    });

    // Open modal
    $('#btnOpenModal').click(function() {
        $('#modalTambah').addClass('active');
        $('#inputNama').focus();
    });

    // Close modal
    $('#btnBatal').click(function() {
        closeModal();
    });

    // Close on overlay click
    $('#modalTambah').click(function(e) {
        if ($(e.target).is('#modalTambah')) {
            closeModal();
        }
    });

    // Close on ESC key
    $(document).keydown(function(e) {
        if (e.key === 'Escape') closeModal();
    });

    function closeModal() {
        $('#modalTambah').removeClass('active');
        $('#formTambah')[0].reset();
    }

    // Submit form
    $('#formTambah').submit(function(e) {
        e.preventDefault();

        let form = this;
        if (!form.checkValidity()) {
            form.reportValidity();
            return;
        }

        let nama = $('#inputNama').val().trim();
        let harga = $('#inputHarga').val().trim();

        if (nama === '' || harga === '') return;

        // Loading state
        let $btn = $('#btnSimpan');
        let originalHTML = $btn.html();
        $btn.html('<span class="tb-spinner"></span> Menyimpan...').prop('disabled', true);

        setTimeout(function() {
            let item = {
                id: idCounter++,
                nama: nama,
                harga: harga
            };

            dataBarang.push(item);

            // Add row to DataTable
            table.row.add([
                '<strong>' + item.id + '</strong>',
                item.nama,
                'Rp ' + Number(item.harga).toLocaleString('id-ID')
            ]).draw();

            closeModal();

            // Reset button
            $btn.html(originalHTML).prop('disabled', false);
        }, 600);
    });

});
</script>
@endpush
