@extends('layout.petugas')

@section('title', 'Riwayat Antrian')

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Riwayat Antrian</h1>
    <div>
        <a href="{{ route('petugas.antrian') }}" class="btn btn-sm btn-primary">
            <i class="fas fa-arrow-left"></i> Kembali ke Antrian
        </a>
    </div>
</div>

<!-- Date Filter -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Filter Tanggal</h6>
    </div>
    <div class="card-body">
        <form action="{{ route('petugas.riwayat-antrian') }}" method="GET" class="form-inline">
            <div class="form-group mb-2">
                <label for="date" class="mr-2">Pilih Tanggal:</label>
                <input type="date" class="form-control" id="date" name="date" value="{{ $date }}">
            </div>
            <button type="submit" class="btn btn-primary ml-2 mb-2">Filter</button>
        </form>
    </div>
</div>

<!-- History Table -->
<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold text-primary">Daftar Pasien Terlayani - {{ \Carbon\Carbon::parse($date)->format('d F Y') }}</h6>
        <div>
            <a href="#" class="btn btn-sm btn-success" id="exportButton">
                <i class="fas fa-file-export"></i> Export
            </a>
            <a href="#" class="btn btn-sm btn-info" id="printButton">
                <i class="fas fa-print"></i> Cetak
            </a>
        </div>
    </div>
    <div class="card-body">
        @if(count($riwayat) > 0)
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No. Antrian</th>
                        <th>Nama Pasien</th>
                        <th>Poliklinik</th>
                        <th>Dokter</th>
                        <th>Waktu Selesai</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($riwayat as $item)
                    <tr>
                        <td>{{ $item['no_antrian'] }}</td>
                        <td>{{ $item['nama_pasien'] }}</td>
                        <td>{{ $item['poli'] }}</td>
                        <td>{{ $item['dokter'] }}</td>
                        <td>{{ $item['waktu_selesai'] }}</td>
                        <td>
                            <span class="badge badge-success">{{ $item['status'] }}</span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="text-center py-5">
            <i class="fas fa-history fa-3x text-gray-300 mb-3"></i>
            <p class="text-gray-600">Tidak ada data riwayat antrian untuk tanggal ini.</p>
        </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Initialize DataTables
    $('#dataTable').DataTable();
    
    // Print button functionality
    $('#printButton').click(function(e) {
        e.preventDefault();
        window.print();
    });
    
    // Export button (placeholder functionality)
    $('#exportButton').click(function(e) {
        e.preventDefault();
        Swal.fire({
            title: 'Export Data',
            text: 'Data akan diexport ke Excel',
            icon: 'info',
            showCancelButton: true,
            confirmButtonText: 'Ya, Export',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire(
                    'Exported!',
                    'Data berhasil diexport.',
                    'success'
                );
            }
        });
    });
});
</script>
@endpush
