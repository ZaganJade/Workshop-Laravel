@extends('layouts.app')

@section('title', 'Wilayah Cascading')

@section('content')

<div class="modern-page-header">
    <h3>
        <div class="modern-header-icon">
            <i class="mdi mdi-map-marker-multiple"></i>
        </div>
        Wilayah Administrasi Indonesia
    </h3>
    <div style="font-size: 0.8rem; color: #6b7280; font-weight: 600; background: #f3f4f6; padding: 6px 16px; border-radius: 50px;">
        <i class="mdi mdi-vector-link me-1 text-primary"></i> Cascading Select &mdash; AJAX & Axios
    </div>
</div>

{{-- Tab Switcher: AJAX vs Axios --}}
<ul class="nav nav-pills mb-4 gap-2" id="cascadeTab" role="tablist">
    <li class="nav-item" role="presentation">
        <button class="nav-link active font-weight-bold px-4 py-2" id="ajax-tab" data-bs-toggle="pill" data-bs-target="#ajaxPane" type="button" role="tab" style="border-radius: 12px; font-size: 0.8rem; letter-spacing: 0.5px;">
            <i class="mdi mdi-jquery me-1"></i> AJAX jQuery
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link font-weight-bold px-4 py-2" id="axios-tab" data-bs-toggle="pill" data-bs-target="#axiosPane" type="button" role="tab" style="border-radius: 12px; font-size: 0.8rem; letter-spacing: 0.5px;">
            <i class="mdi mdi-language-javascript me-1"></i> Axios
        </button>
    </li>
</ul>

