<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Teachers extends Model
{
    use HasFactory;

    protected $table = 'tb_teachers';
    protected $primarykey = 'id_teachers';

    protected $filable= [
        'nama_teachers',
        'city',
        'pob',
    ];
}
