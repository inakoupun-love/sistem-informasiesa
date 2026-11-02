<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="Profil Desa Kalinaun - Informasi Desa, Visi & Misi, dan Struktur Organisasi">
  <title>Profil Desa - Desa Kalinaun</title>

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

    .profil-hero {
      background: linear-gradient(135deg, #a12c2f 0%, #7b1e21 100%);
      color: white;
      padding: 70px 0;
      text-align: center;
    }

    .profil-hero h1 {
      font-size: 34px;
      font-weight: 700;
      margin-bottom: 12px;
    }

    .profil-hero p {
      font-size: 15px;
      color: rgba(255, 255, 255, 0.85);
      max-width: 640px;
      margin: 0 auto;
    }

    .profil-card {
      background: white;
      border-radius: 16px;
      padding: 36px;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
      margin-bottom: 30px;
    }

    .profil-card.overlap {
      margin-top: -36px;
      position: relative;
      z-index: 10;
    }

    .profil-title {
      font-size: 20px;
      font-weight: 700;
      color: #1e293b;
      margin-bottom: 22px;
      padding-bottom: 14px;
      border-bottom: 2px solid #f1f5f9;
    }

    .profil-title i {
      color: #a12c2f;
      margin-right: 8px;
    }

    .info-item {
      display: flex;
      justify-content: space-between;
      gap: 16px;
      padding: 11px 0;
      border-bottom: 1px dashed #e2e8f0;
    }

    .info-item:last-child {
      border-bottom: none;
    }

    .info-label {
      font-weight: 600;
      color: #64748b;
      font-size: 14px;
    }

    .info-value {
      font-weight: 600;
      color: #1e293b;
      font-size: 14px;
      text-align: right;
    }

    .deskripsi-text {
      line-height: 1.9;
      font-size: 15px;
      color: #475569;
    }

    .visi-box {
      background: linear-gradient(135deg, rgba(161, 44, 47, 0.06) 0%, rgba(123, 30, 33, 0.06) 100%);
      border-left: 4px solid #a12c2f;
      border-radius: 12px;
      padding: 24px 26px;
    }

    .visi-box h4 {
      font-weight: 700;
      color: #a12c2f;
      margin-bottom: 10px;
      font-size: 17px;
    }

    .visi-box p {
      margin-bottom: 0;
      font-size: 15.5px;
      line-height: 1.9;
      color: #334155;
    }

    .misi-heading {
      font-weight: 700;
      color: #1e293b;
      font-size: 17px;
      margin: 28px 0 16px;
    }

    .misi-heading i {
      color: #a12c2f;
      margin-right: 8px;
    }

    .misi-list {
      padding-left: 0;
      list-style: none;
      counter-reset: misi;
      margin-bottom: 0;
    }

    .misi-list li {
      counter-increment: misi;
      position: relative;
      padding: 13px 18px 13px 58px;
      background: #f8fafc;
      border-radius: 10px;
      margin-bottom: 10px;
      font-size: 14.5px;
      line-height: 1.7;
      color: #475569;
    }

    .misi-list li:last-child {
      margin-bottom: 0;
    }

    .misi-list li::before {
      content: counter(misi);
      position: absolute;
      left: 14px;
      top: 50%;
      transform: translateY(-50%);
      width: 30px;
      height: 30px;
      border-radius: 50%;
      background: #a12c2f;
      color: #ffffff;
      font-weight: 700;
      font-size: 14px;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .connector {
      width: 2px;
      height: 26px;
      background: #cbd5e1;
      margin: 0 auto;
    }

    .struktur-item {
      background: #ffffff;
      border: 1px solid #e2e8f0;
      border-radius: 12px;
      padding: 20px 14px;
      text-align: center;
      transition: all 0.3s ease;
      height: 100%;
    }

    .struktur-item:hover {
      border-color: #a12c2f;
      transform: translateY(-3px);
      box-shadow: 0 8px 20px rgba(161, 44, 47, 0.12);
    }

    .struktur-item.kades {
      background: linear-gradient(135deg, #a12c2f 0%, #7b1e21 100%);
      border: none;
    }

    .struktur-item .avatar {
      width: 54px;
      height: 54px;
      border-radius: 50%;
      background: #f1f5f9;
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 0 auto 12px;
      font-size: 22px;
      color: #a12c2f;
    }

    .struktur-item.kades .avatar {
      background: rgba(255, 255, 255, 0.2);
      color: #ffffff;
    }

    .struktur-item .nama {
      font-weight: 600;
      color: #1e293b;
      font-size: 15px;
      margin-bottom: 4px;
      word-break: break-word;
    }

    .struktur-item .jabatan {
      font-size: 12px;
      color: #64748b;
      text-transform: uppercase;
      letter-spacing: 0.6px;
      font-weight: 600;
    }

    .struktur-item.kades .nama {
      color: #ffffff;
    }

    .struktur-item.kades .jabatan {
      color: rgba(255, 255, 255, 0.85);
    }

    .struktur-label {
      text-align: center;
      font-weight: 700;
      color: #1e293b;
      font-size: 15px;
      margin: 26px 0 14px;
      text-transform: uppercase;
      letter-spacing: 1px;
    }

    footer {
      background-color: #1f272b;
      color: #94a3b8;
      padding: 30px 0;
      font-size: 13.5px;
      text-align: center;
      border-top: 1px solid #334155;
      margin-top: 20px;
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
      .profil-hero h1 {
        font-size: 24px;
      }
      .profil-hero {
        padding: 50px 0;
      }
      .profil-card {
        padding: 24px;
      }
      .profil-card.overlap {
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
              <li><a href="{{ route('profil-desa') }}" class="btn btn-outline-light btn-sm active"><i class="fa fa-building"></i> Profil Desa</a></li>
              <li><a href="{{ route('cekbansos') }}" class="btn btn-outline-light btn-sm"><i class="fa fa-boxes"></i> Cek Bansos</a></li>
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
  <section class="profil-hero">
    <div class="container">
      <a href="{{ route('welcome') }}" class="small text-white-50"><i class="fa fa-arrow-left"></i> Kembali ke Beranda</a><br><br>
      <h1>Profil Desa Kalinaun</h1>
      <p>Kenali lebih dekat Desa Kalinaun melalui informasi desa, visi &amp; misi, serta struktur organisasi pemerintah desa.</p>
    </div>
  </section>

  <!-- Informasi Desa -->
  <section class="container" id="informasi">
    <div class="row">
      <div class="col-lg-10 offset-lg-1">
        <div class="profil-card overlap">
          <h3 class="profil-title"><i class="fa fa-map-marker"></i> Informasi Desa</h3>
          <div class="row align-items-center g-4">
            <div class="col-lg-7">
              <p class="deskripsi-text mb-0">
                Desa Kalinaun adalah sebuah desa yang terletak di Kecamatan Likupang Selatan, Kabupaten Minahasa Utara, Provinsi Sulawesi Utara.
                Desa Kalinaun dikenal dengan keindahan alamnya serta keramahan masyarakatnya. Mata pencaharian utama masyarakat desa adalah
                bertani, menangkap ikan, serta berwirausaha. Melalui sistem pelayanan administrasi SIPAKAL, Pemerintah Desa Kalinaun berkomitmen
                memberikan pelayanan yang cepat, mudah, dan transparan kepada seluruh masyarakat.
              </p>
            </div>
            <div class="col-lg-5">
              <div class="info-item">
                <span class="info-label">Nama Desa</span>
                <span class="info-value">Kalinaun</span>
              </div>
              <div class="info-item">
                <span class="info-label">Kecamatan</span>
                <span class="info-value">Likupang Selatan</span>
              </div>
              <div class="info-item">
                <span class="info-label">Kabupaten</span>
                <span class="info-value">Minahasa Utara</span>
              </div>
              <div class="info-item">
                <span class="info-label">Provinsi</span>
                <span class="info-value">Sulawesi Utara</span>
              </div>
              <div class="info-item">
                <span class="info-label">Status</span>
                <span class="info-value">Desa</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Visi & Misi -->
  <section class="container" id="visi-misi">
    <div class="row">
      <div class="col-lg-10 offset-lg-1">
        <div class="profil-card">
          <h3 class="profil-title"><i class="fa fa-eye"></i> Visi &amp; Misi Desa</h3>

          <div class="visi-box">
            <h4><i class="fa fa-eye"></i> Visi</h4>
            <p>
              "Terwujudnya Desa Kalinaun yang mandiri, sejahtera, dan religius melalui tata pemerintahan yang baik,
              pelayanan publik yang prima, serta pemberdayaan masyarakat yang berkelanjutan."
            </p>
          </div>

          <h5 class="misi-heading"><i class="fa fa-bullseye"></i> Misi</h5>
          <ol class="misi-list">
            <li>Meningkatkan kualitas tata pemerintahan desa yang bersih, transparan, dan akuntabel.</li>
            <li>Meningkatkan pelayanan publik yang cepat, mudah, dan berkualitas bagi seluruh masyarakat.</li>
            <li>Meningkatkan kesejahteraan masyarakat melalui pemberdayaan ekonomi desa dan pemanfaatan potensi wilayah.</li>
            <li>Meningkatkan pembangunan dan perawatan infrastruktur desa secara merata dan berkelanjutan.</li>
            <li>Meningkatkan kualitas sumber daya manusia di bidang pendidikan dan kesehatan.</li>
            <li>Memperkuat kebersamaan, toleransi, dan kehidupan keagamaan masyarakat desa.</li>
          </ol>
        </div>
      </div>
    </div>
  </section>

  <!-- Struktur Organisasi -->
  <section class="container pb-4" id="struktur">
    <div class="row">
      <div class="col-lg-10 offset-lg-1">
        <div class="profil-card">
          <h3 class="profil-title"><i class="fa fa-sitemap"></i> Struktur Organisasi Pemerintah Desa</h3>

          <div class="struktur-wrap">
            <div class="row justify-content-center">
              <div class="col-lg-4 col-md-6 mb-3">
                <div class="struktur-item kades">
                  <div class="avatar"><i class="fa fa-user"></i></div>
                  <div class="nama">{{ $kepalaDesa->name ?? 'Nama Kepala Desa' }}</div>
                  <div class="jabatan">Kepala Desa</div>
                </div>
              </div>
            </div>

            <div class="connector"></div>

            <div class="row justify-content-center">
              <div class="col-lg-4 col-md-6 mb-3">
                <div class="struktur-item">
                  <div class="avatar"><i class="fa fa-user"></i></div>
                  <div class="nama">Nama Pejabat</div>
                  <div class="jabatan">Sekretaris Desa</div>
                </div>
              </div>
            </div>

            <div class="connector"></div>

            <p class="struktur-label">Kepala Urusan</p>
            <div class="row justify-content-center">
              <div class="col-lg-3 col-md-4 col-sm-6 mb-3">
                <div class="struktur-item">
                  <div class="avatar"><i class="fa fa-user"></i></div>
                  <div class="nama">Nama Pejabat</div>
                  <div class="jabatan">Kaur Tata Usaha</div>
                </div>
              </div>
              <div class="col-lg-3 col-md-4 col-sm-6 mb-3">
                <div class="struktur-item">
                  <div class="avatar"><i class="fa fa-user"></i></div>
                  <div class="nama">Nama Pejabat</div>
                  <div class="jabatan">Kaur Keuangan</div>
                </div>
              </div>
            </div>

            <p class="struktur-label">Kepala Seksi</p>
            <div class="row justify-content-center">
              <div class="col-lg-3 col-md-4 col-sm-6 mb-3">
                <div class="struktur-item">
                  <div class="avatar"><i class="fa fa-user"></i></div>
                  <div class="nama">Nama Pejabat</div>
                  <div class="jabatan">Kasi Pemerintahan</div>
                </div>
              </div>
              <div class="col-lg-3 col-md-4 col-sm-6 mb-3">
                <div class="struktur-item">
                  <div class="avatar"><i class="fa fa-user"></i></div>
                  <div class="nama">Nama Pejabat</div>
                  <div class="jabatan">Kasi Kesejahteraan</div>
                </div>
              </div>
              <div class="col-lg-3 col-md-4 col-sm-6 mb-3">
                <div class="struktur-item">
                  <div class="avatar"><i class="fa fa-user"></i></div>
                  <div class="nama">Nama Pejabat</div>
                  <div class="jabatan">Kasi Pelayanan</div>
                </div>
              </div>
            </div>

            <p class="struktur-label">Kepala Dusun</p>
            <div class="row justify-content-center">
              <div class="col-lg-3 col-md-4 col-sm-6 mb-3">
                <div class="struktur-item">
                  <div class="avatar"><i class="fa fa-user"></i></div>
                  <div class="nama">Nama Pejabat</div>
                  <div class="jabatan">Kepala Dusun I</div>
                </div>
              </div>
              <div class="col-lg-3 col-md-4 col-sm-6 mb-3">
                <div class="struktur-item">
                  <div class="avatar"><i class="fa fa-user"></i></div>
                  <div class="nama">Nama Pejabat</div>
                  <div class="jabatan">Kepala Dusun II</div>
                </div>
              </div>
            </div>
          </div>

          <p class="text-muted small mt-3 mb-0 text-center"><i class="fa fa-info-circle me-1"></i> Nama pejabat pada bagan dapat diubah sesuai dengan data terbaru Pemerintah Desa Kalinaun.</p>
        </div>
      </div>
    </div>
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
