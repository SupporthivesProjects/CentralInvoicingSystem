<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Illuminate\Database\QueryException;

class Handler extends ExceptionHandler
{
    protected $levels = [
       
    ];

    protected $dontReport = [
        \Illuminate\Auth\AuthenticationException::class,
        \Illuminate\Database\Eloquent\ModelNotFoundException::class,
        \Illuminate\Session\TokenMismatchException::class,
        \Symfony\Component\HttpKernel\Exception\NotFoundHttpException::class,
        \Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException::class,
        \Symfony\Component\HttpKernel\Exception\HttpException::class,
        \Illuminate\Validation\ValidationException::class,
    ];

    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            // Log the exception or perform any other action
        });
    }

    public function render($request, Throwable $exception)
    {
        if ($exception instanceof QueryException && str_contains($exception->getMessage(), '2002')) {
            return response()->view('errors.database', [], 500);
        }

        return parent::render($request, $exception);
    }
}
