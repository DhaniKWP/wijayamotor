<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice Servis - Wijaya Motor</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f7f6; margin: 0; padding: 20px;">
    <div style="max-width: 600px; margin: 0 auto; background-color: #ffffff; padding: 30px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.05);">
        <h2 style="color: #1e293b; text-align: center; margin-bottom: 20px;">Terima Kasih, {{ $booking->user->name ?? $booking->user->username ?? 'Pelanggan Setia' }}!</h2>
        
        <p style="color: #475569; font-size: 15px; line-height: 1.6;">
            Pembayaran untuk servis kendaraan Anda dengan Plat Nomor <strong>{{ $booking->vehicle->plat_nomor ?? $booking->vehicle->plate_number ?? '-' }}</strong> telah kami terima (<strong>LUNAS</strong>).
        </p>

        <div style="background-color: #f8fafc; padding: 15px; border-left: 4px solid #10b981; margin: 20px 0;">
            <p style="margin: 0; color: #334155; font-size: 14px;"><strong>No. Invoice:</strong> #WM-{{ str_pad($booking->id, 5, '0', STR_PAD_LEFT) }}</p>
            <p style="margin: 5px 0 0 0; color: #334155; font-size: 14px;"><strong>Tanggal Servis:</strong> {{ \Carbon\Carbon::parse($booking->tanggal)->translatedFormat('d F Y') }}</p>
            <p style="margin: 5px 0 0 0; color: #334155; font-size: 14px;"><strong>Total Biaya:</strong> Rp {{ number_format($booking->transaction->total_cost, 0, ',', '.') }}</p>
        </div>

        <p style="color: #475569; font-size: 15px; line-height: 1.6;">
            Sebagai bukti pembayaran dan rincian pekerjaan yang sah, kami telah melampirkan dokumen Invoice (Struk) dalam format PDF pada email ini.
        </p>

        <p style="color: #475569; font-size: 15px; line-height: 1.6;">
            Semoga kendaraan Anda selalu dalam kondisi prima. Kami tunggu kedatangan Anda pada jadwal servis berikutnya!
        </p>

        <hr style="border: none; border-top: 1px solid #e2e8f0; margin: 30px 0;">
        
        <div style="text-align: center; color: #94a3b8; font-size: 12px;">
            <p style="margin: 0;"><strong>Wijaya Motor</strong></p>
            <p style="margin: 5px 0 0 0;">Jl. Raya Contoh No. 123, Kota | Telp: 021-12345678</p>
            <p style="margin: 5px 0 0 0;">*Email ini di-generate otomatis oleh sistem.</p>
        </div>
    </div>
</body>
</html>
