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
                        brand: { DEFAULT: '#dc2626', dark: '#b91c1c' }, // Replaced orange with red
                        ink: { DEFAULT: '#1a0505', light: '#2a0a0a' }, // Dark red-tinted ink
                        danger: '#E11D48',
                        primary: '#450a0a', // red-950
                        secondary: '#ef4444', // red-500
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
            width: 5px;
            height: 5px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 9999px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 255, 255, 0.25);
        }
    </style>
</head>
<body class="bg-[#F8FAFC] flex h-screen overflow-hidden antialiased" x-data="{ sidebarOpen: false }">
    
    <div x-show="sidebarOpen" x-cloak class="fixed inset-0 z-20 bg-slate-900/50 backdrop-blur-sm md:hidden" @click="sidebarOpen = false" x-transition.opacity></div>

    <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" class="fixed inset-y-0 left-0 z-30 w-64 bg-gradient-to-b from-[#450a0a] via-[#2a0a0a] to-[#000000] text-white flex flex-col transition-transform duration-300 md:relative md:translate-x-0 shrink-0 shadow-2xl md:shadow-none border-r border-red-900/30">
        <!-- Logo Area -->
        <div class="h-20 flex items-center justify-between px-6 border-b border-red-900/30 shrink-0 bg-black/20">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-lg bg-gradient-to-tr from-red-600 to-red-400 flex items-center justify-center text-white font-black text-lg border border-red-500/20 shadow-sm shadow-red-500/20">
                    <span class="text-white drop-shadow-md">W</span>
                </div>
                <div class="flex flex-col">
                    <span class="font-black text-sm tracking-widest text-white leading-none">WIJAYA <span class="text-red-500">MOTOR</span></span>
                    <span class="mt-1 self-start inline-flex items-center px-1.5 py-0.5 rounded text-[8px] font-black bg-red-500/10 text-red-400 border border-red-500/20 tracking-widest leading-none">PORTAL</span>
                </div>
            </div>
            <button @click="sidebarOpen = false" class="md:hidden text-slate-400 hover:text-white transition-colors bg-white/5 rounded-lg p-1.5 border border-white/5">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        
        <!-- Navigation Menu -->
        <nav class="flex-1 px-4 py-6 space-y-5 overflow-y-auto custom-scrollbar">
            <!-- Group 1: Navigation Utama -->
            <div>
                <span class="text-[9px] font-black text-red-200/50 uppercase tracking-[0.15em] px-3 flex items-center mb-3">
                    <span class="w-1.5 h-1.5 bg-red-500 rounded-sm opacity-60 mr-2 shrink-0"></span>
                    Navigasi Utama
                </span>
                <div class="space-y-1">
                    <a href="{{ route('admin.dashboard') }}" class="relative flex items-center space-x-3 px-4 py-2.5 rounded-lg font-bold transition-all duration-200 {{ request()->routeIs('admin.dashboard') ? "bg-red-600 text-white shadow-md shadow-red-900/20" : "text-red-100/60 hover:bg-white/[0.04] hover:text-white hover:translate-x-1 border border-transparent hover:border-red-500/10 group" }}">
                        <svg class="w-5 h-5 {{ request()->routeIs('admin.dashboard') ? 'text-white' : 'text-red-100/60 group-hover:text-red-400 transition-colors' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                        </svg>
                        <span class="text-sm">Dashboard</span>
                    </a>
                </div>
            </div>

            <!-- Group 2: Pelayanan -->
            <div class="border-t border-red-900/30 pt-4">
                <span class="text-[9px] font-black text-red-200/50 uppercase tracking-[0.15em] px-3 flex items-center mb-3">
                    <span class="w-1.5 h-1.5 bg-red-500 rounded-sm opacity-60 mr-2 shrink-0"></span>
                    Layanan & Antrean
                </span>
                <div class="space-y-1">
                    <a href="{{ route('admin.bookings.index') }}" class="relative flex items-center space-x-3 px-4 py-2.5 rounded-lg font-bold transition-all duration-200 {{ request()->routeIs('admin.bookings.*') ? "bg-red-600 text-white shadow-md shadow-red-900/20" : "text-red-100/60 hover:bg-white/[0.04] hover:text-white hover:translate-x-1 border border-transparent hover:border-red-500/10 group" }}">
                        <svg class="w-5 h-5 {{ request()->routeIs('admin.bookings.*') ? 'text-white' : 'text-red-100/60 group-hover:text-red-400 transition-colors' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                        </svg>
                        <span class="text-sm">Manajemen Booking</span>
                    </a>

                    <a href="{{ route('admin.orders.index') }}" class="relative flex items-center justify-between px-4 py-2.5 rounded-lg font-bold transition-all duration-200 {{ request()->routeIs('admin.orders.*') ? "bg-red-600 text-white shadow-md shadow-red-900/20" : "text-red-100/60 hover:bg-white/[0.04] hover:text-white hover:translate-x-1 border border-transparent hover:border-red-500/10 group" }}">
                        <div class="flex items-center space-x-3">
                            <svg class="w-5 h-5 {{ request()->routeIs('admin.orders.*') ? 'text-white' : 'text-red-100/60 group-hover:text-red-400 transition-colors' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                            </svg>
                            <span class="text-sm">Pesanan Sparepart</span>
                        </div>
                        @php $pendingOrders = \App\Models\Order::where('status','pending')->count(); @endphp
                        @if($pendingOrders > 0)
                            <span class="text-[10px] font-black px-1.5 py-0.5 rounded {{ request()->routeIs('admin.orders.*') ? 'bg-white/20 text-white' : 'bg-red-500/20 text-red-400 border border-red-500/30' }}">
                                {{ $pendingOrders }}
                            </span>
                        @endif
                    </a>
                </div>
            </div>

            <!-- Group 3: Data Master -->
            <div class="border-t border-red-900/30 pt-4">
                <span class="text-[9px] font-black text-red-200/50 uppercase tracking-[0.15em] px-3 flex items-center mb-3">
                    <span class="w-1.5 h-1.5 bg-red-500 rounded-sm opacity-60 mr-2 shrink-0"></span>
                    Data Gudang & Servis
                </span>
                <div class="space-y-1">
                    <a href="{{ route('admin.services.index') }}" class="relative flex items-center space-x-3 px-4 py-2.5 rounded-lg font-bold transition-all duration-200 {{ request()->routeIs('admin.services.*') ? "bg-red-600 text-white shadow-md shadow-red-900/20" : "text-red-100/60 hover:bg-white/[0.04] hover:text-white hover:translate-x-1 border border-transparent hover:border-red-500/10 group" }}">
                        <svg class="w-5 h-5 {{ request()->routeIs('admin.services.*') ? 'text-white' : 'text-red-100/60 group-hover:text-red-400 transition-colors' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        <span class="text-sm">Master Servis</span>
                    </a>

                    <a href="{{ route('admin.spareparts.index') }}" class="relative flex items-center space-x-3 px-4 py-2.5 rounded-lg font-bold transition-all duration-200 {{ request()->routeIs('admin.spareparts.*') ? "bg-red-600 text-white shadow-md shadow-red-900/20" : "text-red-100/60 hover:bg-white/[0.04] hover:text-white hover:translate-x-1 border border-transparent hover:border-red-500/10 group" }}">
                        <svg class="w-5 h-5 {{ request()->routeIs('admin.spareparts.*') ? 'text-white' : 'text-red-100/60 group-hover:text-red-400 transition-colors' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                        </svg>
                        <span class="text-sm">Kelola Sparepart</span>
                    </a>
                </div>
            </div>

            <!-- Group 4: Keuangan & Laporan -->
            <div class="border-t border-red-900/30 pt-4">
                <span class="text-[9px] font-black text-red-200/50 uppercase tracking-[0.15em] px-3 flex items-center mb-3">
                    <span class="w-1.5 h-1.5 bg-red-500 rounded-sm opacity-60 mr-2 shrink-0"></span>
                    Keuangan & Laporan
                </span>
                <div class="space-y-1">
                    <a href="{{ route('admin.laporan.index') }}" class="relative flex items-center space-x-3 px-4 py-2.5 rounded-lg font-bold transition-all duration-200 {{ request()->routeIs('admin.laporan.*') ? "bg-red-600 text-white shadow-md shadow-red-900/20" : "text-red-100/60 hover:bg-white/[0.04] hover:text-white hover:translate-x-1 border border-transparent hover:border-red-500/10 group" }}">
                        <svg class="w-5 h-5 {{ request()->routeIs('admin.laporan.*') ? 'text-white' : 'text-red-100/60 group-hover:text-red-400 transition-colors' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                        <span class="text-sm">Laporan Pemasukan</span>
                    </a>
                </div>
            </div>
        </nav>

        <!-- Sidebar Profile Card (Logout Integrated) -->
        <div class="p-4 border-t border-red-900/30 shrink-0 bg-black/20">
            <div class="flex items-center justify-between gap-3 p-3 rounded-xl bg-white/[0.03] border border-white/5 shadow-[inset_0_1px_1px_rgba(255,255,255,0.02)]">
                <div class="flex items-center gap-2.5 min-w-0">
                    <div class="relative shrink-0">
                        <div class="w-9 h-9 bg-red-600 text-white rounded-lg flex items-center justify-center font-extrabold text-sm border border-red-500/30 shadow-md">
                            {{ substr(Auth::user()->name ?? 'A', 0, 1) }}
                        </div>
                        <span class="absolute bottom-0 right-0 block h-2.5 w-2.5 rounded-full bg-emerald-500 ring-2 ring-[#450a0a] z-10"></span>
                    </div>
                    <div class="min-w-0">
                        <p class="text-xs font-black text-slate-100 truncate leading-tight">{{ Auth::user()->name ?? 'Admin' }}</p>
                        <p class="text-[9px] font-black text-red-400 uppercase tracking-[0.08em] mt-1">Admin Bengkel</p>
                    </div>
                </div>
                
                <form method="POST" action="{{ route('logout') }}" class="shrink-0">
                    @csrf
                    <button type="submit" class="w-8 h-8 rounded-lg flex items-center justify-center text-red-200/50 hover:text-red-400 hover:bg-red-500/10 hover:border-red-500/20 border border-transparent transition-all duration-200 focus:outline-none" title="Keluar Sistem">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                    </button>
                </form>
            </div>
        </div>
    </aside>

    <div class="flex-1 flex flex-col overflow-hidden w-full">
        
        <header class="bg-white h-20 flex items-center justify-between px-4 md:px-8 z-10 shrink-0 border-b border-slate-200/60 shadow-sm w-full">
            <div class="flex items-center">
                <button @click="sidebarOpen = true" class="md:hidden mr-4 text-slate-500 hover:text-slate-800 p-2 rounded-lg hover:bg-slate-50 transition-colors">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>
                <h1 class="text-lg md:text-xl font-extrabold text-slate-800 tracking-tight truncate">@yield('header_title', 'Overview')</h1>
            </div>
        </header>

        <main class="flex-1 overflow-y-auto p-4 md:p-8">
            @yield('content')
        </main>

    </div>

    @stack('modals')

</body>
</html>