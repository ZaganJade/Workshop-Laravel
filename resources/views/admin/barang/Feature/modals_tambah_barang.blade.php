<div id="modalTambahBarang" class="bg-white rounded-[3rem] shadow-2xl w-full max-w-lg transform transition-all duration-300 scale-95 opacity-0 hidden overflow-hidden ring-1 ring-white/20">
    <div class="px-10 py-8 border-b border-slate-50 flex items-center justify-between bg-gradient-to-br from-violet-50/50 via-white to-fuchsia-50/30">
        <div>
            <h5 class="text-2xl font-black text-slate-900 tracking-tighter">Tambah Barang</h5>
            <p class="text-[10px] text-violet-400 font-bold uppercase tracking-[4px] mt-1.5">Registrasi Barang Baru</p>
        </div>
        <button type="button" onclick="closeScopedModal('modalTambahBarang')" class="p-3 text-slate-300 hover:text-rose-500 hover:bg-rose-50 rounded-3xl transition-all">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>
    </div>
    <form id="formTambahBarang" onsubmit="return false;">
        <div class="p-10 space-y-6">
            <div>
                <label for="tambah_nama" class="block text-[11px] font-black text-slate-400 uppercase tracking-[2px] mb-3 ml-1">Nama Barang</label>
                <input type="text" id="tambah_nama" required placeholder="Sabun Mandi, Shampoo, dll" class="w-full px-6 py-4 bg-slate-50 border-2 border-slate-100 rounded-2xl focus:outline-none focus:border-violet-500/50 focus:ring-8 focus:ring-violet-500/5 transition-all text-sm font-black text-slate-800 placeholder:text-slate-300 shadow-sm">
            </div>
            <div>
                <label for="tambah_harga" class="block text-[11px] font-black text-slate-400 uppercase tracking-[2px] mb-3 ml-1">Harga (Rp)</label>
                <input type="number" id="tambah_harga" required min="0" placeholder="5000" class="w-full px-6 py-4 bg-slate-50 border-2 border-slate-100 rounded-2xl focus:outline-none focus:border-violet-500/50 focus:ring-8 focus:ring-violet-500/5 transition-all text-sm font-black text-slate-800 placeholder:text-slate-300 shadow-sm">
            </div>
        </div>
        <div class="px-10 py-8 bg-slate-50/50 border-t border-slate-100 flex justify-end gap-3">
            <button type="button" onclick="closeScopedModal('modalTambahBarang')" class="px-6 py-3.5 text-xs font-black text-slate-400 hover:text-slate-700 uppercase tracking-widest transition-colors">Batal</button>
            <button type="button" id="btnSimpanBarang" onclick="simpanBarang()" class="px-8 py-3.5 bg-slate-900 border border-slate-700 text-white text-xs font-black rounded-2xl shadow-2xl hover:bg-violet-600 transition-all active:scale-95 uppercase tracking-[3px] flex items-center gap-2">
                <svg id="spinnerSimpan" class="w-4 h-4 animate-spin hidden" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path></svg>
                <span id="txtSimpan">Simpan</span>
            </button>
        </div>
    </form>
</div>

{{-- ============================================== --}}
{{-- MODAL: Edit Barang                             --}}
{{-- ============================================== --}}
<div id="modalEditBarang" class="bg-white rounded-[3rem] shadow-2xl w-full max-w-lg transform transition-all duration-300 scale-95 opacity-0 hidden overflow-hidden ring-1 ring-white/20">
    <div class="px-10 py-8 border-b border-slate-50 flex items-center justify-between bg-gradient-to-br from-indigo-50/50 via-white to-white">
        <div>
            <h5 class="text-2xl font-black text-slate-900 tracking-tighter">Edit Barang</h5>
            <p class="text-[10px] text-indigo-400 font-bold uppercase tracking-[4px] mt-1.5">Modifikasi Data Barang</p>
        </div>
        <button type="button" onclick="closeScopedModal('modalEditBarang')" class="p-3 text-slate-300 hover:text-rose-500 hover:bg-rose-50 rounded-3xl transition-all">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>
    </div>
    <form id="formEditBarang" onsubmit="return false;">
        <div class="p-10 space-y-6">
            <div>
                <label class="block text-[11px] font-black text-slate-400 uppercase tracking-[2px] mb-3 ml-1">ID Barang</label>
                <input type="text" id="edit_id" readonly class="w-full px-6 py-4 bg-slate-100 border-2 border-slate-200 rounded-2xl text-sm font-black text-slate-500 cursor-not-allowed shadow-sm">
            </div>
            <div>
                <label for="edit_nama" class="block text-[11px] font-black text-slate-400 uppercase tracking-[2px] mb-3 ml-1">Nama Barang</label>
                <input type="text" id="edit_nama" required placeholder="Sabun Mandi" class="w-full px-6 py-4 bg-slate-50 border-2 border-slate-100 rounded-2xl focus:outline-none focus:border-indigo-500/50 focus:ring-8 focus:ring-indigo-500/5 transition-all text-sm font-black text-slate-800 placeholder:text-slate-300 shadow-sm">
            </div>
            <div>
                <label for="edit_harga" class="block text-[11px] font-black text-slate-400 uppercase tracking-[2px] mb-3 ml-1">Harga (Rp)</label>
                <input type="number" id="edit_harga" required min="0" placeholder="5000" class="w-full px-6 py-4 bg-slate-50 border-2 border-slate-100 rounded-2xl focus:outline-none focus:border-indigo-500/50 focus:ring-8 focus:ring-indigo-500/5 transition-all text-sm font-black text-slate-800 placeholder:text-slate-300 shadow-sm">
            </div>
        </div>
        <div class="px-10 py-8 bg-slate-50/50 border-t border-slate-100 flex justify-between">
            <button type="button" id="btnHapusBarang" onclick="hapusBarang()" class="px-6 py-3.5 bg-rose-500 hover:bg-rose-600 text-white text-xs font-black rounded-2xl shadow-xl shadow-rose-200 transition-all active:scale-95 uppercase tracking-[2px] flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                Hapus
            </button>
            <div class="flex gap-3">
                <button type="button" onclick="closeScopedModal('modalEditBarang')" class="px-6 py-3.5 text-xs font-black text-slate-400 hover:text-slate-700 uppercase tracking-widest transition-colors">Batal</button>
                <button type="button" id="btnUbahBarang" onclick="ubahBarang()" class="px-8 py-3.5 bg-indigo-600 border border-indigo-700 text-white text-xs font-black rounded-2xl shadow-xl shadow-indigo-200 hover:bg-indigo-700 transition-all active:scale-95 uppercase tracking-[3px] flex items-center gap-2">
                    <svg id="spinnerUbah" class="w-4 h-4 animate-spin hidden" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path></svg>
                    <span id="txtUbah">Ubah</span>
                </button>
            </div>
        </div>
    </form>
</div>
