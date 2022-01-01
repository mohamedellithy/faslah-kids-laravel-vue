<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

# Route::get('/', function () {
#     return view('welcome');
# });

# Auth::routes();

# Authentication Routes...
# Route::get('login/{barcode?}', 'Auth\LoginController@showLoginForm')->name('login');

#  Registration Routes...
# Route::get('register/{barcode}', 'Auth\RegisterController@showRegistrationForm')->name('register');
# Route::post('register/{barcode}', 'Auth\RegisterController@register');



Route::get('/home', 'HomeController@index')->name('home');

Route::prefix('admin')->as('admin.')->group(function(){
    Route::get('admin/login','admin\AdminController@login');
    Route::any('/{page}/{sub_pages?}/{sub_sub_pages?}/{id?}', function($page,$sub_pages = null,$sub_sub_pages=null,$id=null) {
        return view('admin.master');
    })->where(['page' => '.*','sub_pagess'=>'.*','sub_sub_pages'=>'.*','id'=>'0-9']);
});


# Route::middleware('auth')->group(function(){
    Route::any('/{page}/{id?}', function($page) {
        return view('user.master');
    })->where(['page' => '.*','id'=>'0-9']);
# });
