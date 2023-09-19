<?php

namespace App\Imports;

use App\Models\Attendance;
use App\Models\AttendanceData;
use App\Models\Student;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class AttendanceDataImport implements ToModel, WithHeadingRow, WithChunkReading, WithBatchInserts
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

    private $attendance_id;
    
    public function __construct($attendance_id) 
    {
        $this->attendance_id = $attendance_id;
    }

    public function model(array $row)
    {
        $attendance = Attendance::select('grade_id', 'generation_id')->where('id', $this->attendance_id)->first();
        $student = Student::select('id', 'name')->where('name', $row['nama'])->where('grade_id', $attendance->grade_id)->where('generation_id', $attendance->generation_id)->first();

        // if student not found, don't import
        if (!$student) {
            return null;
        }

        return new AttendanceData([
            'attendance_id' => $this->attendance_id,
            'student_id' => $student->id,
            'status' => $row['status'],
            'description' => $row['deskripsi'],
            'proof_file_id' => null
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
