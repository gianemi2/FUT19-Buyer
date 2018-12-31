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

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/

Route::get('transactions', 'Api\TransactionsController@index');
Route::get('transactions/{id}', 'Api\TransactionsController@show');

Route::get('players', 'Api\PlayersController@index');
Route::get('players/trashed', 'Api\PlayersController@all');

Route::get('accounts', 'Api\AccountsController@index');
Route::put('accounts/{id}', 'Api\AccountsController@update');

Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {

    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');

});
