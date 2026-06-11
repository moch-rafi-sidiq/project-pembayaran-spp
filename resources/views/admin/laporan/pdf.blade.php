<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>{{ $title }}</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h2 { margin: 0; }
        .header p { margin: 5px 0; color: #666; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #2563EB; color: white; }
        .footer { margin-top: 20px; text-align: right; font-size: 10px; }
        .total { margin-top: 15px; font-weight: bold; text-align: right; }
    </style>
</head>
<body>
    <div class="header">
        <h2>SIPAYU - Sistem Pembayaran SPP</h2>
        <p>{{ $title }}</p>
        <p>Dicetak: {{ date('d/m/Y H:i:s') }}</p>
    </div>
    
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>NIS</th>
                <th>Siswa</th>
                <th>Bulan</th>
                <th>Tahun</th>
                <th>Jumlah</th>
                <th>Metode</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pembayaran as $index => $p)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ date('d/m/Y', strtotime($p->tanggal_bayar)) }}</td>
                <td>{{ $p->siswa->nis ?? '-' }}</td>
                <td>{{ $p->siswa->name ?? '-' }}</td>
                <td>{{ $p->bulan }}</td>
                <td>{{ $p->tahun }}</td>
                <td>Rp {{ number_format($p->jumlah, 0, ',', '.') }}</td>
                <td>{{ $p->metode }}</td>
                <td>{{ $p->status }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
    <div class="total">
        Total Transaksi: {{ count($pembayaran) }}<br>
        Total Pemasukan: Rp {{ number_format($pembayaran->sum('jumlah'), 0, ',', '.') }}
    </div>
    
    <div class="footer">
        <p>Dicetak oleh: {{ Auth::user()->name }}</p>
    </div>
</body>
</html>