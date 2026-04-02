{{-- Modal: Tambah Barang --}}
<div class="modal fade" id="modalTambahBarang" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content" style="border-radius: 24px; border: none; overflow: hidden;">
            <div class="modal-header border-0 p-4" style="background: linear-gradient(135deg, var(--primary-indigo), var(--primary-violet)); color: white;">
                <h5 class="modal-title font-weight-bold"><i class="mdi mdi-plus-circle-outline me-2"></i>Registrasi Barang Baru</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formTambahBarang" onsubmit="return false;">
                <div class="modal-body p-4">
                    <div class="form-group mb-3">
                        <label class="font-weight-bold text-dark mb-2">Nama Barang</label>
                        <input type="text" id="tambah_nama" class="form-control" placeholder="Sabun Mandi, Shampoo, dll" required 
                               style="border-radius: 12px; padding: 12px; border: 2px solid #f1f5f9; background: #f8fafc;">
                    </div>
                    <div class="form-group mb-0">
                        <label class="font-weight-bold text-dark mb-2">Harga (Rp)</label>
                        <input type="number" id="tambah_harga" class="form-control" placeholder="5000" required min="0"
                               style="border-radius: 12px; padding: 12px; border: 2px solid #f1f5f9; background: #f8fafc;">
                    </div>
                </div>
                <div class="modal-footer border-0 p-4 pt-0">
                    <button type="button" class="btn btn-light font-weight-bold" data-bs-dismiss="modal" style="border-radius: 12px; padding: 12px 24px;">Batal</button>
                    <button type="button" id="btnSimpanBarang" onclick="simpanBarang()" class="btn btn-gradient-primary font-weight-bold" style="border-radius: 12px; padding: 12px 24px;">
                        <span id="spinnerSimpan" class="spinner-border spinner-border-sm me-2 d-none" role="status"></span>
                        <span id="txtSimpan">Simpan</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Modal: Edit Barang --}}
<div class="modal fade" id="modalEditBarang" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content" style="border-radius: 24px; border: none; overflow: hidden;">
            <div class="modal-header border-0 p-4 bg-info text-white">
                <h5 class="modal-title font-weight-bold"><i class="mdi mdi-pencil-outline me-2"></i>Modifikasi Data Barang</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formEditBarang" onsubmit="return false;">
                <div class="modal-body p-4">
                    <div class="form-group mb-3">
                        <label class="font-weight-bold text-muted mb-2">ID Barang (Read-only)</label>
                        <input type="text" id="edit_id" class="form-control" readonly 
                               style="border-radius: 12px; padding: 12px; border: 1px solid #e2e8f0; background: #edf2f7; color: #718096; font-family: monospace;">
                    </div>
                    <div class="form-group mb-3">
                        <label class="font-weight-bold text-dark mb-2">Nama Barang</label>
                        <input type="text" id="edit_nama" class="form-control" placeholder="Sabun Mandi" required
                               style="border-radius: 12px; padding: 12px; border: 2px solid #f1f5f9; background: #f8fafc;">
                    </div>
                    <div class="form-group mb-0">
                        <label class="font-weight-bold text-dark mb-2">Harga (Rp)</label>
                        <input type="number" id="edit_harga" class="form-control" placeholder="5000" required min="0"
                               style="border-radius: 12px; padding: 12px; border: 2px solid #f1f5f9; background: #f8fafc;">
                    </div>
                </div>
                <div class="modal-footer border-0 p-4 pt-0 d-flex justify-content-between">
                    <button type="button" id="btnHapusBarang" onclick="hapusBarang()" class="btn btn-inverse-danger font-weight-bold" style="border-radius: 12px; padding: 12px 24px;">
                        <i class="mdi mdi-delete-outline me-1"></i> Hapus
                    </button>
                    <div>
                        <button type="button" class="btn btn-light font-weight-bold me-2" data-bs-dismiss="modal" style="border-radius: 12px; padding: 12px 24px;">Batal</button>
                        <button type="button" id="btnUbahBarang" onclick="ubahBarang()" class="btn btn-info text-white font-weight-bold" style="border-radius: 12px; padding: 12px 24px;">
                            <span id="spinnerUbah" class="spinner-border spinner-border-sm me-2 d-none" role="status"></span>
                            <span id="txtUbah">Update</span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
