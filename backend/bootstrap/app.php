<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->web(append: \App\Http\Middleware\SeoMiddleware::class);
        $middleware->throttleApi(60);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (\Throwable $e, Request $request) {
            if (!($request->wantsJson() || $request->is('api/*'))) {
                return null;
            }

            $status = 500;
            $message = 'Server Error';

            if ($e instanceof \Illuminate\Database\Eloquent\ModelNotFoundException) {
                $status = 404;
                $message = 'Resource not found.';
            } elseif ($e instanceof \Illuminate\Validation\ValidationException) {
                $status = 422;
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed.',
                    'errors' => $e->errors(),
                ], $status);
            } elseif ($e instanceof \Symfony\Component\HttpKernel\Exception\HttpException) {
                $status = $e->getStatusCode();
                $message = $e->getMessage() ?: 'Error';
            }

            return response()->json([
                'success' => false,
                'message' => $message,
            ], $status);
        });
    })->create();
