@extends('layouts.admin')

@section('content')
<div class="page-heading">
  <div class="page-heading-copy">
    <span class="page-icon"><i class="bi bi-people" aria-hidden="true"></i></span>
    <div>
      <p class="eyebrow mb-1">Manajemen</p>
      <h1 class="h3 mb-1">Kelola Pengguna</h1>
      <p class="text-muted mb-0">Manajemen daftar pengguna sistem dan wewenang (role) mereka.</p>
    </div>
  </div>
</div>

@if(session('success'))
<div class="alert alert-success mt-3 alert-dismissible fade show" role="alert">
  {{ session('success') }}
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

@if($errors->any())
<div class="alert alert-danger mt-3 alert-dismissible fade show" role="alert">
  <ul class="mb-0">
    @foreach($errors->all() as $error)
      <li>{{ $error }}</li>
    @endforeach
  </ul>
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<section class="panel mt-3">
  <div class="panel-header">
    <div>
      <h2 class="h5 mb-1 section-title"><i class="bi bi-list-ul" aria-hidden="true"></i><span>Daftar Pengguna</span></h2>
    </div>
  </div>
  <div class="table-responsive">
    <table class="table align-middle mb-0">
      <thead>
        <tr>
          <th scope="col">Nama Lengkap</th>
          <th scope="col">Username</th>
          <th scope="col">Role</th>
          <th scope="col">Status Account</th>
          <th scope="col">Tanggal Daftar</th>
          <th scope="col" class="text-end">Aksi</th>
        </tr>
      </thead>
      <tbody>
        @forelse($users as $user)
        <tr>
          <td>
            <div class="d-flex align-items-center gap-2">
              <img class="avatar-img avatar-sm" src="{{ asset('mentahan1/assets/images/avatar/avatar.jpg') }}" alt="Avatar">
              <div>
                <p class="fw-semibold mb-0">{{ $user->name }}</p>
                <p class="text-muted small mb-0">NIK: {{ $user->nik ?? '-' }}</p>
                <p class="text-muted small mb-0">Telp: {{ $user->phone ?? '-' }}</p>
              </div>
            </div>
          </td>
          <td>{{ $user->username ?? '-' }}</td>
          <td>
            @if($user->role == 'admin')
              <span class="badge text-bg-primary">Admin</span>
            @elseif($user->role == 'kepala_desa')
              <span class="badge text-bg-success">Kepala Desa</span>
            @else
              <span class="badge text-bg-secondary">Masyarakat</span>
            @endif
          </td>
          <td>
            @if($user->status == 'active')
              <span class="badge text-bg-success">Aktif</span>
            @elseif($user->status == 'inactive')
              <span class="badge text-bg-secondary">Tidak Aktif</span>
            @else
              <span class="badge text-bg-danger">Ditangguhkan</span>
            @endif
          </td>
          <td>{{ $user->created_at->format('d M Y') }}</td>
          <td class="text-end">
            <button class="btn btn-light btn-sm" data-bs-toggle="modal" data-bs-target="#modalEdit{{ $user->id }}"><i class="bi bi-pencil"></i> Edit</button>
            <form action="{{ route('admin.pengguna.destroy', $user->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengguna ini?');">
              @csrf
              @method('DELETE')
              <button type="submit" class="btn btn-danger btn-sm" {{ Auth::id() == $user->id ? 'disabled' : '' }}><i class="bi bi-trash"></i> Hapus</button>
            </form>
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="6" class="text-center py-4 text-muted">Belum ada data pengguna.</td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</section>

<!-- Modals rendered outside of table to prevent HTML rendering conflicts -->
@foreach($users as $user)
<div class="modal fade" id="modalEdit{{ $user->id }}" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="{{ route('admin.pengguna.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="modal-header">
          <h5 class="modal-title">Edit Pengguna: {{ $user->name }}</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body text-start">
          <div class="mb-3">
            <label class="form-label">Role <span class="text-danger">*</span></label>
            <select class="form-select" name="role" required {{ Auth::id() == $user->id ? 'disabled' : '' }}>
              <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
              <option value="kepala_desa" {{ $user->role == 'kepala_desa' ? 'selected' : '' }}>Kepala Desa</option>
              <option value="masyarakat" {{ $user->role == 'masyarakat' ? 'selected' : '' }}>Masyarakat</option>
            </select>
            @if(Auth::id() == $user->id)
              <input type="hidden" name="role" value="{{ $user->role }}">
              <small class="text-muted">Anda tidak dapat mengubah role akun Anda sendiri.</small>
            @endif
          </div>
          <div class="mb-3">
            <label class="form-label">Status Akun <span class="text-danger">*</span></label>
            <select class="form-select" name="status" required {{ Auth::id() == $user->id ? 'disabled' : '' }}>
              <option value="active" {{ $user->status == 'active' ? 'selected' : '' }}>Aktif</option>
              <option value="inactive" {{ $user->status == 'inactive' ? 'selected' : '' }}>Tidak Aktif</option>
              <option value="suspended" {{ $user->status == 'suspended' ? 'selected' : '' }}>Ditangguhkan</option>
            </select>
            @if(Auth::id() == $user->id)
              <input type="hidden" name="status" value="{{ $user->status }}">
              <small class="text-muted">Anda tidak dapat menonaktifkan akun Anda sendiri.</small>
            @endif
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endforeach
@endsection
