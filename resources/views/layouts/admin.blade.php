<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="description" content="adminHMD professional admin dashboard template">
  <title>Dashboard | adminHMD</title>

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
        <a class="brand-mark" href="{{ route('admin.dashboard') }}" aria-label="Admin Dashboard">
          <span class="brand-icon"><i class="bi bi-grid-1x2-fill" aria-hidden="true"></i></span>
          <span class="brand-copy">
            <span class="brand-title">Desa Kalinaun</span>
            <span class="brand-subtitle">Admin Panel</span>
          </span>
        </a>
      </div>

      <nav class="sidebar-nav">
        <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}" aria-current="page">
          <span class="nav-icon"><i class="bi bi-speedometer2" aria-hidden="true"></i></span>
          <span class="nav-text">Dashboard</span>
        </a>
        <a class="nav-link {{ request()->routeIs('admin.pengguna') ? 'active' : '' }}" href="{{ route('admin.pengguna') }}">
          <span class="nav-icon"><i class="bi bi-people" aria-hidden="true"></i></span>
          <span class="nav-text">Kelola Pengguna</span>
        </a>
        <a class="nav-link {{ request()->routeIs('admin.pengajuan') ? 'active' : '' }}" href="{{ route('admin.pengajuan') }}">
          <span class="nav-icon"><i class="bi bi-file-earmark" aria-hidden="true"></i></span>
          <span class="nav-text">Kelola Pengajuan</span>
        </a>
        <a class="nav-link {{ request()->routeIs('admin.jenis_surat') ? 'active' : '' }}" href="{{ route('admin.jenis_surat') }}">
          <span class="nav-icon"><i class="bi bi-file-earmark-plus" aria-hidden="true"></i></span>
          <span class="nav-text">Jenis Surat</span>
        </a>
        <a class="nav-link {{ request()->routeIs('admin.bansos') ? 'active' : '' }}" href="{{ route('admin.bansos') }}">
          <span class="nav-icon"><i class="bi bi-hand-thumbs-up" aria-hidden="true"></i></span>
          <span class="nav-text">Kelola Bansos</span>
        </a>
        <a class="nav-link {{ request()->routeIs('admin.jenis_bansos') ? 'active' : '' }}" href="{{ route('admin.jenis_bansos') }}">
          <span class="nav-icon"><i class="bi bi-box2-heart" aria-hidden="true"></i></span>
          <span class="nav-text">Jenis Bansos</span>
        </a>
        <a class="nav-link {{ request()->routeIs('admin.informasi') ? 'active' : '' }}" href="{{ route('admin.informasi') }}">
          <span class="nav-icon"><i class="bi bi-newspaper" aria-hidden="true"></i></span>
          <span class="nav-text">Kelola Informasi</span>
        </a>
        <a class="nav-link {{ request()->routeIs('admin.laporan') ? 'active' : '' }}" href="{{ route('admin.laporan') }}">
          <span class="nav-icon"><i class="bi bi-file-text" aria-hidden="true"></i></span>
          <span class="nav-text">Kelola Pengaduan</span>
        </a>
      </nav>

      <div class="sidebar-user">
        <img class="avatar-img avatar-md sidebar-user-avatar" src="{{ asset('mentahan1/assets/images/avatar/avatar.jpg') }}" alt="{{ Auth::user()->name }}">
        <strong>{{ Auth::user()->name }}</strong>
        <small>Admin</small>
      </div>

      <div class="sidebar-footer">
        <span class="status-dot"></span>
        <span class="sidebar-footer-text">System running smoothly</span>
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
            <input class="form-control search-input" type="search" placeholder="Search users, orders, reports" aria-label="Search">
          </form>

          <div class="navbar-actions ms-auto">
            <button class="icon-button theme-toggle" type="button" data-theme-toggle aria-label="Switch color theme" title="Switch color theme">
              <i class="bi bi-moon-stars" data-theme-icon aria-hidden="true"></i>
            </button>
            <div class="dropdown">
              <button class="icon-button" type="button" data-bs-toggle="dropdown" aria-expanded="false" aria-label="Notifications">
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
                <img class="avatar-img avatar-sm" src="{{ asset('mentahan1/assets/images/avatar/avatar.jpg') }}" alt="{{ Auth::user()->name }}">
                <span class="profile-name d-none d-sm-inline">{{ Auth::user()->name }}</span>
              </button>
              <ul class="dropdown-menu dropdown-menu-end">
                <li><a class="dropdown-item" href="{{ route('admin.profil') }}">Profile</a></li>
                <!-- <li><a class="dropdown-item" href="#">Account settings</a></li> -->
                <li><hr class="dropdown-divider"></li>
                <li>
                  <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                    @csrf
                    <button type="submit" class="dropdown-item" style="background: none; border: none; cursor: pointer; text-align: left;">Sign out</button>
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
          <!-- <span>Copyright 2026 adminHMD. <br> Developed by <a target="_blank" class="fw-bold text-success" href="https://github.com/HasanMahmudDev">Md. Hasan Mahmud</a> • Distributed by <a target="_blank" class="fw-bold text-success" href="https://themewagon.com">ThemeWagon</a> </span>
          <span>Professional dashboard template.</span> -->
        </div>
      </footer>
    </div>
  </div>

  <script src="{{ asset('mentahan1/assets/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('mentahan1/assets/js/main.js') }}"></script>
  <script src="{{ asset('mentahan1/assets/js/notifications.js') }}"></script>
</body>
</html>
