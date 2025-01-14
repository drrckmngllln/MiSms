<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Illuminate\Support\Collection;

class StudentGenderDataClass implements FromCollection, WithHeadings, WithColumnWidths, WithStyles
{
    protected $studentData;

    public function __construct($studentData)
    {
        $this->studentData = $studentData;
    }

    public function collection()
    {
        $data = $this->studentData->map(function ($student) {
            return [
                'ID Number' => $student->id_number,
                'Name' => $student->last_name . ', ' . $student->first_name . ' ' . $student->middle_name,
                'Gender' => $student->gender,

            ];
        });

        // Add total row
        $data->push([
            'Total Students:',
            $this->studentData->count(),
            '',
            ''
        ]);

        return $data;
    }

    public function headings(): array
    {
        return ['ID Number', 'Name', 'Gender'];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 15,  // ID Number
            'B' => 40,  // Name
            'C' => 10,  // Gender

        ];
    }

    public function styles(Worksheet $sheet)
    {
        $lastRow = $sheet->getHighestRow();

        return [
            1 => ['font' => ['bold' => true]],
            $lastRow => ['font' => ['bold' => true]],
        ];
    }
}
