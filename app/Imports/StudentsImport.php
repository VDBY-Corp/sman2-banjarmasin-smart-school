<?php

namespace App\Imports;

use App\Models\Generation;
use App\Models\Grade;
use App\Models\Student;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class StudentsImport implements ToModel, WithHeadingRow, WithChunkReading, WithBatchInserts
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $gradeName = $row['kelas'];
        $generationName = $row['angkatan'];
        $grade = Grade::select('id', 'name')->where('name', $gradeName)->first();
        $generation = Generation::select('id','name')->where('name', $generationName)->first();

        // if generation or grade not found, don't import
        if (!$grade || !$generation) {
            return null;
        }

        return new Student([
            'nisn' => $row['nisn'],
            'grade_id' => $grade->id,
            'generation_id' => $generation->id,
            'name' => $row['nama'],
            'gender' => $row['jenis_kelamin'],
            'place_birth' => $row['tempat_lahir'],
            'date_birth' => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['tanggal_lahir'])
        ]);
    }

    public function chunkSize(): int
    {
        return 1000;
    }

    public function batchSize(): int
    {
        return 1000;
    }
}
