<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AchievementCategory extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'achievement_categories';
    protected $primaryKey = 'id';
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'name',
        'description',
    ];

    public function achievements()
    {
        return $this->hasMany(Achievement::class);
    }
}
