@extends('layouts.admin')

@section('title', 'Invoice Servis #WM-{{ $booking->id }} - Wijaya Motor')
@section('header_title', 'Invoice Servis')

@section('content')

@if(session('success'))
<div class="bg-emerald-50 border border-emerald-100 text-emerald-600 px-4 py-3.5 rounded-lg mb-6 flex items-center text-sm font-semibold shadow-sm">
    <svg class="w-5 h-5 mr-2 text-emerald-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
    {{ session('success') }}
</div>
@endif



<div class="max-w-3xl mx-auto space-y-5">

    {{-- Breadcrumb --}}
    <div class="flex items-center gap-2 text-xs font-bold text-slate-400">
        <a href="{{ route('admin.bookings.index') }}" class="hover:text-brand transition-colors">Manajemen Booking</a>
        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
        <span class="text-slate-600">Invoice #WM-{{ str_pad($booking->id, 5, '0', STR_PAD_LEFT) }}</span>
    </div>

    {{-- Action Buttons --}}
    <div class="flex items-center justify-between print:hidden">
        <a href="{{ route('admin.bookings.index') }}" class="inline-flex items-center gap-2 text-slate-500 hover:text-slate-700 text-sm font-bold transition-colors">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/></svg>
            Kembali
        </a>
        <div class="flex items-center gap-3">
            @if($booking->transaction->payment_status === 'pending')
            @php $bookingCode = str_pad($booking->id, 5, '0', STR_PAD_LEFT); @endphp
            <form action="{{ route('admin.bookings.mark.paid', $booking->id) }}" method="POST"
                  onsubmit="return confirm('Tandai pembayaran booking #WM-{{ $bookingCode }} sebagai LUNAS?')">
                @csrf
                <button type="submit" class="inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white px-5 py-2.5 rounded-lg text-xs font-black transition-all shadow-sm">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                    Tandai Lunas
                </button>
            </form>
            @else
            <span class="inline-flex items-center gap-1.5 bg-teal-50 text-teal-700 border border-teal-200 px-4 py-2.5 rounded-lg text-xs font-black">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                Sudah Lunas
            </span>
            @endif
            <button onclick="window.print()" class="inline-flex items-center gap-2 bg-slate-800 hover:bg-slate-900 text-white px-5 py-2.5 rounded-lg text-xs font-black transition-all shadow-sm">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                Cetak Invoice
            </button>
        </div>
    </div>


    {{-- Invoice Card --}}
    <div id="invoiceCard" class="bg-white border border-slate-200/60 rounded-xl shadow-sm overflow-hidden">

        {{-- Header Invoice --}}
        <div class="border-b border-gray-200 px-8 py-8 flex justify-between items-start bg-white">
            <div>
                <div class="flex items-center gap-3 mb-4">
                    <img src="{{ asset('uploads/logo.webp') }}" alt="Logo Wijaya Motor" class="h-14 w-auto object-contain">
                    <div>
                        <p class="text-gray-900 font-black text-xl tracking-tight">WIJAYA MOTOR</p>
                        <p class="text-gray-500 text-[10px] font-bold tracking-widest uppercase">Bengkel & Servis Resmi</p>
                    </div>
                </div>
                <p class="text-gray-500 text-xs">Jl. Raya Contoh No. 123, Kota</p>
                <p class="text-gray-500 text-xs">Telp: 021-12345678</p>
            </div>
            <div class="text-right">
                <p class="text-gray-400 text-[10px] font-bold uppercase tracking-widest mb-1">Invoice</p>
                <p class="text-gray-900 font-black text-2xl">#WM-{{ str_pad($booking->id, 5, '0', STR_PAD_LEFT) }}</p>
                <p class="text-gray-400 text-[10px] mt-3 font-bold uppercase tracking-widest">Tanggal Servis</p>
                <p class="text-gray-900 text-sm font-bold">{{ \Carbon\Carbon::parse($booking->tanggal)->translatedFormat('d F Y') }}</p>
                <p class="text-gray-400 text-[10px] mt-3 font-bold uppercase tracking-widest">Status Pembayaran</p>
                @if($booking->transaction->payment_status === 'paid')
                    <span class="inline-block bg-emerald-100 text-emerald-700 text-[10px] font-black px-3 py-1 rounded-md mt-1 border border-emerald-200">LUNAS</span>
                @else
                    <span class="inline-block bg-amber-100 text-amber-700 text-[10px] font-black px-3 py-1 rounded-md mt-1 border border-amber-200">BELUM LUNAS</span>
                @endif
            </div>
        </div>

        <div class="px-8 py-6 space-y-6">

            {{-- Info Pelanggan & Kendaraan --}}
            <div class="grid grid-cols-2 gap-6">
                <div>
                    <p class="text-[9px] font-extrabold text-slate-400 uppercase tracking-widest mb-2">Pelanggan</p>
                    <p class="text-sm font-black text-slate-800">{{ $booking->user->name ?? $booking->user->username ?? '-' }}</p>
                    <p class="text-xs text-slate-500 font-medium">{{ $booking->user->email ?? '-' }}</p>
                    <p class="text-xs text-slate-500 font-medium">{{ $booking->user->no_telp ?? $booking->user->phone ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-[9px] font-extrabold text-slate-400 uppercase tracking-widest mb-2">Kendaraan</p>
                    <p class="text-sm font-black text-slate-800">{{ $booking->vehicle->merek ?? $booking->vehicle->name ?? '-' }}</p>
                    <span class="inline-block font-mono text-xs font-black bg-slate-900 text-white px-3 py-1 rounded tracking-widest mt-1">
                        {{ $booking->vehicle->plat_nomor ?? $booking->vehicle->plate_number ?? '-' }}
                    </span>
                    @if($booking->kilometer)
                    <p class="text-xs text-slate-400 mt-1">{{ number_format($booking->kilometer, 0, ',', '.') }} KM saat servis</p>
                    @endif
                </div>
            </div>

            {{-- Tabel Rincian Pekerjaan --}}
            <div>
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-slate-50 border-y border-slate-100">
                            <th class="text-left px-4 py-3 text-[9px] font-extrabold text-slate-400 uppercase tracking-wider">Deskripsi</th>
                            <th class="text-center px-4 py-3 text-[9px] font-extrabold text-slate-400 uppercase tracking-wider w-14">Qty</th>
                            <th class="text-right px-4 py-3 text-[9px] font-extrabold text-slate-400 uppercase tracking-wider w-32">Harga Satuan</th>
                            <th class="text-right px-4 py-3 text-[9px] font-extrabold text-slate-400 uppercase tracking-wider w-32">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        {{-- Service Utama --}}
                        <tr class="bg-brand/5">
                            <td class="px-4 py-3">
                                <p class="font-bold text-slate-800 text-xs">{{ $booking->service->name ?? 'Layanan Utama' }}</p>
                                <p class="text-[10px] text-brand font-bold">● Jasa Dasar</p>
                            </td>
                            <td class="px-4 py-3 text-center text-xs font-bold text-slate-600">1</td>
                            <td class="px-4 py-3 text-right text-xs font-bold text-slate-600">
                                Rp {{ number_format($booking->estimasi_harga ?? 0, 0, ',', '.') }}
                            </td>
                            <td class="px-4 py-3 text-right text-xs font-bold text-slate-800">
                                Rp {{ number_format($booking->estimasi_harga ?? 0, 0, ',', '.') }}
                            </td>
                        </tr>

                        {{-- Item tambahan (jasa + sparepart) --}}
                        @foreach($booking->transaction->items as $item)
                        <tr>
                            <td class="px-4 py-3">
                                <p class="font-bold text-slate-800 text-xs">{{ $item->display_name }}</p>
                                <p class="text-[10px] font-bold {{ $item->item_type === 'sparepart' ? 'text-blue-500' : 'text-slate-400' }}">
                                    ● {{ $item->item_type === 'sparepart' ? 'Sparepart' : 'Jasa Tambahan' }}
                                </p>
                                @if($item->note)
                                <p class="text-[10px] text-slate-400 italic mt-0.5">{{ $item->note }}</p>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-center text-xs font-bold text-slate-600">{{ $item->qty }}</td>
                            <td class="px-4 py-3 text-right text-xs font-bold text-slate-600">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                            <td class="px-4 py-3 text-right text-xs font-bold text-slate-800">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="border-t-2 border-slate-100 bg-slate-50/50">
                            <td colspan="3" class="px-4 py-3 text-right text-xs font-extrabold text-slate-500 uppercase tracking-wider">Total Jasa</td>
                            <td class="px-4 py-3 text-right text-xs font-black text-slate-700">Rp {{ number_format($booking->transaction->service_cost, 0, ',', '.') }}</td>
                        </tr>
                        <tr class="bg-slate-50/50">
                            <td colspan="3" class="px-4 py-3 text-right text-xs font-extrabold text-slate-500 uppercase tracking-wider">Total Sparepart</td>
                            <td class="px-4 py-3 text-right text-xs font-black text-slate-700">Rp {{ number_format($booking->transaction->sparepart_cost, 0, ',', '.') }}</td>
                        </tr>
                        <tr class="bg-brand/5 border-t-2 border-brand/20">
                            <td colspan="3" class="px-4 py-4 text-right font-black text-slate-800 uppercase tracking-wider">GRAND TOTAL</td>
                            <td class="px-4 py-4 text-right font-black text-brand text-lg">Rp {{ number_format($booking->transaction->total_cost, 0, ',', '.') }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            {{-- Metode Pembayaran --}}
            <div class="flex items-center justify-between py-4 border-t border-slate-100">
                <div>
                    <p class="text-[9px] font-extrabold text-slate-400 uppercase tracking-widest mb-1">Metode Pembayaran</p>
                    <p class="text-sm font-black text-slate-800">
                        {{ $booking->transaction->payment_method === 'cash' ? '💵 Tunai (Cash)' : '🏦 Transfer Bank' }}
                    </p>
                </div>
                <div class="text-right">
                    <p class="text-[9px] font-extrabold text-slate-400 uppercase tracking-widest mb-1">Dicetak pada</p>
                    <p class="text-xs font-bold text-slate-600">{{ now()->translatedFormat('d F Y, H:i') }} WIB</p>
                </div>
            </div>

            {{-- Footer Note --}}
            <div class="text-center py-4 border-t border-slate-100">
                <p class="text-xs text-slate-400 font-medium">Terima kasih telah mempercayakan kendaraan Anda kepada <strong>Wijaya Motor</strong>.</p>
                <p class="text-[10px] text-slate-300 mt-1">Dokumen ini digenerate secara otomatis oleh sistem.</p>
            </div>
        </div>
    </div>

    {{-- Back button --}}
    <div class="print:hidden">
        <a href="{{ route('admin.bookings.index') }}" class="inline-flex items-center gap-2 text-slate-500 hover:text-slate-700 text-sm font-bold transition-colors">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/></svg>
            Kembali ke Daftar Booking
        </a>
    </div>
</div>

<style>
    @media print {
        body * { visibility: hidden; }
        #invoiceCard, #invoiceCard * { visibility: visible; }
        #invoiceCard { position: fixed; top: 0; left: 0; width: 100%; }
    }
</style>

@endsection
