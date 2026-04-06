<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Kantin Pintar Premium</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    
    <!-- AOS -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    
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
    
    <style>
        :root {
            --primary-indigo: #4f46e5;
            --primary-violet: #7c3aed;
        }

        body {
            font-family: 'Outfit', 'sans-serif';
            background-color: #f8fafc;
            overflow-x: hidden;
        }

        .mesh-gradient {
            background-color: #f8fafc;
            background-image: 
                radial-gradient(at 0% 0%, rgba(79, 70, 229, 0.08) 0px, transparent 50%),
                radial-gradient(at 100% 0%, rgba(124, 58, 237, 0.1) 0px, transparent 50%),
                radial-gradient(at 100% 100%, rgba(255, 204, 112, 0.05) 0px, transparent 50%);
            background-attachment: fixed;
        }
        
        .glass-nav {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(25px);
            -webkit-backdrop-filter: blur(25px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.4);
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.5);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.05);
        }

        .custom-scrollbar::-webkit-scrollbar { width: 6px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { 
            background: #cbd5e1; 
            border-radius: 10px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #94a3b8; }

        .btn-premium {
            background: linear-gradient(135deg, #4f46e5, #7c3aed);
            box-shadow: 0 10px 30px -10px rgba(79, 70, 229, 0.4);
        }

        .text-gradient {
            background: linear-gradient(135deg, #4f46e5, #7c3aed);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
    </style>
    @stack('css')
</head>
<body class="antialiased mesh-gradient text-slate-800">
    <div class="min-h-screen flex flex-col">
        <!-- Minimal Header for POS -->
        <header class="glass-nav sticky top-0 z-50 transition-all duration-500">
            <div class="max-w-[1500px] mx-auto px-6 h-24 flex items-center justify-between">
                <div class="flex items-center gap-4 group cursor-pointer transition-transform hover:scale-105">
                    <div class="w-12 h-12 bg-gradient-to-br from-indigo-600 to-violet-600 rounded-2xl flex items-center justify-center text-white text-2xl shadow-xl shadow-indigo-200 group-hover:rotate-6 transition-all duration-500">
                        <i class="fas fa-utensils"></i>
                    </div>
                    <div>
                        <h1 class="text-2xl font-black italic tracking-tighter text-slate-900 leading-none">Workshop<span class="text-indigo-600">POS.</span></h1>
                        <p class="text-[10px] text-slate-400 font-black uppercase tracking-[0.3em] mt-1 italic">Premium Experience</p>
                    </div>
                </div>

                <div class="flex items-center gap-8">
                    @if(Auth::check())
                        <div class="hidden md:flex flex-col text-right">
                             <p class="text-xs font-black text-indigo-500 uppercase tracking-widest mb-1 italic">Selamat Datang,</p>
                            <p class="text-sm font-black text-slate-800 tracking-tight">{{ Auth::user()->name }}</p>
                        </div>
                        <div class="w-12 h-12 rounded-2xl bg-white border-2 border-indigo-50 flex items-center justify-center text-indigo-600 font-black text-lg shadow-sm">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>
                    @else
                        <div class="hidden md:flex flex-col text-right">
                             <p class="text-xs font-black text-slate-400 uppercase tracking-widest mb-1 italic">Selamat Datang,</p>
                            <p class="text-sm font-black text-slate-600 tracking-tight">{{ session('username') ?? 'Tamu' }}</p>
                        </div>
                        <div class="w-12 h-12 rounded-2xl bg-white border-2 border-slate-100 flex items-center justify-center text-slate-400 font-black text-lg shadow-sm">
                            {{ strtoupper(substr(session('username') ?? 'T', 0, 1)) }}
                        </div>
                    @endif
                    
                    <a href="{{ url('/') }}" class="px-6 py-3 bg-white border border-slate-100 rounded-2xl text-xs font-black text-slate-400 uppercase tracking-widest hover:bg-slate-900 hover:text-white transition-all duration-500 flex items-center gap-3 active:scale-95">
                        <i class="fas fa-arrow-left text-[10px]"></i> Keluar
                    </a>
                </div>
            </div>
        </header>

        <!-- Main Content (POS) -->
        <main class="flex-1 max-w-[1500px] mx-auto w-full p-8 md:p-12 mb-20">
            @yield('content')
        </main>
    </div>

    <script>
        AOS.init({
            once: true,
            mirror: false
        });
    </script>
    @stack('js')
</body>
</html>
