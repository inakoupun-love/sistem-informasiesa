@extends('layouts.masyarakat')

@section('content')
<div class="page-heading">
  <div class="page-heading-copy">
    <span class="page-icon"><i class="bi bi-clock-history" aria-hidden="true"></i></span>
    <div>
      <p class="eyebrow mb-1">Aktivitas Anda</p>
      <h1 class="h3 mb-1">Riwayat Saya</h1>
      <p class="text-muted mb-0">Pantau status dari seluruh pengajuan, permohonan bansos, dan laporan Anda.</p>
    </div>
  </div>
</div>

<div class="row g-3 mt-1">
  <div class="col-12 col-md-4">
    <div class="metric-card metric-primary h-100">
      <div class="metric-top">
        <span class="metric-label">Pengajuan Surat</span>
        <span class="metric-icon"><i class="bi bi-file-earmark" aria-hidden="true"></i></span>
      </div>
      <div class="metric-value">{{ $pengajuans->count() }}</div>
      <div class="metric-meta"><span class="text-muted">Total aktivitas</span></div>
    </div>
  </div>
  <div class="col-12 col-md-4">
    <div class="metric-card metric-success h-100">
      <div class="metric-top">
        <span class="metric-label">Permintaan Bansos</span>
        <span class="metric-icon"><i class="bi bi-hand-thumbs-up" aria-hidden="true"></i></span>
      </div>
      <div class="metric-value">{{ $bansos->count() }}</div>
      <div class="metric-meta"><span class="text-muted">Total aktivitas</span></div>
    </div>
  </div>
  <div class="col-12 col-md-4">
    <div class="metric-card metric-warning h-100">
      <div class="metric-top">
        <span class="metric-label">Laporan / Aduan</span>
        <span class="metric-icon"><i class="bi bi-megaphone" aria-hidden="true"></i></span>
      </div>
      <div class="metric-value">{{ $laporans->count() }}</div>
      <div class="metric-meta"><span class="text-muted">Total aktivitas</span></div>
    </div>
  </div>