<div class="tab-content" id="cascadeTabContent">
    {{-- ===================== AJAX Pane ===================== --}}
    <div class="tab-pane fade show active" id="ajaxPane" role="tabpanel">
        <div class="card border-0 shadow-sm" style="border-radius: 20px;">
            <div class="card-header bg-white border-0 pt-4 px-4 pb-0 d-flex justify-content-between align-items-center">
                <span class="badge bg-soft-primary text-primary px-3 py-2 font-weight-bold" style="border-radius: 8px; font-size: 0.65rem; letter-spacing: 0.5px;">AJAX JQUERY</span>
                <i class="mdi mdi-dots-horizontal text-muted"></i>
            </div>
            <div class="card-body p-4 pt-3">
                <h5 class="font-weight-bold mb-4 text-dark"><i class="mdi mdi-map-search me-2 text-primary"></i>Pilih Wilayah Anda</h5>

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="text-xs font-weight-bold text-uppercase text-muted mb-2 d-block" style="letter-spacing: 1px;">Level 1: Provinsi</label>
                        <select id="ajaxProvinsi" class="form-select" style="border-radius: 12px; padding: 12px 18px; border: 2px solid #f1f5f9; background: #f8fafc;">
                            <option value="0">-- Pilih Provinsi --</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="text-xs font-weight-bold text-uppercase text-muted mb-2 d-block" style="letter-spacing: 1px;">Level 2: Kota / Kabupaten</label>
                        <select id="ajaxKota" class="form-select" style="border-radius: 12px; padding: 12px 18px; border: 2px solid #f1f5f9; background: #f8fafc;">
                            <option value="0">-- Pilih Kota --</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="text-xs font-weight-bold text-uppercase text-muted mb-2 d-block" style="letter-spacing: 1px;">Level 3: Kecamatan</label>
                        <select id="ajaxKecamatan" class="form-select" style="border-radius: 12px; padding: 12px 18px; border: 2px solid #f1f5f9; background: #f8fafc;">
                            <option value="0">-- Pilih Kecamatan --</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="text-xs font-weight-bold text-uppercase text-muted mb-2 d-block" style="letter-spacing: 1px;">Level 4: Kelurahan</label>
                        <select id="ajaxKelurahan" class="form-select" style="border-radius: 12px; padding: 12px 18px; border: 2px solid #f1f5f9; background: #f8fafc;">
                            <option value="0">-- Pilih Kelurahan --</option>
                        </select>
                    </div>
                </div>

                <div class="mt-4 p-4" style="background: linear-gradient(135deg, #f8fafc, #f1f5f9); border-radius: 16px; border-left: 4px solid var(--primary-indigo, #4f46e5);">
                    <small class="text-uppercase font-weight-bold text-muted mb-1 d-block" style="font-size: 0.6rem; letter-spacing: 1px;">Alamat Lengkap</small>
                    <div class="h6 font-weight-bold mb-0 text-dark" id="ajaxHasil">-</div>
                </div>
            </div>
        </div>
    </div>

    {{-- ===================== Axios Pane ===================== --}}
    <div class="tab-pane fade" id="axiosPane" role="tabpanel">
        <div class="card border-0 shadow-sm" style="border-radius: 20px;">
            <div class="card-header bg-white border-0 pt-4 px-4 pb-0 d-flex justify-content-between align-items-center">
                <span class="badge bg-soft-success text-success px-3 py-2 font-weight-bold" style="border-radius: 8px; font-size: 0.65rem; letter-spacing: 0.5px;">AXIOS PROMISE</span>
                <i class="mdi mdi-dots-horizontal text-muted"></i>
            </div>
            <div class="card-body p-4 pt-3">
                <h5 class="font-weight-bold mb-4 text-dark"><i class="mdi mdi-map-marker-path me-2 text-success"></i>Pilih Wilayah Anda</h5>

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="text-xs font-weight-bold text-uppercase text-muted mb-2 d-block" style="letter-spacing: 1px;">Level 1: Provinsi</label>
                        <select id="axiosProvinsi" class="form-select" style="border-radius: 12px; padding: 12px 18px; border: 2px solid #f1f5f9; background: #f8fafc;">
                            <option value="0">-- Pilih Provinsi --</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="text-xs font-weight-bold text-uppercase text-muted mb-2 d-block" style="letter-spacing: 1px;">Level 2: Kota / Kabupaten</label>
                        <select id="axiosKota" class="form-select" style="border-radius: 12px; padding: 12px 18px; border: 2px solid #f1f5f9; background: #f8fafc;">
                            <option value="0">-- Pilih Kota --</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="text-xs font-weight-bold text-uppercase text-muted mb-2 d-block" style="letter-spacing: 1px;">Level 3: Kecamatan</label>
                        <select id="axiosKecamatan" class="form-select" style="border-radius: 12px; padding: 12px 18px; border: 2px solid #f1f5f9; background: #f8fafc;">
                            <option value="0">-- Pilih Kecamatan --</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="text-xs font-weight-bold text-uppercase text-muted mb-2 d-block" style="letter-spacing: 1px;">Level 4: Kelurahan</label>
                        <select id="axiosKelurahan" class="form-select" style="border-radius: 12px; padding: 12px 18px; border: 2px solid #f1f5f9; background: #f8fafc;">
                            <option value="0">-- Pilih Kelurahan --</option>
                        </select>
                    </div>
                </div>

                <div class="mt-4 p-4" style="background: linear-gradient(135deg, #f0fdf4, #dcfce7); border-radius: 16px; border-left: 4px solid #22c55e;">
                    <small class="text-uppercase font-weight-bold text-success mb-1 d-block" style="font-size: 0.6rem; letter-spacing: 1px;">Alamat Lengkap</small>
                    <div class="h6 font-weight-bold mb-0 text-dark" id="axiosHasil">-</div>
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
</style>

@endsection

@push('js')
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
// =========================================================
// Endpoint URLs (dari Laravel route)
// =========================================================
const WILAYAH_URL = {
    provinsi:  "{{ route('admin.wilayah-cascade.provinsi') }}",
    kota:      "{{ route('admin.wilayah-cascade.kota') }}",
    kecamatan: "{{ route('admin.wilayah-cascade.kecamatan') }}",
    kelurahan: "{{ route('admin.wilayah-cascade.kelurahan') }}"
};

// =========================================================
// Helper: reset select ke state default + disable
// =========================================================
function resetSelect($el, placeholder) {
    $el.html(`<option value="0">${placeholder}</option>`).val('0').prop('disabled', true);
}

function fillSelect($el, items, placeholder) {
    let html = `<option value="0">${placeholder}</option>`;
    items.forEach(function (item) {
        html += `<option value="${item.id}">${item.name}</option>`;
    });
    $el.html(html).prop('disabled', false);
}

