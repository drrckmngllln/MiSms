<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Illuminate\Support\Collection;

class DiscountCategoryExport implements FromCollection, WithHeadings, WithStyles
{
    protected $studentData;
    protected $totalDiscountAmount;

    public function __construct(Collection $studentData)
    {
        $this->studentData = $studentData;
        $this->totalDiscountAmount = $studentData->sum('amount');
    }

    public function collection()
    {
        $data = $this->studentData->toArray();

        // Add row for totals
        $data[] = [
            'department' => '',
            'discount' => 'TOTAL',
            'amount' => $this->totalDiscountAmount,
        ];

        return collect($data);
    }

    public function headings(): array
    {
        return [
            'Department',
            'Discount Category',
            'Amount',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:C1')->getFont()->setBold(true);

        $lastRow = $sheet->getHighestRow();
        $sheet->getStyle("A{$lastRow}:C{$lastRow}")->getFont()->setBold(true);

        $sheet->getColumnDimension('A')->setWidth(20);
        $sheet->getColumnDimension('B')->setWidth(30);
        $sheet->getColumnDimension('C')->setWidth(30);
    }
}
