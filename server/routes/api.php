<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['middleware' => 'api', 'prefix' => 'auth'], function ($router) {
    $router->post('register', 'JWTAuthController@register');
    $router->post('login', 'JWTAuthController@login');
    $router->post('logout', 'JWTAuthController@logout');
    $router->post('refresh', 'JWTAuthController@refresh');
    $router->get('profile', 'JWTAuthController@profile');
});
