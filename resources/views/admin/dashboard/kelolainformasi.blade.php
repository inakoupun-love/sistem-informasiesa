@extends('layouts.admin')

@section('content')
<div class="page-heading">
  <div class="page-heading-copy">
    <span class="page-icon"><i class="bi bi-newspaper" aria-hidden="true"></i></span>
    <div>
      <p class="eyebrow mb-1">Manajemen</p>
      <h1 class="h3 mb-1">Kelola Informasi</h1>
      <p class="text-muted mb-0">Manajemen berita, pengumuman, and informasi penting untuk warga.</p>
    </div>
  </div>
  <div class="heading-actions">
    <button class="btn btn-primary btn-sm" type="button" data-bs-toggle="modal" data-bs-target="#modalTambah"><i class="bi bi-plus-lg" aria-hidden="true"></i> Tambah Informasi</button>
  </div>
</div>

@if(session('success'))
<div class="alert alert-success mt-3 alert-dismissible fade show" role="alert">
  {{ session('success') }}
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
      <h2 class="h5 mb-1 section-title"><i class="bi bi-card-heading" aria-hidden="true"></i><span>Daftar Informasi</span></h2>
    </div>
  </div>
  <div class="table-responsive">
    <table class="table align-middle mb-0">
      <thead>
        <tr>
          <th scope="col">Judul</th>
          <th scope="col">Kategori</th>
          <th scope="col">Tanggal Dibuat</th>
          <th scope="col">Penulis</th>
          <th scope="col" class="text-end">Aksi</th>
        </tr>
      </thead>
      <tbody>
        @forelse($informasi as $info)
        <tr>
          <td><p class="fw-semibold mb-0">{{ $info->judul }}</p></td>
          <td><span class="badge text-bg-secondary">{{ $info->kategori ?? 'Umum' }}</span></td>
          <td>{{ $info->created_at->format('d M Y') }}</td>
          <td>{{ $info->user->name ?? 'Admin' }}</td>
          <td class="text-end">
            <button class="btn btn-light btn-sm" data-bs-toggle="modal" data-bs-target="#modalEdit{{ $info->id }}"><i class="bi bi-pencil"></i> Edit</button>
            <form action="{{ route('admin.informasi.destroy', $info->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus informasi ini?');">
              @csrf
              @method('DELETE')
              <button type="submit" class="btn btn-danger btn-sm"><i class="bi bi-trash"></i> Hapus</button>
            </form>
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="5" class="text-center py-4 text-muted">Belum ada data informasi.</td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</section>

<!-- Modals rendered outside of table to prevent HTML rendering conflicts -->
@foreach($informasi as $info)
<div class="modal fade modal-ckeditor" id="modalEdit{{ $info->id }}" tabindex="-1" aria-hidden="true" data-editor-id="editorEdit{{ $info->id }}">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form action="{{ route('admin.informasi.update', $info->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="modal-header">
          <h5 class="modal-title">Edit Informasi</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body text-start">
          <div class="mb-3">
            <label class="form-label">Judul Informasi <span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="judul" value="{{ $info->judul }}" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Kategori <span class="text-danger">*</span></label>
            <select class="form-select" name="kategori" required>
              <option value="Umum" {{ $info->kategori == 'Umum' ? 'selected' : '' }}>Umum</option>
              <option value="Pengumuman" {{ $info->kategori == 'Pengumuman' ? 'selected' : '' }}>Pengumuman</option>
              <option value="Kegiatan" {{ $info->kategori == 'Kegiatan' ? 'selected' : '' }}>Kegiatan</option>
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label">Konten Informasi <span class="text-danger">*</span></label>
            <textarea class="form-control" id="editorEdit{{ $info->id }}" name="konten" rows="5" required>{{ $info->konten }}</textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endforeach

<!-- Modal Tambah -->
<div class="modal fade" id="modalTambah" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form action="{{ route('admin.informasi.store') }}" method="POST">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title">Tambah Informasi</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body text-start">
          <div class="mb-3">
            <label class="form-label">Judul Informasi <span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="judul" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Kategori <span class="text-danger">*</span></label>
            <select class="form-select" name="kategori" required>
              <option value="Umum">Umum</option>
              <option value="Pengumuman">Pengumuman</option>
              <option value="Kegiatan">Kegiatan</option>
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label">Konten Informasi <span class="text-danger">*</span></label>
            <textarea class="form-control" id="editorTambah" name="konten" rows="5"></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script src="https://cdn.ckeditor.com/ckeditor5/36.0.1/classic/ckeditor.js"></script>
<script>
  class MyUploadAdapter {
    constructor(loader) {
      this.loader = loader;
    }

    upload() {
      return this.loader.file
        .then(file => new Promise((resolve, reject) => {
          this._initRequest();
          this._initListeners(resolve, reject, file);
          this._sendRequest(file);
        }));
    }

    abort() {
      if (this.xhr) {
        this.xhr.abort();
      }
    }

    _initRequest() {
      const xhr = this.xhr = new XMLHttpRequest();
      xhr.open('POST', '{{ route("admin.informasi.upload_image") }}', true);
      xhr.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}');
      xhr.responseType = 'json';
    }

    _initListeners(resolve, reject, file) {
      const xhr = this.xhr;
      const loader = this.loader;
      const genericErrorText = `Couldn't upload file: ${file.name}.`;

      xhr.addEventListener('error', () => reject(genericErrorText));
      xhr.addEventListener('abort', () => reject());
      xhr.addEventListener('load', () => {
        const response = xhr.response;

        if (!response || response.error) {
          return reject(response && response.error ? response.error.message : genericErrorText);
        }

        resolve({
          default: response.url
        });
      });

      if (xhr.upload) {
        xhr.upload.addEventListener('progress', evt => {
          if (evt.lengthComputable) {
            loader.uploadTotal = evt.total;
            loader.uploaded = evt.loaded;
          }
        });
      }
    }

    _sendRequest(file) {
      const data = new FormData();
      data.append('upload', file);
      this.xhr.send(data);
    }
  }

  function MyCustomUploadAdapterPlugin(editor) {
    editor.plugins.get('FileRepository').createUploadAdapter = (loader) => {
      return new MyUploadAdapter(loader);
    };
  }

  document.addEventListener("DOMContentLoaded", function() {
    // Initialize Editor for Tambah
    ClassicEditor
      .create(document.querySelector('#editorTambah'), {
        extraPlugins: [MyCustomUploadAdapterPlugin]
      })
      .catch(error => {
        console.error(error);
      });

    // Initialize Editors for Edit Modals dynamically when modal is shown
    const editModals = document.querySelectorAll('.modal-ckeditor');
    editModals.forEach(modal => {
      const editorId = modal.getAttribute('data-editor-id');
      const textarea = modal.querySelector('#' + editorId);
      
      let editorInstance = null;
      
      modal.addEventListener('shown.bs.modal', function() {
        if (!editorInstance) {
          ClassicEditor
            .create(textarea, {
              extraPlugins: [MyCustomUploadAdapterPlugin]
            })
            .then(editor => {
              editorInstance = editor;
            })
            .catch(error => {
              console.error(error);
            });
        }
      });
    });
  });
</script>
@endsection
