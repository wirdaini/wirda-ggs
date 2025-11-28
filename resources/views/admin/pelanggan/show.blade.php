@extends('layouts.admin.app')

@section('content')
    <div class="py-4">
        <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
            <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
                <li class="breadcrumb-item">
                    <a href="#">
                        <svg class="icon icon-xxs" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                            </path>
                        </svg>
                    </a>
                </li>
                <li class="breadcrumb-item"><a href="{{ route('pelanggan.index') }}">Pelanggan</a></li>
                <li class="breadcrumb-item active" aria-current="page">Detail Pelanggan</li>
            </ol>
        </nav>
        <div class="d-flex justify-content-between w-100 flex-wrap">
            <div class="mb-3 mb-lg-0">
                <h1 class="h4">Detail Pelanggan</h1>
                <p class="mb-0">Informasi lengkap pelanggan dan file pendukung</p>
            </div>
            <div>
                <a href="{{ route('pelanggan.index') }}" class="btn btn-primary">
                    <i class="far fa-question-circle me-1"></i> Kembali
                </a>
            </div>
        </div>
    </div>

    {{-- Success/Error Messages --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Sukses!</strong> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Error!</strong> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-12 mb-4">
            <div class="card border-0 shadow components-section">
                <div class="card-body">
                    <div class="row">
                        <!-- Informasi Pelanggan -->
                        <div class="col-lg-6">
                            <h5 class="mb-3">Informasi Pelanggan</h5>
                            <!-- MENJADI INI: -->
                            <table class="table table-bordered">
                                <tr>
                                    <th width="30%">Nama</th>
                                    <td>{{ $pelanggan->first_name }} {{ $pelanggan->last_name }}</td>
                                </tr>
                                <tr>
                                    <th>Email</th>
                                    <td>{{ $pelanggan->email }}</td>
                                </tr>
                                <tr>
                                    <th>Telepon</th>
                                    <td>{{ $pelanggan->phone }}</td>
                                </tr>
                                <tr>
                                    <th>Tanggal Lahir</th>
                                    <td>{{ $pelanggan->birthday }}</td>
                                </tr>
                                <tr>
                                    <th>Jenis Kelamin</th>
                                    <td>{{ $pelanggan->gender }}</td>
                                </tr>
                            </table>
                        </div>

                        <!-- Form Upload File -->
                        <div class="col-lg-6">
                            <h5 class="mb-3">Upload File Pendukung</h5>
                            <form method="POST" action="{{ route('uploads.store') }}" enctype="multipart/form-data">
                                @csrf

                                <!-- Hidden fields untuk relasi -->
                                <input type="hidden" name="ref_table" value="pelanggan">
                                <input type="hidden" name="ref_id" value="{{ $pelanggan->pelanggan_id }}">

                                <div class="mb-3">
                                    <label for="filename" class="form-label">Pilih File</label>
                                    <input type="file" class="form-control" name="filename[]" required multiple
                                        accept=".jpg,.jpeg,.png,.pdf,.doc,.docx">
                                    <div class="form-text">
                                        Format: JPG, PNG, PDF, DOC, DOCX (Maksimal 2MB per file)
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary">
                                    Upload Files
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Daftar File Terupload -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <h5 class="mb-3">File Pendukung</h5>
                            @if ($pelanggan->files->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama File</th>
                                                <th>Tanggal Upload</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($pelanggan->files as $index => $file)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>
                                                        @if (in_array(pathinfo($file->filename, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'gif']))
                                                            <img src="{{ asset('images/' . $file->filename) }}"
                                                                alt="Thumbnail" width="50" class="img-thumbnail me-2">
                                                        @else
                                                            <i class="fas fa-file me-2"></i>
                                                        @endif
                                                        {{ $file->filename }}
                                                    </td>
                                                    <td>{{ $file->created_at->format('d/m/Y H:i') }}</td>
                                                    <td>
                                                        <div class="btn-group">
                                                            <a href="{{ asset('images/' . $file->filename) }}"
                                                                target="_blank" class="btn btn-sm btn-info">
                                                                Lihat
                                                            </a>
                                                            <form action="{{ route('uploads.destroy', $file->id) }}"
                                                                method="POST" onsubmit="return confirm('Hapus file ini?')">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-sm btn-danger">
                                                                    Hapus
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <p class="text-muted">Belum ada file pendukung.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </body>
@endsection
