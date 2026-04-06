@extends('layouts.pos_layout')

@section('title', 'Pesanan Tertunda')

@section('content')
<div class="max-w-6xl mx-auto flex flex-col gap-8">
    {{-- Header Section --}}
    <div class="flex flex-col md:flex-row items-center justify-between gap-6" data-aos="fade-down">
        <div class="flex items-center gap-6">
            <a href="{{ route('pos') }}" class="w-14 h-14 bg-white rounded-2xl flex items-center justify-center text-slate-400 hover:text-indigo-600 hover:shadow-xl transition-all duration-500 active:scale-90 border border-slate-100 italic font-black shadow-sm group">
                <i class="fas fa-arrow-left group-hover:-translate-x-1 transition-transform"></i>
            </a>
            <div>
                <h2 class="text-4xl font-black text-slate-900 tracking-tighter leading-none italic mb-2">Pesanan <span class="text-indigo-600">Tertunda.</span></h2>
                <p class="text-xs text-slate-400 font-bold uppercase tracking-[0.2em] italic">Selesaikan pembayaran untuk memproses pesanan Anda.</p>
            </div>
        </div>
        
        <div class="px-6 py-3 bg-indigo-50 rounded-2xl border border-indigo-100 flex items-center gap-3">
            <div class="w-2 h-2 bg-indigo-500 rounded-full animate-pulse"></div>
            <span class="text-[10px] font-black text-indigo-600 uppercase tracking-widest italic">Menunggu Pembayaran</span>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-8">
        @forelse($pesanans as $pesanan)
            <div class="glass-card rounded-[2.5rem] overflow-hidden group hover:shadow-2xl transition-all duration-700 border-white/50" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                <div class="flex flex-col lg:flex-row">
                    {{-- Summary Column --}}
                    <div class="lg:w-1/3 bg-slate-50/50 p-10 border-b lg:border-b-0 lg:border-r border-slate-100 relative overflow-hidden">
                        <div class="absolute -top-10 -left-10 w-40 h-40 bg-indigo-600/5 rounded-full blur-3xl group-hover:bg-indigo-600/10 transition-all duration-700"></div>
                        
                        <div class="relative z-10">
                            <div class="flex items-center justify-between mb-8">
                                <span class="px-4 py-1.5 bg-orange-100 text-orange-600 text-[10px] font-black uppercase tracking-widest rounded-full italic">Unpaid</span>
                                <span class="text-[10px] text-slate-400 font-bold italic">{{ $pesanan->created_at->format('d M Y, H:i') }}</span>
                            </div>
                            
                            <h3 class="text-3xl font-black text-slate-900 tracking-tighter mb-1 italic">#{{ $pesanan->idpesanan }}</h3>
                            <p class="text-slate-500 text-sm font-semibold mb-8 italic">Atas Nama: <span class="text-slate-800 font-black uppercase tracking-tight ml-1">{{ $pesanan->nama }}</span></p>
                            
                            <div class="bg-white/80 rounded-3xl p-6 border border-white shadow-inner">
                                <div class="flex items-center justify-between mb-4">
                                    <span class="text-[10px] text-slate-400 font-black uppercase tracking-widest italic">Item Count</span>
                                    <span class="text-sm font-black text-slate-900">{{ $pesanan->details->count() }} Produk</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-[10px] text-slate-400 font-black uppercase tracking-widest italic">Total Bill</span>
                                    <span class="text-2xl font-black text-indigo-600 italic tracking-tight">Rp {{ number_format($pesanan->total, 0, ',', '.') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Action Column --}}
                    <div class="lg:w-2/3 p-10 flex flex-col justify-center">
                        @if($pesanan->payment && $pesanan->payment->raw_response)
                            @php
                                $raw = $pesanan->payment->raw_response;
                                $paymentType = $pesanan->payment->payment_type ?? ($raw['payment_type'] ?? null);
                            @endphp

                            <div class="flex items-center gap-6 mb-8">
                                <div class="w-16 h-16 bg-slate-900 rounded-2xl flex items-center justify-center text-white text-2xl shadow-xl">
                                    @if($paymentType == 'qris') <i class="fas fa-qrcode"></i>
                                    @elseif($paymentType == 'bank_transfer' || $paymentType == 'echannel') <i class="fas fa-university"></i>
                                    @elseif($paymentType == 'cstore') <i class="fas fa-store"></i>
                                    @else <i class="fas fa-credit-card"></i>
                                    @endif
                                </div>
                                <div>
                                    <h4 class="text-lg font-black text-slate-900 uppercase tracking-tight leading-none italic mb-1">{{ str_replace('_', ' ', $paymentType) }}</h4>
                                    <p class="text-xs text-slate-400 font-bold italic">Gunakan detail di bawah ini untuk menyelesaikan pembayaran.</p>
                                </div>
                            </div>

                            @if($paymentType == 'qris')
                                <div class="flex flex-col md:flex-row items-center gap-10">
                                    @php
                                        $qrUrl = null;
                                        if (isset($raw['actions'])) {
                                            foreach ($raw['actions'] as $action) {
                                                if ($action['name'] == 'generate-qr-code') $qrUrl = $action['url'];
                                            }
                                        }
                                    @endphp
                                    @if($qrUrl)
                                        <div class="p-4 bg-white rounded-3xl border-2 border-slate-100 shadow-xl group/qr">
                                            <img src="{{ $qrUrl }}" alt="QR Code" class="w-40 h-40 rounded-xl group-hover/qr:scale-105 transition-transform duration-500">
                                        </div>
                                    @else
                                        <div class="w-40 h-40 bg-slate-100 rounded-3xl flex items-center justify-center text-slate-400 text-xs text-center p-6 italic font-bold">QR Code Expired</div>
                                    @endif
                                    
                                    <div class="flex-1 space-y-4">
                                        <h5 class="text-sm font-black text-slate-800 uppercase tracking-widest italic border-b border-slate-100 pb-2">Instruksi Bayar:</h5>
                                        <ul class="space-y-3 text-xs text-slate-500 font-semibold italic">
                                            <li class="flex items-start gap-3">
                                                <span class="w-5 h-5 rounded-full bg-indigo-600 text-white flex-shrink-0 flex items-center justify-center text-[10px] font-black not-italic">1</span>
                                                <span>Buka aplikasi E-Wallet Anda (Gopay/OVO/Dana/dll).</span>
                                            </li>
                                            <li class="flex items-start gap-3">
                                                <span class="w-5 h-5 rounded-full bg-indigo-600 text-white flex-shrink-0 flex items-center justify-center text-[10px] font-black not-italic">2</span>
                                                <span>Pilih menu <span class="text-indigo-600 font-black uppercase">Scan QRIS</span>.</span>
                                            </li>
                                            <li class="flex items-start gap-3">
                                                <span class="w-5 h-5 rounded-full bg-indigo-600 text-white flex-shrink-0 flex items-center justify-center text-[10px] font-black not-italic">3</span>
                                                <span>Scan kode QR di samping dan konfirmasi bayar.</span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>

                            @elseif($paymentType == 'bank_transfer' || $paymentType == 'echannel')
                                @php
                                    $vaNumber = null;
                                    $bankName = strtoupper($pesanan->payment->bank ?? '');
                                    if (isset($raw['va_numbers'][0]['va_number'])) {
                                        $vaNumber = $raw['va_numbers'][0]['va_number'];
                                        $bankName = strtoupper($raw['va_numbers'][0]['bank'] ?? $bankName);
                                    } elseif (isset($raw['bill_key'])) {
                                        $vaNumber = $raw['bill_key'];
                                        $bankName = 'MANDIRI (BILL: ' . $raw['biller_code'] . ')';
                                    } elseif (isset($raw['permata_va_number'])) {
                                        $vaNumber = $raw['permata_va_number'];
                                        $bankName = 'PERMATA';
                                    }
                                @endphp
                                <div class="bg-white rounded-[2rem] p-8 border border-white shadow-inner flex flex-col md:flex-row items-center gap-10">
                                    <div class="text-center md:text-left">
                                        <p class="text-[10px] text-slate-400 font-black uppercase tracking-widest mb-1 italic">Bank Tujuan</p>
                                        <h5 class="text-2xl font-black text-slate-900 tracking-tighter italic">{{ $bankName }}</h5>
                                    </div>
                                    <div class="flex-1 w-full relative">
                                        <p class="text-[10px] text-slate-400 font-black uppercase tracking-widest mb-1 italic text-center md:text-left">Virtual Account</p>
                                        <div class="flex items-center justify-between bg-slate-50 p-4 rounded-2xl border border-slate-100">
                                            <span class="text-2xl font-black text-indigo-600 tracking-widest italic" id="va-{{ $pesanan->idpesanan }}">{{ $vaNumber ?? 'N/A' }}</span>
                                            <button onclick="copyToClipboard('{{ $vaNumber }}')" class="w-10 h-10 bg-white rounded-xl flex items-center justify-center text-slate-400 hover:text-indigo-600 hover:shadow-lg transition-all active:scale-90 border border-slate-100">
                                                <i class="fas fa-copy"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                            @elseif($paymentType == 'cstore')
                                <div class="bg-white rounded-[2rem] p-8 border border-white shadow-inner flex flex-col md:flex-row items-center gap-10">
                                    <div class="text-center md:text-left">
                                        <p class="text-[10px] text-slate-400 font-black uppercase tracking-widest mb-1 italic">Retail Store</p>
                                        <h5 class="text-2xl font-black text-red-600 tracking-tighter italic">{{ strtoupper($raw['store'] ?? 'RETAIL') }}</h5>
                                    </div>
                                    <div class="flex-1 w-full relative">
                                        <p class="text-[10px] text-slate-400 font-black uppercase tracking-widest mb-1 italic text-center md:text-left">Payment Code</p>
                                        <div class="flex items-center justify-between bg-slate-50 p-4 rounded-2xl border border-slate-100">
                                            <span class="text-2xl font-black text-red-600 tracking-widest italic" id="code-{{ $pesanan->idpesanan }}">{{ $raw['payment_code'] ?? 'N/A' }}</span>
                                            <button onclick="copyToClipboard('{{ $raw['payment_code'] }}')" class="w-10 h-10 bg-white rounded-xl flex items-center justify-center text-slate-400 hover:text-red-600 hover:shadow-lg transition-all active:scale-90 border border-slate-100">
                                                <i class="fas fa-copy"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <div class="mt-10 pt-8 border-t border-slate-100 flex justify-end gap-4">
                                <button onclick="payNow('{{ $pesanan->idpesanan }}')" class="px-8 py-4 bg-indigo-600 text-white rounded-2xl text-xs font-black uppercase tracking-widest flex items-center gap-3 hover:bg-slate-900 transition-all duration-500 shadow-xl shadow-indigo-100 active:scale-95 italic">
                                    <i class="fas fa-exchange-alt text-[10px]"></i> Ganti Metode
                                </button>
                            </div>

                        @else
                            <div class="text-center py-10" data-aos="zoom-in">
                                <div class="w-20 h-20 bg-indigo-50 rounded-[2rem] flex items-center justify-center text-3xl text-indigo-300 mx-auto mb-6">
                                    <i class="fas fa-money-check-dollar"></i>
                                </div>
                                <h4 class="text-xl font-black text-slate-900 tracking-tighter leading-none italic mb-2">Metode Belum Dipilih</h4>
                                <p class="text-xs text-slate-400 font-bold uppercase tracking-widest italic mb-8">Pilih cara bayar untuk melanjutkan pesanan ini.</p>
                                
                                <button onclick="payNow('{{ $pesanan->idpesanan }}')" class="px-10 py-5 bg-gradient-to-br from-indigo-600 to-violet-600 text-white rounded-2xl text-xs font-black uppercase tracking-widest shadow-2xl shadow-indigo-200 active:scale-95 transition-all italic">
                                    Bayar Sekarang <i class="fas fa-arrow-right ml-3"></i>
                                </button>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full py-40 text-center" data-aos="zoom-in">
                <div class="inline-flex items-center justify-center w-32 h-32 bg-indigo-50 rounded-[2.5rem] mb-8 shadow-inner">
                        <i class="fas fa-check-double text-6xl text-indigo-200 animate-bounce"></i>
                </div>
                <h3 class="text-[2.5rem] font-black text-slate-900 mb-4 tracking-tighter leading-none italic">Semua Beres!</h3>
                <p class="text-slate-400 font-bold max-w-md mx-auto uppercase tracking-widest text-xs leading-loose">Tidak ada pesanan yang menunggu pembayaran. Silakan eksplorasi menu lezat kami.</p>
                
                <a href="{{ route('pos') }}" class="inline-flex mt-10 px-8 py-4 bg-slate-900 text-white rounded-2xl text-xs font-black uppercase tracking-widest items-center gap-3 hover:bg-indigo-600 transition-all duration-500 active:scale-95 italic shadow-2xl shadow-slate-200">
                    Ke Menu POS <i class="fas fa-utensils text-[10px]"></i>
                </a>
            </div>
        @endforelse
    </div>
