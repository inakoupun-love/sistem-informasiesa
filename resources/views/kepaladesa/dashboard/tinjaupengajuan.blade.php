@extends('layouts.kades')

@section('content')
<div class="page-heading">
  <div class="page-heading-copy">
    <span class="page-icon"><i class="bi bi-file-earmark" aria-hidden="true"></i></span>
    <div>
      <p class="eyebrow mb-1">Menu Utama</p>
      <h1 class="h3 mb-1">Tinjau Pengajuan Surat</h1>
      <p class="text-muted mb-0">Daftar pengajuan dokumen dan surat dari masyarakat.</p>
    </div>
  </div>
</div>

@if(session('success'))
<div class="alert alert-success mt-3 alert-dismissible fade show" role="alert">
  {{ session('success') }}
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<section class="panel mt-3">
  <div class="panel-header">
    <div>
      <h2 class="h5 mb-1 section-title"><i class="bi bi-list-ul" aria-hidden="true"></i><span>Daftar Pengajuan</span></h2>
    </div>
  </div>
  <div class="table-responsive">
    <table class="table align-middle mb-0">
      <thead>
        <tr>
          <th scope="col">ID</th>
          <th scope="col">Nama Pemohon</th>
          <th scope="col">Jenis Surat</th>
          <th scope="col">Tanggal Pengajuan</th>
          <th scope="col">Status</th>
          <th scope="col" class="text-end">Aksi</th>
        </tr>
      </thead>
      <tbody>
        @forelse($pengajuans as $pengajuan)
        <tr>
          <td>#{{ $pengajuan->id }}</td>
          <td>
            <div class="d-flex align-items-center gap-2">
              <div>
                <p class="fw-semibold mb-0">{{ $pengajuan->user->name ?? 'User Tidak Ditemukan' }}</p>
                <p class="text-muted small mb-0">NIK: {{ $pengajuan->user->nik ?? '-' }}</p>
              </div>
            </div>
          </td>
          <td>{{ $pengajuan->jenisSurat->nama_surat ?? 'Tipe Dihapus' }}</td>
          <td>{{ $pengajuan->created_at->format('d M Y') }}</td>
          <td>
            @if($pengajuan->status == 'pending')
              <span class="badge text-bg-warning">Menunggu</span>
            @elseif($pengajuan->status == 'disetujui')
              <span class="badge text-bg-success">Disetujui</span>
            @else
              <span class="badge text-bg-danger">Ditolak</span>
            @endif
          </td>
          <td class="text-end">
            <button class="btn btn-light btn-sm" data-bs-toggle="modal" data-bs-target="#modalDetail{{ $pengajuan->id }}"><i class="bi bi-eye"></i> Detail</button>
            @if($pengajuan->status == 'pending')
              <form action="{{ route('kepala_desa.pengajuan.update_status', $pengajuan->id) }}" method="POST" class="d-inline">
                @csrf
                @method('PUT')
                <input type="hidden" name="status" value="disetujui">
                <button type="submit" class="btn btn-success btn-sm"><i class="bi bi-check-circle"></i> Setujui</button>
              </form>
              <form action="{{ route('kepala_desa.pengajuan.update_status', $pengajuan->id) }}" method="POST" class="d-inline">
                @csrf
                @method('PUT')
                <input type="hidden" name="status" value="ditolak">
                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menolak pengajuan ini?');"><i class="bi bi-x-circle"></i> Tolak</button>
              </form>
            @endif
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="6" class="text-center py-4 text-muted">Belum ada data pengajuan surat.</td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</section>

<!-- Modals rendered outside of table to prevent HTML rendering conflicts -->
@foreach($pengajuans as $pengajuan)
<div class="modal fade" id="modalDetail{{ $pengajuan->id }}" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Detail Pengajuan Surat #{{ $pengajuan->id }}</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-start">
        <div class="row mb-3">
          <div class="col-md-6">
            <h6>Informasi Pemohon</h6>
            <table class="table table-sm table-borderless">
              <tr>
                <td style="width: 120px;" class="text-muted">Nama</td>
                <td>: {{ $pengajuan->user->name ?? '-' }}</td>
              </tr>
              <tr>
                <td class="text-muted">NIK</td>
                <td>: {{ $pengajuan->user->nik ?? '-' }}</td>
              </tr>
              <tr>
                <td class="text-muted">Email</td>
                <td>: {{ $pengajuan->user->email ?? '-' }}</td>
              </tr>
            </table>
          </div>
          <div class="col-md-6">
            <h6>Informasi Surat</h6>
            <table class="table table-sm table-borderless">
              <tr>
                <td style="width: 120px;" class="text-muted">Jenis Surat</td>
                <td>: {{ $pengajuan->jenisSurat->nama_surat ?? '-' }}</td>
              </tr>
              <tr>
                <td class="text-muted">Tanggal</td>
                <td>: {{ $pengajuan->created_at->format('d M Y H:i') }}</td>
              </tr>
              <tr>
                <td class="text-muted">Keperluan</td>
                <td>: {{ $pengajuan->keperluan ?? '-' }}</td>
              </tr>
            </table>
          </div>
        </div>

        @if($pengajuan->status == 'pending')
          <hr>
          <form action="{{ route('kepala_desa.pengajuan.update_status', $pengajuan->id) }}" method="POST">
            @csrf
            @method('PUT')
            <h6 class="mb-3">Tindakan Kepala Desa</h6>
            <div class="mb-3">
              <label class="form-label">Ubah Status Pengajuan <span class="text-danger">*</span></label>
              <select class="form-select" name="status" required>
                <option value="disetujui">Setujui</option>
                <option value="ditolak">Tolak</option>
              </select>
            </div>
            <div class="mb-3">
              <label class="form-label">Keterangan / Catatan Tambahan</label>
              <textarea class="form-control" name="keterangan" rows="3" placeholder="Masukkan catatan tambahan jika diperlukan...">{{ $pengajuan->keterangan }}</textarea>
            </div>
            <div class="text-end">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
              <button type="submit" class="btn btn-primary">Simpan Keputusan</button>
            </div>
          </form>
        @else
          <hr>
          <h6>Status Pengajuan:</h6>
          <div class="p-3 bg-light rounded">
            <strong>{{ ucfirst($pengajuan->status) }}</strong>
            <p class="mb-0 text-muted small mt-1">Catatan: {{ $pengajuan->keterangan ?? '-' }}</p>
          </div>
        @endif
      </div>
    </div>
  </div>
</div>
@endforeach
@endsection
