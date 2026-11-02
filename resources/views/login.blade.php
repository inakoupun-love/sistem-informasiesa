<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login - SIPAKAL Desa Kalinaun</title>
  <link rel="stylesheet" href="{{ asset('mentahan1/assets/css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('mentahan1/assets/vendors/bootstrap-icons/bootstrap-icons.css') }}">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <style>
    body {
      min-height: 100vh;
      background: linear-gradient(135deg, #1f272b 0%, #161c1e 100%);
      font-family: 'Poppins', sans-serif;
      padding: 30px 16px;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .login-card {
      width: 100%;
      max-width: 440px;
      background: white;
      border-radius: 18px;
      box-shadow: 0 20px 45px rgba(0, 0, 0, 0.45);
      overflow: hidden;
      border: 1px solid rgba(255, 255, 255, 0.1);
    }

    /* ===== Header: logo + nama desa ===== */
    .login-header {
      background: linear-gradient(135deg, #a12c2f 0%, #7b1e21 100%);
      color: white;
      padding: 28px 24px 24px;
      text-align: center;
    }

    .login-logo {
      width: 86px;
      height: 86px;
      object-fit: contain;
      background: rgba(255, 255, 255, 0.95);
      border-radius: 50%;
      padding: 6px;
      margin-bottom: 14px;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.25);
    }

    .login-header h1 {
      font-size: 21px;
      font-weight: 700;
      margin: 0 0 4px;
      letter-spacing: 0.5px;
    }

    .login-header p {
      margin: 0;
      font-size: 12.5px;
      opacity: 0.85;
      font-weight: 300;
    }

    .login-body {
      padding: 26px 28px 28px;
    }

    /* ===== Pilih peran ===== */
    .form-select {
      border: 1px solid #e2e8f0;
      border-radius: 9px;
      padding: 12px 14px 12px 42px;
      font-size: 13.5px;
      font-family: 'Poppins', sans-serif;
      transition: all 0.3s ease;
      color: #334155;
      width: 100%;
      appearance: none;
      background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='%2394a3b8' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E");
      background-repeat: no-repeat;
      background-position: right 14px center;
      cursor: pointer;
    }

    .form-select:focus {
      border-color: #a12c2f;
      box-shadow: 0 0 0 3px rgba(161, 44, 47, 0.15);
    }

    /* ===== Form ===== */
    .form-group {
      margin-bottom: 16px;
    }

    .form-label {
      font-weight: 500;
      color: #2c3e50;
      margin-bottom: 7px;
      font-size: 13px;
      display: block;
    }

    .input-wrap {
      position: relative;
    }

    .input-wrap .input-icon {
      position: absolute;
      left: 14px;
      top: 50%;
      transform: translateY(-50%);
      color: #94a3b8;
      font-size: 15px;
      pointer-events: none;
    }

    .form-control {
      border: 1px solid #e2e8f0;
      border-radius: 9px;
      padding: 12px 14px 12px 42px;
      font-size: 13.5px;
      font-family: 'Poppins', sans-serif;
      transition: all 0.3s ease;
      color: #334155;
      width: 100%;
    }

    .form-control:focus {
      border-color: #a12c2f;
      box-shadow: 0 0 0 3px rgba(161, 44, 47, 0.15);
    }

    .toggle-pass {
      position: absolute;
      right: 12px;
      top: 50%;
      transform: translateY(-50%);
      background: none;
      border: none;
      color: #94a3b8;
      cursor: pointer;
      font-size: 15px;
      padding: 2px 4px;
    }

    .toggle-pass:hover {
      color: #a12c2f;
    }

    .form-hint {
      font-size: 11px;
      color: #94a3b8;
      margin-top: 6px;
    }

    .btn-login {
      background: linear-gradient(135deg, #a12c2f 0%, #7b1e21 100%);
      color: white;
      border: none;
      padding: 13px;
      border-radius: 9px;
      font-weight: 600;
      cursor: pointer;
      width: 100%;
      transition: all 0.3s ease;
      font-size: 14px;
      letter-spacing: 0.5px;
      box-shadow: 0 4px 15px rgba(161, 44, 47, 0.3);
      margin-top: 6px;
    }

    .btn-login:hover {
      transform: translateY(-2px);
      box-shadow: 0 6px 20px rgba(161, 44, 47, 0.4);
      color: #fff;
    }

    .alert {
      margin-bottom: 18px;
      border-radius: 9px;
      font-size: 12.5px;
      padding: 12px 14px;
    }

    .remember-row {
      display: flex;
      align-items: center;
      margin: 2px 0 10px;
    }

    .form-check-input:checked {
      background-color: #a12c2f;
      border-color: #a12c2f;
    }

    .form-check-label {
      margin-left: 6px;
      cursor: pointer;
      font-size: 13px;
      color: #475569;
    }

    .login-footer {
      background: #f8fafc;
      padding: 16px 28px;
      text-align: center;
      border-top: 1px solid #f1f5f9;
      font-size: 13px;
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

    .login-back {
      text-align: center;
      margin-top: 22px;
    }

    .login-back a {
      color: #cbd5e1;
      text-decoration: none;
      font-size: 13px;
      font-weight: 500;
      transition: color 0.2s ease;
    }

    .login-back a:hover {
      color: #fff;
    }

    @media (max-width: 480px) {
      .login-body,
      .login-footer {
        padding-left: 18px;
        padding-right: 18px;
      }
      .role-btn span {
        font-size: 10.5px;
      }
    }
  </style>
</head>
<body>
  <div class="login-card">
    <div class="login-header">
      <img src="{{ asset('mentahan2/assets/images/logodesa.png') }}" alt="Logo Desa Kalinaun" class="login-logo">
      <h1>DESA KALINAUN</h1>
      <p>SIPAKAL - Sistem Pelayanan Administrasi</p>
    </div>

    <div class="login-body">
      @if (session('success'))
        <div class="alert alert-success" role="alert">
          <strong class="d-block mb-1">Berhasil!</strong>
          {{ session('success') }}
        </div>
      @endif

      @if ($errors->any())
        <div class="alert alert-danger" role="alert">
          <strong class="d-block mb-1">Login Gagal!</strong>
          @foreach ($errors->all() as $error)
            <div>{{ $error }}</div>
          @endforeach
        </div>
      @endif

      <form method="POST" action="{{ route('login.store') }}" id="loginForm">
        @csrf

        {{-- Pilih Peran --}}
        <div class="form-group">
          <label class="form-label" for="roleInput">Pilih Peran</label>
          <div class="input-wrap">
            <i class="bi bi-person-rolodex input-icon"></i>
            <select class="form-select" id="roleInput" name="role" required>
              <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Admin Desa</option>
              <option value="kepala_desa" {{ old('role') === 'kepala_desa' ? 'selected' : '' }}>Kepala Desa</option>
              <option value="masyarakat" {{ old('role', 'masyarakat') === 'masyarakat' ? 'selected' : '' }}>Masyarakat</option>
            </select>
          </div>
        </div>

        {{-- Username --}}
        <div class="form-group">
          <label class="form-label" for="loginField" id="loginLabel">Nama Lengkap</label>
          <div class="input-wrap">
            <i class="bi bi-person input-icon" id="loginIcon"></i>
            <input
              class="form-control"
              type="text"
              id="loginField"
              name="login_field"
              placeholder="Masukkan nama lengkap"
              value="{{ old('login_field') }}"
              required
            >
          </div>
          <div class="form-hint" id="loginHint"><i class="bi bi-info-circle"></i> Contoh: Abraham Petra Titihalawa</div>
        </div>

        {{-- Kata Sandi --}}
        <div class="form-group">
          <label class="form-label" for="password" id="passLabel">Kata Sandi (NIK)</label>
          <div class="input-wrap">
            <i class="bi bi-lock input-icon"></i>
            <input
              class="form-control"
              type="text"
              id="password"
              name="password"
              placeholder="16 digit NIK"
              maxlength="16"
              inputmode="numeric"
              required
            >
            <button type="button" class="toggle-pass" id="togglePass" style="display:none;">
              <i class="bi bi-eye"></i>
            </button>
          </div>
          <div class="form-hint" id="passHint"><i class="bi bi-info-circle"></i> NIK terdiri dari 16 angka</div>
        </div>

        <div class="remember-row">
          <input class="form-check-input" type="checkbox" id="remember" name="remember">
          <label class="form-check-label" for="remember">Ingat saya di perangkat ini</label>
        </div>

        <button type="submit" class="btn-login">
          <i class="bi bi-box-arrow-in-right me-1"></i> Masuk Sekarang
        </button>
      </form>
    </div>

    <div class="login-footer">
      Belum punya akun?
      <a href="{{ route('register') }}">Daftar Akun Baru</a>
    </div>
  </div>

  <script src="{{ asset('mentahan1/assets/js/bootstrap.bundle.min.js') }}"></script>
  <script>
    const roleInput = document.getElementById('roleInput');
    const loginLabel = document.getElementById('loginLabel');
    const loginIcon = document.getElementById('loginIcon');
    const loginField = document.getElementById('loginField');
    const loginHint = document.getElementById('loginHint');
    const passLabel = document.getElementById('passLabel');
    const passInput = document.getElementById('password');
    const passHint = document.getElementById('passHint');
    const togglePass = document.getElementById('togglePass');

    function applyRole(role) {
      if (role === 'masyarakat') {
        loginLabel.textContent = 'Nama Lengkap';
        loginIcon.className = 'bi bi-person input-icon';
        loginField.placeholder = 'Masukkan nama lengkap';
        loginHint.innerHTML = '<i class="bi bi-info-circle"></i> Contoh: Abraham Petra Titihalawa';
        passLabel.textContent = 'Kata Sandi (NIK)';
        passInput.type = 'text';
        passInput.placeholder = '16 digit NIK';
        passInput.setAttribute('maxlength', '16');
        passInput.setAttribute('inputmode', 'numeric');
        passHint.innerHTML = '<i class="bi bi-info-circle"></i> NIK terdiri dari 16 angka';
        togglePass.style.display = 'none';
      } else {
        loginLabel.textContent = 'Username';
        loginIcon.className = 'bi bi-person-badge input-icon';
        loginField.placeholder = 'Masukkan username';
        loginHint.innerHTML = '';
        passLabel.textContent = 'Kata Sandi';
        passInput.type = 'password';
        passInput.placeholder = 'Masukkan kata sandi';
        passInput.removeAttribute('maxlength');
        passInput.removeAttribute('inputmode');
        passHint.innerHTML = '';
        togglePass.style.display = '';
      }
    }

    roleInput.addEventListener('change', () => applyRole(roleInput.value));

    togglePass.addEventListener('click', function () {
      const icon = this.querySelector('i');
      if (passInput.type === 'password') {
        passInput.type = 'text';
        icon.className = 'bi bi-eye-slash';
      } else {
        passInput.type = 'password';
        icon.className = 'bi bi-eye';
      }
    });

    passInput.addEventListener('input', function () {
      if (roleInput.value === 'masyarakat') {
        this.value = this.value.replace(/[^\d]/g, '').slice(0, 16);
      }
    });

    applyRole(roleInput.value || 'masyarakat');
  </script>
</body>
</html>
