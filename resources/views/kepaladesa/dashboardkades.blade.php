@extends('layouts.kades')

@section('content')
<div class="page-heading">
  <div class="page-heading-copy">
    <span class="page-icon"><i class="bi bi-speedometer2" aria-hidden="true"></i></span>
    <div>
      <p class="eyebrow mb-1">Overview</p>
      <h1 class="h3 mb-1">Dashboard Kepala Desa</h1>
      <p class="text-muted mb-0">Monitor pengajuan surat, bansos, dan data warga dari satu tempat.</p>
    </div>
  </div>
</div>

<section class="row g-3 mt-1" aria-label="Dashboard metrics">
  <div class="col-12 col-sm-6 col-xl-4">
    <article class="metric-card metric-primary">
      <div class="metric-top">
        <span class="metric-label">Total Pengajuan</span>
        <span class="metric-icon"><i class="bi bi-file-earmark-text" aria-hidden="true"></i></span>
      </div>
      <div class="metric-value">0</div>
      <div class="metric-meta">
        <span class="text-muted">Menunggu Review</span>
      </div>
    </article>
  </div>

  <div class="col-12 col-sm-6 col-xl-4">
    <article class="metric-card metric-success">
      <div class="metric-top">
        <span class="metric-label">Total Bansos</span>
        <span class="metric-icon"><i class="bi bi-box-seam" aria-hidden="true"></i></span>
      </div>
      <div class="metric-value">0</div>
      <div class="metric-meta">
        <span class="text-muted">Menunggu Review</span>
      </div>
    </article>
  </div>

  <div class="col-12 col-sm-6 col-xl-4">
    <article class="metric-card metric-warning">
      <div class="metric-top">
        <span class="metric-label">Warga Terdaftar</span>
        <span class="metric-icon"><i class="bi bi-people" aria-hidden="true"></i></span>
      </div>
      <div class="metric-value">0</div>
      <div class="metric-meta">
        <span class="text-muted">Total warga di sistem</span>
      </div>
    </article>
  </div>
</section>

<section class="panel mt-3">
  <div class="panel-header">
    <div>
      <h2 class="h5 mb-1 section-title"><i class="bi bi-activity" aria-hidden="true"></i><span>Aktivitas Terbaru</span></h2>
      <p class="text-muted mb-0">Belum ada aktivitas terbaru saat ini.</p>
    </div>
  </div>
  <div class="panel-body p-4 text-center text-muted">
    <i class="bi bi-inbox fs-1"></i>
    <p class="mt-2">Data masih kosong.</p>
  </div>
</section>
@endsection
