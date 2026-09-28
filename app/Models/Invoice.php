<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Invoice extends Model
{
    protected $fillable = [
        'booking_id',
        'customer_id',
        'kos_id',
        'invoice_number',
        'amount',
        'admin_fee',
        'tax',
        'total_amount',
        'due_date',
        'paid_at',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'due_date' => 'date',
            'paid_at' => 'datetime',
            'amount' => 'decimal:2',
            'admin_fee' => 'decimal:2',
            'tax' => 'decimal:2',
            'total_amount' => 'decimal:2',
        ];
    }

    /**
     * Booking yang menjadi acuan terbitnya invoice ini.
     */
    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class, 'booking_id');
    }

    /**
     * Customer yang ditagih pada invoice ini (denormalized).
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    /**
     * Kos yang disewa pada invoice ini (denormalized).
     */
    public function kos(): BelongsTo
    {
        return $this->belongsTo(Kos::class, 'kos_id');
    }

    /**
     * Seluruh transaksi / percobaan pembayaran atas invoice ini.
     */
    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class, 'invoice_id');
    }

    /**
     * Generate nomor invoice unik server-side (format: INV-YYYYMM-XXXX).
     */
    public static function generateInvoiceNumber(): string
    {
        $prefix = 'INV-' . now()->format('Ym') . '-';

        $lastInvoice = static::where('invoice_number', 'like', $prefix . '%')
            ->orderBy('id', 'desc')
            ->first();

        $nextNumber = 1;
        if ($lastInvoice) {
            $lastSequence = substr($lastInvoice->invoice_number, strlen($prefix));
            if (is_numeric($lastSequence)) {
                $nextNumber = (int) $lastSequence + 1;
            }
        }

        do {
            $candidate = $prefix . str_pad((string) $nextNumber, 4, '0', STR_PAD_LEFT);
            $exists = static::where('invoice_number', $candidate)->exists();
            if ($exists) {
                $nextNumber++;
            }
        } while ($exists);

        return $candidate;
    }

    /**
     * Buat invoice secara otomatis dari data booking (server-side).
     */
    public static function createFromBooking(Booking $booking, ?string $dueDate = null): self
    {
        // Proteksi duplikasi invoice untuk satu booking
        if (static::where('booking_id', $booking->id)->exists()) {
            throw new \RuntimeException('Invoice duplicate: Booking ini sudah memiliki invoice.');
        }

        $resolvedDueDate = $dueDate ?? (
            $booking->start_date
                ? \Carbon\Carbon::parse($booking->start_date)->format('Y-m-d')
                : now()->format('Y-m-d')
        );

        return static::create([
            'booking_id' => $booking->id,
            'customer_id' => $booking->customer_id,
            'kos_id' => $booking->kos_id,
            'invoice_number' => static::generateInvoiceNumber(),
            'amount' => $booking->subtotal,
            'admin_fee' => $booking->admin_fee,
            'tax' => 0.00,
            'total_amount' => $booking->total_amount,
            'due_date' => $resolvedDueDate,
            'status' => 'unpaid',
        ]);
    }

    /**
     * Accessor label status dalam bahasa Indonesia.
     */
    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'paid' => 'Lunas',
            'unpaid' => 'Belum Dibayar',
            'expired' => 'Kadaluarsa',
            'cancelled' => 'Dibatalkan',
            default => ucfirst((string) $this->status),
        };
    }

    /**
     * Alias total untuk kompatibilitas.
     */
    public function getTotalAttribute(): float
    {
        return (float) $this->total_amount;
    }
}
