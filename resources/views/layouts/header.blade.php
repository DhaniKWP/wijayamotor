<div class="bg-gray-100 border-b border-gray-200 text-xs py-2 hidden md:block">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex justify-end items-center space-x-6">
    <a href="https://wa.me/62895321813103" target="_blank" rel="noopener noreferrer" class="flex items-center text-gray-600 hover:text-brand transition">
      <svg class="w-3.5 h-3.5 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
      Hubungi Kami
    </a>
    <a href="https://maps.app.goo.gl/jmZuadRSjWc7xmz98" target="_blank" rel="noopener noreferrer" class="flex items-center text-gray-600 hover:text-brand transition border-l border-gray-300 pl-6">
      <svg class="w-3.5 h-3.5 mr-1.5 text-danger" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
      Lokasi Bengkel
    </a>
    @php
        $cartCount = Auth::check() && Auth::user()->role === 'customer' ? \App\Models\CartItem::where('user_id', Auth::id())->count() : 0;
    @endphp
    <a href="{{ route('cart.index') }}" class="flex items-center text-gray-600 hover:text-brand transition border-l border-gray-300 pl-6">
      <svg class="w-3.5 h-3.5 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 0a2 2 0 100 4 2 2 0 000-4z"/></svg>
      Keranjang ({{ $cartCount }})
    </a>
    
    <div class="border-l border-gray-300 pl-6">
      @auth
        <a href="{{ route('dashboard') }}" class="flex items-center text-brand font-bold hover:text-brand-dark transition">
          <svg class="w-3.5 h-3.5 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
          {{ Auth::user()->name }}
        </a>
      @else
        <a href="{{ route('login') }}" class="flex items-center text-danger font-bold hover:text-red-700 transition">
          <svg class="w-3.5 h-3.5 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/></svg>
          Login / Daftar
        </a>
      @endauth
    </div>
  </div>
</div>

<nav class="bg-white sticky top-0 z-50 shadow-sm border-b border-gray-100">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
    <div class="flex justify-between items-center h-20">
      
      <a href="{{ url('/') }}" class="flex items-center gap-2 shrink-0">
        <span class="font-black text-2xl tracking-tighter text-ink">WIJAYA<span class="text-danger border-b-4 border-brand leading-none inline-block pb-0.5 ml-1">MOTOR</span></span>
      </a>

      <div class="hidden md:flex space-x-8 items-center font-bold text-xs text-gray-700 uppercase tracking-wider">
        <a href="{{ url('/') }}" class="hover:text-brand transition">Home</a>
        <a href="{{ route('booking.index') }}" class="hover:text-brand transition">Booking Servis</a>
        <a href="{{ route('sparepart.index') }}" class="hover:text-brand transition">Sparepart</a>
        <a href="{{ route('artikel.index') }}" class="hover:text-brand transition">Tips & Berita</a>
        <a href="{{ route('lokasi') }}" class="hover:text-brand transition">Lokasi Bengkel</a>
      </div>

      
      <button @click="mobileMenu = !mobileMenu" class="md:hidden text-gray-600 p-2">
        <svg x-show="!mobileMenu" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
        <svg x-show="mobileMenu" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
      </button>
    </div>

    {{-- MOBILE OVERLAY --}}
    <div x-show="mobileMenu" 
         x-cloak
         x-transition:enter="transition-opacity ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity ease-in duration-150"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click="mobileMenu = false"
         class="md:hidden fixed inset-0 bg-black/40 z-40">
    </div>

    {{-- MOBILE MENU SIDE PANEL --}}
    <div x-show="mobileMenu" 
         x-cloak
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 translate-x-full"
         x-transition:enter-end="opacity-100 translate-x-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 translate-x-0"
         x-transition:leave-end="opacity-0 translate-x-full"
         @click.outside="mobileMenu = false"
         class="md:hidden fixed top-0 right-0 bottom-0 w-72 bg-white shadow-2xl z-50 overflow-y-auto">
      <div class="p-5">
        {{-- Header dengan tombol close --}}
        <div class="flex justify-between items-center mb-6">
          <span class="font-black text-lg tracking-tighter text-ink">WIJAYA<span class="text-danger">MOTOR</span></span>
          <button @click="mobileMenu = false" class="text-gray-400 hover:text-gray-600 p-1">
            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
          </button>
        </div>

        {{-- Menu items --}}
        <div class="space-y-1">
          <a href="{{ url('/') }}" @click="mobileMenu = false" class="flex items-center px-4 py-3 rounded-xl font-bold text-sm text-gray-700 hover:bg-gray-50 hover:text-danger transition {{ request()->is('/') ? 'text-danger bg-red-50' : '' }}">
            <svg class="w-5 h-5 mr-3 text-gray-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
            Home
          </a>
          <a href="{{ route('booking.index') }}" @click="mobileMenu = false" class="flex items-center px-4 py-3 rounded-xl font-bold text-sm text-gray-700 hover:bg-gray-50 hover:text-danger transition">
            <svg class="w-5 h-5 mr-3 text-gray-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            Booking Servis
          </a>
          <a href="{{ route('sparepart.index') }}" @click="mobileMenu = false" class="flex items-center px-4 py-3 rounded-xl font-bold text-sm text-gray-700 hover:bg-gray-50 hover:text-danger transition">
            <svg class="w-5 h-5 mr-3 text-gray-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            Sparepart
          </a>
          <a href="{{ route('artikel.index') }}" @click="mobileMenu = false" class="flex items-center px-4 py-3 rounded-xl font-bold text-sm text-gray-700 hover:bg-gray-50 hover:text-danger transition">
            <svg class="w-5 h-5 mr-3 text-gray-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
            Tips & Berita
          </a>
          <a href="{{ route('lokasi') }}" @click="mobileMenu = false" class="flex items-center px-4 py-3 rounded-xl font-bold text-sm text-gray-700 hover:bg-gray-50 hover:text-danger transition">
            <svg class="w-5 h-5 mr-3 text-gray-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            Lokasi Bengkel
          </a>
        </div>

        <hr class="my-5 border-gray-200">

        {{-- User section --}}
        @auth
          <a href="{{ route('dashboard') }}" @click="mobileMenu = false" class="flex items-center px-4 py-3 rounded-xl font-bold text-sm text-brand hover:bg-red-50 transition">
            <svg class="w-5 h-5 mr-3 text-danger shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
            {{ Auth::user()->name }}
          </a>
          <a href="{{ route('cart.index') }}" @click="mobileMenu = false" class="flex items-center px-4 py-3 rounded-xl font-bold text-sm text-gray-700 hover:bg-gray-50 hover:text-danger transition">
            <svg class="w-5 h-5 mr-3 text-gray-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 0a2 2 0 100 4 2 2 0 000-4z"/></svg>
            Keranjang ({{ $cartCount }})
          </a>
        @else
          <a href="{{ route('login') }}" @click="mobileMenu = false" class="flex items-center px-4 py-3 rounded-xl font-bold text-sm text-danger hover:bg-red-50 transition">
            <svg class="w-5 h-5 mr-3 text-danger shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/></svg>
            Login / Daftar
          </a>
        @endauth

        {{-- Hubungi Kami --}}
        <div class="mt-6 px-4">
          <a href="https://wa.me/62895321813103" target="_blank" class="flex items-center justify-center w-full bg-[#25D366] text-white px-4 py-3 rounded-xl font-bold text-sm transition hover:bg-green-600">
            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
            Hubungi via WhatsApp
          </a>
        </div>
      </div>
    </div>
  </div>
</nav>
