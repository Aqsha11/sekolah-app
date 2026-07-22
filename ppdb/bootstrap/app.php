<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route;

return Application::configure(basePath: dirname(__DIR__))

    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
        then: function () {
            Route::middleware('web')->group(base_path('routes/public.php'));
            Route::middleware('web')->group(base_path('routes/admin.php'));
            Route::middleware('web')->group(base_path('routes/orangtua.php'));
            Route::middleware('web')->group(base_path('routes/rfid.php'));
        },
    )

    ->withMiddleware(function (Middleware $middleware) {

        $middleware->alias([
            'role' => \Spatie\Permission\Middleware\RoleMiddleware::class,
            'permission' => \Spatie\Permission\Middleware\PermissionMiddleware::class,
            'role_or_permission' => \Spatie\Permission\Middleware\RoleOrPermissionMiddleware::class,
        ]);

        // Security headers
        $middleware->append(\App\Http\Middleware\SecurityHeaders::class);

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
