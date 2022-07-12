<?php

use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\UserController;
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

Route::middleware(['api'])->group(function () {

    Route::group(['prefix' => 'v1', 'namespace' => 'Api\V1', 'as' => 'api.v1.'], function (){


        Route::group(['prefix' => 'auth' , 'as' => 'auth.'] , function (){
            Route::post('register' , [AuthController::class , 'register'])->name('register');
            Route::post('login' , [AuthController::class , 'login'])->name('login');
        });


        Route::group(['middleware' => 'auth:sanctum'] , function (){

            Route::group(['prefix' => 'user' , 'as' => 'user.'] , function (){
                Route::get('/' , [UserController::class , 'user'])->name('user');
            });

        });

    });

});



Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
