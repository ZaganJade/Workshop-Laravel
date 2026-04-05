@extends('layouts.pos_layout')

@section('title', 'Pembayaran Berhasil')

@section('content')
<div class="max-w-4xl mx-auto py-12" data-aos="zoom-in">
    <div class="glass-card rounded-[3rem] overflow-hidden shadow-2xl border-white/40">
        <!-- Success Header -->
        <div class="bg-gradient-to-br from-indigo-600 via-violet-600 to-indigo-800 p-12 text-white text-center relative overflow-hidden">
            <div class="relative z-10">
                <div class="w-24 h-24 bg-white/20 backdrop-blur-xl rounded-full flex items-center justify-center mx-auto mb-8 shadow-2xl border border-white/20 animate-bounce">
                    <i class="fas fa-check text-4xl"></i>
                </div>
                <h1 class="text-5xl font-black italic tracking-tighter mb-4">Pembayaran <span class="text-indigo-200">Berhasil!</span></h1>
                <p class="text-indigo-100 font-bold uppercase tracking-[0.3em] text-xs italic opacity-80">Pesanan Anda sedang dalam proses penyiapan.</p>
            </div>
            
            <!-- Abstract Decorations -->
            <div class="absolute -top-10 -left-10 w-40 h-40 bg-white/10 rounded-full blur-3xl"></div>
            <div class="absolute -bottom-10 -right-10 w-60 h-60 bg-indigo-400/20 rounded-full blur-3xl"></div>
        </div>

        <div class="p-12 md:p-16 bg-white/40 backdrop-blur-md">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-16">
                <!-- Order Summary -->
                <div data-aos="fade-right" data-aos-delay="200">
                    <h2 class="text-xl font-black text-slate-900 italic tracking-tighter mb-8 border-b-2 border-indigo-50 pb-4">Ringkasan <span class="text-indigo-600">Pesanan.</span></h2>
                    
                    <div class="space-y-6">
                        @foreach($pesanan->details as $detail)
                        <div class="flex items-center justify-between group">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 bg-indigo-50 rounded-xl flex items-center justify-center text-indigo-600 group-hover:scale-110 group-hover:rotate-6 transition-all duration-500 shadow-sm border border-indigo-100/50">
                                    <i class="fas fa-utensils text-sm"></i>
                                </div>
                                <div>
                                    <h4 class="font-black text-slate-800 tracking-tight italic">{{ $detail->menu->nama_menu }}</h4>
                                    <p class="text-[10px] text-slate-400 font-black uppercase tracking-widest">{{ $detail->jumlah }}x Porsi</p>
                                </div>
                            </div>
                            <p class="text-sm font-black text-slate-900 italic tracking-tighter">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</p>
                        </div>
                        @endforeach
                    </div>

                    <div class="mt-10 pt-8 border-t-2 border-indigo-50">
                        <div class="flex justify-between items-center">
                            <span class="text-xs font-black text-slate-400 uppercase tracking-widest italic">Total Pembayaran</span>
                            <span class="text-3xl font-black text-indigo-600 tracking-tighter italic">Rp {{ number_format($pesanan->total, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>

                <!-- Transaction Details -->
                <div data-aos="fade-left" data-aos-delay="400">
                    <h2 class="text-xl font-black text-slate-900 italic tracking-tighter mb-8 border-b-2 border-indigo-50 pb-4">Detail <span class="text-indigo-600">Transaksi.</span></h2>
                    
                    <div class="bg-indigo-50/50 rounded-3xl p-8 space-y-6 border border-indigo-100/50">
                        <div>
                            <p class="text-[10px] text-slate-400 font-black uppercase tracking-widest mb-1 italic">Order ID</p>
                            <p class="text-sm font-black text-slate-900">#ORD-{{ str_pad($pesanan->idpesanan, 6, '0', STR_PAD_LEFT) }}</p>
                        </div>
                        <div>
                            <p class="text-[10px] text-slate-400 font-black uppercase tracking-widest mb-1 italic">Metode Pembayaran</p>
                            <p class="text-sm font-black text-slate-900 uppercase">
                                {{ $pesanan->payment ? str_replace('_', ' ', $pesanan->payment->payment_type) : 'Midtrans Snap' }}
                            </p>
                        </div>
                        <div>
                            <p class="text-[10px] text-slate-400 font-black uppercase tracking-widest mb-1 italic">Waktu Transaksi</p>
                            <p class="text-sm font-black text-slate-900">{{ $pesanan->paid_at ?? $pesanan->created_at }}</p>
                        </div>
                        <div>
                            <p class="text-[10px] text-slate-400 font-black uppercase tracking-widest mb-1 italic">Status</p>
                            <span class="px-4 py-1.5 bg-green-100 text-green-600 rounded-full text-[10px] font-black uppercase tracking-widest italic flex items-center gap-2 w-fit">
                                <i class="fas fa-check-circle animate-pulse"></i> Pembayaran Lunas
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer Action -->
            <div class="mt-16 text-center" data-aos="fade-up" data-aos-delay="600">
                <a href="{{ route('pos') }}" class="group inline-flex items-center gap-4 bg-slate-900 text-white font-black px-10 py-5 rounded-[2rem] shadow-2xl hover:bg-black hover:scale-105 transition-all duration-500 active:scale-95 text-xs uppercase tracking-[0.3em] italic">
                    <i class="fas fa-arrow-left text-indigo-400 group-hover:-translate-x-2 transition-transform"></i>
                    Kembali ke Point of Sale
                </a>
                
                <p class="mt-8 text-[10px] font-black text-slate-300 uppercase tracking-widest italic flex items-center justify-center gap-3">
                    <i class="fas fa-shield-alt text-indigo-400"></i> Struk virtual aman tersimpan di sistem kami.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
