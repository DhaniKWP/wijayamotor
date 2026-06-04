@extends('layouts.admin')

@section('title', 'Manajemen Booking - Wijaya Motor')
@section('header_title', 'Manajemen Booking Servis')

@section('content')

@if(session('success'))
<div class="bg-emerald-50 border border-emerald-100 text-emerald-600 px-4 py-3.5 rounded-lg mb-6 flex items-center text-sm font-semibold shadow-sm">
    <svg class="w-5 h-5 mr-2 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
    {{ session('success') }}
</div>
@endif

<div class="bg-white rounded-xl border border-slate-200/60 overflow-hidden shadow-sm">
    <div class="p-6 border-b border-slate-100 flex flex-col md:flex-row md:items-center justify-between gap-4 bg-slate-50/50">
        <div>
            <h2 class="text-base font-extrabold text-slate-800 tracking-tight uppercase">Daftar Antrean & Persetujuan</h2>
            <p class="text-xs text-slate-400 font-bold uppercase tracking-wider mt-0.5">Kelola status pesanan masuk dan konfirmasi kehadiran pelanggan</p>
        </div>
        
        <form action="{{ route('admin.bookings.index') }}" method="GET" class="flex space-x-2 animate-none" id="filterForm">
            <select name="status" onchange="document.getElementById('filterForm').submit()" class="text-xs border border-slate-200 rounded-lg focus:ring-brand/50 focus:border-brand py-2.5 pl-3 pr-10 text-slate-600 font-extrabold bg-white shadow-sm transition-all cursor-pointer">
                <option value="">Semua Status</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Menunggu Persetujuan</option>
                <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Disetujui / Terjadwal</option>
                <option value="process" {{ request('status') == 'process' ? 'selected' : '' }}>Sedang Dikerjakan</option>
                <option value="done" {{ request('status') == 'done' ? 'selected' : '' }}>Selesai Servis</option>
            </select>
        </form>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-slate-100">
            <thead class="bg-slate-50/20">
                <tr>
                    <th class="px-6 py-4 text-left text-[10px] font-extrabold text-slate-500 uppercase tracking-wider">Jadwal & Tipe</th>
                    <th class="px-6 py-4 text-left text-[10px] font-extrabold text-slate-500 uppercase tracking-wider">Pelanggan & Kendaraan</th>
                    <th class="px-6 py-4 text-left text-[10px] font-extrabold text-slate-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-4 text-right text-[10px] font-extrabold text-slate-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-slate-50">
                @forelse($bookings as $booking)
                <tr class="hover:bg-slate-50/50 transition-colors">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-bold text-slate-800">{{ \Carbon\Carbon::parse($booking->tanggal)->translatedFormat('d M Y') }}</div>
                        <div class="text-xs text-slate-400 font-bold tracking-wider mt-1 uppercase">{{ \Carbon\Carbon::parse($booking->jam)->format('H:i') }} WIB</div>
                        <div class="mt-2 flex items-center gap-1.5">
                            @if($booking->tipe_booking === 'home_service')
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-[10px] font-bold bg-blue-50 text-blue-700 border border-blue-100">
                                    Home Service
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-[10px] font-bold bg-indigo-50 text-indigo-700 border border-indigo-100">
                                    Layanan Bengkel
                                </span>
                            @endif

                            @if($booking->kilometer)
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-brand/10 text-brand">
                                    {{ number_format($booking->kilometer, 0, ',', '.') }} KM
                                </span>
                            @endif
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm font-bold text-slate-800">{{ $booking->user->name ?? $booking->user->username ?? 'Pelanggan' }}</div>
                        <div class="flex items-center gap-2 mt-1.5 flex-wrap">
                            <span class="inline-block text-[10px] font-bold bg-slate-100 text-slate-600 px-2 py-0.5 rounded tracking-wide uppercase">
                                {{ $booking->vehicle->plat_nomor ?? $booking->vehicle->plate_number ?? '-' }}
                            </span>
                            <span class="text-xs text-slate-500 font-medium">
                                {{ $booking->vehicle->name ?? '-' }}
                            </span>
                        </div>
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
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                        <button type="button" data-id="{{ $booking->id }}" onclick="openDetailModal(this.getAttribute('data-id'))" class="bg-slate-100 hover:bg-slate-200 text-slate-700 px-3 py-2 rounded-lg text-xs font-bold transition-all duration-200 inline-flex items-center gap-1 shadow-sm focus:outline-none">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            Detail
                        </button>   
                        @if($booking->status == 'pending')
                            <form action="{{ route('admin.bookings.accept', $booking->id) }}" method="POST" class="inline-block">
                                @csrf
                                <button type="submit" class="bg-emerald-500 hover:bg-emerald-600 text-white px-3 py-2 rounded-lg text-xs font-bold shadow-sm transition-all duration-200 focus:outline-none">Terima</button>
                            </form>
                            <form action="{{ route('admin.bookings.reject', $booking->id) }}" method="POST" class="inline-block">
                                @csrf
                                <button type="submit" class="bg-rose-50 hover:bg-rose-100 text-rose-600 border border-rose-200 px-3 py-2 rounded-lg text-xs font-bold transition-all duration-200 focus:outline-none">Tolak</button>
                            </form>
                        @elseif($booking->status == 'confirmed')
                            <form action="{{ route('admin.bookings.process', $booking->id) }}" method="POST" class="inline-block">
                                @csrf
                                <button type="submit" class="bg-ink hover:bg-ink-light text-white px-4 py-2 rounded-lg text-xs font-bold shadow-sm transition-all duration-200 focus:outline-none">Mulai Kerjakan</button>
                            </form>
                        @elseif($booking->status == 'process')
                            <form action="{{ route('admin.bookings.complete', $booking->id) }}" method="POST" class="inline-block">
                                @csrf
                                <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-lg text-xs font-bold shadow-sm transition-all duration-200 focus:outline-none">Selesaikan Servis</button>
                            </form>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-6 py-16 text-center">
                        <div class="w-14 h-14 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4 text-slate-300 border border-slate-100">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                        </div>
                        <p class="text-slate-400 text-sm font-semibold">Tidak ada data booking dengan status tersebut.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/50">
        {{ $bookings->links() }}
    </div>
