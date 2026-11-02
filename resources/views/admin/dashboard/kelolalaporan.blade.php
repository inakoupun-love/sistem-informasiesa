@extends('layouts.admin')

@section('content')
<div class="page-heading">
  <div class="page-heading-copy">
    <span class="page-icon"><i class="bi bi-file-text" aria-hidden="true"></i></span>
    <div>
      <p class="eyebrow mb-1">Manajemen</p>
      <h1 class="h3 mb-1">Kelola Pengaduan</h1>
      <p class="text-muted mb-0">Daftar laporan dan pengaduan dari warga desa.</p>
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
      <h2 class="h5 mb-1 section-title"><i class="bi bi-exclamation-triangle" aria-hidden="true"></i><span>Daftar Pengaduan Warga</span></h2>
    </div>
  </div>
  <div class="table-responsive">
    <table class="table align-middle mb-0">
      <thead>
        <tr>
          <th scope="col">ID</th>
          <th scope="col">Pelapor</th>
          <th scope="col">Judul Pengaduan</th>
          <th scope="col">Tanggal Lapor</th>
          <th scope="col">Status</th>
          <th scope="col" class="text-end">Aksi</th>
        </tr>
      </thead>
      <tbody>
        @forelse($laporans as $laporan)
        <tr>
          <td>#{{ $laporan->id }}</td>
          <td>
            <div class="d-flex align-items-center gap-2">
              <div>
                <p class="fw-semibold mb-0">{{ $laporan->user->name ?? 'User Tidak Ditemukan' }}</p>
                <p class="text-muted small mb-0">NIK: {{ $laporan->user->nik ?? '-' }}</p>
              </div>
            </div>
          </td>
          <td>{{ $laporan->judul }}</td>
          <td>{{ $laporan->created_at->format('d M Y') }}</td>
          <td>
            @if($laporan->status == 'pending')
              <span class="badge text-bg-warning">Menunggu Diproses</span>
            @elseif($laporan->status == 'diterima')
              <span class="badge text-bg-info">Diterima Kepala Desa</span>
            @elseif($laporan->status == 'diproses')
              <span class="badge text-bg-primary">Sedang Diproses</span>
            @else
              <span class="badge text-bg-success">Selesai</span>
            @endif
          </td>
          <td class="text-end">
            <button class="btn btn-light btn-sm" data-bs-toggle="modal" data-bs-target="#modalDetail{{ $laporan->id }}"><i class="bi bi-eye"></i> Detail</button>
            <form action="{{ route('admin.laporan.destroy', $laporan->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus laporan ini?');">
              @csrf
              @method('DELETE')
              <button type="submit" class="btn btn-danger btn-sm"><i class="bi bi-trash"></i> Hapus</button>
            </form>
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="6" class="text-center py-4 text-muted">Belum ada data laporan dari warga.</td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</section>

<!-- Modals rendered outside of table to prevent HTML rendering conflicts -->
@foreach($laporans as $laporan)
<div class="modal fade" id="modalDetail{{ $laporan->id }}" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Detail Pengaduan #{{ $laporan->id }}</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-start">
        <div class="row mb-3">
          <div class="col-md-6">
            <h6>Informasi Pelapor</h6>
            <table class="table table-sm table-borderless">
              <tr>
                <td style="width: 120px;" class="text-muted">Nama</td>
                <td>: {{ $laporan->user->name ?? '-' }}</td>
              </tr>
              <tr>
                <td class="text-muted">NIK</td>
                <td>: {{ $laporan->user->nik ?? '-' }}</td>
              </tr>
              <tr>
                <td class="text-muted">Email</td>
                <td>: {{ $laporan->user->email ?? '-' }}</td>
              </tr>
            </table>
          </div>
          <div class="col-md-6">
            <h6>Informasi Pengaduan</h6>
            <table class="table table-sm table-borderless">
              <tr>
                <td style="width: 120px;" class="text-muted">Judul Pengaduan</td>
                <td>: {{ $laporan->judul }}</td>
              </tr>
              <tr>
                <td class="text-muted">Tanggal Lapor</td>
                <td>: {{ $laporan->created_at->format('d M Y H:i') }}</td>
              </tr>
            </table>
          </div>
        </div>

        <div class="mb-3">
          <h6>Isi Pengaduan / Keluhan:</h6>
          <div class="p-3 bg-light rounded" style="white-space: pre-line;">
            {{ $laporan->isi_laporan }}
          </div>
        </div>

        <hr>

        <form action="{{ route('admin.laporan.update_status', $laporan->id) }}" method="POST">
          @csrf
          @method('PUT')
          <h6 class="mb-3">Tindakan Admin</h6>
          <div class="mb-3">
            <label class="form-label">Ubah Status Pengaduan <span class="text-danger">*</span></label>
            <select class="form-select" name="status" required>
              <option value="pending" {{ $laporan->status == 'pending' ? 'selected' : '' }}>Menunggu Diproses</option>
              <option value="diterima" {{ $laporan->status == 'diterima' ? 'selected' : '' }}>Diterima Kepala Desa</option>
              <option value="diproses" {{ $laporan->status == 'diproses' ? 'selected' : '' }}>Sedang Diproses</option>
              <option value="selesai" {{ $laporan->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
            </select>
          </div>
          <div class="text-end">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-success">Update Status</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endforeach
@endsection
