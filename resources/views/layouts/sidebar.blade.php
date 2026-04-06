<nav class="sidebar sidebar-offcanvas" id="sidebar" style="background: rgba(255, 255, 255, 0.4) !important; backdrop-filter: blur(10px) !important; border-right: 1px solid rgba(255, 255, 255, 0.3) !important;">
    <ul class="nav">
      {{-- Profile Section --}}
      <li class="nav-item nav-profile" style="margin-bottom: 20px !important;">
        <a href="#" class="nav-link" style="background: rgba(255, 255, 255, 0.6) !important; margin: 10px 15px !important; border-radius: 20px !important; border: 1px solid rgba(255, 255, 255, 0.8) !important; box-shadow: 0 10px 25px rgba(0,0,0,0.03) !important; padding: 15px !important;">
          <div class="nav-profile-image" style="width: 48px !important; height: 48px !important;">
            <div style="width: 100%; height: 100%; border-radius: 14px; background: linear-gradient(135deg, #4f46e5, #7c3aed); color: white; display: flex; align-items: center; justify-content: center; font-weight: 900; font-size: 1.25rem; shadow: 0 8px 20px rgba(79, 70, 229, 0.2);">
                {{ strtoupper(substr(Auth::user()->name ?? session('username') ?? 'G', 0, 1)) }}
            </div>
            <span class="login-status online" style="bottom: -2px; right: -2px; border: 3px solid white; background: #22c55e;"></span>
          </div>
          <div class="nav-profile-text d-flex flex-column overflow-hidden ms-3">
            <span class="font-weight-black mb-0" style="color: #1e293b; font-size: 0.95rem; font-weight: 900 !important; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; letter-spacing: -0.01em;">{{ Auth::user()->name ?? session('username') ?? 'Guest User' }}</span>
            <span class="text-indigo-600" style="font-size: 0.65rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.05em;">{{ Auth::check() ? 'SUPER ADMINISTRATOR' : 'VISITOR' }}</span>
          </div>
        </a>
      </li>

      <li class="nav-item mt-2">
        <span style="font-size: 0.65rem; font-weight: 900; text-transform: uppercase; color: #94a3b8; padding: 0 30px; letter-spacing: 0.15em; display: block; margin-bottom: 10px;">Main Menu</span>
      </li>

      {{-- Dashboard --}}
      <li class="nav-item {{ Route::is('admin.dashboard') ? 'is-active' : '' }}">
        <a class="nav-link" href="{{ url('/admin') }}">
          <i class="fas fa-chart-pie menu-icon"></i>
          <span class="menu-title">Statistik Dashboard</span>
        </a>
      </li>

      {{-- POS Transaction --}}
      <li class="nav-item {{ Route::is('pos') ? 'is-active' : '' }}">
        <a class="nav-link" href="{{ route('pos') }}">
          <i class="fas fa-cash-register menu-icon"></i>
          <span class="menu-title">Transaksi POS</span>
        </a>
      </li>

      {{-- Pending Orders --}}
      <li class="nav-item {{ Route::is('pesanan.pending') ? 'is-active' : '' }}">
        <a class="nav-link" href="{{ route('pesanan.pending') }}">
          <i class="fas fa-file-invoice-dollar menu-icon"></i>
          <span class="menu-title">Pesanan Tertunda</span>
        </a>
      </li>

      <li class="nav-item mt-4">
        <span style="font-size: 0.65rem; font-weight: 900; text-transform: uppercase; color: #94a3b8; padding: 0 30px; letter-spacing: 0.15em; display: block; margin-bottom: 10px;">Manajemen Data</span>
      </li>

      <li class="nav-item {{ Route::is('admin.kategori.*') ? 'is-active' : '' }}">
        <a class="nav-link" href="{{ route('admin.kategori.index') }}">
          <i class="fas fa-tags menu-icon"></i>
          <span class="menu-title">Kategori Master</span>
        </a>
      </li>

      <li class="nav-item {{ Route::is('admin.buku.*') ? 'is-active' : '' }}">
        <a class="nav-link" href="{{ route('admin.buku.index') }}">
          <i class="fas fa-book-bookmark menu-icon"></i>
          <span class="menu-title">Katalog Buku</span>
        </a>
      </li>

      <li class="nav-item {{ Route::is('admin.barang.*') ? 'is-active' : '' }}">
        <a class="nav-link" href="{{ route('admin.barang.index') }}">
          <i class="fas fa-boxes-stacked menu-icon"></i>
          <span class="menu-title">Stok Barang</span>
        </a>
      </li>

      <li class="nav-item mt-4">
        <span style="font-size: 0.65rem; font-weight: 900; text-transform: uppercase; color: #94a3b8; padding: 0 30px; letter-spacing: 0.15em; display: block; margin-bottom: 10px;">Audit & Lokasi</span>
      </li>

      <li class="nav-item {{ Route::is('admin.logs.index') ? 'is-active' : '' }}">
        <a class="nav-link" href="{{ route('admin.logs.index') }}">
          <i class="fas fa-clock-rotate-left menu-icon"></i>
          <span class="menu-title">Jejak Aktivitas</span>
        </a>
      </li>

      <li class="nav-item {{ Request::is('admin/wilayah*') ? 'is-active' : '' }}">
        <a class="nav-link" href="{{ url('/admin/wilayah') }}">
          <i class="fas fa-map-location-dot menu-icon"></i>
          <span class="menu-title">Geografi Wilayah</span>
        </a>
      </li>

      <li class="nav-item {{ Request::is('admin/tambah-barang*') ? 'is-active' : '' }}">
        <a class="nav-link" href="{{ url('/admin/tambah-barang/html') }}">
          <i class="fas fa-square-plus menu-icon"></i>
          <span class="menu-title">Quick Entry</span>
        </a>
      </li>
    </ul>
</nav>