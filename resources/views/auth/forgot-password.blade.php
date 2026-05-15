<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password - Wijaya Motor</title>
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
<body class="bg-slate-50 flex items-center justify-center min-h-screen p-4 selection:bg-secondary selection:text-white">

    <div class="w-full max-w-md">
        <div class="text-center mb-8">
            <a href="{{ url('/') }}" class="inline-block cursor-pointer group">
                <span class="font-black text-3xl tracking-tighter text-primary group-hover:text-secondary transition-colors">WIJAYA <span class="text-neutral group-hover:text-neutral">MOTOR</span></span>
            </a>
        </div>

        <div class="bg-white rounded-3xl shadow-xl p-8 border border-slate-100">
            <h2 class="text-2xl font-bold text-primary mb-2">Lupa Password?</h2>
            <p class="text-neutral text-sm mb-6 leading-relaxed">
                Nggak masalah! Masukkan alamat email yang terdaftar, dan kami akan mengirimkan tautan untuk membuat password baru.
            </p>

            <x-auth-session-status class="mb-4 text-green-600 font-medium text-sm" :status="session('status')" />

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <div class="mb-6">
                    <label for="email" class="block text-sm font-semibold text-primary mb-2">Email Terdaftar</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus placeholder="contoh@email.com" class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:ring-2 focus:ring-secondary focus:border-transparent outline-none transition-all">
                    <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-500 text-sm" />
                </div>

                <button type="submit" class="w-full bg-primary hover:bg-[#112a4f] text-white font-bold py-3.5 px-4 rounded-xl transition-all shadow-lg shadow-primary/20 hover:-translate-y-0.5">
                    Kirim Tautan Reset
                </button>
            </form>

            <div class="mt-6 text-center">
                <a href="{{ route('login') }}" class="text-sm font-semibold text-secondary hover:text-[#e67e00] transition">
                    &larr; Kembali ke halaman Login
                </a>
            </div>
        </div>
    </div>

</body>
</html>