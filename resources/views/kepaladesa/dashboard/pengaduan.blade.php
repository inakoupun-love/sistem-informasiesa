@extends('layouts.kades')

@section('content')
<div class="page-heading">
  <div class="page-heading-copy">
    <span class="page-icon"><i class="bi bi-megaphone" aria-hidden="true"></i></span>
    <div>
      <p class="eyebrow mb-1">Menu Utama</p>
      <h1 class="h3 mb-1">Pengaduan Masyarakat</h1>
      <p class="text-muted mb-0">Daftar pengaduan dari warga desa yang perlu diterima dan ditindaklanjuti.</p>
    </div>
  </div>
</div>

@if(session('success'))
<div class="alert alert-success mt-3 alert-dismissible fade show" role="alert">
  {{ session('success') }}
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

@if(session('warning'))
<div class="alert alert-warning mt-3 alert-dismissible fade show" role="alert">
  {{ session('warning') }}
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<section class="panel mt-3">
  <div class="panel-header">
    <div>
      <h2 class="h5 mb-1 section-title"><i class="bi bi-inbox" aria-hidden="true"></i><span>Daftar Pengaduan Warga</span></h2>
      <p class="text-muted mb-0">Terima pengaduan untuk meneruskannya ke proses tindak lanjut.</p>
    </div>
  </div>
  <div class="table-responsive">
    <table class="table align-middle mb-0">
      <thead>
        <tr>
          <th scope="col">ID</th>
          <th scope="col">Pelapor</th>
          <th scope="col">Judul Pengaduan</th>
          <th scope="col">Tanggal</th>
          <th scope="col">Status</th>
          <th scope="col" class="text-end">Aksi</th>
        </tr>
      </thead>
      <tbody>
        @forelse($laporans as $laporan)
        <tr>
          <td>#{{ $laporan->id }}</td>
          <td>
            <p class="fw-semibold mb-0">{{ $laporan->user->name ?? 'User Tidak Ditemukan' }}</p>
            <p class="text-muted small mb-0">NIK: {{ $laporan->user->nik ?? '-' }}</p>
          </td>
          <td>{{ $laporan->judul }}</td>
          <td>{{ $laporan->created_at->format('d M Y') }}</td>
          <td>
            @if($laporan->status == 'pending')
              <span class="badge text-bg-warning">Menunggu Diterima</span>
            @elseif($laporan->status == 'diterima')
              <span class="badge text-bg-info">Diterima</span>
            @elseif($laporan->status == 'diproses')
              <span class="badge text-bg-primary">Sedang Diproses</span>
            @else
              <span class="badge text-bg-success">Selesai</span>
            @endif
          </td>
          <td class="text-end">
            <div class="d-inline-flex flex-wrap align-items-center justify-content-end gap-1">
              <button class="btn btn-light btn-sm text-nowrap" data-bs-toggle="modal" data-bs-target="#modalDetail{{ $laporan->id }}"><i class="bi bi-eye me-1"></i>Detail</button>
              @if($laporan->status == 'pending')
              <form action="{{ route('kepala_desa.laporan.terima', $laporan->id) }}" method="POST" class="d-inline-flex m-0">
                @csrf
                @method('PUT')
                <button type="submit" class="btn btn-primary btn-sm text-nowrap"><i class="bi bi-check2-square me-1"></i>Terima</button>
              </form>
              @endif
            </div>
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="6" class="text-center py-4 text-muted">Belum ada pengaduan dari warga.</td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</section>

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
                <td style="width: 120px;" class="text-muted">Judul</td>
                <td>: {{ $laporan->judul }}</td>
              </tr>
              <tr>
                <td class="text-muted">Tanggal</td>
                <td>: {{ $laporan->created_at->format('d M Y H:i') }}</td>
              </tr>
              <tr>
                <td class="text-muted">Status</td>
                <td>:
                  @if($laporan->status == 'pending')
                    <span class="badge text-bg-warning">Menunggu Diterima</span>
                  @elseif($laporan->status == 'diterima')
                    <span class="badge text-bg-info">Diterima</span>
                  @elseif($laporan->status == 'diproses')
                    <span class="badge text-bg-primary">Sedang Diproses</span>
                  @else
                    <span class="badge text-bg-success">Selesai</span>
                  @endif
                </td>
              </tr>
            </table>
          </div>
        </div>

        <div class="mb-3">
          <h6>Isi Pengaduan / Keluhan:</h6>
          <div class="p-3 bg-light rounded" style="white-space: pre-line;">{{ $laporan->isi_laporan }}</div>
        </div>

        @if($laporan->status == 'pending')
        <hr>
        <form action="{{ route('kepala_desa.laporan.terima', $laporan->id) }}" method="POST">
          @csrf
          @method('PUT')
          <div class="text-end">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-primary"><i class="bi bi-check2-square me-1"></i>Terima Pengaduan</button>
          </div>
        </form>
        @else
        <div class="alert alert-info mb-0">Pengaduan ini telah diterima dan diteruskan untuk ditindaklanjuti.</div>
        @endif
      </div>
    </div>
  </div>
</div>
@endforeach
@endsection
