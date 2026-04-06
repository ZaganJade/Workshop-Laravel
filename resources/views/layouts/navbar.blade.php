<nav class="navbar default-layout-navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row" style="
    background: rgba(255, 255, 255, 0.8) !important;
    backdrop-filter: blur(12px) !important;
    -webkit-backdrop-filter: blur(12px) !important;
    border-bottom: 1px solid rgba(226, 232, 240, 0.6) !important;
    box-shadow: none !important;
">
    <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-start" style="background: transparent !important; width: var(--sidebar-width) !important;">
      <a class="navbar-brand brand-logo" href="{{ url('/admin') }}" style="padding-left: 28px;">
        <i class="mdi mdi-cube-send me-2" style="color: var(--primary-indigo); font-size: 1.8rem; vertical-align: middle;"></i>
        <span style="font-weight: 800; font-size: 1.25rem; letter-spacing: -0.5px; color: #1f2937;">Workshop<span style="color: var(--primary-indigo);">Admin</span></span>
      </a>
      <a class="navbar-brand brand-logo-mini" href="{{ url('/admin') }}" style="padding-left: 20px;">
        <i class="mdi mdi-cube-send" style="color: var(--primary-indigo); font-size: 1.8rem;"></i>
      </a>
    </div>
    <div class="navbar-menu-wrapper d-flex align-items-stretch" style="box-shadow: none !important;">
      <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize" style="color: #64748b;">
        <span class="mdi mdi-menu"></span>
      </button>
      
      <div class="search-field d-none d-md-block ms-3">
        <form class="d-flex align-items-center h-100" action="#">
          <div class="input-group" style="background: #f1f5f9; border-radius: 12px; padding: 2px 12px; border: 1px solid transparent; transition: all 0.2s;">
            <div class="input-group-prepend bg-transparent">
              <i class="input-group-text border-0 mdi mdi-magnify" style="color: #94a3b8; background: transparent;"></i>
            </div>
            <input type="text" class="form-control bg-transparent border-0" placeholder="Cari data..." style="font-size: 0.875rem; color: #475569;">
          </div>
        </form>
      </div>

      <ul class="navbar-nav navbar-nav-right">
        {{-- Activity Logs Quick Access --}}
        <li class="nav-item d-none d-lg-block ms-1">
          <a class="nav-link" href="{{ route('admin.logs.index') }}" title="Log Aktivitas" style="color: #64748b;">
            <i class="mdi mdi-history" style="font-size: 1.4rem;"></i>
          </a>
        </li>

        {{-- Notifications for Pending Orders (Hybrid: Guest + User) --}}
        @php
            $pendingCount = 0;
            $recentPending = collect();
            $guestOrderIds = session()->get('guest_orders', []);
            
            $query = \App\Models\Pesanan::where('status_bayar', 'menunggu');
            
            if(auth()->check()) {
                $userId = auth()->id();
                $query->where(function($q) use ($userId, $guestOrderIds) {
                    $q->where('user_id', $userId)
                      ->orWhereIn('idpesanan', $guestOrderIds);
                });
            } else {
                if(!empty($guestOrderIds)) {
                    $query->whereIn('idpesanan', $guestOrderIds);
                } else {
                    $query->whereRaw('1=0'); // Force empty if no guest orders
                }
            }

            $pendingCount = (clone $query)->count();
            $recentPending = $query->with('payment')->latest()->take(3)->get();
        @endphp
        <li class="nav-item dropdown ms-1">
          <a class="nav-link count-indicator dropdown-toggle" id="notificationDropdown" href="#" data-bs-toggle="dropdown" style="color: #64748b;">
            <i class="mdi mdi-bell-outline" style="font-size: 1.4rem;"></i>
            @if($pendingCount > 0)
              <span class="count-symbol" style="background: #ef4444; width: 8px; height: 8px; top: 18px; right: 8px;"></span>
            @endif
          </a>
          <div class="dropdown-menu dropdown-menu-end navbar-dropdown preview-list shadow-lg border-0" aria-labelledby="notificationDropdown" style="border-radius: 16px; margin-top: 10px; width: 320px;">
            <h6 class="p-3 mb-0" style="font-weight: 700; font-size: 0.9rem;">Notifikasi</h6>
            <div class="dropdown-divider" style="margin: 0;"></div>
            
            @if($pendingCount > 0)
              @foreach($recentPending as $pesanan)
                <a class="dropdown-item preview-item p-3" href="{{ route('pesanan.pending') }}">
                  <div class="preview-thumbnail">
                    <div class="preview-icon rounded-circle d-flex align-items-center justify-content-center" style="background: #fff7ed; color: #f97316; width: 36px; height: 36px;">
                      <i class="mdi mdi-cash-clock"></i>
                    </div>
                  </div>
                  <div class="preview-item-content d-flex align-items-start flex-column justify-content-center">
                    <h6 class="preview-subject font-weight-bold mb-1" style="font-size: 0.85rem;">Pesanan Tertunda</h6>
                    <p class="text-muted mb-0" style="font-size: 0.75rem;">ID: #{{ $pesanan->idpesanan }} - Rp {{ number_format($pesanan->total, 0, ',', '.') }}</p>
                  </div>
                </a>
                <div class="dropdown-divider" style="margin: 0;"></div>
              @endforeach
            @else
              <div class="p-4 text-center text-muted" style="font-size: 0.8rem;">
                <i class="mdi mdi-check-circle-outline d-block mb-2" style="font-size: 2rem; color: #10b981;"></i>
                Semua pesanan sudah dibayar!
              </div>
            @endif

            <a class="p-3 mb-0 text-center d-block" href="{{ route('pesanan.pending') }}" style="font-size: 0.75rem; color: var(--primary-indigo); font-weight: 600; cursor: pointer; text-decoration: none;">Lihat Semua Pesanan Tertunda</a>
          </div>
        </li>

        {{-- User Profile --}}
        <li class="nav-item nav-profile dropdown">
          <a class="nav-link dropdown-toggle d-flex align-items-center" id="profileDropdown" href="#" data-bs-toggle="dropdown" aria-expanded="false">
            <div class="nav-profile-img me-2" style="position: relative;">
               <div style="width: 36px; height: 36px; border-radius: 10px; background: linear-gradient(135deg, var(--primary-indigo), var(--primary-violet)); color: white; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 0.85rem;">
                {{ strtoupper(substr(session('username') ?? 'A', 0, 1)) }}
               </div>
              <span class="availability-status online" style="bottom: -2px; right: -2px; border: 2px solid white;"></span>
            </div>
            <div class="nav-profile-text d-none d-lg-block">
              <p class="mb-0 text-dark font-weight-bold" style="font-size: 0.9rem;">{{ session('username') ?? 'Admin' }}</p>
            </div>
          </a>
          <div class="dropdown-menu navbar-dropdown shadow-lg border-0" aria-labelledby="profileDropdown" style="border-radius: 16px; margin-top: 10px; overflow: hidden;">
            <div class="p-3 bg-light d-flex align-items-center gap-3">
                <div style="width: 40px; height: 40px; border-radius: 10px; background: linear-gradient(135deg, var(--primary-indigo), var(--primary-violet)); color: white; display: flex; align-items: center; justify-content: center; font-weight: 800;">
                    {{ strtoupper(substr(session('username') ?? 'A', 0, 1)) }}
                </div>
                <div>
                    <div style="font-weight: 700; color: #1f2937;">{{ session('username') ?? 'Admin' }}</div>
                    <div style="font-size: 0.7rem; color: #64748b;">Super Administrator</div>
                </div>
            </div>
            <div class="dropdown-divider" style="margin: 0;"></div>
            <a class="dropdown-item py-3 px-4" href="{{ route('admin.logs.index') }}">
              <i class="mdi mdi-cached me-3 text-success"></i> Log Aktivitas </a>
            <a class="dropdown-item py-3 px-4" href="{{ route('auth.google.switch') }}">
              <i class="mdi mdi-account-switch me-3 text-info"></i> Ganti Akun </a>
            <a class="dropdown-item py-3 px-4" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
              <i class="mdi mdi-logout me-3 text-danger"></i> Keluar </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
          </div>
        </li>

        <li class="nav-item nav-logout d-none d-lg-block ms-1">
          <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" title="Logout" style="color: #64748b;">
            <i class="mdi mdi-power" style="font-size: 1.4rem;"></i>
          </a>
        </li>
      </ul>
      
      <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas" style="color: #64748b;">
        <span class="mdi mdi-menu"></span>
      </button>
    </div>
</nav>