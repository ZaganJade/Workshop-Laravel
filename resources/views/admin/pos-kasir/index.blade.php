@extends('layouts.app')

@section('title', 'POS Kasir AJAX')

@section('content')

<div class="modern-page-header">
    <h3>
        <div class="modern-header-icon">
            <i class="mdi mdi-cash-register"></i>
        </div>
        Point of Sales Kasir
    </h3>
    <div style="font-size: 0.8rem; color: #6b7280; font-weight: 600; background: #f3f4f6; padding: 6px 16px; border-radius: 50px;">
        <i class="mdi mdi-cart-arrow-down me-1 text-primary"></i> Transaksi Kasir &mdash; AJAX & Axios
    </div>
</div>

{{-- Tab Switcher: AJAX vs Axios --}}
<ul class="nav nav-pills mb-4 gap-2" id="posTab" role="tablist">
    <li class="nav-item" role="presentation">
        <button class="nav-link active font-weight-bold px-4 py-2" id="pos-ajax-tab" data-bs-toggle="pill" data-bs-target="#posAjaxPane" type="button" role="tab" style="border-radius: 12px; font-size: 0.8rem; letter-spacing: 0.5px;">
            <i class="mdi mdi-jquery me-1"></i> AJAX jQuery
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link font-weight-bold px-4 py-2" id="pos-axios-tab" data-bs-toggle="pill" data-bs-target="#posAxiosPane" type="button" role="tab" style="border-radius: 12px; font-size: 0.8rem; letter-spacing: 0.5px;">
            <i class="mdi mdi-language-javascript me-1"></i> Axios
        </button>
    </li>
</ul>

