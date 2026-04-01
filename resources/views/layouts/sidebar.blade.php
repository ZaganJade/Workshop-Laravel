<div>
  <nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
      <li class="nav-item nav-profile">
        <a href="#" class="nav-link">
          <div class="nav-profile-image">
            <img src="{{ asset('build/assets/images/faces/face1.jpg') }}" alt="profile" />
            <span class="login-status online"></span>
            <!--change to offline or busy as needed-->
          </div>
          <div class="nav-profile-text d-flex flex-column">
            <span class="font-weight-bold mb-2">{{ session('username') ?? 'Administrator' }}</span>
            <span class="text-secondary text-small">System Admin</span>
          </div>
          <i class="mdi mdi-bookmark-check text-success nav-profile-badge"></i>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{ url('/admin') }}">
          <span class="menu-title">Dashboard</span>
          <i class="mdi mdi-home menu-icon"></i>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{ route('admin.kategori.index') }}">
          <span class="menu-title">Kategori</span>
          <i class="mdi mdi-format-list-bulleted-type menu-icon"></i>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{ route('admin.buku.index') }}">
          <span class="menu-title">Buku</span>
          <i class="mdi mdi-book-open-variant menu-icon"></i>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{ route('admin.barang.index') }}">
          <span class="menu-title">Barang</span>
          <i class="mdi mdi-barcode menu-icon"></i>
        </a>
      </li>
    </ul>
  </nav>
</div>