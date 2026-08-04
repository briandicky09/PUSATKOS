<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = [
        'customer_id',
        'kos_id',
        'invoice_number',
        'amount',
        'status',
        'due_date',
        'paid_at',
    ];
}
