<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Middleware\HandleCors;  // import the CORS middleware
use App\Http\Middleware\TokenAuthMiddleware;

return Application::configure(basePath: dirname(__DIR__))
  ->withRouting(
    web: __DIR__.'/../routes/web.php',
    api: __DIR__.'/../routes/api.php', 
    commands: __DIR__.'/../routes/console.php',
    health: '/up',
)
->withMiddleware(function (Middleware $middleware): void {
    // Register Laravel's built-in CORS middleware here:
    $middleware->prepend(HandleCors::class);
     $middleware->alias([
            'token.auth' => TokenAuthMiddleware::class,
        ]);
})
->withExceptions(function (Exceptions $exceptions): void {
    //
})
->create();
