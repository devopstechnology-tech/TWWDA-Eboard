<?php

declare(strict_types=1);

namespace App\Traits;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

trait RendersJsonResponses
{
    protected function getSafeMessage(?string $safeMessage = null): string
    {
        if (isset($safeMessage) && config('app.debug') === false) {
            return $safeMessage;
        }

        return $this->getMessage();
    }

    protected function getErrorKey(int $statusCode): string
    {
        $statusText = Arr::get(JsonResponse::$statusTexts, $statusCode, 'error');
        $statusText = Str::lower($statusText);

        return Str::slug($statusText, '_');
    }

    protected function jsonResponse(
        int|string $key,
        int|string $code = null,
        string $message = null
    ): JsonResponse {
        if (func_num_args() === 1) {
            // $key === status code
            $code = $key;
            $key = $this->getErrorKey($key);
        } elseif (func_num_args() === 2 && is_int($key) && is_string($code)) {
            // $key === status code && $code === message
            $message = $code;
            $code = $key;
            $key = $this->getErrorKey($key);
        }

        return response()
            ->json([
                'error' => $key,
                'message' => $this->getSafeMessage($message),
            ])
            ->setStatusCode($code);
    }
}
