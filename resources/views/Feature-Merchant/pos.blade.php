@extends('layouts.pos_layout')

@section('title', 'Point of Sale')

@section('content')
<div class="h-full flex flex-col lg:flex-row gap-12" id="pos-app">
    <!-- Kolom Kiri: Menu -->
    <div class="w-full lg:w-[65%] flex flex-col" data-aos="fade-right">
        <div class="glass-card rounded-[3rem] p-10 mb-8 flex-1 relative overflow-hidden group">
            <!-- Decorative Accent -->
            <div class="absolute -top-10 -right-10 w-40 h-40 bg-indigo-600/5 rounded-full blur-3xl group-hover:bg-indigo-600/10 transition-all duration-700"></div>
            
            <div class="flex flex-col md:flex-row items-start md:items-center justify-between mb-12 gap-8 sticky top-0 bg-white/20 backdrop-blur-md z-10 py-4 -mx-4 px-4 rounded-2xl">
                <div>
                    <h2 class="text-4xl font-black text-slate-900 tracking-tighter leading-none mb-3 italic">Daftar <span class="text-indigo-600">Menu.</span></h2>
                    <p class="text-sm text-slate-400 font-bold uppercase tracking-widest">Pilih vendor favoritmu untuk mengeksplorasi hidangan.</p>
                </div>
                <div class="relative w-full md:w-80 group">
                    <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none text-indigo-400 group-hover:scale-110 transition-transform">
                        <i class="fas fa-store-alt text-lg"></i>
                    </div>
                    <select id="vendor-select" class="appearance-none w-full bg-white border-2 border-indigo-50 text-slate-900 text-sm font-black rounded-2xl focus:ring-4 focus:ring-indigo-100 focus:border-indigo-500 block p-5 pl-14 transition-all duration-500 shadow-sm cursor-pointer italic hover:border-indigo-200">
                        <option value="" selected disabled>Pilih Vendor Kantin</option>
                        @foreach($vendors as $vendor)
                            <option value="{{ $vendor->idvendor }}">{{ $vendor->nama_vendor }}</option>
                        @endforeach
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center px-5 pointer-events-none text-slate-300">
                        <i class="fas fa-chevron-down text-xs"></i>
                    </div>
                </div>
            </div>

            <div id="menu-container" class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-8">
                <!-- Menus will be loaded here via AJAX -->
                <div class="col-span-full py-40 text-center" data-aos="zoom-in">
                    <div class="inline-flex items-center justify-center w-32 h-32 bg-indigo-50 rounded-[2.5rem] mb-8 shadow-inner">
                         <i class="fas fa-bowl-food text-6xl text-indigo-200 animate-pulse"></i>
                    </div>
                    <h3 class="text-[2.5rem] font-black text-slate-900 mb-4 tracking-tighter leading-none italic">Menunggu Pesananmu!</h3>
                    <p class="text-slate-400 font-bold max-w-md mx-auto uppercase tracking-widest text-xs leading-loose">Silakan pilih vendor di sebelah kanan atas untuk melihat menu yang lezat dan bergizi.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Kolom Kanan: Keranjang -->
    <div class="w-full lg:w-[35%]" data-aos="fade-left">
        <div class="glass-card rounded-[3rem] shadow-2xl border-indigo-50/50 flex flex-col sticky top-32 overflow-hidden">
            <!-- Header Keranjang -->
            <div class="p-10 bg-gradient-to-r from-slate-900 to-indigo-950 items-center justify-between flex relative overflow-hidden">
                <div class="relative z-10">
                    <h2 class="text-2xl font-black text-white italic tracking-tighter">Keranjang <span class="text-indigo-400">Saya.</span></h2>
                    <p class="text-[10px] text-indigo-300/60 font-black uppercase tracking-[0.3em] mt-2 italic">ID: ORD-{{ date('His') }}</p>
                </div>
                <div class="w-14 h-14 bg-white/10 backdrop-blur-xl rounded-2xl flex items-center justify-center text-3xl text-white shadow-2xl border border-white/10 relative z-10 transition-transform active:scale-95 cursor-pointer">
                    <i class="fas fa-shopping-basket"></i>
                </div>
                <!-- Decoration -->
                <div class="absolute -right-5 -top-5 w-32 h-32 bg-indigo-500/20 rounded-full blur-2xl"></div>
            </div>

            <!-- Items -->
            <div id="cart-items" class="p-10 space-y-8 max-h-[500px] overflow-y-auto mb-2 custom-scrollbar bg-white/40">
                <!-- Empty Cart State -->
                <div id="empty-cart" class="text-center py-24 group">
                    <div class="w-24 h-24 bg-slate-50 rounded-[2rem] flex items-center justify-center mx-auto mb-8 shadow-inner group-hover:scale-110 transition-transform duration-500">
                        <i class="fas fa-cart-arrow-down text-4xl text-slate-200"></i>
                    </div>
                    <p class="text-slate-400 font-black uppercase tracking-[0.2em] text-[10px] italic">Oops! Keranjang masih kosong.</p>
                </div>
            </div>

            <!-- Total -->
            <div class="p-10 bg-slate-50/50 border-t border-slate-100 backdrop-blur-md">
                <div class="space-y-6 mb-10">
                    <div class="flex justify-between text-slate-400 font-black uppercase tracking-[0.2em] text-[10px] italic">
                        <span>Biaya Terhitung</span>
                        <span id="cart-subtotal" class="text-slate-900">Rp 0</span>
                    </div>
                    <div class="flex justify-between items-center pt-6 border-t border-slate-200">
                        <div>
                            <span class="text-[10px] font-black text-indigo-500 uppercase tracking-[0.3em] italic block mb-1">Total Bayar</span>
                            <span id="cart-total" class="text-4xl font-black text-slate-900 tracking-tighter italic">Rp 0</span>
                        </div>
                        <div class="w-12 h-12 bg-green-100 rounded-2xl flex items-center justify-center text-green-600 text-xl animate-pulse">
                            <i class="fas fa-check-double"></i>
                        </div>
                    </div>
                </div>

                <button id="btn-pay" disabled class="group w-full bg-slate-900 text-white font-black py-6 rounded-[2rem] shadow-2xl hover:bg-black disabled:bg-slate-200 disabled:cursor-not-allowed transition-all duration-500 transform active:scale-95 flex items-center justify-center gap-4 text-xs uppercase tracking-[0.3em] italic">
                    <i class="fas fa-credit-card text-indigo-400 group-hover:rotate-12 transition-transform"></i>
                    Bayar Sekarang
                </button>
                
                <p class="mt-8 text-center text-[10px] font-black text-slate-300 uppercase tracking-widest italic flex items-center justify-center gap-2">
                    <i class="fas fa-lock"></i> Secured by Midtrans Gateway
                </p>
            </div>
        </div>
    </div>
