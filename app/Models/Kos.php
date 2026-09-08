<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kos extends Model
{
    use SoftDeletes;

    protected $table = 'kos';

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
        'status',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
        ];
    }

    /**
     * Pemilik properti kos ini.
     */
    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    /**
     * Seluruh pemesanan / booking yang terjadi pada kos ini.
     */
    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class, 'kos_id');
    }

    /**
     * Seluruh invoice tagihan yang terkait dengan kos ini.
     */
    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class, 'kos_id');
    }
}
