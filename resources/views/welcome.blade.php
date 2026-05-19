@extends('layouts.app')

@section('title', 'Wijaya Motor — Booking Servis & Sparepart Online')

@section('content')

<style>
    .hide-scrollbar::-webkit-scrollbar { display: none; }
    .hide-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
</style>

<section class="w-full bg-ink relative overflow-hidden">
  <div class="max-w-7xl mx-auto flex flex-col md:flex-row items-center relative z-10">
    <div class="p-8 md:p-16 md:w-1/2">
      <h2 class="text-white font-bold text-xl md:text-2xl mb-2">Servis mobil jadi lebih untung?</h2>
      <h1 class="text-brand font-black text-4xl md:text-5xl leading-tight mb-4">Booking Lewat<br>Website Wijaya Motor</h1>
      <div class="bg-gradient-to-r from-blue-600 to-blue-400 text-white inline-block px-6 py-3 rounded-r-full font-black text-2xl md:text-3xl mb-4 shadow-lg -ml-8 md:-ml-16 pl-8 md:pl-16 relative">
        Dapatkan Diskon 20%
        <div class="absolute right-[-10px] top-1/2 transform -translate-y-1/2 w-5 h-5 bg-blue-400 rotate-45"></div>
      </div>
      <p class="text-white mt-2 font-medium">Setiap servis perdana melalui website kami.</p>
      <a href="{{ route('booking.create') }}" class="mt-8 inline-block bg-danger hover:bg-red-700 text-white font-bold px-8 py-3 rounded-full shadow-lg transition transform hover:scale-105">
        Booking Sekarang
      </a>
    </div>
    <div class="md:w-1/2 relative h-64 md:h-[450px] w-full">
      <img src="https://images.unsplash.com/photo-1632823465306-edeb51a4413a?auto=format&fit=crop&w=800&q=80" alt="Mekanik" class="w-full h-full object-cover rounded-tl-[100px]">
      <div class="absolute inset-0 bg-gradient-to-r from-ink via-transparent to-transparent"></div>
    </div>
  </div>
  <div class="absolute bottom-4 w-full flex justify-center space-x-2 z-20">
    <div class="w-8 h-2 bg-brand rounded-full"></div>
    <div class="w-2 h-2 bg-white/50 rounded-full"></div>
    <div class="w-2 h-2 bg-white/50 rounded-full"></div>
  </div>
</section>

