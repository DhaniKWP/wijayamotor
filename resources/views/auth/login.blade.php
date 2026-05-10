<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Wijaya Motor</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
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
        
        /* Custom Animation */
        @keyframes fadeSlideUp {
            0% { opacity: 0; transform: translateY(20px); }
            100% { opacity: 1; transform: translateY(0); }
        }
        .animate-form {
            animation: fadeSlideUp 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }
    </style>
</head>
<body class="bg-white flex min-h-screen font-sans antialiased">

    <div class="hidden lg:flex lg:w-1/2 lg:fixed lg:inset-y-0 lg:left-0 bg-primary items-end p-16 overflow-hidden">
        <img src="https://images.unsplash.com/photo-1580273916550-e323be2ae537?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80" 
             alt="Sport Car" class="absolute inset-0 w-full h-full object-cover opacity-60 mix-blend-overlay">
        <div class="absolute inset-0 bg-gradient-to-t from-[#0A192F] via-[#0A192F]/80 to-transparent"></div>
        
        <div class="relative z-10 w-full max-w-lg">
            <h2 class="text-white font-black text-2xl tracking-tighter mb-6">WIJAYA MOTOR</h2>
            <h1 class="text-white font-bold text-5xl leading-tight mb-6">Precision engineering for your peace of mind.</h1>
            <p class="text-slate-300 text-lg mb-12">Access Indonesia's premier automotive service network. Track your maintenance, book specialists, and manage your vehicle's health with clinical precision.</p>
            
            <div class="flex items-center space-x-12 border-t border-white/20 pt-8">
                <div>
                    <h3 class="text-secondary font-bold text-3xl">15k+</h3>
                    <p class="text-white/60 text-xs tracking-widest uppercase font-semibold mt-1">Vehicles Serviced</p>
                </div>
                <div>
                    <h3 class="text-secondary font-bold text-3xl">4.9/5</h3>
                    <p class="text-white/60 text-xs tracking-widest uppercase font-semibold mt-1">Customer Rating</p>
                </div>
            </div>
            <p class="text-white/40 text-xs mt-16">&copy; 2024 Wijaya Motor. Professional Automotive Excellence.</p>
        </div>
    </div>

    <div class="w-full lg:w-1/2 lg:ml-[50%] min-h-screen flex flex-col justify-center px-8 sm:px-16 lg:px-24 py-12">
        <div class="w-full max-w-md mx-auto animate-form opacity-0">
            
            <h2 class="text-3xl font-bold text-primary mb-2">Welcome back</h2>
            <p class="text-neutral text-sm mb-8">Please enter your details to access your account.</p>

            <div class="bg-slate-100 p-1 rounded-xl flex items-center mb-8">
                <a href="{{ route('login') }}" class="w-1/2 text-center py-2.5 rounded-lg bg-white shadow-sm text-secondary font-bold text-sm transition">Login</a>
                <a href="{{ route('register') }}" class="w-1/2 text-center py-2.5 rounded-lg text-neutral hover:text-primary font-medium text-sm transition">Create Account</a>
            </div>

            @if ($errors->any())
                <div class="mb-6 p-4 rounded-lg bg-red-50 text-red-600 text-sm border border-red-100">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="mb-5">
                    <label for="email" class="block text-sm font-semibold text-primary mb-2">Email Address</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        </div>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                            class="pl-10 w-full rounded-lg border border-slate-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-secondary focus:border-transparent placeholder-slate-400 transition" 
                            placeholder="name@wijayamotor.com">
                    </div>
                </div>

                <div class="mb-6">
                    <div class="flex justify-between items-center mb-2">
                        <label for="password" class="block text-sm font-semibold text-primary">Password</label>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-xs font-semibold text-secondary hover:underline transition">Forgot password?</a>
                        @endif
                    </div>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                        </div>
                        <input id="password" type="password" name="password" required
                            class="pl-10 w-full rounded-lg border border-slate-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-secondary focus:border-transparent transition" 
                            placeholder="••••••••">
                    </div>
                </div>

                <div class="flex items-center mb-8">
                    <input id="remember_me" type="checkbox" name="remember" class="w-4 h-4 text-secondary bg-slate-100 border-slate-300 rounded focus:ring-secondary focus:ring-2 transition">
                    <label for="remember_me" class="ml-2 text-sm text-neutral font-medium cursor-pointer">Remember me for 30 days</label>
                </div>

                <button type="submit" class="w-full bg-secondary hover:bg-[#e67e00] text-white font-bold py-3.5 px-4 rounded-lg transition shadow-lg shadow-secondary/20">
                    Sign In
                </button>
            </form>

            <p class="text-center text-sm text-neutral mt-8">
                Don't have an account? <a href="{{ route('register') }}" class="font-bold text-secondary hover:underline transition">Create an Account</a>
            </p>

            <div class="flex justify-center space-x-6 mt-16 text-xs text-neutral font-medium">
                <a href="#" class="hover:text-primary transition">Privacy Policy</a>
                <a href="#" class="hover:text-primary transition">Terms of Service</a>
                <a href="#" class="hover:text-primary transition">Support</a>
            </div>
        </div>
    </div>
</body>
</html>