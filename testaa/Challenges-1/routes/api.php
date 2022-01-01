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

Route::prefix('auth')->group(function(){
    Route::post('login', 'Api\Auth\AuthController@login');
});


# Route::post('register', 'Auth\AuthController@login');
Route::group(['middleware'=>'auth:api','namespace'=>'Api'],function(){
    Route::prefix('auth')->group(function(){
        Route::post('logout', 'Auth\AuthController@logout');
        Route::get('me', 'Auth\AuthController@me');
        # Route::post('refresh', 'AuthController@refresh');
    });

    Route::prefix('admin')->as('admin.')->group(function(){
        Route::post('products/{id}','ProductController@update');
        Route::resource('products','ProductController')->except([
            'update'
        ]);
        Route::resource('barcodes','BarcodeController');
        Route::post('challenges/{id}','ChallengeController@update');
        Route::resource('challenges','ChallengeController')->except([
            'update'
        ]);
        Route::resource('kids','KidController');
        Route::get('statics','StaticsController@index');
    });

});







