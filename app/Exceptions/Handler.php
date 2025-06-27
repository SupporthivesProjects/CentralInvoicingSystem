<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Illuminate\Database\QueryException;

class Handler extends ExceptionHandler
{

    public function render($request, Throwable $exception)
    {
        $message = $exception->getMessage();
    
        if (str_contains($message, 'Network is unreachable') || 
            str_contains($message, 'Connection refused') ||
            str_contains($message, 'Class') && str_contains($message, 'not found')) {
            return response()->view('errors.database', [], 500);
        }
    
        return parent::render($request, $exception);
    }
    
}
