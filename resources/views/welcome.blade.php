@extends('layouts.app')

@section('title', 'Wijaya Motor — Booking Servis & Sparepart Online')

@section('content')

<section id="hero-carousel"
         class="w-full bg-ink relative overflow-hidden h-[500px] md:h-[550px]"
         data-testid="hero-carousel">

  <div class="carousel-track">

    {{-- ====== SLIDE 1 ====== --}}
    <div class="carousel-slide opacity-100 transition-opacity duration-1000 ease-in-out"
         data-index="0" data-testid="carousel-slide-1">
      <img src="https://lh3.googleusercontent.com/gps-cs-s/APNQkAHrj6xaOGJQYn6C8BP8292pOMO6zXCqxkWBX5mhCb28PGzVaJVkr8TRMoa62l-G-G8kNWdzeEPf3knsAdEBRAbKFhZ1bSVfV_GQmlHyBVFrYMMGJBEj4CrFz-kj6ZtfZA1oY98HvA=s680-w680-h510-rw"
           alt="Mekanik Wijaya Motor"
           class="absolute inset-0 w-full h-full object-cover">
      {{-- Overlay agar teks terbaca --}}
      <div class="absolute inset-0 bg-gradient-to-r from-ink/95 via-ink/75 to-ink/20"></div>
      <div class="absolute inset-0 bg-black/30 md:hidden"></div>

      <div class="relative z-10 max-w-7xl mx-auto h-full flex items-center">
        <div class="p-8 md:p-16 md:w-2/3 lg:w-1/2">
          <h2 class="text-white font-bold text-xl md:text-2xl mb-2 drop-shadow-lg">Servis mobil jadi lebih untung?</h2>
          <h1 class="text-brand font-black text-4xl md:text-5xl leading-tight mb-4 drop-shadow-lg">Booking Lewat<br>Website Wijaya Motor</h1>
          <div class="bg-gradient-to-r from-blue-600 to-blue-400 text-white inline-block px-6 py-3 rounded-r-full font-black text-2xl md:text-3xl mb-4 shadow-lg -ml-8 md:-ml-16 pl-8 md:pl-16 relative">
            Dapatkan Diskon 20%
            <div class="absolute right-[-10px] top-1/2 transform -translate-y-1/2 w-5 h-5 bg-blue-400 rotate-45"></div>
          </div>
          <p class="text-white mt-2 font-medium drop-shadow">Setiap servis perdana melalui website kami.</p>
          <a href="{{ route('booking.create') }}"
             class="mt-8 inline-block bg-danger hover:bg-red-700 text-white font-bold px-8 py-3 rounded-full shadow-lg transition transform hover:scale-105"
             data-testid="booking-btn-slide-1">
            Booking Sekarang
          </a>
        </div>
      </div>
    </div>

    {{-- ====== SLIDE 2 ====== --}}
    <div class="carousel-slide opacity-0 transition-opacity duration-1000 ease-in-out pointer-events-none"
         data-index="1" data-testid="carousel-slide-2">
      <img src="https://lh3.googleusercontent.com/gps-cs-s/APNQkAEhRVDFX60B5yrqbKZv8XlVDaHsBeSspJD7omWZ5qDUWChCx5oF-AT-l1ZF2I9BIdfe90UMnwuxTkpQ8ukrmIaF3YTMSiTI3G1kKyT3xBb0a9mKfx2JF2e_R0VRSpSFVs646qPo=s680-w680-h510-rw"
           alt="Mekanik Wijaya Motor"
           class="absolute inset-0 w-full h-full object-cover">
      <div class="absolute inset-0 bg-gradient-to-r from-ink/95 via-ink/75 to-ink/20"></div>
      <div class="absolute inset-0 bg-black/30 md:hidden"></div>

      <div class="relative z-10 max-w-7xl mx-auto h-full flex items-center">
        <div class="p-8 md:p-16 md:w-2/3 lg:w-1/2">
          <h2 class="text-white font-bold text-xl md:text-2xl mb-2 drop-shadow-lg">Servis mobil jadi lebih untung?</h2>
          <h1 class="text-brand font-black text-4xl md:text-5xl leading-tight mb-4 drop-shadow-lg">Booking Lewat<br>Website Wijaya Motor</h1>
          <div class="bg-gradient-to-r from-blue-600 to-blue-400 text-white inline-block px-6 py-3 rounded-r-full font-black text-2xl md:text-3xl mb-4 shadow-lg -ml-8 md:-ml-16 pl-8 md:pl-16 relative">
            Dapatkan Diskon 20%
            <div class="absolute right-[-10px] top-1/2 transform -translate-y-1/2 w-5 h-5 bg-blue-400 rotate-45"></div>
          </div>
          <p class="text-white mt-2 font-medium drop-shadow">Setiap servis perdana melalui website kami.</p>
          <a href="{{ route('booking.create') }}"
             class="mt-8 inline-block bg-danger hover:bg-red-700 text-white font-bold px-8 py-3 rounded-full shadow-lg transition transform hover:scale-105"
             data-testid="booking-btn-slide-2">
            Booking Sekarang
          </a>
        </div>
      </div>
    </div>

    {{-- ====== SLIDE 3 ====== --}}
    <div class="carousel-slide opacity-0 transition-opacity duration-1000 ease-in-out pointer-events-none"
         data-index="2" data-testid="carousel-slide-3">
      <img src="https://lh3.googleusercontent.com/gps-cs-s/APNQkAFEzmkIgAjaN4UHHsjstrZvaKA5vnZWKikaq3mGPc7Gcre5dIFIhTSUw0_t_mPAWB3tpl-bzSL1o5YmNAufz7B17dRQXrl1OirmMfqJzaPxMnxJnqbOr8hFa7pam3Iavi4jqLV_lg=s680-w680-h510-rw"
           alt="Mekanik Wijaya Motor"
           class="absolute inset-0 w-full h-full object-cover">
      <div class="absolute inset-0 bg-gradient-to-r from-ink/95 via-ink/75 to-ink/20"></div>
      <div class="absolute inset-0 bg-black/30 md:hidden"></div>

      <div class="relative z-10 max-w-7xl mx-auto h-full flex items-center">
        <div class="p-8 md:p-16 md:w-2/3 lg:w-1/2">
          <h2 class="text-white font-bold text-xl md:text-2xl mb-2 drop-shadow-lg">Servis mobil jadi lebih untung?</h2>
          <h1 class="text-brand font-black text-4xl md:text-5xl leading-tight mb-4 drop-shadow-lg">Booking Lewat<br>Website Wijaya Motor</h1>
          <div class="bg-gradient-to-r from-blue-600 to-blue-400 text-white inline-block px-6 py-3 rounded-r-full font-black text-2xl md:text-3xl mb-4 shadow-lg -ml-8 md:-ml-16 pl-8 md:pl-16 relative">
            Dapatkan Diskon 20%
            <div class="absolute right-[-10px] top-1/2 transform -translate-y-1/2 w-5 h-5 bg-blue-400 rotate-45"></div>
          </div>
          <p class="text-white mt-2 font-medium drop-shadow">Setiap servis perdana melalui website kami.</p>
          <a href="{{ route('booking.create') }}"
             class="mt-8 inline-block bg-danger hover:bg-red-700 text-white font-bold px-8 py-3 rounded-full shadow-lg transition transform hover:scale-105"
             data-testid="booking-btn-slide-3">
            Booking Sekarang
          </a>
        </div>
      </div>
    </div>

  </div>

  {{-- ====== INDICATORS ====== --}}
  <div class="absolute bottom-4 w-full flex justify-center space-x-2 z-20">
    <button type="button" class="carousel-dot w-8 h-2 bg-brand rounded-full transition-all duration-300" data-target="0" aria-label="Slide 1" data-testid="carousel-dot-1"></button>
    <button type="button" class="carousel-dot w-2 h-2 bg-white/50 rounded-full transition-all duration-300 hover:bg-white/80" data-target="1" aria-label="Slide 2" data-testid="carousel-dot-2"></button>
    <button type="button" class="carousel-dot w-2 h-2 bg-white/50 rounded-full transition-all duration-300 hover:bg-white/80" data-target="2" aria-label="Slide 3" data-testid="carousel-dot-3"></button>
  </div>