<section class="py-12 bg-white border-b border-gray-100 relative group" 
         x-data="{ 
            scrollNext() { this.$refs.slider.scrollBy({ left: 300, behavior: 'smooth' }); },
            scrollPrev() { this.$refs.slider.scrollBy({ left: -300, behavior: 'smooth' }); }
         }">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
    
    <div class="mb-8">
      <h2 class="text-2xl font-black text-ink uppercase tracking-tight">Kategori Pilihan</h2>
      <p class="text-gray-500 text-sm mt-1">Kemudahan pesan & perawatan mobil online di Wijaya Motor</p>
    </div>

    <button @click="scrollPrev" class="absolute left-0 top-1/2 mt-4 -translate-y-1/2 -translate-x-4 bg-white border border-gray-100 shadow-lg rounded-full p-3 z-10 text-gray-400 hover:text-danger hover:border-danger hover:scale-110 transition-all hidden md:block opacity-0 group-hover:opacity-100">
        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/></svg>
    </button>

    <button @click="scrollNext" class="absolute right-0 top-1/2 mt-4 -translate-y-1/2 translate-x-4 bg-white border border-gray-100 shadow-lg rounded-full p-3 z-10 text-gray-400 hover:text-danger hover:border-danger hover:scale-110 transition-all hidden md:block opacity-0 group-hover:opacity-100">
        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
    </button>

    <div x-ref="slider" class="flex gap-4 sm:gap-6 overflow-x-auto snap-x snap-mandatory hide-scrollbar pb-6 pt-2">
        
        <a href="{{ route('booking.create') }}" class="snap-start shrink-0 w-36 sm:w-44 bg-white border border-gray-200 rounded-2xl p-6 flex flex-col items-center justify-center gap-4 hover:border-danger hover:shadow-lg transition-all duration-300 group hover:-translate-y-1">
            <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center text-gray-500 group-hover:text-danger group-hover:bg-red-50 transition-colors duration-300">
                <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            </div>
            <span class="font-bold text-gray-900 text-sm text-center group-hover:text-danger transition-colors">Servis Booking</span>
        </a>

        <a href="#promo" class="snap-start shrink-0 w-36 sm:w-44 bg-white border border-gray-200 rounded-2xl p-6 flex flex-col items-center justify-center gap-4 hover:border-danger hover:shadow-lg transition-all duration-300 group hover:-translate-y-1">
            <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center text-gray-500 group-hover:text-danger group-hover:bg-red-50 transition-colors duration-300">
                <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
            </div>
            <span class="font-bold text-gray-900 text-sm text-center group-hover:text-danger transition-colors">Kupon Servis</span>
        </a>

        <a href="{{ route('sparepart.index') }}" class="snap-start shrink-0 w-36 sm:w-44 bg-white border border-gray-200 rounded-2xl p-6 flex flex-col items-center justify-center gap-4 hover:border-danger hover:shadow-lg transition-all duration-300 group hover:-translate-y-1">
            <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center text-gray-500 group-hover:text-danger group-hover:bg-red-50 transition-colors duration-300">
                <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>
            </div>
            <span class="font-bold text-gray-900 text-sm text-center group-hover:text-danger transition-colors">Aksesoris</span>
        </a>

        <a href="{{ route('sparepart.index') }}" class="snap-start shrink-0 w-36 sm:w-44 bg-white border border-gray-200 rounded-2xl p-6 flex flex-col items-center justify-center gap-4 hover:border-danger hover:shadow-lg transition-all duration-300 group hover:-translate-y-1">
            <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center text-gray-500 group-hover:text-danger group-hover:bg-red-50 transition-colors duration-300">
                <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            </div>
            <span class="font-bold text-gray-900 text-sm text-center group-hover:text-danger transition-colors">Suku Cadang</span>
        </a>

        <a href="{{ route('booking.homeservice') }}" class="snap-start shrink-0 w-36 sm:w-44 bg-white border border-gray-200 rounded-2xl p-6 flex flex-col items-center justify-center gap-4 hover:border-danger hover:shadow-lg transition-all duration-300 group hover:-translate-y-1">
            <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center text-gray-500 group-hover:text-danger group-hover:bg-red-50 transition-colors duration-300">
                <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
            </div>
            <span class="font-bold text-gray-900 text-sm text-center group-hover:text-danger transition-colors">Home Service</span>
        </a>

        <a href="{{ route('dashboard') }}" class="snap-start shrink-0 w-36 sm:w-44 bg-white border border-gray-200 rounded-2xl p-6 flex flex-col items-center justify-center gap-4 hover:border-danger hover:shadow-lg transition-all duration-300 group hover:-translate-y-1">
            <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center text-gray-500 group-hover:text-danger group-hover:bg-red-50 transition-colors duration-300">
                <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
            </div>
            <span class="font-bold text-gray-900 text-sm text-center group-hover:text-danger transition-colors">Riwayat Servis</span>
        </a>

    </div>
  </div>
</section>

<section id="promo" class="py-12 bg-white">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex justify-between items-end mb-6">
      <div>
        <h2 class="text-xl font-bold text-ink mb-1">Lihat promo lainnya</h2>
      </div>
      <a href="#" class="text-danger font-bold text-sm hover:underline flex items-center">
        LIHAT SEMUA <svg class="w-4 h-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
      </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
      <div class="bg-white group cursor-pointer">
        <div class="overflow-hidden rounded-xl shadow-sm border border-gray-200 mb-4">
          <img src="https://images.unsplash.com/photo-1552930294-6b595f4c2974?auto=format&fit=crop&w=800&q=80" alt="Promo" class="w-full h-48 object-cover group-hover:scale-105 transition duration-500">
        </div>
        <h3 class="font-bold text-ink text-lg leading-snug group-hover:text-brand transition">Promo Spesial: Booking Fee Pakai E-Wallet Dapat Cashback!</h3>
        <p class="text-sm text-gray-500 mt-2">1 Jun 2026 - 30 Jul 2026</p>
      </div>
      <div class="bg-white group cursor-pointer">
        <div class="overflow-hidden rounded-xl shadow-sm border border-gray-200 mb-4">
          <img src="https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?auto=format&fit=crop&w=800&q=80" alt="Promo" class="w-full h-48 object-cover group-hover:scale-105 transition duration-500">
        </div>
        <h3 class="font-bold text-ink text-lg leading-snug group-hover:text-brand transition">Service Berkala Lewat Website, Dapatkan Point Rewards!</h3>
        <p class="text-sm text-gray-500 mt-2">15 Mei 2026 - 31 Des 2026</p>
      </div>
      <div class="bg-white group cursor-pointer hidden md:block">
        <div class="overflow-hidden rounded-xl shadow-sm border border-gray-200 mb-4">
          <img src="https://images.unsplash.com/photo-1619642751034-765dfdf7c58e?auto=format&fit=crop&w=800&q=80" alt="Promo" class="w-full h-48 object-cover group-hover:scale-105 transition duration-500">
        </div>
        <h3 class="font-bold text-ink text-lg leading-snug group-hover:text-brand transition">Ganti Oli Paket Lengkap: Gratis Filter & Pengecekan 20 Titik</h3>
        <p class="text-sm text-gray-500 mt-2">Sepanjang Tahun 2026</p>
      </div>
    </div>
  </div>
