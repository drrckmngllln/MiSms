<?php

namespace App\Imports;

use App\Models\CurriculumSubject;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CurriculumSubjectInSectionImport implements ToModel, WithHeadingRow
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
        return new CurriculumSubject([
            //
            'curriculum_id' => request('curriculum_id'),
            'year_level' => $row['year_level'],
            'semester_id' => $row['semester_id'],
            'code' => $row['code'],
            'descriptive_tittle' => $row['descriptive_tittle'],
            'total_units' => $row['total_units'],
            'lecture_units' => $row['lecture_units'],
            'lab_units' => is_numeric($row['lab_units']) ? (int)$row['lab_units'] : 0,
            'pre_requisite' => $row['pre_requisite'],
            'total_hrs_per_week' => $row['total_hrs_per_week'],
        ]);
    }
}