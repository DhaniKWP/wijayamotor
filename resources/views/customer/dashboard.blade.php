@extends('layouts.app')

@section('title', 'Dashboard Profil — Wijaya Motor')

@section('content')
<div class="bg-white border-b border-gray-200 py-3">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-xs font-bold text-gray-500 tracking-wider uppercase flex items-center space-x-2">
        <a href="{{ url('/') }}" class="hover:text-brand">Home</a>
        <span>&rsaquo;</span>
        <span class="text-ink">Dashboard Profil</span>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 grid grid-cols-1 lg:grid-cols-4 gap-8">
    <aside class="lg:col-span-1">
        <div class="mb-8">
            <p class="text-gray-500 text-sm">Halo,</p>
            <h2 class="text-xl font-black text-ink leading-tight mb-2">{{ Auth::user()->name }}</h2>
        </div>
        <nav class="space-y-1">
            <a href="#" class="flex items-center px-2 py-3 text-danger font-bold border-b border-gray-100">Dashboard Profil</a>
            <a href="{{ route('garasi.index') }}" class="flex items-center px-2 py-3 text-gray-600 hover:text-brand transition border-b border-gray-100">Garasi Saya</a>
            <a href="{{ route('booking.create') }}" class="flex items-center px-2 py-3 text-gray-600 hover:text-brand transition border-b border-gray-100">Booking Baru</a>
            
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

    <main class="lg:col-span-3">
        <div class="bg-gradient-to-r from-danger to-red-800 rounded-xl p-8 text-white mb-8 shadow-sm">
            <h2 class="text-2xl font-black uppercase">DASHBOARD PELANGGAN</h2>
            <p class="text-red-100">Kelola kendaraan dan pesanan servis Anda di sini.</p>
        </div>
        
        <div class="bg-white border border-gray-200 rounded-2xl p-6 md:p-8 shadow-sm">
            <h3 class="font-black text-ink mb-6 uppercase tracking-wider text-sm flex items-center gap-2">
                <svg class="w-5 h-5 text-brand" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                </svg>
                Daftar Pesanan Servis ({{ $bookings->count() }})
            </h3>
            
            @php
                $addonLabels = [
                    'spooring' => 'Spooring & Balancing',
                    'ac' => 'AC Superlight Care',
                    'engine' => 'Engine Room Treatment',
                    'engine_oil' => 'Engine Oil',
                    'brake_service' => 'Brake Service',
                    'engine_tune_up' => 'Engine Tune Up',
                    'fuel_filter' => 'Replace Fuel Filter',
                    'brake_pads' => 'Replace Brake Pads',
                    'reset_alarm' => 'Reset Alarm',
                    'engine_diagnose' => 'Engine Diagnose',
                    'other' => 'Other Service',
                ];
            @endphp

            @forelse($bookings as $booking)
                <div x-data="{ open: false }" class="bg-white border border-slate-100 rounded-2xl p-5 mb-5 hover:shadow-md hover:border-slate-200 transition-all duration-300 shadow-sm">
                    <!-- Header: Vehicle Name, Plate, Status, Booking Type -->
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 pb-4 border-b border-slate-100">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-slate-50 flex items-center justify-center text-slate-500 shrink-0">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                </svg>
                            </div>
                            <div>
                                <div class="flex items-center gap-2 flex-wrap">
                                    <h4 class="font-bold text-ink text-base leading-tight">{{ $booking->vehicle->name }}</h4>
                                    <span class="text-[10px] font-bold bg-slate-100 text-slate-600 px-2 py-0.5 rounded tracking-wide uppercase">
                                        {{ $booking->vehicle->plate_number }}
                                    </span>
                                </div>
                                <p class="text-xs text-slate-400 font-medium mt-0.5">Tahun Rilis: {{ $booking->vehicle->year }}</p>
                            </div>
                        </div>
                        
                        <div class="flex items-center gap-2 sm:self-center">
                            <!-- Tipe Booking Badge -->
                            @if($booking->tipe_booking === 'home_service')
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-blue-50 text-blue-700 border border-blue-100">
                                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                    </svg>
                                    Home Service
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-indigo-50 text-indigo-700 border border-indigo-100">
                                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                    </svg>
                                    Layanan Bengkel
                                </span>
                            @endif

                            <!-- Status Badge -->
                            @if($booking->status === 'pending')
                                <span class="px-3 py-1 rounded-full text-xs font-semibold bg-amber-50 text-amber-700 border border-amber-100">
                                    Pending
                                </span>
                            @elseif($booking->status === 'confirmed')
                                <span class="px-3 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-100">
                                    Disetujui
                                </span>
                            @elseif($booking->status === 'process')
                                <span class="px-3 py-1 rounded-full text-xs font-semibold bg-blue-50 text-blue-700 border border-blue-100 inline-flex items-center gap-1">
                                    <span class="relative flex h-2 w-2">
                                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-75"></span>
                                        <span class="relative inline-flex rounded-full h-2 w-2 bg-blue-500"></span>
                                    </span>
                                    Dikerjakan
                                </span>
                            @elseif($booking->status === 'done')
                                <span class="px-3 py-1 rounded-full text-xs font-semibold bg-teal-50 text-teal-700 border border-teal-100">
                                    Selesai
                                </span>
                            @elseif($booking->status === 'cancelled')
                                <span class="px-3 py-1 rounded-full text-xs font-semibold bg-rose-50 text-rose-700 border border-rose-100">
                                    Dibatalkan
                                </span>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Body: Details & QR Code -->
                    <div class="grid grid-cols-1 md:grid-cols-12 gap-5 pt-4">
                        <!-- Main Details column -->
                        <div class="md:col-span-9 space-y-4">
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <!-- Service Name -->
                                <div>
                                    <span class="text-[10px] uppercase font-bold text-slate-400 block tracking-wider mb-1">Layanan Utama</span>
                                    <p class="font-bold text-ink text-sm">
                                        {{ $booking->service->name }}
                                        @if($booking->kilometer)
                                            <span class="ml-1 text-[11px] font-bold text-brand bg-brand/10 px-2 py-0.5 rounded">
                                                {{ number_format($booking->kilometer, 0, ',', '.') }} KM
                                            </span>
                                        @endif
                                    </p>
                                </div>
                                
                                <!-- Date and Time -->
                                <div>
                                    <span class="text-[10px] uppercase font-bold text-slate-400 block tracking-wider mb-1">Jadwal Kedatangan</span>
                                    <p class="text-sm font-semibold text-slate-700 flex items-center gap-1.5">
                                        <svg class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        {{ \Carbon\Carbon::parse($booking->tanggal)->translatedFormat('d M Y') }} &bull; {{ \Carbon\Carbon::parse($booking->jam)->format('H:i') }} WIB
                                    </p>
                                </div>
                            </div>
                            
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <!-- Location/Address -->
                                <div>
                                    @if($booking->tipe_booking === 'home_service')
                                        <span class="text-[10px] uppercase font-bold text-slate-400 block tracking-wider mb-1">Alamat Servis</span>
                                        <p class="text-xs text-slate-600 font-medium flex items-start gap-1.5 leading-relaxed">
                                            <svg class="w-4 h-4 text-rose-500 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                            <span class="line-clamp-2" title="{{ $booking->alamat_lengkap }}">{{ $booking->alamat_lengkap }}</span>
                                        </p>
                                    @else
                                        <span class="text-[10px] uppercase font-bold text-slate-400 block tracking-wider mb-1">Lokasi Bengkel</span>
                                        <p class="text-sm font-semibold text-slate-700 flex items-center gap-1.5">
                                            <svg class="w-4 h-4 text-indigo-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                            </svg>
                                            Cabang {{ ucfirst($booking->cabang ?? 'Pusat') }}
                                        </p>
                                    @endif
                                </div>
                                
                                <!-- Price Estimate -->
                                <div>
                                    <span class="text-[10px] uppercase font-bold text-slate-400 block tracking-wider mb-1">Estimasi Biaya</span>
                                    <p class="text-base font-extrabold text-slate-900">
                                        Rp {{ number_format($booking->estimasi_harga, 0, ',', '.') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- QR Code Column -->
                        <div class="md:col-span-3 flex flex-col items-center justify-center border-t md:border-t-0 md:border-l border-slate-100 pt-4 md:pt-0 md:pl-4 shrink-0">
                            <div class="bg-white p-2 border border-slate-200 rounded-xl shadow-sm inline-block">
                                <img src="https://api.qrserver.com/v1/create-qr-code/?size=100x100&data=WM-{{ $booking->id }}" class="w-20 h-20" alt="QR Code Booking">
                            </div>
                            <span class="text-[10px] font-bold text-slate-400 mt-2 tracking-wide text-center">Tunjukkan QR saat tiba</span>
                        </div>
                    </div>
                    
                    <!-- Accordion/Collapse: Detail Add-ons & Keluhan -->
                    <div x-show="open" x-collapse x-cloak class="mt-4 pt-4 border-t border-slate-100 bg-slate-50 rounded-xl p-4">
                        <!-- Addons -->
                        @if($booking->addons && is_array($booking->addons) && count($booking->addons) > 0)
                            <div class="mb-4">
                                <span class="text-[10px] uppercase font-bold text-slate-400 block tracking-wider mb-2">Layanan Tambahan (Add-ons) / Pekerjaan</span>
                                <div class="flex flex-wrap gap-2">
                                    @foreach($booking->addons as $addon)
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg text-xs font-semibold bg-white border border-slate-200 text-slate-700 shadow-sm">
                                            <span class="w-1.5 h-1.5 rounded-full bg-brand"></span>
                                            {{ $addonLabels[$addon] ?? ucfirst(str_replace('_', ' ', $addon)) }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                        
                        <!-- Keluhan -->
                        @if($booking->keluhan && $booking->keluhan !== '-')
                            <div>
                                <span class="text-[10px] uppercase font-bold text-slate-400 block tracking-wider mb-1">Catatan Keluhan / Deskripsi</span>
                                <p class="text-xs text-slate-600 font-medium leading-relaxed italic bg-white p-3 rounded-lg border border-slate-200">
                                    &ldquo;{{ $booking->keluhan }}&rdquo;
                                </p>
                            </div>
                        @endif
                        
                        <!-- Home Service Address Detail -->
                        @if($booking->tipe_booking === 'home_service' && $booking->alamat_lengkap)
                            <div class="mt-4">
                                <span class="text-[10px] uppercase font-bold text-slate-400 block tracking-wider mb-1">Alamat Lengkap Kunjungan</span>
                                <p class="text-xs text-slate-700 font-medium leading-relaxed bg-white p-3 rounded-lg border border-slate-200">
                                    {{ $booking->alamat_lengkap }}
                                </p>
                            </div>
                        @endif
                    </div>
                    
                    <!-- Footer Button to Toggle Details -->
                    @if(($booking->addons && is_array($booking->addons) && count($booking->addons) > 0) || ($booking->keluhan && $booking->keluhan !== '-') || ($booking->tipe_booking === 'home_service'))
                        <div class="mt-4 pt-3 border-t border-slate-50 flex justify-end">
                            <button @click="open = !open" class="text-xs font-bold text-brand hover:text-brand-dark transition-all duration-200 inline-flex items-center gap-1">
                                <span x-text="open ? 'Sembunyikan Rincian' : 'Lihat Rincian Detail'"></span>
                                <svg class="w-4 h-4 transform transition-transform duration-200" :class="open ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                        </div>
                    @endif
                </div>
            @empty
                <div class="text-center py-10">
                    <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4 text-slate-300">
                        <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </div>
                    <p class="text-gray-400 text-sm font-semibold">Belum ada pesanan servis aktif.</p>
                    <a href="{{ route('booking.create') }}" class="inline-block mt-4 text-xs font-bold text-brand hover:text-brand-dark">Buat Booking Sekarang &rarr;</a>
                </div>
            @endforelse
        </div>
    </main>
</div>
@endsection