</section>

<section class="py-12 bg-gray-50 border-t border-gray-200">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex justify-between items-end mb-6">
      <div>
        <h2 class="text-2xl font-black text-ink uppercase">BENGKEL TERDEKAT</h2>
        <p class="text-gray-600 text-sm mt-1">Ketahui cabang Wijaya Motor di sekitar lokasi Anda</p>
      </div>
      <a href="#" class="text-danger font-bold text-sm hover:underline hidden sm:flex items-center">
        LIHAT SEMUA <svg class="w-4 h-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
      </a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 flex flex-col md:flex-row gap-6 items-center">
      <img src="https://images.unsplash.com/photo-1598558543997-cd2a5d528b71?auto=format&fit=crop&w=400&q=80" alt="Bengkel" class="w-full md:w-64 h-40 object-cover rounded-lg">
      <div class="flex-1 w-full">
        <h3 class="text-xl font-bold text-ink mb-2">WIJAYA MOTOR JAKARTA SELATAN</h3>
        <div class="flex items-center text-sm text-gray-600 mb-4">
          <svg class="w-4 h-4 text-brand mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
          <a href="#" class="text-blue-600 hover:underline font-semibold mr-2">Petunjuk Arah</a> (2.5 Km)
        </div>
        <div class="flex items-center text-sm">
          <span class="font-semibold text-gray-700 mr-3">Layanan: </span>
          <span class="inline-flex items-center text-danger font-bold"><span class="w-2 h-2 rounded-full bg-danger mr-1.5"></span> Servis Umum</span>
          <span class="inline-flex items-center text-brand font-bold ml-4"><span class="w-2 h-2 rounded-full bg-brand mr-1.5"></span> Penjualan Suku Cadang</span>
        </div>
      </div>
      <div class="shrink-0 w-full md:w-auto">
        <a href="{{ route('booking.create') }}" class="block text-center border-2 border-brand text-brand hover:bg-brand hover:text-white font-bold px-8 py-3 rounded-full transition w-full">
          Booking di sini
        </a>
      </div>
    </div>
  </div>
</section>

<section id="sparepart" class="py-12 bg-white">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex justify-between items-end mb-8">
      <div>
        <h2 class="text-2xl font-black text-ink uppercase">SUKU CADANG ORIGINAL</h2>
        <p class="text-gray-600 text-sm mt-1">Sparepart terlaris untuk kebutuhan mobil Anda</p>
      </div>
      <a href="{{ route('sparepart.index') }}" class="text-danger font-bold text-sm hover:underline hidden sm:flex items-center">
        KATALOG LENGKAP <svg class="w-4 h-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
      </a>
    </div>

    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-6">
      <div class="bg-white border border-gray-200 rounded-xl p-4 hover:shadow-lg transition group">
        <img src="https://images.unsplash.com/photo-1598300042247-d088f8ab3a91?auto=format&fit=crop&w=300&q=80" alt="Oli" class="w-full h-40 object-cover rounded-lg mb-4">
        <h4 class="font-bold text-ink text-sm md:text-base leading-tight mb-2 group-hover:text-brand">Oli Mesin TMO Gold 0W-20 (4L)</h4>
        <p class="font-black text-danger text-lg mb-4">Rp 450.000</p>
        <button class="w-full bg-ink hover:bg-ink-light text-white font-bold py-2 rounded-lg text-sm transition">Tambah Keranjang</button>
      </div>
      <div class="bg-white border border-gray-200 rounded-xl p-4 hover:shadow-lg transition group">
        <img src="https://images.unsplash.com/photo-1558618666-fcd25c85cd64?auto=format&fit=crop&w=300&q=80" alt="Filter" class="w-full h-40 object-cover rounded-lg mb-4">
        <h4 class="font-bold text-ink text-sm md:text-base leading-tight mb-2 group-hover:text-brand">Filter Udara Original SUV</h4>
        <p class="font-black text-danger text-lg mb-4">Rp 120.000</p>
        <button class="w-full bg-ink hover:bg-ink-light text-white font-bold py-2 rounded-lg text-sm transition">Tambah Keranjang</button>
      </div>
      <div class="bg-white border border-gray-200 rounded-xl p-4 hover:shadow-lg transition group">
        <img src="https://images.unsplash.com/photo-1486262715619-67b85e0b08d3?auto=format&fit=crop&w=300&q=80" alt="Busi" class="w-full h-40 object-cover rounded-lg mb-4">
        <h4 class="font-bold text-ink text-sm md:text-base leading-tight mb-2 group-hover:text-brand">Busi Iridium Long Life (Set 4)</h4>
        <p class="font-black text-danger text-lg mb-4">Rp 380.000</p>
        <button class="w-full bg-ink hover:bg-ink-light text-white font-bold py-2 rounded-lg text-sm transition">Tambah Keranjang</button>
      </div>
      <div class="bg-white border border-gray-200 rounded-xl p-4 hover:shadow-lg transition group">
        <img src="https://images.unsplash.com/photo-1600705722908-bab1e61c0b4d?auto=format&fit=crop&w=300&q=80" alt="Rem" class="w-full h-40 object-cover rounded-lg mb-4">
        <h4 class="font-bold text-ink text-sm md:text-base leading-tight mb-2 group-hover:text-brand">Kampas Rem Depan Premium</h4>
        <p class="font-black text-danger text-lg mb-4">Rp 550.000</p>
        <button class="w-full bg-ink hover:bg-ink-light text-white font-bold py-2 rounded-lg text-sm transition">Tambah Keranjang</button>
      </div>
    </div>
  </div>
