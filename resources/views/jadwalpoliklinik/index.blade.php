<!-- index.blade.php -->
@extends('layout.admin')

@section('title', 'Jadwal Poliklinik')

@section('content')
<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">Data Jadwal Poliklinik</h1>

<!-- Date Range Filter -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Cari Berdasarkan Tanggal</h6>
    </div>
    <div class="card-body">
        <form action="{{ route('jadwalpoliklinik.index') }}" method="GET" class="row">
            <div class="col-md-4 mb-3">
                <label for="start_date">Dari Tanggal</label>
                <div class="input-group">
                    <input type="date" class="form-control" id="start_date" name="start_date" value="{{ request()->input('start_date') }}">
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <label for="end_date">Sampai Tanggal</label>
                <div class="input-group">
                    <input type="date" class="form-control" id="end_date" name="end_date" value="{{ request()->input('end_date') }}">
                </div>
            </div>
            <div class="col-md-4 mb-3 d-flex align-items-end">
                <button type="submit" class="btn btn-primary btn-sm mr-1"><i class="fas fa-search"></i> Search</button>
                <a href="{{ route('jadwalpoliklinik.index') }}" class="btn btn-secondary btn-sm"><i class="fas fa-sync-alt"></i> Refresh</a>
            </div>
        </form>
    </div>
</div>

<!-- DataTables Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <a href="{{ route('jadwalpoliklinik.create') }}" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Tambah</a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode</th>
                        <th>Nama Dokter</th>
                        <th>Nama Poliklinik</th>
                        <th>Profil Dokter</th>
                        <th>Tanggal Praktek</th>
                        <th>Jam Praktek</th>
                        <th>Jumlah</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @php $no = 1; @endphp
                    @foreach ($jadwalpoliklinik as $item)
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $item->kode }}</td>
                        <td>{{ $item->dokter->nama_dokter }}</td>
                        <td>{{ $item->dokter->poliklinik->nama_poliklinik }}</td>
                        <td>
                            @if($item->dokter && $item->dokter->foto_dokter)
                                <img src="{{ asset('storage/foto_dokter/' . $item->dokter->foto_dokter) }}" alt="Foto Dokter" width="50" height="50">
                            @else
                                <span>No photo available</span>
                            @endif
                        </td>
                        <td>{{ $item->tanggal_praktek }}</td>
                        <td>{{ $item->jam_mulai }} - {{ $item->jam_selesai }}</td>
                        <td>{{ $item->jumlah }}</td>
                        <td>
                            <a href="{{ route('jadwalpoliklinik.edit', $item->id) }}" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i> Edit</a>
                            <form action="{{ route('jadwalpoliklinik.destroy', $item->id) }}" method="POST" class="d-inline delete-form">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm btn-delete">Hapus</button>
                        </form>
                        </td>
                    </tr>
                    @endforeach
                    @include('sweetalert::alert')
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Sertakan SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<!-- Sertakan file JavaScript khusus -->
<script src="{{ asset('js/sweetalert.js') }}"></script>
@endsection