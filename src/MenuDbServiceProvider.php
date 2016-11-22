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
        $this->setupRoutes($router);
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

    /**
     * Define the routes for the application.
     *
     * @param  \Illuminate\Routing\Router  $router
     * @return void
     */
    public function setupRoutes($router)
    {
        $router->group(['namespace' => 'Hobord\MenuDb\Http\Controllers'], function($router) {

            $router->group([
                'middleware' => 'api',
            ], function ($router) {
                include __DIR__.'/routes/api.php';
            });

        });
    }
}