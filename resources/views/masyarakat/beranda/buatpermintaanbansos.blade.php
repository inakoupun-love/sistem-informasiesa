@extends('layouts.masyarakat')

@section('content')
<div class="page-heading">
  <div class="page-heading-copy">
    <span class="page-icon"><i class="bi bi-hand-thumbs-up" aria-hidden="true"></i></span>
    <div>
      <p class="eyebrow mb-1">Formulir</p>
      <h1 class="h3 mb-1">Permintaan Bantuan Sosial</h1>
      <p class="text-muted mb-0">Isi data pemohon, pilih program, dan unggah dokumen pendukung.</p>
    </div>
  </div>
</div>

<form action="{{ route('masyarakat.store_bansos') }}" method="POST" enctype="multipart/form-data">
  @csrf

  {{-- ===== Data Pemohon ===== --}}
  <section class="panel mt-3">
    <div class="panel-header">
      <div>
        <h2 class="h5 mb-1 section-title"><i class="bi bi-person-vcard" aria-hidden="true"></i><span>Data Pemohon</span></h2>
      </div>
    </div>
    <div class="panel-body p-4">
      <div class="row g-3">
        <div class="col-md-6">
          <label for="nama_lengkap" class="form-label fw-semibold">Nama Lengkap <span class="text-danger">*</span></label>
          <input type="text" class="form-control @error('nama_lengkap') is-invalid @enderror" id="nama_lengkap" name="nama_lengkap" value="{{ old('nama_lengkap', Auth::user()->name) }}" placeholder="Masukkan nama lengkap" required>
          @error('nama_lengkap')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        <div class="col-md-6">
          <label for="nik" class="form-label fw-semibold">NIK <span class="text-danger">*</span></label>
          <input type="text" class="form-control @error('nik') is-invalid @enderror" id="nik" name="nik" value="{{ old('nik', Auth::user()->nik) }}" maxlength="16" inputmode="numeric" placeholder="16 digit NIK" required>
          @error('nik')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        <div class="col-12">
          <label for="alamat" class="form-label fw-semibold">Alamat <span class="text-danger">*</span></label>
          <textarea class="form-control @error('alamat') is-invalid @enderror" id="alamat" name="alamat" rows="2" placeholder="Masukkan alamat lengkap" required>{{ old('alamat', Auth::user()->alamat) }}</textarea>
          @error('alamat')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        <div class="col-md-6">
          <label for="rt_rw" class="form-label fw-semibold">RT/RW <span class="text-danger">*</span></label>
          <input type="text" class="form-control @error('rt_rw') is-invalid @enderror" id="rt_rw" name="rt_rw" value="{{ old('rt_rw') }}" placeholder="Contoh: 001/002" required>
          @error('rt_rw')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        <div class="col-md-6">
          <label for="no_hp" class="form-label fw-semibold">Nomor HP Aktif <span class="text-danger">*</span></label>
          <input type="text" class="form-control @error('no_hp') is-invalid @enderror" id="no_hp" name="no_hp" value="{{ old('no_hp', Auth::user()->phone) }}" placeholder="Contoh: 081234567890" required>
          @error('no_hp')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        <div class="col-md-6">
          <label for="status_tempat_tinggal" class="form-label fw-semibold">Status Tempat Tinggal <span class="text-danger">*</span></label>
          <select class="form-select @error('status_tempat_tinggal') is-invalid @enderror" id="status_tempat_tinggal" name="status_tempat_tinggal" required>
            <option value="">-- Pilih Status Tempat Tinggal --</option>
            @foreach (['Milik Sendiri', 'Sewa / Kontrak', 'Menumpang Keluarga', 'Rumah Dinas', 'Lainnya'] as $status)
              <option value="{{ $status }}" {{ old('status_tempat_tinggal') === $status ? 'selected' : '' }}>{{ $status }}</option>
            @endforeach
          </select>
          @error('status_tempat_tinggal')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        <div class="col-md-6">
          <label for="desa" class="form-label fw-semibold">Desa <span class="text-danger">*</span></label>
          <input type="text" class="form-control @error('desa') is-invalid @enderror" id="desa" name="desa" value="{{ old('desa', 'Kalinaun') }}" placeholder="Masukkan nama desa" required>
          @error('desa')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>
      </div>
    </div>
  </section>

  {{-- ===== Pilihan Program ===== --}}
  <section class="panel mt-3">
    <div class="panel-header">
      <div>
        <h2 class="h5 mb-1 section-title"><i class="bi bi-box2-heart" aria-hidden="true"></i><span>Program Bantuan Sosial</span></h2>
      </div>
    </div>
    <div class="panel-body p-4">
      <label for="program" class="form-label fw-semibold">Pilih Program <span class="text-danger">*</span></label>
      <select class="form-select @error('program') is-invalid @enderror" id="program" name="program" required>
        <option value="">-- Pilih Program --</option>
        @foreach ($programs as $program)
          <option value="{{ $program }}" {{ old('program') === $program ? 'selected' : '' }}>{{ $program }}</option>
        @endforeach
      </select>
      @error('program')
        <div class="invalid-feedback">{{ $message }}</div>
      @enderror
    </div>
  </section>

  {{-- ===== Dokumen Pendukung ===== --}}
  <section class="panel mt-3">
    <div class="panel-header">
      <div>
        <h2 class="h5 mb-1 section-title"><i class="bi bi-paperclip" aria-hidden="true"></i><span>Dokumen Pendukung</span></h2>
        <p class="text-muted mb-0">Unggah berkas berikut (JPG, PNG, atau PDF maksimal 5 MB).</p>
      </div>
    </div>
    <div class="panel-body p-4">
      <div class="row g-3">
        <div class="col-md-4">
          <label for="dokumen_ktp" class="form-label fw-semibold">KTP <span class="text-danger">*</span></label>
          <input type="file" class="form-control @error('dokumen_ktp') is-invalid @enderror" id="dokumen_ktp" name="dokumen_ktp" accept=".jpg,.jpeg,.png,.pdf" required>
          @error('dokumen_ktp')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        <div class="col-md-4">
          <label for="dokumen_kk" class="form-label fw-semibold">KK <span class="text-danger">*</span></label>
          <input type="file" class="form-control @error('dokumen_kk') is-invalid @enderror" id="dokumen_kk" name="dokumen_kk" accept=".jpg,.jpeg,.png,.pdf" required>
          @error('dokumen_kk')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        <div class="col-md-4">
          <label for="dokumen_rumah" class="form-label fw-semibold">Foto Kondisi Rumah <span class="text-danger">*</span></label>
          <input type="file" class="form-control @error('dokumen_rumah') is-invalid @enderror" id="dokumen_rumah" name="dokumen_rumah" accept=".jpg,.jpeg,.png,.pdf" required>
          @error('dokumen_rumah')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>
      </div>
    </div>
  </section>

  {{-- ===== Kondisi Ekonomi Keluarga ===== --}}
  <section class="panel mt-3">
    <div class="panel-header">
      <div>
        <h2 class="h5 mb-1 section-title"><i class="bi bi-cash-coin" aria-hidden="true"></i><span>Kondisi Ekonomi Keluarga</span></h2>
      </div>
    </div>
    <div class="panel-body p-4">
      <label for="kondisi_ekonomi" class="form-label fw-semibold">Uraian Kondisi Ekonomi <span class="text-danger">*</span></label>
      <textarea class="form-control @error('kondisi_ekonomi') is-invalid @enderror" id="kondisi_ekonomi" name="kondisi_ekonomi" rows="4" placeholder="Jelaskan kondisi ekonomi keluarga, penghasilan, jumlah tanggungan, dan alasan membutuhkan bantuan..." required>{{ old('kondisi_ekonomi') }}</textarea>
      @error('kondisi_ekonomi')
        <div class="invalid-feedback">{{ $message }}</div>
      @enderror
    </div>
  </section>

  <div class="d-flex flex-wrap justify-content-end gap-2 mt-3 mb-4">
    <a href="{{ route('masyarakat.dashboard') }}" class="btn btn-light">Batal</a>
    <button type="submit" class="btn btn-primary"><i class="bi bi-send" aria-hidden="true"></i> Kirim Permohonan</button>
  </div>
</form>

<script>
  document.getElementById('nik').addEventListener('input', function () {
    this.value = this.value.replace(/[^\d]/g, '').slice(0, 16);
  });
</script>
@endsection
