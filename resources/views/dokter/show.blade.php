<!-- dokter.show.blade.php -->

@extends(Auth::user()->roles == 'admin' ? 'layout.admin' : 'layout.petugas')

@section('title', 'Detail Dokter')

@section('content')
<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">Detail Dokter</h1>

<div class="row">
    <div class="col-lg-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Informasi Dokter</h6>
            </div>
            <div class="card-body">
                <div class="text-center mb-4">
                    <img src="{{ asset('storage/foto_dokter/' . $dokter->foto_dokter) }}" 
                         class="img-profile rounded-circle" style="width: 150px; height: 150px; object-fit: cover;">
                </div>
                
                <div class="text-center mb-3">
                    <h4>{{ $dokter->nama_dokter }}</h4>
                    <p class="mb-2">{{ $dokter->poliklinik->nama_poliklinik }}</p>
                    
                    <!-- Rating display -->
                    <div class="ratings mb-3">
                        @php 
                            $fullStars = floor($averageRating);
                            $halfStar = $averageRating - $fullStars > 0.3 ? 1 : 0;
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
                        
                        <span class="ml-1">({{ number_format($averageRating, 1) }})</span>
                    </div>
                </div>
                
                <div class="text-center mt-3">
                    <a href="{{ route('dokter.edit', $dokter->id) }}" class="btn btn-primary">Edit</a>
                    <a href="{{ route('dokter.index') }}" class="btn btn-secondary">Kembali</a>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-8">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Ulasan Pasien</h6>
            </div>
            <div class="card-body">
                @if($ratings->count() > 0)
                    @foreach($ratings as $rating)
                        <div class="review-item mb-4 pb-4 border-bottom">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <strong>{{ $rating->user->nama }}</strong>
                                    <div class="small text-muted">{{ $rating->created_at->format('d M Y, H:i') }}</div>
                                </div>
                                <div class="ratings">
                                    @for($i = 0; $i < 5; $i++)
                                        @if($i < $rating->rating)
                                            <i class="fas fa-star text-warning"></i>
                                        @else
                                            <i class="far fa-star text-warning"></i>
                                        @endif
                                    @endfor
                                </div>
                            </div>
                            
                            @if($rating->review)
                                <div class="review-text mt-2">
                                    {{ $rating->review }}
                                </div>
                            @endif
                        </div>
                    @endforeach
                @else
                    <div class="text-center py-4">
                        <p class="text-muted">Belum ada ulasan untuk dokter ini</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection