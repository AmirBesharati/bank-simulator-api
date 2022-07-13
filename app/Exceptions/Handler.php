<?php

namespace App\Exceptions;

use App\Services\Api\ApiResponseServiceFacade;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    protected function unauthenticated($request, AuthenticationException $exception)
    {
        return ApiResponseServiceFacade::setStatus(config('enums.response_statuses.unauthorized'))
                ->setResultMessage(__('messages.api.auth.unauthenticated'))
                ->response();
    }

    protected function convertValidationExceptionToResponse(ValidationException $e, $request)
    {
        return ApiResponseServiceFacade::setStatus(config('enums.response_statuses.unprocessable_entity'))
            ->setResultMessage(__('messages.validation.message'))
            ->setErrors($e->errors())
            ->response();
    }

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }
}
