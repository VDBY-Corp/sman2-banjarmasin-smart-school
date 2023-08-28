<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ViolationCategory extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'violation_categories';
    protected $primaryKey = 'id';
    protected $dates = ['deleted_at'];
    protected $fillable = ['name', 'description'];

    public function violations()
    {
        return $this->hasMany(Violation::class);
    }
}
