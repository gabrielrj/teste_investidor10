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

Route::get('/teste', function(){
    return 'teste';
});

Route::post('/login', [\App\Http\Controllers\Auth\JWTAuthController::class, 'login']);

Route::middleware('jwt.auth')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::controller(\App\Http\Controllers\UserController::class)->group(function (){
        Route::get('/users/all', 'getAllUsers');
        Route::post('/users/store', 'createNewUser');
        Route::put('/users/update/{id}', 'updateUser');
        Route::delete('/users/delete/{id}', 'deleteUser');
    });

    Route::controller(\App\Http\Controllers\NewsController::class)->group(function (){
        Route::get('/news/categories/all', 'getAllCategories');
        Route::get('/news/all/{categoryId?}/{newsTitle?}/{regsByPage?}/{page?}', 'getAllNews');
        Route::get('/news/show/{id}', 'findNewsByCode');
        Route::post('/news/store', 'createNewNews');
        Route::put('/news/update/{id}', 'updateNews');
        Route::delete('/news/delete/{id}', 'deleteNews');
    });

    Route::post('/logout', [\App\Http\Controllers\Auth\JWTAuthController::class, 'logout']);
});
