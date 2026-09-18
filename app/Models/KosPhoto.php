<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KosPhoto extends Model
{
    protected $table = 'kos_photos';

    protected $fillable = [
        'kos_id',
        'photo_path',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'sort_order' => 'integer',
        ];
    }

    /**
     * Properti kos pemilik foto ini.
     */
    public function kos(): BelongsTo
    {
        return $this->belongsTo(Kos::class, 'kos_id');
    }

    /**
     * Accessor untuk URL lengkap foto yang dapat diakses browser.
     */
    public function getUrlAttribute(): string
    {
        return asset('storage/' . $this->photo_path);
    }
}
