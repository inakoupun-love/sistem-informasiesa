<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

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

        // Percayai proxy (ngrok, Cloudflare, load balancer) agar Laravel
        // mendeteksi skema HTTPS dari header X-Forwarded-Proto.
        $middleware->trustProxies(at: '*');
        
        $middleware->redirectGuestsTo(function (Request $request) {
            if ($request->is('admin*')) {
                return route('login.admin');
            }
            if ($request->is('kepala-desa*')) {
                return route('login.kepala_desa');
            }
            return route('login.masyarakat');
        });
        
        $middleware->redirectUsersTo(function (Request $request) {
            return route('dashboard.redirect');
        });
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*'),
        );
    })->create();
