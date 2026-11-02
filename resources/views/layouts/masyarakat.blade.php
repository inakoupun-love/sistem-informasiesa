<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="description" content="Dashboard Masyarakat Desa Kalinaun">
  <title>Dashboard Masyarakat | Desa Kalinaun</title>

  <!-- Preconnect untuk stabilisasi koneksi aset lokal dan eksternal -->
  <link rel="preconnect" href="{{ url('/') }}">
  <link rel="preconnect" href="https://ui-avatars.com">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

  <link rel="preload" href="{{ asset('mentahan1/assets/css/bootstrap.min.css') }}" as="style">
  <link rel="preload" href="{{ asset('mentahan1/assets/css/style.css') }}" as="style">

  <link rel="stylesheet" href="{{ asset('mentahan1/assets/css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('mentahan1/assets/vendors/bootstrap-icons/bootstrap-icons.css') }}">
  <link rel="stylesheet" href="{{ asset('mentahan1/assets/css/style.css') }}">
  <link rel="stylesheet" href="{{ asset('mentahan1/assets/css/notifications.css') }}">
</head>

<body>
  <div class="admin-shell">
    <div class="sidebar-backdrop" data-sidebar-close></div>

    <aside class="admin-sidebar" id="adminSidebar" aria-label="Main navigation">
      <div class="sidebar-header">
        <a class="brand-mark" href="{{ route('masyarakat.dashboard') }}" aria-label="Dashboard Masyarakat">
          <span class="brand-icon"><i class="bi bi-house-door" aria-hidden="true"></i></span>
          <span class="brand-copy">
            <span class="brand-title">Desa Kalinaun</span>
            <span class="brand-subtitle">Masyarakat</span>
          </span>
        </a>
      </div>

      <nav class="sidebar-nav">
        <a class="nav-link {{ request()->routeIs('masyarakat.dashboard') ? 'active' : '' }}" href="{{ route('masyarakat.dashboard') }}" aria-current="page">
          <span class="nav-icon"><i class="bi bi-speedometer2" aria-hidden="true"></i></span>
          <span class="nav-text">Dashboard</span>
        </a>
        <a class="nav-link {{ request()->routeIs('masyarakat.buat_pengajuan') ? 'active' : '' }}" href="{{ route('masyarakat.buat_pengajuan') }}">
          <span class="nav-icon"><i class="bi bi-file-earmark-plus" aria-hidden="true"></i></span>
          <span class="nav-text">Buat Pengajuan</span>
        </a>
        <a class="nav-link {{ request()->routeIs('masyarakat.buat_bansos') ? 'active' : '' }}" href="{{ route('masyarakat.buat_bansos') }}">
          <span class="nav-icon"><i class="bi bi-hand-thumbs-up" aria-hidden="true"></i></span>
          <span class="nav-text">Permintaan Bansos</span>
        </a>
        <a class="nav-link {{ request()->routeIs('masyarakat.buat_laporan') ? 'active' : '' }}" href="{{ route('masyarakat.buat_laporan') }}">
          <span class="nav-icon"><i class="bi bi-megaphone" aria-hidden="true"></i></span>
          <span class="nav-text">Buat Pengaduan</span>
        </a>
        <a class="nav-link {{ request()->routeIs('masyarakat.riwayat') ? 'active' : '' }}" href="{{ route('masyarakat.riwayat') }}">
          <span class="nav-icon"><i class="bi bi-clock-history" aria-hidden="true"></i></span>
          <span class="nav-text">Riwayat Saya</span>
        </a>

        <a class="nav-link {{ request()->routeIs('cekbansos') ? 'active' : '' }}" href="{{ route('cekbansos') }}">
          <span class="nav-icon"><i class="bi bi-box2-heart" aria-hidden="true"></i></span>
          <span class="nav-text">Cek Bansos</span>
        </a>

        <a class="nav-link {{ request()->routeIs('masyarakat.profil') ? 'active' : '' }}" href="{{ route('masyarakat.profil') }}">
          <span class="nav-icon"><i class="bi bi-person-circle" aria-hidden="true"></i></span>
          <span class="nav-text">Profil</span>
        </a>
      </nav>

      <div class="sidebar-user">
        <img class="avatar-img avatar-md sidebar-user-avatar" src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=random" alt="{{ Auth::user()->name }}">
        <strong>{{ Auth::user()->name }}</strong>
        <small>Masyarakat</small>
      </div>

      <div class="sidebar-footer">
        <span class="status-dot"></span>
        <span class="sidebar-footer-text">Sistem berjalan lancar</span>
      </div>
    </aside>

    <div class="admin-main">
      <nav class="navbar admin-navbar navbar-expand bg-white">
        <div class="container-fluid px-3 px-lg-4">
          <button class="sidebar-toggle" type="button" data-sidebar-toggle aria-controls="adminSidebar" aria-expanded="true" aria-label="Toggle sidebar">
            <span></span>
            <span></span>
            <span></span>
          </button>

          <form class="d-none d-md-flex ms-3 flex-grow-1" role="search">
            <input class="form-control search-input" type="search" placeholder="Cari pengajuan, laporan..." aria-label="Search">
          </form>

          <div class="navbar-actions ms-auto">
            <button class="icon-button theme-toggle" type="button" data-theme-toggle aria-label="Ubah tema" title="Ubah tema">
              <i class="bi bi-moon-stars" data-theme-icon aria-hidden="true"></i>
            </button>
            <div class="dropdown">
              <button class="icon-button" type="button" data-bs-toggle="dropdown" aria-expanded="false" aria-label="Notifikasi">
                <span class="notification-dot"></span>
                <i class="bi bi-bell" aria-hidden="true"></i>
              </button>
              <div class="dropdown-menu dropdown-menu-end notification-menu">
                <div class="dropdown-header fw-bold text-body d-flex justify-content-between align-items-center">
                  <span>Notifikasi</span>
                  <button class="btn btn-sm btn-link" data-mark-all-read title="Tandai semua telah dibaca">
                    <i class="bi bi-check-all"></i>
                  </button>
                </div>
                <!-- Notifications will be loaded here by JavaScript -->
              </div>
            </div>

            <div class="dropdown">
              <button class="profile-button dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                <img class="avatar-img avatar-sm" src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=random" alt="{{ Auth::user()->name }}">
                <span class="profile-name d-none d-sm-inline">{{ Auth::user()->name }}</span>
              </button>
              <ul class="dropdown-menu dropdown-menu-end">

                <li><hr class="dropdown-divider"></li>
                <li>
                  <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                    @csrf
                    <button type="submit" class="dropdown-item" style="background: none; border: none; cursor: pointer; text-align: left;">Logout</button>
                  </form>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </nav>

      <main class="dashboard-content">
        <div class="container-fluid px-3 px-lg-4 py-4">
          @yield('content')
        </div>
      </main>

      <footer class="admin-footer">
        <div class="container-fluid px-3 px-lg-4">
          <span>Copyright 2026 Desa Kalinaun. <br> Sistem Manajemen Desa</span>
          <span>All rights reserved.</span>
        </div>
      </footer>
    </div>
  </div>

  <script src="{{ asset('mentahan1/assets/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('mentahan1/assets/js/main.js') }}"></script>
  <script src="{{ asset('mentahan1/assets/js/notifications.js') }}"></script>
</body>
</html>
