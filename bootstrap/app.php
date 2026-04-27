<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'role' => \App\Http\Middleware\RoleMiddleware::class,
        ]);

        // Redirect user yang sudah login saat mengakses route 'guest' (login/register)
        $middleware->redirectUsersTo(function () {
            $role = auth()->user()?->role;
            return match ($role) {
                'admin'    => route('admin.users.index'),
                'operator' => route('operator.produk.index'),
                default    => route('surat-masuk.index'),
            };
        });
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
