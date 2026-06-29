<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lengkapi Data Diri - Wijaya Motor</title>
    @vite('resources/css/app.css')
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 flex items-center justify-center min-h-screen p-4">
    <div class="w-full max-w-md bg-white rounded-2xl shadow-xl overflow-hidden">
        <div class="p-8">
            <div class="flex items-center gap-2 mb-8 justify-center">
                <span class="text-ink font-extrabold text-xl tracking-tight">WIJAYA</span>
                <span class="text-brand font-extrabold text-xl tracking-tight">MOTOR</span>
            </div>

            <h2 class="text-2xl font-extrabold text-ink mb-2 text-center">Lengkapi Data Diri</h2>
            <p class="text-gray-500 text-sm mb-8 text-center">Tinggal selangkah lagi untuk menyelesaikan pendaftaran Anda.</p>

            @if ($errors->any())
                <div class="mb-6 p-4 rounded-xl bg-red-50 text-red-600 text-sm border border-red-100">
                    <ul class="list-disc list-inside space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('profile.complete.update') }}">
                @csrf
                <div class="mb-5">
                    <label for="phone" class="block text-sm font-bold text-ink mb-2">Nomor WhatsApp / HP</label>
                    <input id="phone" type="text" name="phone" value="{{ old('phone') }}" required autofocus
                        class="w-full rounded-xl border border-gray-200 px-4 py-3 text-sm bg-gray-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand/30 focus:border-brand transition" 
                        placeholder="081234567890">
                </div>

                <div class="mb-8">
                    <label for="address" class="block text-sm font-bold text-ink mb-2">Alamat Lengkap</label>
                    <textarea id="address" name="address" required rows="3"
                        class="w-full rounded-xl border border-gray-200 px-4 py-3 text-sm bg-gray-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand/30 focus:border-brand transition" 
                        placeholder="Jl. Raya Contoh No. 123, Kelurahan, Kecamatan">{{ old('address') }}</textarea>
                </div>

                <button type="submit" class="w-full bg-brand hover:bg-brand-dark text-white font-bold py-3.5 px-4 rounded-xl transition shadow-lg shadow-brand/20 text-sm">
                    Simpan dan Lanjutkan
                </button>
            </form>
        </div>
    </div>
</body>
</html>
