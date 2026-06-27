@extends('layouts.app')

@section('title', 'Pesanan Saya — Wijaya Motor')

@section('content')

{{-- Breadcrumb --}}
<div class="bg-white border-b border-gray-200 py-3">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-xs font-bold text-gray-500 tracking-wider uppercase flex items-center space-x-2">
        <a href="{{ url('/') }}" class="hover:text-danger transition">Home</a>
        <span>&rsaquo;</span>
        <a href="{{ route('dashboard') }}" class="hover:text-danger transition">Dashboard Profil</a>
        <span>&rsaquo;</span>
        <span class="text-ink">Pesanan Saya</span>
    </div>
</div>

@php
    // Tentukan tab aktif dari query string, default ke 'servis'
    $activeTab = request('tab', 'servis');
@endphp

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 grid grid-cols-1 lg:grid-cols-4 gap-8">

    {{-- Sidebar --}}
    <aside class="lg:col-span-1">
        <div class="mb-8">
            <p class="text-gray-500 text-sm">Halo,</p>
            <h2 class="text-xl font-black text-gray-900 leading-tight mb-2">{{ Auth::user()->name }}</h2>
            <p class="text-xs text-gray-400">{{ Auth::user()->email }}</p>
        </div>
        <nav class="space-y-1">
            <a href="{{ route('dashboard') }}" class="flex items-center px-2 py-3 text-gray-600 hover:text-danger transition border-b border-gray-100 font-medium">Dashboard Profil</a>
            <a href="{{ route('customer.pesanan') }}" class="flex items-center px-2 py-3 text-danger font-bold border-b border-gray-100">Pesanan Saya</a>
            <a href="{{ route('garasi.index') }}" class="flex items-center px-2 py-3 text-gray-600 hover:text-danger transition border-b border-gray-100 font-medium">Garasi Saya</a>
            <a href="{{ route('booking.create') }}" class="flex items-center px-2 py-3 text-gray-600 hover:text-danger transition border-b border-gray-100 font-medium">Booking Baru</a>
            
            <form method="POST" action="{{ route('logout') }}" class="block">
                @csrf
                <a href="{{ route('logout') }}"
                   onclick="event.preventDefault(); this.closest('form').submit();"
                   class="flex items-center px-2 py-3 text-gray-600 hover:text-danger transition border-b border-gray-100 font-medium">
                    Logout
                </a>
            </form>
        </nav>
    </aside>

    {{-- Main Content --}}
    <main class="lg:col-span-3">

        {{-- Page Header --}}
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
            <div>
                <h2 class="text-2xl font-black uppercase text-gray-900 tracking-tight">PESANAN SAYA</h2>
                <p class="text-gray-500 text-sm mt-1">Riwayat servis dan pembelian sparepart kendaraan Anda.</p>
            </div>
            <a href="{{ route('booking.create') }}" class="bg-gray-900 hover:bg-black text-white px-5 py-2.5 rounded-lg font-bold text-xs uppercase tracking-widest transition shadow-sm flex items-center shrink-0">
                <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                Booking Servis
            </a>
        </div>

        {{-- TABS --}}
        <div class="flex border-b border-gray-200 mb-6">
            <a href="{{ route('customer.pesanan') }}?tab=servis"
               class="px-5 py-3 text-xs font-bold uppercase tracking-wider border-b-2 transition
                      {{ $activeTab === 'servis' ? 'border-danger text-danger' : 'border-transparent text-gray-500 hover:text-gray-700' }}">
                Riwayat Servis
                @if($bookings->count() > 0)
                    <span class="ml-1.5 bg-gray-100 text-gray-600 text-[10px] font-bold px-1.5 py-0.5 rounded">{{ $bookings->count() }}</span>
                @endif
            </a>
            <a href="{{ route('customer.pesanan') }}?tab=sparepart"
               class="px-5 py-3 text-xs font-bold uppercase tracking-wider border-b-2 transition
                      {{ $activeTab === 'sparepart' ? 'border-danger text-danger' : 'border-transparent text-gray-500 hover:text-gray-700' }}">
                Pembelian Sparepart
                @if($orders->count() > 0)
                    <span class="ml-1.5 bg-gray-100 text-gray-600 text-[10px] font-bold px-1.5 py-0.5 rounded">{{ $orders->count() }}</span>
                @endif
            </a>
        </div>

        {{-- ============================== --}}
        {{-- TAB SERVIS                     --}}
        {{-- ============================== --}}
        @if($activeTab === 'servis')
        @php
            $addonLabels = [
                'spooring'        => 'Spooring & Balancing',
                'ac'              => 'AC Superlight Care',
                'engine'          => 'Engine Room Treatment',
                'engine_oil'      => 'Engine Oil',
                'brake_service'   => 'Brake Service',
                'engine_tune_up'  => 'Engine Tune Up',
                'fuel_filter'     => 'Replace Fuel Filter',
                'brake_pads'      => 'Replace Brake Pads',
                'reset_alarm'     => 'Reset Alarm',
                'engine_diagnose' => 'Engine Diagnose',
                'other'           => 'Other Service',
            ];
        @endphp

        @forelse($bookings as $booking)
        <div x-data="{ open: false, billOpen: false }" class="bg-white border border-gray-200 rounded-xl p-6 mb-6 shadow-sm hover:shadow-md transition">

            {{-- Card Header --}}
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center pb-4 border-b border-gray-100 gap-4">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-gray-50 border border-gray-100 rounded-lg flex items-center justify-center text-gray-400">
                        <svg class="w-6 h-6" viewBox="0 0 512 512" fill="currentColor"><path d="M135.2 117.4L109.1 192H402.9l-26.1-74.6C372.3 104.6 360.2 96 346.6 96H165.4c-13.6 0-25.7 8.6-30.2 21.4zM39.6 196.8L74.8 96.3C88.3 57.8 124.6 32 165.4 32H346.6c40.8 0 77.1 25.8 90.6 64.3l35.2 100.5c23.2 9.6 39.6 32.5 39.6 59.2V400v48c0 17.7-14.3 32-32 32H448c-17.7 0-32-14.3-32-32V400H96v48c0 17.7-14.3 32-32 32H32c-17.7 0-32-14.3-32-32V400 256c0-26.7 16.4-49.6 39.6-59.2zM128 288a32 32 0 1 0 -64 0 32 32 0 1 0 64 0zm288 32a32 32 0 1 0 0-64 32 32 0 1 0 0 64z"/></svg>
                    </div>
                    <div>
                        <div class="flex items-center gap-2 flex-wrap">
                            <h4 class="font-bold text-gray-900 text-lg leading-tight">{{ $booking->vehicle->name ?? '-' }}</h4>
                            <span class="text-[10px] font-bold bg-gray-100 text-gray-600 px-2 py-0.5 rounded tracking-wide uppercase">{{ $booking->vehicle->plate_number ?? $booking->vehicle->plat_nomor ?? '-' }}</span>
                        </div>
                        <p class="text-xs text-gray-400 font-medium mt-1 uppercase tracking-widest">#WM-{{ str_pad($booking->id, 5, '0', STR_PAD_LEFT) }}</p>
                    </div>
                </div>

                <div class="flex flex-wrap gap-2">
                    @if($booking->tipe_booking === 'home_service')
                        <span class="text-blue-600 bg-blue-50 px-2.5 py-1 rounded-md text-xs font-bold uppercase tracking-wider flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                            Home Service
                        </span>
                    @else
                        <span class="text-indigo-600 bg-indigo-50 px-2.5 py-1 rounded-md text-xs font-bold uppercase tracking-wider flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                            Layanan Bengkel
                        </span>
                    @endif

                    @if($booking->status === 'pending')
                        <span class="text-amber-600 bg-amber-50 px-2.5 py-1 rounded-md text-xs font-bold uppercase tracking-wider">Pending</span>
                    @elseif($booking->status === 'confirmed')
                        <span class="text-green-600 bg-green-50 px-2.5 py-1 rounded-md text-xs font-bold uppercase tracking-wider">Disetujui</span>
                    @elseif($booking->status === 'process')
                        <span class="text-blue-600 bg-blue-50 px-2.5 py-1 rounded-md text-xs font-bold uppercase tracking-wider inline-flex items-center gap-1.5">
                            <span class="w-1.5 h-1.5 rounded-full bg-blue-600 animate-pulse"></span>
                            Dikerjakan
                        </span>
                    @elseif($booking->status === 'done')
                        @if($booking->transaction && $booking->transaction->payment_status === 'pending')
                            <span class="text-red-600 bg-red-50 px-2.5 py-1 rounded-md text-xs font-bold uppercase tracking-wider border border-red-100">Belum Dibayar</span>
                        @else
                            <span class="text-green-600 bg-green-50 px-2.5 py-1 rounded-md text-xs font-bold uppercase tracking-wider">Selesai & Lunas</span>
                        @endif
                    @elseif($booking->status === 'cancelled')
                        <span class="text-gray-500 bg-gray-100 px-2.5 py-1 rounded-md text-xs font-bold uppercase tracking-wider">Dibatalkan</span>
                    @endif
                </div>
            </div>

            {{-- Card Body --}}
            <div class="py-5">
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 text-xs">
                    <div>
                        <p class="text-[9px] font-extrabold text-gray-400 uppercase tracking-widest mb-1">Layanan</p>
                        <p class="font-bold text-gray-900">{{ $booking->service->name ?? '-' }}</p>
                        @if($booking->kilometer)
                            <p class="text-[10px] text-gray-500 mt-0.5">{{ number_format($booking->kilometer, 0, ',', '.') }} KM</p>
                        @endif
                    </div>
                    <div>
                        <p class="text-[9px] font-extrabold text-gray-400 uppercase tracking-widest mb-1">Jadwal</p>
                        <p class="font-bold text-gray-900">{{ \Carbon\Carbon::parse($booking->tanggal)->translatedFormat('d M Y') }}</p>
                        <p class="text-gray-500">{{ \Carbon\Carbon::parse($booking->jam)->format('H:i') }} WIB</p>
                    </div>
                    <div>
                        <p class="text-[9px] font-extrabold text-gray-400 uppercase tracking-widest mb-1">Lokasi</p>
                        @if($booking->tipe_booking === 'home_service')
                            <p class="font-bold text-gray-900 line-clamp-2">{{ $booking->alamat_lengkap }}</p>
                        @else
                            <p class="font-bold text-gray-900">Cabang {{ ucfirst($booking->cabang ?? 'Pusat') }}</p>
                        @endif
                    </div>
                    <div>
                        <p class="text-[9px] font-extrabold text-gray-400 uppercase tracking-widest mb-1">
                            {{ $booking->status === 'done' ? 'Total Tagihan' : 'Estimasi Biaya' }}
                        </p>
                        @if($booking->status === 'done' && $booking->transaction)
                            <p class="font-black text-danger text-sm">Rp {{ number_format($booking->transaction->total_cost, 0, ',', '.') }}</p>
                        @else
                            <p class="font-bold text-gray-900">Rp {{ number_format($booking->estimasi_harga, 0, ',', '.') }}</p>
                        @endif
                    </div>
                </div>

                {{-- TAGIHAN (done + belum lunas) --}}
                @if($booking->status === 'done' && $booking->transaction)
                    @if($booking->transaction->payment_status === 'pending')
                    <div class="mt-5 border-t border-gray-100 pt-5">
                        <button @click="billOpen = !billOpen" class="w-full flex items-center justify-between text-xs font-bold text-red-700 bg-red-50 border border-red-100 rounded-lg px-5 py-3.5 hover:bg-red-100/50 transition uppercase tracking-wider">
                            <span class="flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                Lihat Rincian & Cara Pembayaran
                            </span>
                            <svg class="w-4 h-4 transition-transform duration-200" :class="billOpen ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/></svg>
                        </button>

                        <div x-show="billOpen" x-collapse x-cloak class="mt-4 space-y-4">
                            <div class="bg-white border border-gray-200 rounded-xl overflow-hidden">
                                <table class="w-full text-xs">
                                    <thead class="bg-gray-50 border-b border-gray-200">
                                        <tr>
                                            <th class="text-left px-5 py-3 text-[9px] font-bold text-gray-500 uppercase tracking-wider">Item / Pekerjaan</th>
                                            <th class="text-center px-5 py-3 text-[9px] font-bold text-gray-500 uppercase tracking-wider w-12">Qty</th>
                                            <th class="text-right px-5 py-3 text-[9px] font-bold text-gray-500 uppercase tracking-wider w-32">Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-100">
                                        <tr>
                                            <td class="px-5 py-3">
                                                <p class="font-bold text-gray-900">{{ $booking->service->name }}</p>
                                                <p class="text-[10px] text-gray-500">Layanan Dasar</p>
                                            </td>
                                            <td class="px-5 py-3 text-center text-gray-600 font-bold">1</td>
                                            <td class="px-5 py-3 text-right font-bold text-gray-900">Rp {{ number_format($booking->estimasi_harga, 0, ',', '.') }}</td>
                                        </tr>
                                        @foreach($booking->transaction->items as $item)
                                        <tr>
                                            <td class="px-5 py-3">
                                                <p class="font-bold text-gray-900">{{ $item->display_name }}</p>
                                                <p class="text-[10px] text-gray-500">{{ $item->item_type === 'sparepart' ? 'Sparepart' : 'Jasa Tambahan' }}</p>
                                            </td>
                                            <td class="px-5 py-3 text-center text-gray-600 font-bold">{{ $item->qty }}</td>
                                            <td class="px-5 py-3 text-right font-bold text-gray-900">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot class="border-t-2 border-gray-200 bg-gray-50">
                                        <tr>
                                            <td colspan="2" class="px-5 py-4 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Total Tagihan</td>
                                            <td class="px-5 py-4 text-right font-black text-danger text-base">Rp {{ number_format($booking->transaction->total_cost, 0, ',', '.') }}</td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>

                            <div class="border border-gray-200 rounded-xl p-5 bg-gray-50/50">
                                <p class="text-xs font-bold text-gray-900 uppercase tracking-wider mb-4 border-b border-gray-200 pb-2">Cara Pembayaran</p>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div class="border border-gray-200 rounded-lg p-4 bg-white">
                                        <div class="flex items-center gap-2 mb-2">
                                            <svg class="w-4 h-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                                            <p class="text-xs font-bold text-gray-900 uppercase tracking-wider">Tunai (Cash)</p>
                                        </div>
                                        <p class="text-xs text-gray-500 leading-relaxed">Bayar langsung di kasir bengkel saat mengambil kendaraan.</p>
                                    </div>
                                    <div class="border border-gray-200 rounded-lg p-4 bg-white">
                                        <div class="flex items-center gap-2 mb-3">
                                            <svg class="w-4 h-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                                            <p class="text-xs font-bold text-gray-900 uppercase tracking-wider">Transfer Bank</p>
                                        </div>
                                        <div class="space-y-1.5 text-xs">
                                            <div class="flex justify-between"><span class="text-gray-500">Bank</span><span class="font-bold text-gray-900">{{ $bankInfo['bank'] }}</span></div>
                                            <div class="flex justify-between"><span class="text-gray-500">Rekening</span><span class="font-bold text-gray-900 tracking-wider">{{ $bankInfo['nomor'] }}</span></div>
                                            <div class="flex justify-between"><span class="text-gray-500">A.N.</span><span class="font-bold text-gray-900">{{ $bankInfo['atas_nama'] }}</span></div>
                                        </div>
                                        <p class="text-[10px] text-gray-400 mt-3 border-t border-gray-100 pt-2">Tunjukkan bukti transfer kepada mekanik/kasir.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @else
                    <div class="mt-5 pt-5 border-t border-gray-100">
                        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                            <div class="bg-green-50 border border-green-200 rounded-lg px-5 py-3.5 flex items-center gap-3 flex-1 w-full">
                                <svg class="w-5 h-5 text-green-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                <div>
                                    <p class="text-sm font-bold text-gray-900">Pembayaran Lunas</p>
                                    <p class="text-xs text-gray-500">Total: Rp {{ number_format($booking->transaction->total_cost, 0, ',', '.') }} &bull; Via {{ $booking->transaction->payment_method === 'cash' ? 'Tunai' : 'Transfer' }}</p>
                                </div>
                            </div>
                            <button @click="billOpen = !billOpen" class="w-full sm:w-auto flex items-center justify-center gap-2 text-xs font-bold text-ink border border-gray-200 rounded-lg px-5 py-3.5 hover:bg-gray-50 transition uppercase tracking-wider shrink-0">
                                <span class="flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                    Lihat Invoice
                                </span>
                                <svg class="w-4 h-4 transition-transform duration-200" :class="billOpen ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/></svg>
                            </button>
                        </div>
                        
                        <div x-show="billOpen" x-collapse x-cloak class="mt-4 space-y-4">
                            <div class="bg-white border border-gray-200 rounded-xl overflow-hidden">
                                <table class="w-full text-xs">
                                    <thead class="bg-gray-50 border-b border-gray-200">
                                        <tr>
                                            <th class="text-left px-5 py-3 text-[9px] font-bold text-gray-500 uppercase tracking-wider">Item / Pekerjaan</th>
                                            <th class="text-center px-5 py-3 text-[9px] font-bold text-gray-500 uppercase tracking-wider w-12">Qty</th>
                                            <th class="text-right px-5 py-3 text-[9px] font-bold text-gray-500 uppercase tracking-wider w-32">Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-100">
                                        <tr>
                                            <td class="px-5 py-3">
                                                <p class="font-bold text-gray-900">{{ $booking->service->name }}</p>
                                                <p class="text-[10px] text-gray-500">Layanan Dasar</p>
                                            </td>
                                            <td class="px-5 py-3 text-center text-gray-600 font-bold">1</td>
                                            <td class="px-5 py-3 text-right font-bold text-gray-900">Rp {{ number_format($booking->estimasi_harga, 0, ',', '.') }}</td>
                                        </tr>
                                        @foreach($booking->transaction->items as $item)
                                        <tr>
                                            <td class="px-5 py-3">
                                                <p class="font-bold text-gray-900">{{ $item->display_name }}</p>
                                                <p class="text-[10px] text-gray-500">{{ $item->item_type === 'sparepart' ? 'Sparepart' : 'Jasa Tambahan' }}</p>
                                            </td>
                                            <td class="px-5 py-3 text-center text-gray-600 font-bold">{{ $item->qty }}</td>
                                            <td class="px-5 py-3 text-right font-bold text-gray-900">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot class="border-t-2 border-gray-200 bg-gray-50">
                                        <tr>
                                            <td colspan="2" class="px-5 py-4 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Total Tagihan</td>
                                            <td class="px-5 py-4 text-right font-black text-danger text-base">Rp {{ number_format($booking->transaction->total_cost, 0, ',', '.') }}</td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                    @endif
                @endif

                {{-- Detail Addon & Keluhan --}}
                @if(($booking->addons && is_array($booking->addons) && count($booking->addons) > 0) || ($booking->keluhan && $booking->keluhan !== '-'))
                    <div class="mt-4 pt-4 border-t border-gray-100 flex justify-end">
                        <button @click="open = !open" class="text-xs font-bold text-gray-500 hover:text-danger uppercase tracking-wider transition inline-flex items-center gap-1">
                            <span x-text="open ? 'Sembunyikan Rincian' : 'Lihat Keluhan & Layanan Tambahan'"></span>
                            <svg class="w-4 h-4 transform transition-transform" :class="open ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </button>
                    </div>
                    <div x-show="open" x-collapse x-cloak class="mt-4 border-t border-gray-100 pt-4">
                        <div class="bg-gray-50 rounded-lg p-4">
                            @if($booking->addons && is_array($booking->addons) && count($booking->addons) > 0)
                                <div class="mb-4">
                                    <span class="text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-2 block">Layanan Tambahan</span>
                                    <div class="flex flex-wrap gap-2">
                                        @foreach($booking->addons as $addon)
                                            <span class="inline-flex items-center px-3 py-1 bg-white border border-gray-200 rounded-md text-xs font-bold text-gray-700">
                                                {{ $addonLabels[$addon] ?? ucfirst(str_replace('_', ' ', $addon)) }}
                                            </span>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                            @if($booking->keluhan && $booking->keluhan !== '-')
                                <div>
                                    <span class="text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-1 block">Catatan Keluhan</span>
                                    <p class="text-xs text-gray-700 leading-relaxed italic bg-white p-3 rounded-md border border-gray-200">&ldquo;{{ $booking->keluhan }}&rdquo;</p>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif
            </div>
        </div>
        @empty
        <div class="border-2 border-dashed border-gray-200 rounded-xl bg-gray-50 p-10 text-center">
            <div class="w-16 h-16 bg-white shadow-sm rounded-full flex items-center justify-center mx-auto mb-4 text-gray-300">
                <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
            </div>
            <p class="text-gray-500 text-sm font-medium">Belum ada riwayat servis.</p>
            <a href="{{ route('booking.create') }}" class="inline-block mt-3 text-xs font-bold text-danger hover:underline uppercase tracking-wider">Buat Booking Sekarang &rarr;</a>
        </div>
        @endforelse
        @endif

        {{-- ============================== --}}
        {{-- TAB SPAREPART                  --}}
        {{-- ============================== --}}
        @if($activeTab === 'sparepart')
        @forelse($orders as $order)
        <div class="bg-white border border-gray-200 rounded-xl p-6 mb-6 shadow-sm hover:shadow-md transition">
            
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center pb-4 border-b border-gray-100 gap-3">
                <div>
                    <p class="text-xs text-gray-400 font-medium uppercase tracking-widest">#ORD-{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</p>
                    <p class="text-sm text-gray-500 mt-1">{{ $order->created_at->translatedFormat('d F Y, H:i') }} WIB</p>
                </div>
                <div>
                    @if($order->status === 'pending')
                        <span class="text-amber-600 bg-amber-50 px-2.5 py-1 rounded-md text-xs font-bold uppercase tracking-wider inline-flex items-center gap-1.5">
                            <span class="w-1.5 h-1.5 rounded-full bg-amber-400 animate-pulse"></span>
                            Menunggu Konfirmasi
                        </span>
                    @elseif($order->status === 'confirmed')
                        <span class="text-blue-600 bg-blue-50 px-2.5 py-1 rounded-md text-xs font-bold uppercase tracking-wider inline-flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            Siap Diambil
                        </span>
                    @elseif($order->status === 'done')
                        <span class="text-green-600 bg-green-50 px-2.5 py-1 rounded-md text-xs font-bold uppercase tracking-wider inline-flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            Selesai & Lunas
                        </span>
                    @endif
                </div>
            </div>

            {{-- Item List --}}
            <div class="py-4 space-y-3">
                @foreach($order->items as $item)
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-gray-50 border border-gray-100 rounded-lg flex items-center justify-center shrink-0 overflow-hidden">
                        @if($item->sparepart && $item->sparepart->image)
                            <img src="{{ asset('uploads/spareparts/' . $item->sparepart->image) }}" class="w-full h-full object-cover" alt="">
                        @else
                            <svg class="w-6 h-6 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        @endif
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="font-bold text-gray-900 text-sm truncate">{{ $item->sparepart->name ?? 'Produk dihapus' }}</p>
                        <p class="text-xs text-gray-500">{{ $item->qty }} unit &times; Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                    </div>
                    <p class="text-sm font-bold text-gray-900 shrink-0">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</p>
                </div>
                @endforeach
            </div>

            {{-- Footer --}}
            <div class="pt-4 border-t border-gray-100 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3">
                <div>
                    <p class="text-[9px] font-bold text-gray-400 uppercase tracking-widest">Total Pembayaran</p>
                    <p class="text-base font-black text-danger">Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
                </div>
                @if($order->status === 'pending')
                <div class="bg-amber-50 border border-amber-100 rounded-lg px-4 py-2.5 text-xs text-amber-700 font-bold">
                    Menunggu admin konfirmasi. Kami akan menyiapkan barang Anda.
                </div>
                @elseif($order->status === 'confirmed')
                <div class="bg-blue-50 border border-blue-100 rounded-lg px-4 py-2.5 text-xs text-blue-700 font-bold flex items-center gap-2">
                    <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z"/></svg>
                    Barang siap diambil! Silakan datang ke bengkel dan lakukan pembayaran.
                </div>
                @elseif($order->status === 'done')
                <div class="bg-gray-50 border border-gray-200 rounded-lg px-4 py-2.5 text-xs text-gray-600 font-bold flex items-center gap-2">
                    <svg class="w-4 h-4 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Pesanan Selesai · Bayar via {{ $order->payment_method === 'cash' ? 'Tunai' : 'Transfer' }}
                </div>
                @endif
            </div>
        </div>
        @empty
        <div class="border-2 border-dashed border-gray-200 rounded-xl bg-gray-50 p-10 text-center">
            <div class="w-16 h-16 bg-white shadow-sm rounded-full flex items-center justify-center mx-auto mb-4 text-gray-300">
                <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
            </div>
            <p class="text-gray-500 text-sm font-medium">Belum ada pembelian sparepart.</p>
            <a href="{{ route('sparepart.index') }}" class="inline-block mt-3 text-xs font-bold text-danger hover:underline uppercase tracking-wider">Lihat Katalog Sparepart &rarr;</a>
        </div>
        @endforelse
        @endif

    </main>
</div>

<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
@endsection
