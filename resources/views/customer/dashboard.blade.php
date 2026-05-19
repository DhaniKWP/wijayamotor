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
        
        <div class="bg-white border border-gray-200 rounded-xl p-6">
            <h3 class="font-black text-ink mb-6 uppercase tracking-wider text-sm">PESANAN SERVIS ({{ $bookings->count() }})</h3>
            @forelse($bookings as $booking)
                <div class="border border-gray-100 rounded-lg p-4 mb-4 flex justify-between items-center shadow-sm">
                    <div>
                        <h4 class="font-bold text-ink">{{ $booking->vehicle->name }}</h4>
                        <p class="text-xs text-gray-500">{{ $booking->service->name }} — {{ $booking->tanggal }}</p>
                    </div>
                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=60x60&data=WM-{{ $booking->id }}" class="w-12 h-12 opacity-80">
                </div>
            @empty
                <p class="text-gray-400 text-sm italic">Belum ada pesanan servis.</p>
            @endforelse
        </div>
    </main>
</div>
@endsection