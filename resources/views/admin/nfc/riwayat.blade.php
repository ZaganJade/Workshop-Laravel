@extends('layouts.app')

@section('title', 'Riwayat Absensi NFC')

@section('content')

<div class="modern-page-header">
    <h3>
        <div class="modern-header-icon">
            <i class="mdi mdi-clipboard-text-clock"></i>
        </div>
        Riwayat Absensi
    </h3>
</div>

<div class="card border-0 shadow-sm mb-3" style="border-radius:20px;">
    <div class="card-body p-4">
        <div class="row g-3 align-items-end">
            <div class="col-md-4">
                <label class="form-label small text-uppercase font-weight-bold text-muted">Tanggal</label>
                <input type="date" id="filterTanggal" class="form-control" value="{{ now()->toDateString() }}" style="border-radius:12px;">
            </div>
            <div class="col-md-5">
                <label class="form-label small text-uppercase font-weight-bold text-muted">Mahasiswa</label>
                <select id="filterMahasiswa" class="form-control" style="border-radius:12px;">
                    <option value="">Semua mahasiswa</option>
                    @foreach($mahasiswaList as $m)
                        <option value="{{ $m->id }}">{{ $m->nim }} — {{ $m->nama }} ({{ $m->kelas }})</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <button id="btnFilter" class="btn btn-gradient-primary font-weight-bold w-100" style="border-radius:12px;">
                    <i class="mdi mdi-filter me-1"></i> Tampilkan
                </button>
            </div>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm" style="border-radius:20px;">
    <div class="card-body p-4">
        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr style="background:#f8fafc;">
                        <th>Tanggal</th>
                        <th>NIM</th>
                        <th>Nama</th>
                        <th>Kelas</th>
                        <th>Siklus</th>
                        <th>Masuk</th>
                        <th>Pulang</th>
                        <th>Durasi</th>
                    </tr>
                </thead>
                <tbody id="tbodyRiwayat">
                    <tr><td colspan="8" class="text-center text-muted py-3">Memuat...</td></tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

@push('js')
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
const URL_DATA = "{{ route('admin.nfc.riwayat.data') }}";

document.addEventListener('DOMContentLoaded', () => {
    document.getElementById('btnFilter').addEventListener('click', loadData);
    loadData();
});

async function loadData() {
    const tanggal     = document.getElementById('filterTanggal').value;
    const mahasiswaId = document.getElementById('filterMahasiswa').value;
    const tbody = document.getElementById('tbodyRiwayat');
    tbody.innerHTML = '<tr><td colspan="8" class="text-center text-muted py-3">Memuat...</td></tr>';

    try {
        const r = await axios.get(URL_DATA, { params: {
            tanggal,
            mahasiswa_id: mahasiswaId || null,
        }});
        const items = r.data.data || [];

        if (items.length === 0) {
            tbody.innerHTML = '<tr><td colspan="8" class="text-center text-muted py-4">Tidak ada data untuk filter ini.</td></tr>';
            return;
        }

        const rows = [];
        items.forEach(it => {
            it.cycles.forEach(c => {
                rows.push(`
                    <tr>
                        <td>${esc(it.tanggal)}</td>
                        <td><strong>${esc(it.mahasiswa.nim)}</strong></td>
                        <td>${esc(it.mahasiswa.nama)}</td>
                        <td><span class="badge bg-light text-dark">${esc(it.mahasiswa.kelas)}</span></td>
                        <td>#${c.ke}</td>
                        <td>${c.masuk  ? `<span class="text-success">${c.masuk}</span>`   : '<span class="text-muted">—</span>'}</td>
                        <td>${c.pulang ? `<span class="text-primary">${c.pulang}</span>` : '<span class="text-muted">—</span>'}</td>
                        <td>${c.durasi ? esc(c.durasi) : '<span class="text-muted">—</span>'}</td>
                    </tr>
                `);
            });
        });
        tbody.innerHTML = rows.join('');
    } catch (err) {
        tbody.innerHTML = `<tr><td colspan="8" class="text-center text-danger py-4">Gagal memuat: ${esc(err.response?.data?.message || err.message)}</td></tr>`;
    }
}

function esc(s) {
    return String(s ?? '').replace(/[&<>"']/g, c => ({
        '&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'
    }[c]));
}
</script>
@endpush

@endsection
