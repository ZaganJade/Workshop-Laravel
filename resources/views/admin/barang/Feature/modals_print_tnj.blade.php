{{-- Modal Cetak Label TNJ --}}
<div class="modal fade" id="modalPrintTnj" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content" style="border-radius: 24px; border: none; overflow: hidden;">
            <div class="modal-header border-0 p-4 bg-success text-white">
                <h5 class="modal-title font-weight-bold"><i class="mdi mdi-printer me-2"></i>Cetak Label Harga (TNJ)</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formPrintTnj" action="{{ route('admin.print-label') }}" method="POST" target="_blank">
                @csrf
                {{-- Hidden ids --}}
                <div id="hiddenIdsContainer"></div>
                <input type="hidden" name="x" id="inputX" value="1">
                <input type="hidden" name="y" id="inputY" value="1">

                <div class="modal-body p-4">
                    <div class="alert alert-info border-0 shadow-sm mb-4" style="border-radius: 12px; background: #f0f7ff;">
                        <small class="text-primary font-weight-bold d-flex align-items-center">
                            <i class="mdi mdi-information-outline me-2 fs-5"></i> 
                            Pilih posisi awal cetak pada grid kertas di bawah (A4 5x8).
                        </small>
                    </div>

                    <div class="d-flex justify-content-center mb-4">
                        <div class="border rounded-3 overflow-hidden shadow-sm bg-white" style="width: 100%; max-width: 300px;">
                            <div class="bg-light border-bottom px-3 py-2 text-center">
                                <span class="text-uppercase font-weight-bold text-muted" style="font-size: 0.65rem; letter-spacing: 1px;">Kertas A4 Grid</span>
                            </div>
                            <table id="tnjGrid" class="table table-bordered m-0" style="table-layout: fixed; border-collapse: collapse;">
                                @for($r = 1; $r <= 8; $r++)
                                <tr>
                                    @for($c = 1; $c <= 5; $c++)
                                    <td class="tnj-cell text-center cursor-pointer transition-all"
                                        data-x="{{ $c }}" data-y="{{ $r }}"
                                        style="height: 35px; width: 20%; padding: 0; vertical-align: middle; font-size: 0.6rem; cursor: pointer;">
                                        {{ $c }},{{ $r }}
                                    </td>
                                    @endfor
                                </tr>
                                @endfor
                            </table>
                        </div>
                    </div>

                    <div class="row g-2">
                        <div class="col-6">
                            <div class="p-3 border rounded-3 bg-light text-center">
                                <small class="text-muted text-uppercase d-block mb-1" style="font-size: 0.6rem; font-weight: 800;">Kolom (X)</small>
                                <span id="displayX" class="h4 font-weight-bold text-success mb-0">1</span>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="p-3 border rounded-3 bg-light text-center">
                                <small class="text-muted text-uppercase d-block mb-1" style="font-size: 0.6rem; font-weight: 800;">Baris (Y)</small>
                                <span id="displayY" class="h4 font-weight-bold text-success mb-0">1</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 p-4 pt-0">
                    <button type="button" class="btn btn-light font-weight-bold" data-bs-dismiss="modal" style="border-radius: 12px; padding: 12px 20px;">Batal</button>
                    <button type="submit" class="btn btn-success text-white font-weight-bold shadow-sm" style="border-radius: 12px; padding: 12px 20px;">
                        <i class="mdi mdi-file-pdf-box me-1"></i> Generate PDF
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .tnj-cell:hover { background-color: #f0fdf4 !important; }
    .tnj-cell.selected { background-color: #22c55e !important; color: white !important; font-weight: bold; }
</style>
