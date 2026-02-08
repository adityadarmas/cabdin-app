<?php

namespace App\Policies;

use App\Models\SuratMasuk;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class SuratMasukPolicy
{
    public function viewAny(User $user)
    {
        return in_array($user->role, ['tu', 'staff', 'pimpinan']);
    }

    
    public function view(User $user, SuratMasuk $surat)
    {
        return $user->role === 'staff'
            ? $surat->user_id === $user->id
            : true;
    }

    public function create(User $user)
    {
        return in_array($user->role, ['staff', 'tu', 'admin']);
    }

    public function update(User $user, SuratMasuk $surat)
    {
        // TU boleh edit semua
        if ($user->role === 'tu') {
            return true;
        }

        // Pimpinan hanya boleh disposisi
        if ($user->role === 'pimpinan') {
            return true;
        }

        return false;
    }

    public function delete(User $user, SuratMasuk $surat)
    {
        return $user->role === 'tu';
    }

    // khusus pimpinan
    public function disposisi(User $user, SuratMasuk $surat): bool
    {
        return $user->role === 'pimpinan';
    }

    //khusus staff
    public function viewAssigned(User $user, SuratMasuk $surat)
    {
    return $user->role === 'staff'
        && $surat->user_id === $user->id;
    }

}

