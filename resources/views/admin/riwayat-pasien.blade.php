@extends('layout.admin')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Data Histori Pasien</h1>
        <div>
            <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" id="exportBtn">
                <i class="fas fa-download fa-sm text-white-50"></i> Export Data
            </a>
        </div>
    </div>

    <!-- Filter Card -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Filter Data</h6>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('admin.riwayat-pasien') }}" id="filter-form">
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <label for="search">Cari:</label>
                        <input type="text" class="form-control" id="search" name="search" value="{{ request('search') }}" placeholder="Nama pasien/dokter...">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="start_date">Tanggal Mulai:</label>
                        <input type="date" class="form-control" id="start_date" name="start_date" value="{{ request('start_date') }}">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="end_date">Tanggal Akhir:</label>
                        <input type="date" class="form-control" id="end_date" name="end_date" value="{{ request('end_date') }}">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="poliklinik">Poliklinik:</label>
                        <select class="form-control" id="poliklinik" name="poliklinik">
                            <option value="">-- Semua Poliklinik --</option>
                            @foreach($polikliniks as $poli)
                                <option value="{{ $poli->id }}" {{ request('poliklinik') == $poli->id ? 'selected' : '' }}>
                                    {{ $poli->nama_poliklinik }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="dokter">Dokter:</label>
                        <select class="form-control" id="dokter" name="dokter">
                            <option value="">-- Semua Dokter --</option>
                            @foreach($dokters as $dr)
                                <option value="{{ $dr->id }}" {{ request('dokter') == $dr->id ? 'selected' : '' }}>
                                    {{ $dr->nama_dokter }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3 mb-3 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary mr-2">
                            <i class="fas fa-search"></i> Filter
                        </button>
                        <a href="{{ route('admin.riwayat-pasien') }}" class="btn btn-secondary">
                            <i class="fas fa-sync"></i> Reset
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Data Table -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Data Kunjungan Pasien</h6>
            <span class="badge badge-success">Total: {{ $riwayatPasien->total() }} rekaman</span>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode Kunjungan</th>
                            <th>Nama Pasien</th>
                            <th>Poliklinik</th>
                            <th>Dokter</th>
                            <th>Tanggal</th>
                            <th>Waktu Mulai</th>
                            <th>Waktu Selesai</th>
                            <th>Durasi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($riwayatPasien as $index => $riwayat)
                            <tr>
                                <td>{{ ($riwayatPasien->currentPage() - 1) * $riwayatPasien->perPage() + $index + 1 }}</td>
                                <td>{{ $riwayat->kode_kunjungan }}</td>
                                <td>{{ $riwayat->nama_pasien }}</td>
                                <td>{{ $riwayat->poliklinik }}</td>
                                <td>{{ $riwayat->nama_dokter }}</td>
                                <td>{{ $riwayat->tanggal_kunjungan->format('d/m/Y') }}</td>
                                <td>{{ $riwayat->waktu_mulai ? $riwayat->waktu_mulai->format('H:i:s') : '-' }}</td>
                                <td>{{ $riwayat->waktu_selesai ? $riwayat->waktu_selesai->format('H:i:s') : '-' }}</td>
                                <td>{{ $riwayat->durasi_pelayanan ?? '-' }} menit</td>
                                <td>
                                    <button class="btn btn-sm btn-info view-details" data-id="{{ $riwayat->id }}">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="text-center">Tidak ada data kunjungan pasien</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <div class="mt-4">
                {{ $riwayatPasien->links() }}
            </div>
        </div>
    </div>
</div>

<!-- Details Modal -->
<div class="modal fade" id="detailsModal" tabindex="-1" aria-labelledby="detailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailsModalLabel">Detail Kunjungan Pasien</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-4">
                    <div class="spinner-border text-primary" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>
                <div id="modalContent"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary print-details">Cetak</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        // Check if DataTable is already initialized before initializing
        if (!$.fn.DataTable.isDataTable('#dataTable')) {
            $('#dataTable').DataTable({
                "paging": false,
                "info": false,
                "responsive": true,
                "searching": false,
                "language": {
                    "emptyTable": "Tidak ada data kunjungan pasien"
                }
            });
        }
        
        // View details
        $('.view-details').on('click', function() {
            const id = $(this).data('id');
            $('#modalContent').html('');
            $('.spinner-border').show();
            
            $.ajax({
                url: '/admin/riwayat-pasien/' + id,
                type: 'GET',
                success: function(response) {
                    $('.spinner-border').hide();
                    $('#modalContent').html(response);
                    $('#detailsModal').modal('show');
                },
                error: function(xhr) {
                    $('.spinner-border').hide();
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Failed to load patient details'
                    });
                }
            });
        });
        
        // Print details
        $('.print-details').on('click', function() {
            const content = document.getElementById('modalContent').innerHTML;
            const printWindow = window.open('', '', 'height=600,width=800');
            
            printWindow.document.write('<html><head><title>Detail Kunjungan Pasien</title>');
            printWindow.document.write('<link rel="stylesheet" href="{{ asset("template/css/sb-admin-2.min.css") }}">');
            printWindow.document.write('</head><body>');
            printWindow.document.write(content);
            printWindow.document.write('</body></html>');
            
            printWindow.document.close();
            printWindow.focus();
            
            setTimeout(function() {
                printWindow.print();
                printWindow.close();
            }, 1000);
        });
        
        // Export to Excel
        $('#exportBtn').on('click', function(e) {
            e.preventDefault();
            window.location.href = '{{ route("admin.riwayat-pasien.export") }}?' + $('#filter-form').serialize();
        });
    });
</script>
@endpush
