<?php

declare(strict_types=1);

namespace Whodoku\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class UseWhodokuDatabase
{
    public function handle(Request $request, Closure $next): Response
    {
        $originalConnection = DB::getDefaultConnection();
        DB::setDefaultConnection('whodoku');

        try {
            return $next($request);
        } finally {
            DB::setDefaultConnection($originalConnection);
        }
    }
}
