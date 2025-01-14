<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

use function PHPSTORM_META\map;

class MasterListExport implements FromCollection, WithHeadings, WithStyles
{
    /**
     * @return \Illuminate\Support\Collection
     */
    protected $studentData, $withGrade;

    public function __construct($studentData, $withGrade = false)
    {
        $this->studentData = $studentData;
        $this->withGrade = $withGrade;
    }
    public function collection()
    {
        $formattedData = [];
        $uniqueLastNames = [];

        foreach ($this->studentData as $student) {

            $formattedData[$student->first_name][] = [
                'id_number' => $student->id_number,
                'first_name' => $student->first_name,
                'middle_name' => $student->middle_name,
                'last_name' => $student->last_name,
                'gender' => $student->gender,
                'course' => $student->course,
                'year_level' => $student->year_level,
                'home_address' => $student->home_address,
                'code' => $student->Code,
                'grades' => $student->Grade,
                'subject' => $student->Subjects,
                'units' => $student->Units,
                'status' => $student->status,

            ];
        }

        $collection = collect();
        foreach ($formattedData as $firstName => $subjects) {
            foreach ($subjects as $index => $data) {
                if (!in_array($data['id_number'], $uniqueLastNames)) {
                    $uniqueLastNames[] = $data['id_number'];
                }

                $rowData = [
                    ($index === 0) ? $data['id_number'] : '',
                    ($index === 0) ? $data['last_name'] : '',
                    ($index === 0) ? $data['middle_name'] : '',
                    ($index === 0) ? $data['first_name'] : '',
                    ($index === 0) ? $data['gender'] : '',
                    ($index === 0) ? $data['course'] : '',
                    ($index === 0) ? $data['year_level'] : '',
                    ($index === 0) ? $data['home_address'] : '',
                    // $data['code'],
                    $data['subject'],
                    $data['units'],
                    $data['code'],
                    ($index === 0) ? $data['status'] : '',
                ];
                if ($this->withGrade) {
                    $rowData[] = $data['grades'] ?? '';
                }
                $collection->push($rowData);
            }

            $totalStudents = count($uniqueLastNames);
        }


        // Insert a row for total students
        $totalStudentsRow = [
            'Total Students',
            '',
            '',

            $totalStudents,

        ];
        $collection->push($totalStudentsRow);


        return $collection;
    }

    public function headings(): array
    {
        $headings = [
            'ID Number',
            'Last Name',
            'Middle Name',
            'First Name',
            'Gender',
            'Course',
            'Year Level',
            'Address',
            'Subjects',
            'Units',
            'Code',
            'Status',
        ];
        if ($this->withGrade) {
            $headings[] = 'Grade';
        }
        return $headings;
    }
    public function styles(Worksheet $sheet)
    {
        // $sheet->getStyle('A1:D1')->getFont()->setBold(true);
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
        $sheet->getColumnDimension('J')->setWidth(20);
        $sheet->getColumnDimension('K')->setWidth(20);
        // $sheet->getColumnDimension('L')->setWidth(20);
        if ($this->withGrade) {
            $sheet->getColumnDimension('L')->setWidth(20);
        }
        $sheet->getColumnDimension('M')->setWidth(20);
        $sheet->getStyle('A' . ($this->studentData->count() + 2))->getFont()->setBold(true);
        $sheet->getStyle('D' . ($this->studentData->count() + 2))->getFont()->setBold(true);
    }
}
