@extends('layouts.admin')

@section('title', 'Penjualan Offline - Wijaya Motor')
@section('header_title', 'Kasir Penjualan Offline')

@section('content')

@if(session('success'))
<div class="bg-emerald-50 border border-emerald-100 text-emerald-700 px-4 py-3.5 rounded-xl mb-6 flex items-center gap-2 text-sm font-semibold shadow-sm">
    <svg class="w-5 h-5 text-emerald-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
    {{ session('success') }}
</div>
@endif

{{-- Stat Cards --}}
<div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
    <div class="bg-white rounded-xl border border-slate-200 p-5 shadow-sm">
        <p class="text-[10px] font-extrabold text-slate-400 uppercase tracking-widest mb-1">Transaksi Hari Ini</p>
        <p class="text-2xl font-black text-slate-800">{{ $countToday }}</p>
        <p class="text-xs text-slate-400 mt-1">Penjualan offline</p>
    </div>
    <div class="bg-white rounded-xl border border-slate-200 p-5 shadow-sm">
        <p class="text-[10px] font-extrabold text-slate-400 uppercase tracking-widest mb-1">Pendapatan Hari Ini</p>
        <p class="text-2xl font-black text-brand">Rp {{ number_format($totalToday, 0, ',', '.') }}</p>
        <p class="text-xs text-slate-400 mt-1">Dari penjualan offline</p>
    </div>
    <div class="bg-white rounded-xl border border-slate-200 p-5 shadow-sm flex items-center justify-center">
        <a href="{{ route('admin.offline-sales.create') }}" class="inline-flex items-center gap-2 bg-brand hover:bg-brand-dark text-white px-6 py-3 rounded-xl text-sm font-black transition-all shadow-md hover:shadow-lg hover:-translate-y-0.5">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
            Transaksi Baru
        </a>
    </div>
</div>

{{-- Filter --}}
<div class="bg-white rounded-xl border border-slate-200 shadow-sm p-4 mb-4">
    <form method="GET" action="{{ route('admin.offline-sales.index') }}" class="flex flex-wrap gap-3 items-end">
        <div class="flex-1 min-w-[160px]">
            <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest block mb-1">Cari Nama Customer</label>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama..."
                class="w-full px-3 py-2 rounded-lg border border-slate-200 text-sm font-medium text-slate-700 focus:outline-none focus:ring-2 focus:ring-brand/20 focus:border-brand transition">
        </div>
        <div>
            <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest block mb-1">Tanggal</label>
            <input type="date" name="date" value="{{ request('date') }}"
                class="px-3 py-2 rounded-lg border border-slate-200 text-sm font-medium text-slate-700 focus:outline-none focus:ring-2 focus:ring-brand/20 focus:border-brand transition">
        </div>
        <button type="submit" class="px-4 py-2 bg-slate-800 hover:bg-slate-900 text-white text-xs font-black rounded-lg transition">Cari</button>
        <a href="{{ route('admin.offline-sales.index') }}" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-600 text-xs font-black rounded-lg transition">Reset</a>
    </form>
</div>

{{-- Tabel Riwayat --}}
<div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-slate-50 border-b border-slate-100">
                    <th class="text-left px-5 py-3.5 text-[10px] font-extrabold text-slate-400 uppercase tracking-widest">No. Nota</th>
                    <th class="text-left px-5 py-3.5 text-[10px] font-extrabold text-slate-400 uppercase tracking-widest">Customer</th>
                    <th class="text-left px-5 py-3.5 text-[10px] font-extrabold text-slate-400 uppercase tracking-widest">Item Terjual</th>
                    <th class="text-left px-5 py-3.5 text-[10px] font-extrabold text-slate-400 uppercase tracking-widest">Total</th>
                    <th class="text-left px-5 py-3.5 text-[10px] font-extrabold text-slate-400 uppercase tracking-widest">Bayar</th>
                    <th class="text-left px-5 py-3.5 text-[10px] font-extrabold text-slate-400 uppercase tracking-widest">Tanggal</th>
                    <th class="text-left px-5 py-3.5 text-[10px] font-extrabold text-slate-400 uppercase tracking-widest">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($sales as $sale)
                <tr class="hover:bg-slate-50/50 transition-colors">
                    <td class="px-5 py-4">
                        <span class="font-mono text-xs font-black text-slate-700">#OFF-{{ str_pad($sale->id, 5, '0', STR_PAD_LEFT) }}</span>
                    </td>
                    <td class="px-5 py-4">
                        <p class="font-bold text-slate-800 text-xs">{{ $sale->customer_name }}</p>
                        <p class="text-[10px] text-slate-400">Kasir: {{ $sale->admin->name ?? '-' }}</p>
                    </td>
                    <td class="px-5 py-4">
                        <div class="flex flex-wrap gap-1">
                            @foreach($sale->items->take(2) as $item)
                                <span class="inline-block bg-slate-100 text-slate-600 text-[10px] font-bold px-2 py-0.5 rounded-md">
                                    {{ $item->sparepart->name ?? '-' }} ({{ $item->qty }})
                                </span>
                            @endforeach
                            @if($sale->items->count() > 2)
                                <span class="text-[10px] text-slate-400 font-bold">+{{ $sale->items->count() - 2 }} lagi</span>
                            @endif
                        </div>
                    </td>
                    <td class="px-5 py-4">
                        <p class="font-black text-slate-800 text-sm">Rp {{ number_format($sale->total_amount, 0, ',', '.') }}</p>
                    </td>
                    <td class="px-5 py-4">
                        <span class="inline-flex items-center gap-1 text-[10px] font-black px-2.5 py-1 rounded-lg {{ $sale->payment_method === 'cash' ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-blue-50 text-blue-700 border border-blue-200' }}">
                            {{ $sale->payment_method === 'cash' ? '💵 Tunai' : '🏦 Transfer' }}
                        </span>
                    </td>
                    <td class="px-5 py-4">
                        <p class="text-xs font-semibold text-slate-600">{{ $sale->created_at->translatedFormat('d M Y') }}</p>
                        <p class="text-[10px] text-slate-400">{{ $sale->created_at->format('H:i') }} WIB</p>
                    </td>
                    <td class="px-5 py-4">
                        <a href="{{ route('admin.offline-sales.show', $sale->id) }}"
                           class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-slate-800 hover:bg-slate-900 text-white text-[10px] font-black uppercase tracking-wider rounded-lg transition shadow-sm">
                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                            Struk
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-5 py-16 text-center">
                        <div class="flex flex-col items-center gap-3">
                            <svg class="w-12 h-12 text-slate-200" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            <p class="text-sm font-bold text-slate-400">Belum ada riwayat penjualan offline</p>
                            <a href="{{ route('admin.offline-sales.create') }}" class="mt-1 inline-flex items-center gap-2 bg-brand text-white px-4 py-2 rounded-lg text-xs font-black transition hover:bg-brand-dark">
                                + Buat Transaksi Pertama
                            </a>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($sales->hasPages())
    <div class="px-5 py-4 border-t border-slate-100">
        {{ $sales->links() }}
    </div>
    @endif
</div>

@endsection
