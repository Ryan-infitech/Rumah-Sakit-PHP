<h3><center>RS Dr.Rian</center></h3>
<h4><center>No Antrian</center></h4>
<h1><center>{{ $antrian->no_antrian }}</center></h1>
<br>
<table border="0" cellspacing="0" cellpadding="5" style="margin-left:auto;margin-right:auto;">
    <tr>
        <td>Kode: </td>
        <td>{{ $antrian->kode_antrian }}</td>
    </tr>
    <tr>
        <td>Tgl Reservasi: </td>
        <td>{{ $antrian->tanggal_reservasi->format('d-m-Y') }}</td>
    </tr>
    <tr>
        <td>Nama Pasien : </td>
        <td>{{ $antrian->nama_pasien }}</td>
    </tr>
    <tr>
        <td>Tgl Berobat : </td>
        <td>{{ $antrian->tanggal_berobat->format('d-m-Y') }}</td>
    </tr>
    <tr>
        <td>Poliklinik : </td>
        <td>{{ $antrian->poliklinik }}</td>
    </tr>
    <tr>
        <td>Dokter : </td>
        <td>{{ $antrian->nama_dokter }}</td>
    </tr>
    <tr>
        <td>Penjamin : </td>
        <td>{{ $antrian->penjamin }}</td>
    </tr>
</table>
<br>
<center>Mohon Perhatikan demi kenyamanan semua pasien</center>
<hr>
<center>
<p>ANTRIAN POLIKLINIK tidak berlaku (dilewat) jika pasien datang:</p>
<p>TIDAK SESUAI jadwal rencana kunjungan atau melewati waktu ESTIMASI.</p>
</center>