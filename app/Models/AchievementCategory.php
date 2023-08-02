<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AchievementCategory extends Model
{
    use HasFactory;

    protected $table = 'achievement_categories';
    protected $primaryKey = 'id';
    public $incrementing = false;
}
