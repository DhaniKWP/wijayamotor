<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ServiceTransaction;
use App\Models\Order;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        // 1. Get filter params (format: YYYY-MM)
        $start_month = $request->input('start_month', Carbon::now()->format('Y-m'));
        $end_month = $request->input('end_month', Carbon::now()->format('Y-m'));
        $tab = $request->input('tab', 'service'); // 'service', 'sparepart', or 'stock'

        // Parse to Carbon instances
        $startDate = Carbon::createFromFormat('Y-m', $start_month)->startOfMonth();
        $endDate = Carbon::createFromFormat('Y-m', $end_month)->endOfMonth();

        $services = collect();
        $totalServiceIncome = 0;
        $orders = collect();
        $totalOrderIncome = 0;
        $spareparts = collect();
        $totalAssetValue = 0;
        $lowStockCount = 0;

        if ($tab === 'service') {
            $serviceQuery = ServiceTransaction::with(['booking', 'booking.user'])
                ->where('payment_status', 'paid')
                ->whereBetween('created_at', [$startDate, $endDate]);

            $services = $serviceQuery->latest()->get();
            $totalServiceIncome = $services->sum('service_cost');
        } elseif ($tab === 'sparepart') {
            $orderQuery = Order::with(['user', 'items.sparepart'])
                ->where('status', 'done')
                ->whereBetween('created_at', [$startDate, $endDate]);

            $onlineOrders = $orderQuery->latest()->get();
            
            $serviceSpareparts = ServiceTransaction::with(['booking', 'booking.user'])
                ->where('payment_status', 'paid')
                ->where('sparepart_cost', '>', 0)
                ->whereBetween('created_at', [$startDate, $endDate])
                ->latest()
                ->get();
                
            $totalOrderIncome = $onlineOrders->sum('total_price') + $serviceSpareparts->sum('sparepart_cost');
            
            $combinedList = collect();
            foreach($onlineOrders as $ord) {
                $itemText = collect($ord->items)->map(function($i) {
                    return ($i->sparepart->name ?? 'Unknown') . ' (x' . $i->quantity . ')';
                })->implode(', ');
                
                $combinedList->push((object)[
                    'type' => 'online',
                    'date' => $ord->created_at,
                    'invoice' => '#ORD-' . str_pad($ord->id, 5, '0', STR_PAD_LEFT),
                    'customer' => $ord->user->name ?? 'Pelanggan Umum',
                    'items_text' => $itemText,
                    'total' => $ord->total_price,
                    'status' => 'Pesanan Online',
                    'method' => $ord->payment_method ?? 'cash'
                ]);
            }
            foreach($serviceSpareparts as $svc) {
                $combinedList->push((object)[
                    'type' => 'offline',
                    'date' => $svc->created_at,
                    'invoice' => '#INV-' . str_pad($svc->id, 5, '0', STR_PAD_LEFT),
                    'customer' => $svc->booking->user->name ?? 'Pelanggan Bengkel',
                    'items_text' => 'Pembelian via Servis',
                    'total' => $svc->sparepart_cost,
                    'status' => 'Servis Offline',
                    'method' => $svc->payment_method ?? 'cash'
                ]);
            }
            $orders = $combinedList->sortByDesc('date');
        } elseif ($tab === 'stock') {
            $spareparts = \App\Models\Sparepart::orderBy('name', 'asc')->get();
            $totalAssetValue = $spareparts->sum(function($item) {
                return $item->stock * $item->price;
            });
            $lowStockCount = $spareparts->where('stock', '<=', 3)->count();
        }

        return view('admin.laporan.index', compact(
            'services',
            'totalServiceIncome',
            'orders',
            'totalOrderIncome',
            'spareparts',
            'totalAssetValue',
            'lowStockCount',
            'start_month',
            'end_month',
            'tab'
        ));
    }

    public function export(Request $request)
    {
        $start_month = $request->input('start_month', Carbon::now()->format('Y-m'));
        $end_month = $request->input('end_month', Carbon::now()->format('Y-m'));
        $tab = $request->input('tab', 'service');

        $startDate = Carbon::createFromFormat('Y-m', $start_month)->startOfMonth();
        $endDate = Carbon::createFromFormat('Y-m', $end_month)->endOfMonth();

        if ($tab === 'service') {
            $fileName = 'Laporan_Servis_Wijaya_Motor_' . $start_month . '_sd_' . $end_month . '.xlsx';
            return \Excel::download(new \App\Exports\ServiceIncomeSheet($startDate, $endDate), $fileName);
        } elseif ($tab === 'sparepart') {
            $fileName = 'Laporan_Sparepart_Wijaya_Motor_' . $start_month . '_sd_' . $end_month . '.xlsx';
            return \Excel::download(new \App\Exports\SparepartIncomeSheet($startDate, $endDate), $fileName);
        } else {
            $fileName = 'Lembar_Stock_Opname_Wijaya_Motor_' . date('Y-m-d') . '.xlsx';
            return \Excel::download(new \App\Exports\StockOpnameSheet(), $fileName);
        }
    }

    public function exportPdf(Request $request)
    {
        $start_month = $request->input('start_month', Carbon::now()->format('Y-m'));
        $end_month = $request->input('end_month', Carbon::now()->format('Y-m'));
        $tab = $request->input('tab', 'service');

        $startDate = Carbon::createFromFormat('Y-m', $start_month)->startOfMonth();
        $endDate = Carbon::createFromFormat('Y-m', $end_month)->endOfMonth();

        $services = collect();
        $totalServiceIncome = 0;
        $orders = collect();
        $totalOrderIncome = 0;

        if ($tab === 'stock') {
            $spareparts = \App\Models\Sparepart::orderBy('name', 'asc')->get();
            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.laporan.pdf-stock', compact('spareparts'));
            $pdf->setPaper('A4', 'portrait');
            return $pdf->stream('Lembar_Stock_Opname_Wijaya_Motor_' . date('Y-m-d') . '.pdf');
        }

        if ($tab === 'service') {
            $services = ServiceTransaction::with(['booking', 'booking.user', 'booking.vehicle'])
                ->where('payment_status', 'paid')
                ->whereBetween('created_at', [$startDate, $endDate])
                ->latest()
                ->get();
            $totalServiceIncome = $services->sum('service_cost');
            $fileName = 'Laporan_Servis_Wijaya_Motor_' . $start_month . '_sd_' . $end_month . '.pdf';
        } else {
            $onlineOrders = Order::with(['user', 'items.sparepart'])
                ->where('status', 'done')
                ->whereBetween('created_at', [$startDate, $endDate])
                ->latest()
                ->get();
                
            $serviceSpareparts = ServiceTransaction::with(['booking', 'booking.user'])
                ->where('payment_status', 'paid')
                ->where('sparepart_cost', '>', 0)
                ->whereBetween('created_at', [$startDate, $endDate])
                ->latest()
                ->get();
                
            $totalOrderIncome = $onlineOrders->sum('total_price') + $serviceSpareparts->sum('sparepart_cost');
            
            $combinedList = collect();
            foreach($onlineOrders as $ord) {
                $itemText = collect($ord->items)->map(function($i) {
                    return ($i->sparepart->name ?? 'Unknown') . ' (x' . $i->quantity . ')';
                })->implode(', ');
                
                $combinedList->push((object)[
                    'type' => 'online',
                    'date' => $ord->created_at,
                    'invoice' => '#ORD-' . str_pad($ord->id, 5, '0', STR_PAD_LEFT),
                    'customer' => $ord->user->name ?? 'Pelanggan Umum',
                    'items_text' => $itemText,
                    'total' => $ord->total_price,
                    'status' => 'Pesanan Online',
                    'method' => $ord->payment_method ?? 'cash'
                ]);
            }
            foreach($serviceSpareparts as $svc) {
                $combinedList->push((object)[
                    'type' => 'offline',
                    'date' => $svc->created_at,
                    'invoice' => '#INV-' . str_pad($svc->id, 5, '0', STR_PAD_LEFT),
                    'customer' => $svc->booking->user->name ?? 'Pelanggan Bengkel',
                    'items_text' => 'Pembelian via Servis',
                    'total' => $svc->sparepart_cost,
                    'status' => 'Servis Offline',
                    'method' => $svc->payment_method ?? 'cash'
                ]);
            }
            $orders = $combinedList->sortByDesc('date');
            
            $fileName = 'Laporan_Sparepart_Wijaya_Motor_' . $start_month . '_sd_' . $end_month . '.pdf';
        }

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.laporan.pdf', compact(
            'services', 'totalServiceIncome', 
            'orders', 'totalOrderIncome', 
            'start_month', 'end_month',
            'startDate', 'endDate', 'tab'
        ));

        $pdf->setPaper('A4', 'landscape');
        
        return $pdf->stream($fileName);
    }
}
