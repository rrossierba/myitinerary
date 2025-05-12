<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use League\Flysystem\Visibility;

class Itinerary extends Model
{
    /** @use HasFactory<\Database\Factories\ItineraryFactory> */
    use HasFactory;

    protected $table = 'itinerary';

    protected $fillable = [
        'title',
        'city_id',
        'user_id',
        'visibility'
    ];

    protected $casts = [
        'visibility' => Visibility::class,
    ];
}
