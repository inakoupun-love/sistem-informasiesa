<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Daftar Akun Baru - SIPAKAL Desa Kalinaun</title>
  <link rel="stylesheet" href="{{ asset('mentahan1/assets/css/bootstrap.min.css') }}">
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

    .register-container {
      background: white;
      border-radius: 15px;
      box-shadow: 0 15px 35px rgba(0, 0, 0, 0.4);
      overflow: hidden;
      width: 100%;
      max-width: 500px;
      border: 1px solid rgba(255, 255, 255, 0.1);
    }

    .register-header {
      background: linear-gradient(135deg, #a12c2f 0%, #7b1e21 100%);
      color: white;
      padding: 40px 30px;
      text-align: center;
      position: relative;
    }

    .register-header h1 {
      font-size: 24px;
      font-weight: 700;
      margin: 0 0 10px;
      letter-spacing: 0.5px;
    }

    .register-header p {
      margin: 0;
      font-size: 13px;
      opacity: 0.85;
      font-weight: 300;
    }

    .register-body {
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

    .btn-register {
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

    .btn-register:hover {
      transform: translateY(-2px);
      box-shadow: 0 6px 20px rgba(161, 44, 47, 0.4);
      color: #fff;
    }

    .register-footer {
      background: #f8fafc;
      padding: 24px 30px;
      text-align: center;
      border-top: 1px solid #f1f5f9;
      font-size: 13.5px;
      color: #64748b;
    }

    .register-footer a {
      color: #a12c2f;
      text-decoration: none;
      font-weight: 600;
      transition: color 0.2s ease;
    }

    .register-footer a:hover {
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

    .form-help {
      font-size: 11.5px;
      color: #94a3b8;
      margin-top: 6px;
    }

    @media (max-width: 480px) {
      .register-container {
        max-width: 100%;
      }
      .register-header {
        padding: 30px 20px;
      }
      .register-body {
        padding: 35px 20px;
      }
      .register-footer {
        padding: 20px;
      }
    }
  </style>
</head>
<body>
  <div class="register-container">
    <div class="register-header">
      <h1><i class="bi bi-person-plus-fill me-2"></i> DAFTAR AKUN</h1>
      <p>Pendaftaran Masyarakat Desa Kalinaun</p>
    </div>

    <div class="register-body">
      @if ($errors->any())
        <div class="alert alert-danger" role="alert">
          <strong class="d-block mb-1">Pendaftaran Gagal!</strong>
          @foreach ($errors->all() as $error)
            <div>{{ $error }}</div>
          @endforeach
        </div>
      @endif

      <div class="form-info">
        <strong>Pendaftaran Mandiri</strong>
        Daftar sebagai masyarakat dengan NIK dan Email aktif. Pastikan data yang dimasukkan valid.
      </div>

      <form method="POST" action="{{ route('register.store') }}">
        @csrf

        <div class="form-group">
          <label class="form-label" for="name">Nama Lengkap</label>
          <input
            class="form-control @error('name') is-invalid @enderror"
            type="text"
            id="name"
            name="name"
            placeholder="Masukkan nama lengkap Anda"
            value="{{ old('name') }}"
            required
            maxlength="255"
          >
          @error('name')
            <span class="error-message">{{ $message }}</span>
          @enderror
          <div class="form-help"><i class="bi bi-info-circle"></i> Contoh: Abraham Petra Titihalawa</div>
        </div>

        <div class="form-group">
          <label class="form-label" for="nik">NIK (Nomor Induk Kependudukan)</label>
          <input
            class="form-control @error('nik') is-invalid @enderror"
            type="text"
            id="nik"
            name="nik"
            placeholder="Masukkan 16 digit NIK"
            value="{{ old('nik') }}"
            maxlength="16"
            pattern="[0-9]{16}"
            required
            inputmode="numeric"
          >
          @error('nik')
            <span class="error-message">{{ $message }}</span>
          @enderror
          <div class="form-help"><i class="bi bi-info-circle"></i> NIK terdiri dari 16 angka (contoh: 3201234567890123)</div>
        </div>

        <div class="form-group">
          <label class="form-label" for="email">Email</label>
          <input
            class="form-control @error('email') is-invalid @enderror"
            type="email"
            id="email"
            name="email"
            placeholder="Masukkan email Anda"
            value="{{ old('email') }}"
            required
          >
          @error('email')
            <span class="error-message">{{ $message }}</span>
          @enderror
          <div class="form-help"><i class="bi bi-info-circle"></i> Email akan digunakan untuk notifikasi sistem</div>
        </div>

        <div class="form-group">
          <label class="form-label" for="phone">Nomor Telepon</label>
          <input
            class="form-control @error('phone') is-invalid @enderror"
            type="tel"
            id="phone"
            name="phone"
            placeholder="Contoh: 081234567890"
            value="{{ old('phone') }}"
            maxlength="20"
            required
            inputmode="tel"
          >
          @error('phone')
            <span class="error-message">{{ $message }}</span>
          @enderror
          <div class="form-help"><i class="bi bi-info-circle"></i> Nomor telepon yang aktif</div>
        </div>

        <div class="form-group">
          <label class="form-label" for="jenis_kelamin">Jenis Kelamin</label>
          <select class="form-control @error('jenis_kelamin') is-invalid @enderror" id="jenis_kelamin" name="jenis_kelamin" required>
            <option value="">Pilih jenis kelamin</option>
            <option value="Laki-laki" @selected(old('jenis_kelamin') === 'Laki-laki')>Laki-laki</option>
            <option value="Perempuan" @selected(old('jenis_kelamin') === 'Perempuan')>Perempuan</option>
          </select>
          @error('jenis_kelamin') <span class="error-message">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
          <label class="form-label" for="tempat_lahir">Tempat Lahir</label>
          <input class="form-control @error('tempat_lahir') is-invalid @enderror" type="text" id="tempat_lahir" name="tempat_lahir" placeholder="Masukkan tempat lahir" value="{{ old('tempat_lahir') }}" required maxlength="100">
          @error('tempat_lahir') <span class="error-message">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
          <label class="form-label" for="tanggal_lahir">Tanggal Lahir</label>
          <input class="form-control @error('tanggal_lahir') is-invalid @enderror" type="date" id="tanggal_lahir" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" required max="{{ now()->format('Y-m-d') }}">
          @error('tanggal_lahir') <span class="error-message">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
          <label class="form-label" for="agama">Agama</label>
          <select class="form-control @error('agama') is-invalid @enderror" id="agama" name="agama" required>
            <option value="">Pilih agama</option>
            @foreach(['Islam', 'Kristen Protestan', 'Katolik', 'Hindu', 'Buddha', 'Konghucu'] as $agama)
              <option value="{{ $agama }}" @selected(old('agama') === $agama)>{{ $agama }}</option>
            @endforeach
          </select>
          @error('agama') <span class="error-message">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
          <label class="form-label" for="pendidikan">Pendidikan Terakhir</label>
          <input class="form-control @error('pendidikan') is-invalid @enderror" type="text" id="pendidikan" name="pendidikan" placeholder="Contoh: SMA / Sederajat" value="{{ old('pendidikan') }}" required maxlength="100">
          @error('pendidikan') <span class="error-message">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
          <label class="form-label" for="pekerjaan">Pekerjaan</label>
          <input class="form-control @error('pekerjaan') is-invalid @enderror" type="text" id="pekerjaan" name="pekerjaan" placeholder="Masukkan pekerjaan" value="{{ old('pekerjaan') }}" required maxlength="100">
          @error('pekerjaan') <span class="error-message">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
          <label class="form-label" for="alamat">Alamat</label>
          <textarea class="form-control @error('alamat') is-invalid @enderror" id="alamat" name="alamat" rows="3" placeholder="Masukkan alamat lengkap" required maxlength="1000">{{ old('alamat') }}</textarea>
          @error('alamat') <span class="error-message">{{ $message }}</span> @enderror
        </div>

        <div class="alert alert-warning border-0" role="alert" style="background-color: #fff9f0; color: #b7791f; border-left: 4px solid #f6a425 !important;">
          <i class="bi bi-shield-lock-fill me-1"></i> <strong>Informasi Password:</strong> NIK Anda akan menjadi password awal Anda. Silakan ubah password Anda demi keamanan setelah berhasil masuk.
        </div>

        <button type="submit" class="btn-register">
          <i class="bi bi-check-circle-fill me-1"></i> Daftar Sekarang
        </button>
      </form>
    </div>

    <div class="register-footer">
      Sudah memiliki akun?
      <a href="{{ route('login.masyarakat') }}">Masuk di sini</a>
    </div>
  </div>

  <script src="{{ asset('mentahan1/assets/js/bootstrap.bundle.min.js') }}"></script>
  <script>
    document.getElementById('nik').addEventListener('input', function(e) {
      this.value = this.value.replace(/[^\d]/g, '').slice(0, 16);
    });
  </script>
</body>
</html>
