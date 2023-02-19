<?php

use Illuminate\Support\Facades\Route;


Route::group(['prefix' => 'stripe'], function () {
    Route::match(['get', 'post'], 'authorize-connect', 'StripeController@authorizeConnect');
});
