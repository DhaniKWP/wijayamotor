@extends('layouts.admin')

@section('title', 'Dashboard Admin - Wijaya Motor')
@section('header_title', 'Dashboard Overview')

@section('content')

<div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
    <div>
        <h2 class="text-xl md:text-2xl font-extrabold text-slate-800 tracking-tight">Selamat datang kembali, {{ Auth::user()->name }}! 👋</h2>
        <p class="text-sm text-slate-500 mt-1 font-medium">Berikut adalah ringkasan operasional dan antrean bengkel Wijaya Motor hari ini.</p>
    </div>
    <div class="text-xs font-bold text-slate-400 uppercase tracking-widest bg-slate-100 px-3.5 py-1.5 rounded-lg">
        {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-white rounded-xl p-5 border border-slate-200/50 shadow-sm flex items-center gap-4 hover:-translate-y-0.5 hover:shadow-md transition-all duration-300">
        <div class="w-12 h-12 bg-slate-100 text-slate-500 rounded-lg flex items-center justify-center shrink-0">
            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        </div>
        <div>
            <p class="text-[10px] font-extrabold text-slate-400 uppercase tracking-wider">Menunggu Acc</p>
            <p class="text-xl font-black text-slate-800 mt-1">{{ $pendingCount }} <span class="text-xs font-bold text-slate-400 uppercase">Antrean</span></p>
        </div>
    </div>

    <div class="bg-white rounded-xl p-5 border border-slate-200/50 shadow-sm flex items-center gap-4 hover:-translate-y-0.5 hover:shadow-md transition-all duration-300">
        <div class="w-12 h-12 bg-slate-100 text-slate-500 rounded-lg flex items-center justify-center shrink-0">
            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
        </div>
        <div>
            <p class="text-[10px] font-extrabold text-slate-400 uppercase tracking-wider">Jadwal Hari Ini</p>
            <p class="text-xl font-black text-slate-800 mt-1">{{ $todayCount }} <span class="text-xs font-bold text-slate-400 uppercase">Mobil</span></p>
        </div>
    </div>

    <div class="bg-white rounded-xl p-5 border border-slate-200/50 shadow-sm flex items-center gap-4 hover:-translate-y-0.5 hover:shadow-md transition-all duration-300">
        <div class="w-12 h-12 bg-slate-100 text-slate-500 rounded-lg flex items-center justify-center shrink-0">
            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
        </div>
        <div>
            <p class="text-[10px] font-extrabold text-slate-400 uppercase tracking-wider">Sedang Diproses</p>
            <p class="text-xl font-black text-slate-800 mt-1">{{ $processCount }} <span class="text-xs font-bold text-slate-400 uppercase">Unit</span></p>
        </div>
    </div>

    <div class="bg-white rounded-xl p-5 border border-slate-200/50 shadow-sm flex items-center gap-4 hover:-translate-y-0.5 hover:shadow-md transition-all duration-300">
        <div class="w-12 h-12 bg-slate-100 text-slate-500 rounded-lg flex items-center justify-center shrink-0">
            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        </div>
        <div>
            <p class="text-[10px] font-extrabold text-slate-400 uppercase tracking-wider">Selesai Bulan Ini</p>
            <p class="text-xl font-black text-slate-800 mt-1">{{ $doneMonthCount }} <span class="text-xs font-bold text-slate-400 uppercase">Mobil</span></p>
        </div>
    </div>
</div>

<div class="bg-white rounded-xl border border-slate-200/60 overflow-hidden shadow-sm">
    <div class="p-6 border-b border-slate-100 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-slate-50/50">
        <div>
            <h3 class="text-base font-extrabold text-slate-800 tracking-tight uppercase">Booking Masuk Terbaru</h3>
            <p class="text-xs text-slate-400 font-bold uppercase tracking-wider mt-0.5">5 antrean terakhir yang masuk ke dalam sistem</p>
        </div>
        <a href="{{ route('admin.bookings.index') }}" class="text-xs font-bold text-brand hover:text-brand-dark transition-colors inline-flex items-center gap-1">
            Lihat Semua Antrean
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        </a>
    </div>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-slate-100">
            <thead class="bg-slate-50/20">
                <tr>
                    <th class="px-6 py-4 text-left text-[10px] font-extrabold text-slate-500 uppercase tracking-wider">Pelanggan & Kendaraan</th>
                    <th class="px-6 py-4 text-left text-[10px] font-extrabold text-slate-500 uppercase tracking-wider">Layanan & Tipe</th>
                    <th class="px-6 py-4 text-left text-[10px] font-extrabold text-slate-500 uppercase tracking-wider">Jadwal Kedatangan</th>
                    <th class="px-6 py-4 text-left text-[10px] font-extrabold text-slate-500 uppercase tracking-wider">Status</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-slate-50">
                @forelse($recentBookings as $booking)
                <tr class="hover:bg-slate-50/50 transition-colors">
                    <td class="px-6 py-4">
                        <div class="text-sm font-bold text-slate-800">{{ $booking->user->name ?? 'Pelanggan' }}</div>
                        <div class="flex items-center gap-2 mt-1.5 flex-wrap">
                            <span class="inline-block text-[10px] font-bold bg-slate-100 text-slate-600 px-2 py-0.5 rounded tracking-wide uppercase">
                                {{ $booking->vehicle->plat_nomor ?? $booking->vehicle->plate_number ?? '-' }}
                            </span>
                            <span class="text-xs text-slate-500 font-medium">
                                {{ $booking->vehicle->name ?? '-' }}
                            </span>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm font-bold text-slate-800">{{ $booking->service->name ?? 'Servis Umum' }}</div>
                        <div class="flex items-center gap-1.5 mt-1.5">
                            @if($booking->tipe_booking === 'home_service')
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-[10px] font-bold bg-blue-50 text-blue-700 border border-blue-100">
                                    Home Service
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-[10px] font-bold bg-indigo-50 text-indigo-700 border border-indigo-100">
                                    Bengkel
                                </span>
                            @endif

                            @if($booking->kilometer)
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-brand/10 text-brand">
                                    {{ number_format($booking->kilometer, 0, ',', '.') }} KM
                                </span>
                            @endif
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-semibold text-slate-700">{{ \Carbon\Carbon::parse($booking->tanggal)->translatedFormat('d M Y') }}</div>
                        <div class="text-xs text-slate-400 font-bold tracking-wider mt-1 uppercase">{{ \Carbon\Carbon::parse($booking->jam)->format('H:i') }} WIB</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($booking->status == 'pending')
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-amber-50 text-amber-700 border border-amber-100">Pending</span>
                        @elseif($booking->status == 'confirmed')
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-100">Disetujui</span>
                        @elseif($booking->status == 'process')
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-blue-50 text-blue-700 border border-blue-100 gap-1">
                                <span class="relative flex h-2 w-2">
                                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-75"></span>
                                    <span class="relative inline-flex rounded-full h-2 w-2 bg-blue-500"></span>
                                </span>
                                Dikerjakan
                            </span>
                        @elseif($booking->status == 'done')
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-teal-50 text-teal-700 border border-teal-100">Selesai</span>
                        @elseif($booking->status == 'cancelled')
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-rose-50 text-rose-700 border border-rose-100">Ditolak</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-6 py-12 text-center">
                        <div class="w-12 h-12 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-3 text-slate-300 border border-slate-100">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                        </div>
                        <p class="text-slate-400 text-sm font-semibold">Belum ada booking masuk hari ini.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection