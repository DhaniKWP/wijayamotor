<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesanan Sparepart Siap Diambil</title>
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

        .details-box { background-color: #f8fafc; border: 1px solid #e2e8f0; padding: 25px; border-radius: 12px; margin-bottom: 35px; }
        .detail-row { display: flex; margin-bottom: 12px; }
        .detail-row:last-child { margin-bottom: 0; }
        .detail-label { font-weight: 600; width: 140px; color: #64748b; font-size: 14px; text-transform: uppercase; letter-spacing: 0.5px; }
        .detail-value { font-weight: 800; color: #0f172a; font-size: 15px; }
        
        .items-table { width: 100%; border-collapse: collapse; margin-bottom: 35px; }
        .items-table th { background-color: #ffffff; text-align: left; padding: 12px 0; font-size: 12px; color: #94a3b8; border-bottom: 2px solid #e2e8f0; text-transform: uppercase; font-weight: 800; letter-spacing: 0.5px; }
        .items-table td { padding: 16px 0; border-bottom: 1px dashed #e2e8f0; font-size: 14px; }
        .items-table .item-name { font-weight: 700; color: #0f172a; }
        .items-table .item-qty { color: #64748b; font-weight: 600; }
        .items-table .text-right { text-align: right; }
        .items-table .total-row td { font-weight: 900; font-size: 18px; border-top: 2px solid #cbd5e1; border-bottom: none; padding-top: 20px; }
        
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
            <div class="status-badge">Siap Diambil</div>
            <div class="greeting">Halo, {{ $order->user->name ?? $order->user->username ?? 'Pelanggan' }}! 👋</div>
            
            <div class="message">
                Pesanan sparepart Anda <strong>telah disiapkan</strong> oleh tim kami dan saat ini sudah menunggu untuk diambil (di-pickup) langsung di bengkel Wijaya Motor.
            </div>
            
            <div class="details-box">
                <div class="detail-row">
                    <div class="detail-label">No. Order</div>
                    <div class="detail-value">#ORD-{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">Tanggal Pesan</div>
                    <div class="detail-value">{{ $order->created_at->translatedFormat('d F Y, H:i') }}</div>
                </div>
            </div>

            <table class="items-table">
                <thead>
                    <tr>
                        <th>Item Sparepart</th>
                        <th class="text-right">Qty</th>
                        <th class="text-right">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->items as $item)
                    <tr>
                        <td class="item-name">{{ $item->sparepart->name ?? 'Item Dihapus' }}</td>
                        <td class="text-right item-qty">{{ $item->qty }}x</td>
                        <td class="text-right font-bold text-slate-800">Rp{{ number_format($item->subtotal, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                    <tr class="total-row">
                        <td colspan="2" class="text-right" style="color: #64748b;">Total Tagihan</td>
                        <td class="text-right" style="color: #dc2626;">Rp{{ number_format($order->total_price, 0, ',', '.') }}</td>
                    </tr>
                </tbody>
            </table>

            <div class="message">
                Silakan datang ke bengkel kami dan tunjukkan nomor pesanan ini kepada kasir untuk melakukan pembayaran dan pengambilan barang.
            </div>

            <div class="action-container">
                <a href="{{ url('/pesanan') }}" class="btn">Lihat Riwayat Pesanan</a>
            </div>
        </div>
        
        <div class="footer">
            <p>Terima kasih telah berbelanja sparepart di <strong>Wijaya Motor</strong>.</p>
            <p>&copy; {{ date('Y') }} Wijaya Motor. Hak Cipta Dilindungi.</p>
        </div>
    </div>
</body>
</html>
