<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Admin - SIPAKAL Desa Kalinaun</title>
  <link class="stylesheet" href="{{ asset('mentahan1/assets/css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('mentahan1/assets/vendors/bootstrap-icons/bootstrap-icons.css') }}">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <style>
    body {
      display: flex;
      align-items: center;
      justify-content: center;
      min-height: 100vh;
      background: linear-gradient(135deg, #1f272b 0%, #161c1e 100%);
      font-family: 'Poppins', sans-serif;
      padding: 20px;
    }

    .login-container {
      background: white;
      border-radius: 15px;
      box-shadow: 0 15px 35px rgba(0, 0, 0, 0.4);
      overflow: hidden;
      width: 100%;
      max-width: 450px;
      border: 1px solid rgba(255, 255, 255, 0.1);
    }

    .login-header {
      background: linear-gradient(135deg, #a12c2f 0%, #7b1e21 100%);
      color: white;
      padding: 40px 30px;
      text-align: center;
      position: relative;
    }

    .login-header h1 {
      font-size: 24px;
      font-weight: 700;
      margin: 0 0 10px;
      letter-spacing: 0.5px;
    }

    .login-header p {
      margin: 0;
      font-size: 13px;
      opacity: 0.85;
      font-weight: 300;
    }

    .login-body {
      padding: 40px 30px;
    }

    .form-group {
      margin-bottom: 22px;
    }

    .form-label {
      font-weight: 500;
      color: #2c3e50;
      margin-bottom: 8px;
      font-size: 13.5px;
    }

    .form-control {
      border: 1px solid #e2e8f0;
      border-radius: 8px;
      padding: 12px 16px;
      font-size: 14px;
      font-family: 'Poppins', sans-serif;
      transition: all 0.3s ease;
      color: #334155;
    }

    .form-control:focus {
      border-color: #a12c2f;
      box-shadow: 0 0 0 3px rgba(161, 44, 47, 0.15);
    }

    .form-info {
      background: #fffcfc;
      border-left: 4px solid #a12c2f;
      padding: 12px 16px;
      border-radius: 6px;
      margin-bottom: 25px;
      font-size: 13px;
      color: #64748b;
      box-shadow: 0 2px 5px rgba(0,0,0,0.02);
    }

    .form-info strong {
      display: block;
      color: #1e293b;
      margin-bottom: 4px;
      font-weight: 600;
    }

    .btn-login {
      background: linear-gradient(135deg, #a12c2f 0%, #7b1e21 100%);
      color: white;
      border: none;
      padding: 14px;
      border-radius: 8px;
      font-weight: 600;
      cursor: pointer;
      width: 100%;
      transition: all 0.3s ease;
      font-size: 14px;
      letter-spacing: 0.5px;
      box-shadow: 0 4px 15px rgba(161, 44, 47, 0.3);
    }

    .btn-login:hover {
      transform: translateY(-2px);
      box-shadow: 0 6px 20px rgba(161, 44, 47, 0.4);
      color: #fff;
    }

    .login-footer {
      background: #f8fafc;
      padding: 24px 30px;
      text-align: center;
      border-top: 1px solid #f1f5f9;
      font-size: 13.5px;
      color: #64748b;
    }

    .login-footer a {
      color: #a12c2f;
      text-decoration: none;
      font-weight: 600;
      transition: color 0.2s ease;
    }

    .login-footer a:hover {
      color: #7b1e21;
      text-decoration: underline;
    }

    .alert {
      margin-bottom: 22px;
      border-radius: 8px;
      font-size: 13.5px;
    }

    .error-message {
      color: #dc3545;
      font-size: 12px;
      margin-top: 6px;
      display: block;
    }

    .form-check {
      margin-top: 15px;
      margin-bottom: 20px;
    }

    .form-check-input:checked {
      background-color: #a12c2f;
      border-color: #a12c2f;
    }

    .form-check-label {
      margin-left: 5px;
      cursor: pointer;
      font-size: 13.5px;
      color: #475569;
    }

    @media (max-width: 480px) {
      .login-container {
        max-width: 100%;
      }
      .login-header {
        padding: 30px 20px;
      }
      .login-body {
        padding: 35px 20px;
      }
      .login-footer {
        padding: 20px;
      }
    }
  </style>
</head>
<body>
  <div class="login-container">
    <div class="login-header">
      <h1><i class="bi bi-person-gear me-2"></i> LOGIN ADMIN</h1>
      <p>Sistem Pelayanan Administrasi Kalinaun</p>
    </div>

    <div class="login-body">
      @if ($errors->any())
        <div class="alert alert-danger" role="alert">
          <strong class="d-block mb-1">Login Gagal!</strong>
          @foreach ($errors->all() as $error)
            <div>{{ $error }}</div>
          @endforeach
        </div>
      @endif

      <div class="form-info">
        <strong>Akses Panel Admin</strong>
        Masukkan Username dan Password Anda untuk masuk.
      </div>

      <form method="POST" action="{{ route('login.store') }}">
        @csrf
        <input type="hidden" name="role" value="admin">

        <div class="form-group">
          <label class="form-label" for="username">Username</label>
          <input
            class="form-control @error('login_field') is-invalid @enderror"
            type="text"
            id="username"
            name="login_field"
            placeholder="Masukkan username"
            value="{{ old('login_field') }}"
            required
          >
          @error('login_field')
            <span class="error-message">{{ $message }}</span>
          @enderror
        </div>

        <div class="form-group">
          <label class="form-label" for="password">Password</label>
          <input
            class="form-control @error('password') is-invalid @enderror"
            type="password"
            id="password"
            name="password"
            placeholder="Masukkan password"
            required
          >
          @error('password')
            <span class="error-message">{{ $message }}</span>
          @enderror
        </div>

        <div class="form-check">
          <input class="form-check-input" type="checkbox" id="remember" name="remember">
          <label class="form-check-label" for="remember">Ingat saya di perangkat ini</label>
        </div>

        <button type="submit" class="btn-login">
          <i class="bi bi-box-arrow-in-right me-1"></i> Masuk Sekarang
        </button>
      </form>
    </div>

    <div class="login-footer">
      <a href="{{ route('welcome') }}"><i class="bi bi-arrow-left me-1"></i> Kembali ke Halaman Utama</a>
    </div>
  </div>

  <script src="{{ asset('mentahan1/assets/js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>
