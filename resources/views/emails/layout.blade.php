<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            background-color: #f3f4f6;
            color: #374151;
            line-height: 1.6;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background-color: #2563eb;
            color: white;
            padding: 20px;
            text-align: center;
            border-top-left-radius: 8px;
            border-top-right-radius: 8px;
        }
        .content {
            background-color: white;
            padding: 30px;
            border-bottom-left-radius: 8px;
            border-bottom-right-radius: 8px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }
        .footer {
            text-align: center;
            font-size: 12px;
            color: #9ca3af;
            margin-top: 20px;
        }
        .button {
            display: inline-block;
            background-color: #2563eb;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
        }
        .status-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 9999px;
            font-size: 14px;
            font-weight: bold;
            background-color: #e5e7eb;
            color: #374151;
        }
        .info-table {
            width: 100%;
            margin: 20px 0;
            border-collapse: collapse;
        }
        .info-table td {
            padding: 8px 0;
            border-bottom: 1px solid #f3f4f6;
        }
        .info-table td:first-child {
            width: 140px;
            color: #6b7280;
        }
        .info-table td:last-child {
            font-weight: 500;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1 style="margin:0; font-size: 24px;">SIPANDIK</h1>
            <p style="margin:5px 0 0; font-size: 14px; opacity: 0.9;">Sistem Informasi Pelayanan Data & Informasi dan Keamanan</p>
        </div>
        
        <div class="content">
            {{ $slot }}
        </div>
        
        <div class="footer">
            <p>&copy; {{ date('Y') }} Dinas Komunikasi dan Informatika Provinsi Lampung.<br>All rights reserved.</p>
        </div>
    </div>
</body>
</html>
