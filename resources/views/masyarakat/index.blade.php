@extends('layouts.masyarakat')

@section('content')
<div class="page-heading">
  <div class="page-heading-copy">
    <span class="page-icon"><i class="bi bi-speedometer2" aria-hidden="true"></i></span>
    <div>
      <p class="eyebrow mb-1">Selamat Datang, {{ Auth::user()->name }}</p>
      <h1 class="h3 mb-1">Dashboard Masyarakat</h1>
      <p class="text-muted mb-0">Kelola pengajuan, pengaduan, dan permohonan bansos Anda di sini.</p>
    </div>
  </div>
  <div class="heading-actions">
    <a class="btn btn-primary btn-sm" href="{{ route('masyarakat.buat_pengajuan') }}">
      <i class="bi bi-plus-circle" aria-hidden="true"></i> Buat Pengajuan
    </a>
  </div>
</div>

<section class="row g-3 mt-1" aria-label="Dashboard metrics">
  <div class="col-12 col-sm-6 col-xl-4">
    <article class="metric-card metric-primary">
      <div class="metric-top">
        <span class="metric-label">Total Pengajuan</span>
        <span class="metric-icon"><i class="bi bi-file-earmark" aria-hidden="true"></i></span>
      </div>
      <div class="metric-value">{{ \App\Models\Pengajuan::where('user_id', Auth::id())->count() }}</div>
      <div class="metric-meta">
        <span class="text-info">Surat</span>
        <span>diajukan</span>
      </div>
    </article>
  </div>

  <div class="col-12 col-sm-6 col-xl-4">
    <article class="metric-card metric-warning">
      <div class="metric-top">
        <span class="metric-label">Bansos Menunggu</span>
        <span class="metric-icon"><i class="bi bi-hand-thumbs-up" aria-hidden="true"></i></span>
      </div>
      <div class="metric-value">{{ \App\Models\Bansos::where('user_id', Auth::id())->where('status', 'pending')->count() }}</div>
      <div class="metric-meta">
        <span class="text-warning">Permohonan</span>
        <span>pending</span>
      </div>
    </article>
  </div>

  <div class="col-12 col-sm-6 col-xl-4">
    <article class="metric-card metric-danger">
      <div class="metric-top">
        <span class="metric-label">Pengaduan Dibuat</span>
        <span class="metric-icon"><i class="bi bi-megaphone" aria-hidden="true"></i></span>
      </div>
      <div class="metric-value">{{ \App\Models\Laporan::where('user_id', Auth::id())->count() }}</div>
      <div class="metric-meta">
        <span class="text-danger">Aduan</span>
        <span>dikirim</span>
      </div>
    </article>
  </div>


</section>

<section class="row g-3 mt-1">
  <div class="col-12 col-xl-12">
    <div class="panel">
      <div class="panel-header">
        <div>
          <h2 class="h5 mb-1 section-title"><i class="bi bi-file-earmark-text" aria-hidden="true"></i><span>Pengajuan Terbaru</span></h2>
          <p class="text-muted mb-0">Riwayat pengajuan Anda yang paling baru.</p>
        </div>
        <a class="btn btn-light btn-sm" href="{{ route('masyarakat.riwayat') }}">Lihat Semua</a>
      </div>

      <div class="table-responsive">
        <table class="table align-middle mb-0">
          <thead>
            <tr>
              <th scope="col">No</th>
              <th scope="col">Tipe</th>
              <th scope="col">Tanggal</th>
              <th scope="col">Status</th>
            </tr>
          </thead>
          <tbody>
            @forelse(\App\Models\Pengajuan::with('jenisSurat')->where('user_id', Auth::id())->orderBy('created_at', 'desc')->take(5)->get() as $index => $p)
            <tr>
              <td>{{ $index + 1 }}</td>
              <td>{{ $p->jenisSurat->nama_surat ?? 'Tipe Dihapus' }}</td>
              <td>{{ $p->created_at->format('d M Y') }}</td>
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
              <td colspan="4" class="text-center py-3 text-muted">Belum ada pengajuan.</td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>


</section>

<section class="row g-3 mt-1">
  <div class="col-12 col-xl-12">
    @php
      $myBansos = \App\Models\Bansos::with('jenisBansos')->where('user_id', Auth::id())->where('status', 'disetujui')->get();
    @endphp
    <div class="panel">
      <div class="panel-header">
        <div>
          <h2 class="h5 mb-1 section-title"><i class="bi bi-box2-heart" aria-hidden="true"></i><span>Status Penerima Bantuan Sosial</span></h2>
          <p class="text-muted mb-0">Periksa status Anda sebagai penerima bantuan sosial.</p>
        </div>
        <a class="btn btn-light btn-sm" href="{{ route('cekbansos') }}"><i class="bi bi-search" aria-hidden="true"></i> Cek Bansos</a>
      </div>

      <div class="panel-body p-4">
        @if($myBansos->isEmpty())
          <div class="d-flex flex-wrap align-items-center gap-3 p-3 rounded-3 border border-danger-subtle bg-danger-subtle bg-opacity-25">
            <div class="metric-icon bg-danger bg-opacity-10 rounded-circle p-3"><i class="bi bi-x-circle text-danger fs-4" aria-hidden="true"></i></div>
            <div class="flex-grow-1">
              <strong class="text-danger">Anda belum terdaftar sebagai penerima bantuan sosial.</strong>
              <p class="text-muted mb-0 small">Jika Anda membutuhkan bantuan, silakan ajukan permohonan bansos melalui menu Permintaan Bansos.</p>
            </div>
            <a href="{{ route('masyarakat.buat_bansos') }}" class="btn btn-danger btn-sm ms-auto text-nowrap"><i class="bi bi-box2-heart" aria-hidden="true"></i> Ajukan Bansos</a>
          </div>
        @else
          <div class="d-flex align-items-center gap-3 p-3 rounded-3 border border-success-subtle bg-success-subtle bg-opacity-25">
            <div class="metric-icon bg-success bg-opacity-10 rounded-circle p-3"><i class="bi bi-check-circle text-success fs-4" aria-hidden="true"></i></div>
            <div>
              <strong class="text-success">Selamat, Anda terdaftar sebagai penerima bantuan sosial.</strong>
              <p class="text-muted mb-1 small">Program bansos yang Anda terima:</p>
              <ul class="mb-0 small">
                @foreach($myBansos as $b)
                <li>{{ $b->jenisBansos->nama_bansos ?? 'Program Dihapus' }}</li>
                @endforeach
              </ul>
            </div>
          </div>
        @endif
      </div>
    </div>
  </div>
</section>
@endsection
