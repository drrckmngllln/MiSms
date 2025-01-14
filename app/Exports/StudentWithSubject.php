<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Termwind\Components\Dd;

class StudentWithSubject implements FromCollection, WithHeadings, WithStyles
{
    /**
     * @return \Illuminate\Support\Collection
     */
    protected $createAccountTable;

    public function __construct($createAccountTable)
    {
        $this->createAccountTable = $createAccountTable;
    }

    public function collection()
    {
        $fullName = $this->createAccountTable->first_name . ' ' . $this->createAccountTable->middle_name . ' ' . $this->createAccountTable->last_name;
        $studentSubjects = [];
        $studentSubjects = [];

        $basicInfo = [
            'fullName' => $fullName,




        ];

        $firstRow = true;
        foreach ($this->createAccountTable->studentSubjects as $student) {
            foreach ($student->adddetails as $subjectDetails) {
                $studentData = $firstRow ? $basicInfo : array_fill_keys(array_keys($basicInfo), '');
                $studentSubjects[] = array_merge($studentData, [
                    'semester' => $student->semester,
                    'schoolYear' => $student?->schoolYear?->code,
                    'subjectCode' => $student->code,
                    'descriptiveTitle' => $student->descriptive_tittle,
                    'totalUnits' => $student->total_units,
                    'schedule' => $subjectDetails->time . '  ' .  $subjectDetails->day . '  ' . $subjectDetails->room,
                    'instructor' => $subjectDetails?->instructorss?->full_name,
                    'section' => $student->section->section_code,
                ]);
                $firstRow = false;
            }
        }
        return collect($studentSubjects);
    }

    public function headings(): array
    {
        return [
            'Full Name',
            'Semester',
            'SchoolYear',
            'Code',
            'Descriptive Title',
            'Units',
            'Schedule',
            'Instructor',
            'Section'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:I1')->getFont()->setBold(true);
        $sheet->getStyle('J1:K1')->getFont()->setBold(true);
        $sheet->getDefaultRowDimension()->setRowHeight(15);
        $sheet->getColumnDimension('A')->setWidth(40);
        $sheet->getColumnDimension('B')->setWidth(10);
        $sheet->getColumnDimension('C')->setWidth(25);
        $sheet->getColumnDimension('D')->setWidth(40);
        $sheet->getColumnDimension('E')->setWidth(40);
        $sheet->getColumnDimension('F')->setWidth(40);
        $sheet->getColumnDimension('G')->setWidth(40);
        $sheet->getColumnDimension('H')->setWidth(40);
        $sheet->getColumnDimension('I')->setWidth(40);
    }
}
