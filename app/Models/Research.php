<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Research extends Model
{
    /** @use HasFactory<\Database\Factories\ResearchFactory> */
    use HasFactory;

    protected $table = 'research';

    protected $fillble = [
        'query_string',
        'user_id'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
