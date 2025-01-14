<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Illuminate\Support\Collection;

class StudentOccupationDataClass implements FromCollection, WithHeadings, WithColumnWidths, WithStyles
{
    protected $studentData;
    protected $occupation;

    public function __construct($studentData, $occupation)
    {
        $this->studentData = $studentData;
        $this->occupation = $occupation;
    }

    public function collection()
    {
        $data = $this->studentData->map(function ($student) {
            $relevantParent = $this->getRelevantParent($student);
            $relevantOccupation = $student->occupation_father === $this->occupation ? $student->occupation_father : $student->occupation_mother;

            return [
                $student->id_number,
                $this->formatName($student),
                $relevantParent,
                $relevantOccupation,
                $student->barangay,
                $student->municipality,
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

    private function getRelevantParent($student)
    {
        if ($student->occupation_father === $this->occupation && $student->occupation_mother === $this->occupation) {
            return 'Father/Mother';
        } elseif ($student->occupation_father === $this->occupation) {
            return 'Father';
        } else {
            return 'Mother';
        }
    }

    private function formatName($student)
    {
        $name = $student->last_name . ', ' . $student->first_name;
        if (!empty($student->middle_name)) {
            $name .= ' ' . substr($student->middle_name, 0, 1) . '.';
        }
        return $name;
    }

    public function headings(): array
    {
        return ['ID Number', 'Name', 'Parent', 'Occupation', 'Barangay', 'Municipality'];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 15,
            'B' => 40,
            'C' => 25,
            'D' => 25,
            'E' => 25,
            'F' => 25,
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
