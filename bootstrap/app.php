<?php

use App\Http\Middleware\ValidateTelegramHash;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
        api: __DIR__ . '/../routes/api.php',
        apiPrefix: 'api',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->validateCsrfTokens(except: [
            'stripe/*',
            '/<token>/webhook',
        ]);
        $middleware->alias([
            'telegram.hash' => ValidateTelegramHash::class
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
