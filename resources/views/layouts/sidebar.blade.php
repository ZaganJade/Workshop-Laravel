<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
      {{-- Profile Section --}}
      <li class="nav-item nav-profile">
        <a href="#" class="nav-link">
          <div class="nav-profile-image">
            <div style="width: 100%; height: 100%; border-radius: 12px; background: linear-gradient(135deg, var(--primary-indigo), var(--primary-violet)); color: white; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 1.1rem; box-shadow: 0 4px 12px rgba(79, 70, 229, 0.25);">
                {{ strtoupper(substr(session('username') ?? 'A', 0, 1)) }}
            </div>
            <span class="login-status online" style="bottom: -2px; right: -2px; border: 2.5px solid #f8fafc;"></span>
          </div>
          <div class="nav-profile-text d-flex flex-column overflow-hidden">
            <span class="font-weight-bold mb-1" style="color: #1f2937; font-size: 0.95rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ session('username') ?? 'Administrator' }}</span>
            <span class="text-secondary" style="font-size: 0.75rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">Super Admin</span>
          </div>
        </a>
      </li>

      {{-- Dashboard --}}
      <li class="nav-item {{ Route::is('admin.dashboard') ? 'is-active' : '' }}">
        <a class="nav-link" href="{{ url('/admin') }}">
          <i class="mdi mdi-view-dashboard-outline menu-icon"></i>
          <span class="menu-title">Dashboard</span>
        </a>
      </li>

      <li class="nav-item mt-4">
        <span style="font-size: 0.7rem; font-weight: 800; text-transform: uppercase; color: #94a3b8; padding-left: 30px; letter-spacing: 1.5px;">Manajemen Data</span>
      </li>

      <li class="nav-item {{ Route::is('admin.kategori.*') ? 'is-active' : '' }}">
        <a class="nav-link" href="{{ route('admin.kategori.index') }}">
          <i class="mdi mdi-tag-outline menu-icon"></i>
          <span class="menu-title">Kategori</span>
        </a>
      </li>

      <li class="nav-item {{ Route::is('admin.buku.*') ? 'is-active' : '' }}">
        <a class="nav-link" href="{{ route('admin.buku.index') }}">
          <i class="mdi mdi-book-outline menu-icon"></i>
          <span class="menu-title">Koleksi Buku</span>
        </a>
      </li>

      <li class="nav-item {{ Route::is('admin.barang.*') ? 'is-active' : '' }}">
        <a class="nav-link" href="{{ route('admin.barang.index') }}">
          <i class="mdi mdi-cube-outline menu-icon"></i>
          <span class="menu-title">Inventaris Barang</span>
        </a>
      </li>

      <li class="nav-item mt-4">
        <span style="font-size: 0.7rem; font-weight: 800; text-transform: uppercase; color: #94a3b8; padding-left: 30px; letter-spacing: 1.5px;">Audit & Utilitas</span>
      </li>

      <li class="nav-item {{ Route::is('admin.logs.index') ? 'is-active' : '' }}">
        <a class="nav-link" href="{{ route('admin.logs.index') }}">
          <i class="mdi mdi-history menu-icon"></i>
          <span class="menu-title">Log Aktivitas</span>
        </a>
      </li>

      <li class="nav-item {{ Request::is('admin/wilayah*') ? 'is-active' : '' }}">
        <a class="nav-link" href="{{ url('/admin/wilayah') }}">
          <i class="mdi mdi-map-marker-outline menu-icon"></i>
          <span class="menu-title">Wilayah</span>
        </a>
      </li>

      <li class="nav-item {{ Request::is('admin/tambah-barang*') ? 'is-active' : '' }}">
        <a class="nav-link" href="{{ url('/admin/tambah-barang/html') }}">
            <i class="mdi mdi-plus-box-outline menu-icon"></i>
          <span class="menu-title">Tambah Barang</span>
        </a>
      </li>
    </ul>
</nav>