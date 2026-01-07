@component('emails.layout')
    <h2>Halo, {{ $bugReport->user->name }}!</h2>
    
    <p>Ada pembaruan status pada laporan bug yang Anda kirimkan.</p>
    
    <h3 style="margin-top: 25px;">Detail Pembaruan</h3>
    <table class="info-table">
        <tr>
            <td>Nomor Tiket</td>
            <td>#{{ $bugReport->ticket_number }}</td>
        </tr>
        <tr>
            <td>Status Baru</td>
            <td><span class="status-badge" style="background-color: {{ $bugReport->status == 'selesai' ? '#d1fae5' : ($bugReport->status == 'ditolak' ? '#fee2e2' : '#e0f2fe') }}">{{ ucfirst($bugReport->status) }}</span></td>
        </tr>
        @if($bugReport->catatan_admin)
        <tr>
            <td>Catatan Admin</td>
            <td>{{ $bugReport->catatan_admin }}</td>
        </tr>
        @endif
        @if($bugReport->status_apresiasi != 'belum_dinilai')
        <tr>
            <td>Apresiasi</td>
            <td>{{ ucwords(str_replace('_', ' ', $bugReport->status_apresiasi)) }}</td>
        </tr>
        @endif
    </table>

    <div style="text-align: center;">
        <a href="{{ route('user.bug-reports.show', $bugReport->id) }}" class="button">Lihat Detail</a>
    </div>
@endcomponent
