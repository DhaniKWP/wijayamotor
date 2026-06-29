<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atur Ulang Kata Sandi - Wijaya Motor</title>
    <style>
        body { font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; background-color: #f3f4f6; margin: 0; padding: 30px 15px; color: #1e293b; }
        .container { max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.01); }
        .header { background-color: #ffffff; padding: 35px 20px; text-align: center; border-bottom: 1px solid #f1f5f9; }
        .header h1 { color: #0f172a; margin: 0; font-size: 28px; font-weight: 900; letter-spacing: -0.5px; }
        .header span { color: #dc2626; }
        .content { padding: 40px 35px; }
        .greeting { font-size: 20px; font-weight: 800; color: #0f172a; margin-bottom: 15px; }
        .message { font-size: 15px; line-height: 1.6; color: #475569; margin-bottom: 25px; }
        
        .status-badge { display: inline-block; background-color: #fef2f2; color: #dc2626; padding: 6px 12px; border-radius: 9999px; font-size: 12px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 20px; }

        .info-box { background-color: #f8fafc; border-left: 4px solid #94a3b8; padding: 15px 20px; border-radius: 4px 8px 8px 4px; margin-bottom: 25px; }
        .info-box p { margin: 0; font-size: 14px; line-height: 1.6; color: #475569; }

        .action-container { text-align: center; margin-top: 35px; margin-bottom: 35px; }
        .btn { display: inline-block; background-color: #dc2626; color: #ffffff; text-decoration: none; padding: 14px 35px; border-radius: 9999px; font-weight: 800; font-size: 15px; box-shadow: 0 4px 14px 0 rgba(220, 38, 38, 0.39); transition: all 0.2s ease; }
        .footer { background-color: #f8fafc; padding: 25px; text-align: center; font-size: 13px; color: #94a3b8; border-top: 1px solid #e2e8f0; }
        .footer strong { color: #64748b; }
        
        .raw-link { word-break: break-all; color: #dc2626; text-decoration: underline; font-size: 12px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>WIJAYA<span>MOTOR</span></h1>
        </div>
        
        <div class="content">
            <div class="status-badge">Permintaan Reset Password</div>
            <div class="greeting">Halo, {{ $notifiable->name ?? 'Pelanggan' }}! 👋</div>
            
            <div class="message">
                Anda menerima email ini karena kami menerima permintaan untuk mengatur ulang kata sandi (reset password) untuk akun Wijaya Motor Anda.
            </div>
            
            <div class="action-container">
                <a href="{{ $url }}" class="btn">Atur Ulang Kata Sandi</a>
            </div>
            
            <div class="info-box">
                <p>Tautan reset password ini akan kedaluwarsa dalam <strong>{{ config('auth.passwords.'.config('auth.defaults.passwords').'.expire') }} menit</strong>.</p>
                <p style="margin-top: 8px;">Jika Anda tidak pernah meminta untuk mengatur ulang kata sandi, abaikan saja email ini. Akun Anda tetap aman.</p>
            </div>
            
            <hr style="border: 0; border-top: 1px solid #e2e8f0; margin: 30px 0;">
            
            <div class="message" style="font-size: 13px;">
                Jika Anda kesulitan mengklik tombol "Atur Ulang Kata Sandi", salin dan tempel URL di bawah ini ke browser web Anda:
                <br>
                <a href="{{ $url }}" class="raw-link">{{ $url }}</a>
            </div>
        </div>
        
        <div class="footer">
            <p>&copy; {{ date('Y') }} <strong>Wijaya Motor</strong>. Hak cipta dilindungi.</p>
            <p>Jalan Raya Utama No. 123, Kota Tangerang</p>
        </div>
    </div>
</body>
</html>