// Update tampilan alamat lengkap berdasarkan teks terpilih.
function updateHasil(prefix) {
    const get = (id) => {
        const $sel = $('#' + id);
        return $sel.val() && $sel.val() !== '0' ? $sel.find('option:selected').text() : null;
    };
    const parts = [
        get(prefix + 'Kelurahan'),
        get(prefix + 'Kecamatan'),
        get(prefix + 'Kota'),
        get(prefix + 'Provinsi'),
    ].filter(Boolean);
    $('#' + prefix + 'Hasil').text(parts.length ? parts.join(', ') : '-');
}

// =========================================================
// Tab 1: AJAX jQuery
// =========================================================
$(document).ready(function () {
    // Initial state: kosongi semua kecuali Provinsi
    resetSelect($('#ajaxKota'),       '-- Pilih Kota --');
    resetSelect($('#ajaxKecamatan'),  '-- Pilih Kecamatan --');
    resetSelect($('#ajaxKelurahan'),  '-- Pilih Kelurahan --');

    // Load Provinsi sekali di awal
    $.ajax({
        url: WILAYAH_URL.provinsi,
        type: 'GET',
        dataType: 'json',
        success: function (response) {
            if (response.code === 200) {
                fillSelect($('#ajaxProvinsi'), response.data, '-- Pilih Provinsi --');
            } else {
                console.error('Gagal load provinsi:', response.message);
            }
        },
        error: function (xhr) {
            console.error('AJAX error provinsi:', xhr.responseText);
        }
    });

    // Provinsi diubah -> load Kota, reset Kec & Kel
    $('#ajaxProvinsi').on('change', function () {
        const provinceId = $(this).val();
        resetSelect($('#ajaxKota'),       '-- Pilih Kota --');
        resetSelect($('#ajaxKecamatan'),  '-- Pilih Kecamatan --');
        resetSelect($('#ajaxKelurahan'),  '-- Pilih Kelurahan --');
        updateHasil('ajax');

        if (provinceId === '0') return;

        $.ajax({
            url: WILAYAH_URL.kota,
            type: 'GET',
            data: { province_id: provinceId },
            dataType: 'json',
            success: function (response) {
                if (response.code === 200) {
                    fillSelect($('#ajaxKota'), response.data, '-- Pilih Kota --');
                } else {
                    console.error('Gagal load kota:', response.message);
                }
            },
            error: function (xhr) {
                console.error('AJAX error kota:', xhr.responseText);
            }
        });
    });

    // Kota diubah -> load Kecamatan, reset Kel
    $('#ajaxKota').on('change', function () {
        const regencyId = $(this).val();
        resetSelect($('#ajaxKecamatan'),  '-- Pilih Kecamatan --');
        resetSelect($('#ajaxKelurahan'),  '-- Pilih Kelurahan --');
        updateHasil('ajax');

        if (regencyId === '0') return;

        $.ajax({
            url: WILAYAH_URL.kecamatan,
            type: 'GET',
            data: { regency_id: regencyId },
            dataType: 'json',
            success: function (response) {
                if (response.code === 200) {
                    fillSelect($('#ajaxKecamatan'), response.data, '-- Pilih Kecamatan --');
                } else {
                    console.error('Gagal load kecamatan:', response.message);
                }
            },
            error: function (xhr) {
                console.error('AJAX error kecamatan:', xhr.responseText);
            }
        });
    });

    // Kecamatan diubah -> load Kelurahan
    $('#ajaxKecamatan').on('change', function () {
        const districtId = $(this).val();
        resetSelect($('#ajaxKelurahan'), '-- Pilih Kelurahan --');
        updateHasil('ajax');

        if (districtId === '0') return;

        $.ajax({
            url: WILAYAH_URL.kelurahan,
            type: 'GET',
            data: { district_id: districtId },
            dataType: 'json',
            success: function (response) {
                if (response.code === 200) {
                    fillSelect($('#ajaxKelurahan'), response.data, '-- Pilih Kelurahan --');
                } else {
                    console.error('Gagal load kelurahan:', response.message);
                }
            },
            error: function (xhr) {
                console.error('AJAX error kelurahan:', xhr.responseText);
            }
        });
    });

    // Kelurahan diubah -> update hasil saja
    $('#ajaxKelurahan').on('change', function () {
        updateHasil('ajax');
    });
});

