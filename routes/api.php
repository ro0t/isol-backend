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

Route::get('categories', 'Api\CategoryController@categories');

Route::get('manufacturers', 'Api\ManufacturerController@list');

Route::get('frontpages', 'Api\PageController@frontpage');
Route::get('pages/{slug}', 'Api\PageController@getContent');

Route::get('employees', 'Api\EmployeeController@list');

Route::get('news', 'Api\NewsController@latestNews');
Route::get('news/all', 'Api\NewsController@allNews');
Route::get('news/{slug}', 'Api\NewsController@detail');

Route::get('widgets', 'Api\PageController@getContentWidgets');


/*
|--------------------------------------------------------------------------
| SEO Routes
|--------------------------------------------------------------------------
|
| Seo routes called by the frontend website go here.
|
*/
Route::get('products/sitemap', 'Api\ProductController@sitemap');
Route::get('seos/{page}', 'Api\SearchEngineOptimization@metaData');
