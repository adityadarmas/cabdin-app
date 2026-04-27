<?php

namespace App\Providers;

use App\Models\Produk;
use App\Models\SuratKeluar;
use App\Models\SuratMasuk;
use App\Policies\ProdukPolicy;
use App\Policies\SuratKeluarPolicy;
use App\Policies\SuratMasukPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        SuratMasuk::class  => SuratMasukPolicy::class,
        SuratKeluar::class => SuratKeluarPolicy::class,
        Produk::class      => ProdukPolicy::class,
    ];

    public function boot(): void
    {
        $this->registerPolicies();
    }
}
