#Menu db for lavary/laravel-menu

##Insatlation

Install lavary/laravel-menu -> https://github.com/lavary/laravel-menu

```
    composer require hobord/menu_db
```

Now, append service provider to providers array in config/app.php.

```
<?php

'providers' => [

        /*
         * Laravel Framework Service Providers...
         */
        Illuminate\Foundation\Providers\ArtisanServiceProvider::class,
        Illuminate\Auth\AuthServiceProvider::class,
        Illuminate\Broadcasting\BroadcastServiceProvider::class,

        ...
        'Lavary\Menu\ServiceProvider',
        ...
        Hobord\MenuDb\MenuDbServiceProvider::class,
        ...
        
        ],
?>
```

Publish the migration:

```
    php artisan vendor:publish
    composer dump-autoload
```

Create the tables:

```
    php artisan migrate
```