</div>
@endsection

@push('js')
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>
<script>
    function copyToClipboard(text) {
        if (!text) return;
        navigator.clipboard.writeText(text).then(() => {
             Swal.fire({
                icon: 'success',
                title: 'Disalin!',
                text: 'Kode berhasil disalin ke clipboard.',
                timer: 1500,
                showConfirmButton: false,
                background: 'rgba(255, 255, 255, 0.9)',
                backdrop: `rgba(79, 70, 229, 0.05)`,
                customClass: {
                    popup: 'rounded-[2rem] border-none shadow-2xl font-sans'
                }
            });
        });
    }

    function payNow(id) {
        Swal.fire({
            title: 'Memproses...',
            text: 'Membuka gerbang pembayaran',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            },
            customClass: {
                popup: 'rounded-[2rem] border-none font-sans'
            }
        });

        fetch(`/snap-token/${id}`)
            .then(response => response.json())
            .then(data => {
                Swal.close();
                if (data.snap_token) {
                    window.snap.pay(data.snap_token, {
                        onSuccess: function(result) {
                            window.location.href = `/payment/success/${id}`;
                        },
                        onPending: function(result) {
                            location.reload();
                        },
                        onError: function(result) {
                             Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Pembayaran gagal diproses!',
                                customClass: { popup: 'rounded-[2rem]' }
                            });
                        },
                        onClose: function() {
                            location.reload();
                        }
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: data.message,
                        customClass: { popup: 'rounded-[2rem]' }
                    });
                }
            })
            .catch(error => {
                Swal.close();
                Swal.fire({
                    icon: 'error',
                    title: 'System Error',
                    text: 'Gagal menghubungi server.',
                    customClass: { popup: 'rounded-[2rem]' }
                });
            });
    }
</script>
@endpush
