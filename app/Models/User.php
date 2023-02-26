<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\teachers as Authteachers;

class teachers extends Authteachers
{
    use HasFactory;

    protected $table = 'tb_teachers';
    protected $primaryKey = 'id_teachers';

    protected $fillable = [
        'nama_teachers',
        'email',
        'password',
        'level',
    ];
}