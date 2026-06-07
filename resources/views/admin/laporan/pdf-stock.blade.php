<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Lembar Stock Opname - Wijaya Motor</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            color: #1e293b;
        }
        .header p {
            margin: 5px 0 0;
            color: #64748b;
        }
        .info-box {
            margin-bottom: 20px;
        }
        .info-box p {
            margin: 5px 0;
            font-size: 13px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            border: 1px solid #cbd5e1;
            padding: 8px 10px;
            text-align: left;
        }
        th {
            background-color: #f1f5f9;
            font-weight: bold;
            color: #475569;
            font-size: 11px;
            text-transform: uppercase;
        }
        .text-center {
            text-align: center;
        }
        .text-right {
            text-align: right;
        }
        .empty-col {
            width: 80px;
        }
        .signature-area {
            margin-top: 50px;
            width: 100%;
        }
        .signature-box {
            float: right;
            width: 250px;
            text-align: center;
        }
        .signature-line {
            margin-top: 80px;
            border-bottom: 1px solid #333;
        }
    </style>
</head>
<body>

    <div class="header">
        <h1>WIJAYA MOTOR</h1>
        <p>Lembar Kerja Stock Opname Gudang</p>
    </div>

    <div class="info-box">
        <p><strong>Tanggal Cetak:</strong> {{ \Carbon\Carbon::now()->translatedFormat('d F Y H:i') }}</p>
        <p><strong>Petugas Opname:</strong> ................................................................</p>
    </div>

    <table>
        <thead>
            <tr>
                <th width="5%" class="text-center">No</th>
                <th width="35%">Nama Barang</th>
                <th width="15%" class="text-center">Stok Sistem</th>
                <th width="15%" class="text-center">Stok Fisik</th>
                <th width="15%" class="text-center">Selisih</th>
                <th width="15%">Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($spareparts as $index => $item)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $item->name }}</td>
                    <td class="text-center font-bold">{{ $item->stock }}</td>
                    <td></td> {{-- Kolom kosong untuk stok fisik --}}
                    <td></td> {{-- Kolom kosong untuk selisih --}}
                    <td></td> {{-- Kolom kosong untuk keterangan --}}
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="signature-area">
        <div class="signature-box">
            <p>Mengetahui,</p>
            <div class="signature-line"></div>
            <p>( Admin / Pemilik )</p>
        </div>
        <div class="signature-box" style="float: left;">
            <p>Petugas Opname,</p>
            <div class="signature-line"></div>
            <p>( ................................. )</p>
        </div>
        <div style="clear: both;"></div>
    </div>

</body>
</html>
