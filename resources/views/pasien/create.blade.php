@extends(Auth::user()->roles == 'pasien' ? 'layout.pasien' : 'layout.admin')

@section('title', 'Tambah Data Pasien')

@section('content')
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Tambah Data Pasien</h6>
    </div>
    <div class="card-body">
        <form action="{{ route('pasien.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="nama_pasien">Nama Pasien</label>
                <input type="text" name="nama_pasien" id="nama_pasien" class="form-control @error('nama_pasien') is-invalid @enderror" value="{{ old('nama_pasien', $user->nama_user) }}">
                @error('nama_pasien')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user->username) }}">
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="no_telp">No. Telepon</label>
                <input type="text" name="no_telp" id="no_telp" class="form-control @error('no_telp') is-invalid @enderror" value="{{ old('no_telp', $user->no_telepon) }}">
                @error('no_telp')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="nik">NIK</label>
                <input type="text" name="nik" id="nik" class="form-control @error('nik') is-invalid @enderror" maxlength="16" value="{{ old('nik') }}">
                @error('nik')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="tempat_lahir">Tempat Lahir</label>
                <input type="text" name="tempat_lahir" id="tempat_lahir" class="form-control @error('tempat_lahir') is-invalid @enderror" value="{{ old('tempat_lahir') }}">
                @error('tempat_lahir')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="tanggal_lahir">Tanggal Lahir</label>
                <input type="date" name="tanggal_lahir" id="tanggal_lahir" class="form-control @error('tanggal_lahir') is-invalid @enderror" value="{{ old('tanggal_lahir') }}">
                @error('tanggal_lahir')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="jenis_kelamin">Jenis Kelamin</label>
                <select name="jenis_kelamin" id="jenis_kelamin" class="form-control @error('jenis_kelamin') is-invalid @enderror">
                    <option value="">-- Pilih Jenis Kelamin --</option>
                    <option value="laki-laki" {{ old('jenis_kelamin') == 'laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="perempuan" {{ old('jenis_kelamin') == 'perempuan' ? 'selected' : '' }}>Perempuan</option>
                </select>
                @error('jenis_kelamin')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="alamat">Alamat</label>
                <textarea name="alamat" id="alamat" class="form-control @error('alamat') is-invalid @enderror" rows="3">{{ old('alamat') }}</textarea>
                @error('alamat')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="no_kberobat">No. Kartu Berobat</label>
                <input type="text" name="no_kberobat" id="no_kberobat" class="form-control @error('no_kberobat') is-invalid @enderror" value="{{ old('no_kberobat') }}">
                @error('no_kberobat')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="no_kbpjs">No. Kartu BPJS</label>
                <input type="text" name="no_kbpjs" id="no_kbpjs" class="form-control @error('no_kbpjs') is-invalid @enderror" value="{{ old('no_kbpjs') }}">
                @error('no_kbpjs')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="scan_ktp">Scan KTP</label>
                <input type="file" name="scan_ktp" id="scan_ktp" class="form-control @error('scan_ktp') is-invalid @enderror">
                @error('scan_ktp')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="scan_kberobat">Scan Kartu Berobat</label>
                <input type="file" name="scan_kberobat" id="scan_kberobat" class="form-control @error('scan_kberobat') is-invalid @enderror">
                @error('scan_kberobat')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="scan_kbpjs">Scan BPJS</label>
                <input type="file" name="scan_kbpjs" id="scan_kbpjs" class="form-control @error('scan_kbpjs') is-invalid @enderror">
                @error('scan_kbpjs')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="scan_kasuransi">Scan Asuransi</label>
                <input type="file" name="scan_kasuransi" id="scan_kasuransi" class="form-control @error('scan_kasuransi') is-invalid @enderror">
                @error('scan_kasuransi')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('dashboard-pasien') }}" class="btn btn-secondary">Kembali</a>
            </div>
        </form>
    </div>
</div>
@endsection
