<aside class="lg:col-span-1 lg:sticky lg:top-36 self-start mb-6 lg:mb-0">
    <div class="mb-6 lg:mb-8 hidden lg:block">
        <p class="text-gray-500 text-sm">Halo,</p>
        <h2 class="text-xl font-black text-gray-900 leading-tight mb-2">{{ Auth::user()->name }}</h2>
        <p class="text-xs text-gray-400">{{ Auth::user()->email }}</p>
    </div>
    
    <!-- Mobile User Info & Swipe Hint (Compact) -->
    <div class="mb-4 lg:hidden flex items-center justify-between">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-full bg-brand/10 text-brand flex items-center justify-center font-black text-lg">
                {{ substr(Auth::user()->name, 0, 1) }}
            </div>
            <div>
                <h2 class="text-sm font-black text-gray-900 leading-tight">{{ Auth::user()->name }}</h2>
                <p class="text-xs text-gray-500">{{ Auth::user()->email }}</p>
            </div>
        </div>
        <div class="flex items-center text-danger/70 text-[10px] font-bold uppercase tracking-wider animate-pulse">
            Geser Menu <svg class="w-3 h-3 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7"/></svg>
        </div>
    </div>

    <!-- Navigation Menu (Horizontal Scroll on Mobile, Vertical on Desktop) -->
    <nav class="flex overflow-x-auto lg:flex-col space-x-2 lg:space-x-0 lg:space-y-1 pb-2 lg:pb-0 scrollbar-hide -mx-4 px-4 lg:mx-0 lg:px-0">
        <a href="{{ route('dashboard') }}" class="shrink-0 flex items-center px-4 lg:px-2 py-2 lg:py-3 rounded-full lg:rounded-none transition lg:border-b border-gray-100 {{ request()->routeIs('dashboard') ? 'bg-brand/10 text-danger font-bold lg:bg-transparent lg:text-danger' : 'bg-gray-50 text-gray-600 hover:bg-gray-100 hover:text-danger lg:bg-transparent lg:hover:bg-transparent font-medium' }}">
            Dashboard Profil
        </a>
        <a href="{{ route('customer.pesanan') }}" class="shrink-0 flex items-center px-4 lg:px-2 py-2 lg:py-3 rounded-full lg:rounded-none transition lg:border-b border-gray-100 {{ request()->routeIs('customer.pesanan') ? 'bg-brand/10 text-danger font-bold lg:bg-transparent lg:text-danger' : 'bg-gray-50 text-gray-600 hover:bg-gray-100 hover:text-danger lg:bg-transparent lg:hover:bg-transparent font-medium' }}">
            Pesanan Saya
        </a>
        <a href="{{ route('garasi.index') }}" class="shrink-0 flex items-center px-4 lg:px-2 py-2 lg:py-3 rounded-full lg:rounded-none transition lg:border-b border-gray-100 {{ request()->routeIs('garasi.*') ? 'bg-brand/10 text-danger font-bold lg:bg-transparent lg:text-danger' : 'bg-gray-50 text-gray-600 hover:bg-gray-100 hover:text-danger lg:bg-transparent lg:hover:bg-transparent font-medium' }}">
            Garasi Saya
        </a>
        <a href="{{ route('booking.create') }}" class="shrink-0 flex items-center px-4 lg:px-2 py-2 lg:py-3 rounded-full lg:rounded-none transition lg:border-b border-gray-100 {{ request()->routeIs('booking.create') ? 'bg-brand/10 text-danger font-bold lg:bg-transparent lg:text-danger' : 'bg-gray-50 text-gray-600 hover:bg-gray-100 hover:text-danger lg:bg-transparent lg:hover:bg-transparent font-medium' }}">
            Booking Baru
        </a>
        <a href="{{ route('customer.profile.settings') }}" class="shrink-0 flex items-center px-4 lg:px-2 py-2 lg:py-3 rounded-full lg:rounded-none transition lg:border-b border-gray-100 {{ request()->routeIs('customer.profile.settings') ? 'bg-brand/10 text-danger font-bold lg:bg-transparent lg:text-danger' : 'bg-gray-50 text-gray-600 hover:bg-gray-100 hover:text-danger lg:bg-transparent lg:hover:bg-transparent font-medium' }}">
            Pengaturan Profil
        </a>
        
        <form method="POST" action="{{ route('logout') }}" class="shrink-0 lg:block inline-block">
            @csrf
            <a href="{{ route('logout') }}"
               onclick="event.preventDefault(); this.closest('form').submit();"
               class="flex items-center px-4 lg:px-2 py-2 lg:py-3 rounded-full lg:rounded-none transition lg:border-b border-gray-100 bg-red-50 text-red-600 hover:bg-red-100 font-medium lg:bg-transparent lg:hover:bg-transparent lg:text-gray-600 lg:hover:text-danger">
                Logout
            </a>
        </form>
    </nav>
</aside>

<style>
/* Hide scrollbar for horizontal scroll menu */
.scrollbar-hide::-webkit-scrollbar {
    display: none;
}
.scrollbar-hide {
    -ms-overflow-style: none;
    scrollbar-width: none;
}
</style>