</div>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
  <i class="bi bi-check-circle me-2"></i> {{ session('success') }}
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<div class="panel mt-4">
  <div class="panel-header border-bottom-0 pb-0">
    <ul class="nav nav-tabs" id="riwayatTabs" role="tablist">
      <li class="nav-item" role="presentation">
        <button class="nav-link {{ $pengajuans->isNotEmpty() || ($bansos->isEmpty() && $laporans->isEmpty()) ? 'active' : '' }}" id="surat-tab" data-bs-toggle="tab" data-bs-target="#surat-tab-pane" type="button" role="tab" aria-controls="surat-tab-pane" aria-selected="{{ $pengajuans->isNotEmpty() || ($bansos->isEmpty() && $laporans->isEmpty()) ? 'true' : 'false' }}"><i class="bi bi-file-earmark me-2"></i>Pengajuan Surat <span class="badge text-bg-primary ms-1">{{ $pengajuans->count() }}</span></button>
      </li>
      <li class="nav-item" role="presentation">
        <button class="nav-link {{ $pengajuans->isEmpty() && $bansos->isNotEmpty() ? 'active' : '' }}" id="bansos-tab" data-bs-toggle="tab" data-bs-target="#bansos-tab-pane" type="button" role="tab" aria-controls="bansos-tab-pane" aria-selected="{{ $pengajuans->isEmpty() && $bansos->isNotEmpty() ? 'true' : 'false' }}"><i class="bi bi-hand-thumbs-up me-2"></i>Permintaan Bansos <span class="badge text-bg-success ms-1">{{ $bansos->count() }}</span></button>
      </li>
      <li class="nav-item" role="presentation">
        <button class="nav-link {{ $pengajuans->isEmpty() && $bansos->isEmpty() && $laporans->isNotEmpty() ? 'active' : '' }}" id="laporan-tab" data-bs-toggle="tab" data-bs-target="#laporan-tab-pane" type="button" role="tab" aria-controls="laporan-tab-pane" aria-selected="{{ $pengajuans->isEmpty() && $bansos->isEmpty() && $laporans->isNotEmpty() ? 'true' : 'false' }}"><i class="bi bi-megaphone me-2"></i>Laporan / Aduan <span class="badge text-bg-warning ms-1">{{ $laporans->count() }}</span></button>
      </li>
    </ul>
  </div>
  
  <div class="panel-body p-0">
    <div class="tab-content" id="riwayatTabsContent">
      <!-- Tab Pengajuan Surat -->
      <div class="tab-pane fade {{ $pengajuans->isNotEmpty() || ($bansos->isEmpty() && $laporans->isEmpty()) ? 'show active' : '' }}" id="surat-tab-pane" role="tabpanel" aria-labelledby="surat-tab" tabindex="0">
        <div class="table-responsive">
          <table class="table align-middle mb-0">
            <thead>
              <tr>
                <th scope="col" class="ps-4">No</th>
                <th scope="col">Tipe Surat</th>
                <th scope="col">Keperluan</th>
                <th scope="col">Tanggal Diajukan</th>
                <th scope="col">Dokumen</th>
                <th scope="col">Status</th>
              </tr>
            </thead>
            <tbody>
              @forelse($pengajuans as $index => $p)
              <tr>
                <td class="ps-4">{{ $index + 1 }}</td>
                <td class="fw-medium">{{ $p->jenisSurat->nama_surat ?? 'Tipe Dihapus' }}</td>
                <td>{{ Str::limit($p->keperluan, 40) }}</td>
                <td>{{ $p->created_at->format('d M Y') }}</td>
                <td>
                  @if($p->dokumen_pendukung)
                    <a href="{{ asset('storage/' . $p->dokumen_pendukung) }}" target="_blank" class="btn btn-outline-primary btn-sm"><i class="bi bi-download"></i> Unduh</a>
                  @else
                    <span class="text-muted">-</span>
                  @endif
                </td>
                <td>
                  @if($p->status == 'pending')
                      <span class="badge text-bg-warning">Menunggu</span>
                  @elseif($p->status == 'disetujui')
                      <span class="badge text-bg-success">Disetujui</span>
                  @else
                      <span class="badge text-bg-danger">Ditolak</span>
                  @endif
                </td>
              </tr>
              @empty
              <tr>
                <td colspan="6" class="text-center py-4 text-muted">Belum ada riwayat pengajuan surat.</td>
              </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>

      <!-- Tab Bansos -->
      <div class="tab-pane fade {{ $pengajuans->isEmpty() && $bansos->isNotEmpty() ? 'show active' : '' }}" id="bansos-tab-pane" role="tabpanel" aria-labelledby="bansos-tab" tabindex="0">
        <div class="table-responsive">
          <table class="table align-middle mb-0">
            <thead>
              <tr>
                <th scope="col" class="ps-4">No</th>
                <th scope="col">Program Bansos</th>
                <th scope="col">Kondisi Ekonomi</th>
                <th scope="col">Tanggal Diajukan</th>
                <th scope="col">Status</th>
              </tr>
            </thead>
            <tbody>
              @forelse($bansos as $index => $b)
              <tr>
                <td class="ps-4">{{ $index + 1 }}</td>
                <td class="fw-medium">{{ $b->jenisBansos->nama_bansos ?? 'Tipe Dihapus' }}</td>
                <td>{{ Str::limit($b->kondisi_ekonomi ?? $b->alasan, 40) }}</td>
                <td>{{ $b->created_at->format('d M Y') }}</td>
                <td>
                  @if($b->status == 'pending')
                      <span class="badge text-bg-warning">Menunggu Verifikasi</span>
                  @elseif($b->status == 'diusulkan')
                      <span class="badge text-bg-info">Diusulkan ke Kepala Desa</span>
                  @elseif($b->status == 'disetujui')
                      <span class="badge text-bg-success">Disetujui</span>
                  @else
                      <span class="badge text-bg-danger">Ditolak</span>
                  @endif
                </td>
              </tr>
              @empty
              <tr>
                <td colspan="5" class="text-center py-4 text-muted">Belum ada riwayat permintaan bansos.</td>
              </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>

      <!-- Tab Laporan -->
      <div class="tab-pane fade {{ $pengajuans->isEmpty() && $bansos->isEmpty() && $laporans->isNotEmpty() ? 'show active' : '' }}" id="laporan-tab-pane" role="tabpanel" aria-labelledby="laporan-tab" tabindex="0">
        <div class="table-responsive">
          <table class="table align-middle mb-0">
            <thead>
              <tr>
                <th scope="col" class="ps-4">No</th>
                <th scope="col">Judul Laporan</th>
                <th scope="col">Isi Laporan</th>
                <th scope="col">Tanggal Dikirim</th>
                <th scope="col">Status</th>
              </tr>
            </thead>
            <tbody>
              @forelse($laporans as $index => $l)
              <tr>
                <td class="ps-4">{{ $index + 1 }}</td>
                <td class="fw-medium">{{ $l->judul }}</td>
                <td>{{ Str::limit($l->isi_laporan, 40) }}</td>
                <td>{{ $l->created_at->format('d M Y') }}</td>
                <td>
                  @if($l->status == 'pending')
                      <span class="badge text-bg-warning">Menunggu</span>
                  @elseif($l->status == 'diterima')
                      <span class="badge text-bg-info">Diterima</span>
                  @elseif($l->status == 'diproses')
                      <span class="badge text-bg-primary">Diproses</span>
                  @else
                      <span class="badge text-bg-success">Selesai</span>
                  @endif
                </td>
              </tr>
              @empty
              <tr>
                <td colspan="5" class="text-center py-4 text-muted">Belum ada riwayat laporan/aduan.</td>
              </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>

    </div>
  </div>
</div>
@endsection
