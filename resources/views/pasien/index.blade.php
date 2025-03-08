@extends(
    Auth::user()->roles == 'admin' ? 'layout.admin' : 
    (Auth::user()->roles == 'petugas' ? 'layout.petugas' : 'layout.default')
)

@section('title', 'Data Pasien')

@section('content')
<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">Data Pasien</h1>

<!-- Search Filter -->
<div class="card shadow mb-4">
    <div class="card-body">
        <form action="{{ route('pasien.index') }}" method="GET" class="row">
            <div class="col-md-4 mb-3">
                <label for="search">Cari</label>
                <div class="input-group">
                    <input type="text" class="form-control" id="search" name="search" value="{{ request()->input('search') }}"
                        placeholder="Cari...">
                </div>
            </div>
        </form>
    </div>
</div>

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="datatable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Pasien</th>
                        <th>Email</th>
                        <th>No. Telepon</th>
                        <th>NIK</th>
                        <th>Tempat Lahir</th>
                        <th>Tanggal Lahir</th>
                        <th>Jenis Kelamin</th>
                        <th>Alamat</th>
                        <th>No. Kartu Berobat</th>
                        <th>No. Kartu BPJS</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @php $no = 1; @endphp
                    @foreach ($dataPasien as $item)
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $item->nama_pasien }}</td>
                        <td>{{ $item->email }}</td>
                        <td>{{ $item->no_telp }}</td>
                        <td>{{ $item->nik ?? '-' }}</td>
                        <td>{{ $item->tempat_lahir ?? '-' }}</td>
                        <td>{{ $item->tanggal_lahir ? \Carbon\Carbon::parse($item->tanggal_lahir)->format('d-m-Y') : '-' }}</td>
                        <td>{{ $item->jenis_kelamin ?? '-' }}</td>
                        <td>{{ $item->alamat ?? '-' }}</td>
                        <td>{{ $item->no_kberobat ?? '-' }}</td>
                        <td>{{ $item->no_kbpjs ?? '-' }}</td>
                        @if (Auth::user()->roles == 'admin')
                        <td class="d-flex">
                            <a href="{{ route('pasien.show', $item->id) }}" class="btn btn-info btn-sm mr-1"><i class="fas fa-eye"></i></a>
                            <a href="{{ route('pasien.edit', $item->id) }}" class="btn btn-warning btn-sm mr-1">Edit</a>
                            <form action="{{ route('pasien.destroy', $item->id) }}" method="POST" class="d-inline delete-form">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-danger btn-sm btn-delete">Hapus</button>
                            </form>
                        </td>
                        @endif
                        @if (in_array(Auth::user()->roles, ['petugas', 'kepala_rs']))
                        <td class="d-flex">
                            <a href="{{ route('pasien.show', $item->id) }}" class="btn btn-info btn-sm mr-1"><i class="fas fa-eye"></i></a>
                        </td>
                        @endif
                    </tr>
                    @endforeach
                    @include('sweetalert::alert')
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Sertakan SweetAlert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<!-- Sertakan file JavaScript khusus -->
<script src="{{ asset('js/sweetalert.js') }}"></script>
@endsection