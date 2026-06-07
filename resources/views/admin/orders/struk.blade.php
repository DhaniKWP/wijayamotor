<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk #ORD-{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }} — Wijaya Motor</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Courier New', Courier, monospace;
            font-size: 12px;
            background: #f5f5f5;
            display: flex;
            justify-content: center;
            padding: 40px 16px;
        }

        .struk {
            background: white;
            width: 320px;
            padding: 24px 20px;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.08);
        }

        /* ---- Header ---- */
        .header { text-align: center; padding-bottom: 14px; border-bottom: 1px dashed #ccc; }
        .header .logo { font-size: 18px; font-weight: 900; letter-spacing: 2px; color: #111; }
        .header .logo span { color: #E11D48; }
        .header .sub { font-size: 10px; color: #666; margin-top: 2px; }
        .header .address { font-size: 10px; color: #888; margin-top: 6px; line-height: 1.4; }

        /* ---- Order Info ---- */
        .info-section { padding: 12px 0; border-bottom: 1px dashed #ccc; }
        .info-row { display: flex; justify-content: space-between; margin-bottom: 4px; }
        .info-row .label { color: #666; font-size: 11px; }
        .info-row .val   { font-weight: 700; font-size: 11px; text-align: right; }

        /* ---- Items ---- */
        .items-section { padding: 12px 0; border-bottom: 1px dashed #ccc; }
        .section-title { font-size: 10px; font-weight: 900; letter-spacing: 1px; text-transform: uppercase; color: #999; margin-bottom: 8px; }
        .item { margin-bottom: 8px; }
        .item-name { font-weight: 700; font-size: 12px; color: #111; }
        .item-detail { display: flex; justify-content: space-between; margin-top: 2px; }
        .item-qty { font-size: 11px; color: #666; }
        .item-subtotal { font-size: 11px; font-weight: 700; }

        /* ---- Total ---- */
        .total-section { padding: 12px 0; border-bottom: 1px dashed #ccc; }
        .total-row { display: flex; justify-content: space-between; margin-bottom: 4px; }
        .total-row.grand { margin-top: 8px; border-top: 1px solid #ccc; padding-top: 8px; }
        .total-row .tl { font-size: 11px; color: #666; }
        .total-row .tv { font-size: 11px; font-weight: 700; }
        .total-row.grand .tl { font-size: 13px; font-weight: 900; color: #111; }
        .total-row.grand .tv { font-size: 13px; font-weight: 900; color: #E11D48; }

        /* ---- Footer ---- */
        .footer-section { padding-top: 14px; text-align: center; }
        .status-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 4px;
            font-size: 11px;
            font-weight: 900;
            letter-spacing: 1px;
            text-transform: uppercase;
            margin-bottom: 12px;
        }
        .status-done    { background: #f0fdf4; color: #16a34a; border: 1px solid #bbf7d0; }
        .status-pending { background: #fffbeb; color: #d97706; border: 1px solid #fde68a; }
        .footer-note { font-size: 10px; color: #888; line-height: 1.5; margin-top: 8px; }
        .separator { border: none; border-top: 1px dashed #ccc; margin: 12px 0; }

        /* ---- Print Styles ---- */
        .no-print { text-align: center; margin-top: 24px; }
        .no-print button {
            background: #111;
            color: white;
            border: none;
            padding: 10px 28px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
            letter-spacing: 1px;
        }
        .no-print button:hover { background: #333; }

        @media print {
            body { background: white; padding: 0; }
            .struk { box-shadow: none; border: none; border-radius: 0; }
            .no-print { display: none !important; }
        }
    </style>
</head>
<body>

<div>
    <div class="struk">

        {{-- Header --}}
        <div class="header">
            <div class="logo">WIJAYA <span>MOTOR</span></div>
            <div class="sub">Bengkel Resmi Wijaya Motor</div>
            <div class="address">Jl. Aria Wangsakara, Tangerang Kota<br>Telp: (021) 765-4321</div>
        </div>

        {{-- Info Order --}}
        <div class="info-section">
            <div class="info-row">
                <span class="label">No. Struk</span>
                <span class="val">#ORD-{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</span>
            </div>
            <div class="info-row">
                <span class="label">Tanggal</span>
                <span class="val">{{ $order->created_at->format('d/m/Y H:i') }} WIB</span>
            </div>
            <div class="info-row">
                <span class="label">Customer</span>
                <span class="val">{{ $order->user->name ?? '-' }}</span>
            </div>
            <div class="info-row">
                <span class="label">Jenis Transaksi</span>
                <span class="val">Penjualan Sparepart</span>
            </div>
            @if($order->payment_method)
            <div class="info-row">
                <span class="label">Metode Bayar</span>
                <span class="val">{{ $order->payment_method === 'cash' ? 'Tunai' : 'Transfer Bank' }}</span>
            </div>
            @endif
        </div>

        {{-- Items --}}
        <div class="items-section">
            <div class="section-title">Rincian Item</div>
            @foreach($order->items as $item)
            <div class="item">
                <div class="item-name">{{ $item->sparepart->name ?? 'Produk dihapus' }}</div>
                <div class="item-detail">
                    <span class="item-qty">{{ $item->qty }} pcs &times; Rp {{ number_format($item->price, 0, ',', '.') }}</span>
                    <span class="item-subtotal">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
                </div>
            </div>
            @endforeach
        </div>

        {{-- Total --}}
        <div class="total-section">
            <div class="total-row">
                <span class="tl">Subtotal</span>
                <span class="tv">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
            </div>
            <div class="total-row">
                <span class="tl">Diskon</span>
                <span class="tv">Rp 0</span>
            </div>
            <div class="total-row grand">
                <span class="tl">TOTAL</span>
                <span class="tv">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
            </div>
        </div>

        {{-- Status & Footer --}}
        <div class="footer-section">
            @if($order->status === 'done')
                <span class="status-badge status-done">&#10003; LUNAS</span>
            @else
                <span class="status-badge status-pending">MENUNGGU PEMBAYARAN</span>
            @endif

            <hr class="separator">
            <div class="footer-note">
                Sparepart diambil langsung di bengkel.<br>
                Barang yang sudah dibeli tidak dapat dikembalikan.<br><br>
                Terima kasih telah mempercayakan<br>kendaraan Anda kepada kami.<br><br>
                <strong>Wijaya Motor — Servis Terpercaya</strong>
            </div>
        </div>

    </div>

    {{-- Tombol Print (tidak ikut print) --}}
    <div class="no-print">
        <button onclick="window.print()">
            &#128438; Cetak Struk
        </button>
    </div>
</div>

<script>
    // Auto print kalau diakses lewat tab baru
    window.addEventListener('load', function() {
        // Hanya auto-print kalau user klik dari tombol struk di admin
        // window.print();
    });
</script>
</body>
</html>
