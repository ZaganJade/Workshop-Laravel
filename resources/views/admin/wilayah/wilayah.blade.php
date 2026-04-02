@extends('layouts.app')

@section('title', 'Manajemen Wilayah')

@push('css')
<!-- Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2/select2.min.css" rel="stylesheet" />
<style>
    .wilayah-card {
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 4px 24px rgba(0,0,0,0.08);
        padding: 28px;
        margin-bottom: 24px;
    }
    .wilayah-card h5 {
        font-weight: 700;
        margin-bottom: 20px;
        color: #1a1a2e;
        font-size: 1.1rem;
    }
    .wilayah-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 28px;
    }
    @media (max-width: 768px) {
        .wilayah-grid {
            grid-template-columns: 1fr;
        }
    }
    .wilayah-input {
        width: 100%;
        padding: 10px 14px;
        border: 1.5px solid #e0e0e0;
        border-radius: 8px;
        font-size: 0.95rem;
        transition: border-color 0.2s;
        outline: none;
    }
    .wilayah-input:focus {
        border-color: #7c3aed;
        box-shadow: 0 0 0 3px rgba(124, 58, 237, 0.1);
    }
    .wilayah-btn {
        background: linear-gradient(135deg, #7c3aed, #6d28d9);
        color: #fff;
        border: none;
        padding: 10px 22px;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
        font-size: 0.95rem;
    }
    .wilayah-btn:hover {
        background: linear-gradient(135deg, #6d28d9, #5b21b6);
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(124, 58, 237, 0.3);
    }
    .wilayah-select {
        width: 100%;
        padding: 10px 14px;
        border: 1.5px solid #e0e0e0;
        border-radius: 8px;
        font-size: 0.95rem;
        background: #fafafa;
        outline: none;
        transition: border-color 0.2s;
    }
    .wilayah-select:focus {
        border-color: #7c3aed;
    }
    .wilayah-result {
        margin-top: 16px;
        padding: 14px;
        background: linear-gradient(135deg, #f5f3ff, #ede9fe);
        border-radius: 8px;
        border-left: 4px solid #7c3aed;
        font-size: 0.95rem;
        color: #4c1d95;
        min-height: 48px;
    }
    .wilayah-result strong {
        display: block;
        margin-bottom: 4px;
        font-size: 0.85rem;
        color: #6d28d9;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .input-group {
        display: flex;
        gap: 10px;
        margin-bottom: 16px;
    }
    .input-group .wilayah-input {
        flex: 1;
    }
    .label-text {
        display: block;
        font-weight: 600;
        margin-bottom: 8px;
        color: #374151;
        font-size: 0.9rem;
    }
    .card-badge {
        display: inline-block;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 16px;
    }
    .badge-native {
        background: #dbeafe;
        color: #1d4ed8;
    }
    .badge-select2 {
        background: #dcfce7;
        color: #15803d;
    }

    /* Select2 custom styling */
    .select2-container--default .select2-selection--single {
        height: 44px;
        border: 1.5px solid #e0e0e0;
        border-radius: 8px;
        padding: 6px 14px;
        background: #fafafa;
    }
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 30px;
        color: #374151;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 42px;
    }
    .select2-container--default .select2-results__option--highlighted[aria-selected] {
        background: #7c3aed;
    }
    .select2-dropdown {
        border: 1.5px solid #e0e0e0;
        border-radius: 8px;
        box-shadow: 0 8px 24px rgba(0,0,0,0.1);
    }
</style>
@endpush

@section('content')

<div class="page-header">
    <h3 class="page-title">
        <span class="page-title-icon bg-gradient-primary text-white me-2">
            <i class="mdi mdi-map-marker"></i>
        </span>
        Manajemen Wilayah
    </h3>
</div>

<div class="wilayah-grid">

    {{-- Card 1: Native Select --}}
    <div class="wilayah-card">
        <span class="card-badge badge-native">Native Select</span>
        <h5><i class="mdi mdi-form-dropdown"></i> Select Wilayah</h5>

        <label class="label-text" for="inputWilayah1">Nama Wilayah</label>
        <div class="input-group">
            <input type="text" id="inputWilayah1" class="wilayah-input" placeholder="Masukkan nama wilayah...">
            <button type="button" id="btnTambah1" class="wilayah-btn">
                <i class="mdi mdi-plus"></i> Tambahkan
            </button>
        </div>

        <label class="label-text" for="selectWilayah1">Pilih Wilayah</label>
        <select id="selectWilayah1" class="wilayah-select">
            <option value="">-- Pilih Wilayah --</option>
        </select>

        <div class="wilayah-result">
            <strong>Wilayah Terpilih</strong>
            <span id="hasilWilayah1">-</span>
        </div>
    </div>

    {{-- Card 2: Select2 --}}
    <div class="wilayah-card">
        <span class="card-badge badge-select2">Select2</span>
        <h5><i class="mdi mdi-form-select"></i> Select2 Wilayah</h5>

        <label class="label-text" for="inputWilayah2">Nama Wilayah</label>
        <div class="input-group">
            <input type="text" id="inputWilayah2" class="wilayah-input" placeholder="Masukkan nama wilayah...">
            <button type="button" id="btnTambah2" class="wilayah-btn">
                <i class="mdi mdi-plus"></i> Tambahkan
            </button>
        </div>

        <label class="label-text" for="selectWilayah2">Pilih Wilayah</label>
        <select id="selectWilayah2" class="wilayah-select" style="width: 100%;">
            <option value="">-- Pilih Wilayah --</option>
        </select>

        <div class="wilayah-result">
            <strong>Wilayah Terpilih</strong>
            <span id="hasilWilayah2">-</span>
        </div>
    </div>

</div>

@endsection

@push('js')
<!-- jQuery CDN -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
$(document).ready(function() {

    // Card 1: Native Select
    $('#btnTambah1').click(function() {
        let wilayah = $('#inputWilayah1').val().trim();
        if (wilayah !== '') {
            $('#selectWilayah1').append(`<option value="${wilayah}">${wilayah}</option>`);
            $('#inputWilayah1').val('');
        }
    });

    $('#selectWilayah1').change(function() {
        $('#hasilWilayah1').text($(this).val());
    });

    // Card 2: Select2
    $('#selectWilayah2').select2({
        placeholder: '-- Pilih Wilayah --',
        allowClear: true
    });

    $('#btnTambah2').click(function() {
        let wilayah = $('#inputWilayah2').val().trim();
        if (wilayah !== '') {
            $('#selectWilayah2').append(new Option(wilayah, wilayah)).trigger('change');
            $('#inputWilayah2').val('');
        }
    });

    $('#selectWilayah2').change(function() {
        $('#hasilWilayah2').text($(this).val());
    });

    // Enter key support
    $('#inputWilayah1').keypress(function(e) {
        if (e.which === 13) $('#btnTambah1').click();
    });
    $('#inputWilayah2').keypress(function(e) {
        if (e.which === 13) $('#btnTambah2').click();
    });

});
</script>
@endpush
