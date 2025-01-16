<?php

namespace App\Imports;

use App\Models\CreateAccount;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Carbon\Carbon;

class ImportstudentList implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */

    public function model(array $row)
    {
        $all_null = true;
        foreach ($row as $key => $value) {
            if ($value !== null) {
                $all_null = false;
            } else {
                $row[$key] = 0;
            }
        }
        if ($all_null) {
            return null;
        }
        // dd($row);
        return new CreateAccount([
            //
            'id_number' => $row['id_number'],
            'last_name' => $row['last_name'],
            'first_name' => $row['first_name'],
            'middle_name' => $row['middle_name'],
            'course_id' => is_numeric($row['course_id']) ? (int)$row['course_id'] : 0,
            'campus_id' => is_numeric($row['campus_id']) ? (int)$row['campus_id'] : 0,
            // 'admission_date' => $row['admission_date'],
            'admission_date' => $this->convertExcelDate($row['admission_date']),
        ]);
    }
    protected function convertExcelDate($excelDate)
    {
        if (is_numeric($excelDate)) {

            return Carbon::createFromFormat('Y-m-d', gmdate('Y-m-d', ($excelDate - 25569) * 86400))->toDateString();
        }
        return $excelDate;
    }
}