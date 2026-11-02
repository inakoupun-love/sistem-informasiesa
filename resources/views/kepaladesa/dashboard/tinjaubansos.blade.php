@extends('layouts.kades')

@section('content')
<div class="page-heading">
  <div class="page-heading-copy">
    <span class="page-icon"><i class="bi bi-hand-thumbs-up" aria-hidden="true"></i></span>
    <div>
      <p class="eyebrow mb-1">Menu Utama</p>
      <h1 class="h3 mb-1">Penerima Usulan Bansos</h1>
      <p class="text-muted mb-0">Daftar usulan bantuan sosial dari Admin Desa untuk disetujui.</p>
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

{{-- ===== Usulan Menunggu Keputusan ===== --}}
<section class="panel mt-3">
  <div class="panel-header">
    <div>
      <h2 class="h5 mb-1 section-title"><i class="bi bi-inbox" aria-hidden="true"></i><span>Usulan Menunggu Keputusan</span></h2>
      <p class="text-muted mb-0">Usulan bansos yang telah diverifikasi Admin Desa.</p>
    </div>
  </div>
  <div class="table-responsive">
    <table class="table align-middle mb-0">
      <thead>
        <tr>
          <th scope="col">ID</th>
          <th scope="col">Nama Pemohon</th>
          <th scope="col">Program</th>
          <th scope="col">Tanggal Diusulkan</th>
          <th scope="col">Status</th>
          <th scope="col" class="text-end">Aksi</th>
        </tr>
      </thead>
      <tbody>
        @forelse($bansos as $b)
        <tr>
          <td>#{{ $b->id }}</td>
          <td>
            <p class="fw-semibold mb-0">{{ $b->nama_lengkap ?? ($b->user->name ?? 'User Tidak Ditemukan') }}</p>
            <p class="text-muted small mb-0">NIK: {{ $b->nik ?? ($b->user->nik ?? '-') }}</p>
          </td>
          <td>{{ $b->jenisBansos->nama_bansos ?? 'Tipe Dihapus' }}</td>
          <td>{{ $b->updated_at->format('d M Y') }}</td>
          <td><span class="badge text-bg-info">Diusulkan</span></td>
          <td class="text-end">
            <button class="btn btn-light btn-sm" data-bs-toggle="modal" data-bs-target="#modalDetail{{ $b->id }}"><i class="bi bi-eye"></i> Detail</button>
            <form action="{{ route('kepala_desa.bansos.update_status', $b->id) }}" method="POST" class="d-inline">
              @csrf
              @method('PUT')
              <input type="hidden" name="status" value="disetujui">
              <button type="submit" class="btn btn-success btn-sm"><i class="bi bi-check-circle"></i> Setujui</button>
            </form>
            <form action="{{ route('kepala_desa.bansos.update_status', $b->id) }}" method="POST" class="d-inline">
              @csrf
              @method('PUT')
              <input type="hidden" name="status" value="ditolak">
              <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menolak usulan bansos ini?');"><i class="bi bi-x-circle"></i> Tolak</button>
            </form>
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="6" class="text-center py-4 text-muted">Belum ada usulan bansos dari Admin Desa.</td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</section>

{{-- ===== Riwayat Usulan ===== --}}
<section class="panel mt-3">
  <div class="panel-header">
    <div>
      <h2 class="h5 mb-1 section-title"><i class="bi bi-clock-history" aria-hidden="true"></i><span>Riwayat Usulan</span></h2>
      <p class="text-muted mb-0">Usulan bansos yang telah diputuskan.</p>
    </div>
  </div>
  <div class="table-responsive">
    <table class="table align-middle mb-0">
      <thead>
        <tr>
          <th scope="col">ID</th>
          <th scope="col">Nama Pemohon</th>
          <th scope="col">Program</th>
          <th scope="col">Tanggal Keputusan</th>
          <th scope="col">Status</th>
        </tr>
      </thead>
      <tbody>
        @forelse($riwayatBansos as $b)
        <tr>
          <td>#{{ $b->id }}</td>
          <td>
            <p class="fw-semibold mb-0">{{ $b->nama_lengkap ?? ($b->user->name ?? '-') }}</p>
            <p class="text-muted small mb-0">NIK: {{ $b->nik ?? ($b->user->nik ?? '-') }}</p>
          </td>
          <td>{{ $b->jenisBansos->nama_bansos ?? 'Tipe Dihapus' }}</td>
          <td>{{ $b->updated_at->format('d M Y') }}</td>
          <td>
            @if($b->status == 'disetujui')
              <span class="badge text-bg-success">Disetujui</span>
            @else
              <span class="badge text-bg-danger">Ditolak</span>
            @endif
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="5" class="text-center py-4 text-muted">Belum ada riwayat usulan bansos.</td>
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
        <h5 class="modal-title">Detail Usulan Bansos #{{ $b->id }}</h5>
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

        @if($b->keterangan)
          <div class="alert alert-light border mb-3">
            <strong class="d-block mb-1">Catatan Verifikasi Admin</strong>
            {{ $b->keterangan }}
          </div>
        @endif

        <hr>
        <form action="{{ route('kepala_desa.bansos.update_status', $b->id) }}" method="POST">
          @csrf
          @method('PUT')
          <h6 class="mb-3">Keputusan Kepala Desa</h6>
          <div class="mb-3">
            <label class="form-label">Status <span class="text-danger">*</span></label>
            <select class="form-select" name="status" required>
              <option value="disetujui">Setujui</option>
              <option value="ditolak">Tolak</option>
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label">Keterangan / Catatan Tambahan</label>
            <textarea class="form-control" name="keterangan" rows="3" placeholder="Masukkan catatan tambahan jika diperlukan...">{{ $b->keterangan }}</textarea>
          </div>
          <div class="text-end">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-primary">Simpan Keputusan</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endforeach
@endsection
