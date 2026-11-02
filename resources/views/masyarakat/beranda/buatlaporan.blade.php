@extends('layouts.masyarakat')

@section('content')
<div class="page-heading">
  <div class="page-heading-copy">
    <span class="page-icon"><i class="bi bi-megaphone" aria-hidden="true"></i></span>
    <div>
      <p class="eyebrow mb-1">Aduan Masyarakat</p>
      <h1 class="h3 mb-1">Kirim Pengaduan</h1>
      <p class="text-muted mb-0">Sampaikan pengaduan atau berikan saran kepada pihak desa.</p>
    </div>
  </div>
</div>

<section class="panel mt-3">
  <div class="panel-header">
    <div>
      <h2 class="h5 mb-1 section-title"><i class="bi bi-pencil-square" aria-hidden="true"></i><span>Isi Pengaduan</span></h2>
    </div>
  </div>
  <div class="panel-body p-4">
    <form action="{{ route('masyarakat.store_laporan') }}" method="POST">
      @csrf
      
      <div class="mb-4">
        <label for="judul" class="form-label fw-semibold">Judul Pengaduan <span class="text-danger">*</span></label>
        <input type="text" class="form-control @error('judul') is-invalid @enderror" id="judul" name="judul" value="{{ old('judul') }}" placeholder="Contoh: Lampu jalan mati di RT 01" required>
        @error('judul')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>

      <div class="mb-4">
        <label for="isi_laporan" class="form-label fw-semibold">Detail Pengaduan <span class="text-danger">*</span></label>
        <textarea class="form-control @error('isi_laporan') is-invalid @enderror" id="isi_laporan" name="isi_laporan" rows="5" placeholder="Ceritakan detail masalah yang ingin Anda adukan..." required>{{ old('isi_laporan') }}</textarea>
        @error('isi_laporan')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>

      <div class="d-flex flex-wrap justify-content-end gap-2">
        <a href="{{ route('masyarakat.dashboard') }}" class="btn btn-light">Batal</a>
        <button type="submit" class="btn btn-primary"><i class="bi bi-send" aria-hidden="true"></i> Kirim Pengaduan</button>
      </div>
    </form>
  </div>
</section>
@endsection
