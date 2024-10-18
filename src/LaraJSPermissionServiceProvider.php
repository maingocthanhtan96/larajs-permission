<?php

namespace LaraJS\Permission;

use Illuminate\Routing\Events\RouteMatched;
use Illuminate\Support\ServiceProvider;
use Spatie\Permission\Middleware\PermissionMiddleware;
use Spatie\Permission\Middleware\RoleMiddleware;
use Spatie\Permission\Middleware\RoleOrPermissionMiddleware;

class LaraJSPermissionServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     */
    protected bool $defer = false;

    public function boot()
    {
        \Event::listen(RouteMatched::class, function () {
            $router = $this->app['router'];
            $router->aliasMiddleware('role', RoleMiddleware::class);
            $router->aliasMiddleware('permission', PermissionMiddleware::class);
            $router->aliasMiddleware('role_or_permission', RoleOrPermissionMiddleware::class);
        });
    }

    public function register()
    {
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        $this->loadRoutesFrom(__DIR__.'/../routes/api-v1.php');
        $this->mergeConfigFrom(__DIR__.'/../config/permission.php', 'permission');
    }
}
