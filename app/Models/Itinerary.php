<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enum\Visibility;

class Itinerary extends Model
{
    /** @use HasFactory<\Database\Factories\ItineraryFactory> */
    use HasFactory;

    protected $table = 'itinerary';

    protected $fillable = [
        'title',
        'city_id',
        'user_id',
        'visibility',
        'price',
        'like'
    ];

    protected $casts = [
        'visibility' => Visibility::class,
    ];

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id', 'id');
    }

    public function user(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function favourites()
    {
        return $this->hasMany(Favorites::class, 'itinerary_id', 'id');
    }

    public function stages(){
        return $this->hasMany(Stage::class,'itinerary_id', 'id');
    }

    // check for favourites
    public function isFavouriteByUser($user_id){
        return $this->favourites()
                ->where('user_id', $user_id)
                ->exists();
    }

    public function getFavouriteByUserId($user_id){
        return $this->favourites()
                ->where('user_id', $user_id)->get()->first();
    }
}
