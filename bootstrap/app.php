<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'role'       => \Spatie\Permission\Middleware\RoleMiddleware::class,
            'permission' => \Spatie\Permission\Middleware\PermissionMiddleware::class,
            'role_or_permission' => \Spatie\Permission\Middleware\RoleOrPermissionMiddleware::class,
            'setlocale' => \App\Http\Middleware\SetLanguage::class,
        ]);
        
        $middleware->web(append: [
            \App\Http\Middleware\SetLanguage::class,
<<<<<<< HEAD
        ]);
        $middleware->web(append: [
            \App\Http\Middleware\TrackSiteVisit::class,
=======
>>>>>>> 78bdc598ddbf41bef6c09c132d718564328353e1
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (\Spatie\Permission\Exceptions\UnauthorizedException $e, $request) {
            if ($request->user() && $request->user()->hasRole('student')) {
                return redirect('/');
            }
            abort(403, $e->getMessage());
        });
    })->create();
