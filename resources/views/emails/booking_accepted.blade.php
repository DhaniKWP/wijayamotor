<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Servis Disetujui</title>
    <style>
        body { font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; background-color: #f3f4f6; margin: 0; padding: 30px 15px; color: #1e293b; }
        .container { max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.01); }
        .header { background-color: #ffffff; padding: 35px 20px; text-align: center; border-bottom: 1px solid #f1f5f9; }
        .header h1 { color: #0f172a; margin: 0; font-size: 28px; font-weight: 900; letter-spacing: -0.5px; }
        .header span { color: #dc2626; }
        .content { padding: 40px 35px; }
        .greeting { font-size: 20px; font-weight: 800; color: #0f172a; margin-bottom: 15px; }
        .message { font-size: 15px; line-height: 1.6; color: #475569; margin-bottom: 25px; }
        
        .status-badge { display: inline-block; background-color: #f0fdf4; color: #16a34a; padding: 6px 12px; border-radius: 9999px; font-size: 12px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 20px; }

        .details-box { background-color: #f8fafc; border: 1px solid #e2e8f0; padding: 25px; border-radius: 12px; margin-bottom: 35px; }
        .detail-row { display: flex; margin-bottom: 12px; }
        .detail-row:last-child { margin-bottom: 0; }
        .detail-label { font-weight: 600; width: 140px; color: #64748b; font-size: 14px; text-transform: uppercase; letter-spacing: 0.5px; }
        .detail-value { font-weight: 800; color: #0f172a; font-size: 15px; }
        
        .info-box { background-color: #fef2f2; border-left: 4px solid #dc2626; padding: 15px 20px; border-radius: 4px 8px 8px 4px; margin-bottom: 25px; }
        .info-box p { margin: 0; font-size: 14px; line-height: 1.6; color: #991b1b; }

        .action-container { text-align: center; margin-top: 35px; }
        .btn { display: inline-block; background-color: #dc2626; color: #ffffff; text-decoration: none; padding: 14px 35px; border-radius: 9999px; font-weight: 800; font-size: 15px; box-shadow: 0 4px 14px 0 rgba(220, 38, 38, 0.39); transition: all 0.2s ease; }
        .footer { background-color: #f8fafc; padding: 25px; text-align: center; font-size: 13px; color: #94a3b8; border-top: 1px solid #e2e8f0; }
        .footer strong { color: #64748b; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>WIJAYA<span>MOTOR</span></h1>
        </div>
        
        <div class="content">
            <div class="status-badge">Booking Disetujui</div>
            <div class="greeting">Halo, {{ $booking->user->name ?? $booking->user->username ?? 'Pelanggan' }}! 👋</div>
            
            <div class="message">
                Kabar baik! Permintaan Booking Servis Anda telah <strong>disetujui</strong> oleh Admin Wijaya Motor. Kami telah mencatat jadwal Anda dan mekanik kami siap membantu merawat kendaraan Anda.
            </div>
            
            <div class="details-box">
                <div class="detail-row">
                    <div class="detail-label">No. Booking</div>
                    <div class="detail-value">#WM-{{ str_pad($booking->id, 5, '0', STR_PAD_LEFT) }}</div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">Tanggal Servis</div>
                    <div class="detail-value">{{ \Carbon\Carbon::parse($booking->tanggal)->translatedFormat('d F Y') }}</div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">Sesi Waktu</div>
                    <div class="detail-value">{{ ucfirst($booking->sesi) }}</div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">Kendaraan</div>
                    <div class="detail-value">{{ $booking->vehicle->name ?? $booking->vehicle->merek ?? '-' }} ({{ $booking->vehicle->plate_number ?? $booking->vehicle->plat_nomor ?? '-' }})</div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">Layanan Utama</div>
                    <div class="detail-value">{{ $booking->service->name ?? '-' }}</div>
                </div>
            </div>

            <div class="info-box">
                @if($booking->tipe_booking === 'home_service')
                    <p>Karena Anda memilih <strong>Home Service</strong>, mekanik kami akan datang ke alamat yang telah Anda berikan pada sesi waktu yang ditentukan. Mohon pastikan kendaraan berada di lokasi yang mudah diakses.</p>
                @else
                    <p><strong>Catatan:</strong> Mohon datang ke bengkel tepat waktu sesuai jadwal sesi yang telah dipilih agar tidak mengantre lama.</p>
                @endif
            </div>

            <div class="action-container">
                <a href="{{ url('/dashboard') }}" class="btn">Lihat Detail di Dashboard</a>
            </div>
        </div>
        
        <div class="footer">
            <p>Terima kasih telah mempercayakan kendaraan Anda kepada <strong>Wijaya Motor</strong>.</p>
            <p>&copy; {{ date('Y') }} Wijaya Motor. Hak Cipta Dilindungi.</p>
        </div>
    </div>
</body>
</html>
