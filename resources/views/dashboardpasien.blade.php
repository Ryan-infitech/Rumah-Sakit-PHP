@extends('layout.pasien')

@section('title', 'Dashboard Pasien')

@section('content')
<div class="container-fluid">
    <!-- Welcome Message -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard Pasien</h1>
        <small class="text-muted">Selamat datang, {{ Auth::user()->name ?? 'Pasien' }}!</small>
    </div>

    <!-- Info Cards -->
    <div class="row">
        <div class="col-xl-6 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Jadwal Periksa Berikutnya</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">25 Juli 2023</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar-alt fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-6 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Kunjungan</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">5 Kali</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clinic-medical fa-2x text-gray-300"></i>
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
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Jadwal Periksa Mendatang</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Dokter</th>
                                    <th>Poli</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Data jadwal akan ditampilkan di sini -->
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
                    <a href="#" class="btn btn-primary btn-block mb-3">
                        <i class="fas fa-calendar-plus mr-2"></i>Buat Janji Periksa
                    </a>
                    <a href="#" class="btn btn-info btn-block mb-3">
                        <i class="fas fa-history mr-2"></i>Lihat Riwayat
                    </a>
                    <a href="#" class="btn btn-success btn-block">
                        <i class="fas fa-user-edit mr-2"></i>Update Profil
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
