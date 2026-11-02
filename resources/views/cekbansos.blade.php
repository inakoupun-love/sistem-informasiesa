<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="Cek Status Penerima Bantuan Sosial (Bansos) - Desa Kalinaun">
  <title>Cek Bantuan Sosial - Desa Kalinaun</title>

  <link href="https://fonts.googleapis.com/css?family=Poppins:100,200,300,400,500,600,700,800,900" rel="stylesheet">
  <link href="{{ asset('mentahan2/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('mentahan2/assets/css/fontawesome.css') }}">
  <link rel="stylesheet" href="{{ asset('mentahan2/assets/css/templatemo-edu-meeting.css') }}">
  <link rel="stylesheet" href="{{ asset('mentahan2/assets/css/owl.css') }}">

  <style>
    body {
      background-color: #f8fafc;
      font-family: 'Poppins', sans-serif;
      color: #334155;
    }

    .header-area {
      background-color: #1f272b !important;
      position: sticky !important;
      top: 0;
      z-index: 1000;
      box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }

    .cekBansos-hero {
      background: linear-gradient(135deg, #a12c2f 0%, #7b1e21 100%);
      color: white;
      padding: 70px 0;
      position: relative;
    }

    .cekBansos-hero h1 {
      font-size: 34px;
      font-weight: 700;
      margin-bottom: 12px;
    }

    .cekBansos-hero p {
      font-size: 15px;
      color: rgba(255, 255, 255, 0.85);
      max-width: 640px;
      margin: 0 auto;
    }

    .search-card {
      background: white;
      border-radius: 16px;
      padding: 36px;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
      margin-top: -36px;
      margin-bottom: 50px;
      position: relative;
      z-index: 10;
    }

    .search-card label {
      font-weight: 600;
      color: #1e293b;
    }

    .search-card .form-control {
      border-radius: 10px;
      padding: 14px 16px;
      border-color: #e2e8f0;
    }

    .search-card .form-control:focus {
      border-color: #a12c2f;
      box-shadow: 0 0 0 0.2rem rgba(161, 44, 47, 0.15);
    }

    .btn-bansos {
      background-color: #a12c2f;
      border-color: #a12c2f;
      color: white;
      border-radius: 10px;
      padding: 14px 28px;
      font-weight: 600;
      transition: all 0.3s ease;
    }

    .btn-bansos:hover {
      background-color: #7b1e21;
      border-color: #7b1e21;
      color: white;
    }

    .result-card {
      background: white;
      border-radius: 16px;
      padding: 32px;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
      margin-bottom: 50px;
      border: 2px solid transparent;
      position: relative;
    }

    .result-card.received {
      border-color: #10b981;
    }

    .result-card.not-received {
      border-color: #f43f5e;
    }

    .result-card.not-found {
      border-color: #f59e0b;
    }

    .result-icon {
      width: 68px;
      height: 68px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 30px;
      margin: 0 auto 18px;
    }

    .receipient-avatar {
      width: 60px;
      height: 60px;
      border-radius: 8px;
      background-color: #f1f5f9;
      display: flex;
      align-items: center;
      justify-content: center;
      font-weight: 700;
      color: #a12c2f;
      font-size: 20px;
    }

    .state-table td {
      padding: 8px 12px;
      border: 1px solid #f1f5f9;
    }

    footer {
      background-color: #1f272b;
      color: #94a3b8;
      padding: 30px 0;
      font-size: 13.5px;
      text-align: center;
      border-top: 1px solid #334155;
    }

    footer a {
      color: white;
      text-decoration: none;
      font-weight: 600;
    }

    footer a:hover {
      color: #a12c2f;
    }

    @media (max-width: 768px) {
      .cekBansos-hero h1 {
        font-size: 24px;
      }
      .cekBansos-hero {
        padding: 50px 0;
      }
      .search-card {
        padding: 24px;
        margin-top: -20px;
      }
    }
  </style>
</head>
<body>

  <!-- Header Area Start -->
  <header class="header-area header-sticky">
    <div class="container">
      <div class="row">
        <div class="col-12">
          <nav class="main-nav">
            <a href="{{ route('welcome') }}" class="logo" style="display: flex; align-items: center; gap: 10px; text-decoration: none;">
              <img src="{{ asset('mentahan2/assets/images/logodesa.png') }}" alt="Desa Kalinaun" style="height: 40px; width: auto;">
              <span style="font-weight: bold; color: #ffffff; font-size: 16px;">Desa Kalinaun</span>
            </a>
            <ul class="nav justify-content-end">
              <li><a href="{{ route('profil-desa') }}" class="btn btn-outline-light btn-sm"><i class="fa fa-building"></i> Profil Desa</a></li>
              <li><a href="{{ route('cekbansos') }}" class="btn btn-outline-light btn-sm active"><i class="fa fa-boxes"></i> Cek Bansos</a></li>
            </ul>
            <a class='menu-trigger'>
              <span>Menu</span>
            </a>
          </nav>
        </div>
      </div>
    </div>
  </header>
  <!-- Header Area End -->

  <!-- Hero Section -->
  <section class="cekBansos-hero text-center">
    <div class="container">
      <a href="{{ route('welcome') }}" class="small text-white-50"><i class="fa fa-arrow-left"></i> Kembali ke Beranda</a><br><br>
      <h1>Cek Penerima Bantuan Sosial</h1>
      <p>Masukkan Nomor Induk Kependudukan (NIK) Anda untuk mengetahui apakah Anda terdaftar sebagai penerima bantuan sosial di Desa Kalinaun.</p>
    </div>
  </section>

  <!-- Form / Search Section -->
  <section class="container">
    <div class="row">
      <div class="col-lg-8 offset-lg-2">
        <div class="search-card">
          <form method="GET" action="{{ route('cekbansos') }}" class="row g-3 align-items-end">
            @csrf
            <div class="col-12 col-md-8">
              <label for="nik" class="form-label mb-2">NIK (Nomor Induk Kependudukan)</label>
              <input type="text" id="nik" name="nik" class="form-control" placeholder="Masukkan NIK 16 digit Anda" value="{{ request('nik') }}" required maxlength="20" inputmode="numeric">
            </div>
            <div class="col-12 col-md-4">
              <button type="submit" class="btn btn-bansos w-100">
                <i class="fa fa-search me-1"></i> Periksa Status
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>

    @if(request()->filled('nik'))
    <div class="row">
      <div class="col-lg-8 offset-lg-2">
        @if(!$user)
          <div class="result-card not-found text-center">
            <div class="result-icon bg-warning-subtle text-warning"><i class="fa fa-user-slash"></i></div>
            <h4 class="fw-bold text-warning mb-2">NIK Tidak Ditemukan</h4>
            <p class="text-muted mb-1">NIK <strong>{{ request('nik') }}</strong> tidak terdaftar dalam sistem kependudukan Desa Kalinaun.</p>
            <p class="text-muted mb-4">Pastikan NIK yang Anda masukkan sudah benar. Jika belum memiliki akun, silakan daftar terlebih dahulu pada menu masuk/daftar.</p>
            <a href="{{ route('login') }}" class="btn btn-bansos"><i class="fa fa-share me-1"></i> Login / Daftar</a>
          </div>
        @elseif($bansosList->isEmpty())
          <div class="result-card not-received text-center">
            <div class="result-icon bg-danger-subtle text-danger"><i class="fa fa-times-circle"></i></div>
            <h4 class="fw-bold text-danger mb-2">Tidak Terdaftar sebagai Penerima Bansos</h4>
            <p class="text-muted mb-1">Kami mohon maaf, <strong>{{ $user->name }}</strong>.</p>
            <p class="text-muted mb-4">Anda belum terdaftar sebagai penerima bantuan sosial. Anda dapat mengajukan permohonan bansos melalui akun Anda.</p>
            <a href="{{ route('login') }}" class="btn btn-bansos"><i class="fa fa-share me-1"></i> Ajukan Permohonan Bansos</a>
          </div>
        @else
          <div class="result-card received">
            <div class="text-center">
              <div class="result-icon bg-success-subtle text-success"><i class="fa fa-check"></i></div>
              <h4 class="fw-bold text-success mb-1">Selamat! Anda Menerima Bantuan Sosial</h4>
              <p class="text-muted mb-4">Berikut adalah program bantuan sosial yang Anda terima.</p>
            </div>

            <div class="d-flex align-items-center gap-3 mb-4 p-3 rounded-3 bg-light">
              <div class="receipient-avatar">{{ strtoupper(substr($user->name, 0, 1)) }}</div>
              <div>
                <strong>{{ $user->name }}</strong><br>
                <small class="text-muted">NIK: {{ $user->nik }}</small>
              </div>
            </div>

            <div class="table-responsive">
              <table class="table align-middle mb-0 state-table">
                <thead>
                  <tr>
                    <th scope="col">No</th>
                    <th scope="col">Program Bansos</th>
                    <th scope="col">Status</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($bansosList as $index => $b)
                  <tr>
                    <td>{{ $index + 1 }}</td>
                    <td class="fw-semibold">{{ $b->jenisBansos->nama_bansos ?? 'Program Dihapus' }}</td>
                    <td><span class="badge text-bg-success">Disetujui</span></td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>

            <p class="text-muted small mt-3 mb-0"><i class="fa fa-info-circle me-1"></i> Hubungi Kantor Desa Kalinaun untuk informasi lebih lanjut mengenai penyaluran bantuan.</p>
          </div>
        @endif
      </div>
    </div>
    @endif
  </section>

  <!-- Footer Section -->
  <footer>
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <p>Copyright © 2026 SIPAKAL Desa Kalinaun. Hak Cipta Dilindungi.</p>
          <p class="small text-muted mt-1">Sistem Pelayanan Administrasi Kalinaun.</p>
        </div>
      </div>
    </div>
  </footer>

  <script src="{{ asset('mentahan2/vendor/jquery/jquery.min.js') }}"></script>
  <script src="{{ asset('mentahan2/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>