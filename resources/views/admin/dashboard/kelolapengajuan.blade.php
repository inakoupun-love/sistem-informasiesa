@extends('layouts.admin')

@section('content')
<div class="page-heading">
  <div class="page-heading-copy">
    <span class="page-icon"><i class="bi bi-file-earmark" aria-hidden="true"></i></span>
    <div>
      <p class="eyebrow mb-1">Manajemen</p>
      <h1 class="h3 mb-1">Kelola Pengajuan Surat</h1>
      <p class="text-muted mb-0">Daftar semua pengajuan surat dari masyarakat yang masuk ke sistem.</p>
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

@if($errors->any())
<div class="alert alert-danger mt-3 alert-dismissible fade show" role="alert">
  <ul class="mb-0">
    @foreach($errors->all() as $error)
      <li>{{ $error }}</li>
    @endforeach
  </ul>
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
            @if($pengajuan->status == 'disetujui')
              <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#modalKirimWA{{ $pengajuan->id }}"><i class="bi bi-whatsapp"></i> Kirim WA</button>
              <a href="{{ route('admin.pengajuan.cetak', $pengajuan->id) }}" target="_blank" class="btn btn-primary btn-sm"><i class="bi bi-printer"></i> Cetak</a>
            @endif
            <button class="btn btn-light btn-sm" data-bs-toggle="modal" data-bs-target="#modalDetail{{ $pengajuan->id }}"><i class="bi bi-eye"></i> Detail</button>
            <form action="{{ route('admin.pengajuan.destroy', $pengajuan->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengajuan ini?');">
              @csrf
              @method('DELETE')
              <button type="submit" class="btn btn-danger btn-sm"><i class="bi bi-trash"></i> Hapus</button>
            </form>
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
                <td style="width: 120px;" class="text-muted">Keperluan</td>
                <td>: {{ $pengajuan->keperluan ?? '-' }}</td>
              </tr>
              <tr>
                <td class="text-muted">Dokumen Pendukung</td>
                <td>:
                  @if($pengajuan->dokumen_pendukung)
                    <a href="{{ asset('storage/' . $pengajuan->dokumen_pendukung) }}" target="_blank" class="btn btn-outline-primary btn-sm mt-1"><i class="bi bi-file-earmark-arrow-down"></i> Lihat Dokumen</a>
                  @else
                    <span class="text-muted">-</span>
                  @endif
                </td>
              </tr>
            </table>
          </div>
        </div>
        </div>

        <hr>

        <form action="{{ route('admin.pengajuan.update_status', $pengajuan->id) }}" method="POST">
          @csrf
          @method('PUT')
          <h6 class="mb-3">Tindakan Admin</h6>
          <div class="mb-3">
            <label class="form-label">Ubah Status Pengajuan <span class="text-danger">*</span></label>
            <select class="form-select" name="status" required>
              <option value="pending" {{ $pengajuan->status == 'pending' ? 'selected' : '' }}>Menunggu</option>
              <option value="disetujui" {{ $pengajuan->status == 'disetujui' ? 'selected' : '' }}>Setujui</option>
              <option value="ditolak" {{ $pengajuan->status == 'ditolak' ? 'selected' : '' }}>Tolak</option>
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label">Keterangan / Catatan Admin</label>
            <textarea class="form-control" name="keterangan" rows="3" placeholder="Masukkan keterangan persetujuan atau alasan penolakan...">{{ $pengajuan->keterangan }}</textarea>
          </div>
          <div class="text-end">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-success">Update Status</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modalKirimWA{{ $pengajuan->id }}" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="{{ route('admin.pengajuan.kirim_wa', $pengajuan->id) }}" method="POST">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title"><i class="bi bi-whatsapp" aria-hidden="true"></i> Kirim WhatsApp - #{{ $pengajuan->id }}</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="mb-2">
            <span class="text-muted small">Kepada:</span>
            <span class="fw-semibold">{{ $pengajuan->user->name ?? '-' }}</span>
            <span class="text-muted">({{ $pengajuan->user->phone ?? 'Nomor tidak tersedia' }})</span>
          </div>
          <div class="mb-2">
            <label class="form-label"><i class="bi bi-keyboard" aria-hidden="true"></i> Pesan WhatsApp</label>
            <textarea class="form-control" name="pesan" rows="5" required placeholder="Tulis pesan yang akan dikirim...">Halo {{ $pengajuan->user->name ?? '' }}, surat {{ $pengajuan->jenisSurat->nama_surat ?? '-' }} Anda telah selesai dan dapat diambil di Kantor Desa Kalinaun.</textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-success"><i class="bi bi-send"></i> Kirim</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endforeach
@endsection
