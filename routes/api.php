<?php

use Illuminate\Http\Request;

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

Route::group([
  'prefix' => 'auth',
], function ($router) {
  Route::post('login', 'AuthController@login')
  ->middleware('throttle.login');
  Route::post('verify', 'AuthController@verify');
  Route::post('logout', 'AuthController@logout');
  Route::post('refresh', 'AuthController@refresh');
});

Route::group([
  'middleware' => ['auth:api'],
  'namespace'  => 'Api'
], function($router) {
    Route::resource('category', 'CategoryController', [
        'except'        =>  [
            'create', 'edit'
        ]
    ]);

});