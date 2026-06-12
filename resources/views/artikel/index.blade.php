@extends('layouts.app')

@section('title', 'Tips & Berita — Wijaya Motor')

@section('content')

{{-- Breadcrumb --}}
<div class="bg-white border-b border-gray-200 py-3">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-xs font-bold text-gray-500 tracking-wider uppercase flex items-center space-x-2">
        <a href="{{ url('/') }}" class="hover:text-danger transition">Home</a>
        <span>&rsaquo;</span>
        <span class="text-ink">Tips & Berita</span>
    </div>
</div>

{{-- Page Header --}}
<div class="bg-white border-b border-gray-200 py-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-black uppercase text-gray-900 tracking-tight">TIPS & <span class="text-danger">BERITA</span></h1>
        <p class="text-gray-500 text-sm mt-2">Informasi dan tips perawatan kendaraan terbaru dari Wijaya Motor.</p>
    </div>
</div>

{{-- Daftar Artikel --}}
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">

        {{-- Artikel 1 --}}
        <a href="{{ route('artikel.kampas-rem') }}" class="bg-white border border-gray-200 rounded-xl overflow-hidden group hover:shadow-lg transition-all duration-300 flex flex-col">
            <img src="https://images.unsplash.com/photo-1588017530244-c57df911f73b?auto=format&fit=crop&w=800&q=80" alt="Kampas Rem" class="w-full h-52 object-cover group-hover:scale-105 transition-transform duration-500">
            <div class="p-6 flex-1 flex flex-col">
                <div class="flex items-center justify-between mb-3">
                    <p class="text-xs text-brand font-bold uppercase tracking-wider">TIPS PERAWATAN</p>
                    <span class="text-xs text-gray-400">12 Jun 2026</span>
                </div>
                <h3 class="font-bold text-ink text-lg leading-snug group-hover:text-brand transition mb-2">5 Tanda Kampas Rem Mobil Anda Harus Segera Diganti</h3>
                <p class="text-sm text-gray-500 line-clamp-3 flex-1">Jangan abaikan bunyi berdecit saat mengerem, bisa jadi itu tanda kampas rem Anda sudah menipis dan berbahaya bagi keselamatan.</p>
                <div class="mt-4 pt-4 border-t border-gray-100">
                    <span class="text-danger font-bold text-xs uppercase tracking-wider flex items-center">
                        Baca Selengkapnya <svg class="w-3.5 h-3.5 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </span>
                </div>
            </div>
        </a>

        {{-- Artikel 2 --}}
        <a href="{{ route('artikel.oli-gardan-transmisi') }}" class="bg-white border border-gray-200 rounded-xl overflow-hidden group hover:shadow-lg transition-all duration-300 flex flex-col">
            <img src="https://images.unsplash.com/photo-1711199694531-e982a79ea381?auto=format&fit=crop&w=800&q=80" alt="Oli Gardan" class="w-full h-52 object-cover group-hover:scale-105 transition-transform duration-500">
            <div class="p-6 flex-1 flex flex-col">
                <div class="flex items-center justify-between mb-3">
                    <p class="text-xs text-brand font-bold uppercase tracking-wider">TIPS PERAWATAN</p>
                    <span class="text-xs text-gray-400">10 Jun 2026</span>
                </div>
                <h3 class="font-bold text-ink text-lg leading-snug group-hover:text-brand transition mb-2">Kapan Waktu yang Tepat Mengganti Oli Gardan & Transmisi?</h3>
                <p class="text-sm text-gray-500 line-clamp-3 flex-1">Banyak pemilik mobil lupa mengganti oli gardan. Padahal, telat mengganti bisa membuat gigi gardan rontok dan biaya perbaikannya sangat mahal.</p>
                <div class="mt-4 pt-4 border-t border-gray-100">
                    <span class="text-danger font-bold text-xs uppercase tracking-wider flex items-center">
                        Baca Selengkapnya <svg class="w-3.5 h-3.5 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </span>
                </div>
            </div>
        </a>

        {{-- Artikel 3 --}}
        <a href="{{ route('artikel.scan-kendaraan') }}" class="bg-white border border-gray-200 rounded-xl overflow-hidden group hover:shadow-lg transition-all duration-300 flex flex-col">
            <img src="https://images.unsplash.com/photo-1623682783900-fea916dcba74?auto=format&fit=crop&w=800&q=80" alt="Scan Kendaraan" class="w-full h-52 object-cover group-hover:scale-105 transition-transform duration-500">
            <div class="p-6 flex-1 flex flex-col">
                <div class="flex items-center justify-between mb-3">
                    <p class="text-xs text-brand font-bold uppercase tracking-wider">BERITA BENGKEL</p>
                    <span class="text-xs text-gray-400">8 Jun 2026</span>
                </div>
                <h3 class="font-bold text-ink text-lg leading-snug group-hover:text-brand transition mb-2">Kini di Wijaya Motor: Scan Kendaraan Cepat & Akurat!</h3>
                <p class="text-sm text-gray-500 line-clamp-3 flex-1">Temukan masalah pada mobil Anda sebelum menjadi kerusakan yang lebih besar dengan layanan diagnostic scan terbaru.</p>
                <div class="mt-4 pt-4 border-t border-gray-100">
                    <span class="text-danger font-bold text-xs uppercase tracking-wider flex items-center">
                        Baca Selengkapnya <svg class="w-3.5 h-3.5 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </span>
                </div>
            </div>
        </a>

    </div>
</div>

@endsection