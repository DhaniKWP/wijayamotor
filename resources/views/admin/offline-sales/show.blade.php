@extends('layouts.admin')

@section('title', 'Struk Penjualan #OFF-' . str_pad($sale->id, 5, '0', STR_PAD_LEFT) . ' - Wijaya Motor')
@section('header_title', 'Struk Penjualan Offline')

@section('content')

@if(session('success'))
<div class="bg-emerald-50 border border-emerald-100 text-emerald-700 px-4 py-3.5 rounded-xl mb-6 flex items-center gap-2 text-sm font-semibold shadow-sm print:hidden">
    <svg class="w-5 h-5 text-emerald-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
    {{ session('success') }}
</div>
@endif

<div class="max-w-2xl mx-auto">

    {{-- Breadcrumb --}}
    <div class="flex items-center gap-2 text-xs font-bold text-slate-400 mb-5 print:hidden">
        <a href="{{ route('admin.offline-sales.index') }}" class="hover:text-brand transition-colors">Penjualan Offline</a>
        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
        <span class="text-slate-600">Struk #OFF-{{ str_pad($sale->id, 5, '0', STR_PAD_LEFT) }}</span>
    </div>

    {{-- Action Buttons --}}
    <div class="flex items-center justify-between mb-5 print:hidden">
        <a href="{{ route('admin.offline-sales.index') }}" class="inline-flex items-center gap-2 text-slate-500 hover:text-slate-700 text-sm font-bold transition-colors">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/></svg>
            Kembali
        </a>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.offline-sales.create') }}" class="inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2.5 rounded-lg text-xs font-black transition-all shadow-sm">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                Transaksi Baru
            </a>
            <button onclick="window.print()" class="inline-flex items-center gap-2 bg-slate-800 hover:bg-slate-900 text-white px-4 py-2.5 rounded-lg text-xs font-black transition-all shadow-sm">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                Cetak Struk
            </button>
        </div>
    </div>

    {{-- Struk Card --}}
    <div id="strukCard" class="bg-white border border-slate-200/60 rounded-xl shadow-sm overflow-hidden">

        {{-- Header --}}
        <div class="border-b border-gray-200 px-8 py-8 flex justify-between items-start bg-white">
            <div>
                <div class="flex items-center gap-3 mb-4">
                    <div>
                        <p class="text-gray-900 font-black text-xl tracking-tight">WIJAYA MOTOR</p>
                        <p class="text-gray-500 text-[10px] font-bold tracking-widest uppercase">Bengkel & Servis Resmi</p>
                    </div>
                </div>
                <p class="text-gray-500 text-xs">Jl. Raya Contoh No. 123, Kota</p>
                <p class="text-gray-500 text-xs">Telp: 021-12345678</p>
            </div>
            <div class="text-right">
                <p class="text-gray-400 text-[10px] font-bold uppercase tracking-widest mb-1">Nota Penjualan</p>
                <p class="text-gray-900 font-black text-2xl">#OFF-{{ str_pad($sale->id, 5, '0', STR_PAD_LEFT) }}</p>
                <p class="text-gray-400 text-[10px] mt-3 font-bold uppercase tracking-widest">Tanggal</p>
                <p class="text-gray-900 text-sm font-bold">{{ $sale->created_at->translatedFormat('d F Y, H:i') }} WIB</p>
                <p class="text-gray-400 text-[10px] mt-3 font-bold uppercase tracking-widest">Status</p>
                <span class="inline-block bg-emerald-100 text-emerald-700 text-[10px] font-black px-3 py-1 rounded-md mt-1 border border-emerald-200">LUNAS</span>
            </div>
        </div>

        <div class="px-8 py-6 space-y-6">

            {{-- Info Customer & Kasir --}}
            <div class="grid grid-cols-2 gap-6">
                <div>
                    <p class="text-[9px] font-extrabold text-slate-400 uppercase tracking-widest mb-2">Customer</p>
                    <p class="text-sm font-black text-slate-800">{{ $sale->customer_name }}</p>
                </div>
                <div>
                    <p class="text-[9px] font-extrabold text-slate-400 uppercase tracking-widest mb-2">Kasir</p>
                    <p class="text-sm font-black text-slate-800">{{ $sale->admin->name ?? '-' }}</p>
                </div>
            </div>

            {{-- Tabel Item --}}
            <div>
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-slate-50 border-y border-slate-100">
                            <th class="text-left px-4 py-3 text-[9px] font-extrabold text-slate-400 uppercase tracking-wider">Sparepart</th>
                            <th class="text-center px-4 py-3 text-[9px] font-extrabold text-slate-400 uppercase tracking-wider w-14">Qty</th>
                            <th class="text-right px-4 py-3 text-[9px] font-extrabold text-slate-400 uppercase tracking-wider w-32">Harga Satuan</th>
                            <th class="text-right px-4 py-3 text-[9px] font-extrabold text-slate-400 uppercase tracking-wider w-32">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @foreach($sale->items as $item)
                        <tr>
                            <td class="px-4 py-3">
                                <p class="font-bold text-slate-800 text-xs">{{ $item->sparepart->name ?? 'Sparepart' }}</p>
                                <p class="text-[10px] text-blue-500 font-bold">● Sparepart</p>
                            </td>
                            <td class="px-4 py-3 text-center text-xs font-bold text-slate-600">{{ $item->qty }}</td>
                            <td class="px-4 py-3 text-right text-xs font-bold text-slate-600">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                            <td class="px-4 py-3 text-right text-xs font-bold text-slate-800">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="bg-brand/5 border-t-2 border-brand/20">
                            <td colspan="3" class="px-4 py-4 text-right font-black text-slate-800 uppercase tracking-wider">GRAND TOTAL</td>
                            <td class="px-4 py-4 text-right font-black text-brand text-lg">Rp {{ number_format($sale->total_amount, 0, ',', '.') }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            {{-- Metode & Tanggal Cetak --}}
            <div class="flex items-center justify-between py-4 border-t border-slate-100">
                <div>
                    <p class="text-[9px] font-extrabold text-slate-400 uppercase tracking-widest mb-1">Metode Pembayaran</p>
                    <p class="text-sm font-black text-slate-800">
                        {{ $sale->payment_method === 'cash' ? 'Tunai (Cash)' : 'Transfer Bank' }}
                    </p>
                </div>
                <div class="text-right">
                    <p class="text-[9px] font-extrabold text-slate-400 uppercase tracking-widest mb-1">Dicetak pada</p>
                    <p class="text-xs font-bold text-slate-600">{{ now()->translatedFormat('d F Y, H:i') }} WIB</p>
                </div>
            </div>

            {{-- Footer --}}
            <div class="text-center py-4 border-t border-slate-100">
                <p class="text-xs text-slate-400 font-medium">Terima kasih telah berbelanja di <strong>Wijaya Motor</strong>.</p>
                <p class="text-[10px] text-slate-300 mt-1">Barang yang sudah dibeli tidak dapat dikembalikan.</p>
            </div>
        </div>
    </div>
</div>

<style>
    @media print {
        body * { visibility: hidden; }
        #strukCard, #strukCard * { visibility: visible; }
        #strukCard { position: fixed; top: 0; left: 0; width: 100%; }
    }
</style>

@endsection
