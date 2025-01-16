<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Illuminate\Support\Collection;

class CollectionReportperCampExport implements FromCollection, WithHeadings, WithStyles
{
    protected $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    // Prepare the data for the export
    public function collection(): Collection
    {
        $data = [];
        $totals = [
            'Name' => 'Total', // Set label for the totals row
            'Date' => '',
            'Campus' => '',
            'Department' => '',
            'Tuition Fees' => 0,
            'Miscellaneous Fee' => 0,
            'Other Fees' => 0,
            'Laboratory Fee' => 0,
            'Non Assessed' => 0,
            'Total Collections' => 0,
        ];

        foreach ($this->data as $mettit) {
            // Calculate total collections for each row
            $totalCollections =
                ($mettit['Tuition Fees'] ?? 0) +
                ($mettit['Miscellaneous Fee'] ?? 0) +
                ($mettit['Other Fees'] ?? 0) +
                ($mettit['Laboratory Fee'] ?? 0) +
                ($mettit['Non Assessed'] ?? 0);

            // Add row data
            $row = [
                'Name' => $mettit['name'],
                'Date' => $mettit['date'],
                'Campus' => $mettit['campus'],
                'Department' => $mettit['department'],
                'Tuition Fees' => $mettit['Tuition Fees'] ?? 0,
                'Miscellaneous Fee' => $mettit['Miscellaneous Fee'] ?? 0,
                'Other Fees' => $mettit['Other Fees'] ?? 0,
                'Laboratory Fee' => $mettit['Laboratory Fee'] ?? 0,
                'Non Assessed' => $mettit['Non Assessed'] ?? 0,
                'Total Collections' => $totalCollections,
            ];
            $data[] = $row;

            // Update column totals
            $totals['Tuition Fees'] += $row['Tuition Fees'];
            $totals['Miscellaneous Fee'] += $row['Miscellaneous Fee'];
            $totals['Other Fees'] += $row['Other Fees'];
            $totals['Laboratory Fee'] += $row['Laboratory Fee'];
            $totals['Non Assessed'] += $row['Non Assessed'];
            $totals['Total Collections'] += $totalCollections;
        }

        // Append the totals row to the data
        $data[] = $totals;

        return collect($data);
    }


    public function headings(): array
    {
        return [
            'Cashier',
            'Date',
            'Campus',
            'Department',
            'Tuition Fees',
            'Miscellaneous Fee',
            'Other Fees',
            'Laboratory Fee',
            'Non Assessed',
            'Total Collections',
        ];
    }

    // Apply styling
    public function styles(Worksheet $sheet)
    {
        // Bold the headings and totals row
        $sheet->getStyle('A1:J1')->getFont()->setBold(true);
        $lastRow = count($this->data) + 2; // Adjust for headings and totals row
        $sheet->getStyle("A{$lastRow}:I{$lastRow}")->getFont()->setBold(true);

        // Set column widths
        $sheet->getColumnDimension('A')->setWidth(20);
        $sheet->getColumnDimension('B')->setWidth(10);
        $sheet->getColumnDimension('C')->setWidth(10);
        $sheet->getColumnDimension('D')->setWidth(15);
        $sheet->getColumnDimension('E')->setWidth(20);
        $sheet->getColumnDimension('F')->setWidth(15);
        $sheet->getColumnDimension('G')->setWidth(15);
        $sheet->getColumnDimension('H')->setWidth(15);
        $sheet->getColumnDimension('I')->setWidth(15);
        $sheet->getColumnDimension('J')->setWidth(15);


        // Align numeric columns to the right
        $sheet->getStyle('D2:ZZ500')->getAlignment()->setHorizontal('right');
    }
}