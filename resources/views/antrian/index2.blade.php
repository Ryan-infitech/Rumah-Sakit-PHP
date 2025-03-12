@extends('layout.pasien')

@section('title', 'Riwayat Pendaftaran')

@section('content')
<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">Riwayat Pendaftaran</h1>

<!-- Card for actions and filters -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <a href="{{ route('riwayat.pasien') }}" class="btn btn-danger btn-sm mr-1">
            <i class="fas fa-file-pdf"></i> Export PDF
        </a>
    </div>
</div>

<!-- DataTables Card -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Data Riwayat Pendaftaran</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode Jadwal</th>
                        <th>No Antrian</th>
                        <th>Nama Dokter</th>
                        <th>Poliklinik</th>
                        <th>Tanggal Berobat</th>
                        <th>Penjamin</th>
                        <th>Status</th>
                        <th>Scan BPJS</th>
                        <th>Scan Asuransi</th>
                        <th>Scan Rujukan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @php $no = 1; @endphp
                    @forelse ($antrian as $item)
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $item->kode_jadwalpoliklinik }}</td>
                        <td>{{ $item->no_antrian }}</td>
                        <td>{{ $item->nama_dokter }}</td>
                        <td>{{ $item->poliklinik }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->tanggal_berobat)->format('d-m-Y') }}</td>
                        <td>{{ $item->penjamin }}</td>
                        <td>
                            @if($item->status == 'menunggu')
                                <span class="badge badge-warning">Menunggu</span>
                            @elseif($item->status == 'diproses')
                                <span class="badge badge-primary">Diproses</span>
                            @elseif($item->status == 'dilayani')
                                <span class="badge badge-success">Selesai</span>
                            @endif
                        </td>
                        <td>
                            @if($item->scan_kbpjs)
                                <p><a href="#" data-toggle="modal" data-target="#modalScanBPJS{{ $item->id }}">Lihat/Unduh</a></p>
                            @else
                                Tidak ada file
                            @endif
                        </td>
                        <td>
                            @if($item->scan_kasuransi)
                                <p><a href="#" data-toggle="modal" data-target="#modalScanAsuransi{{ $item->id }}">Lihat/Unduh</a></p>
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
                            <div class="btn-group">
                                <a href="{{ route('generate.antrian', $item->id) }}" class="btn btn-danger btn-sm" title="Cetak">
                                    <i class="fas fa-print"></i>
                                </a>
                                
                                @php
                                    // Check if the user has already rated this doctor
                                    $userRating = \App\Models\Rating::where('dokter_id', $item->dokter_id)
                                        ->where('user_id', Auth::id())
                                        ->first();
                                @endphp
                                
                                @if($userRating)
                                    <button class="btn btn-secondary btn-sm" disabled title="Sudah Dinilai">
                                        <i class="fas fa-star"></i> <span class="small">{{ $userRating->rating }}</span>
                                    </button>
                                @else
                                    <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#rateDoktorModal" 
                                            data-dokter-id="{{ $item->dokter_id }}"
                                            data-antrian-id="{{ $item->id }}" 
                                            data-dokter-nama="{{ $item->nama_dokter }}" title="Beri Rating">
                                        <i class="fas fa-star"></i>
                                    </button>
                                @endif
                            </div>
                        </td>
                    </tr>

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
                                    <img src="{{ asset('storage/' . str_replace('public/', '', $item->scan_surat_rujukan)) }}" class="img-fluid mb-3">
                                    <a href="{{ asset('storage/' . str_replace('public/', '', $item->scan_surat_rujukan)) }}" class="btn btn-primary" 
                                       download>Unduh</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <tr>
                        <td colspan="12" class="text-center">Tidak ada data riwayat pendaftaran</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal for Rating Doctor -->
