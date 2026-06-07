<div class="bg-gray-100 border-b border-gray-200 text-xs py-2 hidden md:block">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex justify-end items-center space-x-6">
    <a href="#" class="flex items-center text-gray-600 hover:text-brand transition">
      <svg class="w-3.5 h-3.5 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
      Hubungi Kami
    </a>
    <div class="flex items-center text-gray-600 border-l border-gray-300 pl-6">
      <svg class="w-3.5 h-3.5 mr-1.5 text-danger" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
      Tangerang Kota
    </div>
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
        <a href="{{ route('booking.index') }}" class="hover:text-brand transition">Booking Servis</a>
        <a href="{{ route('sparepart.index') }}" class="hover:text-brand transition">Sparepart</a>
        <a href="{{ url('/#promo') }}" class="hover:text-brand transition">Promo</a>
        <a href="{{ url('/#berita') }}" class="hover:text-brand transition">Tips & Berita</a>
        <a href="{{ route('lokasi') }}" class="hover:text-brand transition">Lokasi Bengkel</a>
      </div>

      <div class="hidden lg:flex items-center">
        <div class="relative">
          <input type="text" placeholder="Cari layanan atau sparepart..." class="pl-4 pr-10 py-2 border border-gray-300 rounded-full text-sm focus:outline-none focus:border-brand w-64 bg-gray-50 focus:bg-white transition-all">
          <svg class="w-4 h-4 text-gray-400 absolute right-4 top-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
        </div>
      </div>
      
      <button @click="mobileMenu = !mobileMenu" class="md:hidden text-gray-600">
        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
      </button>
    </div>
  </div>
</nav>