<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AttendanceData extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'attendance_data';
    protected $primaryKey = 'id';
    protected $dates = ['deleted_at'];
}
