<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))

    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )

    ->withMiddleware(function (Middleware $middleware) {

        $middleware->alias([
            'role' => \Spatie\Permission\Middleware\RoleMiddleware::class,
            'permission' => \Spatie\Permission\Middleware\PermissionMiddleware::class,
            'role_or_permission' => \Spatie\Permission\Middleware\RoleOrPermissionMiddleware::class,
        ]);

        $middleware->validateCsrfTokens(except: [
            'rfid/scan',
        ]);

        $middleware->trustHosts(at: ['localhost', '127.0.0.1', '::1']);
    })

    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (Spatie\Permission\Exceptions\UnauthorizedException $e) {
            if (request()->expectsJson()) {
                return response()->json(['success' => false, 'message' => 'Anda tidak memiliki akses ke halaman ini'], 403);
            }
            return response()->view('errors.403', [], 403);
        });
    })->create();
