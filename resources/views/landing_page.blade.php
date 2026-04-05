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
        <div class="max-w-7xl mx-auto px-6 h-24 flex items-center justify-between">
            <div class="flex items-center gap-3 group cursor-pointer transition-transform hover:scale-105">
                <div class="w-12 h-12 bg-gradient-to-br from-indigo-600 to-violet-600 rounded-2xl flex items-center justify-center text-white text-2xl shadow-xl shadow-indigo-200 group-hover:rotate-6 transition-all duration-500">
                    <i class="fas fa-cube"></i>
                </div>
                <span class="text-3xl font-black tracking-tighter text-slate-900 italic">Workshop<span class="text-indigo-600">Framework.</span></span>
            </div>

            <div class="flex items-center gap-6">
                @guest
                    <a href="{{ route('register') }}" class="hidden md:block text-slate-800 font-extrabold text-sm uppercase tracking-widest hover:text-indigo-600 transition-colors">Daftar</a>
                    <a href="{{ route('login') }}" class="hidden md:block text-slate-800 font-extrabold text-sm uppercase tracking-widest hover:text-indigo-600 transition-colors">Masuk</a>
                    <a href="{{ route('pos') }}" class="px-8 py-4 btn-premium text-white font-black text-xs uppercase tracking-[0.2em] rounded-2xl shadow-2xl active:scale-95 transition-all duration-300">
                        Pesan Sekarang <i class="fas fa-arrow-right ml-2 text-xs"></i>
                    </a>
                @else
                        <div class="hidden md:block text-right">
                            <span class="block text-[10px] font-black text-indigo-500 uppercase tracking-[0.2em] mb-0.5">SISTEM AKTIF</span>
                            <span class="block text-sm font-black text-slate-800 italic">Halo, {{ Auth::user()->name }}!</span>
                        </div>
                        <a href="{{ route('auth.google.switch') }}" class="px-4 py-2 border-2 border-indigo-100 rounded-xl text-xs font-black text-indigo-600 hover:bg-indigo-50 transition-all flex items-center gap-2" title="Ganti Akun Google">
                            <i class="fas fa-rotate"></i> Ganti Akun
                        </a>
                        <a href="{{ route('admin.dashboard') }}" class="w-12 h-12 bg-white border border-slate-100 rounded-2xl flex items-center justify-center text-indigo-600 shadow-sm hover:bg-indigo-600 hover:text-white transition-all duration-500">
                             <i class="fas fa-th-large text-xl"></i>
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
                
                <h1 class="text-6xl sm:text-8xl font-black text-slate-900 leading-[0.9] tracking-tighter mb-10">
                    Platform Kantin <br> 
                    <span class="text-gradient" id="typed-headline"></span>
                </h1>
                
                <p class="text-xl text-slate-500 font-medium max-w-xl leading-relaxed mb-12">
                    Rasakan kemudahan memesan makanan dari berbagai vendor kantin lewat satu platform terintegrasi dengan Payment Gateway Midtrans.
                </p>

                <div class="flex flex-col sm:flex-row gap-5">
                    <a href="{{ route('pos') }}" class="group px-10 py-5 bg-gradient-to-r from-indigo-600 to-violet-600 text-white font-black text-lg rounded-[2rem] shadow-[0_20px_50px_rgba(79,70,229,0.3)] hover:shadow-indigo-400/40 hover:-translate-y-2 active:scale-95 transition-all duration-500 flex items-center justify-center gap-3">
                        Pesan Sekarang <i class="fas fa-arrow-right transform transition-transform group-hover:translate-x-2"></i>
                    </a>
                    <div class="flex flex-col gap-2">
                        <a href="{{ route('auth.google', ['action' => 'register']) }}" class="px-10 py-5 bg-white text-slate-900 font-black text-lg rounded-[2rem] border-2 border-slate-100 hover:border-indigo-600 hover:text-indigo-600 transition-all duration-500 flex items-center justify-center">
                            Daftar Member
                        </a>
                        <p class="text-[10px] text-center font-bold text-slate-400">Tersedia Login Google <i class="fab fa-google"></i></p>
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

            <div class="relative group" data-aos="zoom-in" data-aos-duration="1500" data-aos-delay="200">
                <!-- Large Decorative Image -->
                <div class="relative z-10 animate-float">
                   <div class="relative w-full aspect-[4/5] bg-slate-200 rounded-[4rem] overflow-hidden shadow-[0_50px_100px_-20px_rgba(31,38,135,0.2)] border-[12px] border-white group-hover:scale-[1.02] transition-transform duration-700">
                       <img src="https://images.unsplash.com/photo-1543353071-873f17a7a088?auto=format&fit=crop&q=80&w=1200" class="w-full h-full object-cover grayscale-[0.2] group-hover:grayscale-0 transition-all duration-700" alt="Food App">
                       <div class="absolute inset-0 bg-gradient-to-t from-black/40 via-transparent to-transparent"></div>
                   </div>
                   
                   <!-- Floating UI Elements -->
                   <div class="absolute -left-12 top-1/4 glass-card p-6 rounded-[2.5rem] flex items-center gap-5 translate-x-4 group-hover:translate-x-0 transition-transform duration-1000">
                       <div class="w-16 h-16 bg-white rounded-3xl shadow-lg flex items-center justify-center text-3xl">🥦</div>
                       <div>
                           <p class="text-lg font-black text-slate-900 tracking-tight leading-none">Menu Sehat</p>
                           <p class="text-sm text-indigo-600 font-bold mt-1 tracking-wider uppercase opacity-80">Vendor Terpercaya</p>
                       </div>
                   </div>
                   
                   <div class="absolute -right-12 bottom-1/4 glass-card p-8 rounded-[3rem] animate-pulse transition-all duration-1000">
                       <div class="flex items-center gap-4 mb-4">
                           <div class="w-4 h-4 bg-green-500 rounded-full"></div>
                           <p class="text-sm font-black text-slate-500 uppercase tracking-widest">TRANSAKSI BARU</p>
                       </div>
                       <p class="text-2xl font-black text-slate-900 tracking-tighter">Rp 25.000</p>
                       <p class="text-xs text-slate-400 font-bold mt-1">Status: Success</p>
                   </div>
                </div>
                
                <!-- Background Decoration -->
                <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[120%] h-[120%] bg-indigo-200/30 rounded-full blur-[120px] -z-10 animate-pulse"></div>
            </div>
        </div>
    </section>

    <!-- How it Works -->
    <section class="py-32 px-6 bg-white overflow-hidden">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-24" data-aos="fade-up">
                <h2 class="text-sm font-black text-indigo-600 uppercase tracking-[0.3em] mb-4">ALUR KERJA</h2>
                <h3 class="text-5xl sm:text-6xl font-black text-slate-900 tracking-tighter">Jadikan Makan Siang Lebih Cepat</h3>
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
    <section id="features" class="py-32 px-6 bg-slate-50 relative overflow-hidden">
        <div class="max-w-7xl mx-auto relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-24 items-center mb-40">
                <div data-aos="fade-right">
                    <h2 class="text-sm font-black text-indigo-600 uppercase tracking-[0.3em] mb-6">INTEGRASI MIDTRANS</h2>
                    <h3 class="text-4xl sm:text-6xl font-black text-slate-900 tracking-tighter leading-tight mb-8">
                        Keamanan Pembayaran <br> <span class="text-indigo-600 italic">Level Perbankan</span>
                    </h3>
                    <p class="text-xl text-slate-500 font-medium mb-10 leading-relaxed">
                        Nikmati kebebasan membayar menggunakan berbagai metode modern mulai dari E-Wallet hingga Virtual Account yang terkonfirmasi secara real-time.
                    </p>
                    <ul class="space-y-6">
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
    <section class="py-24 px-6 relative">
        <div class="max-w-7xl mx-auto glass-card rounded-[4rem] p-16 sm:p-24 overflow-hidden relative" data-aos="zoom-in" data-aos-duration="1000">
            <!-- Pattern -->
            <div class="absolute inset-0 opacity-[0.05] pointer-events-none" style="background-image: url('https://www.transparenttextures.com/patterns/p6.png');"></div>
            
            <div class="relative z-10 text-center max-w-3xl mx-auto">
                <h2 class="text-5xl sm:text-7xl font-black text-slate-900 tracking-tighter mb-10 leading-none italic">
                    Siap Makan Sesuai <br> <span class="text-indigo-600">Jadwalmu?</span>
                </h2>
                <p class="text-xl text-slate-500 font-medium mb-12">
                    Gak perlu lagi lari-larian ke kantin cuma buat antri. Masuk ke sistem POS kami sekarang dan nikmati hidup yang lebih praktis.
                </p>
                <div class="flex flex-col sm:flex-row justify-center gap-6">
                    <a href="{{ route('pos') }}" class="px-14 py-6 bg-slate-900 text-white font-black text-xl rounded-[2.5rem] shadow-[0_25px_60px_-10px_rgba(0,0,0,0.3)] hover:-translate-y-2 hover:bg-black transition-all duration-500">
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
    <footer class="bg-white border-t border-slate-100 pt-20 pb-10 px-6">
        <div class="max-w-7xl mx-auto">
            <div class="flex flex-col lg:flex-row justify-between mb-20 gap-20">
                <div class="max-w-md">
                    <div class="flex items-center gap-3 mb-8">
                        <div class="w-10 h-10 bg-indigo-600 rounded-xl flex items-center justify-center text-white">
                            <i class="fas fa-utensils"></i>
                        </div>
                        <span class="text-2xl font-black tracking-tighter italic">KantinPintar.</span>
                    </div>
                    <p class="text-slate-400 font-bold leading-relaxed mb-10">
                        Digitalisasi ekosistem kantin kampus untuk efisiensi waktu, keamanan transaksi, dan kenyamanan seluruh civitas akademika.
                    </p>
                    <div class="flex gap-4">
                        <a href="#" class="w-12 h-12 rounded-2xl bg-slate-50 text-slate-400 flex items-center justify-center hover:bg-slate-900 hover:text-white transition-all"><i class="fab fa-instagram text-xl"></i></a>
                        <a href="#" class="w-12 h-12 rounded-2xl bg-slate-50 text-slate-400 flex items-center justify-center hover:bg-slate-900 hover:text-white transition-all"><i class="fab fa-twitter text-xl"></i></a>
                        <a href="#" class="w-12 h-12 rounded-2xl bg-slate-50 text-slate-400 flex items-center justify-center hover:bg-slate-900 hover:text-white transition-all"><i class="fab fa-youtube text-xl"></i></a>
                    </div>
                </div>
                
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-10 lg:gap-20">
                    <div>
                        <h5 class="text-xs font-black text-slate-900 uppercase tracking-widest mb-8">FITUR</h5>
                        <ul class="space-y-4">
                            <li><a href="#" class="text-sm font-bold text-slate-400 hover:text-indigo-600 italic">Point of Sale</a></li>
                            <li><a href="#" class="text-sm font-bold text-slate-400 hover:text-indigo-600 italic">E-Payment</a></li>
                            <li><a href="#" class="text-sm font-bold text-slate-400 hover:text-indigo-600 italic">Manajemen Stok</a></li>
                        </ul>
                    </div>
                    <div>
                        <h5 class="text-xs font-black text-slate-900 uppercase tracking-widest mb-8">TEKNOLOGI</h5>
                        <ul class="space-y-4">
                            <li><a href="#" class="text-sm font-bold text-slate-400 hover:text-indigo-600 italic">Laravel 11</a></li>
                            <li><a href="#" class="text-sm font-bold text-slate-400 hover:text-indigo-600 italic">Tailwind CSS</a></li>
                            <li><a href="#" class="text-sm font-bold text-slate-400 hover:text-indigo-600 italic">Midtrans API</a></li>
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
                nav.classList.add('py-4', 'shadow-xl');
                nav.classList.remove('py-0');
            } else {
                nav.classList.remove('py-4', 'shadow-xl');
            }
        });
    </script>
</body>
</html>