<div class="tab-content" id="posTabContent">
    {{-- ===================== AJAX Pane ===================== --}}
    <div class="tab-pane fade show active" id="posAjaxPane" role="tabpanel">
        <div class="row g-4">
            {{-- Form Input --}}
            <div class="col-lg-5">
                <div class="card border-0 shadow-sm h-100" style="border-radius: 20px;">
                    <div class="card-header bg-white border-0 pt-4 px-4 pb-0 d-flex justify-content-between align-items-center">
                        <span class="badge bg-soft-primary text-primary px-3 py-2 font-weight-bold" style="border-radius: 8px; font-size: 0.65rem; letter-spacing: 0.5px;">INPUT BARANG &mdash; AJAX</span>
                        <i class="mdi mdi-barcode-scan text-muted"></i>
                    </div>
                    <div class="card-body p-4 pt-3">
                        <div class="form-group mb-3">
                            <label class="text-xs font-weight-bold text-uppercase text-muted mb-2 d-block" style="letter-spacing: 1px;">Kode Barang</label>
                            <input type="text" id="ajaxKodeBarang" class="form-control" placeholder="Scan / ketik kode &amp; tekan Enter"
                                   style="border-radius: 12px; padding: 12px 18px; border: 2px solid #f1f5f9; background: #f8fafc;">
                        </div>
                        <div class="form-group mb-3">
                            <label class="text-xs font-weight-bold text-uppercase text-muted mb-2 d-block" style="letter-spacing: 1px;">Nama Barang</label>
                            <input type="text" id="ajaxNamaBarang" class="form-control" readonly
                                   style="border-radius: 12px; padding: 12px 18px; border: 2px solid #f1f5f9; background: #f1f5f9;">
                        </div>
                        <div class="form-group mb-3">
                            <label class="text-xs font-weight-bold text-uppercase text-muted mb-2 d-block" style="letter-spacing: 1px;">Harga Barang</label>
                            <input type="text" id="ajaxHargaBarang" class="form-control" readonly
                                   style="border-radius: 12px; padding: 12px 18px; border: 2px solid #f1f5f9; background: #f1f5f9;">
                        </div>
                        <div class="form-group mb-4">
                            <label class="text-xs font-weight-bold text-uppercase text-muted mb-2 d-block" style="letter-spacing: 1px;">Jumlah</label>
                            <input type="number" id="ajaxJumlah" class="form-control" min="1" value="1"
                                   style="border-radius: 12px; padding: 12px 18px; border: 2px solid #f1f5f9; background: #f8fafc;">
                        </div>
                        <button type="button" id="ajaxBtnTambah" class="btn btn-gradient-primary font-weight-bold w-100" disabled
                                style="border-radius: 12px; padding: 12px;">
                            <i class="mdi mdi-cart-plus me-1"></i> Tambahkan ke Tabel
                        </button>
                    </div>
                </div>
            </div>

            {{-- Tabel & Bayar --}}
            <div class="col-lg-7">
                <div class="card border-0 shadow-sm h-100" style="border-radius: 20px;">
                    <div class="card-header bg-white border-0 pt-4 px-4 pb-0 d-flex justify-content-between align-items-center">
                        <span class="badge bg-soft-primary text-primary px-3 py-2 font-weight-bold" style="border-radius: 8px; font-size: 0.65rem; letter-spacing: 0.5px;">KERANJANG TRANSAKSI</span>
                        <i class="mdi mdi-receipt text-muted"></i>
                    </div>
                    <div class="card-body p-4 pt-3">
                        <div class="table-responsive">
                            <table class="table align-middle" id="ajaxTabelKeranjang">
                                <thead style="background: #f8fafc;">
                                    <tr>
                                        <th class="text-uppercase text-muted" style="font-size: 0.7rem; letter-spacing: 1px;">Kode</th>
                                        <th class="text-uppercase text-muted" style="font-size: 0.7rem; letter-spacing: 1px;">Nama</th>
                                        <th class="text-uppercase text-muted" style="font-size: 0.7rem; letter-spacing: 1px;">Harga</th>
                                        <th class="text-uppercase text-muted text-center" style="font-size: 0.7rem; letter-spacing: 1px;">Jumlah</th>
                                        <th class="text-uppercase text-muted text-end" style="font-size: 0.7rem; letter-spacing: 1px;">Subtotal</th>
                                        <th class="text-uppercase text-muted text-center" style="font-size: 0.7rem; letter-spacing: 1px;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr id="ajaxEmptyRow">
                                        <td colspan="6" class="text-center text-muted py-4">
                                            <i class="mdi mdi-cart-outline" style="font-size: 2rem; opacity: 0.3;"></i>
                                            <div>Belum ada barang. Scan kode untuk memulai.</div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mt-3 p-3" style="background: linear-gradient(135deg, #f8fafc, #f1f5f9); border-radius: 16px;">
                            <div>
                                <small class="text-uppercase font-weight-bold text-muted d-block" style="font-size: 0.65rem; letter-spacing: 1px;">Total Belanja</small>
                                <div class="h4 font-weight-bold mb-0 text-dark" id="ajaxTotal">Rp 0</div>
                            </div>
                            <button type="button" id="ajaxBtnBayar" class="btn btn-gradient-primary font-weight-bold px-5 py-3" disabled
                                    style="border-radius: 12px;">
                                <i class="mdi mdi-cash-multiple me-1"></i> Bayar
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ===================== Axios Pane ===================== --}}
    <div class="tab-pane fade" id="posAxiosPane" role="tabpanel">
        <div class="row g-4">
            {{-- Form Input --}}
            <div class="col-lg-5">
                <div class="card border-0 shadow-sm h-100" style="border-radius: 20px;">
                    <div class="card-header bg-white border-0 pt-4 px-4 pb-0 d-flex justify-content-between align-items-center">
                        <span class="badge bg-soft-success text-success px-3 py-2 font-weight-bold" style="border-radius: 8px; font-size: 0.65rem; letter-spacing: 0.5px;">INPUT BARANG &mdash; AXIOS</span>
                        <i class="mdi mdi-barcode-scan text-muted"></i>
                    </div>
                    <div class="card-body p-4 pt-3">
                        <div class="form-group mb-3">
                            <label class="text-xs font-weight-bold text-uppercase text-muted mb-2 d-block" style="letter-spacing: 1px;">Kode Barang</label>
                            <input type="text" id="axiosKodeBarang" class="form-control" placeholder="Scan / ketik kode &amp; tekan Enter"
                                   style="border-radius: 12px; padding: 12px 18px; border: 2px solid #f1f5f9; background: #f8fafc;">
                        </div>
                        <div class="form-group mb-3">
                            <label class="text-xs font-weight-bold text-uppercase text-muted mb-2 d-block" style="letter-spacing: 1px;">Nama Barang</label>
                            <input type="text" id="axiosNamaBarang" class="form-control" readonly
                                   style="border-radius: 12px; padding: 12px 18px; border: 2px solid #f1f5f9; background: #f1f5f9;">
                        </div>
                        <div class="form-group mb-3">
                            <label class="text-xs font-weight-bold text-uppercase text-muted mb-2 d-block" style="letter-spacing: 1px;">Harga Barang</label>
                            <input type="text" id="axiosHargaBarang" class="form-control" readonly
                                   style="border-radius: 12px; padding: 12px 18px; border: 2px solid #f1f5f9; background: #f1f5f9;">
                        </div>
                        <div class="form-group mb-4">
                            <label class="text-xs font-weight-bold text-uppercase text-muted mb-2 d-block" style="letter-spacing: 1px;">Jumlah</label>
                            <input type="number" id="axiosJumlah" class="form-control" min="1" value="1"
                                   style="border-radius: 12px; padding: 12px 18px; border: 2px solid #f1f5f9; background: #f8fafc;">
                        </div>
                        <button type="button" id="axiosBtnTambah" class="btn btn-success text-white font-weight-bold w-100" disabled
                                style="border-radius: 12px; padding: 12px;">
                            <i class="mdi mdi-cart-plus me-1"></i> Tambahkan ke Tabel
                        </button>
                    </div>
                </div>
            </div>

            {{-- Tabel & Bayar --}}
            <div class="col-lg-7">
                <div class="card border-0 shadow-sm h-100" style="border-radius: 20px;">
                    <div class="card-header bg-white border-0 pt-4 px-4 pb-0 d-flex justify-content-between align-items-center">
                        <span class="badge bg-soft-success text-success px-3 py-2 font-weight-bold" style="border-radius: 8px; font-size: 0.65rem; letter-spacing: 0.5px;">KERANJANG TRANSAKSI</span>
                        <i class="mdi mdi-receipt text-muted"></i>
                    </div>
                    <div class="card-body p-4 pt-3">
                        <div class="table-responsive">
                            <table class="table align-middle" id="axiosTabelKeranjang">
                                <thead style="background: #f0fdf4;">
                                    <tr>
                                        <th class="text-uppercase text-muted" style="font-size: 0.7rem; letter-spacing: 1px;">Kode</th>
                                        <th class="text-uppercase text-muted" style="font-size: 0.7rem; letter-spacing: 1px;">Nama</th>
                                        <th class="text-uppercase text-muted" style="font-size: 0.7rem; letter-spacing: 1px;">Harga</th>
                                        <th class="text-uppercase text-muted text-center" style="font-size: 0.7rem; letter-spacing: 1px;">Jumlah</th>
                                        <th class="text-uppercase text-muted text-end" style="font-size: 0.7rem; letter-spacing: 1px;">Subtotal</th>
                                        <th class="text-uppercase text-muted text-center" style="font-size: 0.7rem; letter-spacing: 1px;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr id="axiosEmptyRow">
                                        <td colspan="6" class="text-center text-muted py-4">
                                            <i class="mdi mdi-cart-outline" style="font-size: 2rem; opacity: 0.3;"></i>
                                            <div>Belum ada barang. Scan kode untuk memulai.</div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mt-3 p-3" style="background: linear-gradient(135deg, #f0fdf4, #dcfce7); border-radius: 16px;">
                            <div>
                                <small class="text-uppercase font-weight-bold text-success d-block" style="font-size: 0.65rem; letter-spacing: 1px;">Total Belanja</small>
                                <div class="h4 font-weight-bold mb-0 text-dark" id="axiosTotal">Rp 0</div>
                            </div>
                            <button type="button" id="axiosBtnBayar" class="btn btn-success text-white font-weight-bold px-5 py-3" disabled
                                    style="border-radius: 12px;">
                                <i class="mdi mdi-cash-multiple me-1"></i> Bayar
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .bg-soft-primary { background-color: #eef2ff !important; }
    .bg-soft-success { background-color: #f0fdf4 !important; }
    .nav-pills .nav-link {
        background: #f8fafc;
        color: #64748b;
        border: 2px solid #f1f5f9;
    }
    .nav-pills .nav-link.active {
        background: linear-gradient(135deg, #4f46e5, #7c3aed);
        color: #fff;
        border-color: transparent;
    }
    #posAxiosPane .nav-pills .nav-link.active,
    .nav-pills #pos-axios-tab.active {
        background: linear-gradient(135deg, #16a34a, #22c55e);
    }
</style>

@endsection

@push('js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
// =========================================================
// Endpoint URLs
// =========================================================
const POS_URL = {
    cari:   "{{ url('/admin/pos-kasir/cari') }}",   // + /{kode}
    simpan: "{{ route('admin.pos-kasir.simpan') }}"
};
const CSRF_TOKEN = "{{ csrf_token() }}";

// =========================================================
// Helper: format Rupiah
// =========================================================
function rupiah(n) {
    return 'Rp ' + Number(n || 0).toLocaleString('id-ID');
}

// =========================================================
// Tab 1: AJAX jQuery
// =========================================================
$(document).ready(function () {
    // State barang yang sedang ditemukan (siap untuk ditambahkan)
    let ajaxFoundItem = null;

    // Update enable/disable tombol Tambahkan
    function ajaxSyncBtnTambah() {
        const jumlah = parseInt($('#ajaxJumlah').val(), 10) || 0;
        const ok = ajaxFoundItem !== null && jumlah > 0;
        $('#ajaxBtnTambah').prop('disabled', !ok);
    }

    // Reset form input (kode, nama, harga, jumlah=1) tanpa membersihkan tabel
    function ajaxResetForm() {
        $('#ajaxKodeBarang').val('');
        $('#ajaxNamaBarang').val('');
        $('#ajaxHargaBarang').val('');
        $('#ajaxJumlah').val(1);
        ajaxFoundItem = null;
        ajaxSyncBtnTambah();
        $('#ajaxKodeBarang').focus();
    }

    // Reset seluruh halaman setelah pembayaran sukses
    function ajaxResetSemua() {
        ajaxResetForm();
        $('#ajaxTabelKeranjang tbody').html(`
            <tr id="ajaxEmptyRow">
                <td colspan="6" class="text-center text-muted py-4">
                    <i class="mdi mdi-cart-outline" style="font-size: 2rem; opacity: 0.3;"></i>
                    <div>Belum ada barang. Scan kode untuk memulai.</div>
                </td>
            </tr>
        `);
        ajaxHitungTotal();
    }

    // Hitung total dari semua subtotal di tabel
    function ajaxHitungTotal() {
        let total = 0;
        $('#ajaxTabelKeranjang tbody tr[data-kode]').each(function () {
            total += parseInt($(this).data('subtotal'), 10) || 0;
        });
        $('#ajaxTotal').text(rupiah(total));
        $('#ajaxBtnBayar').prop('disabled', total <= 0);
    }

    // Render ulang baris tabel berdasarkan data
    function ajaxRenderRow(data) {
        const subtotal = data.harga * data.jumlah;
        return `
            <tr data-kode="${data.id_barang}" data-harga="${data.harga}" data-subtotal="${subtotal}">
                <td><span class="font-weight-bold text-dark">${data.id_barang}</span></td>
                <td>${data.nama}</td>
                <td>${rupiah(data.harga)}</td>
                <td class="text-center" style="width: 110px;">
                    <input type="number" class="form-control form-control-sm ajax-row-jumlah text-center" min="1" value="${data.jumlah}" style="border-radius: 8px;">
                </td>
                <td class="text-end font-weight-bold ajax-row-subtotal">${rupiah(subtotal)}</td>
                <td class="text-center">
                    <button type="button" class="btn btn-sm btn-outline-danger ajax-row-hapus" style="border-radius: 8px;">
                        <i class="mdi mdi-delete"></i>
                    </button>
                </td>
            </tr>
        `;
    }

    // Tambah / merge baris ke tabel
    function ajaxTambahKeTabel(data) {
        // Hapus empty row jika ada
        $('#ajaxEmptyRow').remove();

        const $existing = $(`#ajaxTabelKeranjang tbody tr[data-kode="${data.id_barang}"]`);
        if ($existing.length) {
            // Kode sudah ada: update jumlah & subtotal
            const oldJumlah = parseInt($existing.find('.ajax-row-jumlah').val(), 10) || 0;
            const newJumlah = oldJumlah + data.jumlah;
            const harga = parseInt($existing.data('harga'), 10);
            const newSubtotal = harga * newJumlah;

            $existing.find('.ajax-row-jumlah').val(newJumlah);
            $existing.find('.ajax-row-subtotal').text(rupiah(newSubtotal));
            $existing.attr('data-subtotal', newSubtotal).data('subtotal', newSubtotal);
        } else {
            $('#ajaxTabelKeranjang tbody').append(ajaxRenderRow(data));
        }

        ajaxHitungTotal();
    }

    // -----------------------------------------------------
    // Event: tombol Tambahkan Tambah ke kerangjang
    // -----------------------------------------------------
    $('#ajaxBtnTambah').on('click', function () {
        if (!ajaxFoundItem) return;
        const jumlah = parseInt($('#ajaxJumlah').val(), 10) || 0;
        if (jumlah <= 0) return;

        ajaxTambahKeTabel({
            id_barang: ajaxFoundItem.id_barang,
            nama:      ajaxFoundItem.nama,
            harga:     ajaxFoundItem.harga,
            jumlah:    jumlah,
        });

        ajaxResetForm();
    });

    // -----------------------------------------------------
    // Event: input jumlah berubah -> sync tombol Tambah
    // -----------------------------------------------------
    $('#ajaxJumlah').on('input', ajaxSyncBtnTambah);

    // -----------------------------------------------------
    // Event: Enter di kode barang -> AJAX cari
    // -----------------------------------------------------
    $('#ajaxKodeBarang').on('keypress', function (e) {
        if (e.which !== 13) return;
        e.preventDefault();

        const kode = $(this).val().trim();
        if (!kode) return;

        $.ajax({
            url: POS_URL.cari + '/' + encodeURIComponent(kode),
            type: 'GET',
            dataType: 'json',
            success: function (response) {
                if (response.code === 200) {
                    ajaxFoundItem = response.data;
                    $('#ajaxNamaBarang').val(response.data.nama);
                    $('#ajaxHargaBarang').val(rupiah(response.data.harga));
                    $('#ajaxJumlah').val(1).focus().select();
                } else {
                    ajaxFoundItem = null;
                    $('#ajaxNamaBarang').val('');
                    $('#ajaxHargaBarang').val('');
                    Swal.fire({
                        icon: 'warning',
                        title: 'Tidak ditemukan',
                        text: response.message || 'Barang tidak ditemukan',
                        confirmButtonColor: '#4f46e5',
                    });
                }
                ajaxSyncBtnTambah();
            },
            error: function (xhr) {
                ajaxFoundItem = null;
                ajaxSyncBtnTambah();
                if (xhr.status === 404) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Tidak ditemukan',
                        text: 'Kode barang tidak terdaftar',
                        confirmButtonColor: '#4f46e5',
                    });
                } else {
                    console.error('AJAX error cari:', xhr.responseText);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Gagal mengambil data barang',
                        confirmButtonColor: '#4f46e5',
                    });
                }
            }
        });
    });

    // -----------------------------------------------------
    // Event delegation: edit jumlah pada baris tabel
    // -----------------------------------------------------
    $('#ajaxTabelKeranjang').on('input', '.ajax-row-jumlah', function () {
        const $row = $(this).closest('tr');
        let jumlah = parseInt($(this).val(), 10);
        if (isNaN(jumlah) || jumlah < 1) {
            jumlah = 1;
            $(this).val(1);
        }
        const harga = parseInt($row.data('harga'), 10) || 0;
        const subtotal = harga * jumlah;
        $row.find('.ajax-row-subtotal').text(rupiah(subtotal));
        $row.attr('data-subtotal', subtotal).data('subtotal', subtotal);
        ajaxHitungTotal();
    });

    // -----------------------------------------------------
    // Event delegation: hapus baris
    // -----------------------------------------------------
    $('#ajaxTabelKeranjang').on('click', '.ajax-row-hapus', function () {
        $(this).closest('tr').remove();
        // Jika kosong, kembalikan empty row
        if ($('#ajaxTabelKeranjang tbody tr[data-kode]').length === 0) {
            $('#ajaxTabelKeranjang tbody').html(`
                <tr id="ajaxEmptyRow">
                    <td colspan="6" class="text-center text-muted py-4">
                        <i class="mdi mdi-cart-outline" style="font-size: 2rem; opacity: 0.3;"></i>
                        <div>Belum ada barang. Scan kode untuk memulai.</div>
                    </td>
                </tr>
            `);
        }
        ajaxHitungTotal();
    });

    // -----------------------------------------------------
    // Event: tombol Bayar -> kirim transaksi via AJAX
    // -----------------------------------------------------
    $('#ajaxBtnBayar').on('click', function () {
        const items = [];
        let total = 0;
        $('#ajaxTabelKeranjang tbody tr[data-kode]').each(function () {
            const $row = $(this);
            const kode = $row.data('kode');
            const harga = parseInt($row.data('harga'), 10);
            const jumlah = parseInt($row.find('.ajax-row-jumlah').val(), 10) || 0;
            const subtotal = harga * jumlah;
            const nama = $row.find('td').eq(1).text();
            items.push({
                id_barang: kode,
                nama:      nama,
                harga:     harga,
                jumlah:    jumlah,
                subtotal:  subtotal,
            });
            total += subtotal;
        });

        if (items.length === 0) return;

        const $btn = $(this);
        $btn.prop('disabled', true).html('<i class="mdi mdi-loading mdi-spin me-1"></i> Memproses...');

        $.ajax({
            url: POS_URL.simpan,
            type: 'POST',
            dataType: 'json',
            data: {
                _token: CSRF_TOKEN,
                total:  total,
                items:  items,
            },
            success: function (response) {
                if (response.code === 200) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Pembayaran Berhasil',
                        html: `Transaksi #${response.data.idtransaksi} senilai <b>${rupiah(response.data.total)}</b> telah disimpan.`,
                        confirmButtonColor: '#4f46e5',
                    });
                    ajaxResetSemua();
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: response.message || 'Gagal menyimpan transaksi',
                        confirmButtonColor: '#4f46e5',
                    });
                }
            },
            error: function (xhr) {
                console.error('AJAX error bayar:', xhr.responseText);
                let msg = 'Gagal menyimpan transaksi';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    msg = xhr.responseJSON.message;
                }
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: msg,
                    confirmButtonColor: '#4f46e5',
                });
            },
            complete: function () {
                $btn.html('<i class="mdi mdi-cash-multiple me-1"></i> Bayar');
                ajaxHitungTotal();  // re-evaluate disabled state
            }
        });
    });

    // Init state
    ajaxSyncBtnTambah();
    ajaxHitungTotal();
});

