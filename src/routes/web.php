<?php

Route::group(['prefix' => '/api/menu/'], function () {
    Route::get('/{menu_name}', 'ApiController@index');
});