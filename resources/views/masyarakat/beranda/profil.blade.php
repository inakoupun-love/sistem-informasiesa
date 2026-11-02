@extends('layouts.masyarakat')

@section('content')
<div class="page-heading">
  <div class="page-heading-copy">
    <span class="page-icon"><i class="bi bi-person-circle" aria-hidden="true"></i></span>
    <div>
      <p class="eyebrow mb-1">Pengaturan Akun</p>
      <h1 class="h3 mb-1">Profil Saya</h1>
      <p class="text-muted mb-0">Lihat dan perbarui informasi profil Anda.</p>
    </div>
  </div>
</div>

<div class="row mt-4">
  <div class="col-12 col-md-4">
    <div class="card border-0 shadow-sm" style="border-radius: 12px;">
      <div class="card-body text-center p-4">
        <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=random" alt="Profile" class="rounded-circle mb-3" style="width: 120px; height: 120px; object-fit: cover; border: 4px solid #f8f9fa;">
        <h4 class="fw-bold mb-1 text-break">{{ $user->name }}</h4>
        <p class="text-muted mb-3 text-break">{{ $user->email }}</p>
        <span class="badge bg-primary px-3 py-2" style="border-radius: 20px;">Role: Masyarakat</span>
      </div>
    </div>
  </div>
  
  <div class="col-12 col-md-8">
    <div class="card border-0 shadow-sm" style="border-radius: 12px;">
      <div class="card-header bg-white border-bottom-0 pt-4 pb-0 px-4">
        <h5 class="fw-bold mb-0">Informasi Pribadi</h5>
      </div>
      <div class="card-body p-4">
        @if(session('success'))
          <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        @endif

        <form action="{{ route('masyarakat.profil.update') }}" method="POST">
          @csrf
          @method('PUT')
          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label text-muted small fw-semibold text-uppercase">Nama Lengkap</label>
              <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
              @error('name') <small class="text-danger">{{ $message }}</small> @enderror
            </div>
            <div class="col-md-6">
              <label class="form-label text-muted small fw-semibold text-uppercase">Username</label>
              <input type="text" name="username" class="form-control" value="{{ old('username', $user->username) }}" required>
              @error('username') <small class="text-danger">{{ $message }}</small> @enderror
            </div>
            <div class="col-md-6">
              <label class="form-label text-muted small fw-semibold text-uppercase">Alamat Email</label>
              <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
              @error('email') <small class="text-danger">{{ $message }}</small> @enderror
            </div>
            <div class="col-md-6">
              <label class="form-label text-muted small fw-semibold text-uppercase">Nomor Telepon</label>
              <input type="tel" name="phone" class="form-control" value="{{ old('phone', $user->phone) }}" maxlength="20" required inputmode="tel">
              @error('phone') <small class="text-danger">{{ $message }}</small> @enderror
            </div>
            <div class="col-md-6">
              <label class="form-label text-muted small fw-semibold text-uppercase">NIK</label>
              <input type="text" name="nik" class="form-control" value="{{ old('nik', $user->nik) }}">
              @error('nik') <small class="text-danger">{{ $message }}</small> @enderror
            </div>
            <div class="col-md-6">
              <label class="form-label text-muted small fw-semibold text-uppercase">Jenis Kelamin</label>
              <select name="jenis_kelamin" class="form-select" required>
                <option value="">Pilih jenis kelamin</option>
                <option value="Laki-laki" @selected(old('jenis_kelamin', $user->jenis_kelamin) === 'Laki-laki')>Laki-laki</option>
                <option value="Perempuan" @selected(old('jenis_kelamin', $user->jenis_kelamin) === 'Perempuan')>Perempuan</option>
              </select>
              @error('jenis_kelamin') <small class="text-danger">{{ $message }}</small> @enderror
            </div>
            <div class="col-md-6">
              <label class="form-label text-muted small fw-semibold text-uppercase">Tempat Lahir</label>
              <input type="text" name="tempat_lahir" class="form-control" value="{{ old('tempat_lahir', $user->tempat_lahir) }}" required maxlength="100">
              @error('tempat_lahir') <small class="text-danger">{{ $message }}</small> @enderror
            </div>
            <div class="col-md-6">
              <label class="form-label text-muted small fw-semibold text-uppercase">Tanggal Lahir</label>
              <input type="date" name="tanggal_lahir" class="form-control" value="{{ old('tanggal_lahir', optional($user->tanggal_lahir)->format('Y-m-d')) }}" required max="{{ now()->format('Y-m-d') }}">
              @error('tanggal_lahir') <small class="text-danger">{{ $message }}</small> @enderror
            </div>
            <div class="col-md-6">
              <label class="form-label text-muted small fw-semibold text-uppercase">Agama</label>
              <select name="agama" class="form-select" required>
                <option value="">Pilih agama</option>
                @foreach(['Islam', 'Kristen Protestan', 'Katolik', 'Hindu', 'Buddha', 'Konghucu'] as $agama)
                  <option value="{{ $agama }}" @selected(old('agama', $user->agama) === $agama)>{{ $agama }}</option>
                @endforeach
              </select>
              @error('agama') <small class="text-danger">{{ $message }}</small> @enderror
            </div>
            <div class="col-md-6">
              <label class="form-label text-muted small fw-semibold text-uppercase">Pendidikan Terakhir</label>
              <input type="text" name="pendidikan" class="form-control" value="{{ old('pendidikan', $user->pendidikan) }}" required maxlength="100">
              @error('pendidikan') <small class="text-danger">{{ $message }}</small> @enderror
            </div>
            <div class="col-md-6">
              <label class="form-label text-muted small fw-semibold text-uppercase">Pekerjaan</label>
              <input type="text" name="pekerjaan" class="form-control" value="{{ old('pekerjaan', $user->pekerjaan) }}" required maxlength="100">
              @error('pekerjaan') <small class="text-danger">{{ $message }}</small> @enderror
            </div>
            <div class="col-12">
              <label class="form-label text-muted small fw-semibold text-uppercase">Alamat</label>
              <textarea name="alamat" class="form-control" rows="3" required maxlength="1000">{{ old('alamat', $user->alamat) }}</textarea>
              @error('alamat') <small class="text-danger">{{ $message }}</small> @enderror
            </div>
            <div class="col-md-6">
              <label class="form-label text-muted small fw-semibold text-uppercase">Tanggal Bergabung</label>
              <p class="fw-medium text-dark mt-2">{{ $user->created_at->format('d M Y') }}</p>
            </div>
            <div class="col-md-6">
              <label class="form-label text-muted small fw-semibold text-uppercase">Status Akun</label>
              <p class="fw-medium text-success mt-2"><i class="bi bi-check-circle-fill me-1"></i> Aktif</p>
            </div>
            <div class="col-12 mt-4 text-end">
              <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
