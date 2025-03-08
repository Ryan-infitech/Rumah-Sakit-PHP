@extends('layout.pasien')

@section('title', 'Dashboard Pasien')

@section('content')
<div class="container-fluid">
    <!-- Welcome Message -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
        <small class="text-muted">Selamat datang, {{ Auth::user()->nama_user }}!</small>
    </div>

    <!-- Statistics Cards -->
    <div class="row">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Jadwal Periksa Berikutnya</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">Belum Ada Jadwal</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar-alt fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Kunjungan</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">0 Kali</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clinic-medical fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Resep Obat</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">0 Resep</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-prescription-bottle-alt fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Status</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">Aktif</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-check fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions & Upcoming Appointments -->
    <div class="row">
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Jadwal Periksa Mendatang</h6>
                    <a href="#" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus fa-sm"></i> Buat Janji
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Dokter</th>
                                    <th>Poliklinik</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td colspan="5" class="text-center">Belum ada jadwal pemeriksaan</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Menu Cepat</h6>
                </div>
                <div class="card-body">
                    <a href="#" class="btn btn-primary btn-icon-split btn-block mb-3">
                        <span class="icon text-white-50">
                            <i class="fas fa-calendar-plus"></i>
                        </span>
                        <span class="text">Buat Janji Periksa</span>
                    </a>
                    <a href="#" class="btn btn-info btn-icon-split btn-block mb-3">
                        <span class="icon text-white-50">
                            <i class="fas fa-history"></i>
                        </span>
                        <span class="text">Lihat Riwayat Pemeriksaan</span>
                    </a>
                    <a href="{{ route('pasien.show', Auth::user()->datapasien ? Auth::user()->datapasien->id : 'create') }}" class="btn btn-warning btn-icon-split btn-block mb-3">
                        <span class="icon text-white-50">
                            <i class="fas fa-user-circle"></i>
                        </span>
                        <span class="text">Lihat Data Pribadi</span>
                    </a>
                    <a href="{{ route('profile.index') }}" class="btn btn-success btn-icon-split btn-block">
                        <span class="icon text-white-50">
                            <i class="fas fa-user-edit"></i>
                        </span>
                        <span class="text">Update Profil</span>
                    </a>
                </div>
            </div>

            <!-- Informasi Kesehatan Card -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Info Kesehatan</h6>
                </div>
                <div class="card-body">
                    <div class="text-center mb-3">
                        <img class="img-fluid px-3 px-sm-4 mt-3 mb-4" style="width: 15rem;" 
                             src="{{ asset('https://blogimages.softwaresuggest.com/blog/wp-content/uploads/2023/07/26182948/What-is-Health-Information-Technology-Types-Examples.jpg') }}" alt="Health Info">
                    </div>
                    <p>Jaga kesehatan Anda dengan mengikuti pola makan sehat, olahraga teratur, dan istirahat yang cukup.</p>
                    <a href="#" class="btn btn-link btn-sm">Baca tips kesehatan &rarr;</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<!-- Custom script for dashboard -->
<script>
    $(document).ready(function() {
        // Initialize any dashboard-specific JS here
        $('#dataTable').DataTable({
            "language": {
                "emptyTable": "Belum ada jadwal pemeriksaan"
            },
            "paging": true,
            "lengthChange": false,
            "searching": false,
            "ordering": true,
            "info": false,
            "autoWidth": false
        });
    });
</script>
@endpush
