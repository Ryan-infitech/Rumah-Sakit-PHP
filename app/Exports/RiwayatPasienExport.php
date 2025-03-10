<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Carbon\Carbon;

class RiwayatPasienExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    protected $riwayatPasien;
    
    public function __construct($riwayatPasien)
    {
        $this->riwayatPasien = $riwayatPasien;
    }
    
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return $this->riwayatPasien;
    }
    
    /**
    * @return array
    */
    public function headings(): array
    {
        return [
            'No.',
            'Kode Kunjungan',
            'Nama Pasien',
            'Poliklinik',
            'Dokter',
            'Tanggal Kunjungan',
            'Waktu Mulai',
            'Waktu Selesai',
            'Durasi (menit)',
            'Penjamin',
            'Status',
        ];
    }
    
    /**
    * @param mixed $row
    * @return array
    */
    public function map($row): array
    {
        return [
            static::$counter++,  // Auto increment row number
            $row->kode_kunjungan,
            $row->nama_pasien,
            $row->poliklinik,
            $row->nama_dokter,
            $row->tanggal_kunjungan ? Carbon::parse($row->tanggal_kunjungan)->format('d-m-Y') : '',
            $row->waktu_mulai ? Carbon::parse($row->waktu_mulai)->format('H:i:s') : '',
            $row->waktu_selesai ? Carbon::parse($row->waktu_selesai)->format('H:i:s') : '',
            $row->durasi_pelayanan ?? '0',
            $row->penjamin ?? '-',
            ucfirst($row->status),
        ];
    }
    
    /**
    * @param Worksheet $sheet
    */
    public function styles(Worksheet $sheet)
    {
        // Style the header row
        $sheet->getStyle('A1:K1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['rgb' => '4E73DF']
            ]
        ]);
        
        // Set column widths for better readability
        $sheet->getColumnDimension('A')->setWidth(5);
        $sheet->getColumnDimension('B')->setWidth(20);
        $sheet->getColumnDimension('C')->setWidth(30);
        $sheet->getColumnDimension('D')->setWidth(20);
        $sheet->getColumnDimension('E')->setWidth(30);
        $sheet->getColumnDimension('F')->setWidth(15);
        $sheet->getColumnDimension('G')->setWidth(15);
        $sheet->getColumnDimension('H')->setWidth(15);
        $sheet->getColumnDimension('I')->setWidth(15);
        $sheet->getColumnDimension('J')->setWidth(20);
        $sheet->getColumnDimension('K')->setWidth(15);
    }
    
    // Static counter for row numbering
    private static $counter = 1;
}
