<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Invoice #WM-{{ str_pad($booking->id, 5, '0', STR_PAD_LEFT) }}</title>
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
        .item-type {
            font-size: 10px;
            color: #64748b;
            margin-top: 2px;
            margin-bottom: 0;
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
                    <p class="invoice-title">Invoice</p>
                    <p class="invoice-number">#WM-{{ str_pad($booking->id, 5, '0', STR_PAD_LEFT) }}</p>
                    <p class="invoice-date">Tanggal: {{ \Carbon\Carbon::parse($booking->tanggal)->translatedFormat('d F Y') }}</p>
                    @if($booking->transaction->payment_status === 'paid')
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
                    <p class="info-value">{{ $booking->user->name ?? $booking->user->username ?? '-' }}</p>
                    <p class="info-sub">{{ $booking->user->email ?? '-' }}</p>
                    <p class="info-sub">{{ $booking->user->no_telp ?? $booking->user->phone ?? '-' }}</p>
                </td>
                <td style="width: 50%;">
                    <p class="info-title">Kendaraan</p>
                    <p class="info-value">{{ $booking->vehicle->merek ?? $booking->vehicle->name ?? '-' }}</p>
                    <p class="info-sub" style="font-family: monospace; font-weight: bold; background: #f1f5f9; display: inline-block; padding: 2px 6px; margin-top: 5px;">{{ $booking->vehicle->plat_nomor ?? $booking->vehicle->plate_number ?? '-' }}</p>
                    @if($booking->kilometer)
                        <p class="info-sub">{{ number_format($booking->kilometer, 0, ',', '.') }} KM saat servis</p>
                    @endif
                </td>
            </tr>
        </table>
    </div>

    <table class="items-table">
        <thead>
            <tr>
                <th class="text-left">Deskripsi</th>
                <th class="text-center" style="width: 50px;">Qty</th>
                <th class="text-right" style="width: 120px;">Harga Satuan</th>
                <th class="text-right" style="width: 120px;">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <p class="item-name">{{ $booking->service->name ?? 'Layanan Utama' }}</p>
                    <p class="item-type">● Jasa Dasar</p>
                </td>
                <td class="text-center" style="font-weight: bold;">1</td>
                <td class="text-right">Rp {{ number_format($booking->service->price_estimate ?? 0, 0, ',', '.') }}</td>
                <td class="text-right" style="font-weight: bold;">Rp {{ number_format($booking->service->price_estimate ?? 0, 0, ',', '.') }}</td>
            </tr>
            @foreach($booking->transaction->items as $item)
            <tr>
                <td>
                    <p class="item-name">{{ $item->display_name }}</p>
                    <p class="item-type">● {{ $item->item_type === 'sparepart' ? 'Sparepart' : 'Jasa Tambahan' }}</p>
                    @if($item->note)
                        <p style="font-size: 9px; color: #94a3b8; font-style: italic; margin: 2px 0 0 0;">{{ $item->note }}</p>
                    @endif
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
            <td class="total-label">Total Jasa</td>
            <td class="total-val">Rp {{ number_format($booking->transaction->service_cost, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td></td>
            <td class="total-label">Total Sparepart</td>
            <td class="total-val">Rp {{ number_format($booking->transaction->sparepart_cost, 0, ',', '.') }}</td>
        </tr>
        <tr class="grand-total">
            <td>
                <p style="font-size: 10px; color: #94a3b8; font-weight: bold; text-transform: uppercase; margin-bottom: 2px;">Metode Pembayaran</p>
                <p style="font-size: 13px; font-weight: bold; color: #1e293b; margin: 0;">{{ $booking->transaction->payment_method === 'cash' ? 'Tunai (Cash)' : 'Transfer Bank' }}</p>
            </td>
            <td class="total-label">GRAND TOTAL</td>
            <td class="total-val">Rp {{ number_format($booking->transaction->total_cost, 0, ',', '.') }}</td>
        </tr>
    </table>

    <div class="footer">
        <p style="margin: 0;">Terima kasih telah mempercayakan kendaraan Anda kepada <strong>Wijaya Motor</strong>.</p>
        <p style="margin: 5px 0 0 0; font-size: 10px;">Dokumen ini digenerate secara otomatis oleh sistem.</p>
    </div>

</body>
</html>
