<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AchievementData extends Model
{
    use HasFactory;

    protected $table = 'achievement_data';
    protected $primaryKey = 'id';
    public $incrementing = false;
}
