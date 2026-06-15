<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun - Wijaya Motor</title>
    
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

    <!-- Left Panel -->
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

            <h2 class="text-3xl font-extrabold text-ink mb-2">Buat Akun Baru</h2>
            <p class="text-gray-500 text-sm mb-8">Daftar untuk mulai booking servis dan belanja sparepart online.</p>

            <!-- Tab Switcher -->
            <div class="bg-gray-100 p-1 rounded-xl flex items-center mb-8">
                <a href="{{ route('login') }}" class="w-1/2 text-center py-2.5 rounded-lg text-gray-500 hover:text-ink font-semibold text-sm transition">Masuk</a>
                <a href="{{ route('register') }}" class="w-1/2 text-center py-2.5 rounded-lg bg-white shadow-sm text-brand font-bold text-sm transition">Daftar</a>
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

            <form method="POST" action="{{ route('register') }}">
                @csrf
                <div class="mb-4">
                    <label for="name" class="block text-sm font-bold text-ink mb-2">Nama Lengkap</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/></svg>
                        </div>
                        <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus
                            class="pl-11 w-full rounded-xl border border-gray-200 px-4 py-3 text-sm bg-gray-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand/30 focus:border-brand placeholder-gray-400 transition" 
                            placeholder="Masukkan nama lengkap">
                    </div>
                </div>

                <div class="mb-4">
                    <label for="email" class="block text-sm font-bold text-ink mb-2">Email</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/></svg>
                        </div>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required
                            class="pl-11 w-full rounded-xl border border-gray-200 px-4 py-3 text-sm bg-gray-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand/30 focus:border-brand placeholder-gray-400 transition" 
                            placeholder="nama@email.com">
                    </div>
                </div>

                <div class="mb-4">
                    <label for="phone" class="block text-sm font-bold text-ink mb-2">No. Telepon</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 1.5H8.25A2.25 2.25 0 006 3.75v16.5a2.25 2.25 0 002.25 2.25h7.5A2.25 2.25 0 0018 20.25V3.75a2.25 2.25 0 00-2.25-2.25H13.5m-3 0V3h3V1.5m-3 0h3m-3 18.75h3"/></svg>
                        </div>
                        <input id="phone" type="text" name="phone" value="{{ old('phone') }}" required
                            class="pl-11 w-full rounded-xl border border-gray-200 px-4 py-3 text-sm bg-gray-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand/30 focus:border-brand placeholder-gray-400 transition" 
                            placeholder="081234567890">
                    </div>
                </div>

                <div class="mb-4">
                    <label for="address" class="block text-sm font-bold text-ink mb-2">Alamat</label>
                    <textarea id="address" name="address" rows="2"
                        class="w-full rounded-xl border border-gray-200 px-4 py-3 text-sm bg-gray-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand/30 focus:border-brand placeholder-gray-400 transition" 
                        placeholder="Jl. Sudirman No. 123, Tangerang">{{ old('address') }}</textarea>
                </div>

                <div class="grid grid-cols-2 gap-4 mb-6">
                    <div>
                        <label for="password" class="block text-sm font-bold text-ink mb-2">Kata Sandi</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"/></svg>
                            </div>
                            <input id="password" type="password" name="password" required
                                class="pl-11 w-full rounded-xl border border-gray-200 px-4 py-3 text-sm bg-gray-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand/30 focus:border-brand transition" 
                                placeholder="Min. 8 karakter">
                        </div>
                    </div>
                    <div>
                        <label for="password_confirmation" class="block text-sm font-bold text-ink mb-2">Konfirmasi</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z"/></svg>
                            </div>
                            <input id="password_confirmation" type="password" name="password_confirmation" required
                                class="pl-11 w-full rounded-xl border border-gray-200 px-4 py-3 text-sm bg-gray-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand/30 focus:border-brand transition" 
                                placeholder="Ulangi sandi">
                        </div>
                    </div>
                </div>

                <button type="submit" class="w-full bg-brand hover:bg-brand-dark text-white font-bold py-3.5 px-4 rounded-xl transition shadow-lg shadow-brand/20 text-sm">
                    Daftar Sekarang
                </button>
            </form>

            <p class="text-center text-sm text-gray-500 mt-8">
                Sudah punya akun? <a href="{{ route('login') }}" class="font-bold text-brand hover:underline transition">Masuk di sini</a>
            </p>

            <div class="flex justify-center space-x-6 mt-12 text-xs text-gray-400 font-medium pb-4">
                <a href="#" class="hover:text-ink transition">Kebijakan Privasi</a>
                <a href="#" class="hover:text-ink transition">Syarat & Ketentuan</a>
            </div>
        </div>
    </div>
</body>
</html>