<div class="modal fade" id="rateDoktorModal" tabindex="-1" role="dialog" aria-labelledby="rateDoktorModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="rateDoktorModalLabel">Beri Rating untuk Dokter</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('rating.store') }}" method="POST" id="ratingDoctorForm">
                    @csrf
                    <input type="hidden" name="dokter_id" id="dokter_id_input">
                    <!-- Conditionally include antrian_id -->
                    @if(\Illuminate\Support\Facades\Schema::hasColumn('ratings', 'antrian_id'))
                        <input type="hidden" name="antrian_id" id="antrian_id_input">
                    @endif
                    
                    <div class="form-group">
                        <label for="dokter_nama">Nama Dokter:</label>
                        <input type="text" class="form-control" id="dokter_nama" name="dokter_nama" readonly>
                    </div>
                    
                    <div class="form-group">
                        <label>Rating:</label>
                        <div class="star-rating-container my-4 text-center">
                            <div class="star-rating">
                                <input type="radio" id="star-5" name="rating" value="5" /><label for="star-5" title="Sangat Baik"></label>
                                <input type="radio" id="star-4" name="rating" value="4" /><label for="star-4" title="Baik"></label>
                                <input type="radio" id="star-3" name="rating" value="3" /><label for="star-3" title="Cukup"></label>
                                <input type="radio" id="star-2" name="rating" value="2" /><label for="star-2" title="Kurang"></label>
                                <input type="radio" id="star-1" name="rating" value="1" /><label for="star-1" title="Sangat Kurang"></label>
                            </div>
                            <div class="rating-value mt-2">0 dari 5</div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="review">Review (opsional):</label>
                        <textarea class="form-control" id="review" name="review" rows="3"></textarea>
                    </div>
                    
                    <div class="form-group text-right">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Kirim Rating</button>
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
        $('#dataTable').DataTable();
        
        // Handle rating modal for doctor
        $('#rateDoktorModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var dokterId = button.data('dokter-id');
            var dokterNama = button.data('dokter-nama');
            var antrianId = button.data('antrian-id');
            
            console.log('Rating modal opened - Doctor ID:', dokterId, 'Doctor Name:', dokterNama, 'Antrian ID:', antrianId);
            
            var modal = $(this);
            modal.find('#dokter_id_input').val(dokterId);
            modal.find('#dokter_nama').val(dokterNama);
            modal.find('#antrian_id_input').val(antrianId);
            
            // Reset form and rating but keep doctor name
            modal.find('#ratingDoctorForm')[0].reset();
            modal.find('.rating-value').text('0 dari 5');
            modal.find('#dokter_nama').val(dokterNama);
        });
        
        // Star rating click handler
        $('.star-rating input').on('click', function() {
            var value = $(this).val();
            $(this).closest('.star-rating-container').find('.rating-value').text(value + ' dari 5');
        });
        
        // Form validation before submission
        $('#ratingDoctorForm').on('submit', function(e) {
            var rating = $(this).find('input[name="rating"]:checked').val();
            
            if (!rating) {
                e.preventDefault();
                alert('Silakan pilih rating terlebih dahulu');
                return false;
            }
        });
    });
</script>

<style>
/* Star Rating CSS - Complete overhaul */
.star-rating {
    display: inline-flex;
    flex-direction: row-reverse;
    justify-content: center;
}

.star-rating input {
    display: none;
}

.star-rating label {
    cursor: pointer;
    width: 36px;
    height: 36px;
    margin: 0 4px;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24'%3E%3Cpath d='M12 .587l3.668 7.568 8.332 1.151-6.064 5.828 1.48 8.279-7.416-3.967-7.417 3.967 1.481-8.279-6.064-5.828 8.332-1.151z' fill='%23D3D3D3'/%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: center;
    background-size: 36px;
    transition: all 0.2s;
}

.star-rating label:hover,
.star-rating label:hover ~ label,
.star-rating input:checked ~ label {
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24'%3E%3Cpath d='M12 .587l3.668 7.568 8.332 1.151-6.064 5.828 1.48 8.279-7.416-3.967-7.417 3.967 1.481-8.279-6.064-5.828 8.332-1.151z' fill='%23FFD700'/%3E%3C/svg%3E");
    transform: scale(1.1);
}

.rating-value {
    font-weight: bold;
    font-size: 18px;
    color: #555;
}

.badge {
    font-size: 0.85rem;
    padding: 0.35em 0.65em;
}

.badge-warning {
    background-color: #f6c23e;
    color: #212529;
}

.badge-primary {
    background-color: #4e73df;
    color: #fff;
}

.badge-success {
    background-color: #1cc88a;
    color: #fff;
}
</style>

<script src="{{ asset('js/star-rating.js') }}"></script>
@endpush