@extends('layouts.app')

@section('title', 'Manajemen Wilayah')

@section('content')

<div class="modern-page-header">
    <h3>
        <div class="modern-header-icon">
            <i class="mdi mdi-map-marker-radius"></i>
        </div>
        Simulasi Manajemen Wilayah
    </h3>
    <div style="font-size: 0.8rem; color: #6b7280; font-weight: 600; background: #f3f4f6; padding: 6px 16px; border-radius: 50px;">
        <i class="mdi mdi-console me-1 text-primary"></i> Client-side Simulation
    </div>
</div>

<div class="row g-4 overflow-hidden">
    {{-- Card 1: Native Select --}}
    <div class="col-md-6">
        <div class="card h-100 border-0 shadow-sm" style="border-radius: 20px;">
            <div class="card-header bg-white border-0 pt-4 px-4 pb-0 d-flex justify-content-between align-items-center">
                <span class="badge bg-soft-primary text-primary px-3 py-2 font-weight-bold" style="border-radius: 8px; font-size: 0.65rem; letter-spacing: 0.5px;">NATIVE SELECT</span>
                <i class="mdi mdi-dots-horizontal text-muted"></i>
            </div>
            <div class="card-body p-4 pt-3">
                <h5 class="font-weight-bold mb-4 text-dark"><i class="mdi mdi-form-select me-2 text-primary"></i>Input & Pilih Wilayah</h5>
                
                <div class="form-group mb-4">
                    <label class="text-xs font-weight-bold text-uppercase text-muted mb-2 d-block" style="letter-spacing: 1px;">Tambah Wilayah Baru</label>
                    <div class="input-group">
                        <input type="text" id="inputWilayah1" class="form-control" placeholder="Masukkan nama wilayah..." 
                               style="border-radius: 12px 0 0 12px; padding: 12px 18px; border: 2px solid #f1f5f9; background: #f8fafc;">
                        <button type="button" id="btnTambah1" class="btn btn-gradient-primary font-weight-bold px-4" style="border-radius: 0 12px 12px 0;">
                            <i class="mdi mdi-plus"></i>
                        </button>
                    </div>
                </div>

                <div class="form-group mb-4">
                    <label class="text-xs font-weight-bold text-uppercase text-muted mb-2 d-block" style="letter-spacing: 1px;">Daftar Wilayah</label>
                    <select id="selectWilayah1" class="form-select" style="border-radius: 12px; padding: 12px 18px; border: 2px solid #f1f5f9; background: #f8fafc;">
                        <option value="">-- Pilih Wilayah --</option>
                    </select>
                </div>

                <div class="mt-4 p-4" style="background: linear-gradient(135deg, #f8fafc, #f1f5f9); border-radius: 16px; border-left: 4px solid var(--primary-indigo);">
                    <small class="text-uppercase font-weight-bold text-muted mb-1 d-block" style="font-size: 0.6rem; letter-spacing: 1px;">Hasil Seleksi</small>
                    <div class="h5 font-weight-bold mb-0 text-dark" id="hasilWilayah1">-</div>
                </div>
            </div>
        </div>
    </div>

    {{-- Card 2: Select2 --}}
    <div class="col-md-6">
        <div class="card h-100 border-0 shadow-sm" style="border-radius: 20px;">
            <div class="card-header bg-white border-0 pt-4 px-4 pb-0 d-flex justify-content-between align-items-center">
                <span class="badge bg-soft-success text-success px-3 py-2 font-weight-bold" style="border-radius: 8px; font-size: 0.65rem; letter-spacing: 0.5px;">SELECT2 JQUERY</span>
                <i class="mdi mdi-dots-horizontal text-muted"></i>
            </div>
            <div class="card-body p-4 pt-3">
                <h5 class="font-weight-bold mb-4 text-dark"><i class="mdi mdi-layers-outline me-2 text-success"></i>Advanced Wilayah Search</h5>
                
                <div class="form-group mb-4">
                    <label class="text-xs font-weight-bold text-uppercase text-muted mb-2 d-block" style="letter-spacing: 1px;">Registrasi Nama Lokasi</label>
                    <div class="input-group">
                        <input type="text" id="inputWilayah2" class="form-control" placeholder="Ketik nama lokasi..." 
                               style="border-radius: 12px 0 0 12px; padding: 12px 18px; border: 2px solid #f1f5f9; background: #f8fafc;">
                        <button type="button" id="btnTambah2" class="btn btn-success text-white font-weight-bold px-4" style="border-radius: 0 12px 12px 0;">
                            <i class="mdi mdi-playlist-plus"></i>
                        </button>
                    </div>
                </div>

                <div class="form-group mb-4">
                    <label class="text-xs font-weight-bold text-uppercase text-muted mb-2 d-block" style="letter-spacing: 1px;">Pencarian Pintar</label>
                    <select id="selectWilayah2" class="form-select" style="width: 100%;">
                        <option value="">-- Pilih Wilayah --</option>
                    </select>
                </div>

                <div class="mt-4 p-4" style="background: linear-gradient(135deg, #f0fdf4, #dcfce7); border-radius: 16px; border-left: 4px solid #22c55e;">
                    <small class="text-uppercase font-weight-bold text-success mb-1 d-block" style="font-size: 0.6rem; letter-spacing: 1px;">Lokasi Terkunci</small>
                    <div class="h5 font-weight-bold mb-0 text-dark" id="hasilWilayah2">-</div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .bg-soft-primary { background-color: #eef2ff !important; }
    .bg-soft-success { background-color: #f0fdf4 !important; }
    
    /* Select2 Skinning */
    .select2-container--default .select2-selection--single {
        height: 50px !important;
        border: 2px solid #f1f5f9 !important;
        border-radius: 12px !important;
        background-color: #f8fafc !important;
        padding: 10px 14px !important;
    }
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        color: #334155 !important;
        line-height: 28px !important;
        font-weight: 500 !important;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 48px !important;
        right: 10px !important;
    }
    .select2-dropdown {
        border: 1px solid #e2e8f0 !important;
        border-radius: 12px !important;
        box-shadow: 0 10px 25px rgba(0,0,0,0.1) !important;
        overflow: hidden !important;
    }
</style>
@endsection

@push('js')
<!-- Select2 CSS/JS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
$(document).ready(function() {
    // Card 1: Native Select logic
    $('#btnTambah1').click(function() {
        let wilayah = $('#inputWilayah1').val().trim();
        if (wilayah !== '') {
            $('#selectWilayah1').append(`<option value="${wilayah}">${wilayah}</option>`);
            $('#inputWilayah1').val('');
        }
    });

    $('#selectWilayah1').change(function() {
        $('#hasilWilayah1').hide().text($(this).val() || '-').fadeIn();
    });

    // Card 2: Select2 logic
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
        $('#hasilWilayah2').hide().text($(this).val() || '-').fadeIn();
    });

    // Enter key support
    $('#inputWilayah1, #inputWilayah2').keypress(function(e) {
        if (e.which === 13) {
            let id = $(this).attr('id');
            if (id === 'inputWilayah1') $('#btnTambah1').click();
            else $('#btnTambah2').click();
        }
    });
});
</script>
@endpush
