<?php

declare(strict_types=1);

namespace App\Exceptions;

use App\Traits\ApiResponse;
use App\Traits\RendersJsonResponses;
use Exception;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class RolePermissionTypeException extends Exception
{
    use ApiResponse;
    use RendersJsonResponses;

    public function __construct(
        protected $message,
    ) {
        parent::__construct(
            $this->message
        );
    }

    public function render(): JsonResponse
    {
        return $this->response(
            Response::HTTP_CONFLICT,
            $this->message,
            $this->getErrorKey(Response::HTTP_CONFLICT)
        );
    }
}
