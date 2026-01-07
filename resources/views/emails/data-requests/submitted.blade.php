@component('emails.layout')
    <h2>Halo, {{ $dataRequest->user->name }}!</h2>
    
    <p>Permintaan data Anda telah berhasil dikirim. Tim kami akan memverifikasi permintaan Anda dalam waktu 2x24 jam kerja.</p>
    
    <h3 style="margin-top: 25px;">Detail Permintaan</h3>
    <table class="info-table">
        <tr>
            <td>Nomor Tiket</td>
            <td>#{{ $dataRequest->ticket_number }}</td>
        </tr>
        <tr>
            <td>Nama Data</td>
            <td>{{ $dataRequest->nama_data }}</td>
        </tr>
        <tr>
            <td>Oleh OPD/Sumber</td>
            <td>{{ $dataRequest->opd->nama ?? $dataRequest->sumber_data }}</td>
        </tr>
        <tr>
            <td>Tujuan</td>
            <td>{{ $dataRequest->tujuan_penggunaan }}</td>
        </tr>
    </table>

    <div style="text-align: center;">
        <a href="{{ route('user.data-requests.show', $dataRequest->id) }}" class="button">Lihat Permintaan</a>
    </div>
@endcomponent
