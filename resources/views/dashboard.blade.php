<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Dashboard - Wijaya Motor</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#0A192F', // Dark Navy
                        secondary: '#FF8C00', // Orange
                        neutral: '#64748B',
                    },
                    fontFamily: { sans: ['Inter', 'sans-serif'] }
                }
            }
        }
    </script>
    <style> 
        body { font-family: 'Inter', sans-serif; } 
        [x-cloak] { display: none !important; }
        
        @keyframes fadeSlideUp {
            0% { opacity: 0; transform: translateY(15px); }
            100% { opacity: 1; transform: translateY(0); }
        }
        .animate-content {
            animation: fadeSlideUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }
    </style>
</head>
<body class="bg-slate-50 flex h-screen overflow-hidden antialiased" x-data="{ sidebarOpen: false }">

    <div x-show="sidebarOpen" x-transition.opacity @click="sidebarOpen = false" class="fixed inset-0 bg-primary/80 z-20 md:hidden backdrop-blur-sm"></div>

    <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" class="fixed inset-y-0 left-0 z-30 w-64 bg-primary text-white flex flex-col transition-transform duration-300 md:relative md:translate-x-0">
        
        <div class="h-20 flex items-center justify-between px-8 border-b border-white/5">
            <span class="font-bold text-2xl tracking-tighter text-white">WIJAYA <span class="text-secondary">MOTOR</span></span>
            <button @click="sidebarOpen = false" class="md:hidden text-neutral-400 hover:text-white">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        
        <nav class="flex-1 px-4 py-8 space-y-2 overflow-y-auto">
            <a href="#" class="flex items-center space-x-3 bg-white/5 text-white px-4 py-3.5 rounded-xl font-bold border-r-4 border-secondary transition-all">
                <svg class="w-5 h-5 text-secondary" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                <span>Panel Kontrol</span>
            </a>
            
            <a href="#" class="flex items-center space-x-3 text-slate-300 hover:bg-white/5 hover:text-white px-4 py-3.5 rounded-xl font-medium group transition-all">
                <svg class="w-5 h-5 text-neutral group-hover:text-secondary" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/></svg>
                <span>Garasi Saya</span>
            </a>
            
            <a href="#" class="flex items-center space-x-3 text-slate-300 hover:bg-white/5 hover:text-white px-4 py-3.5 rounded-xl font-medium group transition-all">
                <svg class="w-5 h-5 text-neutral group-hover:text-secondary" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                <span>Tiket Booking Aktif</span>
            </a>

            <a href="#" class="flex items-center space-x-3 text-slate-300 hover:bg-white/5 hover:text-white px-4 py-3.5 rounded-xl font-medium group transition-all">
                <svg class="w-5 h-5 text-neutral group-hover:text-secondary" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span>Riwayat Transaksi</span>
            </a>

            <a href="#" class="flex items-center space-x-3 text-slate-300 hover:bg-white/5 hover:text-white px-4 py-3.5 rounded-xl font-medium group transition-all">
                <svg class="w-5 h-5 text-neutral group-hover:text-secondary" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                <span>Rekomendasi Katalog</span>
            </a>
        </nav>

        <div class="p-4 border-t border-white/5">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="flex items-center space-x-3 text-red-300 hover:bg-red-500/10 px-4 py-3 rounded-xl w-full transition-all">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                    <span>Logout</span>
                </button>
            </form>
        </div>
    </aside>

    <div class="flex-1 flex flex-col overflow-hidden bg-slate-50">
        
        <header class="bg-white h-20 border-b border-slate-100 flex items-center justify-between px-4 sm:px-8 z-10 shadow-sm">
            <div class="flex items-center">
                <button @click="sidebarOpen = true" class="md:hidden mr-4 text-primary hover:text-secondary p-2 rounded-lg bg-slate-50 border border-slate-200">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>
                <h1 class="text-xl font-black text-primary tracking-tight">Utama</h1>
            </div>

            <div class="flex items-center space-x-6">
                <div class="flex items-center space-x-3 text-neutral">
                    <button class="relative hover:text-primary transition p-2.5 rounded-xl bg-slate-50 hover:bg-slate-100">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                        <span class="absolute top-1.5 right-1.5 block h-2 w-2 rounded-full ring-2 ring-white bg-red-500 animate-pulse"></span>
                    </button>
                    <button class="relative hover:text-primary transition p-2.5 rounded-xl bg-slate-50 hover:bg-slate-100">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                        <span class="absolute -top-1 -right-1 flex h-4 w-4 items-center justify-center rounded-full ring-2 ring-white bg-secondary text-[10px] font-bold text-white">3</span>
                    </button>
                </div>

                <div class="flex items-center space-x-3 cursor-pointer group">
                    <div class="w-11 h-11 bg-slate-200 rounded-full overflow-hidden border-2 border-secondary ring-2 ring-secondary/10 shadow-sm transition group-hover:shadow-secondary/20 group-hover:ring-secondary/30">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=0A192F&color=fff" alt="Avatar">
                    </div>
                </div>
            </div>
        </header>

        <main class="flex-1 overflow-y-auto p-4 sm:p-8 animate-content">
            
            <div class="mb-12">
                <h2 class="text-3xl md:text-4xl font-black text-primary tracking-tight">
                    Welcome back, {{ explode(' ', Auth::user()->name)[0] }}! <span class="origin-bottom-right inline-block hover:animate-bounce">👋</span>
                </h2>
                <p class="text-neutral mt-3 text-lg leading-relaxed max-w-2xl">Akses cepat kontrol kendaraan, riwayat servis, dan katalog rekomendasi Anda.</p>
            </div>

            <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
                
                <div class="xl:col-span-2">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-xl font-bold text-primary flex items-center">
                            <svg class="w-6 h-6 mr-3 text-secondary" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            Tiket Booking Aktif
                        </h3>
                        <a href="{{ route('booking.create') }}" class="text-sm font-bold text-secondary hover:text-[#e67e00] flex items-center transition">
                            + Booking Baru
                        </a>
                    </div>

                    @forelse($bookings as $booking)
                    <div class="bg-primary rounded-3xl p-8 text-white shadow-xl shadow-primary/20 flex flex-col md:flex-row items-center relative overflow-hidden group hover:scale-[1.01] transition-transform mb-6">
                        <div class="absolute -right-20 -top-20 w-64 h-64 bg-secondary rounded-full blur-[100px] opacity-10 transition group-hover:opacity-20"></div>
                        
                        <div class="md:flex-1 relative z-10 w-full mb-6 md:mb-0">
                            <div class="inline-flex items-center px-4 py-1.5 rounded-lg border border-secondary/30 bg-secondary/10 text-secondary text-xs font-bold tracking-widest uppercase mb-6">
                                Status: {{ strtoupper($booking->status) }}
                            </div>
                            <h4 class="text-3xl font-black mb-3">{{ $booking->vehicle->name ?? 'Mobil Dihapus' }}</h4>
                            <p class="text-secondary font-bold text-lg mb-8 uppercase tracking-wider">{{ $booking->vehicle->plate_number ?? '-' }}</p>
                            
                            <div class="grid grid-cols-2 gap-x-8 gap-y-4 text-sm max-w-sm">
                                <p class="text-slate-400">Servis ID:</p>
                                <p class="font-bold text-slate-100">Service #{{ $booking->service_id }}</p>
                                <p class="text-slate-400">Jadwal:</p>
                                <p class="font-bold text-slate-100">{{ \Carbon\Carbon::parse($booking->tanggal)->translatedFormat('l, d M Y') }}</p>
                                <p class="text-slate-400">Jam:</p>
                                <p class="font-bold text-slate-100">{{ $booking->jam }} WIB</p>
                            </div>
                        </div>

                        <div class="w-40 h-40 bg-white rounded-3xl p-5 shadow-inner relative z-10 flex flex-col items-center justify-center shrink-0">
                            <div class="w-full h-full bg-slate-100 rounded-xl flex items-center justify-center">
                                <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=WM-BOOKING-{{ $booking->id }}" alt="QR Code" class="rounded-lg mix-blend-multiply opacity-80">
                            </div>
                            <p class="text-[9px] text-neutral mt-2 font-mono">WM-BOOKING-{{ str_pad($booking->id, 4, '0', STR_PAD_LEFT) }}</p>
                        </div>
                    </div>
                    @empty
                    <div class="bg-white rounded-3xl border-2 border-dashed border-slate-200 p-12 text-center">
                        <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-neutral-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        </div>
                        <p class="text-neutral font-medium mb-4">Belum ada jadwal servis yang aktif.</p>
                        <a href="{{ route('booking.create') }}" class="inline-block bg-secondary hover:bg-[#e67e00] text-white px-6 py-2 rounded-lg font-bold transition shadow-md shadow-secondary/20">+ Buat Jadwal Servis</a>
                    </div>
                    @endforelse
                </div>

                <div class="xl:col-span-1 space-y-6">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-xl font-bold text-primary flex items-center">
                            <svg class="w-6 h-6 mr-3 text-secondary" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/></svg>
                            Garasi Saya ({{ $vehicles->count() }})
                        </h3>
                    </div>

                    <div class="space-y-4">
                        @forelse($vehicles as $vehicle)
                        <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm flex items-center hover:shadow-md hover:border-secondary/30 hover:-translate-y-0.5 transition-all duration-300 cursor-pointer group">
                            <div class="w-14 h-14 bg-slate-100 text-secondary rounded-xl flex items-center justify-center mr-4 shadow-inner text-xl">🚘</div>
                            <div class="flex-1">
                                <p class="text-xs text-neutral">Tahun: {{ $vehicle->year }}</p>
                                <h4 class="font-bold text-primary mb-1">{{ $vehicle->name }}</h4>
                                <p class="text-[11px] font-black text-secondary tracking-widest uppercase">{{ $vehicle->plate_number }}</p>
                            </div>
                            <svg class="w-5 h-5 text-neutral-300 group-hover:text-secondary transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </div>
                        @empty
                        <div class="bg-slate-50 p-6 rounded-2xl border border-slate-100 text-center">
                            <p class="text-sm text-neutral mb-2">Garasi kosong.</p>
                        </div>
                        @endforelse

                        <a href="{{ route('vehicle.create') }}" class="block w-full text-center bg-slate-100 hover:bg-slate-200 text-neutral-700 hover:text-primary font-bold px-6 py-4 rounded-xl border border-dashed border-slate-200 transition">
                            + Tambah Kendaraan
                        </a>
                    </div>
                </div>

            </div>
            </main>
    </div>

</body>
</html>