<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KantinPintar - Revolusi Sistem Pemesanan Kantin</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Outfit', 'sans-serif'],
                    },
                    colors: {
                        primary: {
                            indigo: '#4f46e5',
                            violet: '#7c3aed',
                        }
                    }
                }
            }
        }
    </script>
    
    <!-- Icons & Animations Libraries -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/typed.js@2.1.0/dist/typed.umd.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

    <style>
        :root {
            --primary-indigo: #4f46e5;
            --primary-violet: #7c3aed;
        }

        body {
            font-family: 'Outfit', sans-serif;
            scroll-behavior: smooth;
        }
        
        .glass-nav {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(25px);
            -webkit-backdrop-filter: blur(25px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.4);
        }

        .mesh-gradient {
            background-color: #f8fafc;
            background-image: 
                radial-gradient(at 0% 0%, rgba(79, 70, 229, 0.08) 0px, transparent 50%),
                radial-gradient(at 100% 0%, rgba(124, 58, 237, 0.1) 0px, transparent 50%),
                radial-gradient(at 100% 100%, rgba(255, 204, 112, 0.05) 0px, transparent 50%);
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.5);
            box-shadow: 0 15px 45px -10px rgba(31, 38, 135, 0.1);
        }

        .text-gradient {
            background: linear-gradient(135deg, #4f46e5, #7c3aed);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        /* Float Animation */
        .animate-float {
            animation: float 6s ease-in-out infinite;
        }
        @keyframes float {
            0% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(2deg); }
            100% { transform: translateY(0px) rotate(0deg); }
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar { width: 10px; }
        ::-webkit-scrollbar-track { background: #f8fafc; }
        ::-webkit-scrollbar-thumb { 
            background: #cbd5e1; 
            border-radius: 10px;
            border: 3px solid #f8fafc;
        }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }

        .btn-premium {
            background: linear-gradient(135deg, #4f46e5, #7c3aed);
            box-shadow: 0 10px 30px -10px rgba(79, 70, 229, 0.4);
        }
        .btn-premium:hover {
            box-shadow: 0 15px 40px -10px rgba(79, 70, 229, 0.6);
            transform: translateY(-2px);
        }
    </style>
</head>
<body class="mesh-gradient bg-slate-50 text-slate-900 antialiased selection:bg-indigo-100 selection:text-indigo-900">

    <!-- Header / Navbar -->
    <nav class="glass-nav fixed top-0 w-full z-[100] transition-all duration-500">
        <div class="max-w-7xl mx-auto px-3 sm:px-4 md:px-6 h-16 sm:h-20 md:h-24 flex items-center justify-between">
            <div class="flex items-center gap-1.5 sm:gap-2 md:gap-3 group cursor-pointer transition-transform hover:scale-105 shrink-0">
                <div class="w-8 h-8 sm:w-10 sm:h-10 md:w-12 md:h-12 bg-gradient-to-br from-indigo-600 to-violet-600 rounded-lg sm:rounded-xl md:rounded-2xl flex items-center justify-center text-white text-base sm:text-xl md:text-2xl shadow-xl shadow-indigo-200 group-hover:rotate-6 transition-all duration-500">
                    <i class="fas fa-cube"></i>
                </div>
                <span class="text-base sm:text-xl md:text-3xl font-black tracking-tighter text-slate-900 italic truncate">Workshop<span class="text-indigo-600 hidden sm:inline">Framework</span><span class="text-indigo-600">.</span></span>
            </div>

            <div class="flex items-center gap-2 sm:gap-3 md:gap-6 shrink-0">
                <!-- Hamburger Button (Mobile) -->
                <button id="mobile-menu-btn" class="md:hidden flex items-center justify-center w-10 h-10 sm:w-11 sm:h-11 rounded-lg bg-slate-100 text-slate-600 hover:bg-slate-200 hover:text-indigo-600 transition-colors focus:outline-none shrink-0">
                    <i class="fas fa-bars text-base sm:text-lg"></i>
                </button>

                <!-- Desktop Links Default -->
                @guest
                    <a href="{{ route('register') }}" class="hidden md:flex min-h-[44px] items-center text-slate-800 font-extrabold text-sm uppercase tracking-widest hover:text-indigo-600 transition-colors">Daftar</a>
                    <a href="{{ route('login') }}" class="hidden md:flex min-h-[44px] items-center text-slate-800 font-extrabold text-sm uppercase tracking-widest hover:text-indigo-600 transition-colors">Masuk</a>
                    <a href="{{ route('pos') }}" class="px-3 py-2 sm:px-5 sm:py-3 md:px-8 md:py-4 min-h-[40px] sm:min-h-[44px] flex items-center justify-center btn-premium text-white font-black text-[9px] sm:text-[10px] md:text-xs uppercase tracking-[0.2em] rounded-lg sm:rounded-xl md:rounded-2xl shadow-2xl active:scale-95 transition-all duration-300 whitespace-nowrap">
                        Pesan <span class="hidden sm:inline">&nbsp;Sekarang</span> <i class="fas fa-arrow-right ml-1 md:ml-2 text-[10px]"></i>
                    </a>
                @else
                    <div class="hidden sm:block text-right">
                        <span class="block text-[8px] md:text-[10px] font-black text-indigo-500 uppercase tracking-[0.2em] mb-0.5">SISTEM AKTIF</span>
                        <span class="block text-xs md:text-sm font-black text-slate-800 italic">Halo, {{ explode(' ', Auth::user()->name)[0] }}!</span>
                    </div>
                    <a href="{{ route('auth.google.switch') }}" class="px-3 py-2 md:px-4 md:py-2 min-h-[44px] border-2 border-indigo-100 rounded-lg md:rounded-xl text-[10px] md:text-xs font-black text-indigo-600 hover:bg-indigo-50 transition-all hidden md:flex items-center gap-2" title="Ganti Akun Google">
                        <i class="fas fa-rotate"></i> <span>Ganti Akun</span>
                    </a>
                    <a href="{{ route('admin.dashboard') }}" class="w-10 h-10 md:w-12 md:h-12 bg-white border border-slate-100 rounded-xl md:rounded-2xl hidden md:flex items-center justify-center text-indigo-600 shadow-sm hover:bg-indigo-600 hover:text-white transition-all duration-500">
                         <i class="fas fa-th-large text-lg md:text-xl"></i>
                    </a>
                    
                    <!-- Mobile Fallback for authenticated POS / Actions -->
                    <a href="{{ route('pos') }}" class="md:hidden px-3 py-2 sm:px-5 sm:py-3 min-h-[40px] flex items-center justify-center btn-premium text-white font-black text-[9px] sm:text-[10px] uppercase tracking-[0.2em] rounded-lg sm:rounded-xl shadow-2xl active:scale-95 transition-all duration-300">
                        Masuk POS
                    </a>
                @endguest
            </div>
        </div>

        <!-- Mobile Menu Drawer -->
        <div id="mobile-menu" class="absolute top-full left-0 w-full bg-white/95 backdrop-blur-xl border-b border-slate-100 shadow-2xl transform origin-top scale-y-0 opacity-0 transition-all duration-300 ease-in-out md:hidden flex flex-col z-40">
            <div class="px-6 py-6 flex flex-col gap-4">
                @guest
                    <a href="{{ route('register') }}" class="w-full flex items-center justify-center min-h-[44px] bg-slate-50 text-slate-800 font-extrabold text-sm uppercase tracking-widest rounded-xl hover:text-indigo-600 transition-colors">Daftar Member</a>
                    <a href="{{ route('login') }}" class="w-full flex items-center justify-center min-h-[44px] bg-slate-50 text-slate-800 font-extrabold text-sm uppercase tracking-widest rounded-xl hover:text-indigo-600 transition-colors">Masuk Akun</a>
                @else
                    <div class="p-4 bg-slate-50 rounded-xl flex items-center gap-4 mb-2">
                         <div class="w-10 h-10 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center font-bold text-lg">
                             {{ substr(Auth::user()->name, 0, 1) }}
                         </div>
                         <div>
                             <p class="text-xs font-black text-indigo-500 uppercase tracking-widest mb-0.5">Online</p>
                             <p class="text-sm font-bold text-slate-800">{{ Auth::user()->name }}</p>
                         </div>
                    </div>
                    <a href="{{ route('admin.dashboard') }}" class="w-full flex items-center justify-center gap-2 min-h-[44px] bg-indigo-50 text-indigo-700 font-extrabold text-sm uppercase rounded-xl hover:bg-indigo-100 transition-colors">
                        <i class="fas fa-th-large"></i> Dashboard Admin
                    </a>
                    <a href="{{ route('auth.google.switch') }}" class="w-full flex items-center justify-center gap-2 min-h-[44px] bg-slate-50 text-slate-700 font-extrabold text-sm uppercase rounded-xl hover:bg-slate-100 transition-colors">
                        <i class="fas fa-rotate"></i> Ganti Akun Google
                    </a>
                @endguest
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-mesh pt-44 pb-32 px-6 overflow-hidden min-h-screen flex items-center">
        <div class="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
            <div class="relative z-10" data-aos="fade-right" data-aos-duration="1200">
                <div class="inline-flex items-center gap-2 px-5 py-2.5 bg-white rounded-full shadow-lg shadow-indigo-100 border border-indigo-50 mb-10 transition-transform hover:scale-105">
                    <span class="flex h-3 w-3 rounded-full bg-indigo-500 animate-ping"></span>
                    <span class="text-[11px] font-black text-indigo-900 uppercase tracking-[0.15em]">Smart Campus Experience</span>
                </div>
                
                <h1 class="text-[2.75rem] leading-[1.1] sm:text-6xl md:text-7xl lg:text-8xl font-black text-slate-900 md:leading-[0.9] tracking-tighter mb-8 md:mb-10">
                    Platform Kantin <br> 
                    <span class="text-gradient" id="typed-headline"></span>
                </h1>
                
                <p class="text-xl text-slate-500 font-medium max-w-xl leading-relaxed mb-12">
                    Rasakan kemudahan memesan makanan dari berbagai vendor kantin lewat satu platform terintegrasi dengan Payment Gateway Midtrans.
                </p>

                <div class="flex flex-col sm:flex-row gap-4 sm:gap-5">
                    <a href="{{ route('pos') }}" class="group px-8 py-4 sm:px-10 sm:py-5 min-h-[44px] bg-gradient-to-r from-indigo-600 to-violet-600 text-white font-black text-base sm:text-lg rounded-full shadow-[0_20px_50px_rgba(79,70,229,0.3)] hover:shadow-indigo-400/40 hover:-translate-y-2 active:scale-95 transition-all duration-500 flex items-center justify-center gap-3">
                        Pesan Sekarang <i class="fas fa-arrow-right transform transition-transform group-hover:translate-x-2"></i>
                    </a>
                    <div class="flex flex-col gap-2">
                        <a href="{{ route('auth.google', ['action' => 'register']) }}" class="px-8 py-4 sm:px-10 sm:py-5 min-h-[44px] bg-white text-slate-900 font-black text-base sm:text-lg rounded-full border-2 border-slate-100 hover:border-indigo-600 hover:text-indigo-600 transition-all duration-500 flex items-center justify-center">
                            Daftar Member
                        </a>
                        <p class="text-[10px] sm:text-xs text-center font-bold text-slate-400">Tersedia Login Google <i class="fab fa-google"></i></p>
                    </div>
                </div>

                <div class="mt-20 flex items-center gap-10">
                    <div class="flex -space-x-3">
                        <div class="w-12 h-12 rounded-full border-4 border-white bg-slate-200 overflow-hidden"><img src="https://i.pravatar.cc/150?u=1" alt=""></div>
                        <div class="w-12 h-12 rounded-full border-4 border-white bg-indigo-100 text-indigo-400 flex items-center justify-center text-xs font-bold font-serif">A</div>
                        <div class="w-12 h-12 rounded-full border-4 border-white bg-slate-200 overflow-hidden"><img src="https://i.pravatar.cc/150?u=3" alt=""></div>
                        <div class="w-12 h-12 rounded-full border-4 border-white bg-indigo-600 text-white flex items-center justify-center text-xs font-bold">+50</div>
                    </div>
                    <div>
                        <p class="text-sm font-black text-slate-900 leading-none">Mahasiswa Aktif</p>
                        <p class="text-xs text-slate-400 font-bold mt-1 uppercase tracking-widest">Telah Bergabung</p>
                    </div>
                </div>
            </div>

            <div class="relative group mt-10 lg:mt-0" data-aos="zoom-in" data-aos-duration="1500" data-aos-delay="200">
                <!-- Large Decorative Image -->
                <div class="relative z-10 animate-float">
                   <div class="relative w-full aspect-square md:aspect-[4/5] bg-slate-200 rounded-[2.5rem] md:rounded-[4rem] overflow-hidden shadow-[0_50px_100px_-20px_rgba(31,38,135,0.2)] border-8 md:border-[12px] border-white group-hover:scale-[1.02] transition-transform duration-700">
                       <img src="https://images.unsplash.com/photo-1543353071-873f17a7a088?auto=format&fit=crop&q=80&w=1200" class="w-full h-full object-cover grayscale-[0.2] group-hover:grayscale-0 transition-all duration-700" alt="Food App">
                       <div class="absolute inset-0 bg-gradient-to-t from-black/40 via-transparent to-transparent"></div>
                   </div>
                   
                   <!-- Floating UI Elements -->
                   <div class="hidden sm:flex absolute -left-6 md:-left-12 top-1/4 glass-card p-4 md:p-6 rounded-[2rem] md:rounded-[2.5rem] items-center gap-3 md:gap-5 translate-x-4 group-hover:translate-x-0 transition-transform duration-1000">
                       <div class="w-12 h-12 md:w-16 md:h-16 bg-white rounded-2xl md:rounded-3xl shadow-lg flex items-center justify-center text-2xl md:text-3xl">🥦</div>
                       <div>
                           <p class="text-base md:text-lg font-black text-slate-900 tracking-tight leading-none">Menu Sehat</p>
                           <p class="text-[10px] md:text-sm text-indigo-600 font-bold mt-1 tracking-wider uppercase opacity-80">Vendor Terpercaya</p>
                       </div>
                   </div>
                   
                   <div class="hidden sm:block absolute -right-6 md:-right-12 bottom-1/4 glass-card p-6 md:p-8 rounded-[2rem] md:rounded-[3rem] animate-pulse transition-all duration-1000">
                       <div class="flex items-center gap-2 md:gap-4 mb-3 md:mb-4">
                           <div class="w-3 h-3 md:w-4 md:h-4 bg-green-500 rounded-full"></div>
                           <p class="text-[10px] md:text-sm font-black text-slate-500 uppercase tracking-widest">TRANSAKSI BARU</p>
                       </div>
                       <p class="text-xl md:text-2xl font-black text-slate-900 tracking-tighter">Rp 25.000</p>
                       <p class="text-[10px] md:text-xs text-slate-400 font-bold mt-1">Status: Success</p>
                   </div>
                </div>
                
                <!-- Background Decoration -->
                <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[120%] h-[120%] bg-indigo-200/30 rounded-full blur-[120px] -z-10 animate-pulse"></div>
            </div>
        </div>
    </section>

    <!-- How it Works -->
    <section class="py-16 md:py-32 px-4 md:px-6 bg-white overflow-hidden">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-16 md:mb-24" data-aos="fade-up">
                <h2 class="text-[10px] md:text-sm font-black text-indigo-600 uppercase tracking-[0.3em] mb-3 md:mb-4">ALUR KERJA</h2>
                <h3 class="text-4xl sm:text-5xl md:text-6xl font-black text-slate-900 tracking-tighter">Jadikan Makan Siang Lebih Cepat</h3>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-12 relative">
                <!-- Connect Line -->
                <div class="hidden md:block absolute top-1/2 left-0 w-full h-[2px] bg-slate-100 -z-10"></div>

                <div class="text-center" data-aos="fade-up" data-aos-delay="100">
                    <div class="w-20 h-20 bg-slate-900 text-white rounded-3xl mx-auto flex items-center justify-center text-3xl mb-8 shadow-xl transition-all hover:scale-110 hover:-rotate-6">
                        <i class="fas fa-search"></i>
                    </div>
                    <h4 class="text-xl font-bold mb-3">1. Pilih Menu</h4>
                    <p class="text-slate-500 text-sm font-medium">Buka menu dari berbagai vendor melalui gadget Anda.</p>
                </div>
                
                <div class="text-center" data-aos="fade-up" data-aos-delay="200">
                    <div class="w-20 h-20 bg-indigo-600 text-white rounded-3xl mx-auto flex items-center justify-center text-3xl mb-8 shadow-xl transition-all hover:scale-110 hover:rotate-6">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                    <h4 class="text-xl font-bold mb-3">2. Masuk Keranjang</h4>
                    <p class="text-slate-500 text-sm font-medium">Atur jumlah pesanan dengan antarmuka yang modern.</p>
                </div>
                
                <div class="text-center" data-aos="fade-up" data-aos-delay="300">
                    <div class="w-20 h-20 bg-violet-600 text-white rounded-3xl mx-auto flex items-center justify-center text-3xl mb-8 shadow-xl transition-all hover:scale-110 hover:-rotate-6">
                        <i class="fas fa-credit-card"></i>
                    </div>
                    <h4 class="text-xl font-bold mb-3">3. Bayar Instan</h4>
                    <p class="text-slate-500 text-sm font-medium">Selesaikan pembayaran via Midtrans secara aman.</p>
                </div>
                
                <div class="text-center" data-aos="fade-up" data-aos-delay="400">
                    <div class="w-20 h-20 bg-green-600 text-white rounded-3xl mx-auto flex items-center justify-center text-3xl mb-8 shadow-xl transition-all hover:scale-110 hover:rotate-6">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <h4 class="text-xl font-bold mb-3">4. Ambil Pesanan</h4>
                    <p class="text-slate-500 text-sm font-medium">Tunjukan bukti bayar dan ambil makanan yang siap.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Grid -->
    <section id="features" class="py-16 md:py-32 px-4 md:px-6 bg-slate-50 relative overflow-hidden">
        <div class="max-w-7xl mx-auto relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 md:gap-24 items-center mb-24 md:mb-40">
                <div data-aos="fade-right">
                    <h2 class="text-[10px] md:text-sm font-black text-indigo-600 uppercase tracking-[0.3em] mb-4 md:mb-6">INTEGRASI MIDTRANS</h2>
                    <h3 class="text-3xl sm:text-5xl md:text-6xl font-black text-slate-900 tracking-tighter leading-tight mb-6 md:mb-8">
                        Keamanan Pembayaran <br> <span class="text-indigo-600 italic">Level Perbankan</span>
                    </h3>
                    <p class="text-base md:text-xl text-slate-500 font-medium mb-8 md:mb-10 leading-relaxed">
                        Nikmati kebebasan membayar menggunakan berbagai metode modern mulai dari E-Wallet hingga Virtual Account yang terkonfirmasi secara real-time.
                    </p>
                    <ul class="space-y-4 md:space-y-6">
                        <li class="flex items-center gap-4 group">
                            <div class="w-8 h-8 rounded-lg bg-green-100 text-green-600 flex items-center justify-center group-hover:bg-green-600 group-hover:text-white transition-all"><i class="fas fa-check"></i></div>
                            <span class="text-lg font-bold text-slate-700 italic">QRIS & GoPay Support</span>
                        </li>
                        <li class="flex items-center gap-4 group">
                            <div class="w-8 h-8 rounded-lg bg-green-100 text-green-600 flex items-center justify-center group-hover:bg-green-600 group-hover:text-white transition-all"><i class="fas fa-check"></i></div>
                            <span class="text-lg font-bold text-slate-700 italic">Bank Virtual Account</span>
                        </li>
                        <li class="flex items-center gap-4 group">
                            <div class="w-8 h-8 rounded-lg bg-green-100 text-green-600 flex items-center justify-center group-hover:bg-green-600 group-hover:text-white transition-all"><i class="fas fa-check"></i></div>
                            <span class="text-lg font-bold text-slate-700 italic">Keamanan Enkripsi SHA512</span>
                        </li>
                    </ul>
                </div>
                <div class="relative" data-aos="fade-left">
                    <div class="bg-slate-900 p-12 rounded-[5rem] shadow-2xl relative z-10">
                        <div class="flex items-center justify-between mb-12">
                            <div class="flex gap-2">
                                <div class="w-3 h-3 rounded-full bg-red-400"></div>
                                <div class="w-3 h-3 rounded-full bg-orange-400"></div>
                                <div class="w-3 h-3 rounded-full bg-green-400"></div>
                            </div>
                            <span class="text-[10px] font-black text-slate-500 uppercase tracking-widest italic">Terminal Payment</span>
                        </div>
                        <div class="space-y-8">
                            <div class="bg-white/5 p-6 rounded-3xl border border-white/10 flex items-center justify-between">
                                <div class="flex items-center gap-5">
                                    <div class="w-12 h-12 bg-white/10 rounded-2xl flex items-center justify-center text-white"><i class="fas fa-wallet text-xl"></i></div>
                                    <div>
                                        <p class="text-white font-bold opacity-80">ShopeePay</p>
                                        <p class="text-[10px] text-indigo-400 font-black">E-WALLET</p>
                                    </div>
                                </div>
                                <div class="w-4 h-4 rounded-full border-2 border-indigo-500"></div>
                            </div>
                            <div class="bg-indigo-600 p-6 rounded-3xl border border-indigo-400 shadow-[0_15px_40px_rgba(79,70,229,0.4)] flex items-center justify-between">
                                <div class="flex items-center gap-5">
                                    <div class="w-12 h-12 bg-white rounded-2xl flex items-center justify-center text-indigo-600"><i class="fas fa-university text-xl"></i></div>
                                    <div>
                                        <p class="text-white font-bold">Virtual Account</p>
                                        <p class="text-[10px] text-white/50 font-black">BANK TRANSFER</p>
                                    </div>
                                </div>
                                <div class="w-6 h-6 bg-white rounded-full flex items-center justify-center shadow-lg transform scale-110">
                                     <i class="fas fa-check text-[10px] text-indigo-600"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Glow -->
                    <div class="absolute inset-0 bg-indigo-500/20 blur-[100px] -z-10 translate-x-10 translate-y-10"></div>
                </div>
            </div>
        </div>
    </section>

    <!-- Final Call to Action -->
    <section class="py-12 md:py-24 px-4 md:px-6 relative">
        <div class="max-w-7xl mx-auto glass-card rounded-[2.5rem] md:rounded-[4rem] p-8 sm:p-24 overflow-hidden relative" data-aos="zoom-in" data-aos-duration="1000">
            <!-- Pattern -->
            <div class="absolute inset-0 opacity-[0.05] pointer-events-none" style="background-image: url('https://www.transparenttextures.com/patterns/p6.png');"></div>
            
            <div class="relative z-10 text-center max-w-3xl mx-auto">
                <h2 class="text-3xl sm:text-7xl font-black text-slate-900 tracking-tighter mb-6 md:mb-10 leading-none italic">
                    Siap Makan Sesuai <br> <span class="text-indigo-600">Jadwalmu?</span>
                </h2>
                <p class="text-base md:text-xl text-slate-500 font-medium mb-8 md:mb-12">
                    Gak perlu lagi lari-larian ke kantin cuma buat antri. Masuk ke sistem POS kami sekarang dan nikmati hidup yang lebih praktis.
                </p>
                <div class="flex flex-col sm:flex-row justify-center gap-4 md:gap-6">
                    <a href="{{ route('pos') }}" class="px-8 py-5 md:px-14 md:py-6 bg-slate-900 text-white font-black text-lg md:text-xl rounded-[2rem] md:rounded-[2.5rem] shadow-[0_25px_60px_-10px_rgba(0,0,0,0.3)] hover:-translate-y-2 hover:bg-black transition-all duration-500">
                        Masuk POS Sekarang
                    </a>
                </div>
            </div>
            
            <!-- Accents -->
            <div class="absolute top-0 right-0 w-64 h-64 bg-indigo-600/5 blur-[80px] -z-10"></div>
            <div class="absolute bottom-0 left-0 w-64 h-64 bg-violet-600/5 blur-[80px] -z-10"></div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-white border-t border-slate-100 pt-16 md:pt-20 pb-8 md:pb-10 px-4 md:px-6">
        <div class="max-w-7xl mx-auto">
            <div class="flex flex-col lg:flex-row justify-between mb-16 md:mb-20 gap-12 md:gap-20">
                <div class="max-w-md">
                    <div class="flex items-center gap-3 mb-6 md:mb-8">
                        <div class="w-10 h-10 bg-indigo-600 rounded-xl flex items-center justify-center text-white">
                            <i class="fas fa-utensils"></i>
                        </div>
                        <span class="text-xl md:text-2xl font-black tracking-tighter italic">KantinPintar.</span>
                    </div>
                    <p class="text-sm md:text-base text-slate-400 font-bold leading-relaxed mb-8 md:mb-10">
                        Digitalisasi ekosistem kantin kampus untuk efisiensi waktu, keamanan transaksi, dan kenyamanan seluruh civitas akademika.
                    </p>
                    <div class="flex gap-4">
                        <a href="#" class="w-10 h-10 md:w-12 md:h-12 rounded-[0.85rem] md:rounded-2xl bg-slate-50 text-slate-400 flex items-center justify-center hover:bg-slate-900 hover:text-white transition-all"><i class="fab fa-instagram text-lg md:text-xl"></i></a>
                        <a href="#" class="w-10 h-10 md:w-12 md:h-12 rounded-[0.85rem] md:rounded-2xl bg-slate-50 text-slate-400 flex items-center justify-center hover:bg-slate-900 hover:text-white transition-all"><i class="fab fa-twitter text-lg md:text-xl"></i></a>
                        <a href="#" class="w-10 h-10 md:w-12 md:h-12 rounded-[0.85rem] md:rounded-2xl bg-slate-50 text-slate-400 flex items-center justify-center hover:bg-slate-900 hover:text-white transition-all"><i class="fab fa-youtube text-lg md:text-xl"></i></a>
                    </div>
                </div>
                
                <div class="grid grid-cols-2 md:grid-cols-3 gap-8 md:gap-10 lg:gap-20">
                    <div>
                        <h5 class="text-[10px] md:text-xs font-black text-slate-900 uppercase tracking-widest mb-6 md:mb-8">FITUR</h5>
                        <ul class="space-y-3 md:space-y-4">
                            <li><a href="#" class="p-1 -ml-1 inline-block min-h-[44px] text-xs md:text-sm font-bold text-slate-400 hover:text-indigo-600 italic">Point of Sale</a></li>
                            <li><a href="#" class="p-1 -ml-1 inline-block min-h-[44px] text-xs md:text-sm font-bold text-slate-400 hover:text-indigo-600 italic">E-Payment</a></li>
                            <li><a href="#" class="p-1 -ml-1 inline-block min-h-[44px] text-xs md:text-sm font-bold text-slate-400 hover:text-indigo-600 italic">Manajemen Stok</a></li>
                        </ul>
                    </div>
                    <div>
                        <h5 class="text-[10px] md:text-xs font-black text-slate-900 uppercase tracking-widest mb-6 md:mb-8">TEKNOLOGI</h5>
                        <ul class="space-y-3 md:space-y-4">
                            <li><a href="#" class="p-1 -ml-1 inline-block min-h-[44px] text-xs md:text-sm font-bold text-slate-400 hover:text-indigo-600 italic">Laravel 11</a></li>
                            <li><a href="#" class="p-1 -ml-1 inline-block min-h-[44px] text-xs md:text-sm font-bold text-slate-400 hover:text-indigo-600 italic">Tailwind CSS</a></li>
                            <li><a href="#" class="p-1 -ml-1 inline-block min-h-[44px] text-xs md:text-sm font-bold text-slate-400 hover:text-indigo-600 italic">Midtrans API</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            
            <div class="pt-10 border-t border-slate-50 text-center">
                <p class="text-xs font-black text-slate-300 uppercase tracking-[0.3em]">&copy; 2026 KANTINPINTAR ECOSYSTEM. ALL RIGHTS RESERVED.</p>
            </div>
        </div>
    </footer>

    <script>
        // Init AOS
        AOS.init({
            once: true,
            mirror: false
        });

        // Init Typed.js
        var typed = new Typed('#typed-headline', {
            strings: ['Tanpa Antri.', 'Lebih Cepat.', 'Masa Depan.', 'Modern.'],
            typeSpeed: 50,
            backSpeed: 30,
            backDelay: 2000,
            loop: true,
            showCursor: true,
            cursorChar: '|'
        });

        // Navbar Scroll Effect
        window.addEventListener('scroll', function() {
            const nav = document.querySelector('nav');
            if (window.scrollY > 50) {
                nav.classList.add('py-2', 'md:py-4', 'shadow-xl');
                nav.classList.remove('py-0');
            } else {
                nav.classList.remove('py-2', 'md:py-4', 'shadow-xl');
            }
        });

        // Mobile Menu Toggle
        const menuBtn = document.getElementById('mobile-menu-btn');
        const mobileMenu = document.getElementById('mobile-menu');
        
        if(menuBtn && mobileMenu) {
            menuBtn.addEventListener('click', () => {
                const isExpanded = mobileMenu.classList.contains('scale-y-100');
                if (isExpanded) {
                    // Close
                    mobileMenu.classList.remove('scale-y-100', 'opacity-100');
                    mobileMenu.classList.add('scale-y-0', 'opacity-0');
                    menuBtn.innerHTML = '<i class="fas fa-bars text-lg"></i>';
                } else {
                    // Open
                    mobileMenu.classList.remove('scale-y-0', 'opacity-0');
                    mobileMenu.classList.add('scale-y-100', 'opacity-100');
                    menuBtn.innerHTML = '<i class="fas fa-times text-lg"></i>';
                }
            });
        }
    </script>
</body>
</html>
