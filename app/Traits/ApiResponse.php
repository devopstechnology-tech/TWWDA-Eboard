<?php

declare(strict_types=1);

namespace App\Traits;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Traits\LogsActivity;
use Symfony\Component\HttpFoundation\Response;

trait ApiResponse
{
    use LogsActivity;
    use Loggable;

    /**
     * Send a JSON response and optional Log a "view" activity.
     *
     * @param null $data
     * @param null $class
     */
    public function response(int $status, string $message, $data = null, $class = null, $headers = []): JsonResponse
    {
        if (!is_null($class)) {
            $array = explode('\\', $class);
            $className = end($array);
            activity($className)
                ->event('viewed')
                ->performedOn(new $class())
                ->causedBy(Auth::user())
                ->withProperties(['attributes' => $data])
                ->log($className.' viewed');
        }

        return response()->json([
            'message' => $message,
            'data' => $data,
            'code' => $status,
        ], $status, $headers);
    }


    /**
     * Handles an authorization error.
     *
     * @param null $message
     */
    public function authorizationError($message = null): JsonResponse
    {
        return $this->error(Response::HTTP_FORBIDDEN, 'Authorization Failed', $message);
    }

    /**
     * Sends a JSON error response.
     *ActivityLogv1
     * @param null $errors
     */
    public function error($status, $message, $errors = null): JsonResponse
    {
        return response()->json([
            'message' => $message,
            'errors' => $errors,
            'code' => $status,
        ], $status);
    }

    public function accessError($message = null): JsonResponse
    {
        return $this->error(Response::HTTP_FORBIDDEN, 'Access Denied', $message);
    }

    /**
     * Handles an authentication error.
     *
     * @param null $message
     */
    public function authenticationError($message = null): JsonResponse
    {
        return $this->error(Response::HTTP_UNAUTHORIZED, 'Authentication Failed', $message);
    }

    /**
     * Handles a validation error.
     */
    public function validationError($errors): JsonResponse
    {
        return $this->error(Response::HTTP_UNPROCESSABLE_ENTITY, 'Validation error', $errors);
    }

    /**
     * Handles a server error.
     */
    public function serverError(): JsonResponse
    {
        return $this->error(Response::HTTP_INTERNAL_SERVER_ERROR, 'Internal server error occured');
    }

    /**
     * Handles a query  error.
     */
    public function queryError($e): JsonResponse
    {
        $integrityConstraintViolation = 1451;
        if ($e->errorInfo[1] == $integrityConstraintViolation) {
            $message = 'Cannot proceed with query, it is referenced by other records in the database.';
        } else {
            $message = 'Could not execute query '.App::environment('production') ? '' : $e->errorInfo[2];
        }

        return $this->error(Response::HTTP_NOT_ACCEPTABLE, 'Data Integrity Error', $message);
    }
}