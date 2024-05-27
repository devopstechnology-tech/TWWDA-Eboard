<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Traits\ApiResponse;
use Closure;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerifyEmail
{
    use ApiResponse;

    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->user()) {
            throw new AuthenticationException();
        }

        if (auth()->user()->hasVerifiedEmail()) {

            return $next($request);
        }

        return $this->response(Response::HTTP_UNAUTHORIZED, __('messages.email_not_verified'), null);
    }
}
