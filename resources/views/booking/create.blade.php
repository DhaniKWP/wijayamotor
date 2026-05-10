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
                            <h3 class="text-xl font-bold text-primary flex items-center mb-6">
                                <span class="text-secondary mr-3 text-2xl">🚘</span> Informasi Kendaraan
                            </h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                <div>
                                    <label class="block text-sm font-semibold text-primary mb-2">Merek (Brand)</label>
                                    <input type="text" name="brand" placeholder="Contoh: Honda" required class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:ring-2 focus:ring-secondary focus:border-transparent outline-none transition-all">
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-primary mb-2">Tipe (Model)</label>
                                    <input type="text" name="model" placeholder="Contoh: CR-V" required class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:ring-2 focus:ring-secondary focus:border-transparent outline-none transition-all">
                                </div>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                <div>
                                    <label class="block text-sm font-semibold text-primary mb-2">Tahun Kendaraan</label>
                                    <input type="number" name="year" placeholder="Contoh: 2018" min="1990" max="{{ date('Y') }}" required class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:ring-2 focus:ring-secondary focus:border-transparent outline-none transition-all">
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-primary mb-2">Plat Nomor</label>
                                    <input type="text" name="plate_number" placeholder="B 1234 ABC" required class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:ring-2 focus:ring-secondary focus:border-transparent outline-none transition-all uppercase">
                                </div>
                            </div>
                        </div>

                        <div class="mb-10">
                            <h3 class="text-xl font-bold text-primary flex items-center mb-6">
                                <span class="text-secondary mr-3 text-2xl">🛠️</span> Detail Servis
                            </h3>
                            
                            <div class="mb-6">
                                <label class="block text-sm font-semibold text-primary mb-2">Pilih Jenis Servis</label>
                                <select name="service_type" required class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:ring-2 focus:ring-secondary focus:border-transparent outline-none transition-all bg-white appearance-none">
                                    <option value="1">Routine Maintenance (Oil Change & Inspection)</option>
                                    <option value="2">Advanced Engine Tune-up</option>
                                    <option value="3">Brake Service & Replacement</option>
                                    <option value="4">Electrical & Battery Diagnostics</option>
                                </select>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                <div>
                                    <label class="block text-sm font-semibold text-primary mb-2">Tanggal Servis</label>
                                    <input type="date" name="preferred_date" required class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:ring-2 focus:ring-secondary focus:border-transparent outline-none transition-all text-neutral">
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-primary mb-2">Jam Servis</label>
                                    <select name="preferred_time" required class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:ring-2 focus:ring-secondary focus:border-transparent outline-none transition-all bg-white">
                                        <option value="08:00">08:00 WIB</option>
                                        <option value="10:00">10:00 WIB</option>
                                        <option value="13:00">13:00 WIB</option>
                                        <option value="15:00">15:00 WIB</option>
                                    </select>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-primary mb-2">Keluhan (Opsional)</label>
                                <textarea name="complaint" rows="3" placeholder="Contoh: Bunyi berdecit saat rem diinjak..." class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:ring-2 focus:ring-secondary focus:border-transparent outline-none transition-all resize-none"></textarea>
                            </div>
                        </div>

                        <button type="submit" class="w-full bg-[#E86E25] hover:bg-[#c95a1a] text-white font-bold py-4 px-4 rounded-xl transition shadow-lg shadow-[#E86E25]/30 text-lg">
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
                            <span class="font-bold">Rp 150.000*</span>
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