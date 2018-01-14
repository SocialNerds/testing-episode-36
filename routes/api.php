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

Route::middleware(['api'])->group(function () {
    Route::get('/books', 'BookController@all');
    Route::get('/books/{id}', 'BookController@get');
    Route::post('/books', 'BookController@create');
    Route::delete('/books/{id}', 'BookController@delete');

    Route::get('/favorites', 'FavoritesController@userFavorites');
    Route::get('/favorites/{id}', 'FavoritesController@get');
    Route::post('/favorites', 'FavoritesController@create');
    Route::delete('/favorites/{id}', 'FavoritesController@delete');
});