@extends('layouts.admin')

@section('title', 'Laporan Pemasukan - Wijaya Motor')
@section('header_title', 'Laporan Keuangan')

@section('content')

{{-- HEADER & FILTER --}}
<div class="mb-8 bg-white p-6 rounded-xl border border-slate-200/60 shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-6">
    <div>
        <h2 class="text-xl md:text-2xl font-extrabold text-slate-800 tracking-tight">Rekapitulasi Pemasukan</h2>
        <p class="text-sm text-slate-500 mt-1 font-medium">Data pendapatan dari transaksi servis dan penjualan sparepart.</p>
    </div>
    
    <form method="GET" action="{{ route('admin.laporan.index') }}" class="flex items-center gap-3 bg-slate-50 p-2 rounded-lg border border-slate-100 flex-wrap">
        <div class="flex items-center gap-2">
            <label class="text-[10px] font-extrabold text-slate-400 uppercase">Dari</label>
            <input type="month" name="start_month" value="{{ $start_month }}" class="bg-white border border-slate-200 rounded-md px-3 py-2 text-sm font-bold text-slate-700 focus:outline-none focus:ring-2 focus:ring-brand focus:border-transparent">
        </div>
        <div class="flex items-center gap-2">
            <label class="text-[10px] font-extrabold text-slate-400 uppercase">Sampai</label>
            <input type="month" name="end_month" value="{{ $end_month }}" class="bg-white border border-slate-200 rounded-md px-3 py-2 text-sm font-bold text-slate-700 focus:outline-none focus:ring-2 focus:ring-brand focus:border-transparent">
        </div>
        
        <div class="flex items-center gap-2">
            <input type="hidden" name="tab" value="{{ $tab }}">
            <button type="submit" class="bg-slate-800 hover:bg-slate-900 text-white font-bold py-2 px-4 rounded-md text-sm transition-colors flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/></svg>
                Filter
            </button>
            
            <a href="{{ route('admin.laporan.export', ['start_month' => $start_month, 'end_month' => $end_month, 'tab' => $tab]) }}" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-2 px-4 rounded-md text-sm transition-colors flex items-center gap-2 shadow-sm">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                Export Excel
            </a>
            
            <a href="{{ route('admin.laporan.export.pdf', ['start_month' => $start_month, 'end_month' => $end_month, 'tab' => $tab]) }}" target="_blank" class="bg-rose-600 hover:bg-rose-700 text-white font-bold py-2 px-4 rounded-md text-sm transition-colors flex items-center gap-2 shadow-sm">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 9h1.5m1.5 0h.5m-3.5 4h5m-5 4h5"/></svg>
                Export PDF
            </a>
        </div>
    </form>
</div>

{{-- TABS NAVIGATION --}}
<div class="flex gap-2 mb-6 border-b border-slate-200">
    <a href="{{ request()->fullUrlWithQuery(['tab' => 'service']) }}" class="py-3 px-6 font-bold text-sm border-b-2 transition-colors {{ $tab === 'service' ? 'border-brand text-brand' : 'border-transparent text-slate-500 hover:text-slate-800 hover:border-slate-300' }}">
        Laporan Servis
    </a>
    <a href="{{ request()->fullUrlWithQuery(['tab' => 'sparepart']) }}" class="py-3 px-6 font-bold text-sm border-b-2 transition-colors {{ $tab === 'sparepart' ? 'border-brand text-brand' : 'border-transparent text-slate-500 hover:text-slate-800 hover:border-slate-300' }}">
        Laporan Sparepart
    </a>
</div>

{{-- SUMMARY CARDS (DYNAMIC BASED ON TAB) --}}
@if($tab === 'service')
<div class="mb-8">
    <div class="bg-gradient-to-br from-slate-800 to-slate-900 rounded-xl p-6 shadow-md flex items-center justify-between relative overflow-hidden">
        <div class="absolute right-0 top-0 opacity-10 transform translate-x-1/4 -translate-y-1/4">
            <svg class="w-32 h-32 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        </div>
        <div class="relative z-10">
            <p class="text-xs font-black text-slate-300 uppercase tracking-widest mb-1">Total Pendapatan Servis (Periode Ini)</p>
            <h3 class="text-3xl font-black text-white">Rp {{ number_format($totalServiceIncome, 0, ',', '.') }}</h3>
            <p class="text-xs text-slate-300 font-medium mt-1">Dari {{ $services->count() }} transaksi servis</p>
        </div>
        <div class="w-14 h-14 bg-white/10 backdrop-blur-sm rounded-xl flex items-center justify-center shrink-0 relative z-10 border border-white/20">
            <svg class="w-7 h-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
        </div>
    </div>
