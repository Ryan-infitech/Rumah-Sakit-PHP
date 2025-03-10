@extends('layout.admin')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Riwayat Kunjungan</h1>
        <div class="d-flex align-items-center">
            <form action="{{ route('admin.riwayat-antrian') }}" method="GET" class="form-inline mr-auto ml-md-3 my-2 my-md-0">
                <div class="input-group">
                    <input type="date" class="form-control" name="date" value="{{ $date ?? '' }}">
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="submit">
                            <i class="fas fa-search fa-sm"></i> Filter
                        </button>
                    </div>
                </div>
            </form>
            <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm ml-2" onclick="printData()">
                <i class="fas fa-download fa-sm text-white-50"></i> Generate Report
            </a>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="row">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Kunjungan</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $summary['total'] ?? 0 }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
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
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Selesai Dilayani</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $summary['dilayani'] ?? 0 }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-check-circle fa-2x text-gray-300"></i>
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
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Sedang Diproses</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $summary['diproses'] ?? 0 }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-spinner fa-2x text-gray-300"></i>
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
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Menunggu</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $summary['menunggu'] ?? 0 }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clock fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Appointments Table -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Kunjungan Pasien - {{ \Carbon\Carbon::parse($date)->format('d/m/Y') }}</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No. Antrian</th>
                            <th>Nama Pasien</th>
                            <th>Poliklinik</th>
                            <th>Dokter</th>
                            <th>Waktu Mulai</th>
                            <th>Waktu Selesai</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($riwayat as $item)
                        <tr>
                            <td>{{ $item['no_antrian'] }}</td>
                            <td>{{ $item['nama_pasien'] }}</td>
                            <td>{{ $item['poli'] }}</td>
                            <td>{{ $item['dokter'] }}</td>
                            <td>{{ $item['waktu_mulai'] }}</td>
                            <td>{{ $item['waktu_selesai'] }}</td>
                            <td>
                                @if($item['status'] == 'Menunggu')
                                    <span class="badge badge-warning">Menunggu</span>
                                @elseif($item['status'] == 'Diproses')
                                    <span class="badge badge-info">Diproses</span>
                                @elseif($item['status'] == 'Dilayani')
                                    <span class="badge badge-success">Selesai</span>
                                @else
                                    <span class="badge badge-secondary">{{ $item['status'] }}</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center">Tidak ada data kunjungan pada tanggal ini</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#dataTable').DataTable({
            "order": [],
            "language": {
                "emptyTable": "Tidak ada data kunjungan pada tanggal ini"
            }
        });
    });

    function printData() {
        var divToPrint = document.getElementById("dataTable");
        var htmlToPrint = '' +
            '<style type="text/css">' +
            'table {border-collapse: collapse; width: 100%;}' + 
            'th, td {border: 1px solid #ddd; padding: 8px; text-align: left;}' +
            'th {background-color: #f2f2f2;}' +
            'h2 {text-align: center;}' +
            '</style>';
        htmlToPrint += '<h2>Laporan Kunjungan Pasien - {{ \Carbon\Carbon::parse($date)->format("d/m/Y") }}</h2>';
        htmlToPrint += divToPrint.outerHTML;
        
        var newWin = window.open('', 'Print-Window');
        newWin.document.open();
        newWin.document.write('<html><head><title>Laporan Kunjungan Pasien</title>' + htmlToPrint + '</head><body>');
        newWin.document.write('</body></html>');
        newWin.document.close();
        
        setTimeout(function() {
            newWin.print();
            newWin.close();
        }, 500);
    }
</script>
@endpush
