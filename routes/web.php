<?php

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

// Authentication specific routes
Auth::routes();
Route::get('logout', function() {
    Auth::logout();
    return redirect('/');
})->name('logout');

// CMS Routes, don't forget to apply middleware in the constructor
Route::get('/', 'PageController@index')->name('home');

Route::get('/product/categories', 'ProductCategoryController@index')->name('categories');

Route::get('product', 'ProductController@index')->name('products');

Route::get('settings', 'SettingsController@index')->name('settings');

Route::get('manufacturers', 'ManufacturerController@index')->name('manufacturers');
