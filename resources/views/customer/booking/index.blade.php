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
            <div class="h-32 flex items-center justify-center mb-6 text-ink group-hover:text-danger transition-colors duration-300">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-24 w-24 group-hover:scale-110 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.2">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M11.42 15.17L17.25 21A2.652 2.652 0 0021 17.25l-5.877-5.877M11.42 15.17l2.496-3.03c.317-.384.74-.626 1.208-.766M11.42 15.17l-4.655 5.653a2.548 2.548 0 11-3.586-3.586l6.837-5.63m5.108-.233c.55-.164 1.163-.188 1.743-.14a4.5 4.5 0 004.486-6.336l-3.276 3.277a3.004 3.004 0 01-2.25-2.25l3.276-3.276a4.5 4.5 0 00-6.336 4.486c.091 1.076-.071 2.264-.904 2.95l-.102.085m-1.745 1.437L5.909 7.5H4.5L2.25 3.75l1.5-1.5L7.5 4.5v1.409l4.26 4.26m-1.745 1.437l1.745-1.437m6.615 8.206L15.75 15.75M4.867 19.125h.008v.008h-.008v-.008z" />
                </svg>
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
            <div class="h-32 flex items-center justify-center mb-6 text-ink group-hover:text-danger transition-colors duration-300">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-24 w-24 group-hover:scale-110 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.2">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 01-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 00-3.213-9.193 2.056 2.056 0 00-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 00-10.026 0 1.106 1.106 0 00-.987 1.106v7.635m12-6.677v6.677m0 4.5v-4.5m0 0h-12" />
                </svg>
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