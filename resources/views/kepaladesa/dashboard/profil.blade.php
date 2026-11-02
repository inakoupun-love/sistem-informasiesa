@extends('layouts.kades')

@section('content')
<div class="page-heading">
  <div class="page-heading-copy">
    <span class="page-icon"><i class="bi bi-person-circle" aria-hidden="true"></i></span>
    <div>
      <p class="eyebrow mb-1">Pengaturan</p>
      <h1 class="h3 mb-1">Profil Anda</h1>
      <p class="text-muted mb-0">Kelola informasi profil dan kredensial akun Anda.</p>
    </div>
  </div>
</div>

<div class="row mt-3">
  <div class="col-12 col-xl-4">
    <div class="panel text-center p-4">
      <img class="avatar-img avatar-xl rounded-circle mb-3" style="width: 120px; height: 120px; object-fit: cover;" src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=random" alt="{{ $user->name }}">
      <h4 class="mb-1">{{ $user->name }}</h4>
      <p class="text-muted mb-3">Kepala Desa</p>
      <span class="badge text-bg-success mb-3">Akun Aktif</span>
      <hr>
      <div class="d-flex flex-wrap justify-content-between text-muted small mt-3 gap-2">
        <span>Bergabung sejak:</span>
        <span class="fw-semibold">{{ $user->created_at->format('d M Y') }}</span>
      </div>
    </div>
  </div>
  
  <div class="col-12 col-xl-8">
    <div class="panel p-4">
      <h4 class="mb-4">Informasi Personal</h4>
      @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          {{ session('success') }}
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      @endif
      <form action="{{ route('kepala_desa.profil.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row g-3">
          <div class="col-md-6">
            <label class="form-label">Nama Lengkap</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
            @error('name') <small class="text-danger">{{ $message }}</small> @enderror
          </div>
          <div class="col-md-6">
            <label class="form-label">Username</label>
            <input type="text" name="username" class="form-control" value="{{ old('username', $user->username) }}" required>
            @error('username') <small class="text-danger">{{ $message }}</small> @enderror
          </div>
          <div class="col-md-6">
            <label class="form-label">NIP</label>
            <input type="text" name="nik" class="form-control" value="{{ old('nik', $user->nik) }}">
            @error('nik') <small class="text-danger">{{ $message }}</small> @enderror
          </div>
          <div class="col-md-6">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
            @error('email') <small class="text-danger">{{ $message }}</small> @enderror
          </div>
          <div class="col-12">
            <label for="signature" class="form-label">Tanda Tangan Elektronik</label>
            <div class="border rounded p-3 bg-light-subtle">
              @if($user->signature_path)
                <div class="mb-3">
                  <p class="small text-muted mb-2">Tanda tangan saat ini:</p>
                  <img src="{{ asset('storage/' . $user->signature_path) }}" alt="Tanda tangan {{ $user->name }}" style="max-width: 280px; max-height: 100px; object-fit: contain;">
                </div>
              @endif
              <input type="file" id="signature" name="signature" class="form-control @error('signature') is-invalid @enderror" accept="image/png,image/jpeg,image/webp">
              <div class="form-text">Unggah gambar tanda tangan dengan format PNG, JPG, atau WEBP, maksimal 2 MB.</div>
              @error('signature') <small class="text-danger d-block">{{ $message }}</small> @enderror
              @if($user->signature_path)
                <div class="form-check mt-2">
                  <input class="form-check-input" type="checkbox" name="remove_signature" value="1" id="remove_signature">
                  <label class="form-check-label" for="remove_signature">Hapus tanda tangan tersimpan</label>
                </div>
              @endif
            </div>
          </div>
        </div>
        <div class="mt-4 text-end">
          <button type="submit" class="btn btn-primary">Update Profil</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
