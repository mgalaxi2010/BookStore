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
Route::prefix('books')->group(function (){

    Route::get('', 'BooksController@getCollection');

    Route::middleware(['auth','check.token'])->group(function () {

        Route::post('', 'BooksController@post')->middleware('auth.admin');
        Route::post('{book}/reviews', 'BooksController@postReview');

    });
});

