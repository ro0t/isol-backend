<?php

use Illuminate\Http\Request;

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

Route::get('products', 'Api\ProductController@list');
Route::get('products/{id}', 'Api\ProductController@detail');
Route::get('categories', 'Api\ProductController@categories');
Route::get('manufacturers', 'Api\ManufacturerController@list');
Route::get('pages/{slug}', 'Api\PageController@getContent');

Route::get('news', 'Api\NewsController@latestNews');
Route::get('news/all', 'Api\NewsController@allNews');
Route::get('news/{slug}', 'Api\NewsController@detail');
