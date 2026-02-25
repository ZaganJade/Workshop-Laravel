@extends('layouts.app')

@section('title', 'Tampilan Buku')

@section('content')
<div class="relative min-h-[800px]">
    {{-- Header Section --}}
    <div class="mb-10 flex flex-col lg:flex-row lg:items-center lg:justify-between gap-8">
        <div>
            <h3 class="text-4xl font-black text-slate-900 tracking-tighter">Katalog Buku</h3>
            <p class="text-slate-500 font-semibold mt-1 tracking-tight">Manajemen database literatur perpustakaan Anda.</p>
        </div>
        <div class="flex items-center gap-4">
            <span class="px-5 py-2.5 bg-slate-50 border border-slate-200 text-slate-600 text-[10px] font-black uppercase tracking-widest rounded-2xl hidden sm:block">
                {{ $buku->count() }} Koleksi Aktif
            </span>
            <button type="button" onclick="openScopedModal('modalTambahBuku')" class="group flex items-center px-8 py-3.5 bg-gradient-to-r from-violet-600 to-indigo-600 hover:from-violet-700 hover:to-indigo-700 text-white font-black rounded-2xl shadow-2xl shadow-violet-200 transition-all active:scale-95">
                <svg class="w-6 h-6 mr-3 group-hover:rotate-180 transition-transform duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                Registrasi Buku
            </button>
        </div>
    </div>

    {{-- Collection Card --}}
    <div class="bg-white rounded-[3rem] shadow-[0_32px_64px_-16px_rgba(0,0,0,0.05)] border border-slate-100 overflow-hidden ring-1 ring-slate-200/50">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/50">
                        <th class="px-10 py-6 text-[11px] font-black text-slate-400 border-none uppercase tracking-[4px]">Signatur</th>
                        <th class="px-10 py-6 text-[11px] font-black text-slate-400 border-none uppercase tracking-[4px]">Judul & Metadata</th>
                        <th class="px-10 py-6 text-[11px] font-black text-slate-400 border-none uppercase tracking-[4px]">Klasifikasi</th>
                        <th class="px-10 py-6 text-[11px] font-black text-slate-400 border-none uppercase tracking-[4px] text-center w-56">Kontrol</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @foreach($buku as $item)
                    <tr class="group hover:bg-slate-50/70 transition-all duration-300">
                        <td class="px-10 py-6">
                            <span class="px-4 py-1.5 bg-slate-900 text-white text-[11px] font-black rounded-lg border border-slate-700 uppercase tracking-widest shadow-lg shadow-slate-200">
                                {{ $item->kode }}
                            </span>
                        </td>
                        <td class="px-10 py-6">
                            <div class="text-lg font-black text-slate-800 tracking-tight group-hover:text-violet-600 transition-colors">{{ $item->judul }}</div>
                            <div class="flex items-center mt-1 text-xs text-slate-400 font-bold uppercase tracking-wider">
                                <span class="bg-slate-100 px-2 py-0.5 rounded mr-2 italic">{{ $item->pengarang }}</span>
                                <span class="opacity-40">•</span>
                                <span class="ml-2">ID: {{ str_pad($item->idbuku, 4, '0', STR_PAD_LEFT) }}</span>
                            </div>
                        </td>
                        <td class="px-10 py-6">
                            <span class="inline-flex items-center px-4 py-1.5 rounded-xl text-[10px] font-black bg-indigo-50 text-indigo-700 border border-indigo-100 uppercase tracking-widest">
                                {{ $item->kategori->nama_kategori ?? 'Umum' }}
                            </span>
                        </td>
                        <td class="px-10 py-6">
                            <div class="flex items-center justify-center space-x-3">
                                <button type="button" 
                                        class="btn-edit-buku p-3.5 bg-white border border-slate-100 rounded-2xl text-slate-400 hover:text-indigo-600 hover:border-indigo-200 hover:shadow-xl hover:-translate-y-1 transition-all"
                                        data-id="{{ $item->idbuku }}"
                                        data-kode="{{ $item->kode }}"
                                        data-judul="{{ $item->judul }}"
                                        data-pengarang="{{ $item->pengarang }}"
                                        data-idkategori="{{ $item->idkategori }}"
                                        data-url="{{ route('admin.buku.update', $item->idbuku) }}">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                </button>
                                <form action="{{ route('admin.buku.destroy', $item->idbuku) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="p-3.5 bg-white border border-slate-100 rounded-2xl text-slate-400 hover:text-rose-600 hover:border-rose-200 hover:shadow-xl hover:-translate-y-1 transition-all"
                                            onclick="return confirm('Musnahkan data buku ini dari sistem?')">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @if($buku->isEmpty())
            <div class="text-center py-32 bg-slate-50/20">
                <div class="w-24 h-24 mx-auto bg-slate-100 rounded-[2rem] flex items-center justify-center mb-8 shadow-inner">
                    <svg class="w-12 h-12 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5s3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                </div>
                <h5 class="text-xl font-black text-slate-300 uppercase tracking-[6px]">Koleksi Nihil</h5>
            </div>
        @endif
    </div>

    {{-- Scoped Modals Container --}}
    <div id="scopedModalOverlay" class="absolute inset-0 bg-slate-900/40 backdrop-blur-md z-[500] hidden flex items-center justify-center p-8 transition-all duration-300">
        
        {{-- Modal Tambah --}}
        <div id="modalTambahBuku" class="bg-white rounded-[3rem] shadow-2xl w-full max-w-2xl transform transition-all duration-300 scale-95 opacity-0 hidden overflow-hidden ring-1 ring-white/20">
            <div class="px-12 py-10 border-b border-slate-50 flex items-center justify-between bg-gradient-to-br from-violet-50/50 via-white to-fuchsia-50/30">
                <div>
                    <h5 class="text-3xl font-black text-slate-900 tracking-tighter">Registrasi Buku</h5>
                    <p class="text-[10px] text-slate-400 font-bold uppercase tracking-[4px] mt-1.5">Arsip literatur baru</p>
                </div>
                <button type="button" onclick="closeScopedModal('modalTambahBuku')" class="p-3 text-slate-300 hover:text-rose-500 hover:bg-rose-50 rounded-3xl transition-all">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            <form action="{{ route('admin.buku.store') }}" method="POST">
                @csrf
                <div class="p-12">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                        <div class="space-y-8">
                            <div>
                                <label for="kode" class="block text-[11px] font-black text-slate-400 uppercase tracking-[2px] mb-3 ml-1">Signatur Kode</label>
                                <input type="text" class="w-full px-6 py-4.5 bg-slate-50 border-2 border-slate-100 rounded-2xl focus:outline-none focus:border-violet-500/50 focus:ring-8 focus:ring-violet-500/5 transition-all text-sm font-black text-slate-800 placeholder:text-slate-300 shadow-sm" id="kode" name="kode" placeholder="Misal: L-001" required>
                            </div>
                            <div>
                                <label for="idkategori" class="block text-[11px] font-black text-slate-400 uppercase tracking-[2px] mb-3 ml-1">Klasifikasi Koleksi</label>
                                <select class="w-full px-6 py-4.5 bg-slate-50 border-2 border-slate-100 rounded-2xl focus:outline-none focus:border-violet-500/50 focus:ring-8 focus:ring-violet-500/5 transition-all text-sm font-black text-slate-800 shadow-sm" id="idkategori" name="idkategori" required>
                                    <option value="" disabled selected>Pilih Kategori</option>
                                    @foreach($kategori as $kat)
                                        <option value="{{ $kat->idkategori }}">{{ $kat->nama_kategori }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="space-y-8">
                            <div>
                                <label for="judul" class="block text-[11px] font-black text-slate-400 uppercase tracking-[2px] mb-3 ml-1">Nominal Judul</label>
                                <input type="text" class="w-full px-6 py-4.5 bg-slate-50 border-2 border-slate-100 rounded-2xl focus:outline-none focus:border-violet-500/50 focus:ring-8 focus:ring-violet-500/5 transition-all text-sm font-black text-slate-800 placeholder:text-slate-300 shadow-sm" id="judul" name="judul" placeholder="Judul Buku Lengkap" required>
                            </div>
                            <div>
                                <label for="pengarang" class="block text-[11px] font-black text-slate-400 uppercase tracking-[2px] mb-3 ml-1">Nama Penulis</label>
                                <input type="text" class="w-full px-6 py-4.5 bg-slate-50 border-2 border-slate-100 rounded-2xl focus:outline-none focus:border-violet-500/50 focus:ring-8 focus:ring-violet-500/5 transition-all text-sm font-black text-slate-800 placeholder:text-slate-300 shadow-sm" id="pengarang" name="pengarang" placeholder="Author" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="px-12 py-10 bg-slate-50/50 border-t border-slate-100 flex justify-end gap-4">
                    <button type="button" onclick="closeScopedModal('modalTambahBuku')" class="px-8 py-4 text-xs font-black text-slate-400 hover:text-slate-700 uppercase tracking-widest transition-colors">Aborsi Proses</button>
                    <button type="submit" class="px-12 py-4 bg-slate-900 border border-slate-700 text-white text-xs font-black rounded-[1.5rem] shadow-2xl hover:bg-violet-600 transition-all active:scale-95 uppercase tracking-[3px]">
                        Arsipkan Buku
                    </button>
                </div>
            </form>
        </div>

        {{-- Modal Edit --}}
        <div id="modalEditBuku" class="bg-white rounded-[3rem] shadow-2xl w-full max-w-2xl transform transition-all duration-300 scale-95 opacity-0 hidden overflow-hidden ring-1 ring-white/20">
            <div class="px-12 py-10 border-b border-slate-50 flex items-center justify-between bg-gradient-to-br from-indigo-50/50 via-white to-white">
                <div>
                    <h5 class="text-3xl font-black text-slate-900 tracking-tighter">Modifikasi Data</h5>
                    <p class="text-[10px] text-indigo-400 font-bold uppercase tracking-[4px] mt-1.5">Pembaruan entitas koleksi</p>
                </div>
                <button type="button" onclick="closeScopedModal('modalEditBuku')" class="p-3 text-slate-300 hover:text-rose-500 hover:bg-rose-50 rounded-3xl transition-all">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            <form id="formEditBuku" action="" method="POST">
                @csrf
                @method('PUT')
                <div class="p-12">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                        <div class="space-y-8">
                            <div>
                                <label for="edit_kode" class="block text-[11px] font-black text-slate-400 uppercase tracking-[2px] mb-3 ml-1">Signatur Kode</label>
                                <input type="text" class="w-full px-6 py-4.5 bg-slate-50 border-2 border-slate-100 rounded-2xl focus:outline-none focus:border-indigo-500/50 focus:ring-8 focus:ring-indigo-500/5 transition-all text-sm font-black text-slate-800 shadow-sm" id="edit_kode" name="kode" required>
                            </div>
                            <div>
                                <label for="edit_idkategori" class="block text-[11px] font-black text-slate-400 uppercase tracking-[2px] mb-3 ml-1">Klasifikasi Koleksi</label>
                                <select class="w-full px-6 py-4.5 bg-slate-50 border-2 border-slate-100 rounded-2xl focus:outline-none focus:border-indigo-500/50 focus:ring-8 focus:ring-indigo-500/5 transition-all text-sm font-black text-slate-800 shadow-sm" id="edit_idkategori" name="idkategori" required>
                                    @foreach($kategori as $kat)
                                        <option value="{{ $kat->idkategori }}">{{ $kat->nama_kategori }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="space-y-8">
                            <div>
                                <label for="edit_judul" class="block text-[11px] font-black text-slate-400 uppercase tracking-[2px] mb-3 ml-1">Nominal Judul</label>
                                <input type="text" class="w-full px-6 py-4.5 bg-slate-50 border-2 border-slate-100 rounded-2xl focus:outline-none focus:border-indigo-500/50 focus:ring-8 focus:ring-indigo-500/5 transition-all text-sm font-black text-slate-800 shadow-sm" id="edit_judul" name="judul" required>
                            </div>
                            <div>
                                <label for="edit_pengarang" class="block text-[11px] font-black text-slate-400 uppercase tracking-[2px] mb-3 ml-1">Nama Penulis</label>
                                <input type="text" class="w-full px-6 py-4.5 bg-slate-50 border-2 border-slate-100 rounded-2xl focus:outline-none focus:border-indigo-500/50 focus:ring-8 focus:ring-indigo-500/5 transition-all text-sm font-black text-slate-800 shadow-sm" id="edit_pengarang" name="pengarang" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="px-12 py-10 bg-slate-50/50 border-t border-slate-100 flex justify-end gap-4">
                    <button type="button" onclick="closeScopedModal('modalEditBuku')" class="px-8 py-4 text-xs font-black text-slate-400 hover:text-slate-700 uppercase tracking-widest transition-colors">Batal Ubah</button>
                    <button type="submit" class="px-12 py-4 bg-indigo-600 text-white text-xs font-black rounded-[1.5rem] shadow-2xl shadow-indigo-100 hover:bg-indigo-700 transition-all active:scale-95 uppercase tracking-[3px]">
                        Update Arsip
                    </button>
                </div>
            </form>
        </div>

    </div>
</div>
@endsection

@push('js')
<script src="{{ asset('js/buku.js') }}"></script>
@endpush
