@extends('layout.admin')

@section('title', 'Tambah User')

@section('content')
<!-- Hidden inputs for SweetAlert messages -->
<input type="hidden" id="success-message" value="{{ session('success') }}">
<input type="hidden" id="error-message" value="{{ session('error') }}">

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Tambah User Baru</h6>
    </div>
    <div class="card-body">
        <form action="{{ route('user.add') }}" method="POST" enctype="multipart/form-data" class="user-form">
            @csrf
            <div class="row">
                <div class="col-md-4 text-center">
                    <label for="foto_user" class="form-label d-block"></label>
                    <img id="preview-image" src="{{ asset('default.jpg') }}" alt="Foto Profil" class="img-fluid mb-3" style="max-width: 70%; height: auto;">
                    <input type="file" name="foto_user" id="foto_user" class="form-control" onchange="loadfile(event)">
                </div>
                <div class="col-md-8">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="nama_user">Nama User</label>
                            <input type="text" name="nama_user" id="nama_user" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label for="username">Email/Username</label>
                            <input type="text" name="username" id="username" class="form-control" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="password">Password</label>
                            <input type="password" name="password" id="password" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label for="password_confirmation">Konfirmasi Password</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="no_telepon">No Telepon</label>
                            <input type="text" name="no_telepon" id="no_telepon" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label for="roles">Role</label>
                            <select name="roles" id="roles" class="form-control" required>
                                <option>Pilih</option>
                                <option value="admin">Admin</option>
                                <option value="petugas">Petugas</option>
                                <option value="pasien">Pasien</option>
                            </select>
                        </div>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <a href="{{ route('user.index') }}" class="btn btn-secondary">Batal</a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    // Script untuk menampilkan preview gambar
    var loadfile = function(event) {
        var output = document.getElementById('preview-image');
        output.src = URL.createObjectURL(event.target.files[0]);
        output.onload = function() {
            URL.revokeObjectURL(output.src) // free memory
        }
    };
</script>
@endsection

@include('sweetalert::alert')

@push('scripts')
<script src="{{ asset('js/sweetalert.js') }}"></script>
@endpush