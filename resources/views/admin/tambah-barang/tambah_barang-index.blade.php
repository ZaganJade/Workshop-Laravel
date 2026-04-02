@extends('layouts.app')

@section('title', 'Tambah Barang')

@section('content')

<div class="modern-page-header">
    <h3>
        <div class="modern-header-icon">
            <i class="mdi mdi-cart-plus"></i>
        </div>
        Tambah Barang Baru
    </h3>
    <button type="button" class="btn btn-gradient-primary font-weight-bold" id="btnOpenModal" style="border-radius: 12px; padding: 12px 24px;">
        <i class="mdi mdi-plus me-1"></i> Tambah Barang
    </button>
</div>

{{-- Tab Navigation --}}
<ul class="nav nav-pills mb-4 gap-2" id="pills-tab" role="tablist">
    <li class="nav-item" role="presentation">
        <a href="{{ url('/admin/tambah-barang/html') }}" class="nav-link active font-weight-bold" style="border-radius: 10px; padding: 12px 20px;">
            <i class="mdi mdi-table me-1"></i> HTML Table
        </a>
    </li>
    <li class="nav-item" role="presentation">
        <a href="{{ url('/admin/tambah-barang/datatables') }}" class="nav-link bg-white text-muted border font-weight-bold" style="border-radius: 10px; padding: 12px 20px;">
            <i class="mdi mdi-table-large me-1"></i> DataTables
        </a>
    </li>
</ul>

<div class="card">
    <div class="card-body p-4">
        <div class="table-responsive">
            <table class="table table-hover w-100" id="myTable">
                <thead class="bg-light">
                    <tr>
                        <th style="width: 80px; border-top: none;">ID</th>
                        <th style="border-top: none;">Nama Barang</th>
                        <th style="width: 200px; border-top: none;">Harga</th>
                    </tr>
                </thead>
                <tbody id="tableBody">
                    <tr>
                        <td colspan="3" class="text-center py-5 text-muted">
                            <i class="mdi mdi-package-variant-closed fs-1 d-block mb-2 opacity-50"></i>
                            Belum ada data barang. Klik <strong>"+ Tambah Barang"</strong> untuk memulai.
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Modal Tambah --}}
<div class="modal fade" id="modalTambah" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content" style="border-radius: 24px; border: none; overflow: hidden;">
            <div class="modal-header border-0 p-4" style="background: linear-gradient(135deg, var(--primary-indigo), var(--primary-violet)); color: white;">
                <h5 class="modal-title font-weight-bold"><i class="mdi mdi-package-variant-plus me-2"></i>Tambah Barang Baru</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formTambah">
                <div class="modal-body p-4">
                    <div class="form-group mb-3">
                        <label class="font-weight-bold text-dark mb-2">Nama Barang</label>
                        <input type="text" id="inputNama" class="form-control" placeholder="Masukkan nama barang..." required 
                               style="border-radius: 12px; padding: 12px; border: 2px solid #f1f5f9; background: #f8fafc;">
                    </div>
                    <div class="form-group mb-0">
                        <label class="font-weight-bold text-dark mb-2">Harga Barang (Rp)</label>
                        <input type="number" id="inputHarga" class="form-control" placeholder="Contoh: 15000" required min="0"
                               style="border-radius: 12px; padding: 12px; border: 2px solid #f1f5f9; background: #f8fafc;">
                    </div>
                </div>
                <div class="modal-footer border-0 p-4 pt-0">
                    <button type="button" class="btn btn-light font-weight-bold" data-bs-dismiss="modal" style="border-radius: 12px; padding: 12px 24px;">Batal</button>
                    <button type="submit" class="btn btn-gradient-primary font-weight-bold" id="btnSimpan" style="border-radius: 12px; padding: 12px 24px;">
                        <span id="txtSimpan"><i class="mdi mdi-content-save me-1"></i> Simpan</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('js')
<script>
$(document).ready(function() {
    let dataBarang = [];
    let idCounter = 1;

    // Open Modal logic
    const modalTambah = new bootstrap.Modal(document.getElementById('modalTambah'));
    
    $('#btnOpenModal').click(function() {
        modalTambah.show();
    });

    // Reset focus when modal opens
    document.getElementById('modalTambah').addEventListener('shown.bs.modal', function () {
        document.getElementById('inputNama').focus();
    });

    // Handle form submit
    $('#formTambah').submit(function(e) {
        e.preventDefault();

        let nama = $('#inputNama').val().trim();
        let harga = $('#inputHarga').val().trim();

        if (nama === '' || harga === '') return;

        $('#btnSimpan').prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-2"></span> Menyimpan...');

        setTimeout(function() {
            dataBarang.push({
                id: idCounter++,
                nama: nama,
                harga: harga
            });

            renderTable();
            modalTambah.hide();
            $('#formTambah')[0].reset();
            $('#btnSimpan').prop('disabled', false).html('<i class="mdi mdi-content-save me-1"></i> Simpan');
        }, 600);
    });

    function renderTable() {
        let html = '';
        if (dataBarang.length === 0) {
            html = '<tr><td colspan="3" class="text-center py-5 text-muted"><i class="mdi mdi-package-variant-closed fs-1 d-block mb-2 opacity-50"></i>Belum ada data barang. Klik <strong>"+ Tambah Barang"</strong> untuk memulai.</td></tr>';
        } else {
            dataBarang.forEach(function(item) {
                html += `
                    <tr>
                        <td><span class="badge bg-dark font-weight-bold" style="border-radius: 6px;">#${item.id}</span></td>
                        <td><span class="font-weight-bold text-dark">${item.nama}</span></td>
                        <td><span class="badge bg-soft-success text-success font-weight-bold" style="border-radius: 8px; padding: 8px 12px;">Rp ${Number(item.harga).toLocaleString('id-ID')}</span></td>
                    </tr>
                `;
            });
        }
        $('#tableBody').html(html);
    }
});
</script>
<style>
    .bg-soft-success { background-color: #f0fdf4 !important; }
    .nav-pills .nav-link.active {
        background: linear-gradient(135deg, var(--primary-indigo), var(--primary-violet)) !important;
        box-shadow: 0 4px 12px rgba(79, 70, 229, 0.2) !important;
    }
</style>
@endpush
