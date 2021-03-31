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

Route::group(['middleware' => 'api'], function ($router) {
    $router->get('menu-items', 'MenuItemController@index');

    $router->get('accounts', 'AccountController@index')->name('GET Accounts');
    $router->post('accounts', 'AccountController@store')->name('POST Account');
    $router->put('accounts/{id}', 'AccountController@update')->name('PUT Account');
    $router->delete('accounts/{id}', 'AccountController@destroy')->name('DELETE Account');

    $router->get('transaction-types', 'TransactionTypeController@index')->name('GET Transaction Types');
    $router->post('transaction-types', 'TransactionTypeController@store')->name('POST Transaction Types');
    $router->put('transaction-types/{id}', 'TransactionTypeController@update')->name('PUT Transaction Types');
    $router->delete('transaction-types/{id}', 'TransactionTypeController@destroy')->name('DELETE Transaction Types');
});