</div>

<div id="modalDetail" class="fixed inset-0 z-50 hidden bg-slate-900/60 backdrop-blur-sm overflow-hidden h-full w-full flex items-center justify-center p-4">
    <div class="relative w-full max-w-2xl bg-white rounded-xl shadow-2xl overflow-hidden flex flex-col max-h-[90vh]">
        <!-- Modal Header -->
        <div class="bg-gradient-to-r from-ink to-[#112a4f] text-white px-6 py-5 border-b border-white/5 flex justify-between items-center shrink-0">
            <div>
                <h3 class="text-base font-extrabold text-white tracking-tight uppercase flex items-center gap-2">
                    <svg class="w-5 h-5 text-brand" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    Detail Booking Servis
                </h3>
                <p class="text-[10px] text-slate-300 font-bold uppercase tracking-wider mt-1">Kode Transaksi: <span class="text-brand font-black" id="modalId"></span></p>
            </div>
            <button onclick="closeModal()" class="text-slate-400 hover:text-white hover:bg-white/10 transition-all duration-200 rounded-full p-2">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        
        <!-- Modal Body -->
        <div class="p-6 space-y-6 overflow-y-auto custom-scrollbar flex-1 bg-slate-50/30">
            
            <!-- Status & Method Banner -->
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 p-4 bg-white border border-slate-200/60 rounded-xl shadow-sm">
                <div class="flex items-center gap-3">
                    <div class="p-2 bg-slate-50 rounded-lg border border-slate-200/50 text-slate-400">
                        <svg class="w-5 h-5 text-brand" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div>
                        <span class="text-[9px] text-slate-400 font-extrabold uppercase tracking-wider block mb-0.5">Status Booking</span>
                        <div id="modalStatusBadge"></div>
                    </div>
                </div>
                <div class="flex items-center gap-3 sm:text-right sm:flex-row-reverse">
                    <div class="p-2 bg-slate-50 rounded-lg border border-slate-200/50 text-slate-400">
                        <svg class="w-5 h-5 text-brand" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/>
                        </svg>
                    </div>
                    <div class="text-left sm:text-right">
                        <span class="text-[9px] text-slate-400 font-extrabold uppercase tracking-wider block mb-0.5">Metode Servis</span>
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg text-xs font-black bg-ink text-white border border-white/10 shadow-sm" id="modalTipe">-</span>
                    </div>
                </div>
            </div>

            <!-- Customer & Vehicle Info Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-gradient-to-br from-slate-50/50 to-white border border-slate-200/60 rounded-xl p-5 shadow-sm hover:border-slate-355/70 transition-colors duration-300">
                    <h4 class="text-xs font-bold text-slate-500 uppercase tracking-widest border-b border-slate-100 pb-2.5 mb-3.5 flex items-center gap-2">
                        <svg class="w-4 h-4 text-brand shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        Informasi Pelanggan
                    </h4>
                    <ul class="space-y-3.5 text-sm">
                        <li>
                            <span class="text-slate-400 block text-[9px] font-extrabold uppercase tracking-widest">Nama Pelanggan</span> 
                            <span class="font-extrabold text-slate-800" id="modalNama">-</span>
                        </li>
                        <li>
                            <span class="text-slate-400 block text-[9px] font-extrabold uppercase tracking-widest">No. Telepon / WA</span> 
                            <span class="font-bold text-slate-700" id="modalPhone">-</span>
                        </li>
                    </ul>
                </div>
                
                <div class="bg-gradient-to-br from-slate-50/50 to-white border border-slate-200/60 rounded-xl p-5 shadow-sm hover:border-slate-355/70 transition-colors duration-300">
                    <h4 class="text-xs font-bold text-slate-500 uppercase tracking-widest border-b border-slate-100 pb-2.5 mb-3.5 flex items-center gap-2">
                        <svg class="w-4 h-4 text-brand shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 16V17C19 18.1046 18.1046 19 17 19H16C14.8954 19 14 18.1046 14 17V16M10 16V17C10 18.1046 9.10457 19 8 19H7C5.89543 19 5 17 5 17V16M3 11L5.3409 6.31819C5.7483 5.5034 6.57793 5 7.4915 5H16.5085C17.4221 5 18.2517 5.5034 18.6591 6.31819L21 11M3 11V16H21V11M3 11H21"/>
                        </svg>
                        Informasi Kendaraan
                    </h4>
                    <ul class="space-y-3.5 text-sm">
                        <li>
                            <span class="text-slate-400 block text-[9px] font-extrabold uppercase tracking-widest mb-1.5">Plat Nomor</span> 
                            <div class="inline-flex items-center gap-2">
                                <span class="inline-block text-xs font-mono font-bold bg-slate-900 text-white border border-slate-700 px-3 py-1 rounded shadow-sm tracking-widest uppercase" id="modalPlat">-</span>
                                <span class="text-[9px] text-slate-400 font-bold uppercase tracking-wider">PLAT INDONESIA</span>
                            </div>
                        </li>
                        <li>
                            <span class="text-slate-400 block text-[9px] font-extrabold uppercase tracking-widest">Merek & Model</span> 
                            <span class="font-extrabold text-slate-800" id="modalMerek">-</span>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Service details & location grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-gradient-to-br from-slate-50/50 to-white border border-slate-200/60 rounded-xl p-5 shadow-sm hover:border-slate-355/70 transition-colors duration-300">
                    <h4 class="text-xs font-bold text-slate-500 uppercase tracking-widest border-b border-slate-100 pb-2.5 mb-3.5 flex items-center gap-2">
                        <svg class="w-4 h-4 text-brand shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"/>
                        </svg>
                        Detail Layanan
                    </h4>
                    <ul class="space-y-3.5 text-sm">
                        <li>
                            <span class="text-slate-400 block text-[9px] font-extrabold uppercase tracking-widest">Layanan Utama</span> 
                            <span class="font-extrabold text-slate-800" id="modalService">-</span>
                        </li>
                        <li>
                            <span class="text-slate-400 block text-[9px] font-extrabold uppercase tracking-widest mb-1">Jarak Tempuh</span> 
                            <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-black bg-brand/10 text-brand border border-brand/20" id="modalKm">-</span>
                        </li>
                        <li>
                            <span class="text-slate-400 block text-[9px] font-extrabold uppercase tracking-widest">Estimasi Harga Jasa Dasar</span> 
                            <span class="font-extrabold text-emerald-600 text-lg" id="modalHarga">-</span>
                        </li>
                    </ul>
                </div>

                <div class="bg-gradient-to-br from-slate-50/50 to-white border border-slate-200/60 rounded-xl p-5 shadow-sm hover:border-slate-355/70 transition-colors duration-300 flex flex-col justify-between">
                    <div>
                        <h4 class="text-xs font-bold text-slate-500 uppercase tracking-widest border-b border-slate-100 pb-2.5 mb-3.5 flex items-center gap-2">
                            <svg class="w-4 h-4 text-brand shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            Lokasi Pelaksanaan
                        </h4>
                        <div>
                            <span class="text-slate-400 block text-[9px] font-extrabold uppercase tracking-widest mb-2" id="labelLokasi">Lokasi:</span>
                            <p class="text-xs font-semibold text-slate-700 bg-white p-3 rounded-lg border border-slate-200/60 leading-relaxed shadow-inner" id="modalLokasi">-</p>
                        </div>
                    </div>
                    
                    <div class="mt-4">
                        <span class="text-slate-400 block text-[9px] font-extrabold uppercase tracking-widest mb-2">Pekerjaan Tambahan (Add-ons)</span>
                        <div class="flex flex-wrap gap-1.5" id="modalAddons"></div>
                    </div>
                </div>
            </div>

            <!-- Catatan/Keluhan Section -->
            <div>
                <h4 class="text-xs font-bold text-slate-500 uppercase tracking-widest pb-2 mb-3 flex items-center gap-2">
                    <svg class="w-4 h-4 text-brand shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>
                    </svg>
                    Keluhan & Catatan Khusus
                </h4>
                <div id="modalKeluhanWrapper" class="rounded-xl p-4 shadow-sm transition-all duration-300">
                    <p id="modalKeluhan" class="leading-relaxed">-</p>
                </div>
            </div>
        </div>

        <!-- Modal Footer -->
        <div class="bg-slate-50 px-6 py-4 border-t border-slate-100 flex justify-end shrink-0">
            <button onclick="closeModal()" class="px-6 py-2.5 bg-slate-900 hover:bg-slate-800 text-white rounded-lg text-xs font-black transition-all duration-200 shadow-lg shadow-slate-900/20 active:scale-95 focus:outline-none">Tutup Detail</button>
        </div>
    </div>