// =========================================================
// Tab 2: Axios
// =========================================================
document.addEventListener('DOMContentLoaded', function () {
    const elProv = document.getElementById('axiosProvinsi');
    const elKota = document.getElementById('axiosKota');
    const elKec  = document.getElementById('axiosKecamatan');
    const elKel  = document.getElementById('axiosKelurahan');
    const elHasil = document.getElementById('axiosHasil');

    // Helper: reset native <select> ke placeholder + disable
    function resetSel(el, placeholder) {
        el.innerHTML = `<option value="0">${placeholder}</option>`;
        el.value = '0';
        el.disabled = true;
    }

    // Helper: isi <select> dari array {id, name}
    function fillSel(el, items, placeholder) {
        let html = `<option value="0">${placeholder}</option>`;
        items.forEach((item) => {
            html += `<option value="${item.id}">${item.name}</option>`;
        });
        el.innerHTML = html;
        el.disabled = false;
    }

    // Helper: ambil text option terpilih, atau null jika value = '0'
    function selectedText(el) {
        if (!el.value || el.value === '0') return null;
        return el.options[el.selectedIndex].text;
    }

    function updateHasil() {
        const parts = [
            selectedText(elKel),
            selectedText(elKec),
            selectedText(elKota),
            selectedText(elProv),
        ].filter(Boolean);
        elHasil.textContent = parts.length ? parts.join(', ') : '-';
    }

    // ---- Initial state ----
    resetSel(elKota, '-- Pilih Kota --');
    resetSel(elKec,  '-- Pilih Kecamatan --');
    resetSel(elKel,  '-- Pilih Kelurahan --');

    // ---- Load Provinsi ----
    axios.get(WILAYAH_URL.provinsi)
        .then((res) => {
            if (res.data.code === 200) {
                fillSel(elProv, res.data.data, '-- Pilih Provinsi --');
            } else {
                console.error('Axios gagal load provinsi:', res.data.message);
            }
        })
        .catch((err) => {
            console.error('Axios error provinsi:', err);
        });

    // ---- Provinsi change -> load Kota, reset Kec & Kel ----
    elProv.addEventListener('change', function () {
        const provinceId = this.value;
        resetSel(elKota, '-- Pilih Kota --');
        resetSel(elKec,  '-- Pilih Kecamatan --');
        resetSel(elKel,  '-- Pilih Kelurahan --');
        updateHasil();

        if (provinceId === '0') return;

        axios.get(WILAYAH_URL.kota, { params: { province_id: provinceId } })
            .then((res) => {
                if (res.data.code === 200) {
                    fillSel(elKota, res.data.data, '-- Pilih Kota --');
                } else {
                    console.error('Axios gagal load kota:', res.data.message);
                }
            })
            .catch((err) => console.error('Axios error kota:', err));
    });

    // ---- Kota change -> load Kecamatan, reset Kel ----
    elKota.addEventListener('change', function () {
        const regencyId = this.value;
        resetSel(elKec, '-- Pilih Kecamatan --');
        resetSel(elKel, '-- Pilih Kelurahan --');
        updateHasil();

        if (regencyId === '0') return;

        axios.get(WILAYAH_URL.kecamatan, { params: { regency_id: regencyId } })
            .then((res) => {
                if (res.data.code === 200) {
                    fillSel(elKec, res.data.data, '-- Pilih Kecamatan --');
                } else {
                    console.error('Axios gagal load kecamatan:', res.data.message);
                }
            })
            .catch((err) => console.error('Axios error kecamatan:', err));
    });

    // ---- Kecamatan change -> load Kelurahan ----
    elKec.addEventListener('change', function () {
        const districtId = this.value;
        resetSel(elKel, '-- Pilih Kelurahan --');
        updateHasil();

        if (districtId === '0') return;

        axios.get(WILAYAH_URL.kelurahan, { params: { district_id: districtId } })
            .then((res) => {
                if (res.data.code === 200) {
                    fillSel(elKel, res.data.data, '-- Pilih Kelurahan --');
                } else {
                    console.error('Axios gagal load kelurahan:', res.data.message);
                }
            })
            .catch((err) => console.error('Axios error kelurahan:', err));
    });

    // ---- Kelurahan change -> update hasil ----
    elKel.addEventListener('change', updateHasil);
});
</script>
@endpush
