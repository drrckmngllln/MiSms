<?php

namespace App\Exports;

use App\Models\Subject;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Termwind\Components\Dd;

class discountCollectionExport implements FromCollection, WithHeadings, WithStyles
{
    protected $studentData;
    protected $totalStudents;
    protected $totalDiscountAmount;

    public function __construct($studentData)
    {

        $this->studentData = $studentData;
        $this->totalStudents = $studentData->count();
        $this->totalDiscountAmount = $studentData->sum('DiscountAmount');
    }

    public function collection()
    {
        $data = $this->studentData->toArray();

        // Add row for totals
        $data[] = [
            'id_number' => 'Total Students',
            'full_name' => $this->totalStudents,
            'course_department' => '',
            'discount_type' => '',
            'discount_code' => '',
            'discount_amount' => $this->totalDiscountAmount,
            'reason_remarks' => '',
        ];

        return collect($data);
    }

    public function headings(): array
    {
        return [
            'Student ID',
            'Full Name',
            'Course/Department',
            'Discount Type',
            'Discount Code',
            'Discount Amount',
            'Reason/Remarks',
        ];
    }
    public function map($row): array
    {
        return [
            $row['id_number'],
            $row['full_name'],
            $row['course_department'],
            $row['discount_type'],
            $row['discount_code'],
            $row['discount_amount'],
            $row['reason_remarks'],
        ];
    }


    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:G1')->getFont()->setBold(true);


        $lastRow = $sheet->getHighestRow();
        $sheet->getStyle("A{$lastRow}:G{$lastRow}")->getFont()->setBold(true);


        $sheet->getColumnDimension('A')->setWidth(20);
        $sheet->getColumnDimension('B')->setWidth(30);
        $sheet->getColumnDimension('C')->setWidth(30);
        $sheet->getColumnDimension('D')->setWidth(20);
        $sheet->getColumnDimension('E')->setWidth(20);
        $sheet->getColumnDimension('F')->setWidth(20);
        $sheet->getColumnDimension('G')->setWidth(40);
    }
}