@extends('layouts.app')

@section('title', 'Pilihan Layanan Servis — Wijaya Motor')

@section('content')

<div class="bg-white border-b border-gray-200 py-3">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-xs font-bold text-gray-500 tracking-wider uppercase flex items-center space-x-2">
        <a href="{{ url('/') }}" class="hover:text-brand">Home</a>
        <span>&rsaquo;</span>
        <span class="text-ink">Booking Service</span>
    </div>
</div>

<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    
    <div class="mb-10 text-center md:text-left">
        <h1 class="text-3xl font-black text-ink uppercase tracking-tight mb-2">BOOKING WIJAYA MOTOR</h1>
        <p class="text-gray-500 text-sm md:text-base">Layanan purna jual dari Wijaya Motor yang menawarkan jasa perbaikan berupa servis perawatan berkala untuk Anda.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-20">
        
        <a href="{{ route('booking.create') }}" class="bg-white border border-gray-200 rounded-xl p-8 flex flex-col items-center text-center shadow-sm hover:shadow-xl hover:border-brand transition-all duration-300 group">
            <div class="h-32 flex items-center justify-center mb-6">
                <img src="https://cdn-icons-png.flaticon.com/512/1973/1973807.png" alt="Layanan Bengkel" class="h-24 object-contain group-hover:scale-110 transition-transform duration-300">
            </div>
            <h3 class="text-lg font-black text-ink uppercase tracking-wider mb-3 group-hover:text-brand transition-colors">Layanan Bengkel</h3>
            <p class="text-gray-500 text-sm leading-relaxed mb-8 flex-1">
                Layanan purna jual dari Wijaya Motor yang menawarkan jasa perbaikan berupa servis perawatan berkala di cabang terdekat kami.
            </p>
            <div class="w-full flex justify-end items-center text-danger font-bold text-sm group-hover:text-red-700 transition-colors">
                PILIH LAYANAN 
                <svg class="w-4 h-4 ml-1 transform group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
            </div>
        </a>

        <a href="{{ route('booking.homeservice') }}" class="bg-white border border-gray-200 rounded-xl p-8 flex flex-col items-center text-center shadow-sm hover:shadow-xl hover:border-brand transition-all duration-300 group">
            <div class="h-32 flex items-center justify-center mb-6">
                <img src="https://cdn-icons-png.flaticon.com/512/2933/2933939.png" alt="Home Service" class="h-24 object-contain group-hover:scale-110 transition-transform duration-300">
            </div>
            <h3 class="text-lg font-black text-ink uppercase tracking-wider mb-3 group-hover:text-brand transition-colors">Home Service</h3>
            <p class="text-gray-500 text-sm leading-relaxed mb-8 flex-1">
                Bengkel bergerak yang dapat melakukan perawatan kendaraan di tempat pelanggan tanpa harus datang ke cabang.
            </p>
            <div class="w-full flex justify-end items-center text-danger font-bold text-sm group-hover:text-red-700 transition-colors">
                PILIH LAYANAN 
                <svg class="w-4 h-4 ml-1 transform group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
            </div>
        </a>

    </div>

</div>

@endsection