</div>
@else
<div class="mb-8">
    <div class="bg-gradient-to-br from-amber-600 to-amber-700 rounded-xl p-6 shadow-md flex items-center justify-between relative overflow-hidden">
        <div class="absolute right-0 top-0 opacity-10 transform translate-x-1/4 -translate-y-1/4">
            <svg class="w-32 h-32 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        </div>
        <div class="relative z-10">
            <p class="text-xs font-black text-white/80 uppercase tracking-widest mb-1">Total Pendapatan Sparepart (Periode Ini)</p>
            <h3 class="text-3xl font-black text-white">Rp {{ number_format($totalOrderIncome, 0, ',', '.') }}</h3>
            <p class="text-xs text-white/80 font-medium mt-1">Dari {{ $orders->count() }} pesanan sparepart</p>
        </div>
        <div class="w-14 h-14 bg-white/10 backdrop-blur-sm rounded-xl flex items-center justify-center shrink-0 relative z-10 border border-white/20">
            <svg class="w-7 h-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
        </div>
    </div>
</div>
@endif

<div>
    @if($tab === 'service')
    {{-- TABLE: Service Transactions --}}
    <div class="bg-white rounded-xl border border-slate-200/60 overflow-hidden shadow-sm">
        <div class="p-5 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
            <h3 class="text-sm font-extrabold text-slate-800 tracking-tight uppercase flex items-center gap-2">
                <svg class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                Rincian Pemasukan Servis
            </h3>
        </div>
        <div class="overflow-x-auto max-h-[500px] overflow-y-auto">
            <table class="min-w-full divide-y divide-slate-100">
                <thead class="bg-slate-50/50 sticky top-0 z-10">
                    <tr>
                        <th class="px-5 py-3 text-left text-[10px] font-extrabold text-slate-500 uppercase tracking-wider">Tgl / Invoice</th>
                        <th class="px-5 py-3 text-left text-[10px] font-extrabold text-slate-500 uppercase tracking-wider">Pelanggan</th>
                        <th class="px-5 py-3 text-right text-[10px] font-extrabold text-slate-500 uppercase tracking-wider">Total</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-slate-50">
                    @forelse($services as $svc)
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="px-5 py-3">
                            <div class="text-xs font-bold text-slate-800">{{ $svc->created_at->format('d/m/Y') }}</div>
                            <div class="text-[10px] text-slate-500 font-medium mt-0.5 uppercase">#INV-{{ str_pad($svc->id, 5, '0', STR_PAD_LEFT) }}</div>
                        </td>
                        <td class="px-5 py-3">
                            <div class="text-xs font-bold text-slate-800 truncate max-w-[150px]">{{ $svc->booking->user->name ?? 'Guest' }}</div>
                        </td>
                        <td class="px-5 py-3 text-right">
                            <div class="text-sm font-black text-slate-800">Rp{{ number_format($svc->total_cost, 0, ',', '.') }}</div>
                            <div class="text-[10px] text-green-600 font-bold mt-0.5">Lunas via {{ ucfirst($svc->payment_method) }}</div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="px-5 py-8 text-center">
                            <svg class="w-10 h-10 text-slate-300 mx-auto mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            <p class="text-sm text-slate-500 font-medium">Belum ada pemasukan servis di periode ini.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @else
    {{-- TABLE: Direct Sparepart Orders --}}
    <div class="bg-white rounded-xl border border-slate-200/60 overflow-hidden shadow-sm">
        <div class="p-5 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
            <h3 class="text-sm font-extrabold text-slate-800 tracking-tight uppercase flex items-center gap-2">
                <svg class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                Rincian Penjualan Langsung
            </h3>
        </div>
        <div class="overflow-x-auto max-h-[500px] overflow-y-auto">
            <table class="min-w-full divide-y divide-slate-100">
                <thead class="bg-slate-50/50 sticky top-0 z-10">
                    <tr>
                        <th class="px-5 py-3 text-left text-[10px] font-extrabold text-slate-500 uppercase tracking-wider">Tgl / Order ID</th>
                        <th class="px-5 py-3 text-left text-[10px] font-extrabold text-slate-500 uppercase tracking-wider">Pelanggan</th>
                        <th class="px-5 py-3 text-right text-[10px] font-extrabold text-slate-500 uppercase tracking-wider">Total</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-slate-50">
                    @forelse($orders as $ord)
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="px-5 py-3">
                            <div class="text-xs font-bold text-slate-800">{{ $ord->created_at->format('d/m/Y') }}</div>
                            <div class="text-[10px] text-slate-500 font-medium mt-0.5 uppercase">#ORD-{{ str_pad($ord->id, 5, '0', STR_PAD_LEFT) }}</div>
                        </td>
                        <td class="px-5 py-3">
                            <div class="text-xs font-bold text-slate-800 truncate max-w-[150px]">{{ $ord->user->name ?? 'Pelanggan' }}</div>
                        </td>
                        <td class="px-5 py-3 text-right">
                            <div class="text-sm font-black text-slate-800">Rp{{ number_format($ord->total_price, 0, ',', '.') }}</div>
                            <div class="text-[10px] text-green-600 font-bold mt-0.5">Selesai</div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="px-5 py-8 text-center">
                            <svg class="w-10 h-10 text-slate-300 mx-auto mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                            <p class="text-sm text-slate-500 font-medium">Belum ada pesanan sparepart di periode ini.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @endif
</div>
@endsection
