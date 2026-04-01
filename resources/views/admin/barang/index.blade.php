@extends('layouts.app')

@section('title', 'Daftar Barang')

@section('content')
<div class="relative min-h-[800px]">
    {{-- Header Section --}}
    <div class="mb-10 flex flex-col lg:flex-row lg:items-center lg:justify-between gap-8">
        <div>
            <h3 class="text-4xl font-black text-slate-900 tracking-tighter">Katalog Barang</h3>
            <p class="text-slate-500 font-semibold mt-1 tracking-tight">Manajemen data barang & cetak label harga.</p>
        </div>
        <div class="flex items-center gap-4">
            <span class="px-5 py-2.5 bg-slate-50 border border-slate-200 text-slate-600 text-[10px] font-black uppercase tracking-widest rounded-2xl hidden sm:block">
                {{ $barang->count() }} Item Terdaftar
            </span>
            <button type="button" id="btnPrintTnj" disabled
                    class="group flex items-center px-6 py-3.5 bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700 disabled:from-slate-300 disabled:to-slate-400 disabled:cursor-not-allowed text-white font-black rounded-2xl shadow-2xl shadow-emerald-200 disabled:shadow-slate-100 transition-all active:scale-95">
                <svg class="w-5 h-5 mr-3 group-hover:-translate-y-1 transition-transform duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                <span id="btnPrintText">Print Label TNJ</span>
            </button>
        </div>
    </div>

    {{-- Collection Card --}}
    <div class="bg-white rounded-[3rem] shadow-[0_32px_64px_-16px_rgba(0,0,0,0.05)] border border-slate-100 overflow-hidden ring-1 ring-slate-200/50">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/50">
                        <th class="px-8 py-6 text-[11px] font-black text-slate-400 border-none uppercase tracking-[4px] text-center w-20">
                            <label class="inline-flex items-center cursor-pointer">
                                <input type="checkbox" id="selectAll" class="w-5 h-5 rounded-lg border-2 border-slate-200 text-emerald-500 focus:ring-emerald-400 focus:ring-offset-0 cursor-pointer accent-emerald-500">
                            </label>
                        </th>
                        <th class="px-10 py-6 text-[11px] font-black text-slate-400 border-none uppercase tracking-[4px]">ID Barang</th>
                        <th class="px-10 py-6 text-[11px] font-black text-slate-400 border-none uppercase tracking-[4px]">Nama Barang</th>
                        <th class="px-10 py-6 text-[11px] font-black text-slate-400 border-none uppercase tracking-[4px]">Harga</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @foreach($barang as $item)
                    <tr class="group hover:bg-slate-50/70 transition-all duration-300 barang-row">
                        <td class="px-8 py-5 text-center">
                            <input type="checkbox" class="barang-checkbox w-5 h-5 rounded-lg border-2 border-slate-200 text-emerald-500 focus:ring-emerald-400 focus:ring-offset-0 cursor-pointer accent-emerald-500"
                                   value="{{ $item->id_barang }}" data-nama="{{ $item->nama }}" data-harga="{{ $item->harga }}">
                        </td>
                        <td class="px-10 py-5">
                            <span class="px-4 py-1.5 bg-slate-900 text-white text-[11px] font-black rounded-lg border border-slate-700 uppercase tracking-widest shadow-lg shadow-slate-200">
                                {{ $item->id_barang }}
                            </span>
                        </td>
                        <td class="px-10 py-5">
                            <div class="text-lg font-black text-slate-800 tracking-tight group-hover:text-emerald-600 transition-colors">{{ $item->nama }}</div>
                        </td>
                        <td class="px-10 py-5">
                            <span class="inline-flex items-center px-4 py-1.5 rounded-xl text-[12px] font-black bg-emerald-50 text-emerald-700 border border-emerald-100 tracking-wide">
                                Rp {{ number_format($item->harga, 0, ',', '.') }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @if($barang->isEmpty())
            <div class="text-center py-32 bg-slate-50/20">
                <div class="w-24 h-24 mx-auto bg-slate-100 rounded-[2rem] flex items-center justify-center mb-8 shadow-inner">
                    <svg class="w-12 h-12 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                </div>
                <h5 class="text-xl font-black text-slate-300 uppercase tracking-[6px]">Belum Ada Barang</h5>
            </div>
        @endif
    </div>

    {{-- ============================================== --}}
    {{-- MODAL: Print Label TNJ (Kertas Koordinat)      --}}
    {{-- ============================================== --}}
    <div id="scopedModalOverlay" class="absolute inset-0 bg-slate-900/40 backdrop-blur-md z-[500] hidden flex items-center justify-center p-8 transition-all duration-300">

        <div id="modalPrintTnj" class="bg-white rounded-[3rem] shadow-2xl w-full max-w-2xl transform transition-all duration-300 scale-95 opacity-0 hidden overflow-hidden ring-1 ring-white/20">
            {{-- Modal Header --}}
            <div class="px-10 py-8 border-b border-slate-50 flex items-center justify-between bg-gradient-to-br from-emerald-50/50 via-white to-teal-50/30">
                <div>
                    <h5 class="text-2xl font-black text-slate-900 tracking-tighter">Cetak Label TNJ</h5>
                    <p class="text-[10px] text-emerald-500 font-bold uppercase tracking-[4px] mt-1.5">Pilih Posisi Awal Pada Kertas</p>
                </div>
                <button type="button" onclick="closeScopedModal('modalPrintTnj')" class="p-3 text-slate-300 hover:text-rose-500 hover:bg-rose-50 rounded-3xl transition-all">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <form id="formPrintTnj" action="{{ route('admin.print-label') }}" method="POST" target="_blank">
                @csrf
                {{-- Hidden ids --}}
                <div id="hiddenIdsContainer"></div>
                <input type="hidden" name="x" id="inputX" value="1">
                <input type="hidden" name="y" id="inputY" value="1">

                <div class="p-8 space-y-6">
                    {{-- Info --}}
                    <div class="flex items-center gap-3 px-5 py-3 bg-amber-50 border border-amber-100 rounded-2xl">
                        <svg class="w-5 h-5 text-amber-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <p class="text-xs font-bold text-amber-700">Klik sel pada kertas di bawah untuk menentukan posisi awal cetak label. <span id="selectedCount" class="text-emerald-600">0 barang</span> terpilih.</p>
                    </div>

                    {{-- Visual TNJ Paper Grid --}}
                    <div class="flex justify-center">
                        <div class="border-2 border-slate-200 rounded-2xl overflow-hidden shadow-inner bg-white" style="width: 340px;">
                            {{-- Paper header --}}
                            <div class="bg-slate-50 border-b border-slate-200 px-4 py-2 flex items-center justify-between">
                                <span class="text-[9px] font-black text-slate-400 uppercase tracking-[3px]">Kertas A4 — 5×8 Grid</span>
                                <span id="coordDisplay" class="text-[10px] font-black text-emerald-600 bg-emerald-50 px-3 py-1 rounded-lg border border-emerald-100">X:1 Y:1</span>
                            </div>
                            {{-- Grid table --}}
                            <table id="tnjGrid" class="w-full border-collapse" style="table-layout: fixed;">
                                @for($r = 1; $r <= 8; $r++)
                                <tr>
                                    @for($c = 1; $c <= 5; $c++)
                                    <td class="tnj-cell border border-slate-100 text-center cursor-pointer transition-all duration-200 hover:bg-emerald-50 select-none"
                                        data-x="{{ $c }}" data-y="{{ $r }}"
                                        style="height: 38px; width: 20%; font-size: 9px; color: #94a3b8;">
                                        <span class="cell-label">{{ $c }},{{ $r }}</span>
                                    </td>
                                    @endfor
                                </tr>
                                @endfor
                            </table>
                        </div>
                    </div>

                    {{-- Coordinate display --}}
                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-slate-50 rounded-2xl p-4 border border-slate-100 text-center">
                            <div class="text-[10px] font-black text-slate-400 uppercase tracking-[2px] mb-1">Kolom (X)</div>
                            <div id="displayX" class="text-3xl font-black text-emerald-600">1</div>
                        </div>
                        <div class="bg-slate-50 rounded-2xl p-4 border border-slate-100 text-center">
                            <div class="text-[10px] font-black text-slate-400 uppercase tracking-[2px] mb-1">Baris (Y)</div>
                            <div id="displayY" class="text-3xl font-black text-emerald-600">1</div>
                        </div>
                    </div>
                </div>

                {{-- Footer --}}
                <div class="px-10 py-8 bg-slate-50/50 border-t border-slate-100 flex justify-end gap-3">
                    <button type="button" onclick="closeScopedModal('modalPrintTnj')" class="px-6 py-3.5 text-xs font-black text-slate-400 hover:text-slate-700 uppercase tracking-widest transition-colors">Batal</button>
                    <button type="submit" class="px-8 py-3.5 bg-emerald-600 border border-emerald-700 text-white text-xs font-black rounded-2xl shadow-xl shadow-emerald-200 hover:bg-emerald-700 transition-all active:scale-95 uppercase tracking-[2px]">
                        <span class="flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                            Cetak PDF
                        </span>
                    </button>
                </div>
            </form>
        </div>

    </div>
</div>
@endsection

@push('js')
<script src="{{ asset('js/barang.js') }}"></script>
@endpush
