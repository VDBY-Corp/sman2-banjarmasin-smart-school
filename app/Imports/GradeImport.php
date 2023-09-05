<?php

namespace App\Imports;

use App\Models\Grade;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Models\Teacher;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class GradeImport implements ToModel, WithHeadingRow, WithChunkReading, WithBatchInserts
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $nama = $row['nama'];
        $teacher = Teacher::select('id', 'name')->where('id', $row['guru'])->orWhere('name', $row['guru'])->first();

        // if teacher not found, don't import
        if (!$teacher) {
            return null;
        }

        return new Grade([
            'name' => $nama,
            'teacher_id' => $teacher->id,
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
