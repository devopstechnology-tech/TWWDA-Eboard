<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Traits\ApiResponse;
use Closure;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class DecryptToken
{
    use ApiResponse;

    public function handle(Request $request, Closure $next): mixed
    {
        try {
            $decryptedToken = Crypt::decryptString($request->bearerToken());
            $request->headers->set('Authorization', "Bearer {$decryptedToken}");

            return $next($request);
        } catch (DecryptException $e) {
            //            throw new DecryptException($e->getMessage());
            $response = [
                'code' => 401,
                'error' => 'Token not provided.',
            ];

            return response()->json($response, 401);
        }
    }
}
