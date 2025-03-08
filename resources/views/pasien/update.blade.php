@extends(
    Auth::user()->roles == 'admin' ? 'layout.admin' :
    (Auth::user()->roles == 'pasien' ? 'layout.pasien' : 'layout.default')
)

@section('title', 'Edit Data Pasien')

@section('content')
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Edit Data Pasien</h6>
    </div>
    <div class="card-body">
        <form action="{{ route('pasien.update', $dataPasien->id) }}" method="POST" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label for="nik">NIK</label>
                <input type="text" name="nik" id="nik" class="form-control" maxlength="16" value="{{ old('nik', $dataPasien->nik) }}">
            </div>
            <div class="form-group">
                <label for="tempat_lahir">Tempat Lahir</label>
                <input type="text" name="tempat_lahir" id="tempat_lahir" class="form-control" value="{{ old('tempat_lahir', $dataPasien->tempat_lahir) }}">
            </div>
            <div class="form-group">
                <label for="tanggal_lahir">Tanggal Lahir</label>
                <input type="date" name="tanggal_lahir" id="tanggal_lahir" class="form-control" value="{{ old('tanggal_lahir', $dataPasien->tanggal_lahir) }}">
            </div>
            <div class="form-group">
                <label for="jenis_kelamin">Jenis Kelamin</label>
                <select name="jenis_kelamin" id="jenis_kelamin" class="form-control">
                    <option value="laki-laki" {{ ($dataPasien->jenis_kelamin == 'laki-laki' ? 'selected' : '') }}>Laki-laki</option>
                    <option value="perempuan" {{ ($dataPasien->jenis_kelamin == 'perempuan' ? 'selected' : '') }}>Perempuan</option>
                </select>
            </div>
            <div class="form-group">
                <label for="alamat">Alamat</label>
                <input type="text" name="alamat" id="alamat" class="form-control" value="{{ old('alamat', $dataPasien->alamat) }}">
            </div>
            <div class="form-group">
                <label for="no_kberobat">No. Kartu Berobat</label>
                <input type="text" name="no_kberobat" id="no_kberobat" class="form-control" value="{{ old('no_kberobat', $dataPasien->no_kberobat) }}">
            </div>
            <div class="form-group">
                <label for="no_kbpjs">No. Kartu BPJS</label>
                <input type="text" name="no_kbpjs" id="no_kbpjs" class="form-control" value="{{ old('no_kbpjs', $dataPasien->no_kbpjs) }}">
            </div>
            <div class="form-group">
                <label for="scan_ktp">Scan KTP</label>
                <input type="file" name="scan_ktp" id="scan_ktp" class="form-control">
            </div>
            <div class="form-group">
                <label for="scan_kberobat">Scan Kartu Berobat</label>
                <input type="file" name="scan_kberobat" id="scan_kberobat" class="form-control">
            </div>
            <div class="form-group">
                <label for="scan_kbpjs">Scan BPJS</label>
                <input type="file" name="scan_kbpjs" id="scan_kbpjs" class="form-control">
            </div>
            <div class="form-group">
                <label for="scan_kasuransi">Scan Asuransi</label>
                <input type="file" name="scan_kasuransi" id="scan_kasuransi" class="form-control">
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-primary">Update</button>
                @if (Auth::user()->roles == 'pasien')
                <a href="{{ route('pasien.show', $dataPasien->id) }}" class="btn btn-secondary">Batal</a>
                @endif
                @if (Auth::user()->roles == 'admin')
                <a href="{{ route('pasien.index', $dataPasien->id) }}" class="btn btn-secondary">Batal</a>
                @endif
            </div>
        </form>
    </div>
</div>
@endsection

@include('sweetalert::alert')