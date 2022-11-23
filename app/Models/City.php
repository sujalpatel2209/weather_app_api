<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class City extends Model
{
    use HasFactory;

    protected $table = 'cities';

    protected $primaryKey = 'id';

    protected $fillable = [
        'user_id',
        'city',
    ];

    protected $hidden = [];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function weatherHistories(): HasMany
    {
        return $this->hasMany(Weather::class, 'city_id', 'id');
    }
}
