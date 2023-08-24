<?php

namespace App\Imports;

use App\Models\Student;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class StudentsImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // dd($row);
        // die();
        return new Student([
            'nisn' => $row['nisn'],
            'grade_id' => $row['grade_id'],
            'generation_id' => $row['generation_id'],
            'name' => $row['name'],
            'gender' => $row['gender'],
            'point' => $row['point'],
        ]);
    }
}
