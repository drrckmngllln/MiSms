<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class feescollectionExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    protected $groupedData;
    protected $category_arr;
    protected $sub_categories_arr;
    protected $sub_cat_spc_counts;

    public function __construct($groupedData)
    {
        $this->groupedData = $groupedData;
    }

    public function collection()
    {
        $data = [];

        // dd($this->groupedData);

        $second_row = ['', '', '', '', '', ...$this->sub_categories_arr];
        $data[] = $second_row;

        // dd($this->groupedData);
        foreach ($this->groupedData as $course => $categories) {

            $total = $categories['Tuition Fees']['TUITION FEE/UNITS']['amount'];
            $d = [
                'date' => now()->format('d/m/Y'),
                'campus' => $categories['Tuition Fees']['TUITION FEE/UNITS']['campus'],
                'course' => $course,
                'year_level' => $categories['Tuition Fees']['TUITION FEE/UNITS']['year_level'],
                'tuition_fee' => '₱' . $total,
            ];

            foreach ($this->sub_categories_arr as $sub_cat) {
                $found = false;
                foreach ($categories as $cat_key => $cat_val) {
                    if ($cat_key === 'Tuition Fees') continue;
                    foreach ($cat_val as $sub_cat_key => $sub_cat_value) {
                        // dd($sub_cat_value);
                        if ($sub_cat === $sub_cat_key) {
                            $d = [...$d, $sub_cat_key => '₱' . $sub_cat_value["amount"]];
                            $total += $sub_cat_value["amount"];
                            $found = true;
                        }
                    }
                }
                if (!$found) $d = [...$d, ''];
            }

            $data[] = [...$d, '₱' . $total];
        }

        // foreach ($this->groupedData as $category => $subCategories) {
        //     foreach ($subCategories as $subCategory => $details) {
        //         $data[] = [
        //             'date' => now()->format('d/m/Y'),
        //             'campus' => $details['campus'],
        //             'course' => $details['course_id'],
        //             'year_level' => $details['year_level'],
        //             'category' => $category,
        //             'sub_category' => $subCategory,
        //             'amount' => $details['amount'],
        //         ];
        //     }
        // }

        return collect($data);
    }

    public function headings(): array
    {
        $categories_output = [];
        $sub_categories = [];
        // dd($this->groupedData);
        foreach ($this->groupedData as $course => $categories) {
            foreach ($categories as $cat_key => $cat_val) {
                if ($cat_key === 'Tuition Fees') continue;
                // Categories
                if (!in_array($cat_key, $categories_output)) {
                    $categories_output[] = $cat_key;

                    // add empty spaces, for merge later
                    $temp_sub_cats = [];
                    foreach ($this->groupedData as $course => $categories1) {
                        foreach ($categories1 as $cat_key1 => $cat_val1) {
                            if ($cat_key1 === 'Tuition Fees') continue;
                            foreach ($cat_val1 as $sub_cat_key1 => $sub_cat_value) {
                                if ($cat_key === $cat_key1) {
                                    if (!in_array($sub_cat_key1, $temp_sub_cats)) {
                                        $temp_sub_cats[] = $sub_cat_key1;
                                    }
                                }
                            }
                        }
                    }
                    $sub_cat_count = count($temp_sub_cats);
                    $this->sub_cat_spc_counts[$cat_key] = $sub_cat_count;
                    $spaces = $sub_cat_count - 1;
                    for ($i = 1; $i <= $spaces; $i++) {
                        $categories_output[] = '';
                    }
                }
                // Sub-Categories
                foreach ($cat_val as $sub_cat_key => $sub_cat_value) {
                    if (!in_array($sub_cat_key, $sub_categories)) {
                        $sub_categories[] = $sub_cat_key;
                    }
                }
            }
        }

        $this->sub_categories_arr = $sub_categories;
        // dd($sub_categories);
        $this->category_arr = $categories_output;
        return [
            'Date',
            'Campus',
            'Course',
            'Year Level',
            'Tuition Fees',
            ...$categories_output,
            'Total Collection'
        ];
    }

    public function map($row): array
    {
        return $row;
    }

    public function styles(Worksheet $sheet)
    {
        $columns = $this->getColumns();
        $row2Cols = $this->getRow2Columns();

        $sheet->getStyle('A1:Z1')->getFont()->setBold(true);
        $sheet->getStyle('A2:Z2')->getFont()->setBold(true);
        $sheet->getStyle('A1:Z1')->getAlignment()->setHorizontal('center')->setVertical('center');
        $sheet->getStyle('A2:Z2')->getAlignment()->setHorizontal('center')->setVertical('center');
        $sheet->getStyle('E3:ZZ500')->getAlignment()->setHorizontal('right');
        $sheet->getColumnDimension('A')->setWidth(12);
        $sheet->getColumnDimension('B')->setWidth(20);
        $sheet->getColumnDimension('C')->setWidth(15);
        $sheet->getColumnDimension('D')->setWidth(15);
        $sheet->getColumnDimension('E')->setWidth(20);
        $sheet->getColumnDimension('F')->setWidth(15);
        $sheet->getColumnDimension('G')->setWidth(15);
        $sheet->getRowDimension(1)->setRowHeight(30);
        $sheet->getRowDimension(2)->setRowHeight(30);
        $cnt = count($this->sub_categories_arr) + 5;
        $sheet->getColumnDimension($row2Cols[$cnt])->setWidth(15);
        $start = false;
        $start_ind = null;
        // ['Msix fee', '', '', 'Other fee', '','']
        foreach ($this->category_arr as $index => $cat) {
            if ($cat !== '' && !$start) {
                $start = true;
                $start_ind = $index;
            } else if ($cat !== '' && $start) {
                $cnt = $index - $start_ind - 2; // 3
                $char1 = $columns[$cnt + 5]; //+5 for: date, campus, course, year level, tuition fee
                $char2 = $columns[$index +  5 - 1];
                $cell_rng = "$char1:$char2";
                $sheet->mergeCells($cell_rng);
                $start = $index;
            } else if ($index === count($this->category_arr) - 1) {
                $cnt = $index + 1 - $start_ind - 2; // 3
                $char1 = $columns[$cnt + 5]; //+5 for: date, campus, course, year level, tuition fee
                $char2 = $columns[$index + 1 +  5 - 1];
                $cell_rng = "$char1:$char2";
                $sheet->mergeCells($cell_rng);
            }
        }

        foreach ($this->sub_categories_arr as $index => $sub_category) {
            $char1 = $row2Cols[$index + 5]; //+5 for: date, campus, course, year level, tuition fee
            $sheet->getColumnDimension($char1)->setWidth(strlen($sub_category) * 1.2);
        }
    }

    private function getColumns()
    {
        $columns = [];
        $c = '';
        for ($i = 1; $i <= 26; $i++) {
            $column = chr(64 + $i);
            $columns[] = $column . '1';
        }
        $c = 'A';
        for ($i = 1; $i <= 26; $i++) {
            $column = chr(64 + $i);
            $columns[] = $c . $column . '1';
        }
        return $columns;
    }


    private function getRow2Columns()
    {
        $columns = [];
        $c = '';
        for ($i = 1; $i <= 26; $i++) {
            $column = chr(64 + $i);
            $columns[] = $column;
        }
        $c = 'A';
        for ($i = 1; $i <= 26; $i++) {
            $column = chr(64 + $i);
            $columns[] = $c . $column;
        }
        return $columns;
    }
}
