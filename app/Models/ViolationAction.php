<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ViolationAction extends Model
{
    use HasFactory;

    protected $fillable = [
        'point_a',
        'point_b',
        'action',
    ];
}
