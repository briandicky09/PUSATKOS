<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kos extends Model
{
    protected $fillable = [
        'owner_id',
        'title',
        'slug',
        'description',
        'price',
        'type',
        'city',
        'address',
        'thumbnail',
    ];
}
