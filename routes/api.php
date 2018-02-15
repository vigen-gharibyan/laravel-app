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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'v1'], function()
{
    Route::resource('items', 'ItemController', [
        'except' => []
    ]);

    Route::resource('posts', 'PostController');
});

Route::post('users/register', 'UserController@create');
Route::post('users/authenticate', 'UserController@authenticate');
Route::put('users/update/{id}', 'UserController@update');
Route::get('users/checkEmail/{email}', 'UserController@checkEmail');

