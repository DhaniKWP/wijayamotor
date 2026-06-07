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
        $tab = $request->input('tab', 'service'); // 'service' or 'sparepart'

        // Parse to Carbon instances
        $startDate = Carbon::createFromFormat('Y-m', $start_month)->startOfMonth();
        $endDate = Carbon::createFromFormat('Y-m', $end_month)->endOfMonth();

        $services = collect();
        $totalServiceIncome = 0;
        $orders = collect();
        $totalOrderIncome = 0;

        if ($tab === 'service') {
            $serviceQuery = ServiceTransaction::with(['booking', 'booking.user'])
                ->where('payment_status', 'paid')
                ->whereBetween('created_at', [$startDate, $endDate]);

            $services = $serviceQuery->latest()->get();
            $totalServiceIncome = $services->sum('total_cost');
        } else {
            $orderQuery = Order::with(['user', 'items.sparepart'])
                ->where('status', 'done')
                ->whereBetween('created_at', [$startDate, $endDate]);

            $orders = $orderQuery->latest()->get();
            $totalOrderIncome = $orders->sum('total_price');
        }

        return view('admin.laporan.index', compact(
            'services',
            'totalServiceIncome',
            'orders',
            'totalOrderIncome',
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
        } else {
            $fileName = 'Laporan_Sparepart_Wijaya_Motor_' . $start_month . '_sd_' . $end_month . '.xlsx';
            return \Excel::download(new \App\Exports\SparepartIncomeSheet($startDate, $endDate), $fileName);
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

        if ($tab === 'service') {
            $services = ServiceTransaction::with(['booking', 'booking.user', 'booking.vehicle'])
                ->where('payment_status', 'paid')
                ->whereBetween('created_at', [$startDate, $endDate])
                ->latest()
                ->get();
            $totalServiceIncome = $services->sum('total_cost');
            $fileName = 'Laporan_Servis_Wijaya_Motor_' . $start_month . '_sd_' . $end_month . '.pdf';
        } else {
            $orders = Order::with(['user', 'items.sparepart'])
                ->where('status', 'done')
                ->whereBetween('created_at', [$startDate, $endDate])
                ->latest()
                ->get();
            $totalOrderIncome = $orders->sum('total_price');
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
