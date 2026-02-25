@extends('layouts.app')

@section('title', 'Tampilan Kategori')

@section('content')
<div class="relative min-h-[600px]">
    {{-- Header Section --}}
    <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-6">
        <div>
            <h3 class="text-3xl font-black text-slate-800 tracking-tighter">Kategori Buku</h3>
            <p class="text-slate-500 font-medium mt-1">Kelola klasifikasi koleksi perpustakaan Anda.</p>
        </div>
        <button type="button" onclick="openScopedModal('modalTambahKategori')" class="group flex items-center px-6 py-3 bg-slate-900 border border-slate-700 hover:bg-violet-600 text-white font-bold rounded-2xl shadow-xl hover:shadow-violet-200 transition-all active:scale-95">
            <svg class="w-5 h-5 mr-2 group-hover:rotate-90 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
            Tambah Baru
        </button>
    </div>

    {{-- Main Table Area --}}
    <div class="bg-white rounded-[2.5rem] shadow-2xl shadow-slate-200/50 border border-slate-100 overflow-hidden ring-1 ring-slate-200/50">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/50">
                        <th class="px-8 py-5 text-[11px] font-black text-slate-400 uppercase tracking-[3px] w-20">No</th>
                        <th class="px-8 py-5 text-[11px] font-black text-slate-400 uppercase tracking-[3px]">Kategori</th>
                        <th class="px-8 py-5 text-[11px] font-black text-slate-400 uppercase tracking-[3px] text-center w-48">Operasi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @foreach($kategori as $index => $item)
                    <tr class="hover:bg-slate-50/50 transition-colors group">
                        <td class="px-8 py-5 text-sm font-black text-slate-300">{{ $index + 1 }}</td>
                        <td class="px-8 py-5">
                            <span class="text-base font-bold text-slate-700 group-hover:text-violet-600 transition-colors">{{ $item->nama_kategori }}</span>
                        </td>
                        <td class="px-8 py-5 text-center">
                            <div class="flex items-center justify-center space-x-2">
                                <button type="button" 
                                        class="btn-edit-kategori p-3 bg-white border border-slate-100 rounded-xl text-slate-400 hover:text-blue-500 hover:border-blue-200 hover:shadow-lg transition-all"
                                        data-id="{{ $item->idkategori }}"
                                        data-name="{{ $item->nama_kategori }}"
                                        data-url="{{ route('admin.kategori.update', $item->idkategori) }}">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                </button>
                                <form action="{{ route('admin.kategori.destroy', $item->idkategori) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="p-3 bg-white border border-slate-100 rounded-xl text-slate-400 hover:text-rose-500 hover:border-rose-200 hover:shadow-lg transition-all"
                                            onclick="return confirm('Hapus kategori ini?')">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @if($kategori->isEmpty())
            <div class="text-center py-24 bg-slate-50/30">
                <div class="inline-flex items-center justify-center w-24 h-24 bg-white rounded-full shadow-inner mb-6">
                    <svg class="w-10 h-10 text-slate-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                </div>
                <h5 class="text-lg font-black text-slate-400 uppercase tracking-widest">Data Kosong</h5>
            </div>
        @endif
    </div>

    {{-- Scoped Modals Container --}}
    <div id="scopedModalOverlay" class="absolute inset-x-0 inset-y-0 bg-slate-900/40 backdrop-blur-md z-[500] hidden flex items-center justify-center p-8 transition-all duration-300">
        
        {{-- Modal Tambah --}}
        <div id="modalTambahKategori" class="bg-white rounded-[2.5rem] shadow-2xl w-full max-w-lg transform transition-all duration-300 scale-95 opacity-0 hidden overflow-hidden ring-1 ring-white/20">
            <div class="px-10 py-8 border-b border-slate-100 flex items-center justify-between bg-gradient-to-r from-violet-50/50 to-white">
                <div>
                    <h5 class="text-2xl font-black text-slate-800 tracking-tighter">Tambah Kategori</h5>
                    <p class="text-[10px] text-slate-400 font-bold uppercase tracking-[2px] mt-1">Entri data kategori baru</p>
                </div>
                <button type="button" onclick="closeScopedModal('modalTambahKategori')" class="p-2 text-slate-300 hover:text-rose-500 hover:bg-rose-50 rounded-2xl transition-all">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            <form action="{{ route('admin.kategori.store') }}" method="POST">
                @csrf
                <div class="p-10">
                    <div class="space-y-6">
                        <div>
                            <label for="nama_kategori" class="block text-[11px] font-black text-slate-400 uppercase tracking-[2px] mb-2.5 ml-1">Label Kategori</label>
                            <input type="text" class="w-full px-6 py-4 bg-slate-50 border-2 border-slate-100 rounded-2xl focus:outline-none focus:border-violet-500/50 focus:ring-4 focus:ring-violet-500/5 transition-all text-sm font-bold text-slate-700 placeholder:text-slate-300" id="nama_kategori" name="nama_kategori" placeholder="Misal: Fiksi, Eksperimen" required>
                        </div>
                    </div>
                </div>
                <div class="px-10 py-8 bg-slate-50/50 border-t border-slate-100 flex justify-end gap-3">
                    <button type="button" onclick="closeScopedModal('modalTambahKategori')" class="px-6 py-3 text-sm font-black text-slate-400 hover:text-slate-600 uppercase tracking-wide">Batalkan</button>
                    <button type="submit" class="px-10 py-3 bg-violet-600 text-white text-sm font-black rounded-2xl shadow-lg shadow-violet-200 hover:bg-violet-700 transition-all active:scale-95 uppercase tracking-widest">
                        Simpan Data
                    </button>
                </div>
            </form>
        </div>

        {{-- Modal Edit --}}
        <div id="modalEditKategori" class="bg-white rounded-[2.5rem] shadow-2xl w-full max-w-lg transform transition-all duration-300 scale-95 opacity-0 hidden overflow-hidden ring-1 ring-white/20">
            <div class="px-10 py-8 border-b border-slate-100 flex items-center justify-between bg-gradient-to-r from-blue-50/50 to-white">
                <div>
                    <h5 class="text-2xl font-black text-slate-800 tracking-tighter">Perbarui Kategori</h5>
                    <p class="text-[10px] text-blue-400 font-bold uppercase tracking-[2px] mt-1">Ubah identitas kategori</p>
                </div>
                <button type="button" onclick="closeScopedModal('modalEditKategori')" class="p-2 text-slate-300 hover:text-rose-500 hover:bg-rose-50 rounded-2xl transition-all">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            <form id="formEditKategori" action="" method="POST">
                @csrf
                @method('PUT')
                <div class="p-10">
                    <div class="space-y-6">
                        <div>
                            <label for="edit_nama_kategori" class="block text-[11px] font-black text-slate-400 uppercase tracking-[2px] mb-2.5 ml-1">Label Kategori</label>
                            <input type="text" class="w-full px-6 py-4 bg-slate-50 border-2 border-slate-100 rounded-2xl focus:outline-none focus:border-blue-500/50 focus:ring-4 focus:ring-blue-500/5 transition-all text-sm font-bold text-slate-700" id="edit_nama_kategori" name="nama_kategori" required>
                        </div>
                    </div>
                </div>
                <div class="px-10 py-8 bg-slate-50/50 border-t border-slate-100 flex justify-end gap-3">
                    <button type="button" onclick="closeScopedModal('modalEditKategori')" class="px-6 py-3 text-sm font-black text-slate-400 hover:text-slate-600 uppercase tracking-wide">Batalkan</button>
                    <button type="submit" class="px-10 py-3 bg-blue-600 text-white text-sm font-black rounded-2xl shadow-lg shadow-blue-200 hover:bg-blue-700 transition-all active:scale-95 uppercase tracking-widest">
                        Update Data
                    </button>
                </div>
            </form>
        </div>

    </div>
</div>
@endsection

@push('js')
<script src="{{ asset('js/kategori.js') }}"></script>
@endpush
