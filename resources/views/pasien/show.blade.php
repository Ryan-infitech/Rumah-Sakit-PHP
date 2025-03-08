@extends(
    Auth::user()->roles == 'admin' ? 'layout.admin' :
    (Auth::user()->roles == 'pasien' ? 'layout.pasien' :
    (Auth::user()->roles == 'petugas' ? 'layout.petugas' : 'layout.default'))
)

@section('title', 'Detail Data Pribadi')

@section('content')
<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">Detail Data Pribadi</h1>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        @if (in_array(Auth::user()->roles, ['admin', 'petugas', 'kepala_rs']))
            <a href="{{ route('pasien.index') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        @endif
        
        @if (Auth::user()->roles == 'pasien')
            <a href="{{ route('pasien.edit', $dataPasien->id) }}" class="btn btn-success btn-sm">
                <i class="fas fa-edit"></i> Edit/Lengkapi Data
            </a>
        @endif
    </div>
    
    <div class="card-body">
        @if ($dataPasien)
            <div class="row">
                <div class="col-md-8">
                    <div class="row">
                        <div class="col-md-6">
                            <h6>Nama Pasien:</h6>
                            <p>{{ $dataPasien->nama_pasien }}</p>
                        </div>
                        <div class="col-md-6">
                            <h6>Email/Username:</h6>
                            <p>{{ $dataPasien->email }}</p>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <h6>No. Telepon:</h6>
                            <p>{{ $dataPasien->no_telp }}</p>
                        </div>
                        <div class="col-md-6">
                            <h6>NIK:</h6>
                            <p>{{ $dataPasien->nik ?? '-' }}</p>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <h6>Tempat Lahir:</h6>
                            <p>{{ $dataPasien->tempat_lahir ?? '-' }}</p>
                        </div>
                        <div class="col-md-6">
                            <h6>Tanggal Lahir:</h6>
                            <p>{{ $dataPasien->tanggal_lahir ? 
                                \Carbon\Carbon::parse($dataPasien->tanggal_lahir)->format('d-m-Y') : '-' }}</p>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <h6>Jenis Kelamin:</h6>
                            <p>{{ $dataPasien->jenis_kelamin ?? '-' }}</p>
                        </div>
                        <div class="col-md-6">
                            <h6>Alamat:</h6>
                            <p>{{ $dataPasien->alamat ?? '-' }}</p>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <h6>No. Kartu Berobat:</h6>
                            <p>{{ $dataPasien->no_kberobat ?? '-' }}</p>
                        </div>
                        <div class="col-md-6">
                            <h6>No. Kartu BPJS:</h6>
                            <p>{{ $dataPasien->no_kbpjs ?? '-' }}</p>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <h6>Scan KTP:</h6>
                            @if($dataPasien->scan_ktp)
                                <p><a href="#" data-toggle="modal" data-target="#modalScanKTP">Lihat/Unduh KTP</a></p>
                            @else
                                <p>Gambar KTP tidak ditemukan.</p>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <h6>Scan Kartu Berobat:</h6>
                            @if($dataPasien->scan_kberobat)
                                <p><a href="#" data-toggle="modal" data-target="#modalScanKartuBerobat">Lihat/Unduh Kartu Berobat</a></p>
                            @else
                                <p>Gambar Kartu Berobat tidak ditemukan.</p>
                            @endif
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <h6>Scan BPJS:</h6>
                            @if($dataPasien->scan_kbpjs)
                                <p><a href="#" data-toggle="modal" data-target="#modalScanBPJS">Lihat/Unduh BPJS</a></p>
                            @else
                                <p>Gambar BPJS tidak ditemukan.</p>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <h6>Scan Asuransi:</h6>
                            @if($dataPasien->scan_kasuransi)
                                <p><a href="#" data-toggle="modal" data-target="#modalScanAsuransi">Lihat/Unduh Asuransi</a></p>
                            @else
                                <p>Gambar Asuransi tidak ditemukan.</p>
                            @endif
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4 text-center" style="align-self: center;">
                    @if($dataPasien->user->foto_user && file_exists(public_path('storage/foto_user/' . $dataPasien->user->foto_user)))
                        <img src="{{ asset('storage/foto_user/' . $dataPasien->user->foto_user) }}" 
                             alt="Foto User" class="img-fluid rounded mb-4" width="300">
                    @else
                        <p>Foto User tidak ditemukan.</p>
                    @endif
                </div>
            </div>
        @else
            <p>Data pasien tidak ditemukan.</p>
        @endif
    </div>
</div>

<!-- Modal for Scan KTP -->
<div class="modal fade" id="modalScanKTP" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Scan KTP</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <img src="{{ asset('storage/' . $dataPasien->scan_ktp) }}" class="img-fluid mb-3">
                <a href="{{ asset('storage/' . $dataPasien->scan_ktp) }}" class="btn btn-primary" download>Unduh</a>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Scan Kartu Berobat -->
<div class="modal fade" id="modalScanKartuBerobat" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Scan Kartu Berobat</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <img src="{{ asset('storage/' . $dataPasien->scan_kberobat) }}" class="img-fluid mb-3">
                <a href="{{ asset('storage/' . $dataPasien->scan_kberobat) }}" class="btn btn-primary" download>Unduh</a>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Scan BPJS -->
<div class="modal fade" id="modalScanBPJS" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Scan BPJS</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <img src="{{ asset('storage/' . $dataPasien->scan_kbpjs) }}" class="img-fluid mb-3">
                <a href="{{ asset('storage/' . $dataPasien->scan_kbpjs) }}" class="btn btn-primary" download>Unduh</a>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Scan Asuransi -->
<div class="modal fade" id="modalScanAsuransi" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Scan Asuransi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <img src="{{ asset('storage/' . $dataPasien->scan_kasuransi) }}" class="img-fluid mb-3">
                <a href="{{ asset('storage/' . $dataPasien->scan_kasuransi) }}" class="btn btn-primary" download>Unduh</a>
            </div>
        </div>
    </div>
</div>
@endsection

@include('sweetalert::alert')
