<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>OTP Verification - {{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Outfit', sans-serif;
            background-color: #f8f9fa;
        }
    </style>
</head>
<body>
    <div class="container-fluid min-vh-100 d-flex flex-column mb-0 pb-0">

        <!-- Header / Navbar Section -->
        <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm py-3 mb-5">
            <div class="container">
                <a class="navbar-brand fw-bold text-primary" href="#">Workshop Framework</a>
            </div>
        </nav>

        <!-- Main Content -->
        <div class="row flex-grow-1 justify-content-center align-items-center">
            <div class="col-md-7 col-lg-5">
                
                <div class="text-center mb-5">
                    <h1 class="display-5 fw-bold text-dark mb-3">Verifikasi Akun Anda</h1>
                    <p class="lead text-muted">Kami telah mengirimkan 6-digit kode OTP ke email terdaftar Anda. Masukkan kode tersebut untuk melanjutkan persetujuan akses dashboard.</p>
                </div>

                <div class="card shadow-lg border-0 rounded-4 overflow-hidden mb-5">
                    <div class="card-header bg-primary text-white text-center py-4">
                        <h4 class="mb-0 fw-light">Masukkan Kode Keamanan</h4>
                    </div>
                    
                    <div class="card-body p-5">
                        @if (session('status'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('status') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <form action="{{ route('auth.otp.verify') }}" method="POST">
                            @csrf
                            <div class="mb-4">
                                <label for="otp" class="form-label text-muted fw-bold">Kode OTP</label>
                                <input class="form-control form-control-lg text-center" 
                                    style="font-size: 28px; letter-spacing: 15px; font-weight: bold; background-color: #f8f9fa; border-width: 2px;" 
                                    id="otp" name="otp" type="text" placeholder="------" 
                                    maxlength="6" required autofocus autocomplete="off" />
                                @error('otp')
                                    <div class="text-danger small mt-2 fw-bold">{{ $message }}</div>
                                @enderror
                                <div class="form-text mt-2 text-center text-secondary">
                                    Kode terdiri atas 6 kombinasi angka.
                                </div>
                            </div>
                            
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary btn-lg py-3 fw-bold rounded-3">
                                    Konfirmasi OTP
                                </button>
                            </div>
                        </form>
                        
                        <form action="{{ route('auth.otp.resend') }}" method="POST" class="mt-3">
                            @csrf
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-outline-secondary btn-lg py-3 fw-bold rounded-3">
                                    Kirim Ulang OTP
                                </button>
                            </div>
                        </form>
                    </div>
                    <div class="card-footer bg-white text-center py-4 border-top-0">
                        <p class="mb-0 text-muted">Ada kesalahan? 
                            <a href="/login" class="text-decoration-none fw-bold" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Batalkan Login</a>
                        </p>
                        
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                </div>
                
            </div>
        </div>
        
        <!-- Footer -->
        <footer class="bg-white text-center py-4 mt-auto">
            <div class="container text-muted small">
                &copy; {{ date('Y') }} Workshop Framework. All Rights Reserved.
            </div>
        </footer>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
