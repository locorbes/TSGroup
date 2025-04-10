<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Auth\AuthenticationException;

use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */

    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->expectsJson()) {
            return response()->json([
                'message' => trans('auth.unauthenticated')
            ], 401);
        }

        return redirect('/'); 
    }

    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $exception)
    {
        // Error 405
        if ($exception instanceof MethodNotAllowedHttpException) {
            return response()->json([
                'error' => __('http.405')
            ], 405);
        }

        // Error 404
        if ($exception instanceof NotFoundHttpException) {
            return response()->json([
                'error' => __('http.404')
            ], 404);
        }

        // Error 401
        if ($exception instanceof AuthenticationException) {
            return response()->json([
                'message' => __('messages.unauthenticated')
            ], 401);
        }
        return parent::render($request, $exception);
    }
}
