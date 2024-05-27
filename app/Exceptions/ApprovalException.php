<?php

declare(strict_types=1);

namespace App\Exceptions;

use App\Traits\ApiResponse;
use App\Traits\RendersJsonResponses;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Lang;

class ApprovalException extends Exception
{
    use ApiResponse;
    use RendersJsonResponses;

    public function __construct(
        protected string $name,
    ) {
        parent::__construct(
            Lang::get('exceptions.approval.error', ['name' => $this->name])
        );
    }

    public function render(): JsonResponse
    {
        return $this->response(Response::HTTP_CONFLICT, $this->getMessage(), $this->getErrorKey(Response::HTTP_CONFLICT));

    }
}
