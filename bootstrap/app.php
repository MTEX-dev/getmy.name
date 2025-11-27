<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
//use Throwable;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Response;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->web(append: [
            \App\Http\Middleware\SetLocale::class,
        ]);

        $middleware->api(append: [
            \App\Http\Middleware\LogApiRequests::class,
            \App\Http\Middleware\LogApiTokenUsage::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->renderable(function (ValidationException $e, Request $request) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'The given data was invalid.',
                    'errors' => $e->errors(),
                ], 422);
            }
            return back()->withInput($request->except(['password', 'password_confirmation']))
                ->withErrors($e->errors());
        });

        $exceptions->renderable(function (HttpException $e, Request $request) {
            $statusCode = $e->getStatusCode();
            $exceptionName = class_basename($e);

            if (view()->exists("pages.errors.{$statusCode}")) {
                return response()->view("pages.errors.{$statusCode}", ['exception' => $e], $statusCode);
            }

            if (view()->exists("pages.errors")) {
                return response()->view("pages.errors", ['exception' => $e], $statusCode);
            }

            if ($request->expectsJson()) {
                return response()->json(['message' => $e->getMessage()], $statusCode);
            }

            return response()->view('pages.errors.general', ['exception' => $e], $statusCode);
        });

        $exceptions->renderable(function (Throwable $e, Request $request) {
            if ($request->expectsJson()) {
                return response()->json(['message' => $e->getMessage()], 500);
            }

            if (view()->exists("pages.errors.general")) {
                return response()->view("pages.errors.general", ['exception' => $e], 500);
            }

            return response('An unexpected error occurred.', 500);
        });
    })->create();