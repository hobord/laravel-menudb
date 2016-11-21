<?php

namespace Hobord\MenuDb;

use Illuminate\Support\ServiceProvider;
use Hobord\MenuDb\Http\Middleware\MenuDbMiddleware;

class MenuDbServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot(\Illuminate\Routing\Router $router, \Illuminate\Contracts\Http\Kernel $kernel)
    {
        $this->publishes([
            __DIR__.'/database/migrations' => database_path('migrations'),
        ], 'migrations');

//        $kernel->pushMiddleware(MenuDbMiddleware::class);
//        $kernel->prependMiddleware(MenuDbMiddleware::class);
        $router->pushMiddlewareToGroup('web', MenuDbMiddleware::class);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

}