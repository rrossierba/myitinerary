<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stage extends Model
{
    /** @use HasFactory<\Database\Factories\StageFactory> */
    use HasFactory;

    protected $table = 'stages';

    protected $fillable = [
        'location',
        'description',
        'duration',
        'cost',
        'itinerary_id',
    ];

    public function itinerary(){
        return $this->belongsTo(Itinerary::class, 'itinerary_id', 'id');
    }
}
