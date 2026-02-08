<?php

namespace App\Policies;
use App\Models\Produk;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ProdukPolicy
{
    public function viewAny(User $user)
    {
        return $user->role === 'admin';
    }

    public function update(User $user, Produk $produk)
    {
        return $user->role === 'admin';
    }

    public function delete(User $user, Produk $produk)
    {
        return $user->role === 'admin';
    }
    
}


