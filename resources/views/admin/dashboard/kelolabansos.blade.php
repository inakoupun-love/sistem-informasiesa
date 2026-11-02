@extends('layouts.admin')

@section('content')
<div class="page-heading">
  <div class="page-heading-copy">
    <span class="page-icon"><i class="bi bi-hand-thumbs-up" aria-hidden="true"></i></span>
    <div>
      <p class="eyebrow mb-1">Manajemen</p>
      <h1 class="h3 mb-1">Kelola Bansos</h1>
      <p class="text-muted mb-0">Daftar semua permohonan bantuan sosial dari masyarakat.</p>
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
      <h2 class="h5 mb-1 section-title"><i class="bi bi-box-seam" aria-hidden="true"></i><span>Daftar Permohonan Bansos</span></h2>
    </div>
  </div>
  <div class="table-responsive">
    <table class="table align-middle mb-0">
      <thead>
        <tr>
          <th scope="col">ID</th>
          <th scope="col">Nama Pemohon</th>
          <th scope="col">Jenis Bansos</th>
          <th scope="col">Tanggal Pengajuan</th>
          <th scope="col">Status</th>
          <th scope="col" class="text-end">Aksi</th>
        </tr>
      </thead>
      <tbody>
        @forelse($bansos as $b)
        <tr>
          <td>#{{ $b->id }}</td>
          <td>
            <div class="d-flex align-items-center gap-2">
              <div>
                <p class="fw-semibold mb-0">{{ $b->nama_lengkap ?? ($b->user->name ?? 'User Tidak Ditemukan') }}</p>
                <p class="text-muted small mb-0">NIK: {{ $b->nik ?? ($b->user->nik ?? '-') }}</p>
              </div>
            </div>
          </td>
          <td>{{ $b->jenisBansos->nama_bansos ?? 'Tipe Dihapus' }}</td>
          <td>{{ $b->created_at->format('d M Y') }}</td>
          <td>
            @if($b->status == 'pending')
              <span class="badge text-bg-warning">Menunggu Verifikasi</span>
            @elseif($b->status == 'diusulkan')
              <span class="badge text-bg-info">Diusulkan ke Kades</span>
            @elseif($b->status == 'disetujui')
              <span class="badge text-bg-success">Disetujui</span>
            @else
              <span class="badge text-bg-danger">Ditolak</span>
            @endif
          </td>
          <td class="text-end">
            <div class="d-inline-flex flex-wrap align-items-center justify-content-end gap-1">
              @if($b->status == 'pending')
                <button class="btn btn-primary btn-sm text-nowrap" data-bs-toggle="modal" data-bs-target="#modalDetail{{ $b->id }}"><i class="bi bi-patch-check me-1"></i>Verifikasi</button>
              @else
                <button class="btn btn-light btn-sm text-nowrap" data-bs-toggle="modal" data-bs-target="#modalDetail{{ $b->id }}"><i class="bi bi-eye me-1"></i>Detail</button>
              @endif
              @if($b->status == 'disetujui')
                <button class="btn btn-success btn-sm text-nowrap" data-bs-toggle="modal" data-bs-target="#modalKirimWA{{ $b->id }}"><i class="bi bi-whatsapp me-1"></i>Kirim Notifikasi</button>
              @endif
              <form action="{{ route('admin.bansos.destroy', $b->id) }}" method="POST" class="d-inline-flex m-0" onsubmit="return confirm('Apakah Anda yakin ingin menghapus permohonan bansos ini?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-outline-danger btn-sm text-nowrap"><i class="bi bi-trash me-1"></i>Hapus</button>
              </form>
            </div>
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="6" class="text-center py-4 text-muted">Belum ada data permohonan bansos.</td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</section>

