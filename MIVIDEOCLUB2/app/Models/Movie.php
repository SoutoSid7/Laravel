<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    protected $fillable = [
        // Solo estos campos pueden ser insertados o actualizados con create() o update()
        'title',
        'year',
        'director',
        'poster',
        'rented',
        'synopsis'
    ];
}
