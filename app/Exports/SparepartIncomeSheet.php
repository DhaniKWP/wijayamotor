<?php

namespace App\Exports;

use App\Models\Order;
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

class SparepartIncomeSheet implements FromCollection, WithHeadings, WithTitle, WithMapping, ShouldAutoSize, WithStyles, WithCustomStartCell, WithEvents
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
        $onlineOrders = \App\Models\Order::with(['user', 'items.sparepart'])
            ->where('status', 'done')
            ->whereBetween('created_at', [$this->startDate, $this->endDate])
            ->latest()
            ->get();
            
        $serviceSpareparts = \App\Models\ServiceTransaction::with(['booking', 'booking.user'])
            ->where('payment_status', 'paid')
            ->where('sparepart_cost', '>', 0)
            ->whereBetween('created_at', [$this->startDate, $this->endDate])
            ->latest()
            ->get();
            
        $this->totalIncome = $onlineOrders->sum('total_price') + $serviceSpareparts->sum('sparepart_cost');
        
        $combinedList = collect();
        foreach($onlineOrders as $ord) {
            $itemText = collect($ord->items)->map(function($i) {
                return ($i->sparepart->name ?? 'Unknown') . ' (x' . $i->quantity . ')';
            })->implode(', ');
            
            $combinedList->push((object)[
                'date' => $ord->created_at,
                'invoice' => 'ORD-' . str_pad($ord->id, 5, '0', STR_PAD_LEFT),
                'customer' => $ord->user->name ?? 'Pelanggan Umum',
                'items_text' => $itemText,
                'total' => $ord->total_price,
                'method' => $ord->payment_method ?? 'cash'
            ]);
        }
        foreach($serviceSpareparts as $svc) {
            $combinedList->push((object)[
                'date' => $svc->created_at,
                'invoice' => 'INV-' . str_pad($svc->id, 5, '0', STR_PAD_LEFT),
                'customer' => $svc->booking->user->name ?? 'Pelanggan Bengkel',
                'items_text' => 'Pembelian via Servis',
                'total' => $svc->sparepart_cost,
                'method' => $svc->payment_method ?? 'cash'
            ]);
        }
        
        return $combinedList->sortByDesc('date');
    }

    public function map($item): array
    {
        return [
            $item->date->format('d/m/Y H:i'),
            $item->invoice,
            $item->customer,
            $item->items_text,
            ucfirst($item->method),
            $item->total,
        ];
    }

    public function headings(): array
    {
        return [
            'Tanggal',
            'No Order',
            'Nama Pelanggan',
            'Barang yang Dibeli',
            'Metode Pembayaran',
            'Total Pemasukan (Rp)',
        ];
    }

    public function title(): string
    {
        return 'Penjualan Langsung';
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
                $sheet->setCellValue('A2', 'Laporan Pemasukan Penjualan Sparepart');
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
