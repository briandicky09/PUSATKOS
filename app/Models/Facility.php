<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Facility extends Model
{
    protected $table = 'facilities';

    protected $fillable = [
        'name',
        'slug',
    ];

    /**
     * Properti kos yang memiliki fasilitas ini.
     */
    public function kos(): BelongsToMany
    {
        return $this->belongsToMany(Kos::class, 'facility_kos');
    }
}
