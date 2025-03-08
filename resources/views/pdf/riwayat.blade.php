<!DOCTYPE html>
<html>
<head>
    <title>Riwayat Pendaftaran</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        h1 {
            font-size: 24px;
            margin: 0;
        }
        h2 {
            font-size: 18px;
            margin: 10px 0;
        }
        .patient-info {
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>RS Dr. Rian</h1>
        <h2>Riwayat Pendaftaran Pasien</h2>
    </div>
    
    <div class="patient-info">
        <p><strong>Nama Pasien:</strong> {{ $datapasien->nama_pasien }}</p>
        <p><strong>No. Rekam Medis:</strong> {{ $datapasien->no_bberobat }}</p>
        <p><strong>Tanggal Cetak:</strong> {{ now()->format('d-m-Y H:i') }}</p>
    </div>
    
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal Berobat</th>
                <th>No Antrian</th>
                <th>Poliklinik</th>
                <th>Dokter</th>
                <th>Penjamin</th>
            </tr>
        </thead>
        <tbody>
            @php $no = 1; @endphp
            @foreach($antrian as $item)
            <tr>
                <td>{{ $no++ }}</td>
                <td>{{ $item->tanggal_berobat->format('d-m-Y') }}</td>
                <td>{{ $item->no_antrian }}</td>
                <td>{{ $item->poliklinik }}</td>
                <td>{{ $item->nama_dokter }}</td>
                <td>{{ $item->penjamin }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
    <div class="footer">
        <p>Dokumen ini dicetak secara elektronik dan tidak memerlukan tanda tangan.</p>
    </div>
</body>
</html>
