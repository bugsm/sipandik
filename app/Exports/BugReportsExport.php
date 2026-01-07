<?php

namespace App\Exports;

use App\Models\BugReport;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class BugReportsExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    public function collection()
    {
        return BugReport::with(['user', 'application.opd', 'vulnerabilityType'])
            ->latest()
            ->get();
    }

    public function headings(): array
    {
        return [
            'Nomor Tiket',
            'Tanggal Laporan',
            'Pelapor',
            'OPD',
            'Aplikasi',
            'Jenis Kerentanan',
            'Tingkat Keparahan',
            'Judul',
            'Status',
            'Apresiasi',
            'Keterangan Admin'
        ];
    }

    public function map($bugReport): array
    {
        return [
            $bugReport->ticket_number,
            $bugReport->created_at->format('d/m/Y H:i'),
            $bugReport->user->name,
            $bugReport->application->opd->nama,
            $bugReport->application->nama,
            $bugReport->vulnerabilityType->nama,
            $bugReport->vulnerabilityType->level,
            $bugReport->judul,
            ucfirst($bugReport->status),
            $bugReport->status_apresiasi === 'belum_dinilai' ? 'Belum Dinilai' : ucfirst($bugReport->status_apresiasi),
            $bugReport->catatan_admin ?? '-'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
