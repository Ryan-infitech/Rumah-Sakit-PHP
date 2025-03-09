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
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                @if(isset($dashboardData['jadwalBerikutnya']))
                                    {{ $dashboardData['jadwalBerikutnya']->tanggal_berobat->format('d M Y') }}
                                @else
                                    Belum Ada Jadwal
                                @endif
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar-alt fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md=6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Kunjungan</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $dashboardData['totalKunjungan'] }} Kali</div>
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
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $dashboardData['totalResep'] }} Resep</div>
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
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                @if($dataPasien)
                                    Aktif
                                @else
                                    Belum Lengkap
                                @endif
                            </div>
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
                    <a href="{{ route('Pendaftaran.index') }}" class="btn btn-primary btn-sm">
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
                                @forelse($dashboardData['upcomingAppointments'] as $appointment)
                                <tr>
                                    <td>{{ $appointment->tanggal_berobat->format('d/m/Y') }}</td>
                                    <td>{{ $appointment->nama_dokter }}</td>
                                    <td>{{ $appointment->poliklinik }}</td>
                                    <td>
                                        @if($appointment->status == 'menunggu')
                                            <span class="badge badge-warning">Menunggu</span>
                                        @elseif($appointment->status == 'diproses')
                                            <span class="badge badge-info">Sedang Diproses</span>
                                        @else
                                            <span class="badge badge-secondary">{{ $appointment->status }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('generate.antrian', $appointment->id) }}" class="btn btn-primary btn-sm">
                                            <i class="fas fa-print fa-sm"></i> Cetak
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center">Belum ada jadwal pemeriksaan</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Available Schedules Section -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Jadwal Poliklinik Tersedia (7 Hari Kedepan)</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="availableScheduleTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Poliklinik</th>
                                    <th>Dokter</th>
                                    <th>Jam</th>
                                    <th>Kuota</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($dashboardData['availableSchedules'] as $schedule)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($schedule->tanggal_praktek)->format('d/m/Y') }}</td>
                                    <td>{{ $schedule->poliklinik->nama_poliklinik }}</td>
                                    <td>{{ $schedule->dokter->nama_dokter }}</td>
                                    <td>{{ \Carbon\Carbon::parse($schedule->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($schedule->jam_selesai)->format('H:i') }}</td>
                                    <td>{{ $schedule->jumlah }}</td>
                                    <td>
                                        <button class="btn btn-success btn-sm" data-toggle="modal" data-target="#pendaftaranModal" 
                                                data-id="{{ $schedule->id }}">Daftar</button>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center">Tidak ada jadwal tersedia dalam 7 hari kedepan</td>
                                </tr>
                                @endforelse
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
                    <a href="{{ route('Pendaftaran.index') }}" class="btn btn-primary btn-icon-split btn-block mb-3">
                        <span class="icon text-white-50">
                            <i class="fas fa-calendar-plus"></i>
                        </span>
                        <span class="text">Buat Janji Periksa</span>
                    </a>
                    <a href="{{ route('antrian.index2') }}" class="btn btn-info btn-icon-split btn-block mb-3">
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
                             src="{{ asset('https://cdn.dribbble.com/users/3419046/screenshots/9149627/farm-800x600.gif') }}" alt="Health Info">
                    </div>
                    <p>Jaga kesehatan Anda dengan mengikuti pola makan sehat, olahraga teratur, dan istirahat yang cukup.</p>
                    <a href="#" class="btn btn-link btn-sm">Baca tips kesehatan &rarr;</a>
                </div>
            </div>

            <!-- Data Status -->
            @if(!$dataPasien)
            <div class="card shadow mb-4 border-left-danger">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Perhatian!</div>
                    <div class="mb-2">Data pribadi anda belum lengkap. Silahkan lengkapi data pribadi anda.</div>
                    <a href="{{ route('pasien.create') }}" class="btn btn-danger btn-sm btn-block">Lengkapi Data</a>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Modal Pendaftaran (reuse from Pendaftaran page) -->
<div class="modal fade" id="pendaftaranModal" tabindex="-1" role="dialog" aria-labelledby="pendaftaranModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="pendaftaranModalLabel">Form Pendaftaran Rawat Jalan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="pendaftaranForm" action="{{ route('Pendaftaran.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="jadwalpoliklinik_id" id="jadwalpoliklinik_id">
                    
                    <div class="form-group">
                        <label for="penjamin">Penjamin:</label>
                        <select name="penjamin" id="penjamin" class="form-control" required onchange="toggleSuratRujukan()">
                            <option value="">Pilih Penjamin</option>
                            <option value="UMUM">UMUM</option>
                            <option value="BPJS">BPJS</option>
                            <option value="Asuransi">Asuransi</option>
                        </select>
                    </div>
                    
                    <div class="form-group" id="scan_surat_rujukan_group" style="display: none;">
                        <label for="scan_surat_rujukan">Scan Surat Rujukan:</label>
                        <input type="file" name="scan_surat_rujukan" id="scan_surat_rujukan" class="form-control">
                    </div>
                    
                    <div class="form-group text-center">
                        <button type="submit" class="btn btn-primary">Daftar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<!-- Custom script for dashboard -->
<script>
    $(document).ready(function() {
        // Initialize datatables
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
        
        $('#availableScheduleTable').DataTable({
            "language": {
                "emptyTable": "Tidak ada jadwal tersedia dalam 7 hari kedepan"
            },
            "paging": true,
            "lengthChange": false,
            "searching": false,
            "ordering": true,
            "info": false,
            "autoWidth": false
        });
    });
    
    // Handle modal for registration
    $('#pendaftaranModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget)
        var jadwalpoliklinikId = button.data('id')
        var modal = $(this)
        modal.find('#jadwalpoliklinik_id').val(jadwalpoliklinikId)
    })
    
    function toggleSuratRujukan() {
        var penjamin = document.getElementById('penjamin').value;
        var suratRujukanGroup = document.getElementById('scan_surat_rujukan_group');
        
        if (penjamin === 'BPJS') {
            suratRujukanGroup.style.display = 'block';
        } else {
            suratRujukanGroup.style.display = 'none';
        }
    }
</script>
@endpush
