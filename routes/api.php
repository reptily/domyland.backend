<?php

use Illuminate\Http\Request;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post("/user", "API\UserController@register");

Route::post('/login', 'API\UserController@login');

Route::resource('/news', 'API\NewsController')->only(['index', 'show']);

Route::group(['middleware' => 'auth:api'], function () {
    Route::resource('/news', 'API\NewsController')->only(['store', 'destroy', "update"]);
    Route::get("/author/{id}", "API\NewsController@indexAuthors");

    Route::resource('/author', 'API\AuthorController')->only(['index', 'store', 'show', 'destroy']);
});
