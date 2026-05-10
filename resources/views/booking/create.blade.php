<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Service - Wijaya Motor</title>
    
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
    <style> body { font-family: 'Inter', sans-serif; } </style>
</head>
<body class="bg-slate-50 text-primary antialiased">

    <nav class="bg-white border-b border-slate-200 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <div class="flex-shrink-0 flex items-center">
                    <a href="{{ url('/') }}" class="font-black text-2xl tracking-tighter text-primary">WIJAYA <span class="text-neutral">MOTOR</span></a>
                </div>
                
                <div class="hidden md:flex space-x-8">
                    <a href="{{ url('/') }}" class="text-neutral hover:text-primary font-medium transition-colors">Home</a>
                    <a href="#" class="text-neutral hover:text-primary font-medium transition-colors">Services</a>
                    <a href="#" class="text-neutral hover:text-primary font-medium transition-colors">Spareparts</a>
                    <a href="#" class="text-secondary font-bold border-b-2 border-secondary pb-1">Booking</a>
                    <a href="#" class="text-neutral hover:text-primary font-medium transition-colors">Contact</a>
                </div>
                
                <div class="flex items-center space-x-5">
                    @auth
                        <a href="{{ route('dashboard') }}" class="text-primary font-bold hover:text-secondary">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="bg-secondary hover:bg-[#e67e00] text-white px-6 py-2 rounded-lg font-semibold transition-all shadow-md shadow-secondary/20">Login/Register</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-10 pb-6">
        <h1 class="text-4xl font-black text-primary mb-2">Schedule Your Service</h1>
        <p class="text-neutral text-lg">Complete the form below to secure your professional automotive appointment.</p>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-20">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <div class="lg:col-span-2">
                <div class="bg-white p-8 rounded-3xl shadow-sm border border-slate-100">
                    <form action="{{ route('booking.store') }}" method="POST">
                        @csrf
                        
                        <div class="mb-10">
                            <h3 class="text-xl font-bold text-primary flex items-center mb-6">
                                <span class="text-secondary mr-3 text-2xl">🚘</span> Vehicle Information
                            </h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                <div>
                                    <label class="block text-sm font-semibold text-primary mb-2">Brand</label>
                                    <input type="text" name="brand" placeholder="e.g. Honda" required class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:ring-2 focus:ring-secondary focus:border-transparent outline-none transition-all">
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-primary mb-2">Model</label>
                                    <input type="text" name="model" placeholder="e.g. CR-V" required class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:ring-2 focus:ring-secondary focus:border-transparent outline-none transition-all">
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-primary mb-2">Plate Number</label>
                                <input type="text" name="plate_number" placeholder="B 1234 ABC" required class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:ring-2 focus:ring-secondary focus:border-transparent outline-none transition-all uppercase">
                            </div>
                        </div>

                        <div class="mb-10">
                            <h3 class="text-xl font-bold text-primary flex items-center mb-6">
                                <span class="text-secondary mr-3 text-2xl">🛠️</span> Service Details
                            </h3>
                            
                            <div class="mb-6">
                                <label class="block text-sm font-semibold text-primary mb-2">Select Service Type</label>
                                <select name="service_type" required class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:ring-2 focus:ring-secondary focus:border-transparent outline-none transition-all bg-white appearance-none">
                                    <option value="1">Routine Maintenance (Oil Change & Inspection)</option>
                                    <option value="2">Advanced Engine Tune-up</option>
                                    <option value="3">Brake Service & Replacement</option>
                                    <option value="4">Electrical & Battery Diagnostics</option>
                                </select>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                <div>
                                    <label class="block text-sm font-semibold text-primary mb-2">Preferred Date</label>
                                    <input type="date" name="preferred_date" required class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:ring-2 focus:ring-secondary focus:border-transparent outline-none transition-all text-neutral">
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-primary mb-2">Preferred Time</label>
                                    <select name="preferred_time" required class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:ring-2 focus:ring-secondary focus:border-transparent outline-none transition-all bg-white">
                                        <option value="08:00">08:00 AM</option>
                                        <option value="10:00">10:00 AM</option>
                                        <option value="13:00">01:00 PM</option>
                                        <option value="15:00">03:00 PM</option>
                                    </select>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-primary mb-2">Describe Complaint (Optional)</label>
                                <textarea name="complaint" rows="3" placeholder="e.g. Strange noise when braking, vibrating steering wheel..." class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:ring-2 focus:ring-secondary focus:border-transparent outline-none transition-all resize-none"></textarea>
                            </div>
                        </div>

                        <button type="submit" class="w-full bg-[#E86E25] hover:bg-[#c95a1a] text-white font-bold py-4 px-4 rounded-xl transition shadow-lg shadow-[#E86E25]/30 text-lg">
                            Confirm Appointment Booking
                        </button>
                    </form>
                </div>
            </div>

            <div class="lg:col-span-1 space-y-6">
                
                <div class="bg-primary rounded-3xl p-6 text-white shadow-xl">
                    <h3 class="text-xl font-bold mb-6">Booking Summary</h3>
                    
                    <div class="space-y-4 mb-6">
                        <div class="flex justify-between items-center pb-4 border-b border-white/10">
                            <span class="text-slate-300 text-sm">Estimated Price</span>
                            <span class="font-bold">Rp 750.000*</span>
                        </div>
                        <div class="flex justify-between items-center pb-4 border-b border-white/10">
                            <span class="text-slate-300 text-sm">Estimated Duration</span>
                            <span class="font-bold">120 Minutes</span>
                        </div>
                    </div>
                    
                    <p class="text-[10px] text-slate-400 italic">
                        *Final price may vary based on actual spare parts needed after physical inspection.
                    </p>
                </div>

                <div class="bg-white rounded-3xl overflow-hidden shadow-sm border border-slate-100">
                    <img src="https://images.unsplash.com/photo-1613214149922-f1809c99b414?auto=format&fit=crop&w=600&q=80" alt="Workshop" class="w-full h-40 object-cover">
                    <div class="p-6 space-y-4">
                        <div class="flex items-center text-primary font-medium text-sm">
                            <span class="w-6 h-6 rounded-full bg-secondary/10 text-secondary flex items-center justify-center mr-3">✓</span>
                            Certified Technicians
                        </div>
                        <div class="flex items-center text-primary font-medium text-sm">
                            <span class="w-6 h-6 rounded-full bg-secondary/10 text-secondary flex items-center justify-center mr-3">↺</span>
                            Service Records Maintained
                        </div>
                        <div class="flex items-center text-primary font-medium text-sm">
                            <span class="w-6 h-6 rounded-full bg-secondary/10 text-secondary flex items-center justify-center mr-3">☕</span>
                            Premium Waiting Lounge
                        </div>
                    </div>
                </div>

                <div class="bg-orange-50 rounded-3xl p-6 border border-orange-100 flex items-start">
                    <div class="text-secondary mr-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div>
                        <h4 class="font-bold text-secondary mb-1">Need Help?</h4>
                        <p class="text-sm text-slate-600">Call our service advisor at (021) 555-0123 for immediate assistance.</p>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <footer class="bg-primary py-8 text-neutral-300 border-t-4 border-secondary">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row justify-between items-center text-xs">
            <div class="mb-4 md:mb-0">
                <span class="font-bold text-white text-sm block mb-1">Wijaya Motor</span>
                <p>&copy; 2026 Wijaya Motor. Professional Automotive Excellence.</p>
            </div>
            <div class="flex space-x-6">
                <a href="#" class="hover:text-white transition-colors">Privacy Policy</a>
                <a href="#" class="hover:text-white transition-colors">Terms of Service</a>
                <a href="#" class="hover:text-white transition-colors">FAQ</a>
                <a href="#" class="hover:text-white transition-colors">Support</a>
            </div>
        </div>
    </footer>

</body>
</html>