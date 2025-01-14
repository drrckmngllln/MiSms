<?php

namespace App\Exports;

use App\Models\Subject;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Termwind\Components\Dd;

class IndividualStudentExport implements FromCollection, WithHeadings, WithStyles

{
    protected $studentData;
    protected $checkbox;

    /**
     * @return \Illuminate\Support\Collection
     * 
     */
    public function __construct($studentData, $checkbox)
    {
        $this->studentData = $studentData;
        $this->checkbox = $checkbox;
    }

    public function collection()
    {
        $exportData = [];
        if ($this->studentData->studentSub && $this->studentData->studentSub->isNotEmpty()) {
            $firstRow = true;

            foreach ($this->studentData->studentSub as $subject) {
                $exportData[] = [
                    'Full Name' => $firstRow ? trim(($this->studentData->first_name ?? '') . ' ' . ($this->studentData->middle_name ?? '') . ' ' . ($this->studentData->last_name ?? 'N/A')) : '',
                    'Semester' => $subject->semester ?? 'N/A',
                    'Year Level' => $subject->year_level ?? 'N/A',
                    'School Year' => $subject->schoolyear->code ?? 'N/A',
                    'Code' => $subject->code ?? 'N/A',
                    'Units' => $subject->total_units ?? 'N/A',
                    'Subjects' => $subject->descriptive_tittle ?? 'N/A',
                    'Grades' => $this->checkbox ? ($subject->grade ?? 'N/A') : 'N/A',
                ];
                $firstRow = false;
            }
        }

        return collect($exportData);
    }

    public function headings(): array
    {
        return [
            'Full Name',
            'Semester',
            'Year Level',
            'School Year',
            'Code',
            'Units',
            'Subjects',
            'Grades',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:H1')->getFont()->setBold(true);
        $sheet->getColumnDimension('A')->setWidth(20);
        $sheet->getColumnDimension('B')->setWidth(20);
        $sheet->getColumnDimension('C')->setWidth(20);
        $sheet->getColumnDimension('D')->setWidth(40);
        $sheet->getColumnDimension('E')->setWidth(20);
        $sheet->getColumnDimension('F')->setWidth(20);
        $sheet->getColumnDimension('G')->setWidth(60);
        $sheet->getColumnDimension('H')->setWidth(20);
    }
}
