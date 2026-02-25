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

    <style>
        .page-body-wrapper {
            padding-top: 70px !important;
            min-height: calc(100vh - 70px);
        }
        .navbar.fixed-top {
            z-index: 1030;
        }
        /* Scoped Modal Boundary */
        .content-wrapper {
            position: relative;
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
</script>

@stack('js')

</body>
</html>
