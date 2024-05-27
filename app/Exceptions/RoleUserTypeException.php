<?php

declare(strict_types=1);

namespace App\Exceptions;

use App\Traits\ApiResponse;
use App\Traits\RendersJsonResponses;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Lang;
use Symfony\Component\HttpFoundation\Response;

class RoleUserTypeException extends Exception
{
    use ApiResponse;
    use RendersJsonResponses;

    public function __construct(
        protected $message,
    ) {
        parent::__construct(
            Lang::get('exceptions.role.user.types')
        );
    }

    public function render(): JsonResponse
    {
        return $this->response(
            Response::HTTP_CONFLICT,
            $this->getMessage().PHP_EOL.$this->message,
            $this->getErrorKey(Response::HTTP_CONFLICT)
        );
    }
}
