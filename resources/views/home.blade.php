<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - Landing Page</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Outfit', sans-serif;
            overflow-x: hidden;
        }
        .navbar {
            padding: 1rem 0;
            transition: all 0.3s ease;
        }
        .hero-section {
            min-height: 85vh;
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            display: flex;
            align-items: center;
            color: white;
            position: relative;
        }
        .feature-icon {
            width: 4rem;
            height: 4rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            border-radius: 0.75rem;
            margin-bottom: 1.5rem;
        }
        .card {
            border: none;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
            transition: transform 0.3s ease;
        }
        .card:hover {
            transform: translateY(-5px);
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-transparent position-absolute w-100 z-1" style="border-bottom: 1px solid rgba(255,255,255,0.1);">
        <div class="container">
            <a class="navbar-brand fw-bold fs-4" href="{{ url('/') }}">
                {{ config('app.name', 'Workshop Framework') }}
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    @guest
                        <li class="nav-item">
                            <a class="nav-link text-white me-3" href="{{ route('login') }}">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="btn btn-light rounded-pill px-4" href="{{ route('register') }}">Register</a>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link text-white me-3" href="{{ route('admin.buku.index') }}">Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <a class="btn btn-outline-light rounded-pill px-4" href="{{ route('logout') }}"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                Logout
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <header class="hero-section text-center">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <h1 class="display-3 fw-bold mb-4 animate__animated animate__fadeInDown">Welcome to Workshop Framework</h1>
                    <p class="lead mb-5 opacity-75">A simple, modern, and powerful book management system built with Laravel. Manage your books, categories, and more with ease.</p>
                    
                    @guest
                        <div class="d-flex flex-column flex-sm-row justify-content-center gap-3">
                            <a href="{{ route('login') }}" class="btn btn-light btn-lg px-5 py-3 rounded-pill fw-bold">Get Started</a>
                            <a href="#features" class="btn btn-outline-light btn-lg px-5 py-3 rounded-pill">Learn More</a>
                        </div>
                    @else
                        <div class="d-grid gap-3 d-sm-flex justify-content-sm-center">
                            <a href="{{ route('admin.buku.index') }}" class="btn btn-light btn-lg px-5 py-3 rounded-pill fw-bold shadow">Go to Manage Books</a>
                        </div>
                        <div class="mt-4 opacity-75">
                            <p>You are logged in as <strong>{{ Auth::user()->name }}</strong></p>
                        </div>
                    @endguest
                </div>
            </div>
        </div>
    </header>

    <!-- Features Section -->
    <section id="features" class="py-5 bg-light">
        <div class="container py-5">
            <div class="row text-center mb-5">
                <div class="col-lg-8 mx-auto">
                    <h2 class="fw-bold mb-3">Key Features</h2>
                    <p class="text-muted">Discover what makes our system the best choice for your library management needs.</p>
                </div>
            </div>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card h-100 p-4">
                        <div class="feature-icon bg-primary bg-gradient text-white shadow-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-book" viewBox="0 0 16 16">
                                <path d="M1 2.828c.885-.37 2.154-.769 3.388-.893 1.33-.134 2.458.063 3.112.752v9.746c-.935-.53-2.12-.603-3.213-.493-1.18.12-2.37.461-3.287.811V2.828zm7.5-.141c.654-.689 1.782-.886 3.112-.752 1.234.124 2.503.523 3.388.893v9.923c-.918-.35-2.107-.692-3.287-.81-1.094-.111-2.278-.039-3.213.492V2.687zM8 1.783C7.015.936 5.587.81 4.287.94c-1.514.153-3.042.672-3.994 1.105A.5.5 0 0 0 0 2.5v11a.5.5 0 0 0 .707.455c.882-.4 2.303-.881 3.68-1.02 1.409-.142 2.59.087 3.223.877a.5.5 0 0 0 .78 0c.633-.79 1.814-1.019 3.222-.877 1.378.139 2.8.62 3.681 1.02A.5.5 0 0 0 16 13.5v-11a.5.5 0 0 0-.293-.455c-.952-.433-2.48-.952-3.994-1.105C10.413.809 8.985.936 8 1.783z"/>
                            </svg>
                        </div>
                        <h3 class="h5 fw-bold">Manage Books</h3>
                        <p class="text-muted mb-0">Add, edit, and delete books easily. Keep your library organized and up-to-date with our intuitive interface.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100 p-4">
                        <div class="feature-icon bg-success bg-gradient text-white shadow-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-tags" viewBox="0 0 16 16">
                                <path d="M3 2v4.586l7 7L14.586 9l-7-7H3zM2 2a1 1 0 0 1 1-1h4.586a1 1 0 0 1 .707.293l7 7a1 1 0 0 1 0 1.414l-4.586 4.586a1 1 0 0 1-1.414 0l-7-7A1 1 0 0 1 2 6.586V2z"/>
                                <path d="M5.5 5a.5.5 0 1 1 0-1 .5.5 0 0 1 0 1zm0 1a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3zm1.5 1.5a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1z"/>
                            </svg>
                        </div>
                        <h3 class="h5 fw-bold">Explore Categories</h3>
                        <p class="text-muted mb-0">Organize books by categories. Filter and find exactly what you're looking for in seconds.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100 p-4">
                        <div class="feature-icon bg-info bg-gradient text-white shadow-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-shield-lock" viewBox="0 0 16 16">
                                <path d="M5.338 1.59a61.44 61.44 0 0 0-2.837.856.481.481 0 0 0-.328.39c-.554 4.157.726 7.19 2.253 9.188a10.725 10.725 0 0 0 2.287 2.233c.346.244.652.42.893.533.12.057.218.095.293.118a.55.55 0 0 0 .101.025.615.615 0 0 0 .1-.025c.076-.023.174-.061.294-.118.24-.113.547-.29.893-.533a10.726 10.726 0 0 0 2.287-2.233c1.527-1.997 2.807-5.031 2.253-9.188a.48.48 0 0 0-.328-.39c-.651-.213-1.75-.56-2.837-.855C9.552 1.29 8.531 1.067 8 1.067c-.53 0-1.552.223-2.662.524zM5.072.56C6.157.265 7.31 0 8 0s1.843.265 2.928.56c1.11.3 2.229.655 2.887.87a1.54 1.54 0 0 1 1.044 1.262c.596 4.477-.787 7.795-2.465 9.99a11.775 11.775 0 0 1-2.517 2.453 7.159 7.159 0 0 1-1.048.625c-.28.132-.581.24-.829.24s-.548-.108-.829-.24a7.158 7.158 0 0 1-1.048-.625 11.777 11.777 0 0 1-2.517-2.453C1.928 10.487.545 7.169 1.141 2.692A1.54 1.54 0 0 1 2.185 1.43 62.456 62.456 0 0 1 5.072.56z"/>
                                <path d="M9.5 6.5a1.5 1.5 0 0 1-1 1.5v2.5a.5.5 0 0 1-1 0v-2.5a1.5 1.5 0 0 1-1-1.5 1.5 1.5 0 0 1 3 0z"/>
                            </svg>
                        </div>
                        <h3 class="h5 fw-bold">Secure & Reliable</h3>
                        <p class="text-muted mb-0">Built with robust security features to keep your data safe. Enjoy peace of mind with our secure authentication.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="py-4 bg-white border-top">
        <div class="container text-center">
            <p class="text-muted mb-0">&copy; {{ date('Y') }} {{ config('app.name', 'Workshop Framework') }}. All rights reserved.</p>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>


