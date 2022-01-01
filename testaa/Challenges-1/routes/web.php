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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::prefix('admin')->as('admin.')->group(function(){
    Route::get('admin/login','admin\AdminController@login');

    Route::any('/{page}/{sub_pages?}/{sub_sub_pages?}/{id?}', function($page,$sub_pages = null,$sub_sub_pages=null,$id=null) {
        return view('admin.master');
    })->where(['page' => '.*','sub_pagess'=>'.*','sub_sub_pages'=>'.*','id'=>'0-9']);

});
