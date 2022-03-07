<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Calorie2 extends Model
{
    use HasFactory;
    protected $table = 'calories_2';
    protected $fillable = [
        'carbohydrate',
        'protein',
        'fat',
        'calorie',
        'amount',
        'unit',
        'min',
        'max',
        'repast'
    ];
    protected $casts = [
        'meal'=>'array'
    ];

}

