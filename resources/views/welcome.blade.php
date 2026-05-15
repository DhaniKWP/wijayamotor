@extends('layouts.app')

@section('title', 'Wijaya Motor — Booking Servis & Sparepart Online')

@section('content')

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

<section class="py-12 bg-white border-b border-gray-100">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="mb-8">
      <h2 class="text-2xl font-black text-ink uppercase tracking-tight">Kategori Pilihan</h2>
      <p class="text-gray-500 text-sm mt-1">Kemudahan pesan & perawatan mobil online di Wijaya Motor</p>
    </div>

    <div class="flex space-x-4 overflow-x-auto hide-scrollbar pb-4">
      
      <a href="{{ route('booking.create') }}" class="min-w-[140px] flex-shrink-0 bg-white border border-gray-200 rounded-xl p-4 flex flex-col items-center justify-center text-center hover:shadow-lg hover:border-brand transition group">
        <div class="w-16 h-16 mb-3 relative">
          <img src="https://cdn-icons-png.flaticon.com/512/1973/1973807.png" class="w-full h-full object-contain opacity-80 group-hover:scale-110 transition" alt="Booking">
        </div>
        <span class="font-bold text-sm text-ink group-hover:text-brand">Servis Booking</span>
      </a>

      <a href="#promo" class="min-w-[140px] flex-shrink-0 bg-white border border-gray-200 rounded-xl p-4 flex flex-col items-center justify-center text-center hover:shadow-lg hover:border-brand transition group">
        <div class="w-16 h-16 mb-3 relative">
          <img src="https://cdn-icons-png.flaticon.com/512/879/879757.png" class="w-full h-full object-contain opacity-80 group-hover:scale-110 transition" alt="Kupon">
        </div>
        <span class="font-bold text-sm text-ink group-hover:text-brand">Kupon Servis</span>
      </a>

      <a href="#sparepart" class="min-w-[140px] flex-shrink-0 bg-white border border-gray-200 rounded-xl p-4 flex flex-col items-center justify-center text-center hover:shadow-lg hover:border-brand transition group">
        <div class="w-16 h-16 mb-3 relative">
          <img src="https://cdn-icons-png.flaticon.com/512/3063/3063822.png" class="w-full h-full object-contain opacity-80 group-hover:scale-110 transition" alt="Aksesoris">
        </div>
        <span class="font-bold text-sm text-ink group-hover:text-brand">Aksesoris</span>
      </a>

      <a href="#sparepart" class="min-w-[140px] flex-shrink-0 bg-white border border-gray-200 rounded-xl p-4 flex flex-col items-center justify-center text-center hover:shadow-lg hover:border-brand transition group">
        <div class="w-16 h-16 mb-3 relative">
          <img src="https://cdn-icons-png.flaticon.com/512/2822/2822678.png" class="w-full h-full object-contain opacity-80 group-hover:scale-110 transition" alt="Suku Cadang">
        </div>
        <span class="font-bold text-sm text-ink group-hover:text-brand">Suku Cadang</span>
      </a>

      <a href="#" class="min-w-[140px] flex-shrink-0 bg-white border border-gray-200 rounded-xl p-4 flex flex-col items-center justify-center text-center hover:shadow-lg hover:border-brand transition group">
        <div class="w-16 h-16 mb-3 relative">
          <img src="https://cdn-icons-png.flaticon.com/512/2933/2933939.png" class="w-full h-full object-contain opacity-80 group-hover:scale-110 transition" alt="Home Service">
        </div>
        <span class="font-bold text-sm text-ink group-hover:text-brand">Home Service</span>
      </a>

      <a href="{{ route('dashboard') }}" class="min-w-[140px] flex-shrink-0 bg-white border border-gray-200 rounded-xl p-4 flex flex-col items-center justify-center text-center hover:shadow-lg hover:border-brand transition group">
        <div class="w-16 h-16 mb-3 relative">
          <img src="https://cdn-icons-png.flaticon.com/512/839/839860.png" class="w-full h-full object-contain opacity-80 group-hover:scale-110 transition" alt="Paket">
        </div>
        <span class="font-bold text-sm text-ink group-hover:text-brand">Riwayat Servis</span>
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
      <a href="#" class="text-danger font-bold text-sm hover:underline hidden sm:flex items-center">
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
        LIHAT SEMUA KARTIKEL <svg class="w-4 h-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
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