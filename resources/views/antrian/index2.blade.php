@extends('layout.pasien')

@section('title', 'Riwayat Pendaftaran')

@section('content')
<!-- History/Records Title -->
<h3 class="m-2 text-gray-800">Riwayat Pendaftaran</h3>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <a href="{{ route('riwayat.pasien') }}" class="btn btn-danger btn-sm mr-1"><i class="fas fa-file-pdf"></i> PDF</a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="datatable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode Jadwal</th>
                        <th>Kode Antrian</th>
                        <th>No Antrian</th>
                        <th>Nama Dokter</th>
                        <th>Poliklinik</th>
                        <th>Penjamin</th>
                        <th>Tanggal Berobat</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @php $no = 1; @endphp
                    @forelse ($antrian as $item)
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $item->kode_jadwalpoliklinik }}</td>
                        <td>{{ $item->kode_antrian }}</td>
                        <td>{{ $item->no_antrian }}</td>
                        <td>{{ $item->nama_dokter }}</td>
                        <td>{{ $item->poliklinik }}</td>
                        <td>{{ $item->penjamin }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->tanggal_berobat)->format('d-m-Y') }}</td>
                        <td>
                            @if($item && $item->id)
                                <a href="{{ route('generate.antrian', $item->id) }}" class="btn btn-danger btn-sm"><i class="fas fa-print"></i></a>
                                <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#rateDoktorModal" 
                                        data-dokter-id="{{ $item->jadwalpoliklinik ? $item->jadwalpoliklinik->dokter_id : '' }}" 
                                        data-dokter-nama="{{ $item->nama_dokter }}">
                                    <i class="fas fa-star"></i>
                                </button>
                            @else
                                <span>Data tidak ditemukan</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center">Tidak ada data riwayat pendaftaran</td>
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
                <form action="{{ route('rating.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="dokter_id" id="dokter_id_input">
                    
                    <div class="form-group">
                        <label for="dokter_nama">Nama Dokter:</label>
                        <input type="text" class="form-control" id="dokter_nama" readonly>
                    </div>
                    
                    <div class="form-group">
                        <label>Rating:</label>
                        <div class="rating-stars text-center">
                            <div class="rating-group">
                                <input type="radio" class="rating-input" id="star5" name="rating" value="5" />
                                <label for="star5" class="rating-star"><i class="far fa-star"></i></label>
                                
                                <input type="radio" class="rating-input" id="star4" name="rating" value="4" />
                                <label for="star4" class="rating-star"><i class="far fa-star"></i></label>
                                
                                <input type="radio" class="rating-input" id="star3" name="rating" value="3" />
                                <label for="star3" class="rating-star"><i class="far fa-star"></i></label>
                                
                                <input type="radio" class="rating-input" id="star2" name="rating" value="2" />
                                <label for="star2" class="rating-star"><i class="far fa-star"></i></label>
                                
                                <input type="radio" class="rating-input" id="star1" name="rating" value="1" />
                                <label for="star1" class="rating-star"><i class="far fa-star"></i></label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="review">Review (opsional):</label>
                        <textarea class="form-control" id="review" name="review" rows="3"></textarea>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Kirim Rating</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#datatable').DataTable();
        
        // Handle rating modal
        $('#rateDoktorModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var dokterId = button.data('dokter-id');
            var dokterNama = button.data('dokter-nama');
            
            console.log("Doctor ID:", dokterId); // Debug log
            console.log("Doctor Name:", dokterNama); // Debug log
            
            var modal = $(this);
            modal.find('#dokter_id_input').val(dokterId);
            modal.find('#dokter_nama').val(dokterNama);
        });
        
        // Star rating functionality
        $('.rating-star').hover(function() {
            // Hover in
            var star = $(this);
            var allStars = $('.rating-star');
            var starIndex = allStars.index(star);
            
            // Fill stars up to the hovered one
            allStars.each(function(i) {
                if (i <= starIndex) {
                    $(this).find('i').removeClass('far').addClass('fas');
                } else {
                    $(this).find('i').removeClass('fas').addClass('far');
                }
            });
        }, function() {
            // Hover out - restore based on selection
            var checkedStar = $('input[name="rating"]:checked');
            if (checkedStar.length > 0) {
                var rating = parseInt(checkedStar.val());
                $('.rating-star').each(function(i) {
                    if (i < rating) {
                        $(this).find('i').removeClass('far').addClass('fas');
                    } else {
                        $(this).find('i').removeClass('fas').addClass('far');
                    }
                });
            } else {
                $('.rating-star i').removeClass('fas').addClass('far');
            }
        });
        
        // When clicking a star
        $('.rating-star').on('click', function() {
            var star = $(this);
            var input = $('#' + star.attr('for'));
            input.prop('checked', true);
            
            // Update star display
            var rating = parseInt(input.val());
            $('.rating-star').each(function(i) {
                if (i < rating) {
                    $(this).find('i').removeClass('far').addClass('fas');
                } else {
                    $(this).find('i').removeClass('fas').addClass('far');
                }
            });
        });
    });
</script>

<style>
    .rating-group {
        display: flex;
        justify-content: center;
        flex-direction: row-reverse;
    }
    
    .rating-input {
        display: none;
    }
    
    .rating-star {
        cursor: pointer;
        font-size: 2rem;
        color: #FFD700;
        margin: 0 5px;
    }
</style>
@endpush