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
        ]);
        $middleware->web(append: [
            \App\Http\Middleware\TrackSiteVisit::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (\Spatie\Permission\Exceptions\UnauthorizedException $e, $request) {
            if ($request->user() && $request->user()->hasRole('student')) {
                return redirect('/');
            }
            abort(403, $e->getMessage());
        });
        
        // Custom error pages
        $exceptions->render(function (\Symfony\Component\HttpKernel\Exception\NotFoundHttpException $e, $request) {
            return response()->view('errors.404', [], 404);
        });
        
        $exceptions->render(function (\Symfony\Component\HttpKernel\Exception\HttpException $e, $request) {
            if ($e->getStatusCode() == 500) {
                return response()->view('errors.500', [], 500);
            }
            if ($e->getStatusCode() == 403) {
                return response()->view('errors.403', [], 403);
            }
        });
    })->create();
