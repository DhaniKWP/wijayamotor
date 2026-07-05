<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Invoice #ORD-{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            color: #333;
            font-size: 14px;
            line-height: 1.4;
            margin: 0;
            padding: 20px;
        }
        .header {
            width: 100%;
            border-bottom: 2px solid #ddd;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }
        .header table {
            width: 100%;
            border-collapse: collapse;
        }
        .header td {
            vertical-align: top;
        }
        .logo-text {
            font-size: 24px;
            font-weight: bold;
            color: #1e293b;
            margin: 0;
        }
        .logo-sub {
            font-size: 10px;
            color: #64748b;
            letter-spacing: 1px;
            text-transform: uppercase;
            margin-top: 2px;
        }
        .company-info {
            font-size: 12px;
            color: #64748b;
            margin-top: 5px;
        }
        .invoice-title {
            text-align: right;
            font-size: 12px;
            color: #94a3b8;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin: 0;
        }
        .invoice-number {
            text-align: right;
            font-size: 20px;
            font-weight: bold;
            color: #1e293b;
            margin-top: 5px;
            margin-bottom: 0;
        }
        .invoice-date {
            text-align: right;
            font-size: 12px;
            margin-top: 5px;
        }
        .status-badge {
            display: inline-block;
            background-color: #d1fae5;
            color: #047857;
            padding: 4px 8px;
            font-size: 10px;
            font-weight: bold;
            border-radius: 4px;
            margin-top: 10px;
            border: 1px solid #a7f3d0;
        }
        
        .info-section {
            width: 100%;
            margin-bottom: 30px;
        }
        .info-section table {
            width: 100%;
        }
        .info-title {
            font-size: 10px;
            color: #94a3b8;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 5px;
            font-weight: bold;
        }
        .info-value {
            font-size: 14px;
            font-weight: bold;
            color: #1e293b;
            margin: 0;
        }
        .info-sub {
            font-size: 12px;
            color: #64748b;
            margin-top: 2px;
            margin-bottom: 0;
        }

        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .items-table th {
            background-color: #f8fafc;
            color: #64748b;
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 1px;
            padding: 10px;
            border-top: 1px solid #e2e8f0;
            border-bottom: 1px solid #e2e8f0;
        }
        .items-table td {
            padding: 12px 10px;
            border-bottom: 1px solid #f1f5f9;
        }
        .item-name {
            font-size: 13px;
            font-weight: bold;
            color: #1e293b;
            margin: 0;
        }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .text-left { text-align: left; }

        .totals-table {
            width: 100%;
            border-collapse: collapse;
        }
        .totals-table td {
            padding: 8px 10px;
        }
        .total-label {
            font-size: 12px;
            color: #64748b;
            font-weight: bold;
            text-align: right;
            text-transform: uppercase;
        }
        .total-val {
            font-size: 13px;
            font-weight: bold;
            text-align: right;
            width: 150px;
        }
        .grand-total td {
            border-top: 2px solid #e2e8f0;
            padding-top: 15px;
            padding-bottom: 15px;
        }
        .grand-total .total-label {
            color: #1e293b;
            font-size: 14px;
        }
        .grand-total .total-val {
            font-size: 18px;
            color: #10b981;
        }

        .footer {
            margin-top: 50px;
            border-top: 1px solid #e2e8f0;
            padding-top: 20px;
            text-align: center;
            font-size: 12px;
            color: #94a3b8;
        }
    </style>
</head>
<body>

    <div class="header">
        <table>
            <tr>
                <td style="width: 50%;">
                    <p class="logo-text">WIJAYA MOTOR</p>
                    <p class="logo-sub">Bengkel & Servis Resmi</p>
                    <div class="company-info">
                        <p style="margin: 5px 0 0 0;">Jl. Raya Contoh No. 123, Kota</p>
                        <p style="margin: 2px 0 0 0;">Telp: 021-12345678</p>
                    </div>
                </td>
                <td style="width: 50%; text-align: right;">
                    <p class="invoice-title">Nota Pembelian</p>
                    <p class="invoice-number">#ORD-{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</p>
                    <p class="invoice-date">Tanggal: {{ \Carbon\Carbon::parse($order->created_at)->translatedFormat('d F Y H:i') }}</p>
                    @if($order->status === 'done')
                        <span class="status-badge">LUNAS</span>
                    @else
                        <span class="status-badge" style="background-color: #fef3c7; color: #b45309; border-color: #fde68a;">BELUM LUNAS</span>
                    @endif
                </td>
            </tr>
        </table>
    </div>

    <div class="info-section">
        <table>
            <tr>
                <td style="width: 50%;">
                    <p class="info-title">Pelanggan</p>
                    <p class="info-value">{{ $order->user->name ?? $order->user->username ?? '-' }}</p>
                    <p class="info-sub">{{ $order->user->email ?? '-' }}</p>
                    <p class="info-sub">{{ $order->user->no_telp ?? $order->user->phone ?? '-' }}</p>
                </td>
                <td style="width: 50%;">
                    <p class="info-title">Informasi Pesanan</p>
                    <p class="info-value">Pengambilan Langsung (Pickup)</p>
                    <p class="info-sub" style="margin-top: 5px;">Sparepart diambil di bengkel</p>
                </td>
            </tr>
        </table>
    </div>

    <table class="items-table">
        <thead>
            <tr>
                <th class="text-left">Nama Sparepart</th>
                <th class="text-center" style="width: 50px;">Qty</th>
                <th class="text-right" style="width: 120px;">Harga Satuan</th>
                <th class="text-right" style="width: 120px;">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->items as $item)
            <tr>
                <td>
                    <p class="item-name">{{ $item->sparepart->name ?? 'Produk dihapus' }}</p>
                </td>
                <td class="text-center" style="font-weight: bold;">{{ $item->qty }}</td>
                <td class="text-right">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                <td class="text-right" style="font-weight: bold;">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <table class="totals-table">
        <tr>
            <td></td>
            <td class="total-label">Subtotal</td>
            <td class="total-val">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td></td>
            <td class="total-label">Diskon</td>
            <td class="total-val">Rp 0</td>
        </tr>
        <tr class="grand-total">
            <td>
                @if($order->payment_method)
                <p style="font-size: 10px; color: #94a3b8; font-weight: bold; text-transform: uppercase; margin-bottom: 2px;">Metode Pembayaran</p>
                <p style="font-size: 13px; font-weight: bold; color: #1e293b; margin: 0;">{{ $order->payment_method === 'cash' ? 'Tunai (Cash)' : 'Transfer Bank' }}</p>
                @endif
            </td>
            <td class="total-label">GRAND TOTAL</td>
            <td class="total-val">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
        </tr>
    </table>

    <div class="footer">
        <p style="margin: 0;">Terima kasih telah berbelanja di <strong>Wijaya Motor</strong>.</p>
        <p style="margin: 5px 0 0 0; font-size: 10px;">Barang yang sudah dibeli tidak dapat ditukar atau dikembalikan.<br>Dokumen ini digenerate secara otomatis oleh sistem.</p>
    </div>

</body>
</html>
