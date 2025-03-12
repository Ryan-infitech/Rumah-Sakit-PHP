@extends('layout.pasien')

@section('title', 'Jadwal Periksa')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Jadwal Periksa</h1>
    </div>

    <!-- Filter Card -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Filter Jadwal</h6>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('pasien.jadwal-periksa') }}">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="poliklinik">Poliklinik:</label>
                            <select class="form-control" id="poliklinik" name="poliklinik">
                                <option value="">Semua Poliklinik</option>
                                @foreach($polikliniks as $poli)
                                <option value="{{ $poli->id }}" {{ request('poliklinik') == $poli->id ? 'selected' : '' }}>
                                    {{ $poli->nama_poliklinik }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="dokter">Dokter:</label>
                            <select class="form-control" id="dokter" name="dokter">
                                <option value="">Semua Dokter</option>
                                @foreach($dokters as $dokter)
                                <option value="{{ $dokter->id }}" {{ request('dokter') == $dokter->id ? 'selected' : '' }}>
                                    {{ $dokter->nama_dokter }} - {{ $dokter->poliklinik->nama_poliklinik }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary mr-2">
                            <i class="fas fa-search"></i> Filter
                        </button>
                        <a href="{{ route('pasien.jadwal-periksa') }}" class="btn btn-secondary">
                            <i class="fas fa-sync"></i> Reset
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Available Schedules -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Jadwal Poliklinik Tersedia (7 Hari Kedepan)</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="jadwalTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Hari</th>
                            <th>Poliklinik</th>
                            <th>Dokter</th>
                            <th>Jam</th>
                            <th>Kuota</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($jadwalPoliklinik as $jadwal)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($jadwal->tanggal_praktek)->format('d/m/Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($jadwal->tanggal_praktek)->locale('id')->dayName }}</td>
                            <td>{{ $jadwal->poliklinik->nama_poliklinik }}</td>
                            <td>{{ $jadwal->dokter->nama_dokter }}</td>
                            <td>{{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i') }}</td>
                            <td>{{ $jadwal->jumlah }}</td>
                            <td>
                                <button class="btn btn-success btn-sm" data-toggle="modal" data-target="#pendaftaranModal" 
                                        data-id="{{ $jadwal->id }}">Daftar</button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center">Tidak ada jadwal tersedia dalam 7 hari kedepan</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Pendaftaran -->
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
<script>
    $(document).ready(function() {
        // Initialize DataTable
        $('#jadwalTable').DataTable({
            "responsive": true,
            "language": {
                "emptyTable": "Tidak ada jadwal tersedia dalam 7 hari kedepan"
            }
        });
        
        // Handle modal for registration
        $('#pendaftaranModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var jadwalpoliklinikId = button.data('id');
            var modal = $(this);
            modal.find('#jadwalpoliklinik_id').val(jadwalpoliklinikId);
        });
    });
    
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
