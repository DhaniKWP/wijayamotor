<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard - Wijaya Motor')</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#0A192F',
                        secondary: '#FF8C00',
                        neutral: '#64748B',
                    },
                    fontFamily: { sans: ['Inter', 'sans-serif'] }
                }
            }
        }
    </script>
    <style> body { font-family: 'Inter', sans-serif; } [x-cloak] { display: none !important; } </style>
</head>
<body class="bg-[#F8FAFC] flex h-screen overflow-hidden antialiased" x-data="{ sidebarOpen: false }">
    
    <div x-show="sidebarOpen" x-cloak class="fixed inset-0 z-20 bg-slate-900/50 backdrop-blur-sm md:hidden" @click="sidebarOpen = false" x-transition.opacity></div>

    <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" class="fixed inset-y-0 left-0 z-30 w-64 bg-primary text-white flex flex-col transition-transform duration-300 md:relative md:translate-x-0 shrink-0 shadow-2xl md:shadow-none">
        <div class="h-20 flex items-center justify-between px-6 border-b border-white/5 shrink-0">
            <span class="font-black text-2xl tracking-tighter text-white">ADMIN <span class="text-secondary">PANEL</span></span>
            <button @click="sidebarOpen = false" class="md:hidden text-slate-400 hover:text-white">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        
        <nav class="flex-1 px-4 py-8 space-y-2 overflow-y-auto">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-3 px-4 py-3.5 rounded-xl font-bold transition-all {{ request()->routeIs('admin.dashboard') ? 'bg-white/5 text-white border-r-4 border-secondary' : 'text-slate-400 hover:bg-white/5 hover:text-white group' }}">
                <svg class="w-5 h-5 {{ request()->routeIs('admin.dashboard') ? 'text-secondary' : 'group-hover:text-secondary transition-colors' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                </svg>
                <span>Dashboard</span>
            </a>

            <a href="{{ route('admin.bookings.index') }}" class="flex items-center space-x-3 px-4 py-3.5 rounded-xl font-bold transition-all {{ request()->routeIs('admin.bookings.*') ? 'bg-white/5 text-white border-r-4 border-secondary' : 'text-slate-400 hover:bg-white/5 hover:text-white group' }}">
                <svg class="w-5 h-5 {{ request()->routeIs('admin.bookings.*') ? 'text-secondary' : 'group-hover:text-secondary transition-colors' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                </svg>
                <span>Manajemen Booking</span>
            </a>

            <a href="{{ route('admin.services.index') }}" class="flex items-center space-x-3 px-4 py-3.5 rounded-xl font-bold transition-all {{ request()->routeIs('admin.services.*') ? 'bg-white/5 text-white border-r-4 border-secondary' : 'text-slate-400 hover:bg-white/5 hover:text-white group' }}">
                <svg class="w-5 h-5 {{ request()->routeIs('admin.services.*') ? 'text-secondary' : 'group-hover:text-secondary transition-colors' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                <span>Master Servis</span>
            </a>

            <a href="{{ route('admin.spareparts.index') }}" class="flex items-center space-x-3 px-4 py-3.5 rounded-xl font-bold transition-all {{ request()->routeIs('admin.spareparts.*') ? 'bg-white/5 text-white border-r-4 border-secondary' : 'text-slate-400 hover:bg-white/5 hover:text-white group' }}">
                <svg class="w-5 h-5 {{ request()->routeIs('admin.spareparts.*') ? 'text-secondary' : 'group-hover:text-secondary transition-colors' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                </svg>
                <span>Kelola Sparepart</span>
            </a>
        </nav>

        <div class="p-4 border-t border-white/5 shrink-0">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="flex items-center space-x-3 text-red-300 hover:bg-red-500/10 px-4 py-3 rounded-xl w-full transition-all">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                    <span>Logout</span>
                </button>
            </form>
        </div>
    </aside>

    <div class="flex-1 flex flex-col overflow-hidden w-full">
        
        <header class="bg-white h-20 flex items-center justify-between px-4 md:px-8 z-10 shrink-0 border-b border-slate-200/60 shadow-sm w-full">
            <div class="flex items-center">
                <button @click="sidebarOpen = true" class="md:hidden mr-4 text-slate-500 hover:text-slate-800 p-2 rounded-lg hover:bg-slate-50">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>
                <h1 class="text-lg md:text-xl font-bold text-slate-800 tracking-tight truncate">@yield('header_title', 'Overview')</h1>
            </div>
            <div class="flex items-center space-x-4 shrink-0">
                <div class="text-right hidden sm:block">
                    <p class="text-sm font-bold text-primary">{{ Auth::user()->name ?? 'Admin' }}</p>
                    <p class="text-[10px] text-secondary font-bold uppercase tracking-wider">Administrator</p>
                </div>
                <div class="w-10 h-10 bg-primary rounded-full flex items-center justify-center text-white font-bold border-2 border-secondary shadow-sm">
                    {{ substr(Auth::user()->name ?? 'A', 0, 1) }}
                </div>
            </div>
        </header>

        <main class="flex-1 overflow-y-auto p-4 md:p-8">
            @yield('content')
        </main>

    </div>

    @stack('modals')

</body>
</html>