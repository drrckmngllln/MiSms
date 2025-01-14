<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithEvents;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Events\AfterSheet;

class InstructorReportExport implements FromCollection, WithHeadings, WithStyles, WithEvents
{
    protected $studentData;

    public function __construct($studentData)
    {
        $this->studentData = $studentData;
    }

    public function collection()
    {
        $data = [];
        $previousInstructor = '';
        $previousSchoolYear = '';
        $previousSemester = '';
        $previousSection = '';
        $previousSubject = '';

        foreach ($this->studentData as $item) {
            $subjectTitles = $item->subjects->pluck('descriptive_tittle')->unique()->implode(', ');

            $baseRow = [
                'Instructor Name' => ($previousInstructor !== $item->instructorss->full_name) ? $item->instructorss->full_name : '',
                'School Year' => ($previousSchoolYear !== $item->schoolYear->code) ? $item->schoolYear->code : '',
                'Semester' => ($previousSemester !== $item->semester) ? $item->semester : '',
                'Section' => ($previousSection !== $item->sections?->section_code) ? $item->sections?->section_code : '',
                'Subject' => ($previousSubject !== $subjectTitles) ? $subjectTitles : '',
                'Schedule' => $item->time . ' ' . $item->day . ' ' . $item->room,
            ];
            $data[] = $baseRow;

            $data[] = [
                'Instructor Name' => '',
                'School Year' => '',
                'Semester' => '',
                'Section' => '',
                'Subject' => '',
                'Schedule' => '',
            ];

            $data[] = [
                'Instructor Name' => 'List of Students',
                'School Year' => '',
                'Semester' => '',
                'Section' => '',
                'Subject' => '',
                'Schedule' => '',
            ];
            foreach ($item->subjects->create_accountss as $student) {
                $studentRow = [
                    'Instructor Name' => $student->student->last_name . ' ' . $student->student->first_name . ' ' . $student->student->middle_name,
                    'School Year' => '',
                    'Semester' => '',
                    'Section' => '',
                    'Subject' => '',
                    'Schedule' => '',
                ];

                $data[] = $studentRow;
            }

            $previousInstructor = $item->instructorss->full_name;
            $previousSchoolYear = $item->schoolYear->code;
            $previousSemester = $item->semester;
            $previousSection = $item->sections?->section_code;
            $previousSubject = $subjectTitles;
        }

        return collect($data);
    }

    public function headings(): array
    {
        return [
            'Instructor Name',
            'School Year',
            'Semester',
            'Section',
            'Subject',
            'Schedule',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:F1')->getFont()->setBold(true);
        $sheet->getColumnDimension('A')->setWidth(20);
        $sheet->getColumnDimension('B')->setWidth(20);
        $sheet->getColumnDimension('C')->setWidth(20);
        $sheet->getColumnDimension('D')->setWidth(20);
        $sheet->getColumnDimension('E')->setWidth(40);
        $sheet->getColumnDimension('F')->setWidth(30);
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {

                $worksheet = $event->sheet->getDelegate();
                $highestRow = $worksheet->getHighestRow();

                for ($row = 2; $row <= $highestRow; $row++) {
                    $cellValue = $worksheet->getCell('A' . $row)->getValue();
                    if ($cellValue === 'List of Students') {
                        $worksheet->getStyle('A' . $row . ':F' . $row)->getFont()->setBold(true);
                    }
                }
            },
        ];
    }
}
