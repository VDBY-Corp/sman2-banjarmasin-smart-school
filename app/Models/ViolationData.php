<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ViolationData extends Model
{
    use HasFactory;

    protected $table = 'violation_data';
    protected $primaryKey = 'id';
    public $incrementing = false;
}
