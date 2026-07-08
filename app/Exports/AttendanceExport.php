<?php

namespace App\Exports;

use App\Models\Attendance;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithProperties;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class AttendanceExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize, WithProperties, WithEvents
{
    protected $startDate;
    protected $endDate;

    public function __construct($startDate = null, $endDate = null)
    {
        $this->startDate = $startDate;
        $this->endDate   = $endDate;
    }

    public function properties(): array
    {
        return [
            'creator'        => 'Sistem Absensi KKM',
            'lastModifiedBy' => 'Admin KKM',
            'title'          => 'Data Absensi KKM',
            'description'    => 'Laporan rekap data kehadiran peserta KKM',
            'subject'        => 'Data Absensi',
            'company'        => 'KKM',
        ];
    }

    public function collection()
    {
        $query = Attendance::with('user')->latest('date')->latest('check_in');

        if ($this->startDate) {
            $query->whereDate('date', '>=', $this->startDate);
        }

        if ($this->endDate) {
            $query->whereDate('date', '<=', $this->endDate);
        }

        return $query->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'Nama Peserta',
            'Divisi',
            'Tanggal',
            'Jam Absen',
            'Status',
        ];
    }

    public function map($attendance): array
    {
        static $no = 0;
        $no++;

        $status = strtolower($attendance->status ?? '');
        if ($status === 'present') {
            $statusLabel = 'Hadir';
        } elseif ($status === 'late') {
            $statusLabel = 'Terlambat';
        } elseif ($status === 'absent') {
            $statusLabel = 'Alpha';
        } else {
            $statusLabel = ucfirst($attendance->status ?? '-');
        }

        return [
            $no,
            $attendance->user->name    ?? '-',
            $attendance->user->divisi  ?? '-',
            $attendance->date          ?? '-',
            $attendance->check_in ? substr($attendance->check_in, 0, 5) : '-',
            $statusLabel,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['argb' => 'FFFFFFFF']],
                'fill' => [
                    'fillType'   => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['argb' => 'FF2563EB'],
                ],
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                ],
            ],
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                // Auto filter
                $event->sheet->getDelegate()->setAutoFilter('A1:F1');

                // Borders
                $highestRow    = $event->sheet->getDelegate()->getHighestRow();
                $highestColumn = $event->sheet->getDelegate()->getHighestColumn();
                $fullRange     = 'A1:' . $highestColumn . $highestRow;

                $event->sheet->getDelegate()->getStyle($fullRange)->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color'       => ['argb' => 'FFD1D5DB'],
                        ],
                    ],
                ]);
            },
        ];
    }
}
