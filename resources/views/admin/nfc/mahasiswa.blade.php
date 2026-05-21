@extends('layouts.app')

@section('title', 'Daftar Mahasiswa NFC')

@section('content')

<div class="modern-page-header">
    <h3>
        <div class="modern-header-icon">
            <i class="mdi mdi-card-account-details"></i>
        </div>
        Daftar Mahasiswa
    </h3>
    <button type="button" class="btn btn-gradient-primary font-weight-bold" id="btnTambah" style="border-radius: 12px;">
        <i class="mdi mdi-plus-circle me-1"></i> Tambah Mahasiswa
    </button>
</div>

<div class="card border-0 shadow-sm" style="border-radius: 20px;">
    <div class="card-body p-4">
        <div class="table-responsive">
            <table class="table align-middle" id="tabelMahasiswa">
                <thead>
                    <tr style="background:#f8fafc;">
                        <th>NIM</th>
                        <th>Nama</th>
                        <th>Kelas</th>
                        <th>Serial NFC</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($mahasiswa as $m)
                        <tr data-id="{{ $m->id }}"
                            data-nim="{{ $m->nim }}"
                            data-nama="{{ $m->nama }}"
                            data-kelas="{{ $m->kelas }}"
                            data-serial="{{ $m->nfc_serial }}">
                            <td><strong>{{ $m->nim }}</strong></td>
                            <td>{{ $m->nama }}</td>
                            <td><span class="badge bg-light text-dark">{{ $m->kelas }}</span></td>
                            <td>
                                @if($m->nfc_serial)
                                    <code style="font-size:0.8rem;">{{ $m->nfc_serial }}</code>
                                @else
                                    <span class="text-muted small">— belum terdaftar —</span>
                                @endif
                            </td>
                            <td class="text-end">
                                <button class="btn btn-sm btn-outline-primary btnEdit" style="border-radius:8px;">
                                    <i class="mdi mdi-pencil"></i>
                                </button>
                                <button class="btn btn-sm btn-outline-danger btnHapus" style="border-radius:8px;">
                                    <i class="mdi mdi-delete"></i>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-center text-muted py-4">Belum ada data mahasiswa.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Modal Form --}}
<div class="modal fade" id="modalMahasiswa" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius:20px; border:0;">
            <div class="modal-header border-0">
                <h5 class="modal-title font-weight-bold" id="modalTitle">Tambah Mahasiswa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="formMahasiswa">
                    <input type="hidden" id="formId">
                    <div class="mb-3">
                        <label class="form-label small text-uppercase font-weight-bold text-muted">NIM</label>
                        <input type="text" class="form-control" id="formNim" required maxlength="20" style="border-radius:12px;">
                    </div>
                    <div class="mb-3">
                        <label class="form-label small text-uppercase font-weight-bold text-muted">Nama</label>
                        <input type="text" class="form-control" id="formNama" required maxlength="100" style="border-radius:12px;">
                    </div>
                    <div class="mb-3">
                        <label class="form-label small text-uppercase font-weight-bold text-muted">Kelas</label>
                        <input type="text" class="form-control" id="formKelas" required maxlength="20" placeholder="Misal: TI-4A" style="border-radius:12px;">
                    </div>
                    <div class="mb-2">
                        <label class="form-label small text-uppercase font-weight-bold text-muted">Serial NFC</label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="formSerial" readonly placeholder="Klik tombol di kanan untuk scan" style="border-radius:12px 0 0 12px; background:#f8fafc;">
                            <button type="button" class="btn btn-success" id="btnScanKartu" style="border-radius:0 12px 12px 0;">
                                <i class="mdi mdi-nfc-search-variant me-1"></i> Scan
                            </button>
                        </div>
                        <div id="scanStatus" class="small text-muted mt-2">Status scan: belum aktif.</div>
                    </div>
                </form>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal" style="border-radius:12px;">Batal</button>
                <button type="button" class="btn btn-gradient-primary font-weight-bold" id="btnSimpan" style="border-radius:12px;">
                    <i class="mdi mdi-content-save me-1"></i> Simpan
                </button>
            </div>
        </div>
    </div>
</div>

@push('js')
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
const CSRF_TOKEN = "{{ csrf_token() }}";
const URL = {
    store:       "{{ route('admin.nfc.mahasiswa.store') }}",
    update:      (id) => `{{ url('admin/nfc/mahasiswa') }}/${id}`,
    destroy:     (id) => `{{ url('admin/nfc/mahasiswa') }}/${id}`,
    checkSerial: "{{ route('admin.nfc.mahasiswa.check-serial') }}",
};
axios.defaults.headers.common['X-CSRF-TOKEN'] = CSRF_TOKEN;
axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

