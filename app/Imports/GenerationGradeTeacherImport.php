<?php

namespace App\Imports;

use App\Models\Generation;
use App\Models\GenerationGradeTeacher;
use App\Models\Grade;
use App\Models\Teacher;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class GenerationGradeTeacherImport implements ToModel, WithHeadingRow, WithChunkReading, WithBatchInserts
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $generationName = $row['angkatan'];
        $generation = Generation::select('id', 'name')->where('name', $generationName)->first();

        $gradeName = $row['kelas'];
        $grade = Grade::select('id', 'name')->where('name', $gradeName)->first();

        $teacherName = $row['guru'];
        $teacher = Teacher::select('id', 'name')->where('id', $teacherName)->orWhere('name', $teacherName)->first();
        

        // if teacher not found, don't import
        if (!$teacher || !$generation || !$grade) {
            return null;
        }
        
        return new GenerationGradeTeacher([
            'generation_id' => $generation->id,
            'grade_id' => $grade->id,
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
