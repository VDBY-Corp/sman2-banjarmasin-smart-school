<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AttendanceData extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'attendance_data';
    protected $primaryKey = 'id';
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'attendance_id',
        'student_id',
        'status',
        'description',
        'proof_file_id',
    ];

    public function attendance()
    {
        return $this->belongsTo(Attendance::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function scopeStudent($query, $student)
    {
        return $query->where('student_id', $student->id);
    }

    public function proofFile()
    {
        return $this->belongsTo(File::class, 'proof_file_id');
    }
}
