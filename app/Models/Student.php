<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'students';
    protected $primaryKey = 'nisn';
    protected $keyType = 'string';
    protected $dates = [
        'deleted_at',
    ];
    protected $fillable = [
        'nisn',
        'grade_id',
        'generation_id',
        'name',
        'gender',
    ];
    public $incrementing = false;


    public function grade()
    {
        return $this->belongsTo(Grade::class);
    }

    public function generation()
    {
        return $this->belongsTo(Generation::class);
    }
}
