<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Booking extends Model
{
    protected $fillable = [
        'customer_id',
        'kos_id',
        'booking_code',
        'tenant_name',
        'tenant_phone',
        'tenant_email',
        'start_date',
        'end_date',
        'duration_months',
        'kos_price',
        'subtotal',
        'admin_fee',
        'total_amount',
        'notes',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date' => 'date',
            'duration_months' => 'integer',
            'kos_price' => 'decimal:2',
            'subtotal' => 'decimal:2',
            'admin_fee' => 'decimal:2',
            'total_amount' => 'decimal:2',
        ];
    }

    /**
     * Customer / penyewa yang melakukan booking ini.
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    /**
     * Kos yang dipesan.
     */
    public function kos(): BelongsTo
    {
        return $this->belongsTo(Kos::class, 'kos_id');
    }

    /**
     * Seluruh invoice tagihan yang dihasilkan dari booking ini.
     */
    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class, 'booking_id');
    }
}
