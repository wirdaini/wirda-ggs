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
                <li class="breadcrumb-item"><a href="#">Pelanggan</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit Data</li>
            </ol>
        </nav>
        <div class="d-flex justify-content-between w-100 flex-wrap">
            <div class="mb-3 mb-lg-0">
                <h1 class="h4">Edit Pelanggan</h1>
                <p class="mb-0">Form untuk mengedit data pelanggan.</p>
            </div>
            <div>
                <a href="{{ route('pelanggan.index') }}" class="btn btn-primary"><i class="far fa-question-circle me-1"></i>
                    Kembali</a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12 mb-4">
            <div class="card border-0 shadow components-section">
                <div class="card-body">

                    <form action="{{ route('pelanggan.update', $dataPelanggan->pelanggan_id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row mb-4">
                            <div class="col-lg-4 col-sm-6">
                                <!-- First Name -->
                                <div class="mb-3">
                                    <label for="first_name" class="form-label">First name</label>
                                    <input type="text" name="first_name" id="first_name" class="form-control" required
                                        value="{{ $dataPelanggan->first_name }}">
                                </div>

                                <!-- Last Name -->
                                <div class="mb-3">
                                    <label for="last_name" class="form-label">Last name</label>
                                    <input type="text" name="last_name" id="last_name" class="form-control" required
                                        value="{{ $dataPelanggan->last_name }}">
                                </div>
                            </div>

                            <div class="col-lg-4 col-sm-6">
                                <!-- Birthday -->
                                <div class="mb-3">
                                    <label for="birthday" class="form-label">Birthday</label>
                                    <input type="date" name="birthday" id="birthday" class="form-control"
                                        value="{{ $dataPelanggan->birthday }}">
                                </div>

                                <!-- Gender -->
                                <div class="mb-3">
                                    <label for="gender" class="form-label">Gender</label>
                                    <select id="gender" name="gender" class="form-select">
                                        <option value="">-- Pilih --</option>
                                        <option value="Female" {{ $dataPelanggan->gender == 'Female' ? 'selected' : '' }}>
                                            Female
                                        </option>
                                        <option value="Male" {{ $dataPelanggan->gender == 'Male' ? 'selected' : '' }}>Male
                                        </option>
                                        <option value="Other" {{ $dataPelanggan->gender == 'Other' ? 'selected' : '' }}>
                                            Other
                                        </option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-4 col-sm-12">
                                <!-- Email -->
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="text" name="email" id="email" class="form-control" required
                                        value="{{ $dataPelanggan->email }}">
                                </div>

                                <!-- Phone -->
                                <div class="mb-3">
                                    <label for="phone" class="form-label">Phone</label>
                                    <input type="text" name="phone" id="phone" class="form-control"
                                        value="{{ $dataPelanggan->phone }}">
                                </div>

                                <!-- Buttons -->
                                <div class="">
                                    <button type="submit" class="btn btn-primary">Update</button>
                                    <a href="{{ route('pelanggan.index') }}"
                                        class="btn btn-outline-secondary ms-2">Batal</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Section Upload File & File List -->
    <div class="row">
        <div class="col-12 mb-4">
            <div class="card border-0 shadow components-section">
                <div class="card-body">

                    <!-- Alert Messages -->
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>Sukses!</strong> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Error!</strong> {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="row mb-4">
                        <!-- Form Upload File -->
                        <div class="col-lg-6">
                            <h5 class="mb-3">Upload File Pendukung</h5>
                            <form method="POST" action="{{ route('uploads.store') }}" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="ref_table" value="pelanggan">
                                <input type="hidden" name="ref_id" value="{{ $dataPelanggan->pelanggan_id }}">

                                <div class="mb-3">
                                    <label for="filename" class="form-label">Pilih File</label>
                                    <input type="file" class="form-control" name="filename[]" required multiple
                                        accept=".jpg,.jpeg,.png,.pdf,.doc,.docx">
                                    <div class="form-text">
                                        Format: JPG, PNG, PDF, DOC, DOCX (Maksimal 2MB per file)
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary">Upload Files</button>
                            </form>
                        </div>

                        <!-- Info -->
                        <div class="col-lg-6">
                            <div class="alert alert-info">
                                <h6>Info:</h6>
                                <p class="mb-0">Anda dapat menambah file pendukung pada halaman ini. File yang
                                    diupload akan langsung terlihat di list berikut.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Daftar File Terupload -->
                    <div class="row">
                        <div class="col-12">
                            <h5 class="mb-3">File Pendukung</h5>
                            @if ($dataPelanggan->files->count() > 0)
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
                                            @foreach ($dataPelanggan->files as $index => $file)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>
                                                        @if (in_array(pathinfo($file->filename, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'gif']))
                                                            <img src="{{ asset('images/' . $file->filename) }}"
                                                                alt="Thumbnail" width="50"
                                                                class="img-thumbnail me-2">
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
                                                                method="POST"
                                                                onsubmit="return confirm('Hapus file ini?')">
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
