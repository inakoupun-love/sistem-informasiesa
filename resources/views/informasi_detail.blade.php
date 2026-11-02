<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="Detail Informasi Desa Kalinaun - {{ $info->judul }}">
  <title>{{ $info->judul }} - Desa Kalinaun</title>
  
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

    .detail-header-section {
      background: linear-gradient(135deg, #a12c2f 0%, #7b1e21 100%);
      color: white;
      padding: 60px 0;
      position: relative;
    }

    .detail-header-section a.back-link {
      color: rgba(255, 255, 255, 0.8);
      text-decoration: none;
      font-size: 14px;
      font-weight: 500;
      transition: color 0.3s ease;
      display: inline-flex;
      align-items: center;
      gap: 6px;
      margin-bottom: 20px;
    }

    .detail-header-section a.back-link:hover {
      color: white;
    }

    .detail-header-section h1 {
      font-size: 32px;
      font-weight: 700;
      line-height: 1.3;
      margin-bottom: 15px;
    }

    .meta-item {
      display: inline-flex;
      align-items: center;
      gap: 6px;
      font-size: 13.5px;
      color: rgba(255, 255, 255, 0.85);
      margin-right: 20px;
    }

    .meta-item i {
      color: #fff;
    }

    .content-card {
      background: white;
      border-radius: 16px;
      padding: 40px;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
      margin-top: -30px;
      margin-bottom: 50px;
      position: relative;
      z-index: 10;
    }

    .article-body {
      font-size: 16px;
      line-height: 1.8;
      color: #334155;
      overflow-wrap: break-word;
      word-break: break-word;
    }

    .article-body p {
      margin-bottom: 20px;
    }

    .article-body img {
      max-width: 100%;
      height: auto;
      border-radius: 12px;
      margin: 20px 0;
      box-shadow: 0 5px 15px rgba(0,0,0,0.08);
    }

    .article-body table {
      width: 100% !important;
      max-width: 100%;
      display: block;
      overflow-x: auto;
    }

    .article-body pre {
      overflow-x: auto;
    }

    .sidebar-card {
      background: white;
      border-radius: 16px;
      padding: 24px;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
      margin-top: -30px;
      margin-bottom: 30px;
      position: relative;
      z-index: 10;
    }

    .sidebar-title {
      font-size: 18px;
      font-weight: 700;
      color: #1e293b;
      margin-bottom: 20px;
      padding-bottom: 10px;
      border-bottom: 2px solid #f1f5f9;
      position: relative;
    }

    .sidebar-title::after {
      content: '';
      position: absolute;
      bottom: -2px;
      left: 0;
      width: 40px;
      height: 2px;
      background-color: #a12c2f;
    }

    .news-item {
      display: flex;
      gap: 12px;
      margin-bottom: 16px;
      padding-bottom: 16px;
      border-bottom: 1px solid #f1f5f9;
    }

    .news-item:last-child {
      border-bottom: none;
      margin-bottom: 0;
      padding-bottom: 0;
    }

    .news-img {
      width: 70px;
      height: 70px;
      border-radius: 8px;
      object-fit: cover;
      flex-shrink: 0;
    }

    .news-title {
      font-size: 14px;
      font-weight: 600;
      color: #1e293b;
      line-height: 1.4;
      text-decoration: none;
      transition: color 0.3s ease;
      display: -webkit-box;
      -webkit-line-clamp: 2;
      -webkit-box-orient: vertical;
      overflow: hidden;
    }

    .news-title:hover {
      color: #a12c2f;
    }

    .news-date {
      font-size: 11px;
      color: #94a3b8;
      margin-top: 4px;
    }

    .category-badge {
      background-color: rgba(255, 255, 255, 0.2);
      border: 1px solid rgba(255, 255, 255, 0.4);
      color: white;
      padding: 4px 12px;
      border-radius: 30px;
      font-size: 12px;
      font-weight: 600;
      margin-bottom: 15px;
      display: inline-block;
      text-transform: uppercase;
      letter-spacing: 0.5px;
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
      .detail-header-section h1 {
        font-size: 24px;
      }
      .content-card {
        padding: 24px;
        margin-top: -15px;
      }
      .sidebar-card {
        margin-top: 0;
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
            <a class='menu-trigger'>
              <span>Menu</span>
            </a>
          </nav>
        </div>
      </div>
    </div>
  </header>
  <!-- Header Area End -->

  <!-- Header Section with Title -->
  <section class="detail-header-section">
    <div class="container">
      <div class="row">
        <div class="col-lg-10 offset-lg-1">
          <a href="{{ route('welcome') }}" class="back-link">
            <i class="fa fa-arrow-left"></i> Kembali ke Beranda
          </a>
          <br>
          <span class="category-badge">{{ $info->kategori ?? 'Umum' }}</span>
          <h1>{{ $info->judul }}</h1>
          <div class="meta-info">
            <span class="meta-item">
              <i class="fa fa-calendar-alt"></i> Diposting: {{ $info->created_at->format('d F Y, H:i') }}
            </span>
            <span class="meta-item">
              <i class="fa fa-user"></i> Penulis: {{ $info->user->name ?? 'Administrator' }}
            </span>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Content Section -->
  <section class="container mt-2">
    <div class="row">
      <div class="col-lg-8 offset-lg-1">
        <div class="content-card">
          <article class="article-body">
            {!! $info->konten !!}
          </article>
        </div>
      </div>
      
      <div class="col-lg-3">
        <div class="sidebar-card">
          <h4 class="sidebar-title">Informasi Lainnya</h4>
          @php
            $lainnya = \App\Models\Informasi::where('id', '!=', $info->id)->orderBy('created_at', 'desc')->take(4)->get();
          @endphp
          @forelse($lainnya as $item)
            @php
              preg_match('/<img.+src="([^"]+)"/', $item->konten, $matches);
              $itemImg = !empty($matches[1]) ? $matches[1] : null;
            @endphp
            <div class="news-item">
              @if($itemImg)
                <img src="{{ $itemImg }}" class="news-img" alt="{{ $item->judul }}">
              @else
                <img src="{{ asset('mentahan2/assets/images/service-icon-01.jpg') }}" class="news-img" alt="">
              @endif
              <div>
                <a href="{{ route('informasi.detail', $item->id) }}" class="news-title">{{ $item->judul }}</a>
                <div class="news-date">{{ $item->created_at->format('d M Y') }}</div>
              </div>
            </div>
          @empty
            <p class="text-muted small">Tidak ada informasi lain.</p>
          @endforelse
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
