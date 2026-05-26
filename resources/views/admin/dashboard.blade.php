@extends('layouts.admin')

@section('title', 'Dashboard Admin - Wijaya Motor')
@section('header_title', 'Dashboard Overview')

@section('content')

<div class="mb-8">
    <h2 class="text-xl font-bold text-slate-800">Selamat datang, {{ Auth::user()->name }}! 👋</h2>
    <p class="text-sm text-slate-500 mt-1">Berikut adalah ringkasan operasional bengkel saat ini.</p>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-white rounded-2xl p-6 border border-slate-200/60 shadow-sm flex items-center gap-4">
        <div class="w-14 h-14 bg-amber-50 text-amber-500 rounded-xl flex items-center justify-center shrink-0">
            <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        </div>
        <div>
            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Menunggu Acc</p>
            <p class="text-2xl font-black text-slate-800">{{ $pendingCount }} <span class="text-sm font-medium text-slate-500">Antrean</span></p>
        </div>
    </div>

    <div class="bg-white rounded-2xl p-6 border border-slate-200/60 shadow-sm flex items-center gap-4">
        <div class="w-14 h-14 bg-blue-50 text-blue-500 rounded-xl flex items-center justify-center shrink-0">
            <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
        </div>
        <div>
            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Jadwal Hari Ini</p>
            <p class="text-2xl font-black text-slate-800">{{ $todayCount }} <span class="text-sm font-medium text-slate-500">Mobil</span></p>
        </div>
    </div>

    <div class="bg-white rounded-2xl p-6 border border-slate-200/60 shadow-sm flex items-center gap-4">
        <div class="w-14 h-14 bg-purple-50 text-purple-500 rounded-xl flex items-center justify-center shrink-0">
            <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
        </div>
        <div>
            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Sedang Diproses</p>
            <p class="text-2xl font-black text-slate-800">{{ $processCount }} <span class="text-sm font-medium text-slate-500">Unit</span></p>
        </div>
    </div>

    <div class="bg-white rounded-2xl p-6 border border-slate-200/60 shadow-sm flex items-center gap-4">
        <div class="w-14 h-14 bg-emerald-50 text-emerald-500 rounded-xl flex items-center justify-center shrink-0">
            <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        </div>
        <div>
            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Selesai Bulan Ini</p>
            <p class="text-2xl font-black text-slate-800">{{ $doneMonthCount }} <span class="text-sm font-medium text-slate-500">Mobil</span></p>
        </div>
    </div>
</div>

<div class="bg-white rounded-2xl border border-slate-200/60 overflow-hidden shadow-sm">
    <div class="p-6 border-b border-slate-100 flex justify-between items-center">
        <h3 class="text-lg font-bold text-slate-800">Booking Masuk Terbaru</h3>
        <a href="{{ route('admin.bookings.index') }}" class="text-sm font-bold text-[#FF8C00] hover:underline">Lihat Semua Data &rarr;</a>
    </div>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-slate-100">
            <thead class="bg-slate-50/50">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Pelanggan</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Jadwal</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Status</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-slate-50">
                @forelse($recentBookings as $booking)
                <tr class="hover:bg-slate-50/50 transition-colors">
                    <td class="px-6 py-4">
                        <div class="text-sm font-bold text-slate-800">{{ $booking->user->name ?? 'Pelanggan' }}</div>
                        <div class="text-xs text-slate-500 mt-1">{{ $booking->vehicle->plat_nomor ?? $booking->vehicle->plate_number ?? '-' }}</div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm font-bold text-slate-800">{{ \Carbon\Carbon::parse($booking->tanggal)->format('d M Y') }}</div>
                        <div class="text-xs text-slate-500 mt-1">{{ \Carbon\Carbon::parse($booking->jam)->format('H:i') }} WIB</div>
                    </td>
                    <td class="px-6 py-4">
                        @if($booking->status == 'pending')
                            <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-amber-100 text-amber-700">Pending</span>
                        @elseif($booking->status == 'confirmed')
                            <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-blue-100 text-blue-700">Disetujui</span>
                        @elseif($booking->status == 'process')
                            <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-purple-100 text-purple-700">Dikerjakan</span>
                        @elseif($booking->status == 'done')
                            <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-700">Selesai</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr><td colspan="3" class="px-6 py-8 text-center text-slate-500 text-sm">Belum ada booking masuk.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection