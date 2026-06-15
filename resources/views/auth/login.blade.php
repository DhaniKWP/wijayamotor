<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - Wijaya Motor</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Plus Jakarta Sans', 'sans-serif'] },
                    colors: {
                        brand: { DEFAULT: '#FF8C00', dark: '#e67e00' },
                        ink: { DEFAULT: '#0A192F', light: '#112a4f' },
                        danger: '#E11D48',
                    }
                }
            }
        }
    </script>
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        @keyframes fadeSlideUp {
            0% { opacity: 0; transform: translateY(20px); }
            100% { opacity: 1; transform: translateY(0); }
        }
        .animate-form { animation: fadeSlideUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
    </style>
</head>
<body class="bg-white flex min-h-screen antialiased">

    <!-- Left Panel (Hero) -->
    <div class="hidden lg:flex lg:w-1/2 lg:fixed lg:inset-y-0 lg:left-0 bg-ink items-end p-16 overflow-hidden">
        <img src="https://images.unsplash.com/photo-1580273916550-e323be2ae537?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80" 
             alt="Sport Car" class="absolute inset-0 w-full h-full object-cover opacity-40">
        <div class="absolute inset-0 bg-gradient-to-t from-ink via-ink/85 to-ink/30"></div>
        
        <div class="relative z-10 w-full max-w-lg">
            <a href="/" class="inline-flex items-center gap-2 mb-8">
                <span class="text-white font-extrabold text-2xl tracking-tight">WIJAYA</span>
                <span class="text-brand font-extrabold text-2xl tracking-tight">MOTOR</span>
            </a>
            <h1 class="text-white font-extrabold text-4xl leading-tight mb-5">Perawatan kendaraan Anda, prioritas kami.</h1>
            <p class="text-slate-300 text-base leading-relaxed mb-12">Bergabung dengan ribuan pelanggan yang sudah mempercayakan perawatan kendaraan mereka kepada Wijaya Motor. Booking servis mudah, cepat, dan transparan.</p>
            
            <div class="flex items-center space-x-10 border-t border-white/15 pt-8">
                <div>
                    <h3 class="text-brand font-extrabold text-3xl">15k+</h3>
                    <p class="text-white/50 text-xs tracking-widest uppercase font-bold mt-1">Kendaraan Ditangani</p>
                </div>
                <div>
                    <h3 class="text-brand font-extrabold text-3xl">4.9/5</h3>
                    <p class="text-white/50 text-xs tracking-widest uppercase font-bold mt-1">Rating Pelanggan</p>
                </div>
            </div>
            <p class="text-white/30 text-xs mt-16">&copy; 2026 Wijaya Motor. Hak cipta dilindungi.</p>
        </div>
    </div>

    <!-- Right Panel (Form) -->
    <div class="w-full lg:w-1/2 lg:ml-[50%] min-h-screen flex flex-col justify-center px-8 sm:px-16 lg:px-24 py-12">
        <div class="w-full max-w-md mx-auto animate-form opacity-0">
            
            <!-- Mobile Logo -->
            <div class="lg:hidden flex items-center gap-2 mb-8">
                <span class="text-ink font-extrabold text-xl tracking-tight">WIJAYA</span>
                <span class="text-brand font-extrabold text-xl tracking-tight">MOTOR</span>
            </div>

            <h2 class="text-3xl font-extrabold text-ink mb-2">Selamat Datang!</h2>
            <p class="text-gray-500 text-sm mb-8">Masuk ke akun Anda untuk mengakses layanan bengkel.</p>

            <!-- Tab Switcher -->
            <div class="bg-gray-100 p-1 rounded-xl flex items-center mb-8">
                <a href="{{ route('login') }}" class="w-1/2 text-center py-2.5 rounded-lg bg-white shadow-sm text-brand font-bold text-sm transition">Masuk</a>
                <a href="{{ route('register') }}" class="w-1/2 text-center py-2.5 rounded-lg text-gray-500 hover:text-ink font-semibold text-sm transition">Daftar</a>
            </div>

            @if ($errors->any())
                <div class="mb-6 p-4 rounded-xl bg-red-50 text-red-600 text-sm border border-red-100">
                    <ul class="list-disc list-inside space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="mb-5">
                    <label for="email" class="block text-sm font-bold text-ink mb-2">Email</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/></svg>
                        </div>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                            class="pl-11 w-full rounded-xl border border-gray-200 px-4 py-3 text-sm bg-gray-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand/30 focus:border-brand placeholder-gray-400 transition" 
                            placeholder="nama@email.com">
                    </div>
                </div>

                <div class="mb-6">
                    <div class="flex justify-between items-center mb-2">
                        <label for="password" class="block text-sm font-bold text-ink">Kata Sandi</label>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-xs font-semibold text-brand hover:underline transition">Lupa kata sandi?</a>
                        @endif
                    </div>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"/></svg>
                        </div>
                        <input id="password" type="password" name="password" required
                            class="pl-11 w-full rounded-xl border border-gray-200 px-4 py-3 text-sm bg-gray-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand/30 focus:border-brand transition" 
                            placeholder="Masukkan kata sandi">
                    </div>
                </div>

                <div class="flex items-center mb-8">
                    <input id="remember_me" type="checkbox" name="remember" class="w-4 h-4 text-brand bg-gray-100 border-gray-300 rounded focus:ring-brand focus:ring-2 transition">
                    <label for="remember_me" class="ml-2.5 text-sm text-gray-500 font-medium cursor-pointer">Ingat saya selama 30 hari</label>
                </div>

                <button type="submit" class="w-full bg-brand hover:bg-brand-dark text-white font-bold py-3.5 px-4 rounded-xl transition shadow-lg shadow-brand/20 text-sm">
                    Masuk ke Akun
                </button>
            </form>

            <!-- Promo Banner -->
            <div class="mt-8 p-4 rounded-xl bg-gradient-to-r from-red-50 to-orange-50 border border-red-100/50">
                <div class="flex items-start gap-3">
                    <div class="w-8 h-8 rounded-lg bg-red-100 flex items-center justify-center shrink-0">
                        <svg class="w-4 h-4 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09zM18.259 8.715L18 9.75l-.259-1.035a3.375 3.375 0 00-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 002.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 002.455 2.456L21.75 6l-1.036.259a3.375 3.375 0 00-2.455 2.456z"/></svg>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-red-700">Diskon 20% untuk Booking via Website!</p>
                        <p class="text-[11px] text-red-600/70 mt-0.5">Daftar akun & buat jadwal servis langsung dari HP Anda.</p>
                    </div>
                </div>
            </div>

            <p class="text-center text-sm text-gray-500 mt-6">
                Belum punya akun? <a href="{{ route('register') }}" class="font-bold text-brand hover:underline transition">Daftar Sekarang</a>
            </p>

            <div class="flex justify-center space-x-6 mt-12 text-xs text-gray-400 font-medium">
                <a href="#" class="hover:text-ink transition">Kebijakan Privasi</a>
                <a href="#" class="hover:text-ink transition">Syarat & Ketentuan</a>
            </div>
        </div>
    </div>
</body>
</html>