<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Laporan Permintaan Data SIPANDIK</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
        }
        .header h1, .header h2, .header h3 {
            margin: 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        .footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            font-size: 10px;
            text-align: right;
        }
        .badge {
            padding: 2px 5px;
            border-radius: 3px;
            color: white;
            font-size: 10px;
        }
        .status-diajukan { background-color: #6c757d; }
        .status-diproses { background-color: #fd7e14; }
        .status-tersedia { background-color: #198754; }
        .status-ditolak { background-color: #dc3545; }
    </style>
</head>
<body>
    <div class="header">
        <h2>PEMERINTAH PROVINSI LAMPUNG</h2>
        <h3>SISTEM INFORMASI PELAPORAN KERENTANAN DAN PERMINTAAN DATA (SIPANDIK)</h3>
        <p>Laporan Permintaan Data - {{ $date }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No Tiket</th>
                <th>Tanggal</th>
                <th>Pemohon</th>
                <th>Data Diminta</th>
                <th>Tujuan</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($dataRequests as $request)
            <tr>
                <td>{{ $request->ticket_number }}</td>
                <td>{{ $request->created_at->format('d/m/Y') }}</td>
                <td>
                    {{ $request->user->name }}<br>
                    <small>{{ $request->user->opd ? $request->user->opd->nama : 'Masyarakat' }}</small>
                </td>
                <td>
                    <strong>{{ $request->nama_data }}</strong><br>
                    <small>OPD: {{ $request->opd ? $request->opd->nama : 'Umum' }}</small>
                </td>
                <td>{{ Str::limit($request->tujuan_penggunaan, 50) }}</td>
                <td>
                    <span class="badge status-{{ $request->status }}">{{ ucfirst($request->status) }}</span>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        Dicetak pada: {{ now()->format('d/m/Y H:i:s') }}
    </div>
</body>
</html>
