<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Password Baru - Wijaya Motor</title>
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
            <h2 class="text-2xl font-bold text-primary mb-6">Buat Password Baru</h2>

            <form method="POST" action="{{ route('password.store') }}">
                @csrf

                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <div class="mb-5">
                    <label for="email" class="block text-sm font-semibold text-primary mb-2">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email', $request->email) }}" required readonly class="w-full rounded-xl border border-slate-200 bg-slate-50 text-slate-500 px-4 py-3 text-sm outline-none cursor-not-allowed">
                    <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-500 text-sm" />
                </div>

                <div class="mb-5">
                    <label for="password" class="block text-sm font-semibold text-primary mb-2">Password Baru</label>
                    <input id="password" type="password" name="password" required autofocus autocomplete="new-password" placeholder="Minimal 8 karakter" class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:ring-2 focus:ring-secondary focus:border-transparent outline-none transition-all">
                    <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-500 text-sm" />
                </div>

                <div class="mb-8">
                    <label for="password_confirmation" class="block text-sm font-semibold text-primary mb-2">Konfirmasi Password Baru</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="Ketik ulang password baru" class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:ring-2 focus:ring-secondary focus:border-transparent outline-none transition-all">
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-red-500 text-sm" />
                </div>

                <button type="submit" class="w-full bg-secondary hover:bg-[#e67e00] text-white font-bold py-3.5 px-4 rounded-xl transition-all shadow-lg shadow-secondary/30 hover:-translate-y-0.5">
                    Simpan Password Baru
                </button>
            </form>
        </div>
    </div>

</body>
</html>