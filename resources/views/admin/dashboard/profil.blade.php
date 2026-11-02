@extends('layouts.admin')

@section('content')
<div class="page-heading">
  <div class="page-heading-copy">
    <span class="page-icon"><i class="bi bi-person-circle" aria-hidden="true"></i></span>
    <div>
      <p class="eyebrow mb-1">Pengaturan</p>
      <h1 class="h3 mb-1">Profil Anda</h1>
      <p class="text-muted mb-0">Kelola informasi profil dan kredensial akun Admin Anda.</p>
    </div>
  </div>
</div>

<div class="row mt-3">
  <div class="col-12 col-xl-4">
    <div class="panel text-center p-4">
      <img class="avatar-img avatar-xl rounded-circle mb-3" style="width: 120px; height: 120px; object-fit: cover;" src="{{ asset('mentahan1/assets/images/avatar/avatar.jpg') }}" alt="{{ $user->name }}">
      <h4 class="mb-1">{{ $user->name }}</h4>
      <p class="text-muted mb-3">Administrator</p>
      <span class="badge text-bg-primary mb-3">Super Akses</span>
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
      <form action="{{ route('admin.profil.update') }}" method="POST">
        @csrf
        @method('PUT')
        <div class="row g-3">
          <div class="col-md-6">
            <label class="form-label">Nama Lengkap</label>
            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}" required>
            @error('name') <small class="text-danger">{{ $message }}</small> @enderror
          </div>
          <div class="col-md-6">
            <label class="form-label">Username</label>
            <input type="text" name="username" class="form-control @error('username') is-invalid @enderror" value="{{ old('username', $user->username) }}" required>
            @error('username') <small class="text-danger">{{ $message }}</small> @enderror
          </div>
          <div class="col-md-6">
            <label class="form-label">Password Baru</label>
            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Kosongkan jika tidak diubah" minlength="8" autocomplete="new-password">
            @error('password') <small class="text-danger">{{ $message }}</small> @enderror
          </div>
          <div class="col-md-6">
            <label class="form-label">Konfirmasi Password Baru</label>
            <input type="password" name="password_confirmation" class="form-control" placeholder="Ulangi password baru" minlength="8" autocomplete="new-password">
          </div>
          <div class="col-12">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}" required>
            @error('email') <small class="text-danger">{{ $message }}</small> @enderror
          </div>
        </div>
        <div class="mt-4">
          <button type="submit" class="btn btn-primary"><i class="bi bi-check2-circle me-1" aria-hidden="true"></i>Simpan Perubahan</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
