@extends('layouts.masyarakat')

@section('content')
<div class="page-heading">
  <div class="page-heading-copy">
    <span class="page-icon"><i class="bi bi-newspaper" aria-hidden="true"></i></span>
    <div>
      <p class="eyebrow mb-1">Berita & Pengumuman</p>
      <h1 class="h3 mb-1">Informasi Desa</h1>
      <p class="text-muted mb-0">Dapatkan informasi dan berita terbaru dari Pemerintah Desa.</p>
    </div>
  </div>
</div>

<div class="row mt-3 g-4">
  @forelse($informasi as $info)
  <div class="col-12 col-md-6 col-lg-4">
    <div class="card h-100 shadow-sm border-0" style="border-radius: 12px; overflow: hidden;">
      <div class="card-body p-4">
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
            <span class="badge bg-primary-subtle text-primary px-2 py-1"><i class="bi bi-tag-fill me-1"></i> Pengumuman</span>
            <small class="text-muted"><i class="bi bi-calendar3 me-1"></i> {{ $info->created_at->format('d M Y') }}</small>
        </div>
        <h5 class="card-title fw-bold mb-3 text-break">{{ $info->judul }}</h5>
        <p class="card-text text-muted" style="font-size: 0.95rem;">
          {{ Str::limit($info->isi_informasi, 120) }}
        </p>
      </div>
      <div class="card-footer bg-white border-top-0 p-4 pt-0 text-end">
        <button type="button" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#infoModal{{ $info->id }}">
          Baca Selengkapnya <i class="bi bi-arrow-right ms-1"></i>
        </button>
      </div>
    </div>
  </div>

  <!-- Modal Detail -->
  <div class="modal fade" id="infoModal{{ $info->id }}" tabindex="-1" aria-labelledby="infoModalLabel{{ $info->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content" style="border-radius: 12px;">
        <div class="modal-header border-bottom-0 pt-4 px-4">
          <h1 class="modal-title fs-4 fw-bold" id="infoModalLabel{{ $info->id }}">{{ $info->judul }}</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body px-4 pb-4">
          <p class="text-muted mb-4 small">
            <i class="bi bi-calendar3 me-1"></i> Dipublikasikan pada {{ $info->created_at->format('d F Y, H:i') }}
            <span class="mx-2">|</span>
            <i class="bi bi-person me-1"></i> Oleh: {{ $info->user->name ?? 'Admin' }}
          </p>
          <div class="text-break" style="line-height: 1.8; color: #4a5568; overflow-wrap: break-word;">
            {!! nl2br(e($info->isi_informasi)) !!}
          </div>
        </div>
        <div class="modal-footer border-top-0 px-4 pb-4">
          <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
        </div>
      </div>
    </div>
  </div>
  @empty
  <div class="col-12 text-center py-5">
    <div class="mb-3"><i class="bi bi-inbox fs-1 text-muted"></i></div>
    <h5 class="text-muted">Belum ada informasi yang dipublikasikan.</h5>
  </div>
  @endforelse
</div>
@endsection
