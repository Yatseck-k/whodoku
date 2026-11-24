<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Middleware;
require_once __DIR__.'/../DevInertiaRequests.php';

return Application::configure(basePath: dirname(__DIR__))
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->web(append: [DevInertiaRequests::class]);
    })
    ->withProviders([Whodoku\Providers\WhodokuServiceProvider::class])
    ->withExceptions()
    ->create();
