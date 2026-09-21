<?php

namespace App\Policies;

use App\Models\Booking;
use App\Models\User;

class BookingPolicy
{
    /**
     * Tentukan apakah user dapat melihat detail booking.
     */
    public function view(User $user, Booking $booking): bool
    {
        // Customer hanya boleh melihat booking miliknya sendiri
        if ($user->isCustomer() && (int) $user->id === (int) $booking->customer_id) {
            return true;
        }

        // Owner hanya boleh melihat booking yang masuk ke kos miliknya
        if ($user->isOwner() && $booking->kos && (int) $user->id === (int) $booking->kos->owner_id) {
            return true;
        }

        return false;
    }

    /**
     * Tentukan apakah user dapat membuat booking baru.
     * Hanya role customer yang berhak membuat booking.
     */
    public function create(User $user): bool
    {
        return $user->isCustomer();
    }
}
