<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Auth;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Redirect guest (belum login) ke halaman login
        $middleware->redirectGuestsTo(fn () => route('login'));

        // Redirect user terautentikasi yang mengakses halaman guest (login/register) sesuai role
        $middleware->redirectUsersTo(function () {
            if (Auth::check() && Auth::user()->role === 'owner') {
                return route('owner.dashboard');
            }

            return route('member.home');
        });
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