</section>

{{-- ============================ END HERO CAROUSEL ============================ --}}


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
          <h3 class="font-bold text-ink text-lg leading-snug group-hover:text-brand transition mb-2">5 Tanda Kampas Rem Mobil Anda Harus Segera Diganti</h3>
          <p class="text-sm text-gray-500 line-clamp-2">Jangan abaikan bunyi berdecit saat mengerem, bisa jadi itu tanda kampas rem Anda sudah menipis dan berbahaya bagi keselamatan.</p>
        </div>
      </div>
      <div class="bg-white border border-gray-200 rounded-xl overflow-hidden group cursor-pointer hover:shadow-md transition">
        <img src="https://images.unsplash.com/photo-1518985289524-118c7bc701f5?auto=format&fit=crop&w=800&q=80" alt="Tips" class="w-full h-48 object-cover">
        <div class="p-5">
          <p class="text-xs text-brand font-bold mb-2">TIPS PERAWATAN</p>
          <h3 class="font-bold text-ink text-lg leading-snug group-hover:text-brand transition mb-2">Kapan Waktu yang Tepat Mengganti Oli Gardan & Transmisi?</h3>
          <p class="text-sm text-gray-500 line-clamp-2">Banyak pemilik mobil lupa mengganti oli gardan. Padahal, telat mengganti bisa membuat gigi gardan rontok dan biaya perbaikannya sangat mahal.</p>
        </div>
      </div>
      <div class="bg-white border border-gray-200 rounded-xl overflow-hidden group cursor-pointer hover:shadow-md transition hidden md:block">
        <img src="https://images.unsplash.com/photo-1549399542-7e3f8b79c341?auto=format&fit=crop&w=800&q=80" alt="Tips" class="w-full h-48 object-cover">
        <div class="p-5">
          <p class="text-xs text-brand font-bold mb-2">BERITA BENGKEL</p>
          <h3 class="font-bold text-ink text-lg leading-snug group-hover:text-brand transition mb-2">Wijaya Motor Kini Melayani Spooring & Balancing 3D!</h3>
          <p class="text-sm text-gray-500 line-clamp-2">Kami baru saja mendatangkan mesin Spooring 3D generasi terbaru untuk memastikan kaki-kaki mobil Anda lurus sempurna.</p>
        </div>
      </div>
    </div>
  </div>
