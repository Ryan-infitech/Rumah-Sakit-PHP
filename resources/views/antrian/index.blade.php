@extends(Auth::user()->roles == 'admin' ? 'layout.admin' : 'layout.petugas')

@section('title', 'Laporan Pendaftaran')

@section('content')
<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">Data Antrian Poliklinik</h1>

<!-- Date Range Filter -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Cari Berdasarkan Tanggal Berobat</h6>
    </div>
    <div class="card-body">
        <form action="{{ route('antrian.index') }}" method="GET" class="row">
            <div class="col-md-3 mb-3">
                <label for="start_date">Dari Tanggal</label>
                <div class="input-group">
                    <input type="date" class="form-control" id="start_date" name="start_date" value="{{ request()->input('start_date') }}">
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <label for="end_date">Sampai Tanggal</label>
                <div class="input-group">
                    <input type="date" class="form-control" id="end_date" name="end_date" value="{{ request()->input('end_date') }}">
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <label for="search">Cari</label>
                <div class="input-group">
                    <input type="text" class="form-control" id="search" name="search" value="{{ request()->input('search') }}" placeholder="Cari...">
                </div>
            </div>
            <div class="col-md-3 mb-3 d-flex align-items-end">
                <button type="submit" class="btn btn-primary btn-sm mr-1"><i class="fas fa-search"></i> Search</button>
                <a href="{{ route('antrian.index') }}" class="btn btn-secondary btn-sm mr-1"><i class="fas fa-sync-alt"></i> Refresh</a>
            </div>
        </form>
    </div>
</div>

<!-- DataTables Example -->
<div class="card shadow mb-4">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode Jadwal Poliklinik</th>
                        <th>Kode Antrian</th>
                        <th>No Antrian</th>
                        <th>Nama Pasien</th>
                        <th>Nomor Telepon</th>
                        <th>Nama Dokter</th>
                        <th>Poliklinik</th>
                        <th>Penjamin</th>
                        <th>Tanggal Berobat</th>
                        <th>Tanggal Reservasi</th>
                        <th>No Kartu BPJS</th>
                        <th>Scan Kartu BPJS</th>
                        <th>Scan Kartu Asuransi</th>
                        <th>Scan Surat Rujukan</th>
                        <th>Aksi</th>
                        </tr>
                </thead>
                <tbody>
                    @php $no = 1; @endphp
                    @foreach ($antrian as $item)
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $item->kode_jadwalpoliklinik }}</td>
                        <td>{{ $item->kode_antrian }}</td>
                        <td>{{ $item->no_antrian }}</td>
                        <td>{{ $item->nama_pasien }}</td>
                        <td>{{ $item->no_telp }}</td>
                        <td>{{ $item->nama_dokter }}</td>
                        <td>{{ $item->poliklinik }}</td>
                        <td>{{ $item->penjamin }}</td>
                        <td>{{ $item->tanggal_berobat->format('d-m-Y') }}</td>
                        <td>{{ $item->tanggal_reservasi->format('d-m-Y') }}</td>
                        <td>{{ $item->no_kbpjs }}</td>
                        <td>
                            @if($item->scan_kbpjs)
                                <p><a href="#" data-toggle="modal" data-target="#modalScanBPJS{{ $item->id }}">Lihat/Unduh BPJS</a></p>
                            @else
                                Tidak ada file
                            @endif
                        </td>
                        <td>
                            @if($item->scan_kasuransi)
                                <p><a href="#" data-toggle="modal" data-target="#modalScanAsuransi{{ $item->id }}">Lihat/Unduh Asuransi</a></p>
                            @else
                            Tidak ada file
                            @endif
                        </td>
                        <td>
                            @if($item->scan_surat_rujukan)
                                <a href="{{ asset('storage/' . str_replace('public/', '', $item->scan_surat_rujukan)) }}" target="_blank">Lihat/Unduh</a>
                            @else
                                Tidak ada file
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('generate.antrian', $item->id) }}" class="btn btn-danger btn-sm"><i class="fas fa-print"></i></a>
                        </td>
                    </tr>

                    <!-- Modal for Scan Asuransi -->
                    <div class="modal fade" id="modalScanAsuransi{{ $item->id }}" tabindex="-1" role="dialog" 
                         aria-labelledby="exampleModalLabel{{ $item->id }}" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel{{ $item->id }}">Scan Asuransi</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body text-center">
                                    <img src="{{ asset('storage/' . $item->scan_kasuransi) }}" class="img-fluid mb-3">
                                    <a href="{{ asset('storage/' . $item->scan_kasuransi) }}" class="btn btn-primary" download>Unduh</a>
                                    </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal for Scan Kartu Berobat -->
                    <div class="modal fade" id="modalScanKartuBerobat{{ $item->id }}" tabindex="-1" role="dialog"
                         aria-labelledby="exampleModalLabel{{ $item->id }}" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel{{ $item->id }}">Scan Kartu Berobat</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body text-center">
                                    <img src="{{ asset('storage/' . $item->scan_kberobat) }}" class="img-fluid mb-3">
                                    <a href="{{ asset('storage/' . $item->scan_kberobat) }}" class="btn btn-primary" download>Unduh</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal for Scan BPJS -->
                    <div class="modal fade" id="modalScanBPJS{{ $item->id }}" tabindex="-1" role="dialog"
                         aria-labelledby="exampleModalLabel{{ $item->id }}" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel{{ $item->id }}">Scan BPJS</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body text-center">
                                    <img src="{{ asset('storage/' . $item->scan_kbpjs) }}" class="img-fluid mb-3">
                                    <a href="{{ asset('storage/' . $item->scan_kbpjs) }}" class="btn btn-primary" download>Unduh</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal for Scan Surat Rujukan -->
                    <div class="modal fade" id="modalScanSuratRujukan{{ $item->id }}" tabindex="-1" role="dialog"
                         aria-labelledby="exampleModalLabel{{ $item->id }}" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel{{ $item->id }}">Scan Surat Rujukan</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body text-center">
                                    <img src="{{ asset('storage/' . $item->scan_surat_rujukan) }}" class="img-fluid mb-3">
                                    <a href="{{ asset('storage/' . $item->scan_surat_rujukan) }}" class="btn btn-primary" 
                                       download>Unduh</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    @include('sweetalert::alert')
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Sertakan SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<!-- Sertakan File JavaScript Khusus -->
<script src="{{ asset('js/sweetalert.js') }}"></script>
@endsection