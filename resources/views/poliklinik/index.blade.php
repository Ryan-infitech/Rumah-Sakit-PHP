<!-- index.blade.php -->
@extends('layout.admin')

@section('title', 'Poliklinik')

@section('content')
<!-- Page Heading -->
 <h1 class="h3 mb-2 text-gray-800">Data Poliklinik</h1>

 <!-- DataTales Example -->
  <div class="card shadow mb-4">
    <div class="card-header py-3">
        <a href="{{ route('poliklinik.create') }}" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Tambah</a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Poliklinik</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @php $no = 1; @endphp
                    @foreach ($poliklinik as $item)
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $item->nama_poliklinik }}</td>
                        <td>
                            <a href="{{ route('poliklinik.edit', $item->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('poliklinik.destroy', $item->id) }}" method="POST" class="d-inline delete-form">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-danger btn-sm btn-delete">Hapus</button>
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