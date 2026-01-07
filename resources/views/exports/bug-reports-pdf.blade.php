<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Laporan Bug SIPANDIK</title>
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
        .logo {
            width: 80px;
            position: absolute;
            left: 0;
            top: 0;
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
        .status-diverifikasi { background-color: #0d6efd; }
        .status-diproses { background-color: #fd7e14; }
        .status-selesai { background-color: #198754; }
        .status-ditolak { background-color: #dc3545; }
    </style>
</head>
<body>
    <div class="header">
        <h2>PEMERINTAH PROVINSI LAMPUNG</h2>
        <h3>SISTEM INFORMASI PELAPORAN KERENTANAN DAN PERMINTAAN DATA (SIPANDIK)</h3>
        <p>Laporan Data Bug Report - {{ $date }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No Tiket</th>
                <th>Tanggal</th>
                <th>Pelapor</th>
                <th>Aplikasi/OPD</th>
                <th>Judul/Kerentanan</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($bugReports as $report)
            <tr>
                <td>{{ $report->ticket_number }}</td>
                <td>{{ $report->created_at->format('d/m/Y') }}</td>
                <td>
                    {{ $report->user->name }}<br>
                    <small>{{ $report->user->email }}</small>
                </td>
                <td>
                    <strong>{{ $report->application->nama }}</strong><br>
                    <small>{{ $report->application->opd->nama }}</small>
                </td>
                <td>
                    <strong>{{ $report->judul }}</strong><br>
                    <small class="text-muted">{{ $report->vulnerabilityType->nama }} ({{ $report->vulnerabilityType->level }})</small>
                </td>
                <td>
                    <span class="badge status-{{ $report->status }}">{{ ucfirst($report->status) }}</span>
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
