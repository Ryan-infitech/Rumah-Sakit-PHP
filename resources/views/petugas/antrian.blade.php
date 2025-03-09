@extends('layout.petugas')

@section('title', 'Antrian Hari Ini')

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Antrian Hari Ini</h1>
    <div>
        <span class="badge badge-primary p-2 mr-2">{{ now()->format('l, d F Y') }}</span>
        <a href="{{ route('petugas.riwayat-antrian') }}" class="btn btn-sm btn-secondary">
            <i class="fas fa-history"></i> Riwayat Antrian
        </a>
    </div>
</div>

<!-- Status Counts -->
<div class="row">
    <!-- Menunggu Card -->
    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Menunggu</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{ isset($antrian) ? count(array_filter($antrian, function($item) { return $item['status'] == 'Menunggu'; })) : '0' }}
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-clock fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Diproses Card -->
    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Diproses</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{ isset($antrian) ? count(array_filter($antrian, function($item) { return $item['status'] == 'Diproses'; })) : '0' }}
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-spinner fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Total Card -->
    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Antrian Aktif</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ isset($antrian) ? count($antrian) : '0' }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-users fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold text-primary">Daftar Antrian Aktif</h6>
        <div>
            <a href="#" class="btn btn-sm btn-success" id="refreshButton">
                <i class="fas fa-sync-alt"></i> Refresh
            </a>
        </div>
    </div>
    <div class="card-body">
        @if(count($antrian) > 0)
        <div class="table-responsive">
            <table class="table table-striped" id="dataTable">
                <thead>
                    <tr>
                        <th>No. Antrian</th>
                        <th>Nama Pasien</th>
                        <th>Poliklinik</th>
                        <th>Dokter</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($antrian as $item)
                    <tr>
                        <td>{{ $item['no_antrian'] }}</td>
                        <td>{{ $item['nama_pasien'] }}</td>
                        <td>{{ $item['poli'] }}</td>
                        <td>{{ $item['dokter'] }}</td>
                        <td>
                            <span class="badge 
                                @if($item['status'] == 'Menunggu') badge-warning 
                                @elseif($item['status'] == 'Diproses') badge-info
                                @elseif($item['status'] == 'Dilayani') badge-success
                                @endif">
                                {{ $item['status'] }}
                            </span>
                        </td>
                        <td>
                            @if($item['status'] == 'Menunggu')
                            <form action="{{ route('petugas.proses-antrian', $item['id']) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-info">Proses</button>
                            </form>
                            @elseif($item['status'] == 'Diproses')
                            <form action="{{ route('petugas.selesai-antrian', $item['id']) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-success">Selesai</button>
                            </form>
                            @endif
                            <a href="{{ route('generate.antrian', $item['id']) }}" class="btn btn-sm btn-danger">
                                <i class="fas fa-print fa-sm"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="text-center py-5">
            <i class="fas fa-clipboard-list fa-3x text-gray-300 mb-3"></i>
            <p class="text-gray-600">Tidak ada antrian aktif untuk saat ini.</p>
        </div>
        @endif
    </div>
</div>

<!-- Recently Completed Section (NEW) -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-success">Pasien Baru Selesai Dilayani</h6>
    </div>
    <div class="card-body">
        @if(isset($antrianSelesai) && count($antrianSelesai) > 0)
        <div class="table-responsive">
            <table class="table table-striped" id="completedTable">
                <thead>
                    <tr>
                        <th>No. Antrian</th>
                        <th>Nama Pasien</th>
                        <th>Poliklinik</th>
                        <th>Dokter</th>
                        <th>Waktu Selesai</th>
                        <th>Cetak</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($antrianSelesai ?? [] as $item)
                    <tr>
                        <td>{{ $item['no_antrian'] }}</td>
                        <td>{{ $item['nama_pasien'] }}</td>
                        <td>{{ $item['poli'] }}</td>
                        <td>{{ $item['dokter'] }}</td>
                        <td>{{ $item['waktu_selesai'] }}</td>
                        <td>
                            <a href="{{ route('generate.antrian', $item['id']) }}" class="btn btn-sm btn-danger">
                                <i class="fas fa-print fa-sm"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="text-center py-4">
            <i class="fas fa-check-circle fa-3x text-gray-300 mb-3"></i>
            <p class="text-gray-600">Belum ada pasien yang selesai dilayani hari ini.</p>
        </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Initialize DataTable
    $('#dataTable').DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": true,
    });
    
    // Initialize DataTable for completed appointments if they exist
    if ($('#completedTable tbody tr').length > 0) {
        $('#completedTable').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
        });
    }
    
    // Refresh button
    $('#refreshButton').click(function(e) {
        e.preventDefault();
        location.reload();
    });
    
    // Auto refresh every 30 seconds
    setInterval(function() {
        location.reload();
    }, 30000);
});
</script>
@endpush
