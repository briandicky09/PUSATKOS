<?php

namespace App\Policies;

use App\Models\Kos;
use App\Models\User;

class KosPolicy
{
    /**
     * Tentukan apakah user dapat melihat daftar kos miliknya.
     */
    public function viewAny(User $user): bool
    {
        return $user->isOwner();
    }

    /**
     * Tentukan apakah user dapat melihat detail pengelolaan kos ini.
     */
    public function view(User $user, Kos $kos): bool
    {
        return $user->isOwner() && (int) $user->id === (int) $kos->owner_id;
    }

    /**
     * Tentukan apakah user dapat membuat kos baru.
     */
    public function create(User $user): bool
    {
        return $user->isOwner();
    }

    /**
     * Tentukan apakah user dapat mengedit/mengubah data kos ini.
     */
    public function update(User $user, Kos $kos): bool
    {
        return $user->isOwner() && (int) $user->id === (int) $kos->owner_id;
    }

    /**
     * Tentukan apakah user dapat menghapus kos ini.
     */
    public function delete(User $user, Kos $kos): bool
    {
        return $user->isOwner() && (int) $user->id === (int) $kos->owner_id;
    }

    /**
     * Tentukan apakah user dapat me-restore kos yang dihapus.
     */
    public function restore(User $user, Kos $kos): bool
    {
        return $user->isOwner() && (int) $user->id === (int) $kos->owner_id;
    }

    /**
     * Tentukan apakah user dapat menghapus permanen kos.
     */
    public function forceDelete(User $user, Kos $kos): bool
    {
        return $user->isOwner() && (int) $user->id === (int) $kos->owner_id;
    }
}
