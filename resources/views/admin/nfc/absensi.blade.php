@extends('layouts.app')

@section('title', 'Scan Absensi NFC')

@push('css')
<style>
    .nfc-page {
        max-width: 480px;
        margin: 0 auto;
        padding: 1rem;
    }
    .nfc-status-banner {
        background: #fef3c7;
        border-left: 4px solid #f59e0b;
        color: #78350f;
        padding: 12px 16px;
        border-radius: 12px;
        font-size: 0.9rem;
        margin-bottom: 16px;
    }
    .nfc-scanner-card {
        background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
        border-radius: 24px;
        padding: 32px 20px;
        text-align: center;
        color: white;
        margin-bottom: 16px;
        box-shadow: 0 12px 30px rgba(79, 70, 229, 0.25);
    }
    .nfc-icon {
        font-size: 5rem;
        line-height: 1;
        margin-bottom: 12px;
        display: inline-block;
        transition: transform 0.3s;
    }
    .nfc-icon.pulse {
        animation: nfcPulse 1.5s ease-in-out infinite;
    }
    @keyframes nfcPulse {
        0%, 100% { transform: scale(1); opacity: 1; }
        50%      { transform: scale(1.15); opacity: 0.7; }
    }
    .nfc-status-text {
        font-size: 1rem;
        opacity: 0.9;
        margin-bottom: 4px;
    }
    .nfc-btn-toggle {
        width: 100%;
        padding: 16px;
        font-size: 1rem;
        font-weight: 700;
        border-radius: 16px;
        border: 0;
        background: white;
        color: #4f46e5;
        margin-bottom: 24px;
        min-height: 56px;
    }
    .nfc-btn-toggle:disabled {
        background: #e5e7eb; color: #9ca3af; cursor: not-allowed;
    }
    .nfc-btn-toggle.scanning {
        background: #ef4444; color: white;
    }
    .nfc-feed h6 {
        font-size: 0.7rem;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        color: #6b7280;
        margin-bottom: 12px;
    }
    .nfc-feed-item {
        background: white;
        border-radius: 14px;
        padding: 14px 16px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        margin-bottom: 10px;
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .nfc-feed-icon {
        width: 42px; height: 42px; border-radius: 12px;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.4rem; flex-shrink: 0;
    }
    .nfc-feed-icon.masuk  { background: #d1fae5; color: #059669; }
    .nfc-feed-icon.pulang { background: #dbeafe; color: #2563eb; }
    .nfc-feed-name { font-weight: 700; color: #111827; font-size: 0.95rem; }
    .nfc-feed-meta { font-size: 0.8rem; color: #6b7280; }
    .nfc-toast {
        position: fixed; top: 20px; left: 50%; transform: translateX(-50%);
        padding: 14px 22px; border-radius: 14px; color: white;
        font-weight: 700; box-shadow: 0 12px 30px rgba(0,0,0,0.2);
        z-index: 9999; max-width: 90%; text-align: center;
        animation: nfcToastIn 0.3s ease-out;
    }
    @keyframes nfcToastIn {
        from { opacity: 0; transform: translate(-50%, -20px); }
        to   { opacity: 1; transform: translate(-50%, 0); }
    }
    .nfc-toast.success { background: #10b981; }
    .nfc-toast.info    { background: #3b82f6; }
    .nfc-toast.error   { background: #ef4444; }
    .nfc-toast.warning { background: #f59e0b; color:#78350f; }
</style>
@endpush

@section('content')

<div class="nfc-page">
    <h3 class="font-weight-bold text-center mb-3" style="color:#1e293b;">📡 Scan Absensi NFC</h3>

    <div id="banner" class="nfc-status-banner" style="display:none;">
        ⚠️ Browser tidak mendukung Web NFC. Gunakan Chrome di Android (≥ 89).
    </div>

    <div class="nfc-scanner-card">
        <div id="nfcIcon" class="nfc-icon">📡</div>
        <div id="nfcStatusText" class="nfc-status-text">Tekan tombol di bawah untuk mengaktifkan NFC.</div>
    </div>

    <button id="btnToggle" class="nfc-btn-toggle">
        ⚡ Aktifkan NFC
    </button>

    <div class="nfc-feed">
        <h6>Scan Terakhir Hari Ini</h6>
        <div id="feedList"></div>
        <div id="feedEmpty" class="text-center text-muted small py-3">Belum ada scan hari ini.</div>
    </div>
</div>

@push('js')
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
const CSRF_TOKEN = "{{ csrf_token() }}";
const URL_SCAN = "{{ route('admin.nfc.absensi.scan') }}";
const URL_FEED = "{{ route('admin.nfc.absensi.feed') }}";
axios.defaults.headers.common['X-CSRF-TOKEN'] = CSRF_TOKEN;
axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

let ndef = null;
let abortCtrl = null;
let scanning = false;
const cooldown = new Map(); // serial → timestamp

document.addEventListener('DOMContentLoaded', () => {
    if (!('NDEFReader' in window)) {
        document.getElementById('banner').style.display = 'block';
        document.getElementById('btnToggle').disabled = true;
        document.getElementById('btnToggle').textContent = 'NFC tidak tersedia';
    }

    document.getElementById('btnToggle').addEventListener('click', toggleScan);

    refreshFeed();
    setInterval(refreshFeed, 5000);
});

async function toggleScan() {
    if (scanning) {
        stopScan();
        return;
    }
    await startScan();
}

async function startScan() {
    try {
        ndef = new NDEFReader();
        abortCtrl = new AbortController();
        await ndef.scan({ signal: abortCtrl.signal });

        scanning = true;
        document.getElementById('nfcIcon').classList.add('pulse');
        document.getElementById('nfcStatusText').textContent = '🟢 NFC aktif. Tap kartu ke belakang HP...';
        const btn = document.getElementById('btnToggle');
        btn.textContent = '⏹ Stop';
        btn.classList.add('scanning');

        ndef.addEventListener('reading', onReading);
    } catch (err) {
        toast('error', 'Gagal aktifkan NFC: ' + err.message);
    }
}

function stopScan() {
    if (abortCtrl) abortCtrl.abort();
    scanning = false;
    ndef = null;
    document.getElementById('nfcIcon').classList.remove('pulse');
    document.getElementById('nfcStatusText').textContent = 'NFC dimatikan.';
    const btn = document.getElementById('btnToggle');
    btn.textContent = '⚡ Aktifkan NFC';
    btn.classList.remove('scanning');
}

async function onReading({ serialNumber }) {
    const serial = serialNumber.toUpperCase();
    const now = Date.now();
    const last = cooldown.get(serial);
    if (last && now - last < 3000) {
        return; // cooldown 3 detik
    }
    cooldown.set(serial, now);

    try {
        const r = await axios.post(URL_SCAN, { nfc_serial: serial });
        const d = r.data.data;
        const isMasuk = d.tipe === 'masuk';
        const msg = isMasuk
            ? `✅ ${d.mahasiswa.nama} absen masuk pukul ${d.jam}`
            : `👋 ${d.mahasiswa.nama} absen pulang pukul ${d.jam} (durasi: ${d.durasi})`;
        toast(isMasuk ? 'success' : 'info', msg);
        refreshFeed();
    } catch (err) {
        const status = err.response?.status;
        const msg = err.response?.data?.message || err.message;
        const data = err.response?.data?.data;
        if (status === 404 && data?.nfc_serial) {
            toast('error', `Kartu belum terdaftar (${data.nfc_serial})`);
        } else {
            toast('error', msg);
        }
    }
}

async function refreshFeed() {
    try {
        const r = await axios.get(URL_FEED);
        const items = r.data.data || [];
        const list = document.getElementById('feedList');
        const empty = document.getElementById('feedEmpty');

        if (items.length === 0) {
            list.innerHTML = '';
            empty.style.display = 'block';
            return;
        }
        empty.style.display = 'none';
        list.innerHTML = items.map(it => `
            <div class="nfc-feed-item">
                <div class="nfc-feed-icon ${it.tipe}">
                    ${it.tipe === 'masuk' ? '✅' : '👋'}
                </div>
                <div style="flex:1; min-width:0;">
                    <div class="nfc-feed-name">${escapeHtml(it.mahasiswa.nama)}</div>
                    <div class="nfc-feed-meta">${escapeHtml(it.mahasiswa.kelas)} · ${it.tipe} · ${it.jam}</div>
                </div>
            </div>
        `).join('');
    } catch (err) {
        // silent fail untuk polling
    }
}

function toast(kind, message) {
    const el = document.createElement('div');
    el.className = 'nfc-toast ' + kind;
    el.textContent = message;
    document.body.appendChild(el);
    setTimeout(() => el.remove(), 3000);
}

function escapeHtml(s) {
    return String(s).replace(/[&<>"']/g, c => ({
        '&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'
    }[c]));
}
</script>
@endpush

@endsection
