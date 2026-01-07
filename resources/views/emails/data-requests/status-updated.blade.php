@component('emails.layout')
    <h2>Halo, {{ $dataRequest->user->name }}!</h2>
    
    <p>Status permintaan data Anda telah diperbarui.</p>
    
    <h3 style="margin-top: 25px;">Detail Pembaruan</h3>
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
            <td>Status Baru</td>
            <td><span class="status-badge" style="background-color: {{ $dataRequest->status == 'tersedia' ? '#d1fae5' : ($dataRequest->status == 'ditolak' ? '#fee2e2' : '#e0f2fe') }}">{{ ucfirst($dataRequest->status) }}</span></td>
        </tr>
    </table>

    @if($dataRequest->status == 'tersedia')
    <p>Data yang Anda minta sekarang sudah tersedia untuk diunduh. Silakan masuk ke dashboard untuk mengunduh file.</p>
    @endif

    <div style="text-align: center;">
        <a href="{{ route('user.data-requests.show', $dataRequest->id) }}" class="button">Lihat & Unduh</a>
    </div>
@endcomponent
