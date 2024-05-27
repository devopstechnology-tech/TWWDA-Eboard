<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Traits\ApiResponse;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    use ApiResponse;
    protected function redirectTo($request): ?string
    {
        if (!$request->expectsJson()) {
            return route('login');
        }

        return null;
    }

    protected function unauthenticated($request, array $guards)
    {
        return $this->authenticationError();
    }
}
