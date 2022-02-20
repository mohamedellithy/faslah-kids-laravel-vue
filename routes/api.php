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

Route::prefix('auth')->group(function(){
    Route::post('login', 'Api\Auth\AuthController@login');
    Route::post('register', 'Api\Auth\AuthController@register');
});


# Route::post('register', 'Auth\AuthController@login');
Route::group(['namespace'=>'Api'],function(){
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
        Route::get('products-datatable','ProductController@get_products_for_datatable');


        Route::resource('barcodes','BarcodeController');

        Route::post('challenges/{id}','ChallengeController@update');
        Route::resource('challenges','ChallengeController')->except([
            'update'
        ]);

        Route::get('products/{id}/challenges','ChallengeController@challenges_of_product');
        Route::get('statics','StaticsController@index');

        Route::resource('kids','KidController');
        Route::get('my-solution/{id}','SolutionsController@get_solution_of_kid');
        Route::get('solutions/','SolutionsController@all_solutions');

        //Route::get('my-solution/{solution}','SolutionsController@my_solution');
    });

    Route::get('kid/challenge/activites','KidController@challenges_activities');
    Route::resource('challenges','ChallengeController')->only([
        'show'
    ]);

    Route::get('others/solutions/challenges','SolutionsController@kids_solutions');
    Route::post('attach/solution/challenge','SolutionsController@attach_solution');
    

    Route::get('challenge/page/{id}','KidController@get_my_challenges');
    Route::resource('kids','KidController')->except([
        'update'
    ]);
    Route::post('kids/{id}','KidController@update');

});







