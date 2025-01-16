<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class BanksExports implements FromCollection, WithHeadings, WithStyles
{
    protected $studentData;

    public function __construct($studentData)
    {
        $this->studentData = $studentData;
    }

    public function collection()
    {
        return collect($this->studentData);
    }

    public function headings(): array
    {
        return [
            'Banks',
            'Amount',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:B1')->getFont()->setBold(true);

        $lastRow = $sheet->getHighestRow();
        $sheet->getStyle("A{$lastRow}:B{$lastRow}")->getFont()->setBold(true);

        $sheet->getColumnDimension('A')->setWidth(20);
        $sheet->getColumnDimension('B')->setWidth(15);
    }
}
