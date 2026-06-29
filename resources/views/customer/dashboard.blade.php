@extends('layouts.app')

@section('title', 'Dashboard — Wijaya Motor')

@section('content')

{{-- Breadcrumb --}}
<div class="bg-white border-b border-gray-200 py-3 sticky top-20 z-40">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-xs font-bold text-gray-500 tracking-wider uppercase flex items-center space-x-2">
        <a href="{{ url('/') }}" class="hover:text-danger transition">Home</a>
        <span>&rsaquo;</span>
        <span class="text-ink">Dashboard Profil</span>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 grid grid-cols-1 lg:grid-cols-4 gap-8">

    {{-- Sidebar --}}
    <aside class="lg:col-span-1 lg:sticky lg:top-36 self-start">
        <div class="mb-8">
            <p class="text-gray-500 text-sm">Halo,</p>
            <h2 class="text-xl font-black text-gray-900 leading-tight mb-2">{{ Auth::user()->name }}</h2>
            <p class="text-xs text-gray-400">{{ Auth::user()->email }}</p>
        </div>
        <nav class="space-y-1">
            <a href="{{ route('dashboard') }}" class="flex items-center px-2 py-3 text-danger font-bold border-b border-gray-100">Dashboard Profil</a>
            <a href="{{ route('customer.pesanan') }}" class="flex items-center px-2 py-3 text-gray-600 hover:text-danger transition border-b border-gray-100 font-medium">Pesanan Saya</a>
            <a href="{{ route('garasi.index') }}" class="flex items-center px-2 py-3 text-gray-600 hover:text-danger transition border-b border-gray-100 font-medium">Garasi Saya</a>
            <a href="{{ route('booking.create') }}" class="flex items-center px-2 py-3 text-gray-600 hover:text-danger transition border-b border-gray-100 font-medium">Booking Baru</a>
            <a href="{{ route('customer.profile.settings') }}" class="flex items-center px-2 py-3 text-gray-600 hover:text-danger transition border-b border-gray-100 font-medium">Pengaturan Profil</a>
            
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

        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4">
            <div>
                <h2 class="text-2xl font-black uppercase text-gray-900 tracking-tight">DASHBOARD PELANGGAN</h2>
                <p class="text-gray-500 text-sm mt-1">Selamat datang kembali, kelola aktivitas bengkel Anda di sini.</p>
            </div>
            <a href="{{ route('booking.create') }}" class="bg-gray-900 hover:bg-black text-white px-5 py-2.5 rounded-lg font-bold text-xs uppercase tracking-widest transition shadow-sm flex items-center shrink-0">
                <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                Booking Servis
            </a>
        </div>

        {{-- Stat Cards --}}
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-8">
            <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm">
                <p class="text-3xl font-black text-gray-900 mb-1">{{ $vehicles }}</p>
                <p class="text-xs font-bold text-gray-500 uppercase tracking-widest">Kendaraan</p>
            </div>
            <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm">
                <p class="text-3xl font-black text-gray-900 mb-1">{{ $totalBookings }}</p>
                <p class="text-xs font-bold text-gray-500 uppercase tracking-widest">Total Servis</p>
            </div>
            <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm border-b-4 border-b-danger">
                <p class="text-3xl font-black text-danger mb-1">{{ $activeBookings }}</p>
                <p class="text-xs font-bold text-danger uppercase tracking-widest">Sedang Aktif</p>
            </div>
        </div>

        {{-- Booking Terakhir --}}
        <div>
            <h3 class="font-black text-gray-900 uppercase tracking-wider text-sm mb-4 flex items-center">
                <svg class="w-5 h-5 mr-2 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Booking Terakhir
            </h3>

            @if($latestBooking)
            <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center pb-5 border-b border-gray-100 gap-4">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-gray-50 border border-gray-100 rounded-lg flex items-center justify-center text-gray-400">
                            <svg class="w-6 h-6" viewBox="0 0 512 512" fill="currentColor"><path d="M135.2 117.4L109.1 192H402.9l-26.1-74.6C372.3 104.6 360.2 96 346.6 96H165.4c-13.6 0-25.7 8.6-30.2 21.4zM39.6 196.8L74.8 96.3C88.3 57.8 124.6 32 165.4 32H346.6c40.8 0 77.1 25.8 90.6 64.3l35.2 100.5c23.2 9.6 39.6 32.5 39.6 59.2V400v48c0 17.7-14.3 32-32 32H448c-17.7 0-32-14.3-32-32V400H96v48c0 17.7-14.3 32-32 32H32c-17.7 0-32-14.3-32-32V400 256c0-26.7 16.4-49.6 39.6-59.2zM128 288a32 32 0 1 0 -64 0 32 32 0 1 0 64 0zm288 32a32 32 0 1 0 0-64 32 32 0 1 0 0 64z"/></svg>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-900 text-lg leading-tight">{{ $latestBooking->vehicle->name ?? '-' }}</h4>
                            <p class="text-sm font-black text-danger tracking-widest mt-1 uppercase">{{ $latestBooking->vehicle->plate_number ?? $latestBooking->vehicle->plat_nomor ?? '-' }}</p>
                        </div>
                    </div>
                    
                    <div class="text-left sm:text-right">
                        <p class="text-sm font-bold text-gray-600 mb-1">{{ \Carbon\Carbon::parse($latestBooking->tanggal)->translatedFormat('d F Y') }}</p>
                        
                        @if($latestBooking->status === 'pending')
                            <span class="text-amber-600 bg-amber-50 px-2.5 py-1 rounded-md text-xs font-bold uppercase tracking-wider">Menunggu Konfirmasi</span>
                        @elseif($latestBooking->status === 'confirmed')
                            <span class="text-green-600 bg-green-50 px-2.5 py-1 rounded-md text-xs font-bold uppercase tracking-wider">Terjadwal</span>
                        @elseif($latestBooking->status === 'process')
                            <span class="text-blue-600 bg-blue-50 px-2.5 py-1 rounded-md text-xs font-bold uppercase tracking-wider inline-flex items-center">
                                <span class="w-1.5 h-1.5 rounded-full bg-blue-600 mr-1.5 animate-pulse"></span>
                                Dikerjakan
                            </span>
                        @elseif($latestBooking->status === 'done')
                            @if($latestBooking->transaction && $latestBooking->transaction->payment_status === 'pending')
                                <span class="text-red-600 bg-red-50 px-2.5 py-1 rounded-md text-xs font-bold uppercase tracking-wider">Menunggu Pembayaran</span>
                            @else
                                <span class="text-green-600 bg-green-50 px-2.5 py-1 rounded-md text-xs font-bold uppercase tracking-wider">Selesai & Lunas</span>
                            @endif
                        @elseif($latestBooking->status === 'cancelled')
                            <span class="text-gray-500 bg-gray-100 px-2.5 py-1 rounded-md text-xs font-bold uppercase tracking-wider">Dibatalkan</span>
                        @endif
                    </div>
                </div>

                {{-- Alert Tagihan --}}
                @if($latestBooking->status === 'done' && $latestBooking->transaction && $latestBooking->transaction->payment_status === 'pending')
                <div class="mt-4 bg-red-50 border border-red-100 rounded-lg p-4 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                        <div>
                            <p class="text-sm font-bold text-red-800">Tagihan belum dibayar</p>
                            <p class="text-xs text-red-600">Total: Rp {{ number_format($latestBooking->transaction->total_cost, 0, ',', '.') }}</p>
                        </div>
                    </div>
                    <a href="{{ route('customer.pesanan') }}" class="text-xs font-bold text-red-700 bg-white border border-red-200 px-4 py-2 rounded-lg hover:bg-red-50 transition uppercase tracking-wider text-center">Lihat Tagihan</a>
                </div>
                @endif

                <div class="mt-4 text-right">
                    <a href="{{ route('customer.pesanan') }}" class="text-xs font-bold text-danger hover:underline uppercase tracking-wider">Lihat Semua Pesanan &rarr;</a>
                </div>
            </div>
            @else
            <div class="border-2 border-dashed border-gray-200 rounded-xl bg-gray-50 p-10 text-center">
                <div class="w-14 h-14 bg-white shadow-sm rounded-full flex items-center justify-center mx-auto mb-4 text-gray-300">
                    <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                </div>
                <p class="text-gray-500 text-sm font-medium">Belum ada riwayat servis aktif.</p>
                <a href="{{ route('booking.create') }}" class="inline-block mt-3 text-xs font-bold text-danger hover:underline uppercase tracking-wider">Buat Booking Sekarang &rarr;</a>
            </div>
            @endif
        </div>

    </main>
</div>

@endsection