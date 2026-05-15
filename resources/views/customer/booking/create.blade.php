<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Service - Wijaya Motor</title>
    
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
<body class="bg-slate-50 text-primary antialiased" x-data="{ mobileMenuOpen: false }">

    <nav class="bg-white border-b border-slate-200 sticky top-0 z-50 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <a href="{{ url('/') }}" class="flex-shrink-0 flex items-center cursor-pointer group">
                    <span class="font-black text-2xl tracking-tighter text-primary group-hover:text-secondary transition-colors">WIJAYA <span class="text-neutral group-hover:text-neutral">MOTOR</span></span>
                </a>
                
                <div class="hidden md:flex space-x-10">
                    <a href="{{ url('/') }}" class="text-neutral hover:text-primary font-medium transition-colors">Beranda</a>
                    <a href="{{ url('/#services') }}" class="text-neutral hover:text-primary font-medium transition-colors">Layanan Servis</a>
                    <a href="{{ url('/#spareparts') }}" class="text-neutral hover:text-primary font-medium transition-colors">Katalog Sparepart</a>
                    <a href="#" class="text-secondary font-bold border-b-2 border-secondary pb-1">Booking</a>
                </div>
                
                <div class="hidden md:flex items-center space-x-5">
                    @auth
                        <a href="{{ route('dashboard') }}" class="text-sm font-bold text-primary hover:text-secondary transition">Dashboard Saya</a>
                    @else
                        <a href="{{ route('login') }}" class="bg-primary hover:bg-[#112a4f] text-white px-7 py-2.5 rounded-xl font-semibold transition-all shadow-md shadow-primary/20 hover:-translate-y-0.5">Masuk / Daftar</a>
                    @endauth
                </div>

                <div class="md:hidden flex items-center">
                    <button @click="mobileMenuOpen = !mobileMenuOpen" class="text-primary hover:text-secondary focus:outline-none">
                        <svg class="h-6 w-6" x-show="!mobileMenuOpen" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                        <svg class="h-6 w-6" x-show="mobileMenuOpen" x-cloak fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
            </div>
        </div>
        
        <div x-show="mobileMenuOpen" x-cloak class="md:hidden bg-white border-t border-slate-100" @click.away="mobileMenuOpen = false">
            <div class="px-4 pt-4 pb-6 space-y-3 shadow-lg">
                <a href="{{ url('/') }}" class="block px-3 py-2.5 rounded-lg text-neutral font-medium">Beranda</a>
                <a href="#" class="block px-3 py-2.5 rounded-lg text-secondary bg-secondary/5 font-bold">Booking</a>
                @guest
                    <a href="{{ route('login') }}" class="block w-full text-center bg-primary text-white mt-5 px-6 py-3 rounded-lg font-semibold transition">Masuk / Daftar</a>
                @else
                    <a href="{{ route('dashboard') }}" class="block w-full text-center bg-slate-100 text-primary mt-5 px-6 py-3 rounded-lg font-semibold transition">Dashboard Saya</a>
                @endguest
            </div>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-10 pb-6">
        <h1 class="text-4xl font-black text-primary mb-2">Jadwalkan Servis Anda</h1>
        <p class="text-neutral text-lg">Lengkapi formulir di bawah ini untuk mengamankan jadwal servis kendaraan Anda.</p>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-20">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <div class="lg:col-span-2">
                <div class="bg-white p-8 rounded-3xl shadow-sm border border-slate-100">
                    <form action="{{ route('booking.store') }}" method="POST">
                        @csrf
                        
                        <div class="mb-10">
                            <h3 class="text-lg font-bold text-primary mb-5 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-secondary" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                                Pilih Kendaraan Anda
                            </h3>
                            
                            @if($vehicles->count() > 0)
                                <select name="vehicle_id" required class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:ring-2 focus:ring-secondary outline-none bg-slate-50">
                                    <option value="" disabled selected>-- Pilih Kendaraan dari Garasi --</option>
                                    @foreach($vehicles as $vehicle)
                                        <option value="{{ $vehicle->id }}">
                                            {{ $vehicle->name }} - Plat: {{ $vehicle->plate_number }} ({{ $vehicle->year }})
                                        </option>
                                    @endforeach
                                </select>
                                <p class="text-xs text-neutral mt-2">*Mobil tidak ada di pilihan? <a href="{{ route('garasi.index') }}" class="text-secondary font-bold hover:underline">Tambah di Garasi Saya</a></p>
                            @else
                                <div class="bg-rose-50 border border-rose-200 p-4 rounded-xl">
                                    <p class="text-sm text-rose-600 font-medium mb-2">Anda belum mendaftarkan kendaraan di Garasi.</p>
                                    <a href="{{ route('garasi.index') }}" class="inline-block bg-primary text-white px-4 py-2 rounded-lg text-sm font-bold shadow-sm hover:bg-[#112a4f] transition-colors">
                                        + Tambah Kendaraan Sekarang
                                    </a>
                                </div>
                            @endif
                        </div>

                        <div class="mb-10">
                            <h3 class="text-lg font-bold text-primary mb-5 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-secondary" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                Detail Servis
                            </h3>
                            
                            <div class="mb-6">
                                <label class="block text-sm font-semibold text-slate-600 mb-2">Pilih Jenis Servis</label>
                                <select name="service_id" required class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:ring-2 focus:ring-secondary outline-none">
                                    <option value="" disabled selected>-- Pilih Layanan yang Dibutuhkan --</option>
                                    @foreach($services as $service)
                                        <option value="{{ $service->id }}">
                                            {{ $service->name }} (Estimasi: Rp {{ number_format($service->price_estimate, 0, ',', '.') }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                <div>
                                    <label class="block text-sm font-semibold text-primary mb-2">Tanggal Servis</label>
                                    <input type="date" name="preferred_date" required class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:ring-2 focus:ring-secondary outline-none transition-all text-neutral">
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-primary mb-2">Jam Servis</label>
                                    <select name="preferred_time" required class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:ring-2 focus:ring-secondary outline-none transition-all bg-white">
                                        <option value="08:00">08:00 WIB</option>
                                        <option value="10:00">10:00 WIB</option>
                                        <option value="13:00">13:00 WIB</option>
                                        <option value="15:00">15:00 WIB</option>
                                    </select>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-primary mb-2">Keluhan (Opsional)</label>
                                <textarea name="complaint" rows="3" placeholder="Contoh: Bunyi berdecit saat rem diinjak..." class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:ring-2 focus:ring-secondary outline-none transition-all resize-none"></textarea>
                            </div>
                        </div> <button type="submit" class="w-full bg-[#E86E25] hover:bg-[#c95a1a] text-white font-bold py-4 px-4 rounded-xl transition shadow-lg shadow-[#E86E25]/30 text-lg">
                            Konfirmasi Booking Servis
                        </button>

                    </form>
                </div>
            </div>

            <div class="lg:col-span-1 space-y-6">
                <div class="bg-primary rounded-3xl p-6 text-white shadow-xl">
                    <h3 class="text-xl font-bold mb-6">Ringkasan Booking</h3>
                    <div class="space-y-4 mb-6">
                        <div class="flex justify-between items-center pb-4 border-b border-white/10">
                            <span class="text-slate-300 text-sm">Estimasi Biaya Dasar</span>
                            <span class="font-bold">Sesuai Pilihan</span>
                        </div>
                        <div class="flex justify-between items-center pb-4 border-b border-white/10">
                            <span class="text-slate-300 text-sm">Estimasi Durasi</span>
                            <span class="font-bold">1 - 2 Jam</span>
                        </div>
                    </div>
                    <p class="text-[10px] text-slate-400 italic">*Biaya akhir dapat berubah menyesuaikan kondisi aktual kendaraan dan sparepart yang dibutuhkan.</p>
                </div>

                <div class="bg-white rounded-3xl overflow-hidden shadow-sm border border-slate-100">
                    <img src="https://images.unsplash.com/photo-1613214149922-f1809c99b414?auto=format&fit=crop&w=600&q=80" alt="Workshop" class="w-full h-40 object-cover">
                    <div class="p-6 space-y-4">
                        <div class="flex items-center text-primary font-medium text-sm">
                            <span class="w-6 h-6 rounded-full bg-secondary/10 text-secondary flex items-center justify-center mr-3">✓</span>
                            Mekanik Tersertifikasi
                        </div>
                        <div class="flex items-center text-primary font-medium text-sm">
                            <span class="w-6 h-6 rounded-full bg-secondary/10 text-secondary flex items-center justify-center mr-3">↺</span>
                            Suku Cadang Asli
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</body>
</html>