<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Illuminate\Database\QueryException;

class Handler extends ExceptionHandler
{

    public function render($request, Throwable $exception)
    {
        if (str_contains($exception->getMessage(), 'Network is unreachable')) {
            return response()->view('errors.database', [], 500);
        }
    }
}