</section>

{{-- ============================ SECTION SPAREPART ============================ --}}
<section id="sparepart" class="py-12 bg-white border-b border-gray-100">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex justify-between items-end mb-8">
      <div>
        <h2 class="text-2xl font-black text-ink uppercase tracking-tight">Aksesoris & Sparepart</h2>
        <p class="text-gray-500 text-sm mt-1">Suku cadang asli dan aksesoris resmi untuk kendaraan Anda.</p>
      </div>
      <a href="{{ route('sparepart.index') }}" class="text-danger font-bold text-sm hover:underline flex items-center">
        LIHAT SEMUA <svg class="w-4 h-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
      </a>
    </div>

    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4 sm:gap-6">
      @forelse($featuredSpareparts as $item)
      <a href="{{ route('sparepart.show', $item->id) }}" class="group bg-white border border-gray-200 rounded-xl p-4 hover:border-danger hover:shadow-lg transition-all duration-300 flex flex-col">
        <div class="w-full aspect-square bg-gray-50 rounded-lg mb-3 overflow-hidden flex items-center justify-center">
          @if($item->image)
            <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->name }}" class="w-full h-full object-contain group-hover:scale-105 transition-transform duration-300">
          @else
            <svg class="w-12 h-12 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
            </svg>
          @endif
        </div>
        <h3 class="font-bold text-gray-900 text-sm leading-snug group-hover:text-danger transition-colors line-clamp-2">{{ $item->name }}</h3>
        <div class="mt-auto pt-2">
          <span class="text-danger font-black text-base">Rp{{ number_format($item->price, 0, ',', '.') }}</span>
          @if($item->stock <= 5 && $item->stock > 0)
            <span class="text-xs text-amber-600 font-semibold ml-2">Sisa {{ $item->stock }}</span>
          @elseif($item->stock == 0)
            <span class="text-xs text-gray-400 font-semibold ml-2">Stok Habis</span>
          @endif
        </div>
      </a>
      @empty
      <div class="col-span-full text-center py-12 text-gray-400">
        <svg class="w-16 h-16 mx-auto mb-4 text-gray-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
        </svg>
        <p class="font-semibold">Belum ada produk tersedia</p>
        <p class="text-sm mt-1">Kembali lagi nanti untuk melihat koleksi terbaru kami.</p>
      </div>
      @endforelse
    </div>
  </div>
</section>