</section>

<section id="berita" class="py-12 bg-gray-50 border-t border-gray-200">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex justify-between items-end mb-6">
      <div>
        <h2 class="text-xl font-bold text-ink mb-1">Tips & Berita Otomotif</h2>
      </div>
      <a href="#" class="text-danger font-bold text-sm hover:underline flex items-center">
        LIHAT SEMUA ARTIKEL <svg class="w-4 h-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
      </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
      <div class="bg-white border border-gray-200 rounded-xl overflow-hidden group cursor-pointer hover:shadow-md transition">
        <img src="https://images.unsplash.com/photo-1493238792000-8113da705763?auto=format&fit=crop&w=800&q=80" alt="Tips" class="w-full h-48 object-cover">
        <div class="p-5">
          <p class="text-xs text-brand font-bold mb-2">TIPS PERAWATAN</p>
          <h3 class="font-bold text-ink text-lg leading-snug group-hover:text-brand transition mb-2">Tanda-tanda Kampas Rem Mobil Anda Harus Segera Diganti</h3>
          <p class="text-sm text-gray-500 line-clamp-2">Jangan abaikan bunyi berdecit saat mengerem, bisa jadi itu tanda kampas rem Anda sudah menipis dan berbahaya.</p>
        </div>
      </div>
      <div class="bg-white border border-gray-200 rounded-xl overflow-hidden group cursor-pointer hover:shadow-md transition">
        <img src="https://images.unsplash.com/photo-1518985289524-118c7bc701f5?auto=format&fit=crop&w=800&q=80" alt="Tips" class="w-full h-48 object-cover">
        <div class="p-5">
          <p class="text-xs text-brand font-bold mb-2">BERITA</p>
          <h3 class="font-bold text-ink text-lg leading-snug group-hover:text-brand transition mb-2">Kenapa Ganti Oli Mesin Wajib Dilakukan Tepat Waktu?</h3>
          <p class="text-sm text-gray-500 line-clamp-2">Oli berfungsi sebagai pelumas dan pendingin. Telat ganti oli bisa menyebabkan kerusakan fatal pada komponen mesin dalam.</p>
        </div>
      </div>
      <div class="bg-white border border-gray-200 rounded-xl overflow-hidden group cursor-pointer hover:shadow-md transition hidden md:block">
        <img src="https://images.unsplash.com/photo-1549399542-7e3f8b79c341?auto=format&fit=crop&w=800&q=80" alt="Tips" class="w-full h-48 object-cover">
        <div class="p-5">
          <p class="text-xs text-brand font-bold mb-2">TIPS PERJALANAN</p>
          <h3 class="font-bold text-ink text-lg leading-snug group-hover:text-brand transition mb-2">Persiapan Wajib Kendaraan Sebelum Perjalanan Jauh Mudik</h3>
          <p class="text-sm text-gray-500 line-clamp-2">Cek 5 titik krusial ini sebelum Anda bepergian jauh untuk memastikan perjalanan aman dan nyaman bersama keluarga.</p>
        </div>
      </div>
    </div>
  </div>
</section>

@endsection