</div>

<script id="booking-data" type="application/json">
    {!! json_encode($bookings->items(), JSON_HEX_TAG) !!}
</script>
<script>
    const rawData = document.getElementById('booking-data').textContent;
    const bookingsData = JSON.parse(rawData);
    const bookingsMap = {};
    bookingsData.forEach(b => { bookingsMap[b.id] = b; });

    const addonLabels = {
        'spooring': 'Spooring & Balancing',
        'ac': 'AC Superlight Care',
        'engine': 'Engine Room Treatment',
        'engine_oil': 'Engine Oil',
        'brake_service': 'Brake Service',
        'engine_tune_up': 'Engine Tune Up',
        'fuel_filter': 'Replace Fuel Filter',
        'brake_pads': 'Replace Brake Pads',
        'reset_alarm': 'Reset Alarm',
        'engine_diagnose': 'Engine Diagnose',
        'other': 'Other Service'
    };

    function openDetailModal(id) {
        let data = bookingsMap[id];
        if(!data) return;

        document.getElementById('modalId').innerText = "WM-" + data.id;
        
        let statusBadge = document.getElementById('modalStatusBadge');
        let stat = data.status.toLowerCase();
        if(stat === 'pending') {
            statusBadge.innerHTML = `<span class="inline-flex items-center px-3 py-1.5 rounded-xl text-xs font-extrabold bg-amber-50 text-amber-700 border border-amber-100 shadow-sm">Pending</span>`;
        } else if(stat === 'confirmed') {
            statusBadge.innerHTML = `<span class="inline-flex items-center px-3 py-1.5 rounded-xl text-xs font-extrabold bg-emerald-50 text-emerald-700 border border-emerald-100 shadow-sm">Disetujui</span>`;
        } else if(stat === 'process') {
            statusBadge.innerHTML = `<span class="inline-flex items-center px-3 py-1.5 rounded-xl text-xs font-extrabold bg-blue-50 text-blue-700 border border-blue-100 gap-1.5 shadow-sm">
                <span class="relative flex h-2 w-2">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-blue-500"></span>
                </span>
                Dikerjakan
            </span>`;
        } else if(stat === 'done') {
            statusBadge.innerHTML = `<span class="inline-flex items-center px-3 py-1.5 rounded-xl text-xs font-extrabold bg-teal-50 text-teal-700 border border-teal-100 shadow-sm">Selesai</span>`;
        } else {
            statusBadge.innerHTML = `<span class="inline-flex items-center px-3 py-1.5 rounded-xl text-xs font-extrabold bg-rose-50 text-rose-700 border border-rose-100 shadow-sm">Ditolak</span>`;
        }

        let isHomeService = data.tipe_booking && data.tipe_booking.toLowerCase().includes('home');
        document.getElementById('modalTipe').innerText = isHomeService ? 'HOME SERVICE' : 'LAYANAN BENGKEL';
        document.getElementById('modalNama').innerText = data.user ? (data.user.name || data.user.username) : '-';
        document.getElementById('modalPhone').innerText = data.user ? (data.user.phone || data.user.no_telp || data.user.no_hp || '-') : '-';
        document.getElementById('modalPlat').innerText = data.vehicle ? (data.vehicle.plat_nomor || data.vehicle.plate_number || data.vehicle.nomor_polisi || '-') : '-';
        document.getElementById('modalMerek').innerText = data.vehicle ? (data.vehicle.merek || data.vehicle.merek_kendaraan || data.vehicle.brand || data.vehicle.name || '-') : '-';
        document.getElementById('modalService').innerText = data.service ? data.service.name : 'Servis Umum';
        document.getElementById('modalKm').innerText = data.kilometer ? data.kilometer.toLocaleString('id-ID') + ' KM' : '-';
        
        let harga = data.estimasi_harga ? parseFloat(data.estimasi_harga) : 0;
        document.getElementById('modalHarga').innerText = 'Rp ' + harga.toLocaleString('id-ID');

        if (isHomeService) {
            document.getElementById('labelLokasi').innerText = 'ALAMAT KUNJUNGAN:';
            document.getElementById('modalLokasi').innerText = data.alamat_lengkap || 'Alamat tidak diisi';
        } else {
            document.getElementById('labelLokasi').innerText = 'CABANG TUJUAN:';
            document.getElementById('modalLokasi').innerText = data.cabang ? ('Cabang ' + data.cabang.charAt(0).toUpperCase() + data.cabang.slice(1)) : 'Cabang Pusat';
        }

        let addonsContainer = document.getElementById('modalAddons');
        addonsContainer.innerHTML = ''; 
        if (data.addons && Array.isArray(data.addons) && data.addons.length > 0) {
            data.addons.forEach(addon => {
                let text = addonLabels[addon] || addon.charAt(0).toUpperCase() + addon.slice(1);
                addonsContainer.innerHTML += `<span class="px-2.5 py-1 bg-brand/10 text-brand border border-brand/20 rounded-lg text-xs font-bold shadow-sm">${text}</span>`;
            });
        } else {
            addonsContainer.innerHTML = `<span class="text-xs text-slate-400 italic">Tidak ada pekerjaan tambahan</span>`;
        }
        let keluhan = data.keluhan && data.keluhan !== '-' ? data.keluhan.trim() : '';
        let keluhanEl = document.getElementById('modalKeluhan');
        let keluhanWrapEl = document.getElementById('modalKeluhanWrapper');
        if (keluhan && keluhan !== '') {
            keluhanEl.innerText = keluhan;
            keluhanWrapEl.className = "bg-amber-50/70 border border-amber-200/70 rounded-2xl p-4 shadow-sm text-amber-900";
            keluhanEl.className = "text-amber-800 text-sm font-semibold leading-relaxed";
        } else {
            keluhanEl.innerText = "Tidak ada keluhan atau catatan khusus yang dicantumkan.";
            keluhanWrapEl.className = "bg-slate-50/50 border border-slate-200/40 rounded-2xl p-4 shadow-sm text-slate-400";
            keluhanEl.className = "text-slate-400 text-xs italic font-medium leading-relaxed";
        }
        document.getElementById('modalDetail').classList.remove('hidden');
    }
    
    function closeModal() { document.getElementById('modalDetail').classList.add('hidden'); }
</script>
@endsection