<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Teacher extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'teachers';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $fillable = [
        'name',
        'gender',
        'email',
        'password'
    ];
    protected $hidden = ['password', 'remember_token'];
}
