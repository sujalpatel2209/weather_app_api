<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Weather extends Model
{
    use HasFactory;

    protected $table = 'weather_histories';

    protected $primaryKey = 'id';

    protected $fillable = [
        'city_id',
        'temp_in_celsius',
        'temp_in_fahrenheit'
    ];

    protected $hidden = [];
}
