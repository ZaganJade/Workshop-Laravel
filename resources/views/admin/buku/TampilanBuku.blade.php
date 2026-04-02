@extends('layouts.app')

@section('title', 'Koleksi Buku')

@section('content')
<div class="modern-page-header">
    <h3>
        <div class="modern-header-icon">
            <i class="mdi mdi-book-open-page-variant"></i>
        </div>
        Katalog Koleksi Buku
    </h3>
    <div class="d-flex gap-2">
        <button type="button" onclick="openModal('modalCetakPdfBuku')" class="btn btn-inverse-danger font-weight-bold" style="border-radius: 12px; padding: 12px 20px;">
            <i class="mdi mdi-file-pdf-box me-1"></i> Export PDF
        </button>
        <button type="button" onclick="openModal('modalTambahBuku')" class="btn btn-gradient-primary font-weight-bold" style="border-radius: 12px; padding: 12px 20px;">
            <i class="mdi mdi-plus me-1"></i> Registrasi Buku
        </button>
    </div>
</div>

<div class="card">
    <div class="card-body p-4">
        <div class="table-responsive">
            <table id="bukuTable" class="display w-100">
                <thead>
                    <tr>
                        <th style="width: 80px;">Kode</th>
                        <th>Judul & Penulis</th>
                        <th>Kategori</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($buku as $item)
                    <tr>
                        <td>
                            <span class="badge bg-dark text-white font-weight-bold px-3 py-2" style="border-radius: 8px; font-size: 0.75rem;">
                                {{ $item->kode }}
                            </span>
                        </td>
                        <td>
                            <div class="d-flex flex-column">
                                <span class="font-weight-bold text-dark" style="font-size: 1rem;">{{ $item->judul }}</span>
                                <span class="text-muted" style="font-size: 0.75rem;"><i class="mdi mdi-account-edit me-1"></i>{{ $item->pengarang }}</span>
                            </div>
                        </td>
                        <td>
                            <span class="badge bg-light text-primary border border-primary-subtle px-3 py-2" style="border-radius: 8px; font-size: 0.7rem; font-weight: 700;">
                                {{ $item->kategori->nama_kategori ?? 'Umum' }}
                            </span>
                        </td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-2">
                                <button type="button" 
                                        class="btn btn-inverse-info btn-icon btn-sm btn-edit-buku"
                                        data-id="{{ $item->idbuku }}"
                                        data-kode="{{ $item->kode }}"
                                        data-judul="{{ $item->judul }}"
                                        data-pengarang="{{ $item->pengarang }}"
                                        data-idkategori="{{ $item->idkategori }}"
                                        data-url="{{ route('admin.buku.update', $item->idbuku) }}"
                                        title="Edit">
                                    <i class="mdi mdi-pencil"></i>
                                </button>
                                <form action="{{ route('admin.buku.destroy', $item->idbuku) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-inverse-danger btn-icon btn-sm" onclick="return confirm('Hapus buku ini?')" title="Hapus">
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

{{-- Modal Cetak PDF --}}
<div class="modal fade" id="modalCetakPdfBuku" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 400px;">
        <div class="modal-content" style="border-radius: 24px; border: none; overflow: hidden;">
            <div class="modal-header border-0 p-4 bg-danger text-white">
                <h5 class="modal-title font-weight-bold"><i class="mdi mdi-file-pdf-box me-2"></i>Export Katalog PDF</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.buku.pdf') }}" method="POST" target="_blank">
                @csrf
                <div class="modal-body p-4">
                    <div class="form-group mb-4">
                        <label class="font-weight-bold text-dark mb-2">Ukuran Kertas</label>
                        <select class="form-select" name="paper_size" style="border-radius: 12px; padding: 12px; border: 2px solid #f1f5f9;">
                            <option value="a4" selected>A4</option>
                            <option value="letter">Letter</option>
                            <option value="legal">Legal</option>
                        </select>
                    </div>
                    <div class="form-group mb-0">
                        <label class="font-weight-bold text-dark mb-2">Orientasi</label>
                        <select class="form-select" name="orientation" style="border-radius: 12px; padding: 12px; border: 2px solid #f1f5f9;">
                            <option value="portrait" selected>Portrait</option>
                            <option value="landscape">Landscape</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer border-0 p-4 pt-0">
                    <button type="button" class="btn btn-light font-weight-bold" data-bs-dismiss="modal" style="border-radius: 12px; padding: 12px 24px;">Batal</button>
                    <button type="submit" class="btn btn-danger text-white font-weight-bold" style="border-radius: 12px; padding: 12px 24px;">Generate</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Modal Tambah --}}
