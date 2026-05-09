<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi OTP - Wijaya Motor</title>
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
</head>
<body class="bg-slate-50 flex items-center justify-center min-h-screen">

    <div class="bg-white p-8 rounded-2xl shadow-lg w-full max-w-md border border-slate-100 text-center">
        <!-- Logo / Icon -->
        <div class="w-16 h-16 bg-secondary/10 text-secondary mx-auto rounded-full flex items-center justify-center mb-6">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
        </div>

        <h2 class="text-2xl font-bold text-primary mb-2">Cek Email Anda</h2>
        <p class="text-neutral text-sm mb-8">Kami telah mengirimkan 6 digit kode OTP ke email <span class="font-semibold text-primary">{{ session('otp_verify_email') }}</span>.</p>

        <!-- Pesan Error jika OTP salah/expired -->
        @if($errors->any())
            <div class="bg-red-50 text-red-600 text-sm p-3 rounded-lg mb-6">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('otp.verify.post') }}">
            @csrf
            
            <div class="mb-6">
                <label for="otp" class="block text-sm font-medium text-primary mb-2 text-left">Kode OTP</label>
                <input type="text" id="otp" name="otp" 
                       class="w-full text-center tracking-widest text-2xl font-bold p-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-secondary focus:border-secondary outline-none transition" 
                       maxlength="6" placeholder="------" required autofocus autocomplete="off">
            </div>

            <button type="submit" class="w-full bg-primary hover:bg-primary/90 text-white font-medium py-3 rounded-lg transition shadow-md">
                Verifikasi & Login
            </button>
        </form>

        <div class="mt-6 text-sm text-neutral">
            Belum menerima email? <a href="#" class="text-secondary hover:underline font-medium">Kirim ulang kode</a>
            <br>
            <span class="text-xs text-slate-400 block mt-1">(Cek juga folder Spam/Junk)</span>
        </div>
    </div>

</body>
</html>