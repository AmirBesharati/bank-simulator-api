<?php

use App\Http\Controllers\Api\V1\AccountController;
use App\Http\Controllers\Api\V1\AccountTypeController;
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\TransactionController;
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

            Route::group(['prefix' => 'account' , 'as' => 'account.'] , function (){
                Route::group(['prefix' => 'type' , 'as' => 'type.'] , function (){
                    Route::get('list' , [AccountTypeController::class , 'list'])->name('list');
                });
                Route::post('create' , [AccountController::class , 'create'])->name('create');
            });

            Route::group(['prefix' => 'transaction' , 'as' => 'transaction.'] , function (){
                Route::post('create' , [TransactionController::class , 'create'])->name('create');
                Route::get('detail' , [TransactionController::class , 'detail'])->name('detail');
                Route::get('history' , [TransactionController::class , 'history'])->name('history');

            });

        });

    });

});



Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
