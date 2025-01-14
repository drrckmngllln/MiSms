<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class StudentDataClass implements FromCollection, WithHeadings, WithStyles

{
    protected $studentData;
    /**
     * @return \Illuminate\Support\Collection
     * 
     */
    public function __construct($studentData)
    {
        $this->studentData = $studentData;
    }
    public function collection()
    {
        //
        // return $this->studentData;

        $totalStudents = count($this->studentData);
        $totalRow = [
            'Total Students',
            '',
            '',
            '',
            '',
            '',
            '',
            $totalStudents,
        ];

        $data = $this->studentData->push($totalRow);

        return $data;
    }
    public function headings(): array
    {
        return [
            'First Name',
            'Middle Name',
            'Last Name',
            'Gender',
            'Course',
            'Year Level',
            'Section',
        ];
    }
    public function styles(Worksheet $sheet)
    {

        $sheet->getStyle('A1:D1')->getFont()->setBold(true);
        $sheet->getStyle('A1:H1')->getFont()->setBold(true);

        $sheet->getColumnDimension('A')->setWidth(20);
        $sheet->getColumnDimension('B')->setWidth(20);
        $sheet->getColumnDimension('C')->setWidth(20);
        $sheet->getColumnDimension('D')->setWidth(20);
        $sheet->getColumnDimension('E')->setWidth(20);
        $sheet->getColumnDimension('F')->setWidth(20);
        $sheet->getColumnDimension('G')->setWidth(20);
        $sheet->getColumnDimension('H')->setWidth(40);
        $sheet->getColumnDimension('I')->setWidth(40);
    }
}
