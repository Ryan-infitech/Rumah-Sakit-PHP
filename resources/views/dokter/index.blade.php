<!-- dokter.indext.blade.php -->
 
@extends(Auth::user()->roles == 'admin' ? 'layout.admin' : 'layout.petugas')

@section('title', 'Data Dokter')

@section('content')
<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">Data Dokter</h1>

@if(session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif

<!-- DataTables Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <a href="{{ route('dokter.create') }}" class="btn btn-primary">Tambah Data</a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Foto</th>
                        <th>Nama Dokter</th>
                        <th>Poliklinik</th>
                        <th>Rating</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @php $no = 1; @endphp
                    @foreach ($dokter as $item)
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>
                            <img src="{{ asset('storage/foto_dokter/' . $item->foto_dokter) }}" 
                                alt="Foto {{ $item->nama_dokter }}" width="100">
                        </td>
                        <td>{{ $item->nama_dokter }}</td>
                        <td>{{ $item->poliklinik->nama_poliklinik }}</td>
                        <td>
                            <!-- Rating display -->
                            <div class="ratings">
                                @if(isset($dokterRatings[$item->id]))
                                    @php 
                                        $rating = $dokterRatings[$item->id]; 
                                        $fullStars = floor($rating);
                                        $halfStar = $rating - $fullStars > 0.3 ? 1 : 0;
                                        $emptyStars = 5 - $fullStars - $halfStar;
                                    @endphp
                                    
                                    @for($i = 0; $i < $fullStars; $i++)
                                        <i class="fas fa-star text-warning"></i>
                                    @endfor
                                    
                                    @if($halfStar)
                                        <i class="fas fa-star-half-alt text-warning"></i>
                                    @endif
                                    
                                    @for($i = 0; $i < $emptyStars; $i++)
                                        <i class="far fa-star text-warning"></i>
                                    @endfor
                                    
                                    <span class="ml-1">({{ number_format($rating, 1) }})</span>
                                @else
                                    <span class="text-muted">Belum ada rating</span>
                                @endif
                            </div>
                        </td>
                        <td>
                            <a href="{{ route('dokter.show', $item->id) }}" class="btn btn-info btn-sm"><i class="fas fa-eye"></i></a>
                            <a href="{{ route('dokter.edit', $item->id) }}" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></a>
                            <form action="{{ route('dokter.destroy', $item->id) }}" method="POST" style="display: inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#dataTable').DataTable();
    });
</script>
@endpush