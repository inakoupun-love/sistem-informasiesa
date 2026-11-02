@extends('layouts.masyarakat')

@section('content')
<div class="page-heading">
  <div class="page-heading-copy">
    <span class="page-icon"><i class="bi bi-file-earmark-plus" aria-hidden="true"></i></span>
    <div>
      <p class="eyebrow mb-1">Formulir</p>
      <h1 class="h3 mb-1">Buat Pengajuan Surat</h1>
      <p class="text-muted mb-0">Isi formulir di bawah ini untuk mengajukan surat ke pihak desa.</p>
    </div>
  </div>
</div>

<section class="panel mt-3">
  <div class="panel-header">
    <div>
      <h2 class="h5 mb-1 section-title"><i class="bi bi-pencil-square" aria-hidden="true"></i><span>Data Pengajuan</span></h2>
    </div>
  </div>
  <div class="panel-body p-4">
    <form action="{{ route('masyarakat.store_pengajuan') }}" method="POST" enctype="multipart/form-data">
      @csrf
      
      <div class="mb-4">
        <label for="jenis_surat_id" class="form-label fw-semibold">Pilih Jenis Surat <span class="text-danger">*</span></label>
        <select class="form-select @error('jenis_surat_id') is-invalid @enderror" id="jenis_surat_id" name="jenis_surat_id" required>
          <option value="">-- Pilih Surat --</option>
          @foreach($jenisSurats as $js)
            <option value="{{ $js->id }}">{{ $js->nama_surat }}</option>
          @endforeach
        </select>
        @error('jenis_surat_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>

      <div class="mb-4">
        <label for="keperluan" class="form-label fw-semibold">Keperluan <span class="text-danger">*</span></label>
        <textarea class="form-control @error('keperluan') is-invalid @enderror" id="keperluan" name="keperluan" rows="4" placeholder="Jelaskan secara singkat untuk keperluan apa surat ini dibuat..." required>{{ old('keperluan') }}</textarea>
        @error('keperluan')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>

      <div class="mb-4">
        <label for="dokumen_pendukung" class="form-label fw-semibold">Dokumen Pendukung <span class="text-muted fw-normal">(Opsional)</span></label>
        <input type="file" class="form-control @error('dokumen_pendukung') is-invalid @enderror" id="dokumen_pendukung" name="dokumen_pendukung" accept=".jpg,.jpeg,.png,.pdf">
        <div class="form-text">Unggah lampiran pendukung seperti FC KTP, KK, atau dokumen lainnya (format JPG, PNG, atau PDF, maksimal 5 MB).</div>
        @error('dokumen_pendukung')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>

      <div class="d-flex flex-wrap justify-content-end gap-2">
        <a href="{{ route('masyarakat.dashboard') }}" class="btn btn-light">Batal</a>
        <button type="submit" class="btn btn-primary"><i class="bi bi-send" aria-hidden="true"></i> Kirim Pengajuan</button>
      </div>
    </form>
  </div>
</section>
@endsection
