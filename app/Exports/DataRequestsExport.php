<?php

namespace App\Exports;

use App\Models\DataRequest;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class DataRequestsExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    public function collection()
    {
        return DataRequest::with(['user', 'opd'])
            ->latest()
            ->get();
    }

    public function headings(): array
    {
        return [
            'Nomor Tiket',
            'Tanggal Permintaan',
            'Pemohon',
            'Instansi (OPD)',
            'Nama Data',
            'Tujuan Penggunaan',
            'Format yang Diminta',
            'Tanggal Dibutuhkan',
            'Status',
            'Keterangan Admin'
        ];
    }

    public function map($dataRequest): array
    {
        return [
            $dataRequest->ticket_number,
            $dataRequest->created_at->format('d/m/Y H:i'),
            $dataRequest->user->name,
            $dataRequest->opd ? $dataRequest->opd->nama : 'Umum',
            $dataRequest->nama_data,
            $dataRequest->tujuan_penggunaan,
            is_array($dataRequest->format_data) ? implode(', ', $dataRequest->format_data) : $dataRequest->format_data,
            $dataRequest->tanggal_dibutuhkan ? $dataRequest->tanggal_dibutuhkan->format('d/m/Y') : '-',
            ucfirst($dataRequest->status),
            $dataRequest->catatan_admin ?? '-'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
