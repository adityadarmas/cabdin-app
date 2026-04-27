<?php

namespace App\Policies;

use App\Models\SuratKeluar;
use App\Models\User;

class SuratKeluarPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->role !== 'operator';
    }

    public function create(User $user): bool
    {
        return $user->role !== 'operator';
    }

    public function update(User $user, SuratKeluar $suratKeluar): bool
    {
        if ($user->role === 'operator') return false;
        return in_array($user->role, ['admin', 'tu']) || $user->id === $suratKeluar->user_id;
    }

    public function delete(User $user, SuratKeluar $suratKeluar): bool
    {
        if ($user->role === 'operator') return false;
        return in_array($user->role, ['admin', 'tu']) || $user->id === $suratKeluar->user_id;
    }
}
