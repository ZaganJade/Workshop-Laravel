<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ __('Register') }} | KantinPintar Premium</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Styles & Libraries -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
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
                    },
                    borderRadius: {
                        '4xl': '2rem',
                        '5xl': '2.5rem',
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
            font-family: 'Outfit', sans-serif;
            overflow-x: hidden;
        }

        .mesh-gradient {
            background-color: #f8fafc;
            background-image: 
                radial-gradient(at 0% 0%, rgba(79, 70, 229, 0.15) 0px, transparent 50%),
                radial-gradient(at 100% 0%, rgba(124, 58, 237, 0.15) 0px, transparent 50%),
                radial-gradient(at 50% 50%, rgba(255, 204, 112, 0.05) 0px, transparent 50%),
                radial-gradient(at 100% 100%, rgba(79, 70, 229, 0.1) 0px, transparent 50%),
                radial-gradient(at 0% 100%, rgba(124, 58, 237, 0.1) 0px, transparent 50%);
            background-attachment: fixed;
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(25px);
            -webkit-backdrop-filter: blur(25px);
            border: 1px solid rgba(255, 255, 255, 0.5);
            box-shadow: 0 25px 50px -12px rgba(31, 38, 135, 0.15);
        }

        .text-gradient {
            background: linear-gradient(135deg, #4f46e5, #7c3aed);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .btn-premium {
            background: linear-gradient(135deg, #4f46e5, #7c3aed);
            box-shadow: 0 10px 30px -10px rgba(79, 70, 229, 0.4);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .btn-premium:hover {
            box-shadow: 0 15px 40px -10px rgba(79, 70, 229, 0.6);
            transform: translateY(-3px);
        }

        .input-group:focus-within .input-icon {
            color: var(--primary-indigo);
            transform: scale(1.1);
        }

        /* Floating Animation */
        .animate-float {
            animation: float 6s ease-in-out infinite;
        }
        @keyframes float {
            0% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(2deg); }
            100% { transform: translateY(0px) rotate(0deg); }
        }

        /* Responsive Layout Utilities */
        @media (min-width: 1024px) {
            .auth-container {
                min-height: 100vh;
                display: flex;
            }
            .auth-hero {
                flex: 1;
                display: flex;
            }
            .auth-form-section {
                flex: 1.2;
                display: flex;
            }
        }
    </style>
</head>
<body class="mesh-gradient min-h-screen antialiased selection:bg-indigo-100 selection:text-indigo-900">
    
    <div class="auth-container">
        <!-- Left Side: Hero (Hidden on Mobile) -->
        <div class="auth-hero hidden lg:flex relative overflow-hidden flex-col justify-center px-16 xl:px-24">
            <!-- Background Shapes -->
            <div class="absolute top-[-10%] left-[-10%] w-96 h-96 bg-indigo-200/30 rounded-full blur-[100px] animate-pulse"></div>
            <div class="absolute bottom-[-10%] right-[-10%] w-96 h-96 bg-violet-200/30 rounded-full blur-[100px] animate-pulse" style="animation-delay: 2s"></div>
            
            <div class="relative z-10" data-aos="fade-right" data-aos-duration="1200">
                <a href="{{ url('/') }}" class="inline-flex items-center gap-4 mb-12 group transition-transform hover:scale-105">
                    <div class="w-14 h-14 bg-gradient-to-br from-indigo-600 to-violet-600 rounded-2xl flex items-center justify-center text-white text-3xl shadow-xl shadow-indigo-200 group-hover:rotate-6 transition-all duration-500">
                        <i class="fas fa-cube"></i>
                    </div>
                    <span class="text-4xl font-black tracking-tighter text-slate-900 italic">Workshop<span class="text-indigo-600">Framework.</span></span>
                </a>
                
                <h1 class="text-6xl xl:text-7xl font-black text-slate-900 leading-[0.95] tracking-tighter mb-8">
                    Mulai Perjalanan <br> 
                    <span class="text-gradient">Digitalisasimu <br> Sekarang.</span>
                </h1>
                
                <p class="text-xl text-slate-500 font-medium max-w-lg leading-relaxed mb-12 opacity-80">
                    Bergabunglah dengan ribuan mahasiswa lainnya dalam ekosistem kantin terpintar dan ternyaman.
                </p>

                <!-- Floating Badge -->
                <div class="flex items-center gap-6 animate-float">
                    <div class="glass-card p-6 rounded-3xl flex items-center gap-5 border-indigo-100/50">
                        <div class="w-12 h-12 bg-indigo-100 text-indigo-600 rounded-2xl flex items-center justify-center text-2xl">
                            <i class="fas fa-user-check"></i>
                        </div>
                        <div>
                            <p class="text-sm font-black text-slate-900 uppercase tracking-widest leading-none">Registrasi Cepat</p>
                            <p class="text-[11px] text-indigo-600 font-bold mt-1 tracking-wider italic">Kurang dari 1 Menit</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Absolute Decoration -->
            <div class="absolute -right-20 bottom-[10%] w-2/3 max-w-[500px] opacity-10 pointer-events-none grayscale blur-sm">
                <i class="fas fa-user-plus text-[30rem] text-indigo-900"></i>
            </div>
        </div>

        <!-- Right Side: Form -->
        <div class="auth-form-section flex items-center justify-center p-6 lg:bg-white/30 lg:backdrop-blur-xl border-l border-white/50">
            <div class="w-full max-w-[640px]" data-aos="zoom-in" data-aos-duration="1000">
                <!-- Mobile Logo -->
                <div class="lg:hidden text-center mb-10">
                    <a href="{{ url('/') }}" class="inline-flex items-center gap-3 mb-6">
                        <div class="w-12 h-12 bg-gradient-to-br from-indigo-600 to-violet-600 rounded-2xl flex items-center justify-center text-white text-2xl shadow-xl">
                            <i class="fas fa-cube"></i>
                        </div>
                        <span class="text-3xl font-black text-slate-900 tracking-tighter italic">Workshop<span class="text-indigo-600">Framework.</span></span>
                    </a>
                </div>

                <div class="glass-card rounded-[2.5rem] p-8 sm:p-12 relative overflow-hidden">
                    <div class="relative z-10">
                        <div class="mb-10 text-center lg:text-left">
                            <h2 class="text-4xl font-black text-slate-900 leading-tight mb-2 tracking-tighter">Daftar Akun Baru</h2>
                            <p class="text-slate-400 font-bold text-sm">Ayo buat akun untuk memulai pengalaman barumu.</p>
                        </div>

                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-6">
                                <!-- Username Field -->
                                <div class="input-group">
                                    <label for="username" class="block text-[11px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2.5 ml-1">Username</label>
                                    <div class="relative group">
                                        <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none text-slate-300 input-icon transition-all duration-300">
                                            <i class="fas fa-user-tag"></i>
                                        </div>
                                        <input id="username" type="text" name="username" value="{{ old('username') }}" required autocomplete="username" autofocus 
                                            class="w-full pl-14 pr-6 py-4 bg-slate-50/50 border border-slate-100 rounded-2xl text-slate-700 font-semibold focus:outline-none focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 focus:bg-white transition-all placeholder:text-slate-300"
                                            placeholder="johndoe">
                                    </div>
                                    @error('username')
                                        <p class="mt-2 text-xs font-bold text-rose-500 flex items-center gap-1.5 ml-1">
                                            <i class="fas fa-circle-exclamation"></i> {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <!-- Email Field -->
                                <div class="input-group">
                                    <label for="email" class="block text-[11px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2.5 ml-1">Alamat Email</label>
                                    <div class="relative group">
                                        <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none text-slate-300 input-icon transition-all duration-300">
                                            <i class="fas fa-envelope"></i>
                                        </div>
                                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email" 
                                            class="w-full pl-14 pr-6 py-4 bg-slate-50/50 border border-slate-100 rounded-2xl text-slate-700 font-semibold focus:outline-none focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 focus:bg-white transition-all placeholder:text-slate-300"
                                            placeholder="nama@email.com">
                                    </div>
                                    @error('email')
                                        <p class="mt-2 text-xs font-bold text-rose-500 flex items-center gap-1.5 ml-1">
                                            <i class="fas fa-circle-exclamation"></i> {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <!-- Password Field -->
                                <div class="input-group">
                                    <label for="password" class="block text-[11px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2.5 ml-1">Password</label>
                                    <div class="relative group">
                                        <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none text-slate-300 input-icon transition-all duration-300">
                                            <i class="fas fa-lock"></i>
                                        </div>
                                        <input id="password" type="password" name="password" required autocomplete="new-password"
                                            class="w-full pl-14 pr-6 py-4 bg-slate-50/50 border border-slate-100 rounded-2xl text-slate-700 font-semibold focus:outline-none focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 focus:bg-white transition-all placeholder:text-slate-300"
                                            placeholder="••••••••">
                                    </div>
                                </div>

                                <!-- Confirm Password -->
                                <div class="input-group">
                                    <label for="password-confirm" class="block text-[11px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2.5 ml-1">Konfirmasi Password</label>
                                    <div class="relative group">
                                        <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none text-slate-300 input-icon transition-all duration-300">
                                            <i class="fas fa-shield-check"></i>
                                        </div>
                                        <input id="password-confirm" type="password" name="password_confirmation" required autocomplete="new-password"
                                            class="w-full pl-14 pr-6 py-4 bg-slate-50/50 border border-slate-100 rounded-2xl text-slate-700 font-semibold focus:outline-none focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 focus:bg-white transition-all placeholder:text-slate-300"
                                            placeholder="••••••••">
                                    </div>
                                </div>
                            </div>
                            
                            @error('password')
                                <p class="mt-4 text-xs font-bold text-rose-500 flex items-center gap-1.5 ml-1">
                                    <i class="fas fa-circle-exclamation"></i> {{ $message }}
                                </p>
                            @enderror

                            <!-- Submit Button -->
                            <button type="submit" class="w-full mt-10 py-5 btn-premium text-white font-black text-xs uppercase tracking-[0.25em] rounded-2xl mb-8 flex items-center justify-center gap-3">
                                Daftar Member Sekarang <i class="fas fa-user-plus text-lg"></i>
                            </button>

                            <!-- Social Divider -->
                            <div class="relative mb-8">
                                <div class="absolute inset-0 flex items-center"><div class="w-full border-t border-slate-100"></div></div>
                                <div class="relative flex justify-center text-[10px] uppercase"><span class="bg-white/80 backdrop-blur px-5 text-slate-400 font-bold tracking-[0.3em]">Atau Daftar Dengan</span></div>
                            </div>

                            <!-- Google Register -->
                            <a href="{{ route('auth.google', ['action' => 'register']) }}" class="group w-full py-5 bg-white border-2 border-slate-100 rounded-2xl flex items-center justify-center gap-4 hover:border-indigo-600 hover:text-indigo-600 hover:shadow-xl hover:shadow-indigo-50 transition-all duration-500">
                                <img src="https://www.gstatic.com/firebasejs/ui/2.0.0/images/auth/google.svg" class="w-5 h-5 group-hover:scale-110 transition-transform duration-500" alt="Google">
                                <span class="text-xs font-black text-slate-600 uppercase tracking-widest group-hover:text-indigo-600 transition-colors">Daftar melalui Google</span>
                            </a>
                        </form>
                    </div>
                </div>

                <!-- Footer actions -->
                <div class="text-center mt-10" data-aos="fade-up" data-aos-delay="200">
                    <p class="text-slate-400 text-sm font-bold">
                        Sudah punya akun? 
                        <a href="{{ route('login') }}" class="text-indigo-600 hover:text-violet-600 font-black transition-all underline underline-offset-4 decoration-2 decoration-indigo-200">Masuk Sekarang</a>
                    </p>
                    <a href="{{ url('/') }}" class="inline-flex items-center gap-2 mt-8 text-slate-400 hover:text-slate-600 text-[10px] font-black uppercase tracking-[0.2em] transition-all">
                        <i class="fas fa-chevron-left text-[8px]"></i> Kembali ke Home
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        AOS.init({
            once: true,
            mirror: false
        });
    </script>
    
    @if(session('google_error'))
    <script>
        Swal.fire({
            icon: 'error',
            title: '<span class="text-2xl font-black text-slate-800 tracking-tight">Terjadi Kesalahan</span>',
            html: '<p class="text-slate-600 font-medium">{{ session('google_error') }}</p>',
            confirmButtonColor: '#4f46e5',
            confirmButtonText: 'SAYA MENGERTI',
            customClass: {
                popup: 'rounded-3xl border-none shadow-2xl',
                confirmButton: 'rounded-xl px-8 py-3 font-black text-xs tracking-widest'
            },
            showClass: { popup: 'animate__animated animate__shakeX' }
        });
    </script>
    @endif
</body>
</html>
