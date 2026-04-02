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
