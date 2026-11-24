<?php

declare(strict_types=1);

namespace Whodoku\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Symfony\Component\HttpFoundation\Response;

class UseWhodokuRootView
{
    public function handle(Request $request, Closure $next): Response
    {
        Inertia::setRootView(config('whodoku.root_view', 'whodoku::whodoku'));

        return $next($request);
    }
}
