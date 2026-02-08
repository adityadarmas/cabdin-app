<?php

namespace App\Policies;

use App\Models\SuratKeluar;
use App\Models\User;

class SuratKeluarPolicy
{
    public function view(User $user, SuratKeluar $surat)
    {
        return $user->id === $surat->user_id || $user->role !== 'staff';
    }

    public function update(User $user, SuratKeluar $surat)
    {
        return $user->id === $surat->user_id && $surat->status === 'draft';
    }

    public function ajukan(User $user, SuratKeluar $surat)
    {
        return $user->id === $surat->user_id && $surat->status === 'draft';
    }

    public function approve(User $user, SuratKeluar $surat)
    {
        return $user->role === 'pimpinan'
            && $surat->status === 'menunggu_persetujuan';
    }
}
