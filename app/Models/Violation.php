<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Violation extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'violations';
    protected $primaryKey = 'id';
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'name',
        'point',
        'violation_category_id',
    ];

    public function category()
    {
        return $this->belongsTo(ViolationCategory::class, 'violation_category_id');
    }
}
