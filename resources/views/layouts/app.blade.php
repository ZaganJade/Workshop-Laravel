<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>

    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('build/assets/vendors/mdi/css/materialdesignicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('build/assets/vendors/ti-icons/css/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('build/assets/vendors/css/vendor.bundle.base.css') }}">
    <link rel="stylesheet" href="{{ asset('build/assets/css/style.css') }}">
    
    {{-- DataTables CSS --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    {{-- AOS CSS --}}
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <style>
        :root {
            --primary-indigo: #4f46e5;
            --primary-violet: #7c3aed;
            --glass-bg: rgba(255, 255, 255, 0.85);
            --content-bg: #f8fafc;
            --sidebar-width: 260px;
            --navbar-height: 70px;
        }

        body {
            font-family: 'Outfit', sans-serif;
            -webkit-font-smoothing: antialiased;
            background-color: #f8fafc;
            background-image: 
                radial-gradient(at 0% 0%, rgba(79, 70, 229, 0.05) 0px, transparent 50%),
                radial-gradient(at 100% 0%, rgba(124, 58, 237, 0.08) 0px, transparent 50%),
                radial-gradient(at 100% 100%, rgba(255, 204, 112, 0.03) 0px, transparent 50%);
            background-attachment: fixed;
        }

        .container-scroller {
            background: transparent !important;
        }

        .page-body-wrapper {
            padding-top: var(--navbar-height) !important;
            min-height: calc(100vh - var(--navbar-height));
            background: transparent !important;
            position: relative;
        }

        .main-panel {
            background: transparent !important;
            transition: all 0.3s ease;
        }

        .content-wrapper {
            padding: 1.5rem 1.5rem !important;
            background: transparent !important;
            width: 100% !important;
        }

        /* Modern Scrollbar */
        ::-webkit-scrollbar { width: 10px; height: 10px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { 
            background: #cbd5e1; 
            border-radius: 10px;
            border: 3px solid transparent;
            background-clip: content-box;
        }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }

        /* Global Card Styling Overrides */
        .card {
            background: rgba(255, 255, 255, 0.8) !important;
            backdrop-filter: blur(20px) !important;
            border: 1px solid rgba(255, 255, 255, 0.5) !important;
            border-radius: 24px !important;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.05) !important;
            overflow: hidden !important;
        }

        /* --- MODERN PAGE HEADER --- */
        .modern-page-header {
            background: rgba(255, 255, 255, 0.8) !important;
            backdrop-filter: blur(20px) !important;
            padding: 24px 30px;
            border-radius: 24px;
            margin-bottom: 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 10px 30px rgba(0,0,0,0.02);
            border: 1px solid rgba(255, 255, 255, 0.6);
        }
        .modern-page-header h3 {
            font-weight: 900;
            margin: 0;
            color: #1e293b;
            font-size: 1.5rem;
            display: flex;
            align-items: center;
            gap: 12px;
            letter-spacing: -0.02em;
        }
        .modern-header-icon {
            width: 46px;
            height: 46px;
            background: linear-gradient(135deg, var(--primary-indigo), var(--primary-violet));
            color: white;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 8px 20px rgba(79, 70, 229, 0.25);
            font-size: 1.25rem;
        }

        /* --- MODERN DATATABLES CUSTOMIZATION --- */
        .dataTables_wrapper .dataTables_length select,
        .dataTables_wrapper .dataTables_filter input {
            border: 1px solid #e5e7eb !important;
            border-radius: 10px !important;
            padding: 8px 14px !important;
            background-color: #f9fafb !important;
            outline: none !important;
            font-size: 0.85rem !important;
        }
        .dataTables_wrapper .dataTables_filter input:focus {
            border-color: var(--primary-indigo) !important;
            background-color: #fff !important;
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1) !important;
        }
        table.dataTable.no-footer {
            border-bottom: 1px solid #f1f5f9 !important;
            margin-top: 15px !important;
            margin-bottom: 15px !important;
        }
        table.dataTable thead th {
            background: #f8fafc !important;
            padding: 15px 20px !important;
            font-size: 0.725rem !important;
            font-weight: 700 !important;
            text-transform: uppercase !important;
            letter-spacing: 0.05em !important;
            color: #64748b !important;
            border-bottom: 1px solid #e2e8f0 !important;
        }
        table.dataTable tbody td {
            padding: 14px 20px !important;
            border-bottom: 1px solid #f1f5f9 !important;
            font-size: 0.875rem !important;
            color: #334155 !important;
            vertical-align: middle !important;
        }
        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background: var(--primary-indigo) !important;
            color: white !important;
            border: 1px solid var(--primary-indigo) !important;
            border-radius: 10px !important;
            font-weight: 700 !important;
        }

        .navbar.fixed-top {
            z-index: 1030;
            height: var(--navbar-height) !important;
            transition: none !important;
        }

        .navbar .dropdown-menu {
            display: none !important;
        }
        
        .navbar .dropdown-menu.show, 
        .navbar .dropdown-menu.manual-show {
            display: block !important;
        }

        /* --- GLOBAL SIDEBAR OVERRIDES --- */
        .sidebar {
            background: white !important;
            border-right: 1px solid rgba(226, 232, 240, 0.6) !important;
            box-shadow: none !important;
            width: var(--sidebar-width) !important;
            padding-top: 20px !important;
            transition: width 0.3s ease;
        }

        .sidebar .nav {
            padding-top: 0 !important;
        }

        .sidebar .nav .nav-item {
            border: none !important;
            width: 100% !important;
        }

        .sidebar .nav .nav-item .nav-link {
            display: flex !important;
            flex-direction: row !important;
            align-items: center !important;
            justify-content: flex-start !important;
            padding: 11px 20px !important;
            margin: 4px 15px !important;
            border-radius: 12px !important;
            transition: all 0.2s ease !important;
            color: #64748b !important;
            font-weight: 600 !important;
            font-size: 0.9rem !important;
            text-decoration: none !important;
            background: transparent !important;
            height: auto !important;
            border: 1px solid transparent !important;
            white-space: nowrap !important;
        }

        /* RESET ALL TEMPLATE OVERLAYS */
        .sidebar .nav .nav-item .nav-link:before { display: none !important; }
        .sidebar .nav .nav-item .nav-link i.menu-icon {
            margin: 0 15px 0 0 !important;
            padding: 0 !important;
            width: 24px !important;
            min-width: 24px !important;
            height: 24px !important;
            font-size: 1.25rem !important;
            color: #94a3b8 !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            position: static !important;
            line-height: 1 !important;
            border: none !important;
        }

        .sidebar .nav .nav-item .nav-link .menu-title {
            margin: 0 !important;
            padding: 0 !important;
            line-height: 1.2 !important;
            color: inherit !important;
            font-weight: inherit !important;
            display: inline-block !important;
            vertical-align: middle !important;
        }

        .sidebar .nav .nav-item:not(.is-active):hover .nav-link {
            background-color: #f1f5f9 !important;
            color: #1f2937 !important;
        }

        .sidebar .nav .nav-item:hover .nav-link i.menu-icon {
            color: var(--primary-indigo) !important;
        }

        /* Sidebar Active State - Custom Class to avoid JS conflicts */
        .sidebar .nav .nav-item.is-active > .nav-link {
            background: linear-gradient(135deg, var(--primary-indigo), var(--primary-violet)) !important;
            color: white !important;
            box-shadow: 0 6px 18px rgba(79, 70, 229, 0.25) !important;
            border: 1px solid rgba(255,255,255,0.1) !important;
        }

        .sidebar .nav .nav-item.is-active > .nav-link i.menu-icon {
            color: white !important;
        }

        .sidebar .nav .nav-item.nav-profile {
            background: transparent !important;
            border: none !important;
            padding: 0 !important;
        }

        .sidebar .nav .nav-item.nav-profile .nav-link {
            background: white !important;
            border: 1px solid rgba(226, 232, 240, 0.6) !important;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.03) !important;
            margin: 10px 15px 25px 15px !important;
            padding: 14px 18px !important;
            height: auto !important;
            flex-direction: row !important;
        }

        .sidebar .nav .nav-item .nav-link .menu-title {
            color: inherit !important;
            font-family: inherit !important;
        }

        @media (max-width: 991px) {
            .sidebar-offcanvas {
                right: calc(-1 * var(--sidebar-width)) !important;
            }
            .sidebar-offcanvas.active {
                right: 0 !important;
            }
        }

        /* --- GLOBAL UI FIX: Prevent Blinking Caret on Static Text --- */
        body *:not(input):not(textarea):not(button):not(a):not(.btn):not(select):not(.form-check-input):not([contenteditable="true"]) {
            caret-color: transparent !important;
            cursor: default;
        }

        /* Explicitly restore for editable elements to prevent inheritance issues */
        input, textarea, [contenteditable="true"], .form-control {
            caret-color: auto !important;
            cursor: text !important;
        }
    </style>

    @vite(['resources/css/app.css'])
    @stack('css')
