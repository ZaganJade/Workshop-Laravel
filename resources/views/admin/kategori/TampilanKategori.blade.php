@extends('layouts.app')

@section('title', 'Manajemen Kategori')

@section('content')
<div class="modern-page-header">
    <h3>
        <div class="modern-header-icon">
            <i class="mdi mdi-tag-outline"></i>
        </div>
        Manajemen Kategori
    </h3>
    <button type="button" onclick="openModal('modalTambahKategori')" class="btn btn-gradient-primary btn-md font-weight-bold" style="border-radius: 12px; padding: 12px 24px;">
        <i class="mdi mdi-plus me-1"></i> Tambah Kategori
    </button>
</div>

<div class="card">
    <div class="card-body p-4">
        <div class="table-responsive">
            <table id="kategoriTable" class="display w-100">
                <thead>
                    <tr>
                        <th style="width: 80px;">No</th>
                        <th>Nama Kategori</th>
                        <th class="text-center" style="width: 150px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($kategori as $index => $item)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div style="width: 10px; height: 10px; border-radius: 50%; background: var(--primary-violet); margin-right: 12px;"></div>
                                <span class="font-weight-bold text-dark">{{ $item->nama_kategori }}</span>
                            </div>
                        </td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-2">
                                <button type="button" 
                                        class="btn btn-inverse-info btn-icon btn-sm btn-edit-kategori"
                                        data-id="{{ $item->idkategori }}"
                                        data-name="{{ $item->nama_kategori }}"
                                        data-url="{{ route('admin.kategori.update', $item->idkategori) }}"
                                        title="Edit">
                                    <i class="mdi mdi-pencil"></i>
                                </button>
                                <form action="{{ route('admin.kategori.destroy', $item->idkategori) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-inverse-danger btn-icon btn-sm" onclick="return confirm('Hapus kategori ini?')" title="Hapus">
                                        <i class="mdi mdi-delete"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Modal Tambah --}}
<div class="modal fade" id="modalTambahKategori" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content" style="border-radius: 24px; border: none; overflow: hidden;">
            <div class="modal-header border-0 p-4" style="background: linear-gradient(135deg, var(--primary-indigo), var(--primary-violet)); color: white;">
                <h5 class="modal-title font-weight-bold"><i class="mdi mdi-plus-circle-outline me-2"></i>Tambah Kategori Baru</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.kategori.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="form-group mb-0">
                        <label class="font-weight-bold text-dark mb-2">Nama Kategori</label>
                        <input type="text" class="form-control" name="nama_kategori" placeholder="Misal: Fiksi, Eksperimen" required 
                               style="border-radius: 12px; padding: 14px; border: 2px solid #f1f5f9; background: #f8fafc;">
                    </div>
                </div>
                <div class="modal-footer border-0 p-4 pt-0">
                    <button type="button" class="btn btn-light font-weight-bold" data-bs-dismiss="modal" style="border-radius: 12px; padding: 12px 24px;">Batal</button>
                    <button type="submit" class="btn btn-gradient-primary font-weight-bold" style="border-radius: 12px; padding: 12px 24px;">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Modal Edit --}}
<div class="modal fade" id="modalEditKategori" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content" style="border-radius: 24px; border: none; overflow: hidden;">
            <div class="modal-header border-0 p-4 bg-info text-white">
                <h5 class="modal-title font-weight-bold"><i class="mdi mdi-pencil-outline me-2"></i>Perbarui Kategori</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formEditKategori" action="" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body p-4">
                    <div class="form-group mb-0">
                        <label class="font-weight-bold text-dark mb-2">Nama Kategori</label>
                        <input type="text" class="form-control" id="edit_nama_kategori" name="nama_kategori" required 
                               style="border-radius: 12px; padding: 14px; border: 2px solid #f1f5f9; background: #f8fafc;">
                    </div>
                </div>
                <div class="modal-footer border-0 p-4 pt-0">
                    <button type="button" class="btn btn-light font-weight-bold" data-bs-dismiss="modal" style="border-radius: 12px; padding: 12px 24px;">Batal</button>
                    <button type="submit" class="btn btn-info text-white font-weight-bold" style="border-radius: 12px; padding: 12px 24px;">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('js')
<script>
    $(document).ready(function() {
        $('#kategoriTable').DataTable({
            responsive: true,
            language: {
                search: "Cari:",
                lengthMenu: "Tampilkan _MENU_ data",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ kategori",
                paginate: {
                    first: "Awal",
                    last: "Akhir",
                    next: "Lanjut",
                    previous: "Kembali"
                }
            }
        });

        // Edit Modal Trigger
        $('.btn-edit-kategori').on('click', function() {
            const id = $(this).data('id');
            const name = $(this).data('name');
            const url = $(this).data('url');

            $('#edit_nama_kategori').val(name);
            $('#formEditKategori').attr('action', url);
            
            const modal = new bootstrap.Modal(document.getElementById('modalEditKategori'));
            modal.show();
        });
    });

    function openModal(id) {
        const modal = new bootstrap.Modal(document.getElementById(id));
        modal.show();
    }
</script>
@endpush