<div class="modal fade" id="modalTambahBuku" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content" style="border-radius: 24px; border: none; overflow: hidden;">
            <div class="modal-header border-0 p-4" style="background: linear-gradient(135deg, var(--primary-indigo), var(--primary-violet)); color: white;">
                <h5 class="modal-title font-weight-bold"><i class="mdi mdi-plus-circle-outline me-2"></i>Registrasi Buku Baru</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.buku.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-md-6 mt-3">
                            <label class="font-weight-bold text-dark mb-2">Kode Buku</label>
                            <input type="text" class="form-control" name="kode" placeholder="L-001" required style="border-radius: 12px; padding: 12px; border: 2px solid #f1f5f9; background: #f8fafc;">
                        </div>
                        <div class="col-md-6 mt-3">
                            <label class="font-weight-bold text-dark mb-2">Kategori</label>
                            <select class="form-select" name="idkategori" required style="border-radius: 12px; padding: 12px; border: 2px solid #f1f5f9; background: #f8fafc;">
                                <option value="" disabled selected>Pilih Kategori</option>
                                @foreach($kategori as $kat)
                                    <option value="{{ $kat->idkategori }}">{{ $kat->nama_kategori }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-12 mt-3">
                            <label class="font-weight-bold text-dark mb-2">Judul Buku</label>
                            <input type="text" class="form-control" name="judul" placeholder="Masukkan judul lengkap" required style="border-radius: 12px; padding: 12px; border: 2px solid #f1f5f9; background: #f8fafc;">
                        </div>
                        <div class="col-md-12 mt-3">
                            <label class="font-weight-bold text-dark mb-2">Pengarang / Penulis</label>
                            <input type="text" class="form-control" name="pengarang" placeholder="Nama penulis" required style="border-radius: 12px; padding: 12px; border: 2px solid #f1f5f9; background: #f8fafc;">
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 p-4 pt-0">
                    <button type="button" class="btn btn-light font-weight-bold" data-bs-dismiss="modal" style="border-radius: 12px; padding: 12px 24px;">Batal</button>
                    <button type="submit" class="btn btn-gradient-primary font-weight-bold" style="border-radius: 12px; padding: 12px 24px;">Arsipkan Buku</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Modal Edit --}}
<div class="modal fade" id="modalEditBuku" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content" style="border-radius: 24px; border: none; overflow: hidden;">
            <div class="modal-header border-0 p-4 bg-info text-white">
                <h5 class="modal-title font-weight-bold"><i class="mdi mdi-pencil-outline me-2"></i>Perbarui Data Koleksi</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formEditBuku" action="" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-md-6 mt-3">
                            <label class="font-weight-bold text-dark mb-2">Kode Buku</label>
                            <input type="text" class="form-control" id="edit_kode" name="kode" required style="border-radius: 12px; padding: 12px; border: 2px solid #f1f5f9; background: #f8fafc;">
                        </div>
                        <div class="col-md-6 mt-3">
                            <label class="font-weight-bold text-dark mb-2">Kategori</label>
                            <select class="form-select" id="edit_idkategori" name="idkategori" required style="border-radius: 12px; padding: 12px; border: 2px solid #f1f5f9; background: #f8fafc;">
                                @foreach($kategori as $kat)
                                    <option value="{{ $kat->idkategori }}">{{ $kat->nama_kategori }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-12 mt-3">
                            <label class="font-weight-bold text-dark mb-2">Judul Buku</label>
                            <input type="text" class="form-control" id="edit_judul" name="judul" required style="border-radius: 12px; padding: 12px; border: 2px solid #f1f5f9; background: #f8fafc;">
                        </div>
                        <div class="col-md-12 mt-3">
                            <label class="font-weight-bold text-dark mb-2">Pengarang / Penulis</label>
                            <input type="text" class="form-control" id="edit_pengarang" name="pengarang" required style="border-radius: 12px; padding: 12px; border: 2px solid #f1f5f9; background: #f8fafc;">
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 p-4 pt-0">
                    <button type="button" class="btn btn-light font-weight-bold" data-bs-dismiss="modal" style="border-radius: 12px; padding: 12px 24px;">Batal</button>
                    <button type="submit" class="btn btn-info text-white font-weight-bold" style="border-radius: 12px; padding: 12px 24px;">Update Arsip</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('js')
<script>
    $(document).ready(function() {
        $('#bukuTable').DataTable({
            responsive: true,
            language: {
                search: "Cari buku:",
                lengthMenu: "Tampilkan _MENU_ entri",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ koleksi",
                paginate: {
                    first: "Awal",
                    last: "Akhir",
                    next: "Lanjut",
                    previous: "Kembali"
                }
            }
        });

        // Edit Modal Trigger
        $('.btn-edit-buku').on('click', function() {
            const data = $(this).data();
            $('#edit_kode').val(data.kode);
            $('#edit_judul').val(data.judul);
            $('#edit_pengarang').val(data.pengarang);
            $('#edit_idkategori').val(data.idkategori);
            $('#formEditBuku').attr('action', data.url);
            
            const modal = new bootstrap.Modal(document.getElementById('modalEditBuku'));
            modal.show();
        });
    });

    function openModal(id) {
        const modal = new bootstrap.Modal(document.getElementById(id));
        modal.show();
    }
</script>
@endpush
