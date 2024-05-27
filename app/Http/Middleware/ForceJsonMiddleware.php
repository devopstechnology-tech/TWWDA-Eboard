<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ForceJsonMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param Closure(Request): (Response|RedirectResponse) $next
     */
    public function handle(Request $request, Closure $next): mixed
    {
        if ($request->header('Accept') != 'application/json') {
            $request->headers->set('Accept', 'application/json');
        }

        return $next($request);
    }
}
