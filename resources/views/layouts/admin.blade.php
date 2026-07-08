<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard - Wijaya Motor')</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: { DEFAULT: '#dc2626', dark: '#b91c1c' }, // Merah ala Wijaya Motor
                        danger: '#E11D48',
                        neutral: '#64748B',
                    },
                    fontFamily: { sans: ['Plus Jakarta Sans', 'sans-serif'] }
                }
            }
        }
    </script>
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #F8FAFC; }
        [x-cloak] { display: none !important; }
        /* Custom thin scrollbar */
        .custom-scrollbar::-webkit-scrollbar {
            width: 4px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 9999px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
    </style>
</head>
<body class="bg-[#F8FAFC] flex h-screen overflow-hidden antialiased" x-data="{ sidebarOpen: false }">
    
    <div x-show="sidebarOpen" x-cloak class="fixed inset-0 z-20 bg-slate-900/50 backdrop-blur-sm md:hidden" @click="sidebarOpen = false" x-transition.opacity></div>

    <!-- Sidebar: Clean White (Menyesuaikan Landing Page) -->
    <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" class="fixed inset-y-0 left-0 z-30 w-[260px] bg-white text-slate-600 flex flex-col transition-transform duration-300 md:relative md:translate-x-0 shrink-0 shadow-2xl md:shadow-none border-r border-slate-200">
        
        <!-- Logo Area -->
        <div class="h-20 flex items-center justify-between px-6 border-b border-slate-100 shrink-0 bg-white">
            <div class="flex items-center gap-3">
                <div class="flex flex-col">
                    <span class="font-extrabold text-lg tracking-tight text-slate-800 leading-none">WIJAYA<span class="text-brand">MOTOR</span></span>
                    <span class="mt-1 self-start inline-flex items-center text-[9px] font-bold text-slate-400 tracking-widest leading-none uppercase">Admin Panel</span>
                </div>
            </div>
            <button @click="sidebarOpen = false" class="md:hidden text-slate-400 hover:text-slate-600 transition-colors bg-slate-50 rounded-lg p-1.5 border border-slate-200">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        
        <!-- Navigation Menu -->
        <nav class="flex-1 px-4 py-6 space-y-6 overflow-y-auto custom-scrollbar">
            <!-- Group 1: Navigation Utama -->
            <div>
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest px-3 mb-2 flex">Utama</span>
                <div class="space-y-1">
                    <a href="{{ route('admin.dashboard') }}" class="relative flex items-center space-x-3 px-3 py-2.5 rounded-xl font-semibold transition-all duration-200 {{ request()->routeIs('admin.dashboard') ? "bg-red-50 text-brand border border-red-100 shadow-sm" : "text-slate-500 hover:bg-slate-50 hover:text-brand group border border-transparent" }}">
                        <svg class="w-5 h-5 {{ request()->routeIs('admin.dashboard') ? 'text-brand' : 'text-slate-400 group-hover:text-brand' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                        </svg>
                        <span class="text-sm">Dashboard</span>
                    </a>
                </div>
            </div>

            <!-- Group 2: Pelayanan -->
            <div>
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest px-3 mb-2 flex">Operasional</span>
                <div class="space-y-1">
                    <a href="{{ route('admin.bookings.index', ['status' => 'pending']) }}" class="relative flex items-center justify-between px-3 py-2.5 rounded-xl font-semibold transition-all duration-200 {{ request()->routeIs('admin.bookings.*') ? "bg-red-50 text-brand border border-red-100 shadow-sm" : "text-slate-500 hover:bg-slate-50 hover:text-brand group border border-transparent" }}">
                        <div class="flex items-center space-x-3">
                            <svg class="w-5 h-5 {{ request()->routeIs('admin.bookings.*') ? 'text-brand' : 'text-slate-400 group-hover:text-brand' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                            </svg>
                            <span class="text-sm">Manajemen Antrean</span>
                        </div>
                        @php $pendingBookings = \App\Models\Booking::where('status','pending')->count(); @endphp
                        @if($pendingBookings > 0)
                            <span class="text-[10px] font-bold px-1.5 py-0.5 rounded-md {{ request()->routeIs('admin.bookings.*') ? 'bg-brand text-white' : 'bg-slate-200 text-slate-600' }}">
                                {{ $pendingBookings }}
                            </span>
                        @endif
                    </a>

                    <a href="{{ route('admin.orders.index', ['status' => 'pending']) }}" class="relative flex items-center justify-between px-3 py-2.5 rounded-xl font-semibold transition-all duration-200 {{ request()->routeIs('admin.orders.*') ? "bg-red-50 text-brand border border-red-100 shadow-sm" : "text-slate-500 hover:bg-slate-50 hover:text-brand group border border-transparent" }}">
                        <div class="flex items-center space-x-3">
                            <svg class="w-5 h-5 {{ request()->routeIs('admin.orders.*') ? 'text-brand' : 'text-slate-400 group-hover:text-brand' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                            </svg>
                            <span class="text-sm">Pesanan Online</span>
                        </div>
                        @php $pendingOrders = \App\Models\Order::where('status','pending')->count(); @endphp
                        @if($pendingOrders > 0)
                            <span class="text-[10px] font-bold px-1.5 py-0.5 rounded-md {{ request()->routeIs('admin.orders.*') ? 'bg-brand text-white' : 'bg-slate-200 text-slate-600' }}">
                                {{ $pendingOrders }}
                            </span>
                        @endif
                    </a>

                    <a href="{{ route('admin.offline-sales.index') }}" class="relative flex items-center space-x-3 px-3 py-2.5 rounded-xl font-semibold transition-all duration-200 {{ request()->routeIs('admin.offline-sales.*') ? 'bg-red-50 text-brand border border-red-100 shadow-sm' : 'text-slate-500 hover:bg-slate-50 hover:text-brand group border border-transparent' }}">
                        <svg class="w-5 h-5 {{ request()->routeIs('admin.offline-sales.*') ? 'text-brand' : 'text-slate-400 group-hover:text-brand' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                        <span class="text-sm">Kasir Offline</span>
                    </a>
                </div>
            </div>

            <!-- Group 3: Data Master -->
            <div>
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest px-3 mb-2 flex">Master Data</span>
                <div class="space-y-1">
                    <a href="{{ route('admin.services.index') }}" class="relative flex items-center space-x-3 px-3 py-2.5 rounded-xl font-semibold transition-all duration-200 {{ request()->routeIs('admin.services.*') ? "bg-red-50 text-brand border border-red-100 shadow-sm" : "text-slate-500 hover:bg-slate-50 hover:text-brand group border border-transparent" }}">
                        <svg class="w-5 h-5 {{ request()->routeIs('admin.services.*') ? 'text-brand' : 'text-slate-400 group-hover:text-brand' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        <span class="text-sm">Katalog Servis</span>
                    </a>

                    <a href="{{ route('admin.spareparts.index') }}" class="relative flex items-center space-x-3 px-3 py-2.5 rounded-xl font-semibold transition-all duration-200 {{ request()->routeIs('admin.spareparts.*') ? "bg-red-50 text-brand border border-red-100 shadow-sm" : "text-slate-500 hover:bg-slate-50 hover:text-brand group border border-transparent" }}">
                        <svg class="w-5 h-5 {{ request()->routeIs('admin.spareparts.*') ? 'text-brand' : 'text-slate-400 group-hover:text-brand' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                        </svg>
                        <span class="text-sm">Inventaris Sparepart</span>
                    </a>
                </div>
            </div>

            <!-- Group 4: Laporan -->
            <div>
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest px-3 mb-2 flex">Keuangan</span>
                <div class="space-y-1">
                    <a href="{{ route('admin.laporan.index') }}" class="relative flex items-center space-x-3 px-3 py-2.5 rounded-xl font-semibold transition-all duration-200 {{ request()->routeIs('admin.laporan.*') ? "bg-red-50 text-brand border border-red-100 shadow-sm" : "text-slate-500 hover:bg-slate-50 hover:text-brand group border border-transparent" }}">
                        <svg class="w-5 h-5 {{ request()->routeIs('admin.laporan.*') ? 'text-brand' : 'text-slate-400 group-hover:text-brand' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                        <span class="text-sm">Laporan Pemasukan</span>
                    </a>
                </div>
            </div>
        </nav>

        <!-- Sidebar Profile Card -->
        <div class="p-4 border-t border-slate-100 shrink-0 bg-slate-50/50">
            <div class="flex items-center justify-between gap-3 px-2 py-1">
                <div class="flex items-center gap-3 min-w-0">
                    <div class="relative shrink-0">
                        <div class="w-8 h-8 bg-slate-200 text-slate-600 rounded-full flex items-center justify-center font-bold text-sm border border-slate-300">
                            {{ substr(Auth::user()->name ?? 'A', 0, 1) }}
                        </div>
                        <span class="absolute bottom-0 right-0 block h-2 w-2 rounded-full bg-emerald-500 ring-2 ring-white z-10"></span>
                    </div>
                    <div class="min-w-0">
                        <p class="text-xs font-bold text-slate-700 truncate">{{ Auth::user()->name ?? 'Admin' }}</p>
                        <p class="text-[10px] text-slate-400 font-medium truncate">Administrator</p>
                    </div>
                </div>
                
                <form method="POST" action="{{ route('logout') }}" class="shrink-0">
                    @csrf
                    <button type="submit" class="p-2 rounded-lg text-slate-400 hover:text-red-600 hover:bg-red-50 transition-colors focus:outline-none" title="Logout">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                    </button>
                </form>
            </div>
        </div>
    </aside>

    <!-- Main Content Area -->
    <div class="flex-1 flex flex-col overflow-hidden w-full bg-slate-50/50">
        
        <header class="bg-white/80 backdrop-blur-md h-16 flex items-center justify-between px-6 z-10 shrink-0 border-b border-slate-200/60 sticky top-0 w-full">
            <div class="flex items-center">
                <button @click="sidebarOpen = true" class="md:hidden mr-4 text-slate-500 hover:text-slate-800 p-2 rounded-lg hover:bg-slate-100 transition-colors">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>
                <h1 class="text-lg font-extrabold text-slate-800 tracking-tight truncate">@yield('header_title', 'Overview')</h1>
            </div>
            <div class="flex items-center gap-4">
                <div class="hidden md:flex items-center text-sm font-semibold text-slate-500 bg-white border border-slate-200 shadow-sm px-3 py-1.5 rounded-lg">
                    {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}
                </div>
            </div>
        </header>

        <main class="flex-1 overflow-y-auto p-4 md:p-6 lg:p-8">
            <div class="max-w-7xl mx-auto">
                @yield('content')
            </div>
        </main>

    </div>

    @stack('modals')

    @include('layouts.sweetalert')
</body>
</html>