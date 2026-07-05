<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice Pembelian Sparepart - Wijaya Motor</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f7f6; margin: 0; padding: 20px;">
    <div style="max-width: 600px; margin: 0 auto; background-color: #ffffff; padding: 30px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.05);">
        <h2 style="color: #1e293b; text-align: center; margin-bottom: 20px;">Terima Kasih, {{ $order->user->name ?? $order->user->username ?? 'Pelanggan Setia' }}!</h2>
        
        <p style="color: #475569; font-size: 15px; line-height: 1.6;">
            Pembayaran untuk pesanan sparepart Anda telah kami terima dan berstatus <strong>LUNAS</strong>.
        </p>

        <div style="background-color: #f8fafc; padding: 15px; border-left: 4px solid #10b981; margin: 20px 0;">
            <p style="margin: 0; color: #334155; font-size: 14px;"><strong>No. Invoice:</strong> #ORD-{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</p>
            <p style="margin: 5px 0 0 0; color: #334155; font-size: 14px;"><strong>Tanggal Order:</strong> {{ \Carbon\Carbon::parse($order->created_at)->translatedFormat('d F Y') }}</p>
            <p style="margin: 5px 0 0 0; color: #334155; font-size: 14px;"><strong>Total Biaya:</strong> Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
            <p style="margin: 5px 0 0 0; color: #334155; font-size: 14px;"><strong>Metode Pembayaran:</strong> {{ $order->payment_method === 'cash' ? 'Tunai (Cash)' : 'Transfer Bank' }}</p>
        </div>

        <p style="color: #475569; font-size: 15px; line-height: 1.6;">
            Sebagai bukti pembayaran yang sah, kami telah melampirkan Nota Pembelian (Struk) dalam format PDF pada email ini.
        </p>

        <p style="color: #475569; font-size: 15px; line-height: 1.6;">
            Kami tunggu kedatangan Anda untuk berbelanja sparepart kembali di bengkel kami!
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
