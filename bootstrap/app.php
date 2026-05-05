<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\Admin;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            "admin"=>App\Http\Middleware\Admin::class,
        ]);
    })
        ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            "user"=>App\Http\Middleware\UserMiddleware::class,
        ]);

    })
        ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
           "log"=>App\Http\Middleware\LogMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
