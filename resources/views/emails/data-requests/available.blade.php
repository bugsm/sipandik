@component('emails.layout')
    <h2>Halo, {{ $dataRequest->user->name }}!</h2>
    
    <p>Kabar baik! Data yang Anda minta dari <strong>{{ $dataRequest->opd->nama ?? $dataRequest->sumber_data }}</strong> sekarang sudah tersedia.</p>
    
    <div style="background-color: #f0fdf4; border: 1px solid #bbf7d0; color: #166534; padding: 15px; border-radius: 8px; margin: 20px 0;">
        <strong>Berkas:</strong> {{ $dataRequest->file_name }}<br>
        <strong>Ukuran:</strong> {{ $dataRequest->getFileSizeFormatted() }}<br>
        <strong>Berlaku Sampai:</strong> {{ $dataRequest->expired_at ? $dataRequest->expired_at->format('d M Y') : 'Selamanya' }}
    </div>

    <p style="font-size: 13px; color: #dc2626;">Harap segera mengunduh data ini sebelum tanggal kadaluarsa.</p>

    <div style="text-align: center;">
        <a href="{{ route('user.data-requests.download', $dataRequest->id) }}" class="button" style="background-color: #16a34a;">Unduh Data Sekarang</a>
    </div>
@endcomponent
