<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ViolationData extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'violation_data';
    protected $primaryKey = 'id';
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'student_id',
        'violation_id',
        'generation_id',
        'grade_id',
        'date',
        'proof',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function violation()
    {
        return $this->belongsTo(Violation::class);
    }

    public function generation()
    {
        return $this->belongsTo(Generation::class);
    }

    public function grade()
    {
        return $this->belongsTo(Grade::class);
    }
}
