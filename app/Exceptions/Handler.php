<?php

declare(strict_types=1);

namespace App\Exceptions;

use App\Traits\ApiResponse;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Translation\Exception\NotFoundResourceException;
use Throwable;

//use Illuminate\Support\Facades\Http;

class Handler extends ExceptionHandler
{
    use ApiResponse;

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];
    protected $dontReport = [];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            // $url = 'https://hooks.slack.com/services/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';
            // $data_string = [
            //     'text' => "*Alert Alert! Exception!!* \n\n".$e->getMessage().' in file '.$e->getFile().' at line '.$e->getLine(),
            //     'mrkdwn' => true,
            // ];
            // Http::post($url, $data_string)->json();
        });
        $this->renderable(function (AuthenticationException $ex) {
            return $this->authenticationError($ex->getMessage());
        });
        $this->renderable(function (DecryptException $ex) {
            return $this->authenticationError($ex->getMessage());
        });
        $this->renderable(function (ValidationException $ex) {
            return $this->validationError($ex->errors());
        });
        $this->renderable(function (AccessDeniedHttpException|AuthorizationException $ex) {
            if ($ex instanceof AccessDeniedHttpException) {
                return $this->accessError($ex->getMessage());
            }
            if ($ex->getStatusCode() === Response::HTTP_FORBIDDEN) {
                return $this->authorizationError($ex->getMessage());
            }
        });
        $this->renderable(function (NotFoundHttpException|NotFoundResourceException|ModelNotFoundException $ex) {
            if ($ex->getStatusCode() === Response::HTTP_NOT_FOUND) {
                return $this->error(
                    Response::HTTP_NOT_FOUND,
                    'Resource not Found',
                    $ex->getMessage()
                );
            }
        });
        $this->renderable(function (QueryException $ex) {

            DB::rollBack();

            return $this->queryError($ex);
        });

        //** ALWAYS KEEP THIS SECTION AT THE BOTTOM OF THIS FILE */
        $this->renderable(function (Throwable $ex) {
            return $this->serverError();
        });
    }
}
