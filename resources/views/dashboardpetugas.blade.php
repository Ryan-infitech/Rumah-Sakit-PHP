@extends('layout.petugas')

@section('title', 'Dashboard Petugas')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard Petugas</h1>
        <div>
            <span class="badge badge-primary p-2">{{ now()->format('l, d F Y') }}</span>
            <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm ml-2">
                <i class="fas fa-download fa-sm text-white-50"></i> Generate Laporan
            </a>
        </div>
    </div>

    <!-- Content Row -->
    <div class="row">
        <!-- Antrian Hari Ini Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Antrian Hari Ini</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalAntrian ?? '0' }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sudah Dilayani Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Sudah Dilayani</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $dilayani ?? '0' }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Menunggu Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Menunggu</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $menunggu ?? '0' }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clock fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Diproses Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Sedang Diproses</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $diproses ?? '0' }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-spinner fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Row -->
    <div class="row">
        <!-- Antrian Table (Active: Waiting + Processing) -->
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Antrian Aktif Hari Ini</h6>
                    <a href="{{ route('petugas.antrian') }}" class="btn btn-sm btn-primary shadow-sm">
                        <i class="fas fa-eye fa-sm text-white-50"></i> Lihat Semua
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="antrianTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>No. Antrian</th>
                                    <th>Nama Pasien</th>
                                    <th>Poli</th>
                                    <th>Dokter</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($antrian as $item)
                                <tr>
                                    <td>{{ $item['no_antrian'] }}</td>
                                    <td>{{ $item['nama_pasien'] }}</td>
                                    <td>{{ $item['poli'] }}</td>
                                    <td>{{ $item['dokter'] }}</td>
                                    <td>
                                        @if($item['status'] == 'Menunggu')
                                            <span class="badge badge-warning">Menunggu</span>
                                        @elseif($item['status'] == 'Diproses')
                                            <span class="badge badge-info">Diproses</span>
                                        @else
                                            <span class="badge badge-secondary">{{ $item['status'] }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($item['status'] == 'Menunggu')
                                            <form action="{{ route('petugas.proses-antrian', $item['id']) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-info">
                                                    <i class="fas fa-play fa-sm"></i> Proses
                                                </button>
                                            </form>
                                        @elseif($item['status'] == 'Diproses')
                                            <form action="{{ route('petugas.selesai-antrian', $item['id']) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-success">
                                                    <i class="fas fa-check fa-sm"></i> Selesai
                                                </button>
                                            </form>
                                        @endif
                                        <a href="{{ route('generate.antrian', $item['id']) }}" class="btn btn-sm btn-danger">
                                            <i class="fas fa-print fa-sm"></i> Cetak
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center">Tidak ada antrian aktif saat ini</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Completed Appointments Section (NEW) -->
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-success">Pasien Telah Dilayani Hari Ini</h6>
                    <a href="{{ route('petugas.riwayat-antrian') }}" class="btn btn-sm btn-success shadow-sm">
                        <i class="fas fa-history fa-sm text-white-50"></i> Lihat Riwayat
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="antrianSelesaiTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>No. Antrian</th>
                                    <th>Nama Pasien</th>
                                    <th>Poli</th>
                                    <th>Dokter</th>
                                    <th>Waktu Selesai</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($antrianSelesai ?? [] as $item)
                                <tr>
                                    <td>{{ $item['no_antrian'] }}</td>
                                    <td>{{ $item['nama_pasien'] }}</td>
                                    <td>{{ $item['poli'] }}</td>
                                    <td>{{ $item['dokter'] }}</td>
                                    <td>{{ $item['waktu_selesai'] }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center">Belum ada pasien yang telah dilayani hari ini</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Access Cards -->
        <div class="col-lg-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Menu Cepat</h6>
                </div>
                <div class="card-body">
                    <a href="{{ route('pasien.create') }}" class="btn btn-success btn-icon-split btn-lg btn-block mb-3">
                        <span class="icon text-white-50">
                            <i class="fas fa-user-plus"></i>
                        </span>
                        <span class="text">Daftar Pasien Baru</span>
                    </a>
                    <a href="{{ route('petugas.antrian') }}" class="btn btn-info btn-icon-split btn-lg btn-block mb-3">
                        <span class="icon text-white-50">
                            <i class="fas fa-list-ol"></i>
                        </span>
                        <span class="text">Kelola Antrian</span>
                    </a>
                    <a href="{{ route('petugas.rekam-medis') }}" class="btn btn-primary btn-icon-split btn-lg btn-block mb-3">
                        <span class="icon text-white-50">
                            <i class="fas fa-file-medical"></i>
                        </span>
                        <span class="text">Rekam Medis</span>
                    </a>
                    <a href="{{ route('pasien.index') }}" class="btn btn-secondary btn-icon-split btn-lg btn-block">
                        <span class="icon text-white-50">
                            <i class="fas fa-users"></i>
                        </span>
                        <span class="text">Data Pasien</span>
                    </a>
                </div>
            </div>

            <!-- System Info Card -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Informasi Sistem</h6>
                </div>
                <div class="card-body">
                    <div class="text-center mb-3">
                        <img class="img-fluid px-3 px-sm-4 mt-3 mb-4" style="width: 8rem;" 
                            src="{{ asset('https://cdnl.iconscout.com/lottie/premium/thumb/hospital-building-animation-download-in-lottie-json-gif-static-svg-file-formats--patient-room-emergency-office-medical-and-healthy-pack-healthcare-animations-4709608.gif') }}" alt="Hospital Logo">
                    </div>
                    <div class="mb-2">
                        <span class="font-weight-bold">Jam Sistem:</span> 
                        <span id="time">{{ now()->format('H:i:s') }}</span>
                    </div>
                    <div class="mb-2">
                        <span class="font-weight-bold">Status Server:</span> 
                        <span class="badge badge-success">Online</span>
                    </div>
                    <div class="mb-2">
                        <span class="font-weight-bold">Versi Aplikasi:</span> 1.0.0
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        // Update clock every second
        setInterval(function() {
            var date = new Date();
            var time = date.toLocaleTimeString('id-ID');
            $('#time').text(time);
        }, 1000);

        // Initialize DataTables if there are records
        if ($('#antrianTable tbody tr').length > 1 || 
           ($('#antrianTable tbody tr').length == 1 && 
            $('#antrianTable tbody tr td').length > 1)) {
            $('#antrianTable').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "language": {
                    "emptyTable": "Tidak ada antrian aktif saat ini"
                }
            });
        }

        // Initialize DataTable for completed appointments
        if ($('#antrianSelesaiTable tbody tr').length > 1 || 
           ($('#antrianSelesaiTable tbody tr').length == 1 && 
            $('#antrianSelesaiTable tbody tr td').length > 1)) {
            $('#antrianSelesaiTable').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "language": {
                    "emptyTable": "Belum ada pasien yang telah dilayani hari ini"
                }
            });
        }
    });
</script>
@endpush