// =========================================================
// Tab 2: Axios
// =========================================================
document.addEventListener('DOMContentLoaded', function () {
    // ---- DOM refs ----
    const elKode    = document.getElementById('axiosKodeBarang');
    const elNama    = document.getElementById('axiosNamaBarang');
    const elHarga   = document.getElementById('axiosHargaBarang');
    const elJumlah  = document.getElementById('axiosJumlah');
    const elBtnAdd  = document.getElementById('axiosBtnTambah');
    const elBtnPay  = document.getElementById('axiosBtnBayar');
    const elTbody   = document.querySelector('#axiosTabelKeranjang tbody');
    const elTotal   = document.getElementById('axiosTotal');

    let axiosFoundItem = null;

    // ---- Helpers ----
    function syncBtnTambah() {
        const jumlah = parseInt(elJumlah.value, 10) || 0;
        elBtnAdd.disabled = !(axiosFoundItem !== null && jumlah > 0);
    }

    function resetForm() {
        elKode.value = '';
        elNama.value = '';
        elHarga.value = '';
        elJumlah.value = 1;
        axiosFoundItem = null;
        syncBtnTambah();
        elKode.focus();
    }

    function emptyRowHtml() {
        return `
            <tr id="axiosEmptyRow">
                <td colspan="6" class="text-center text-muted py-4">
                    <i class="mdi mdi-cart-outline" style="font-size: 2rem; opacity: 0.3;"></i>
                    <div>Belum ada barang. Scan kode untuk memulai.</div>
                </td>
            </tr>
        `;
    }

    function resetSemua() {
        resetForm();
        elTbody.innerHTML = emptyRowHtml();
        hitungTotal();
    }

    function hitungTotal() {
        let total = 0;
        elTbody.querySelectorAll('tr[data-kode]').forEach((tr) => {
            total += parseInt(tr.dataset.subtotal, 10) || 0;
        });
        elTotal.textContent = rupiah(total);
        elBtnPay.disabled = total <= 0;
    }

    function rowHtml(data) {
        const subtotal = data.harga * data.jumlah;
        return `
            <tr data-kode="${data.id_barang}" data-harga="${data.harga}" data-subtotal="${subtotal}">
                <td><span class="font-weight-bold text-dark">${data.id_barang}</span></td>
                <td>${data.nama}</td>
                <td>${rupiah(data.harga)}</td>
                <td class="text-center" style="width: 110px;">
                    <input type="number" class="form-control form-control-sm axios-row-jumlah text-center" min="1" value="${data.jumlah}" style="border-radius: 8px;">
                </td>
                <td class="text-end font-weight-bold axios-row-subtotal">${rupiah(subtotal)}</td>
                <td class="text-center">
                    <button type="button" class="btn btn-sm btn-outline-danger axios-row-hapus" style="border-radius: 8px;">
                        <i class="mdi mdi-delete"></i>
                    </button>
                </td>
            </tr>
        `;
    }

    function tambahKeTabel(data) {
        // Hapus empty row
        const empty = document.getElementById('axiosEmptyRow');
        if (empty) empty.remove();

        const existing = elTbody.querySelector(`tr[data-kode="${data.id_barang}"]`);
        if (existing) {
            const inputJml = existing.querySelector('.axios-row-jumlah');
            const oldJumlah = parseInt(inputJml.value, 10) || 0;
            const newJumlah = oldJumlah + data.jumlah;
            const harga = parseInt(existing.dataset.harga, 10);
            const newSubtotal = harga * newJumlah;

            inputJml.value = newJumlah;
            existing.querySelector('.axios-row-subtotal').textContent = rupiah(newSubtotal);
            existing.dataset.subtotal = newSubtotal;
        } else {
            elTbody.insertAdjacentHTML('beforeend', rowHtml(data));
        }
        hitungTotal();
    }

    // ---- Event: tombol Tambahkan ----
    elBtnAdd.addEventListener('click', function () {
        if (!axiosFoundItem) return;
        const jumlah = parseInt(elJumlah.value, 10) || 0;
        if (jumlah <= 0) return;

        tambahKeTabel({
            id_barang: axiosFoundItem.id_barang,
            nama:      axiosFoundItem.nama,
            harga:     axiosFoundItem.harga,
            jumlah:    jumlah,
        });
        resetForm();
    });

    // ---- Event: jumlah berubah ----
    elJumlah.addEventListener('input', syncBtnTambah);

    // ---- Event: Enter di kode barang -> Axios cari ----
    elKode.addEventListener('keypress', function (e) {
        if (e.which !== 13) return;
        e.preventDefault();

        const kode = elKode.value.trim();
        if (!kode) return;

        axios.get(POS_URL.cari + '/' + encodeURIComponent(kode))
            .then((res) => {
                const r = res.data;
                if (r.code === 200) {
                    axiosFoundItem = r.data;
                    elNama.value = r.data.nama;
                    elHarga.value = rupiah(r.data.harga);
                    elJumlah.value = 1;
                    elJumlah.focus();
                    elJumlah.select();
                } else {
                    axiosFoundItem = null;
                    elNama.value = '';
                    elHarga.value = '';
                    Swal.fire({
                        icon: 'warning',
                        title: 'Tidak ditemukan',
                        text: r.message || 'Barang tidak ditemukan',
                        confirmButtonColor: '#22c55e',
                    });
                }
                syncBtnTambah();
            })
            .catch((err) => {
                axiosFoundItem = null;
                elNama.value = '';
                elHarga.value = '';
                syncBtnTambah();

                const status = err.response ? err.response.status : 0;
                if (status === 404) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Tidak ditemukan',
                        text: 'Kode barang tidak terdaftar',
                        confirmButtonColor: '#22c55e',
                    });
                } else {
                    console.error('Axios error cari:', err);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Gagal mengambil data barang',
                        confirmButtonColor: '#22c55e',
                    });
                }
            });
    });

    // ---- Event delegation: edit jumlah pada baris ----
    elTbody.addEventListener('input', function (e) {
        if (!e.target.classList.contains('axios-row-jumlah')) return;
        const tr = e.target.closest('tr');
        let jumlah = parseInt(e.target.value, 10);
        if (isNaN(jumlah) || jumlah < 1) {
            jumlah = 1;
            e.target.value = 1;
        }
        const harga = parseInt(tr.dataset.harga, 10) || 0;
        const subtotal = harga * jumlah;
        tr.querySelector('.axios-row-subtotal').textContent = rupiah(subtotal);
        tr.dataset.subtotal = subtotal;
        hitungTotal();
    });

    // ---- Event delegation: hapus baris ----
    elTbody.addEventListener('click', function (e) {
        const btn = e.target.closest('.axios-row-hapus');
        if (!btn) return;
        btn.closest('tr').remove();
        if (elTbody.querySelectorAll('tr[data-kode]').length === 0) {
            elTbody.innerHTML = emptyRowHtml();
        }
        hitungTotal();
    });

    // ---- Event: tombol Bayar ----
    elBtnPay.addEventListener('click', function () {
        const items = [];
        let total = 0;
        elTbody.querySelectorAll('tr[data-kode]').forEach((tr) => {
            const kode = tr.dataset.kode;
            const harga = parseInt(tr.dataset.harga, 10);
            const jumlah = parseInt(tr.querySelector('.axios-row-jumlah').value, 10) || 0;
            const subtotal = harga * jumlah;
            const nama = tr.cells[1].textContent;
            items.push({
                id_barang: kode,
                nama:      nama,
                harga:     harga,
                jumlah:    jumlah,
                subtotal:  subtotal,
            });
            total += subtotal;
        });

        if (items.length === 0) return;

        elBtnPay.disabled = true;
        elBtnPay.innerHTML = '<i class="mdi mdi-loading mdi-spin me-1"></i> Memproses...';

        axios.post(POS_URL.simpan, {
            total: total,
            items: items,
        }, {
            headers: {
                'X-CSRF-TOKEN': CSRF_TOKEN,
                'Accept': 'application/json',
            }
        })
        .then((res) => {
            const r = res.data;
            if (r.code === 200) {
                Swal.fire({
                    icon: 'success',
                    title: 'Pembayaran Berhasil',
                    html: `Transaksi #${r.data.idtransaksi} senilai <b>${rupiah(r.data.total)}</b> telah disimpan.`,
                    confirmButtonColor: '#22c55e',
                });
                resetSemua();
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: r.message || 'Gagal menyimpan transaksi',
                    confirmButtonColor: '#22c55e',
                });
            }
        })
        .catch((err) => {
            console.error('Axios error bayar:', err);
            let msg = 'Gagal menyimpan transaksi';
            if (err.response && err.response.data && err.response.data.message) {
                msg = err.response.data.message;
            }
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: msg,
                confirmButtonColor: '#22c55e',
            });
        })
        .finally(() => {
            elBtnPay.innerHTML = '<i class="mdi mdi-cash-multiple me-1"></i> Bayar';
            hitungTotal();
        });
    });

    // ---- Init ----
    syncBtnTambah();
    hitungTotal();
});
</script>
@endpush
