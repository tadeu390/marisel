<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Viagem extends Model
{
    use SoftDeletes;

    protected $fiilable = [
        'nome',
        'data',
    ];
}
