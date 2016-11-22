<?php

Route::group(['prefix' => '/api/menu/', 'middleware' => ['web']], function () {
    Route::get('/{menu_name}', 'ApiController@index');
});