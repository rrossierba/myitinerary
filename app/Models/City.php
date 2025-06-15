<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    /** @use HasFactory<\Database\Factories\CityFactory> */
    use HasFactory;

    protected $table = 'cities';

    protected $fillable = ['name', 'region', 'state'];

    public function itineraries()
    {
        return $this->hasMany(Itinerary::class, 'itinerary_id', 'id');
    }

}
