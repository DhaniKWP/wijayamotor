@extends('layouts.admin')

@section('title', 'Dashboard Admin - Wijaya Motor')
@section('header_title', 'Dashboard')

@section('content')

<!-- Header Welcome -->
<div class="mb-8 flex flex-col md:flex-row md:items-end justify-between gap-4">
    <div>
        <h2 class="text-2xl font-extrabold text-slate-800 tracking-tight">Halo, {{ Auth::user()->name }}! 👋</h2>
        <p class="text-sm text-slate-500 mt-1 font-medium">Berikut adalah pantauan ringkas operasional Wijaya Motor hari ini.</p>
    </div>
    <div class="flex items-center gap-3">
        <a href="{{ route('admin.orders.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-slate-200 text-slate-600 hover:text-slate-800 hover:border-slate-300 hover:bg-slate-50 text-sm font-bold rounded-xl shadow-sm transition-all hover:-translate-y-0.5">
            <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
            Pesanan Online
        </a>
        <a href="{{ route('admin.bookings.index') }}" class="inline-flex items-center px-4 py-2 bg-brand hover:bg-brand-dark text-white text-sm font-bold rounded-xl shadow-sm shadow-brand/20 transition-all hover:-translate-y-0.5">
            <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
            Kelola Antrean
        </a>
    </div>
</div>

<!-- Key Metrics Cards -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5 mb-8">
    
    <!-- Card 1 -->
    <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm hover:shadow-md transition-shadow relative overflow-hidden group">
        <div class="absolute -right-4 -top-4 w-24 h-24 bg-amber-50 rounded-full group-hover:scale-110 transition-transform duration-500 ease-out"></div>
        <div class="relative flex items-center gap-4">
            <div class="w-12 h-12 bg-amber-100 text-amber-600 rounded-xl flex items-center justify-center shrink-0 shadow-inner">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div>
                <p class="text-xs font-bold text-slate-500 uppercase tracking-wide">Menunggu Acc</p>
                <div class="flex items-baseline gap-1 mt-0.5">
                    <h3 class="text-2xl font-black text-slate-800">{{ $pendingCount }}</h3>
                    <span class="text-sm font-bold text-slate-400">Antrean</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Card 2 -->
    <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm hover:shadow-md transition-shadow relative overflow-hidden group">
        <div class="absolute -right-4 -top-4 w-24 h-24 bg-brand/5 rounded-full group-hover:scale-110 transition-transform duration-500 ease-out"></div>
        <div class="relative flex items-center gap-4">
            <div class="w-12 h-12 bg-brand/10 text-brand rounded-xl flex items-center justify-center shrink-0 shadow-inner">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            </div>
            <div>
                <p class="text-xs font-bold text-slate-500 uppercase tracking-wide">Jadwal Hari Ini</p>
                <div class="flex items-baseline gap-1 mt-0.5">
                    <h3 class="text-2xl font-black text-slate-800">{{ $todayCount }}</h3>
                    <span class="text-sm font-bold text-slate-400">Mobil</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Card 3 -->
    <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm hover:shadow-md transition-shadow relative overflow-hidden group">
        <div class="absolute -right-4 -top-4 w-24 h-24 bg-blue-50 rounded-full group-hover:scale-110 transition-transform duration-500 ease-out"></div>
        <div class="relative flex items-center gap-4">
            <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-xl flex items-center justify-center shrink-0 shadow-inner">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            </div>
            <div>
                <p class="text-xs font-bold text-slate-500 uppercase tracking-wide">Sedang Servis</p>
                <div class="flex items-baseline gap-1 mt-0.5">
                    <h3 class="text-2xl font-black text-slate-800">{{ $processCount }}</h3>
                    <span class="text-sm font-bold text-slate-400">Unit</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Card 4 -->
    <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm hover:shadow-md transition-shadow relative overflow-hidden group">
        <div class="absolute -right-4 -top-4 w-24 h-24 bg-emerald-50 rounded-full group-hover:scale-110 transition-transform duration-500 ease-out"></div>
        <div class="relative flex items-center gap-4">
            <div class="w-12 h-12 bg-emerald-100 text-emerald-600 rounded-xl flex items-center justify-center shrink-0 shadow-inner">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div>
                <p class="text-xs font-bold text-slate-500 uppercase tracking-wide">Selesai Bulan Ini</p>
                <div class="flex items-baseline gap-1 mt-0.5">
                    <h3 class="text-2xl font-black text-slate-800">{{ $doneMonthCount }}</h3>
                    <span class="text-sm font-bold text-slate-400">Mobil</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Card 5 (Pemasukan Hari Ini) -->
    <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm hover:shadow-md transition-shadow relative overflow-hidden group">
        <div class="absolute -right-4 -top-4 w-24 h-24 bg-indigo-50 rounded-full group-hover:scale-110 transition-transform duration-500 ease-out"></div>
        <div class="relative flex items-center gap-4">
            <div class="w-12 h-12 bg-indigo-100 text-indigo-600 rounded-xl flex items-center justify-center shrink-0 shadow-inner">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div>
                <p class="text-xs font-bold text-slate-500 uppercase tracking-wide">Pemasukan Hari Ini</p>
                <div class="flex items-baseline gap-1 mt-0.5">
                    <h3 class="text-xl font-black text-slate-800">Rp {{ number_format($todayRevenue, 0, ',', '.') }}</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Card 6 (Pemasukan Bulan Ini) -->
    <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm hover:shadow-md transition-shadow relative overflow-hidden group">
        <div class="absolute -right-4 -top-4 w-24 h-24 bg-violet-50 rounded-full group-hover:scale-110 transition-transform duration-500 ease-out"></div>
        <div class="relative flex items-center gap-4">
            <div class="w-12 h-12 bg-violet-100 text-violet-600 rounded-xl flex items-center justify-center shrink-0 shadow-inner">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"/></svg>
            </div>
            <div>
                <p class="text-xs font-bold text-slate-500 uppercase tracking-wide">Pemasukan Bulan Ini</p>
                <div class="flex items-baseline gap-1 mt-0.5">
                    <h3 class="text-xl font-black text-slate-800">Rp {{ number_format($monthRevenue, 0, ',', '.') }}</h3>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Bookings Table -->
