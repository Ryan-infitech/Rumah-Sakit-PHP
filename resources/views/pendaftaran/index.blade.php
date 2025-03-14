@extends(Auth::user()->roles == 'admin' ? 'layout.admin' : 
       (Auth::user()->roles == 'pasien' ? 'layout.pasien' : 'layout.petugas'))

@section('title', 'Pendaftaran Poliklinik')

@section('content')
<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">Pendaftaran Rawat Jalan</h1>

@if(session('success'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'Berhasil',
        text: '{{ session('success') }}',
        timer: 2000,
        showConfirmButton: false
    });
</script>
@endif

<!-- Data Jadwal Hari Ini -->
<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">Hari Ini, {{ $today->format('d/M/Y') }}</h6>
        @if($jadwalHariIni->isEmpty())
        <span class="badge badge-warning">Tidak ada jadwal tersedia</span>
        @else
        <span class="badge badge-success">{{ $jadwalHariIni->count() }} poliklinik tersedia</span>
        @endif
    </div>
    <div class="card-body">
        @if($jadwalHariIni->isEmpty())
        <div class="text-center py-4">
            <i class="fas fa-calendar-times fa-4x text-gray-300 mb-3"></i>
            <p class="text-muted">Tidak ada jadwal praktek dokter untuk hari ini</p>
            @if(!$jadwalBesok->isEmpty() || !$jadwalMendatang->isEmpty())
            <p>Silakan lihat jadwal di hari berikutnya.</p>
            @else
            <p>Silakan kembali lagi di lain waktu.</p>
            @endif
        </div>
        @else
        <div class="row">
            @foreach ($jadwalHariIni as $item)
            <div class="col-sm-6 col-md-4 col-lg-3 mb-4">
                <div class="card h-100">
                    <img src="{{ asset('storage/foto_dokter/' . $item->dokter->foto_dokter) }}" class="card-img-top" 
                         alt="Foto Dokter" style="height: 200px; object-fit: cover;">
                    <div class="card-body">
                        <h5 class="card-title" style="font-size: 1rem; font-weight: bold;">{{ $item->dokter->nama_dokter }}</h5>
                        <p class="card-text" style="font-size: 0.875rem;">
                            <strong>Poliklinik:</strong> {{ $item->dokter->poliklinik->nama_poliklinik }}<br>
                            <strong>Jam:</strong> {{ \Carbon\Carbon::parse($item->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($item->jam_selesai)->format('H:i') }}<br>
                            <strong>Kuota Tersisa:</strong> {{ $item->jumlah }}<br>
                            
                            <!-- Fixed Rating display -->
                            <strong>Rating:</strong>
                            <div class="ratings">
                                @if(isset($dokterRatings[$item->dokter_id]))
                                    @php 
                                        $rating = $dokterRatings[$item->dokter_id]; 
                                        $fullStars = floor($rating);
                                        $halfStar = $rating - $fullStars > 0.3 ? 1 : 0;
                                        $emptyStars = 5 - $fullStars - $halfStar;
                                    @endphp
                                    
                                    @for($i = 0; $i < $fullStars; $i++)
                                        <i class="fas fa-star text-warning"></i>
                                    @endfor
                                    
                                    @if($halfStar)
                                        <i class="fas fa-star-half-alt text-warning"></i>
                                    @endif
                                    
                                    @for($i = 0; $i < $emptyStars; $i++)
                                        <i class="far fa-star text-warning"></i>
                                    @endfor
                                    
                                    <span class="ml-1">({{ number_format($rating, 1) }})</span>
                                @else
                                    <span class="text-muted">Belum ada rating</span>
                                @endif
                            </div>
                        </p>
                        <button class="btn btn-success btn-sm mt-2" data-toggle="modal" data-target="#pendaftaranModal" 
                                data-id="{{ $item->id }}">Daftar</button>
                    </div>
                </div>
            </div>
            @endforeach
            @include('sweetalert::alert')
        </div>
        @endif
    </div>
</div>

<!-- Jadwal Besok - Only show if there are appointments available -->
@if(!$jadwalBesok->isEmpty())
<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">Besok, {{ $tomorrow->format('d/M/Y') }}</h6>
        <span class="badge badge-info">{{ $jadwalBesok->count() }} poliklinik tersedia</span>
    </div>
    <div class="card-body">
        <div class="row">
            @foreach ($jadwalBesok as $item)
            <div class="col-sm-6 col-md-4 col-lg-3 mb-4">
                <div class="card h-100">
                    <img src="{{ asset('storage/foto_dokter/' . $item->dokter->foto_dokter) }}" class="card-img-top" 
                         alt="Foto Dokter" style="height: 200px; object-fit: cover;">
                    <div class="card-body">
                        <h5 class="card-title" style="font-size: 1rem; font-weight: bold;">{{ $item->dokter->nama_dokter }}</h5>
                        <p class="card-text" style="font-size: 0.875rem;">
                            <strong>Poliklinik:</strong> {{ $item->dokter->poliklinik->nama_poliklinik }}<br>
                            <strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($item->tanggal_praktek)->format('d/m/Y') }}<br>
                            <strong>Jam:</strong> {{ \Carbon\Carbon::parse($item->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($item->jam_selesai)->format('H:i') }}<br>
                            <strong>Kuota Tersisa:</strong> {{ $item->jumlah }}<br>
                            
                            <!-- Fixed Rating display -->
                            <strong>Rating:</strong>
                            <div class="ratings">
                                @if(isset($dokterRatings[$item->dokter_id]))
                                    @php 
                                        $rating = $dokterRatings[$item->dokter_id]; 
                                        $fullStars = floor($rating);
                                        $halfStar = $rating - $fullStars > 0.3 ? 1 : 0;
                                        $emptyStars = 5 - $fullStars - $halfStar;
                                    @endphp
                                    
                                    @for($i = 0; $i < $fullStars; $i++)
                                        <i class="fas fa-star text-warning"></i>
                                    @endfor
                                    
                                    @if($halfStar)
                                        <i class="fas fa-star-half-alt text-warning"></i>
                                    @endif
                                    
                                    @for($i = 0; $i < $emptyStars; $i++)
                                        <i class="far fa-star text-warning"></i>
                                    @endfor
                                    
                                    <span class="ml-1">({{ number_format($rating, 1) }})</span>
                                @else
                                    <span class="text-muted">Belum ada rating</span>
                                @endif
                            </div>
                        </p>
                        <button class="btn btn-success btn-sm mt-2" data-toggle="modal" data-target="#pendaftaranModal" 
                                data-id="{{ $item->id }}">Daftar</button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endif

<!-- Jadwal Mendatang (Lebih Dari 1 Hari) - Group by Date -->
@if(isset($jadwalMendatang) && !$jadwalMendatang->isEmpty())
    @php
        $groupedJadwal = $jadwalMendatang->groupBy(function($item) {
            return \Carbon\Carbon::parse($item->tanggal_praktek)->format('Y-m-d');
        });
    @endphp
    
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Jadwal Mendatang</h6>
            <span class="badge badge-primary">{{ $jadwalMendatang->count() }} jadwal tersedia</span>
        </div>
        <div class="card-body">
            <div class="accordion" id="accordionJadwal">
                @foreach($groupedJadwal as $date => $jadwalItems)
                    @php
                        $dateFormat = \Carbon\Carbon::parse($date)->format('d/M/Y');
                        $dayName = \Carbon\Carbon::parse($date)->locale('id')->dayName;
                        $headingId = 'heading' . str_replace(['-', '/'], '', $date);
                        $collapseId = 'collapse' . str_replace(['-', '/'], '', $date);
                    @endphp
                    
                    <div class="card mb-1">
                        <div class="card-header py-2" id="{{ $headingId }}">
                            <h2 class="mb-0">
                                <button class="btn btn-link btn-block text-left collapsed" type="button" 
                                        data-toggle="collapse" data-target="#{{ $collapseId }}" 
                                        aria-expanded="false" aria-controls="{{ $collapseId }}">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span><i class="fas fa-calendar-day mr-2"></i> {{ $dayName }}, {{ $dateFormat }}</span>
                                        <span class="badge badge-info">{{ $jadwalItems->count() }} jadwal</span>
                                    </div>
                                </button>
                            </h2>
                        </div>

                        <div id="{{ $collapseId }}" class="collapse" aria-labelledby="{{ $headingId }}" data-parent="#accordionJadwal">
                            <div class="card-body">
                                <div class="row">
                                    @foreach ($jadwalItems as $item)
                                    <div class="col-sm-6 col-md-4 col-lg-3 mb-4">
                                        <div class="card h-100">
                                            <img src="{{ asset('storage/foto_dokter/' . $item->dokter->foto_dokter) }}" class="card-img-top" 
                                                alt="Foto Dokter" style="height: 150px; object-fit: cover;">
                                            <div class="card-body">
                                                <h5 class="card-title" style="font-size: 1rem; font-weight: bold;">{{ $item->dokter->nama_dokter }}</h5>
                                                <p class="card-text" style="font-size: 0.875rem;">
                                                    <strong>Poliklinik:</strong> {{ $item->dokter->poliklinik->nama_poliklinik }}<br>
                                                    <strong>Jam:</strong> {{ \Carbon\Carbon::parse($item->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($item->jam_selesai)->format('H:i') }}<br>
                                                    <strong>Kuota Tersisa:</strong> {{ $item->jumlah }}
                                                </p>
                                                <button class="btn btn-success btn-sm mt-2" data-toggle="modal" data-target="#pendaftaranModal" 
                                                        data-id="{{ $item->id }}">Daftar</button>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endif

<!-- If no schedules available at all, show a message -->
@if($jadwalHariIni->isEmpty() && $jadwalBesok->isEmpty() && (isset($jadwalMendatang) && $jadwalMendatang->isEmpty()))
<div class="alert alert-info text-center my-4">
    <i class="fas fa-info-circle fa-lg mr-2"></i>
    Tidak ada jadwal dokter tersedia untuk saat ini.
    <br>Silakan cek kembali di lain waktu atau hubungi petugas rumah sakit untuk informasi lebih lanjut.
    <br>
    <a href="{{ route('dashboard-pasien') }}" class="btn btn-primary btn-sm mt-3">
        <i class="fas fa-home fa-sm"></i> Kembali ke Dashboard
    </a>
</div>
@endif

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
                    
                    @if (Auth::user()->roles == 'admin' || Auth::user()->roles == 'petugas')
                    <div class="form-group">
                        <label for="nama_pasien">Nama Pasien:</label>
                        <input type="text" name="nama_pasien" id="nama_pasien" class="form-control" required>
                    </div>
                    @endif
                    
                    <div class="form-group">
                        <label for="penjamin">Penjamin:</label>
                        <select name="penjamin" id="penjamin" class="form-control" required onchange="toggleSuratRujukan()">
                            <option value="">Pilih Penjamin</option>
                            <option value="UMUM">UMUM</option>
                            <option value="BPJS">BPJS</option>
                            <option value="Asuransi">Asuransi</option>
                        </select>
                    </div>
                    
                    @if (Auth::user()->roles == 'pasien')
                    <div class="form-group" id="scan_surat_rujukan_group" style="display: none;">
                        <label for="scan_surat_rujukan">Scan Surat Rujukan:</label>
                        <input type="file" name="scan_surat_rujukan" id="scan_surat_rujukan" class="form-control">
                    </div>
                    @endif
                    
                    <div class="form-group text-center">
                        <button type="submit" class="btn btn-primary">Daftar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Sertakan SweetAlert2 dan Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
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
            if (suratRujukanGroup) {
                suratRujukanGroup.style.display = 'block';
            }
        } else {
            if (suratRujukanGroup) {
                suratRujukanGroup.style.display = 'none';
            }
        }
    }
</script>
@endsection