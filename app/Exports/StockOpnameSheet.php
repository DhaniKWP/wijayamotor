<?php

namespace App\Exports;

use App\Models\Sparepart;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class StockOpnameSheet implements FromCollection, WithHeadings, WithTitle, WithMapping, ShouldAutoSize, WithStyles, WithCustomStartCell, WithEvents
{
    public function collection()
    {
        return Sparepart::orderBy('name', 'asc')->get();
    }

    public function map($sparepart): array
    {
        return [
            $sparepart->name,
            $sparepart->price,
            $sparepart->stock,
            '', // Kolom Stok Fisik kosong untuk diisi manual
            '', // Kolom Selisih kosong
            '', // Kolom Keterangan kosong
        ];
    }

    public function headings(): array
    {
        return [
            'Nama Barang',
            'Harga Satuan (Rp)',
            'Stok Sistem',
            'Stok Fisik',
            'Selisih',
            'Keterangan'
        ];
    }

    public function title(): string
    {
        return 'Lembar Opname';
    }
    
    public function startCell(): string
    {
        return 'A6';
    }
    
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                
                $sheet->setCellValue('A1', 'WIJAYA MOTOR');
                $sheet->setCellValue('A2', 'Lembar Kerja Stock Opname Gudang');
                $sheet->setCellValue('A3', 'Tanggal Cetak: ' . date('d F Y'));
                $sheet->setCellValue('A4', 'Petugas Opname: .......................................');
                
                $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);
                $sheet->getStyle('A2')->getFont()->setBold(true)->setSize(14);
                $sheet->getStyle('A3')->getFont()->setItalic(true);
                $sheet->getStyle('A4')->getFont()->setBold(true);

                // Set column widths manually for the empty columns
                $sheet->getColumnDimension('D')->setWidth(15);
                $sheet->getColumnDimension('E')->setWidth(15);
                $sheet->getColumnDimension('F')->setWidth(25);
            },
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            6    => ['font' => ['bold' => true, 'color' => ['argb' => 'FFFFFFFF']], 'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['argb' => 'FF1E293B']]],
        ];
    }
}
