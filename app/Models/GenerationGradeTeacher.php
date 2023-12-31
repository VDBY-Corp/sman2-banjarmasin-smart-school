<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GenerationGradeTeacher extends Model
{
    use HasFactory, SoftDeletes;

    protected $primaryKey = 'id';
    protected $table = 'generation_grade_teachers';
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'id',
        'generation_id',
        'grade_id',
        'teacher_id'
    ];

    public function generation()
    {
        return $this->belongsTo(Generation::class);
    }

    public function grade()
    {
        return $this->belongsTo(Grade::class);
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }
}