</head>

<body>

<div class="container-scroller">

    {{-- Navbar --}}
    @include('layouts.navbar')

    <div class="container-fluid page-body-wrapper">

        {{-- Sidebar --}}
        @include('layouts.sidebar')

        {{-- Main Content --}}
        <div class="main-panel">
            <div class="content-wrapper">

                {{-- Flash Messages --}}
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @yield('content')

            </div>

            {{-- Footer --}}
            @include('layouts.footer')

        </div>

    </div>

</div>

<!-- JS -->
<script src="{{ asset('build/assets/vendors/js/vendor.bundle.base.js') }}"></script>

<!-- DataTables JS -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>

<script src="{{ asset('build/assets/js/off-canvas.js') }}"></script>
<script src="{{ asset('build/assets/js/misc.js') }}"></script>
<script src="{{ asset('build/assets/js/settings.js') }}"></script>

<!-- Custom Overrides for Dropdowns -->
<style>
  .manual-show {
    display: block !important;
    visibility: visible !important;
    opacity: 1 !important;
    z-index: 9999 !important;
    position: absolute !important;
    top: 100% !important;
    right: 0 !important;
    min-width: 200px !important;
  }
</style>

@vite(['resources/js/app.js'])

<script>
  (function() {
    console.log("Ultra-robust dropdown handler initialized");
    
    // Using capture phase to get ahead of other scripts
    window.addEventListener('click', function(e) {
      var toggle = e.target.closest('.dropdown-toggle');
      
      if (toggle) {
        console.log("Dropdown toggle intercepted on capture phase:", toggle.id);
        e.preventDefault();
        e.stopPropagation();
        
        var parent = toggle.closest('.dropdown');
        var menu = parent ? parent.querySelector('.dropdown-menu') : null;
        
        if (menu) {
          var isShown = menu.classList.contains('manual-show');
          console.log("Current manual-show state:", isShown);
          
          // Close all
          document.querySelectorAll('.manual-show').forEach(function(el) {
            el.classList.remove('manual-show');
          });
          
          if (!isShown) {
            console.log("Forcing menu open");
            menu.classList.add('manual-show');
            parent.classList.add('show');
          }
        }
      } else if (!e.target.closest('.dropdown-menu')) {
        document.querySelectorAll('.manual-show').forEach(function(el) {
          el.classList.remove('manual-show');
        });
      }
    }, true); // true = Use capture phase
  })();

  // Global UI Fix: Prevent Caret/Focus on non-interactive elements
  (function() {
    console.log("Global Caret Fix initialized");
    
    // Prevent focus on non-interactive elements
    document.addEventListener('focus', function(e) {
      var target = e.target;
      var isInteractive = target.closest('input, textarea, button, a, .btn, select, [contenteditable="true"], .form-check-input, .form-control, label');
      
      if (!isInteractive && target !== document.body && target !== document.documentElement) {
        target.blur();
      }
    }, true);

    // Remove accidental contenteditable on mousedown
    document.addEventListener('mousedown', function(e) {
      var target = e.target;
      if (target.hasAttribute('contenteditable') && target.getAttribute('contenteditable') !== 'true') {
        // Only if it's explicitly set but not "true" or just present
      }
      // General cleanup if needed
      if (!target.closest('input, textarea, [contenteditable="true"]')) {
        // Ensure no weird caret browsing behavior
      }
    }, true);
  })();
</script>

    <!-- AI Chatbot Component (Global) -->
    <x-chatbot />

    @stack('js')

</body>
</html>
