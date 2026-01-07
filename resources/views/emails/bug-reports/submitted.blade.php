@component('emails.layout')
    <h2>Halo, {{ $bugReport->user->name }}!</h2>
    
    <p>Terima kasih telah mengirimkan laporan bug ke SIPANDIK. Laporan Anda telah kami terima dan akan segera ditinjau oleh tim kami.</p>
    
    <h3 style="margin-top: 25px;">Detail Laporan</h3>
    <table class="info-table">
        <tr>
            <td>Nomor Tiket</td>
            <td>#{{ $bugReport->ticket_number }}</td>
        </tr>
        <tr>
            <td>Judul</td>
            <td>{{ $bugReport->judul }}</td>
        </tr>
        <tr>
            <td>Aplikasi</td>
            <td>{{ $bugReport->application->nama }}</td>
        </tr>
        <tr>
            <td>Jenis Kerentanan</td>
            <td>{{ $bugReport->vulnerabilityType->nama }}</td>
        </tr>
        <tr>
            <td>Status</td>
            <td><span class="status-badge">{{ ucfirst($bugReport->status) }}</span></td>
        </tr>
    </table>

    <p style="margin-top: 20px;">Anda dapat memantau status laporan Anda dan berkomunikasi dengan tim kami melalui dashboard pengguna.</p>

    <div style="text-align: center;">
        <a href="{{ route('user.bug-reports.show', $bugReport->id) }}" class="button">Lihat Laporan</a>
    </div>
@endcomponent
