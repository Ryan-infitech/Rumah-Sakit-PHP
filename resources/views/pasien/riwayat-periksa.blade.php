@extends('layout.pasien')

@section('title', 'Riwayat Periksa')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Riwayat Pemeriksaan</h1>
        <a href="{{ route('riwayat.pasien') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-download fa-sm text-white-50"></i> Download PDF
        </a>
    </div>

    <!-- Riwayat Periksa Card -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Riwayat Pemeriksaan</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Poliklinik</th>
                            <th>Dokter</th>
                            <th>No Antrian</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($riwayat as $item)
                        <tr>
                            <td>{{ $item->tanggal_berobat->format('d/m/Y') }}</td>
                            <td>{{ $item->poliklinik }}</td>
                            <td>{{ $item->nama_dokter }}</td>
                            <td>{{ $item->no_antrian }}</td>
                            <td><span class="badge badge-success">{{ $item->status }}</span></td>
                            <td>
                                <a href="{{ route('generate.antrian', $item->id) }}" class="btn btn-primary btn-sm">
                                    <i class="fas fa-print fa-sm"></i> Cetak
                                </a>
                                
                                @if(!$item->dokter_id)
                                    <!-- No doctor ID, can't rate -->
                                @elseif($item->rating)
                                    <span class="badge badge-info">Sudah Dinilai</span>
                                @else
                                    <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#ratingModal" 
                                            data-dokter="{{ $item->dokter_id }}" 
                                            data-antrian="{{ $item->id }}"
                                            data-dokter-nama="{{ $item->nama_dokter }}">
                                        <i class="fas fa-star fa-sm"></i> Nilai Dokter
                                    </button>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center">Anda belum memiliki riwayat pemeriksaan</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <!-- Detail Riwayat Medis Card -->
    @if($riwayatKunjungan->isNotEmpty())
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Detail Riwayat Medis</h6>
        </div>
        <div class="card-body">
            <div class="accordion" id="accordionRiwayat">
                @foreach($riwayatKunjungan as $index => $kunjungan)
                <div class="card">
                    <div class="card-header" id="heading{{ $index }}">
                        <h2 class="mb-0">
                            <button class="btn btn-link btn-block text-left collapsed" type="button" 
                                    data-toggle="collapse" data-target="#collapse{{ $index }}" 
                                    aria-expanded="false" aria-controls="collapse{{ $index }}">
                                {{ $kunjungan->tanggal_kunjungan->format('d/m/Y') }} - {{ $kunjungan->poliklinik }} - {{ $kunjungan->nama_dokter }}
                            </button>
                        </h2>
                    </div>
                    <div id="collapse{{ $index }}" class="collapse" aria-labelledby="heading{{ $index }}" data-parent="#accordionRiwayat">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <p><strong>Tanggal Kunjungan:</strong> {{ $kunjungan->tanggal_kunjungan->format('d/m/Y') }}</p>
                                    <p><strong>Poliklinik:</strong> {{ $kunjungan->poliklinik }}</p>
                                    <p><strong>Dokter:</strong> {{ $kunjungan->nama_dokter }}</p>
                                    <p><strong>Durasi Pelayanan:</strong> {{ $kunjungan->durasi_pelayanan ?? '0' }} menit</p>
                                </div>
                                <div class="col-md-6">
                                    <p><strong>Catatan Medis:</strong></p>
                                    <p>{{ $kunjungan->catatan ?? 'Tidak ada catatan' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif
</div>

<!-- Rating Modal -->
<div class="modal fade" id="ratingModal" tabindex="-1" role="dialog" aria-labelledby="ratingModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ratingModalLabel">Beri Penilaian Dokter</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="ratingForm" action="{{ route('rating.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="dokter_id" id="dokter_id">
                    @if(\Illuminate\Support\Facades\Schema::hasColumn('ratings', 'antrian_id'))
                        <input type="hidden" name="antrian_id" id="antrian_id">
                    @endif
                    
                    <!-- Add doctor name display -->
                    <div class="form-group">
                        <label for="dokter_nama">Nama Dokter:</label>
                        <input type="text" class="form-control" id="dokter_nama" readonly>
                    </div>
                    
                    <div class="form-group">
                        <label>Rating:</label>
                        <div class="star-rating-container text-center my-3">
                            <div class="rating-stars">
                                <input type="radio" name="rating" value="5" id="star5"><label for="star5" title="Sangat Baik"></label>
                                <input type="radio" name="rating" value="4" id="star4"><label for="star4" title="Baik"></label>
                                <input type="radio" name="rating" value="3" id="star3"><label for="star3" title="Cukup"></label>
                                <input type="radio" name="rating" value="2" id="star2"><label for="star2" title="Kurang"></label>
                                <input type="radio" name="rating" value="1" id="star1"><label for="star1" title="Sangat Kurang"></label>
                            </div>
                            <div class="selected-rating mt-2">0/5</div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="review">Komentar (Opsional):</label>
                        <textarea class="form-control" id="review" name="review" rows="3"></textarea>
                    </div>
                    
                    <div class="form-group text-center">
                        <button type="submit" class="btn btn-primary">Kirim Penilaian</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<style>
.rating-stars {
    display: flex;
    flex-direction: row-reverse;
    justify-content: center;
}

.rating-stars input {
    display: none;
}

.rating-stars label {
    cursor: pointer;
    width: 48px;
    height: 48px;
    margin: 0 4px;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24'%3E%3Cpath d='M12 .587l3.668 7.568 8.332 1.151-6.064 5.828 1.48 8.279-7.416-3.967-7.417 3.967 1.481-8.279-6.064-5.828 8.332-1.151z' fill='%23D3D3D3'/%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-size: contain;
    transition: background-image 0.2s;
}

.rating-stars label:hover,
.rating-stars label:hover ~ label,
.rating-stars input:checked ~ label {
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24'%3E%3Cpath d='M12 .587l3.668 7.568 8.332 1.151-6.064 5.828 1.48 8.279-7.416-3.967-7.417 3.967 1.481-8.279-6.064-5.828 8.332-1.151z' fill='%23FFD700'/%3E%3C/svg%3E");
}

.selected-rating {
    font-weight: bold;
    font-size: 18px;
}
</style>

<script>
    $(document).ready(function() {
        // Initialize DataTable
        $('#dataTable').DataTable({
            "responsive": true,
            "language": {
                "emptyTable": "Anda belum memiliki riwayat pemeriksaan"
            }
        });
        
        // Handle rating modal
        $('#ratingModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var dokterId = button.data('dokter');
            var antrianId = button.data('antrian');
            var dokterNama = button.data('dokter-nama') || button.closest('tr').find('td:eq(2)').text();
            
            console.log('Doctor ID:', dokterId, 'Antrian ID:', antrianId, 'Doctor Name:', dokterNama);
            
            var modal = $(this);
            modal.find('#dokter_id').val(dokterId);
            modal.find('#antrian_id').val(antrianId);
            modal.find('#dokter_nama').val(dokterNama);
            
            // Reset form and selected stars but keep doctor name
            $('#ratingForm')[0].reset();
            $('.selected-rating').text('0/5');
            modal.find('#dokter_nama').val(dokterNama.trim());
        });
        
        // Handle star rating clicks
        $('.rating-stars input').on('click', function() {
            var ratingValue = $(this).val();
            $('.selected-rating').text(ratingValue + '/5');
        });
        
        // Submit form validation
        $('#ratingForm').on('submit', function(e) {
            var rating = $('input[name="rating"]:checked').val();
            
            if (!rating) {
                e.preventDefault();
                alert('Silakan pilih rating terlebih dahulu');
                return false;
            }
            
            return true;
        });
    });
</script>

<script src="{{ asset('js/star-rating.js') }}"></script>
@endpush