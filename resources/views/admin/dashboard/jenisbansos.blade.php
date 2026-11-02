@extends('layouts.admin')

@section('content')
<div class="page-heading">
  <div class="page-heading-copy">
    <span class="page-icon"><i class="bi bi-box2-heart" aria-hidden="true"></i></span>
    <div>
      <p class="eyebrow mb-1">Master Data</p>
      <h1 class="h3 mb-1">Jenis Bansos</h1>
      <p class="text-muted mb-0">Kelola daftar jenis bantuan sosial yang bisa diajukan oleh Masyarakat.</p>
    </div>
  </div>
  <div class="heading-actions">
    <button class="btn btn-primary btn-sm" type="button" data-bs-toggle="modal" data-bs-target="#modalTambah"><i class="bi bi-plus-lg" aria-hidden="true"></i> Tambah Jenis Bansos</button>
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
      <h2 class="h5 mb-1 section-title"><i class="bi bi-list-ul" aria-hidden="true"></i><span>Daftar Kategori Bansos</span></h2>
    </div>
  </div>
  <div class="table-responsive">
    <table class="table align-middle mb-0">
      <thead>
        <tr>
          <th scope="col">No</th>
          <th scope="col">Nama Bansos</th>
          <th scope="col">Keterangan</th>
          <th scope="col">Tanggal Dibuat</th>
          <th scope="col" class="text-end">Aksi</th>
        </tr>
      </thead>
      <tbody>
        @forelse($jenisBansos as $index => $jb)
        <tr>
          <td>{{ $index + 1 }}</td>
          <td><p class="fw-semibold mb-0">{{ $jb->nama_bansos }}</p></td>
          <td>{{ $jb->keterangan ?? '-' }}</td>
          <td>{{ $jb->created_at->format('d M Y') }}</td>
          <td class="text-end">
            <button class="btn btn-light btn-sm" data-bs-toggle="modal" data-bs-target="#modalEdit{{ $jb->id }}"><i class="bi bi-pencil"></i> Edit</button>
            <form action="{{ route('admin.jenis_bansos.destroy', $jb->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus jenis bansos ini?');">
              @csrf
              @method('DELETE')
              <button type="submit" class="btn btn-danger btn-sm"><i class="bi bi-trash"></i> Hapus</button>
            </form>
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="5" class="text-center py-4 text-muted">Belum ada data jenis bansos.</td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</section>

<!-- Modals rendered outside of table to prevent HTML rendering conflicts -->
@foreach($jenisBansos as $jb)
<div class="modal fade" id="modalEdit{{ $jb->id }}" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="{{ route('admin.jenis_bansos.update', $jb->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="modal-header">
          <h5 class="modal-title">Edit Jenis Bansos</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body text-start">
          <div class="mb-3">
            <label class="form-label">Nama Bansos <span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="nama_bansos" value="{{ $jb->nama_bansos }}" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Keterangan</label>
            <textarea class="form-control" name="keterangan" rows="3">{{ $jb->keterangan }}</textarea>
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

<!-- Modal Tambah -->
<div class="modal fade" id="modalTambah" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="{{ route('admin.jenis_bansos.store') }}" method="POST">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title">Tambah Jenis Bansos</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body text-start">
          <div class="mb-3">
            <label class="form-label">Nama Bansos <span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="nama_bansos" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Keterangan</label>
            <textarea class="form-control" name="keterangan" rows="3"></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
