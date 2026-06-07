<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Keuangan Wijaya Motor</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
            color: #333;
            margin: 0;
            padding: 0;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #1e293b;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            color: #1e293b;
            text-transform: uppercase;
        }
        .header p {
            margin: 5px 0 0 0;
            color: #64748b;
            font-size: 12px;
        }
        .summary-box {
            background-color: #f8fafc;
            border: 1px solid #cbd5e1;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
        }
        .summary-title {
            font-size: 12px;
            font-weight: bold;
            color: #475569;
            margin-bottom: 5px;
        }
        .summary-amount {
            font-size: 20px;
            font-weight: bold;
            color: #0f172a;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        th, td {
            border: 1px solid #cbd5e1;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #1e293b;
            color: #ffffff;
            font-weight: bold;
        }
        .text-right {
            text-align: right;
        }
        .section-title {
            font-size: 14px;
            font-weight: bold;
            color: #1e293b;
            margin-bottom: 10px;
            border-bottom: 1px solid #cbd5e1;
            padding-bottom: 5px;
        }
    </style>
</head>
<body>

    <div class="header">
        <h1>WIJAYA MOTOR</h1>
        <p>Laporan Pemasukan Resmi</p>
        <p>Periode: {{ $startDate->translatedFormat('d F Y') }} s/d {{ $endDate->translatedFormat('d F Y') }}</p>
    </div>

    @if($tab === 'service')
    <div class="summary-box">
        <div class="summary-title">TOTAL PENDAPATAN SERVIS</div>
        <div class="summary-amount">Rp {{ number_format($totalServiceIncome, 0, ',', '.') }}</div>
    </div>

    <div class="section-title">Rincian Pemasukan Servis Mobil</div>
    <table>
        <thead>
            <tr>
                <th width="15%">Tanggal</th>
                <th width="15%">Invoice</th>
                <th width="20%">Pelanggan</th>
                <th width="15%">Kendaraan</th>
                <th width="15%">Metode</th>
                <th width="20%" class="text-right">Total (Rp)</th>
            </tr>
        </thead>
        <tbody>
            @forelse($services as $svc)
                <tr>
                    <td>{{ $svc->created_at->format('d/m/Y H:i') }}</td>
                    <td>#INV-{{ str_pad($svc->id, 5, '0', STR_PAD_LEFT) }}</td>
                    <td>{{ $svc->booking->user->name ?? 'Guest' }}</td>
                    <td>{{ $svc->booking->vehicle->name ?? '-' }} ({{ $svc->booking->vehicle->plat_nomor ?? $svc->booking->vehicle->plate_number ?? '-' }})</td>
                    <td>{{ ucfirst($svc->payment_method) }}</td>
                    <td class="text-right">{{ number_format($svc->total_cost, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align: center; padding: 15px;">Tidak ada transaksi servis pada periode ini.</td>
                </tr>
            @endforelse
            <tr>
                <th colspan="5" class="text-right">SUBTOTAL SERVIS:</th>
                <th class="text-right">Rp {{ number_format($totalServiceIncome, 0, ',', '.') }}</th>
            </tr>
        </tbody>
    </table>
    @else
    <div class="summary-box">
        <div class="summary-title">TOTAL PENDAPATAN SPAREPART</div>
        <div class="summary-amount">Rp {{ number_format($totalOrderIncome, 0, ',', '.') }}</div>
    </div>

    <div class="section-title">Rincian Penjualan Langsung (Sparepart)</div>
    <table>
        <thead>
            <tr>
                <th width="15%">Tanggal</th>
                <th width="15%">Order ID</th>
                <th width="20%">Pelanggan</th>
                <th width="25%">Item</th>
                <th width="10%">Metode</th>
                <th width="15%" class="text-right">Total (Rp)</th>
            </tr>
        </thead>
        <tbody>
            @forelse($orders as $ord)
                <tr>
                    <td>{{ $ord->created_at->format('d/m/Y H:i') }}</td>
                    <td>#ORD-{{ str_pad($ord->id, 5, '0', STR_PAD_LEFT) }}</td>
                    <td>{{ $ord->user->name ?? 'Pelanggan Umum' }}</td>
                    <td>
                        @foreach($ord->items as $item)
                            {{ $item->sparepart->name ?? 'Unknown' }} (x{{ $item->quantity }})<br>
                        @endforeach
                    </td>
                    <td>{{ ucfirst($ord->payment_method ?? 'cash') }}</td>
                    <td class="text-right">{{ number_format($ord->total_price, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align: center; padding: 15px;">Tidak ada penjualan langsung pada periode ini.</td>
                </tr>
            @endforelse
            <tr>
                <th colspan="5" class="text-right">SUBTOTAL SPAREPART:</th>
                <th class="text-right">Rp {{ number_format($totalOrderIncome, 0, ',', '.') }}</th>
            </tr>
        </tbody>
    </table>
    @endif

    <div style="margin-top: 50px; text-align: right; padding-right: 50px;">
        <p>Dicetak pada: {{ \Carbon\Carbon::now()->translatedFormat('d F Y H:i') }}</p>
        <br><br><br>
        <p><strong>( Admin / Pemilik )</strong></p>
    </div>

</body>
</html>
