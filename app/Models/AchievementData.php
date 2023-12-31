<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AchievementData extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'achievement_data';
    protected $primaryKey = 'id';
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'student_id',
        'achievement_id',
        'generation_id',
        'grade_id',
        'date',
        'proof_file_id',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function achievement()
    {
        return $this->belongsTo(Achievement::class);
    }

    public function generation()
    {
        return $this->belongsTo(Generation::class);
    }

    public function grade()
    {
        return $this->belongsTo(Grade::class);
    }

    public function proofFile()
    {
        return $this->belongsTo(File::class, 'proof_file_id');
    }
}
