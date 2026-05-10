<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wijaya Motor - Premium Automotive Service</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    
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
    
    <style>
        body { font-family: 'Inter', sans-serif; }
        html { scroll-behavior: smooth; }
        
        /* Animasi Masuk */
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-up { animation: fadeUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
        .delay-100 { animation-delay: 100ms; }
        .delay-200 { animation-delay: 200ms; }
    </style>
</head>
<body class="bg-slate-50 text-primary antialiased selection:bg-secondary selection:text-white">

    <nav class="fixed w-full z-50 transition-all duration-300 backdrop-blur-md bg-white/85 border-b border-slate-200/50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <div class="flex-shrink-0 flex items-center cursor-pointer">
                    <span class="font-black text-2xl tracking-tighter text-primary">WIJAYA <span class="text-neutral">MOTOR</span></span>
                </div>
                
                <div class="hidden md:flex space-x-10">
                    <a href="#" class="text-secondary font-bold border-b-2 border-secondary pb-1">Home</a>
                    <a href="#services" class="text-neutral hover:text-primary font-medium transition-colors">Services</a>
                    <a href="#spareparts" class="text-neutral hover:text-primary font-medium transition-colors">Spareparts</a>
                    <a href="{{ route('booking.create') }}" class="text-neutral hover:text-primary font-medium transition-colors">Booking</a>
                    <a href="#" class="text-neutral hover:text-primary font-medium transition-colors">Contact</a>
                </div>
                
                <div class="flex items-center space-x-5">
                    @auth
                        <a href="{{ route('dashboard') }}" class="bg-primary hover:bg-[#112a4f] text-white px-7 py-2.5 rounded-xl font-semibold transition-all shadow-lg shadow-primary/20 hover:-translate-y-0.5">
                            Dashboard Saya
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="bg-primary hover:bg-[#112a4f] text-white px-7 py-2.5 rounded-xl font-semibold transition-all shadow-lg shadow-primary/20 hover:-translate-y-0.5">
                            Masuk / Daftar
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <section class="relative bg-primary h-[100vh] min-h-[600px] flex items-center pt-20">
        <div class="absolute inset-0 overflow-hidden">
            <img src="https://images.unsplash.com/photo-1613214149922-f1809c99b414?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80" alt="Car Garage" class="w-full h-full object-cover opacity-40 scale-105 transform transition-transform duration-[10s] hover:scale-100">
            <div class="absolute inset-0 bg-gradient-to-r from-primary via-primary/80 to-transparent"></div>
        </div>
        
        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
            <div class="max-w-2xl animate-fade-up opacity-0">
                <div class="inline-flex items-center px-4 py-2 rounded-full border border-secondary/30 bg-secondary/10 text-secondary text-sm font-bold tracking-widest uppercase mb-6 shadow-inner">
                    <span class="w-2 h-2 rounded-full bg-secondary mr-2 animate-pulse"></span>
                    Premium Auto Care
                </div>
                <h1 class="text-5xl md:text-7xl font-black text-white leading-tight mb-6 tracking-tight">
                    Precision Service<br>for <span class="text-secondary">Superior</span><br>Performance.
                </h1>
                <p class="text-lg md:text-xl text-slate-300 mb-10 leading-relaxed max-w-lg">
                    Experience world-class automotive maintenance. From routine check-ups to complex engine diagnostics, Wijaya Motor keeps you moving safely.
                </p>
                <div class="flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-4">
                    <a href="{{ route('booking.create') }}" class="inline-flex justify-center items-center bg-secondary hover:bg-[#e67e00] text-white px-8 py-4 rounded-xl font-bold transition-all shadow-lg shadow-secondary/30 hover:shadow-secondary/50 hover:-translate-y-1">
                        Booking Servis Sekarang
                    </a>
                    <a href="#services" class="inline-flex justify-center items-center bg-white/10 hover:bg-white/20 backdrop-blur-sm border border-white/20 text-white px-8 py-4 rounded-xl font-bold transition-all">
                        Eksplor Layanan
                    </a>
                </div>
            </div>
        </div>
    </section>

    <section id="services" class="py-24 bg-white relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between items-end mb-12 animate-fade-up opacity-0 delay-100">
                <div class="max-w-2xl">
                    <h2 class="text-3xl md:text-4xl font-black text-primary tracking-tight">Layanan Profesional Kami</h2>
                    <p class="text-neutral mt-4 text-lg">Mekanik tersertifikasi yang menangani kendaraan Anda dengan presisi maksimal.</p>
                </div>
                <a href="{{ route('booking.create') }}" class="text-secondary font-bold hover:text-[#e67e00] flex items-center mt-6 md:mt-0 group">
                    Buat Jadwal Servis Sekarang
                    <span class="ml-2 group-hover:translate-x-1 transition-transform">&rarr;</span>
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <a href="{{ route('booking.create') }}" class="md:col-span-2 relative rounded-3xl overflow-hidden group cursor-pointer shadow-md hover:shadow-2xl transition-all duration-500 min-h-[300px] block">
                    <img src="https://images.unsplash.com/photo-1632823465306-edeb51a4413a?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" class="absolute inset-0 w-full h-full object-cover group-hover:scale-110 transition-transform duration-700" alt="Tune up">
                    <div class="absolute inset-0 bg-gradient-to-t from-primary via-primary/60 to-transparent"></div>
                    <div class="absolute bottom-0 p-8 md:p-10 w-full">
                        <div class="w-12 h-12 bg-secondary/20 backdrop-blur-md text-secondary flex items-center justify-center rounded-2xl mb-6 shadow-inner">⚙️</div>
                        <h3 class="text-2xl md:text-3xl font-bold text-white mb-3">Advanced Engine Tune-up</h3>
                        <p class="text-slate-300 md:w-3/4 leading-relaxed">Restore your engine's peak efficiency and performance with our signature tuning protocol.</p>
                    </div>
                </a>

                <a href="{{ route('booking.create') }}" class="bg-slate-50 p-8 rounded-3xl border border-slate-100 hover:border-secondary/30 hover:shadow-xl transition-all duration-300 cursor-pointer group block">
                    <div class="w-12 h-12 bg-white shadow-sm text-secondary flex items-center justify-center rounded-2xl mb-6 group-hover:scale-110 transition-transform">🛢️</div>
                    <h3 class="text-xl font-bold text-primary mb-3">Oil Change</h3>
                    <p class="text-neutral text-sm mb-8 leading-relaxed">Premium synthetic oil replacement including filter check and fluid top-ups.</p>
                    <span class="text-primary font-bold text-sm flex items-center group-hover:text-secondary transition-colors">Booking <span class="ml-1 opacity-0 group-hover:opacity-100 group-hover:translate-x-1 transition-all">&rarr;</span></span>
                </a>

                </div>
        </div>
    </section>

    <section id="spareparts" class="py-24 bg-slate-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center mb-16 animate-fade-up opacity-0 delay-200">
            <span class="text-secondary font-bold tracking-widest text-sm uppercase">Original Parts</span>
            <h2 class="text-3xl md:text-4xl font-black text-primary mt-2">Katalog Sparepart</h2>
            <p class="text-neutral mt-4 max-w-2xl mx-auto text-lg">Suku cadang asli bergaransi untuk memastikan durabilitas dan keandalan kendaraan Anda.</p>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group">
                    <div class="bg-slate-50 rounded-2xl h-52 mb-6 flex items-center justify-center overflow-hidden relative">
                        <div class="absolute inset-0 bg-primary/5 opacity-0 group-hover:opacity-100 transition-opacity z-10 flex items-center justify-center">
                            <a href="{{ route('login') }}" class="bg-white text-primary px-4 py-2 rounded-lg font-bold shadow-lg transform translate-y-4 group-hover:translate-y-0 transition-all">Lihat Detail</a>
                        </div>
                        <img src="https://images.unsplash.com/photo-1606907568019-21b674b0d01b?ixlib=rb-4.0.3&w=300&q=80" alt="Oil" class="object-cover h-full w-full group-hover:scale-105 transition-transform duration-500">
                    </div>
                    <span class="text-[10px] font-black text-secondary tracking-widest uppercase bg-secondary/10 px-2 py-1 rounded-md">Lubricants</span>
                    <h3 class="font-bold text-primary text-lg mt-3 mb-4">Elite Synthetic 5W-30</h3>
                    <div class="flex justify-between items-center pt-4 border-t border-slate-100">
                        <span class="font-black text-xl text-primary">Rp 150.000</span>
                        <a href="{{ route('login') }}" class="bg-slate-50 p-2.5 rounded-xl border border-slate-200 hover:bg-secondary hover:text-white hover:border-secondary transition-colors text-primary">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 0a2 2 0 100 4 2 2 0 000-4z"></path></svg>
                        </a>
                    </div>
                </div>

                </div>
            
            <div class="text-center mt-12">
                <a href="#" class="inline-flex items-center text-primary font-bold hover:text-secondary transition-colors">
                    Lihat Semua Sparepart
                    <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                </a>
            </div>
        </div>
    </section>

    <footer class="bg-primary pt-20 pb-10 text-neutral-300 border-t-4 border-secondary">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-4 gap-12 mb-16">
            <div class="md:col-span-1">
                <span class="font-black text-2xl text-white block mb-6 tracking-tighter">WIJAYA <span class="text-secondary">MOTOR</span></span>
                <p class="text-sm leading-relaxed mb-6 text-slate-400">Delivering professional automotive excellence since 2010. Your trusted partner for performance and safety.</p>
            </div>
            <div>
                <h4 class="font-bold text-white mb-6 uppercase tracking-wider text-sm">Hubungi Kami</h4>
                <ul class="space-y-4 text-sm text-slate-400">
                    <li class="flex items-start"><span class="mr-3 text-secondary text-lg">📍</span> Jl. Sudirman No. 123, Jakarta Selatan</li>
                    <li class="flex items-start"><span class="mr-3 text-secondary text-lg">📞</span> +62 21 555 0199</li>
                    <li class="flex items-start"><span class="mr-3 text-secondary text-lg">✉️</span> hello@wijayamotor.com</li>
                </ul>
            </div>
            <div>
                <h4 class="font-bold text-white mb-6 uppercase tracking-wider text-sm">Akses Cepat</h4>
                <ul class="space-y-3 text-sm text-slate-400">
                    <li><a href="#" class="hover:text-secondary transition-colors flex items-center"><span class="mr-2 opacity-50">></span> Beranda</a></li>
                    <li><a href="{{ route('booking.create') }}" class="hover:text-secondary transition-colors flex items-center"><span class="mr-2 opacity-50">></span> Booking Servis</a></li>
                    <li><a href="#" class="hover:text-secondary transition-colors flex items-center"><span class="mr-2 opacity-50">></span> Katalog Sparepart</a></li>
                    <li><a href="#" class="hover:text-secondary transition-colors flex items-center"><span class="mr-2 opacity-50">></span> Tentang Kami</a></li>
                </ul>
            </div>
        </div>
    </footer>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('animate-fade-up');
                        entry.target.classList.remove('opacity-0');
                    }
                });
            });

            document.querySelectorAll('.opacity-0').forEach((el) => {
                observer.observe(el);
            });
        });
    </script>
</body>
</html>