<div class="container-fluid p-0">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Detail Kunjungan: {{ $riwayat->kode_kunjungan }}</h5>
        </div>
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-md-6">
                    <h6 class="font-weight-bold">Informasi Pasien</h6>
                    <table class="table table-bordered table-sm">
                        <tr>
                            <th width="40%">Nama Pasien</th>
                            <td>{{ $riwayat->nama_pasien }}</td>
                        </tr>
                        <tr>
                            <th>No. Antrian</th>
                            <td>{{ $riwayat->no_antrian }}</td>
                        </tr>
                        <tr>
                            <th>Tanggal Kunjungan</th>
                            <td>{{ $riwayat->tanggal_kunjungan->format('d/m/Y') }}</td>
                        </tr>
                        <tr>
                            <th>Waktu Mulai</th>
                            <td>{{ $riwayat->waktu_mulai ? $riwayat->waktu_mulai->format('H:i:s') : '-' }}</td>
                        </tr>
                        <tr>
                            <th>Waktu Selesai</th>
                            <td>{{ $riwayat->waktu_selesai ? $riwayat->waktu_selesai->format('H:i:s') : '-' }}</td>
                        </tr>
                        <tr>
                            <th>Durasi Pelayanan</th>
                            <td>{{ $riwayat->durasi_pelayanan ?? '0' }} menit</td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <h6 class="font-weight-bold">Informasi Layanan</h6>
                    <table class="table table-bordered table-sm">
                        <tr>
                            <th width="40%">Poliklinik</th>
                            <td>{{ $riwayat->poliklinik }}</td>
                        </tr>
                        <tr>
                            <th>Dokter</th>
                            <td>{{ $riwayat->nama_dokter }}</td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>
                                <span class="badge badge-success">{{ ucfirst($riwayat->status) }}</span>
                            </td>
                        </tr>
                        <tr>
                            <th>Penjamin</th>
                            <td>{{ $riwayat->penjamin ?? 'Umum' }}</td>
                        </tr>
                        <tr>
                            <th>Catatan</th>
                            <td>{{ $riwayat->catatan ?? '-' }}</td>
                        </tr>
                    </table>
                </div>
            </div>
            
            @if($riwayat->catatan)
            <div class="row mb-3">
                <div class="col-12">
                    <div class="card bg-light">
                        <div class="card-header">
                            <h6 class="font-weight-bold mb-0">Catatan Medis</h6>
                        </div>
                        <div class="card-body">
                            <p>{{ $riwayat->catatan }}</p>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
        <div class="card-footer text-center">
            <p class="small text-muted mb-0">Kunjungan dicatat pada {{ $riwayat->created_at->format('d/m/Y H:i:s') }}</p>
        </div>
    </div>
</div>