<div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
    <div class="px-6 py-5 border-b border-slate-100 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h3 class="text-lg font-extrabold text-slate-800 tracking-tight">Antrean Masuk Terbaru</h3>
            <p class="text-sm text-slate-500 font-medium mt-0.5">5 antrean terakhir yang masuk ke dalam sistem</p>
        </div>
        <a href="{{ route('admin.bookings.index') }}" class="text-sm font-bold text-brand hover:text-brand-dark transition-colors inline-flex items-center">
            Lihat Semua Antrean &rarr;
        </a>
    </div>
    
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50/50 border-b border-slate-200/60">
                    <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider w-1/3">Pelanggan & Kendaraan</th>
                    <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider w-1/4">Layanan</th>
                    <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider w-1/4">Jadwal</th>
                    <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider text-right">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($recentBookings as $booking)
                <tr class="hover:bg-slate-50/80 transition-colors group">
                    <td class="px-6 py-4 align-top">
                        <div class="text-sm font-bold text-slate-800 mb-1">{{ $booking->user->name ?? 'Pelanggan' }}</div>
                        <div class="flex items-center gap-2">
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-slate-800 text-white tracking-widest font-mono">
                                {{ $booking->vehicle->plat_nomor ?? $booking->vehicle->plate_number ?? '-' }}
                            </span>
                            <span class="text-xs text-slate-500 font-medium truncate max-w-[150px]" title="{{ $booking->vehicle->name ?? '-' }}">
                                {{ $booking->vehicle->name ?? '-' }}
                            </span>
                        </div>
                    </td>
                    <td class="px-6 py-4 align-top">
                        <div class="text-sm font-bold text-slate-800 mb-1">{{ $booking->service->name ?? 'Servis Umum' }}</div>
                        @if($booking->tipe_booking === 'home_service')
                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md text-[10px] font-bold bg-indigo-50 text-indigo-600 border border-indigo-100">
                                Home Service
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md text-[10px] font-bold bg-slate-100 text-slate-600 border border-slate-200">
                                Di Bengkel
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-4 align-top">
                        <div class="text-sm font-semibold text-slate-700 mb-1">{{ \Carbon\Carbon::parse($booking->tanggal)->translatedFormat('d M Y') }}</div>
                        <span class="text-xs font-bold text-slate-400 uppercase tracking-wide">Sesi {{ ucfirst($booking->sesi) }}</span>
                    </td>
                    <td class="px-6 py-4 align-top text-right">
                        @if($booking->status == 'pending')
                            <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-bold bg-amber-50 text-amber-700 border border-amber-200">Menunggu</span>
                        @elseif($booking->status == 'confirmed')
                            <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-bold bg-blue-50 text-blue-700 border border-blue-200">Disetujui</span>
                        @elseif($booking->status == 'process')
                            <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-bold bg-orange-50 text-orange-700 border border-orange-200 gap-1.5">
                                <span class="relative flex h-1.5 w-1.5">
                                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-orange-400 opacity-75"></span>
                                    <span class="relative inline-flex rounded-full h-1.5 w-1.5 bg-orange-500"></span>
                                </span>
                                Dikerjakan
                            </span>
                        @elseif($booking->status == 'done')
                            <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">Selesai</span>
                        @elseif($booking->status == 'cancelled')
                            <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-bold bg-red-50 text-red-700 border border-red-200">Ditolak</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-6 py-16 text-center">
                        <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4 border border-slate-100 shadow-inner">
                            <svg class="w-8 h-8 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                        </div>
                        <h4 class="text-sm font-bold text-slate-600 mb-1">Belum ada antrean baru</h4>
                        <p class="text-xs text-slate-400 font-medium">Antrean yang baru masuk akan muncul di sini.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection