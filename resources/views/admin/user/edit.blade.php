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
                <li class="breadcrumb-item"><a href="{{ route('user.index') }}">User</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit Data</li>
            </ol>
        </nav>
        <div class="d-flex justify-content-between w-100 flex-wrap">
            <div class="mb-3 mb-lg-0">
                <h1 class="h4">Edit User</h1>
                <p class="mb-0">Form untuk mengedit data user.</p>
            </div>
            <div>
                <a href="{{ route('user.index') }}" class="btn btn-primary">
                    <i class="far fa-question-circle me-1"></i> Kembali
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12 mb-4">
            <div class="card border-0 shadow components-section">
                <div class="card-body">

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

                    {{-- Error Messages --}}
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form action="{{ route('user.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row mb-4">
                            <div class="col-lg-6 col-sm-6">
                                <!-- Name -->
                                <div class="mb-3">
                                    <label for="name" class="form-label">Name</label>
                                    <input type="text" name="name" id="name" class="form-control" required
                                        value="{{ old('name', $user->name) }}">
                                </div>

                                <!-- Email -->
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" name="email" id="email" class="form-control" required
                                        value="{{ old('email', $user->email) }}">
                                </div>

                                <!-- Password -->
                                <div class="mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" name="password" id="password" class="form-control"
                                        placeholder="Masukkan password baru (minimal 8 karakter)"
                                        value="{{ old('password') }}">
                                    @error('password')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted">Biarkan kosong jika tidak ingin mengubah password</small>
                                </div>

                                <!-- Password Confirmation -->
                                <div class="mb-3">
                                    <label for="password_confirmation" class="form-label">Confirm Password</label>
                                    <input type="password" name="password_confirmation" id="password_confirmation"
                                        class="form-control" placeholder="Konfirmasi password baru">
                                </div>

                                {{-- Role --}}
                                <div class="mb-3">
                                    <label for="role" class="form-label">Role</label>
                                    <select name="role" id="role"
                                        class="form-control @error('role') is-invalid @enderror" required>
                                        <option value="">Pilih Role</option>
                                        <option value="Super Admin"
                                            {{ old('role', $user->role) == 'Super Admin' ? 'selected' : '' }}>Super Admin
                                        </option>
                                        <option value="Administrator"
                                            {{ old('role', $user->role) == 'Administrator' ? 'selected' : '' }}>
                                            Administrator</option>
                                        <option value="Pelanggan"
                                            {{ old('role', $user->role) == 'Pelanggan' ? 'selected' : '' }}>Pelanggan
                                        </option>
                                        <option value="Mitra" {{ old('role', $user->role) == 'Mitra' ? 'selected' : '' }}>
                                            Mitra</option>
                                    </select>
                                    @error('role')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Profile Picture -->
                                <div class="mb-3">
                                    <label for="profile_picture" class="form-label">Profile Picture</label>
                                    <input type="file" name="profile_picture" id="profile_picture"
                                        class="form-control" accept="image/jpeg,image/png,image/jpg,image/gif">
                                    @error('profile_picture')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted">Format: JPEG, PNG, JPG, GIF (Maksimal 2MB)</small>

                                    <!-- Show current profile picture if exists -->
                                    @if ($user->profile_picture)
                                        <div class="mt-2">
                                            <label class="form-label">Current Picture:</label>
                                            <div>
                                                <img src="{{ Storage::url($user->profile_picture) }}"
                                                    alt="Profile Picture" class="img-thumbnail" width="150">
                                            </div>
                                        </div>
                                    @endif
                                </div>

                                <!-- Buttons -->
                                <div class="">
                                    <button type="submit" class="btn btn-primary">Update</button>
                                    <a href="{{ route('user.index') }}" class="btn btn-outline-secondary ms-2">Batal</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
