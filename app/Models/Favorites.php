<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favorites extends Model
{
    /** @use HasFactory<\Database\Factories\FavoritesFactory> */
    use HasFactory;

    protected $table = 'favourites';

    protected $fillable = ['user_id', 'itinerary_id'];

    public function user(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function itinerary(){
        return $this->belongsTo(Itinerary::class, 'itinerary_id', 'id');
    }

}
