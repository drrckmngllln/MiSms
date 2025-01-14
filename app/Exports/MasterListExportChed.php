<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

use function PHPSTORM_META\map;

class MasterListExportChed implements FromCollection, WithHeadings, WithStyles
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
                '' => '',
                'semester' => $student->semester,
                '' => '',
                '' => '',
                'course' => $student->course,
                '' => '',
                'year_level' => $student->year_level,
                'last_name' => $student->last_name,
                'first_name' => $student->first_name,
                'middle_name' => $student->middle_name,
                '' => '',
                'gender' => $student->gender,
                '' => '',
                'home_address' => $student->home_address,
                '' => '',
                'code' => $student->Code,
                'units' => $student->Units,
            ];
        }

        $collection = collect();
        foreach ($formattedData as $firstName => $subjects) {
            $firstSubject = $subjects[0];
            $rowData = [
                $firstSubject[''] ?? '',
                $firstSubject['semester'] ?? '',
                $firstSubject[''] ?? '',
                $firstSubject[''] ?? '',
                $firstSubject['course'] ?? '',
                $firstSubject[''] ?? '',
                $firstSubject['year_level'] ?? '',
                $firstSubject['last_name'] ?? '',
                $firstSubject['first_name'] ?? '',
                $firstSubject['middle_name'] ?? '',
                $firstSubject[''] ?? '',
                $firstSubject['gender'] ?? '',
                '', // Suffix
                $firstSubject['home_address'] ?? '',

            ];

            foreach ($subjects as $index => $subject) {
                if ($index < 8) {
                    $rowData[] = $subject['code'] ?? '';
                    $rowData[] = $subject['units'] ?? '';
                }
            }
            while (count($rowData) < 30) {
                $rowData[] = '';
            }

            if ($this->withGrade) {
                $rowData[] = $firstSubject['grades'] ?? '';
            }

            $collection->push($rowData);
        }

        return $collection;
    }

    public function headings(): array
    {
        return [
            'Name of HEI',
            'Semester (1st,2nd, 3rd,Sum mer)',
            'Academic Year',
            "Program Level (Pre-Baccalaure ate, Baccalaure ate, Post Baccalaure ate, Masters/, Doctoral)",
            'Program Name (Do not Abbrevia te)',
            'Major Name (Do not Abbrevia te)',
            'Year Level',
            'Last Name',
            'First Name',
            'Middle Name',
            'Suffix',
            'Sex (F,M)',
            'Student Type (Foreign, Regular, Exchange, LEP, ETEEAP,DE, TNE,Others )',
            'If Others, please specify',
            'Subject Code 1',
            'Units - Subject 1',
            'Subject Code 2',
            'Units - Subject 2',
            'Subject Code 3',
            'Units - Subject 3',
            'Subject Code 4',
            'Units - Subject 4',
            'Subject Code 5',
            'Units - Subject 5',
            'Subject Code 6',
            'Units - Subject 6',
            'Subject Code 7',
            'Units - Subject 7',
            'Subject Code 8',
            'Units - Subject 8',
            'Subject Code 9',
            'Units - Subject 9',
            'Subject Code 10',
            'Units - Subject 10',
            'Subject Code 11',
            'Units - Subject 11',
            'Subject Code 12',
            'Units - Subject 12',
            'Subject Code 13',
            'Units - Subject 13',
            'Subject Code 14',
            'Units - Subject 14',
            'Subject Code 15',
            'Units - Subject 15',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Get the last column letter
        $lastColumn = $sheet->getHighestColumn();

        // Apply styles to header row
        $sheet->getStyle('A1:' . $lastColumn . '1')->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 10, // Adjust font size as needed
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
                'wrapText' => true,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000'],
                ],
            ],
        ]);

        // Set column widths (adjust as needed)
        $columnWidths = [
            'A' => 15,
            'B' => 10,
            'C' => 10,
            'D' => 15,
            'E' => 15,
            'F' => 10,
            'G' => 10,
            'H' => 10,
            'I' => 10,
            'J' => 10,
            'K' => 15,
            'L' => 10,
            'M' => 10,
            'N' => 10,
            'O' => 10,
            'P' => 10,
            'Q' => 10,
            'R' => 10,
            'S' => 10,
            'T' => 10,
            'U' => 10,
            'V' => 10,
            'W' => 10,
            'X' => 10,
            'Y' => 10,
            'Z' => 10,
            'AA' => 10,
            'AB' => 10,
            'AC' => 10,
            'AD' => 10,
            'AE' => 10,
            'AF' => 10,
            'AG' => 10,
            'AH' => 10,
            'AI' => 10,
            'AJ' => 10,
            'AK' => 10,
            'AL' => 10,
            'AM' => 10,
            'AN' => 10,
            'AO' => 10,
            'AP' => 10,
            'AQ' => 10,
            'AP' => 10,









        ];

        foreach ($columnWidths as $column => $width) {
            $sheet->getColumnDimension($column)->setWidth($width);
        }

        // Set row height for header
        $sheet->getRowDimension(1)->setRowHeight(100);

        // ... rest of your styling code ...
    }
}