let modal;
let editingId = null;

document.addEventListener('DOMContentLoaded', () => {
    modal = new bootstrap.Modal(document.getElementById('modalMahasiswa'));

    document.getElementById('btnTambah').addEventListener('click', () => openForm(null));
    document.getElementById('btnSimpan').addEventListener('click', simpanForm);
    document.getElementById('btnScanKartu').addEventListener('click', scanKartu);

    document.querySelectorAll('.btnEdit').forEach(btn => {
        btn.addEventListener('click', (e) => {
            const tr = e.target.closest('tr');
            openForm({
                id: tr.dataset.id,
                nim: tr.dataset.nim,
                nama: tr.dataset.nama,
                kelas: tr.dataset.kelas,
                serial: tr.dataset.serial,
            });
        });
    });

    document.querySelectorAll('.btnHapus').forEach(btn => {
        btn.addEventListener('click', (e) => {
            const tr = e.target.closest('tr');
            const id = tr.dataset.id;
            const nama = tr.dataset.nama;
            if (!confirm(`Hapus mahasiswa "${nama}"?`)) return;
            axios.delete(URL.destroy(id))
                .then(() => { alert('Mahasiswa dihapus'); location.reload(); })
                .catch(err => alert('Gagal hapus: ' + (err.response?.data?.message || err.message)));
        });
    });
});

function openForm(data) {
    editingId = data?.id || null;
    document.getElementById('modalTitle').textContent = editingId ? 'Edit Mahasiswa' : 'Tambah Mahasiswa';
    document.getElementById('formId').value     = editingId || '';
    document.getElementById('formNim').value    = data?.nim || '';
    document.getElementById('formNama').value   = data?.nama || '';
    document.getElementById('formKelas').value  = data?.kelas || '';
    document.getElementById('formSerial').value = data?.serial || '';
    document.getElementById('scanStatus').textContent = 'Status scan: belum aktif.';
    document.getElementById('scanStatus').className = 'small text-muted mt-2';
    modal.show();
}

async function scanKartu() {
    const status = document.getElementById('scanStatus');
    if (!('NDEFReader' in window)) {
        status.textContent = '⚠️ Browser tidak mendukung Web NFC. Buka dari Android Chrome.';
        status.className = 'small text-warning mt-2';
        return;
    }

    try {
        status.textContent = '🔄 Meminta izin NFC...';
        status.className = 'small text-info mt-2';

        const ndef = new NDEFReader();
        const ctrl = new AbortController();
        await ndef.scan({ signal: ctrl.signal });

        status.textContent = '🟢 NFC aktif. Tap kartu ke HP...';

        ndef.addEventListener('reading', async ({ serialNumber }) => {
            ctrl.abort();
            const serial = serialNumber.toUpperCase();

            try {
                const r = await axios.get(URL.checkSerial, { params: { serial } });
                const d = r.data.data;
                if (d.available === false && (!editingId || d.mahasiswa.nim !== document.getElementById('formNim').value)) {
                    status.textContent = `⚠️ Kartu ini sudah dipakai oleh: ${d.mahasiswa.nama} (${d.mahasiswa.nim})`;
                    status.className = 'small text-danger mt-2';
                    return;
                }
                document.getElementById('formSerial').value = serial;
                status.textContent = `✅ Kartu dipindai: ${serial}`;
                status.className = 'small text-success mt-2';
            } catch (err) {
                status.textContent = '❌ Gagal verifikasi serial: ' + (err.response?.data?.message || err.message);
                status.className = 'small text-danger mt-2';
            }
        }, { once: true });
    } catch (err) {
        status.textContent = '❌ Error: ' + err.message;
        status.className = 'small text-danger mt-2';
    }
}

function simpanForm() {
    const payload = {
        nim:        document.getElementById('formNim').value.trim(),
        nama:       document.getElementById('formNama').value.trim(),
        kelas:      document.getElementById('formKelas').value.trim(),
        nfc_serial: document.getElementById('formSerial').value.trim() || null,
    };

    if (!payload.nim || !payload.nama || !payload.kelas) {
        alert('NIM, Nama, dan Kelas wajib diisi.');
        return;
    }

    const req = editingId
        ? axios.put(URL.update(editingId), payload)
        : axios.post(URL.store, payload);

    req.then(r => {
        alert(r.data.message);
        location.reload();
    }).catch(err => {
        const msg = err.response?.data?.message || err.message;
        const errs = err.response?.data?.errors;
        const detail = errs ? '\n' + Object.values(errs).flat().join('\n') : '';
        alert('Gagal: ' + msg + detail);
    });
}
</script>
@endpush

@endsection
