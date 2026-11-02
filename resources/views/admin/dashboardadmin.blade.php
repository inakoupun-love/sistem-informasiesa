@extends('layouts.admin')

@section('content')
<div class="page-heading">
  <div class="page-heading-copy">
    <span class="page-icon"><i class="bi bi-speedometer2" aria-hidden="true"></i></span>
    <div>
      <p class="eyebrow mb-1">Overview</p>
      <h1 class="h3 mb-1">Dashboard Admin</h1>
      <p class="text-muted mb-0">Monitor aktivitas sistem, pengguna, dan permohonan dari satu ruang kerja.</p>
    </div>
  </div>
</div>

<section class="row g-3 mt-1" aria-label="Dashboard metrics">
  <div class="col-12 col-sm-6 col-xl-3">
    <article class="metric-card metric-primary">
      <div class="metric-top">
        <span class="metric-label">Pengguna Aktif</span>
        <span class="metric-icon"><i class="bi bi-people" aria-hidden="true"></i></span>
      </div>
      <div class="metric-value">{{ number_format($statistics['activeUsers']) }}</div>
      <div class="metric-meta">
        <span class="text-success">Total Akun</span>
      </div>
    </article>
  </div>

  <div class="col-12 col-sm-6 col-xl-3">
    <article class="metric-card metric-success">
      <div class="metric-top">
        <span class="metric-label">Pengajuan Masuk</span>
        <span class="metric-icon"><i class="bi bi-file-earmark-text" aria-hidden="true"></i></span>
      </div>
      <div class="metric-value">{{ number_format($statistics['totalPengajuans']) }}</div>
      <div class="metric-meta">
        <span class="text-success">Dokumen</span>
      </div>
    </article>
  </div>

  <div class="col-12 col-sm-6 col-xl-3">
    <article class="metric-card metric-warning">
      <div class="metric-top">
        <span class="metric-label">Permohonan Bansos</span>
        <span class="metric-icon"><i class="bi bi-box-seam" aria-hidden="true"></i></span>
      </div>
      <div class="metric-value">{{ number_format($statistics['totalBansos']) }}</div>
      <div class="metric-meta">
        <span class="text-success">Bantuan Sosial</span>
      </div>
    </article>
  </div>

  <div class="col-12 col-sm-6 col-xl-3">
    <article class="metric-card metric-danger">
      <div class="metric-top">
        <span class="metric-label">Laporan Masuk</span>
        <span class="metric-icon"><i class="bi bi-file-text" aria-hidden="true"></i></span>
      </div>
      <div class="metric-value">{{ number_format($statistics['pendingLaporans']) }}</div>
      <div class="metric-meta">
        <span class="text-danger">Perlu Ditinjau</span>
      </div>
    </article>
  </div>
</section>

<section class="panel mt-3">
  <div class="panel-header">
    <div>
      <h2 class="h5 mb-1 section-title"><i class="bi bi-activity" aria-hidden="true"></i><span>Aktivitas Sistem Terbaru</span></h2>
      <p class="text-muted mb-0">Belum ada aktivitas terbaru saat ini.</p>
    </div>
  </div>
  <div class="panel-body p-4 text-center text-muted">
    <i class="bi bi-inbox fs-1"></i>
    <p class="mt-2">Data aktivitas masih kosong.</p>
  </div>
</section>
@endsection