<!-- Modals rendered outside of table to prevent HTML rendering conflicts -->
@foreach($bansos as $b)
<div class="modal fade" id="modalDetail{{ $b->id }}" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">{{ $b->status == 'pending' ? 'Verifikasi Permohonan Bansos' : 'Detail Permohonan Bansos' }} #{{ $b->id }}</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-start">
        <div class="row mb-3">
          <div class="col-md-6">
            <h6>Informasi Pemohon</h6>
            <table class="table table-sm table-borderless">
              <tr>
                <td style="width: 140px;" class="text-muted">Nama Lengkap</td>
                <td>: {{ $b->nama_lengkap ?? ($b->user->name ?? '-') }}</td>
              </tr>
              <tr>
                <td class="text-muted">NIK</td>
                <td>: {{ $b->nik ?? ($b->user->nik ?? '-') }}</td>
              </tr>
              <tr>
                <td class="text-muted">Alamat</td>
                <td>: {{ $b->alamat ?? '-' }}</td>
              </tr>
              <tr>
                <td class="text-muted">RT/RW</td>
                <td>: {{ $b->rt_rw ?? '-' }}</td>
              </tr>
              <tr>
                <td class="text-muted">No. HP Aktif</td>
                <td>: {{ $b->no_hp ?? ($b->user->phone ?? '-') }}</td>
              </tr>
              <tr>
                <td class="text-muted">Status Tempat Tinggal</td>
                <td>: {{ $b->status_tempat_tinggal ?? '-' }}</td>
              </tr>
              <tr>
                <td class="text-muted">Desa</td>
                <td>: {{ $b->desa ?? '-' }}</td>
              </tr>
            </table>
          </div>
          <div class="col-md-6">
            <h6>Informasi Bansos</h6>
            <table class="table table-sm table-borderless">
              <tr>
                <td style="width: 140px;" class="text-muted">Program</td>
                <td>: {{ $b->jenisBansos->nama_bansos ?? '-' }}</td>
              </tr>
              <tr>
                <td class="text-muted">Tanggal</td>
                <td>: {{ $b->created_at->format('d M Y H:i') }}</td>
              </tr>
              <tr>
                <td class="text-muted">Kondisi Ekonomi</td>
                <td>: {{ $b->kondisi_ekonomi ?? ($b->alasan ?? '-') }}</td>
              </tr>
              <tr>
                <td class="text-muted">Dokumen Pendukung</td>
                <td>:
                  <div class="d-flex flex-wrap gap-1 mt-1">
                    @if($b->dokumen_ktp)
                      <a href="{{ asset('storage/' . $b->dokumen_ktp) }}" target="_blank" class="btn btn-outline-primary btn-sm"><i class="bi bi-file-earmark-arrow-down"></i> KTP</a>
                    @endif
                    @if($b->dokumen_kk)
                      <a href="{{ asset('storage/' . $b->dokumen_kk) }}" target="_blank" class="btn btn-outline-primary btn-sm"><i class="bi bi-file-earmark-arrow-down"></i> KK</a>
                    @endif
                    @if($b->dokumen_rumah)
                      <a href="{{ asset('storage/' . $b->dokumen_rumah) }}" target="_blank" class="btn btn-outline-primary btn-sm"><i class="bi bi-file-earmark-arrow-down"></i> Foto Rumah</a>
                    @endif
                    @if($b->dokumen_pendukung)
                      <a href="{{ asset('storage/' . $b->dokumen_pendukung) }}" target="_blank" class="btn btn-outline-primary btn-sm"><i class="bi bi-file-earmark-arrow-down"></i> Dokumen</a>
                    @endif
                    @if(!$b->dokumen_ktp && !$b->dokumen_kk && !$b->dokumen_rumah && !$b->dokumen_pendukung)
                      <span class="text-muted">-</span>
                    @endif
                  </div>
                </td>
              </tr>
            </table>
          </div>
        </div>

        <hr>

        <h6 class="mb-3">Tindakan Admin</h6>
        @if($b->status == 'pending')
          <form action="{{ route('admin.bansos.usulkan', $b->id) }}" method="POST" class="mb-3">
            @csrf
            <div class="mb-2">
              <label class="form-label">Catatan Verifikasi <span class="text-muted">(opsional)</span></label>
              <textarea class="form-control" name="keterangan" rows="2" placeholder="Catatan untuk Kepala Desa...">{{ $b->keterangan }}</textarea>
            </div>
            <button type="submit" class="btn btn-primary w-100"><i class="bi bi-send-check"></i> Verifikasi &amp; Usulkan ke Kepala Desa</button>
          </form>

          <form action="{{ route('admin.bansos.update_status', $b->id) }}" method="POST" onsubmit="return confirm('Tolak permohonan bansos ini?');">
            @csrf
            @method('PUT')
            <input type="hidden" name="status" value="ditolak">
            <div class="mb-2">
              <label class="form-label">Alasan Penolakan</label>
              <textarea class="form-control" name="keterangan" rows="2" placeholder="Masukkan alasan penolakan..."></textarea>
            </div>
            <button type="submit" class="btn btn-outline-danger w-100"><i class="bi bi-x-circle"></i> Tolak Permohonan</button>
          </form>
        @elseif($b->status == 'diusulkan')
          <div class="alert alert-info mb-0"><i class="bi bi-hourglass-split me-1"></i> Permohonan telah diverifikasi dan diusulkan. Menunggu keputusan Kepala Desa.</div>
          @if($b->keterangan)
            <p class="text-muted small mt-2 mb-0">Catatan verifikasi: {{ $b->keterangan }}</p>
          @endif
        @elseif($b->status == 'disetujui')
          <div class="alert alert-success mb-0"><i class="bi bi-check-circle me-1"></i> Disetujui Kepala Desa. Kirim notifikasi kepada pemohon melalui tombol <strong>Kirim Notifikasi</strong>.</div>
        @else
          <div class="alert alert-danger mb-0"><i class="bi bi-x-circle me-1"></i> Permohonan ditolak. Keterangan: {{ $b->keterangan ?? '-' }}</div>
        @endif

        <div class="text-end mt-3">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modalKirimWA{{ $b->id }}" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="{{ route('admin.bansos.kirim_wa', $b->id) }}" method="POST">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title"><i class="bi bi-whatsapp" aria-hidden="true"></i> Kirim Notifikasi - #{{ $b->id }}</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="mb-2">
            <span class="text-muted small">Kepada:</span>
            <span class="fw-semibold">{{ $b->nama_lengkap ?? ($b->user->name ?? '-') }}</span>
            <span class="text-muted">({{ $b->no_hp ?? ($b->user->phone ?? 'Nomor tidak tersedia') }})</span>
          </div>
          <div class="mb-2">
            <label class="form-label"><i class="bi bi-keyboard" aria-hidden="true"></i> Pesan WhatsApp</label>
            <textarea class="form-control" name="pesan" rows="5" required placeholder="Tulis pesan yang akan dikirim...">Halo {{ $b->nama_lengkap ?? ($b->user->name ?? '') }}, permohonan {{ $b->jenisBansos->nama_bansos ?? '-' }} Anda telah disetujui dan Anda terdaftar sebagai penerima bansos. Kami akan menghubungi Anda untuk proses selanjutnya.</textarea>
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
