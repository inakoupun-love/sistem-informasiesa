<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>403 - Unauthorized</title>
  <link rel="stylesheet" href="{{ asset('mentahan1/assets/css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('mentahan1/assets/vendors/bootstrap-icons/bootstrap-icons.css') }}">
  <style>
    body {
      display: flex;
      align-items: center;
      justify-content: center;
      min-height: 100vh;
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .error-container {
      background: white;
      border-radius: 10px;
      box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
      padding: 60px 40px;
      text-align: center;
      width: 100%;
      max-width: 500px;
    }

    .error-code {
      font-size: clamp(72px, 26vw, 120px);
      font-weight: 700;
      color: #667eea;
      margin: 0;
    }

    .error-title {
      font-size: 28px;
      font-weight: 600;
      color: #333;
      margin: 20px 0;
    }

    .error-message {
      font-size: 16px;
      color: #666;
      margin-bottom: 30px;
    }

    .error-icon {
      font-size: 60px;
      color: #667eea;
      margin-bottom: 20px;
    }

    .btn-back {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      color: white;
      border: none;
      padding: 12px 30px;
      border-radius: 5px;
      font-weight: 600;
      cursor: pointer;
      text-decoration: none;
      display: inline-block;
      transition: all 0.3s ease;
    }

    .btn-back:hover {
      transform: translateY(-2px);
      box-shadow: 0 5px 20px rgba(102, 126, 234, 0.4);
      color: white;
    }

    .btn-home {
      background: #f0f0f0;
      color: #667eea;
      border: none;
      padding: 12px 30px;
      border-radius: 5px;
      font-weight: 600;
      cursor: pointer;
      text-decoration: none;
      display: inline-block;
      margin-left: 10px;
      transition: all 0.3s ease;
    }

    .btn-home:hover {
      transform: translateY(-2px);
      box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
    }

    @media (max-width: 480px) {
      .error-container {
        padding: 40px 20px;
      }
    }
  </style>
</head>
<body>
  <div class="error-container">
    <div class="error-icon">
      <i class="bi bi-exclamation-triangle"></i>
    </div>
    <h1 class="error-code">403</h1>
    <h2 class="error-title">Akses Ditolak</h2>
    <p class="error-message">
      Anda tidak memiliki izin untuk mengakses halaman ini. 
      Pastikan Anda login dengan akun yang sesuai.
    </p>
    <div>
      <a href="{{ route('welcome') }}" class="btn-back">Kembali ke Beranda</a>
      <a href="/" class="btn-home">Halaman Utama</a>
    </div>
  </div>

  <script src="{{ asset('mentahan1/assets/js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>
