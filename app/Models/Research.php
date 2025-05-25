<?php

namespace App\Models;

use App\Enum\SearchGroups;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Research extends Model
{
    /** @use HasFactory<\Database\Factories\ResearchFactory> */
    use HasFactory;

    protected $table = 'research';

    protected $fillble = [
        'group',
        'query_string'
    ];

    protected $casts = [
        'group' => SearchGroups::class
    ];
}
