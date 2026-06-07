<?php

namespace App\Exports;

use App\Models\ServiceTransaction;
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

class ServiceIncomeSheet implements FromCollection, WithHeadings, WithTitle, WithMapping, ShouldAutoSize, WithStyles, WithCustomStartCell, WithEvents
{
    protected $startDate;
    protected $endDate;
    protected $totalIncome = 0;

    public function __construct($startDate, $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function collection()
    {
        $services = \App\Models\ServiceTransaction::with(['booking', 'booking.user'])
            ->where('payment_status', 'paid')
            ->whereBetween('created_at', [$this->startDate, $this->endDate])
            ->latest()
            ->get();
            
        $this->totalIncome = $services->sum('total_cost');
        
        return $services;
    }

    public function map($transaction): array
    {
        return [
            $transaction->created_at->format('d/m/Y H:i'),
            'INV-' . str_pad($transaction->id, 5, '0', STR_PAD_LEFT),
            $transaction->booking->user->name ?? 'Guest',
            $transaction->booking->vehicle->name ?? '-',
            $transaction->booking->vehicle->plat_nomor ?? $transaction->booking->vehicle->plate_number ?? '-',
            ucfirst($transaction->payment_method),
            $transaction->total_cost,
        ];
    }

    public function headings(): array
    {
        return [
            'Tanggal',
            'No Invoice',
            'Nama Pelanggan',
            'Kendaraan',
            'Plat Nomor',
            'Metode Pembayaran',
            'Total Pemasukan (Rp)',
        ];
    }

    public function title(): string
    {
        return 'Pemasukan Servis';
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
                $sheet->setCellValue('A2', 'Laporan Pemasukan Servis Mobil');
                $sheet->setCellValue('A3', 'Periode: ' . $this->startDate->translatedFormat('d F Y') . ' s/d ' . $this->endDate->translatedFormat('d F Y'));
                $sheet->setCellValue('A4', 'Total Pendapatan: Rp ' . number_format($this->totalIncome, 0, ',', '.'));
                
                $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);
                $sheet->getStyle('A2')->getFont()->setBold(true)->setSize(14);
                $sheet->getStyle('A3')->getFont()->setItalic(true);
                $sheet->getStyle('A4')->getFont()->setBold(true);
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
