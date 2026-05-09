<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wijaya Motor - Professional Automotive Excellence</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased">

    <nav class="bg-white shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <div class="flex-shrink-0 flex items-center">
                    <span class="font-bold text-2xl tracking-tighter text-slate-900">WIJAYA <span class="text-slate-700">MOTOR</span></span>
                </div>
                <div class="hidden md:flex space-x-8">
                    <a href="#" class="text-orange-500 font-medium border-b-2 border-orange-500 pb-1">Home</a>
                    <a href="#" class="text-slate-500 hover:text-slate-900 font-medium transition">Services</a>
                    <a href="#" class="text-slate-500 hover:text-slate-900 font-medium transition">Spareparts</a>
                    <a href="#" class="text-slate-500 hover:text-slate-900 font-medium transition">Booking</a>
                    <a href="#" class="text-slate-500 hover:text-slate-900 font-medium transition">Contact</a>
                </div>
                <div class="flex items-center space-x-4">
                    <button class="text-slate-500 hover:text-slate-900">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </button>
                    <a href="{{ route('login') }}" class="bg-slate-900 hover:bg-slate-800 text-white px-6 py-2.5 rounded-lg font-medium transition shadow-md">Login/Register</a>
                </div>
            </div>
        </div>
    </nav>

    <section class="relative bg-slate-900 h-[600px] flex items-center">
        <div class="absolute inset-0">
            <img src="https://images.unsplash.com/photo-1613214149922-f1809c99b414?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80" alt="Car Garage" class="w-full h-full object-cover opacity-40">
        </div>
        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
            <div class="max-w-2xl">
                <span class="text-orange-400 font-semibold tracking-wider text-sm uppercase border border-orange-400/30 bg-orange-400/10 px-3 py-1 rounded-full">Expert Car Care</span>
                <h1 class="mt-6 text-5xl md:text-6xl font-bold text-white leading-tight">
                    Precision Service<br>for <span class="text-orange-500">Superior</span><br>Performance.
                </h1>
                <p class="mt-6 text-lg text-slate-300">
                    Experience world-class automotive maintenance. From routine check-ups to complex engine diagnostics, Wijaya Motor keeps you moving safely.
                </p>
                <div class="mt-8 flex space-x-4">
                    <a href="#" class="bg-orange-500 hover:bg-orange-600 text-white px-8 py-3.5 rounded-lg font-semibold transition shadow-lg shadow-orange-500/30">Book Service Now</a>
                    <a href="#" class="border border-slate-400 text-white hover:bg-white/10 px-8 py-3.5 rounded-lg font-semibold transition">View Price List</a>
                </div>
            </div>
        </div>
    </section>

    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-end mb-10">
                <div>
                    <h2 class="text-xl font-semibold text-slate-800">Our Professional Services</h2>
                    <p class="text-slate-500 mt-2">Certified experts handling your vehicle with mechanical precision.</p>
                </div>
                <a href="#" class="text-orange-500 font-medium hover:text-orange-600 flex items-center">Explore All Services <span class="ml-2">&rarr;</span></a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="md:col-span-2 relative rounded-2xl overflow-hidden group cursor-pointer">
                    <img src="https://images.unsplash.com/photo-1632823465306-edeb51a4413a?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" class="w-full h-80 object-cover group-hover:scale-105 transition duration-500" alt="Tune up">
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-slate-900/40 to-transparent"></div>
                    <div class="absolute bottom-0 p-8">
                        <div class="w-10 h-10 bg-orange-500/20 text-orange-500 flex items-center justify-center rounded-lg mb-4">⚙️</div>
                        <h3 class="text-xl font-bold text-white mb-2">Advanced Engine Tune-up</h3>
                        <p class="text-slate-300">Restore your engine's peak efficiency and performance with our signature tuning protocol.</p>
                    </div>
                </div>

                <div class="bg-slate-50 p-8 rounded-2xl border border-slate-100 hover:shadow-lg transition cursor-pointer">
                    <div class="w-10 h-10 bg-orange-100 text-orange-500 flex items-center justify-center rounded-lg mb-6">🛢️</div>
                    <h3 class="text-lg font-bold text-slate-800 mb-2">Oil Change</h3>
                    <p class="text-slate-500 text-sm mb-6">Premium synthetic oil replacement including filter check and fluid top-ups.</p>
                    <span class="text-slate-900 font-medium text-sm">Learn More ></span>
                </div>

                <div class="bg-slate-50 p-8 rounded-2xl border border-slate-100 hover:shadow-lg transition cursor-pointer">
                    <div class="w-10 h-10 bg-orange-100 text-orange-500 flex items-center justify-center rounded-lg mb-6">🛑</div>
                    <h3 class="text-lg font-bold text-slate-800 mb-2">Brake Service</h3>
                    <p class="text-slate-500 text-sm mb-6">Comprehensive inspection and pad replacement to ensure your absolute safety.</p>
                    <span class="text-slate-900 font-medium text-sm">Learn More ></span>
                </div>

                <div class="bg-slate-900 p-8 rounded-2xl border border-slate-800 hover:shadow-lg transition cursor-pointer">
                    <div class="w-10 h-10 bg-slate-800 text-blue-400 flex items-center justify-center rounded-lg mb-6">⚡</div>
                    <h3 class="text-lg font-bold text-white mb-2">Battery & Electrical</h3>
                    <p class="text-slate-400 text-sm mb-6">Complete electrical system diagnostic and premium battery replacement services.</p>
                    <span class="text-white font-medium text-sm">Learn More ></span>
                </div>

                <div class="bg-slate-50 p-8 rounded-2xl border border-slate-100 hover:shadow-lg transition cursor-pointer">
                    <div class="w-10 h-10 bg-orange-100 text-orange-500 flex items-center justify-center rounded-lg mb-6">❄️</div>
                    <h3 class="text-lg font-bold text-slate-800 mb-2">A/C Recharge</h3>
                    <p class="text-slate-500 text-sm mb-6">Keep your cabin cool with our high-pressure system leak test and gas recharge.</p>
                    <span class="text-slate-900 font-medium text-sm">Learn More ></span>
                </div>
            </div>
        </div>
    </section>

    <section class="py-20 bg-slate-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center mb-12">
            <h2 class="text-xl font-semibold text-slate-800">Featured Spareparts</h2>
            <p class="text-slate-500 mt-2">Genuine parts for long-lasting reliability.</p>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-100 hover:shadow-md transition">
                    <div class="bg-slate-100 rounded-xl h-48 mb-4 flex items-center justify-center overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1606907568019-21b674b0d01b?ixlib=rb-4.0.3&w=300&q=80" alt="Oil" class="object-cover h-full w-full">
                    </div>
                    <span class="text-xs font-bold text-orange-500 tracking-wider uppercase">Lubricants</span>
                    <h3 class="font-bold text-slate-800 mt-1 mb-4">Elite Synthetic 5W-30</h3>
                    <div class="flex justify-between items-center">
                        <span class="font-bold text-lg text-slate-900">$54.99</span>
                        <button class="bg-slate-50 p-2 rounded-lg border border-slate-200 hover:bg-slate-100"><svg class="w-5 h-5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 0a2 2 0 100 4 2 2 0 000-4z"></path></svg></button>
                    </div>
                </div>

                <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-100 hover:shadow-md transition">
                    <div class="bg-slate-100 rounded-xl h-48 mb-4 flex items-center justify-center">
                        <img src="https://images.unsplash.com/photo-1590209459345-d84a70bceb52?ixlib=rb-4.0.3&w=300&q=80" alt="Brake Pad" class="object-cover h-full w-full rounded-xl">
                    </div>
                    <span class="text-xs font-bold text-orange-500 tracking-wider uppercase">Braking</span>
                    <h3 class="font-bold text-slate-800 mt-1 mb-4">Ceramic Ultra Pads</h3>
                    <div class="flex justify-between items-center">
                        <span class="font-bold text-lg text-slate-900">$89.00</span>
                        <button class="bg-slate-50 p-2 rounded-lg border border-slate-200 hover:bg-slate-100"><svg class="w-5 h-5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 0a2 2 0 100 4 2 2 0 000-4z"></path></svg></button>
                    </div>
                </div>
                
                 </div>
        </div>
    </section>

    <section class="py-20 bg-white">
        <div class="max-w-4xl mx-auto px-4 text-center">
            <span class="text-5xl font-black text-orange-500 leading-none">99</span>
            <h2 class="text-xl font-semibold text-slate-800 mt-4 mb-12">What Our Clients Say</h2>
            
            <div class="grid md:grid-cols-2 gap-8 text-left">
                <div class="bg-slate-50 p-8 rounded-2xl border border-slate-100">
                    <div class="text-orange-400 mb-4">★★★★★</div>
                    <p class="text-slate-600 italic mb-6">"The service at Wijaya Motor is truly exceptional. They diagnosed a tricky electrical issue in my car that three other shops couldn't find. Highly recommended!"</p>
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-slate-300 rounded-full mr-4 overflow-hidden"><img src="https://i.pravatar.cc/150?img=11" alt="User"></div>
                        <div>
                            <h4 class="font-bold text-slate-800">Robert J. Henderson</h4>
                            <span class="text-xs text-slate-500">BMW X5 Owner</span>
                        </div>
                    </div>
                </div>
                <div class="bg-slate-50 p-8 rounded-2xl border border-slate-100">
                    <div class="text-orange-400 mb-4">★★★★★</div>
                    <p class="text-slate-600 italic mb-6">"Clean, professional, and transparent. I love the digital inspection reports they send to my phone. No more guessing what needs fixing."</p>
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-slate-300 rounded-full mr-4 overflow-hidden"><img src="https://i.pravatar.cc/150?img=5" alt="User"></div>
                        <div>
                            <h4 class="font-bold text-slate-800">Sarah Mitchell</h4>
                            <span class="text-xs text-slate-500">Audi A4 Owner</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer class="bg-[#0f172a] pt-16 pb-8 text-slate-400">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-4 gap-12 mb-12">
            <div>
                <span class="font-bold text-xl text-white block mb-4">WIJAYA MOTOR</span>
                <p class="text-sm leading-relaxed mb-6">Delivering professional automotive excellence since 2010. Your trusted partner for performance and safety.</p>
            </div>
            <div>
                <h4 class="font-bold text-white mb-4">Contact Us</h4>
                <ul class="space-y-3 text-sm">
                    <li class="flex items-start"><span class="mr-2 text-orange-500">📍</span> Jl. Sudirman No. 123, Jakarta Selatan</li>
                    <li class="flex items-start"><span class="mr-2 text-orange-500">📞</span> +62 21 555 0199</li>
                    <li class="flex items-start"><span class="mr-2 text-orange-500">✉️</span> info@wijayamotor.com</li>
                </ul>
            </div>
            <div>
                <h4 class="font-bold text-white mb-4">Quick Links</h4>
                <ul class="space-y-2 text-sm">
                    <li><a href="#" class="hover:text-white transition">Privacy Policy</a></li>
                    <li><a href="#" class="hover:text-white transition">Terms of Service</a></li>
                    <li><a href="#" class="hover:text-white transition">FAQ</a></li>
                    <li><a href="#" class="hover:text-white transition">Support</a></li>
                </ul>
            </div>
            <div>
                <h4 class="font-bold text-white mb-4">Working Hours</h4>
                <ul class="space-y-2 text-sm">
                    <li class="flex justify-between"><span>Mon - Fri:</span> <span>08:00 - 18:00</span></li>
                    <li class="flex justify-between"><span>Saturday:</span> <span>08:00 - 15:00</span></li>
                    <li class="flex justify-between text-orange-400"><span>Sunday:</span> <span>Closed</span></li>
                </ul>
            </div>
        </div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-8 border-t border-slate-800 text-sm flex justify-between items-center">
            <p>&copy; 2024 Wijaya Motor. Professional Automotive Excellence.</p>
        </div>
    </footer>

</body>
</html>