</div>

@push('js')
<script src="{{ env('MIDTRANS_SNAP_URL') }}" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>
<script>
    $(document).ready(function() {
        let cart = [];

        // 🔹 1. Dropdown Vendor
        $('#vendor-select').on('change', function() {
            const vendorId = $(this).val();
            $('#menu-container').html('<div class="col-span-full py-40 text-center"><div class="inline-block animate-spin border-4 border-indigo-100 border-t-indigo-600 w-16 h-16 rounded-full mb-6"></div><p class="text-xs font-black text-slate-400 uppercase tracking-[0.3em] italic">Menyiapkan menu terlezat...</p></div>');
            
            $.get(`/menus/${vendorId}`, function(menus) {
                renderMenus(menus);
            });
        });

        function renderMenus(menus) {
            let html = '';
            if (menus.length === 0) {
                html = '<div class="col-span-full py-40 text-center"><i class="fas fa-box-open text-6xl text-slate-100 mb-6"></i><p class="text-xs font-black text-slate-400 uppercase tracking-[0.2em] italic">Maaf, menu belum tersedia untuk vendor ini.</p></div>';
            } else {
                menus.forEach((menu, index) => {
                    const delay = (index % 6) * 100;
                    html += `
                        <div class="bg-white/60 backdrop-blur-sm rounded-[2.5rem] p-6 border-2 border-transparent hover:border-indigo-600/20 hover:bg-white shadow-sm hover:shadow-[0_25px_60px_-15px_rgba(79,70,229,0.15)] transition-all duration-700 group relative overflow-hidden" 
                             data-aos="zoom-in" data-aos-delay="${delay}">
                            <div class="absolute top-4 right-4 w-10 h-10 bg-indigo-50 rounded-xl flex items-center justify-center text-indigo-400 opacity-0 group-hover:opacity-100 transition-all duration-500 scale-50 group-hover:scale-100">
                                <i class="fas fa-leaf text-xs"></i>
                            </div>
                            <div class="w-full aspect-square mb-6 bg-slate-50 rounded-[1.8rem] flex items-center justify-center text-6xl group-hover:scale-105 transition-transform duration-700 group-hover:rotate-2 shadow-inner border border-slate-100/50">
                                <i class="fas fa-bowl-food text-slate-200"></i>
                            </div>
                            <h3 class="font-black text-slate-900 text-xl mb-1 italic tracking-tight">${menu.nama_menu}</h3>
                            <p class="text-[10px] text-slate-400 font-black uppercase tracking-widest mb-6 italic">Vendor Terpercaya</p>
                            
                            <div class="flex items-center justify-between pt-4 border-t border-slate-50">
                                <p class="text-indigo-600 font-black text-2xl tracking-tighter italic">Rp ${menu.harga.toLocaleString('id-ID')}</p>
                                <button class="add-to-cart w-14 h-14 bg-slate-900 text-white rounded-2xl flex items-center justify-center hover:bg-indigo-600 hover:shadow-xl hover:shadow-indigo-200 transition-all duration-500 active:scale-90 shadow-lg group-hover:rotate-6" 
                                    data-id="${menu.idmenu}" data-nama="${menu.nama_menu}" data-harga="${menu.harga}">
                                    <i class="fas fa-plus text-lg"></i>
                                </button>
                            </div>
                        </div>
                    `;
                });
            }
            $('#menu-container').html(html);
        }

        // 🔹 3. Keranjang (Cart)
        $(document).on('click', '.add-to-cart', function() {
            const id = $(this).data('id');
            const nama = $(this).data('nama');
            const harga = $(this).data('harga');

            const existing = cart.find(item => item.id === id);
            if (existing) {
                existing.qty++;
            } else {
                cart.push({ id, nama, harga, qty: 1 });
            }
            renderCart();
        });

        $(document).on('click', '.qty-plus', function() {
            const id = $(this).data('id');
            const item = cart.find(item => item.id === id);
            if (item) item.qty++;
            renderCart();
        });

        $(document).on('click', '.qty-minus', function() {
            const id = $(this).data('id');
            const index = cart.findIndex(item => item.id === id);
            if (index !== -1) {
                if (cart[index].qty > 1) {
                    cart[index].qty--;
                } else {
                    cart.splice(index, 1);
                }
            }
            renderCart();
        });

        function renderCart() {
            if (cart.length === 0) {
                $('#empty-cart').removeClass('hidden').addClass('animate-in fade-in zoom-in duration-500');
                $('#cart-items').html($('#empty-cart')[0].outerHTML);
                $('#btn-pay').prop('disabled', true);
                $('#cart-subtotal').text(`Rp 0`);
                $('#cart-total').text(`Rp 0`);
            } else {
                $('#empty-cart').addClass('hidden');
                let html = '';
                let total = 0;
                cart.forEach((item, index) => {
                    const subtotal = item.qty * item.harga;
                    total += subtotal;
                    html += `
                        <div class="flex items-center justify-between p-6 bg-white/70 backdrop-blur rounded-3xl border border-white shadow-sm transition-all hover:shadow-md animate-in slide-in-from-right duration-500" style="animation-delay: ${index * 50}ms">
                            <div class="flex-1">
                                <h4 class="font-black text-slate-800 tracking-tight italic leading-tight">${item.nama}</h4>
                                <p class="text-[10px] text-indigo-500 font-black uppercase tracking-widest mt-1">Rp ${item.harga.toLocaleString('id-ID')}</p>
                            </div>
                            <div class="flex items-center gap-4 ml-4 bg-slate-100/50 p-1.5 rounded-2xl border border-slate-200/50">
                                <button class="w-10 h-10 rounded-xl flex items-center justify-center bg-white border border-slate-100 text-slate-400 hover:text-rose-500 hover:border-rose-100 transition-all active:scale-90 qty-minus" data-id="${item.id}">
                                    <i class="fas fa-minus text-xs"></i>
                                </button>
                                <span class="font-black text-lg w-6 text-center text-slate-900 italic">${item.qty}</span>
                                <button class="w-10 h-10 rounded-xl flex items-center justify-center bg-white border border-slate-100 text-slate-400 hover:text-indigo-600 hover:border-indigo-100 transition-all active:scale-90 qty-plus" data-id="${item.id}">
                                    <i class="fas fa-plus text-xs"></i>
                                </button>
                            </div>
                        </div>
                    `;
                });
                $('#cart-items').html(html);
                $('#cart-subtotal').text(`Rp ${total.toLocaleString('id-ID')}`);
                $('#cart-total').text(`Rp ${total.toLocaleString('id-ID')}`);
                $('#btn-pay').prop('disabled', false);
            }
        }

        // 🔹 5. Tombol "Bayar"
        $('#btn-pay').on('click', function() {
            const btn = $(this);
            btn.prop('disabled', true).html('<div class="inline-block animate-spin border-2 border-indigo-400 border-t-white w-4 h-4 rounded-full mr-3"></div> MEMPROSES TRANSAKSI...');

            $.ajax({
                url: '/order',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    items: cart
                },
                success: function(response) {
                    const idpesanan = response.idpesanan;
                    
                    $.get(`/snap-token/${idpesanan}`)
                    .done(function(res) {
                        snap.pay(res.snap_token, {
                            onSuccess: function(result) {
                                Swal.fire({
                                    icon: 'success',
                                    title: '<span class="text-2xl font-black text-slate-800 tracking-tight">Pembayaran Berhasil!</span>',
                                    html: '<p class="text-slate-600 font-medium">Terima kasih pesanan Anda sedang disiapkan. Silakan ambil pesanan Anda di vendor terkait.</p>',
                                    confirmButtonColor: '#4f46e5',
                                    confirmButtonText: 'SAYA MENGERTI',
                                    customClass: { popup: 'rounded-[2.5rem]', confirmButton: 'rounded-xl px-10 py-4 font-black text-xs tracking-widest' }
                                }).then(() => { window.location.href = '/payment/success/' + idpesanan; });
                            },
                            onPending: function(result) {
                                Swal.fire({
                                    icon: 'warning',
                                    title: '<span class="text-2xl font-black text-slate-800 tracking-tight">Pembayaran Pending</span>',
                                    html: '<p class="text-slate-600 font-medium">Silakan selesaikan pembayaran Anda melalui channel yang tersedia.</p>',
                                    confirmButtonColor: '#4f46e5',
                                    confirmButtonText: 'OKE',
                                    customClass: { popup: 'rounded-[2.5rem]', confirmButton: 'rounded-xl px-10 py-4 font-black text-xs tracking-widest' }
                                }).then(() => { window.location.href = '/payment/success/' + idpesanan; });
                            },
                            onError: function(result) {
                                console.error('Midtrans Snap Error:', result);
                                Swal.fire({
                                    icon: 'error',
                                    title: '<span class="text-2xl font-black text-slate-800 tracking-tight">Pembayaran Gagal</span>',
                                    html: `<p class="text-slate-600 font-medium">Maaf, terjadi kesalahan saat memproses pembayaran Anda. <br><small class="text-slate-400">Status: ${result.status_message}</small></p>`,
                                    confirmButtonColor: '#4f46e5',
                                    confirmButtonText: 'SAYA MENGERTI',
                                    customClass: { popup: 'rounded-[2.5rem]', confirmButton: 'rounded-xl px-10 py-4 font-black text-xs tracking-widest' }
                                });
                                btn.prop('disabled', false).html('<i class="fas fa-credit-card text-indigo-400 mr-3"></i> Bayar Sekarang');
                            },
                            onClose: function() {
                                console.log('Midtrans Snap window closed');
                                btn.prop('disabled', false).html('<i class="fas fa-credit-card text-indigo-400 mr-3"></i> Bayar Sekarang');
                            }
                        });
                    })
                    .fail(function(xhr) {
                        const message = xhr.responseJSON ? xhr.responseJSON.message : 'Gagal mengambil token pembayaran.';
                        Swal.fire({ icon: 'error', title: 'Oops...', text: message });
                        btn.prop('disabled', false).html('<i class="fas fa-credit-card text-indigo-400 mr-3"></i> Bayar Sekarang');
                    });
                },
                error: function(xhr) {
                    Swal.fire({ icon: 'error', title: 'Error', text: 'Terjadi kesalahan saat membuat pesanan.' });
                    btn.prop('disabled', false).html('<i class="fas fa-credit-card text-indigo-400 mr-3"></i> Bayar Sekarang');
                }
            });
        });
    });
</script>
@endpush
@endsection