{{-- ============================ SECTION LOKASI ============================ --}}
<section id="lokasi" class="py-12 bg-gray-50 border-b border-gray-100">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex justify-between items-end mb-8">
      <div>
        <h2 class="text-2xl font-black text-ink uppercase tracking-tight">Lokasi Bengkel</h2>
        <p class="text-gray-500 text-sm mt-1">Kunjungi bengkel resmi Wijaya Motor terdekat.</p>
      </div>
      <a href="{{ route('lokasi') }}" class="text-danger font-bold text-sm hover:underline flex items-center">
        LIHAT DETAIL <svg class="w-4 h-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
      </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
      {{-- Info Lokasi --}}
      <div class="lg:col-span-1 space-y-4">
        <div class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm">
          <div class="flex items-center mb-3">
            <div class="w-9 h-9 bg-gray-50 border border-gray-100 rounded-xl flex items-center justify-center text-danger mr-3">
              <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
              </svg>
            </div>
            <h3 class="font-black text-gray-900 text-xs uppercase tracking-wider">Alamat</h3>
          </div>
          <p class="text-gray-800 font-semibold text-sm leading-relaxed">RJF4+H4W, Jl. Aria Wangsakara, RT.001/RW.001</p>
          <p class="text-gray-500 text-xs mt-1">Bugel, Kec. Karawaci, Kota Tangerang, Banten 15114</p>
        </div>

        <div class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm">
          <div class="flex items-center mb-3">
            <div class="w-9 h-9 bg-gray-50 border border-gray-100 rounded-xl flex items-center justify-center text-danger mr-3">
              <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
              </svg>
            </div>
            <h3 class="font-black text-gray-900 text-xs uppercase tracking-wider">Jam Operasional</h3>
          </div>
          <ul class="space-y-2 text-sm">
            <li class="flex justify-between items-center border-b border-gray-100 pb-1.5">
              <span class="text-gray-600 font-medium">Senin – Jumat</span>
              <span class="font-bold text-gray-900">08.00 – 17.00</span>
            </li>
            <li class="flex justify-between items-center border-b border-gray-100 pb-1.5">
              <span class="text-gray-600 font-medium">Sabtu</span>
              <span class="font-bold text-gray-900">08.00 – 15.00</span>
            </li>
            <li class="flex justify-between items-center">
              <span class="text-gray-600 font-medium">Minggu & Libur</span>
              <span class="font-bold text-danger">Tutup</span>
            </li>
          </ul>
        </div>

        <a href="{{ route('booking.create') }}" 
           class="flex items-center justify-center w-full bg-gray-900 hover:bg-black text-white px-5 py-3 rounded-xl font-bold text-sm uppercase tracking-widest transition shadow-sm">
          <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
          </svg>
          Booking Sekarang
        </a>
      </div>

      {{-- Google Maps --}}
      <div class="lg:col-span-2">
        <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden h-full">
          <div class="p-4 border-b border-gray-100 flex items-center justify-between">
            <div>
              <h3 class="font-black text-gray-900 text-xs uppercase tracking-wider">Wijaya Motor</h3>
              <p class="text-xs text-gray-500 mt-0.5">Jl. Aria Wangsakara, Bugel, Kec. Karawaci, Kota Tangerang</p>
            </div>
            <a href="https://maps.google.com/maps?q=Jl.+Aria+Wangsakara,+Bugel,+Kec.+Karawaci,+Kota+Tangerang"
               target="_blank" rel="noopener noreferrer"
               class="flex items-center text-xs font-bold text-danger hover:text-red-700 transition uppercase tracking-wider border border-red-200 rounded-lg px-3 py-1.5 hover:bg-red-50">
              <svg class="w-3.5 h-3.5 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
              </svg>
              Buka Maps
            </a>
          </div>
          <iframe
            src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d48306.16760168223!2d106.6102302926478!3d-6.157260263648726!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69ff1392c7c165%3A0x92463838076380d1!2sBengkel%20Mobil%20WIJAYA%20MOTOR!5e1!3m2!1sen!2sid!4v1780859758029!5m2!1sen!2sid"
            width="100%"
            height="360"
            style="border:0; display: block;"
            allowfullscreen=""
            loading="lazy"
            referrerpolicy="no-referrer-when-downgrade"
            title="Lokasi Wijaya Motor di Google Maps">
          </iframe>
        </div>
      </div>
    </div>
  </div>
</section>

@endsection
