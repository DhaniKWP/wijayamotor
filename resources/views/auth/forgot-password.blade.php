<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password - Wijaya Motor</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Plus Jakarta Sans', 'sans-serif'] },
                    colors: {
                        brand: { DEFAULT: '#dc2626', dark: '#b91c1c' },
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
            <a href="/" class="inline-flex items-center gap-2 mb-8 hover:opacity-80 transition">
                <span class="text-white font-extrabold text-2xl tracking-tight">WIJAYA</span>
                <span class="text-brand font-extrabold text-2xl tracking-tight">MOTOR</span>
            </a>
            <h1 class="text-white font-extrabold text-4xl leading-tight mb-5">Tenang, kami siap membantu Anda.</h1>
            <p class="text-slate-300 text-base leading-relaxed mb-12">Jangan khawatir jika Anda lupa kata sandi. Masukkan email terdaftar Anda, dan kami akan memandu Anda untuk mengatur ulang kata sandi dengan aman.</p>
            
            <p class="text-white/30 text-xs mt-16">&copy; {{ date('Y') }} Wijaya Motor. Hak cipta dilindungi.</p>
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

            <a href="{{ route('login') }}" class="inline-flex items-center text-sm font-bold text-gray-400 hover:text-ink mb-6 transition">
                <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali ke Login
            </a>

            <h2 class="text-3xl font-extrabold text-ink mb-3">Lupa Kata Sandi?</h2>
            <p class="text-gray-500 text-sm mb-8 leading-relaxed">
                Nggak masalah! Masukkan alamat email yang terdaftar, dan kami akan mengirimkan tautan untuk membuat kata sandi baru Anda.
            </p>

            @if(session('status'))
                <div class="mb-6 p-4 rounded-xl bg-emerald-50 text-emerald-700 text-sm font-semibold border border-emerald-100 flex items-start gap-3">
                    <svg class="w-5 h-5 text-emerald-500 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}">
                @csrf
                <div class="mb-6">
                    <label for="email" class="block text-sm font-bold text-ink mb-2">Email Terdaftar</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/></svg>
                        </div>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                            class="pl-11 w-full rounded-xl border {{ $errors->has('email') ? 'border-danger focus:ring-danger/30' : 'border-gray-200 focus:border-brand focus:ring-brand/30' }} px-4 py-3.5 text-sm bg-gray-50 focus:bg-white focus:outline-none focus:ring-2 placeholder-gray-400 transition" 
                            placeholder="nama@email.com">
                    </div>
                    @if($errors->has('email'))
                        <p class="mt-2 text-sm font-semibold text-danger">{{ $errors->first('email') }}</p>
                    @endif
                </div>

                <button type="submit" class="w-full bg-brand hover:bg-brand-dark text-white font-bold py-3.5 px-4 rounded-xl transition shadow-lg shadow-brand/20 text-sm flex items-center justify-center gap-2">
                    Kirim Tautan Reset
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                </button>
            </form>

            <div class="flex justify-center space-x-6 mt-16 text-xs text-gray-400 font-medium pb-4">
                <a href="#" class="hover:text-ink transition">Bantuan</a>
                <a href="#" class="hover:text-ink transition">Kebijakan Privasi</a>
            </div>
        </div>
    </div>
</body>
</html>