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
Route::get('sitemap.xml', 'MiscController@generateSitemap');

// Authentication specific routes
Auth::routes();

Route::get('logout', function() {
    Auth::logout();
    return redirect('/');
})->name('logout');

Route::get('/', 'PageController@index')->name('home');

Route::post('/utility/uploadPhoto', 'UtilityController@uploadPhoto');

Route::group(['prefix' => 'pages'], function() {

    Route::get('edit/{id}', 'PageController@edit')->name('page.edit');
    Route::get('edit/special/{layout}', 'PageController@editSpecial')->name('page.edit.special');
    Route::get('frontpage/edit', 'FrontpageController@editFrontpage')->name('frontpage');
    Route::get('seo/{id}', 'PageController@seo')->name('page.seo');
    Route::get('deleteImage/{id}', 'PageController@deleteImage');

    Route::post('images/{id}', 'PageController@addImages')->name('page.images');
    Route::post('edit/{id}', 'PageController@change');
    Route::post('seo/{id}', 'PageController@changeSeo');
    Route::post('frontpage/edit/{moduleId}', 'FrontpageController@updateModule');
    Route::post('frontpage/order/{rowId}', 'FrontpageController@updateModulePositions');
    Route::post('frontpage/slideshow/upload', 'FrontpageController@addImages')->name('frontpage.slideshow.upload');

});

Route::group([ 'prefix' => 'employees'], function() {

    Route::get('/', 'EmployeesController@index')->name('employees');
    Route::get('new', 'EmployeesController@create')->name('employees.new');
    Route::get('edit/{id}', 'EmployeesController@edit')->name('employees.edit');
    Route::get('delete/{id}', 'EmployeesController@delete')->name('employees.delete');

    Route::post('new', 'EmployeesController@createNew');
    Route::post('edit/{id}', 'EmployeesController@change');

});

Route::group(['prefix' => 'news'], function() {

    Route::get('/', 'NewsController@index')->name('news');
    Route::get('new', 'NewsController@create')->name('news.new');
    Route::get('edit/{id}', 'NewsController@edit')->name('news.edit');
    Route::get('delete/{id}', 'NewsController@delete')->name('news.delete');

    Route::post('new', 'NewsController@createNew');
    Route::post('edit/{id}', 'NewsController@change');

});

Route::group(['prefix' => 'users'], function() {

    Route::get('/', 'UserController@index')->name('users');
    Route::get('new', 'UserController@create')->name('users.new');
    Route::get('edit/{id}', 'UserController@edit')->name('users.edit');
    Route::get('delete/{id}', 'UserController@delete')->name('users.delete');

    Route::post('new', 'UserController@createNew');
    Route::post('edit/{id}', 'UserController@change');

});

Route::group([ 'prefix' => 'categories' ], function() {

    Route::get('/', 'ProductCategoryController@index')->name('categories');
    Route::get('depth/{categoryId}', 'ProductCategoryController@indexWithDepth')->name('categories.depth');
    Route::get('order/menu/{parentId}', 'ProductCategoryController@orderMenuItems')->name('categories.orderMenu');

    Route::get('edit/{id}', 'ProductCategoryController@edit')->name('categories.edit');
    Route::get('delete/{id}', 'ProductCategoryController@delete')->name('categories.delete');
    Route::get('new', 'ProductCategoryController@create')->name('categories.new');

    Route::post('new', 'ProductCategoryController@createNew');
    Route::post('edit/{id}', 'ProductCategoryController@change');
    Route::post('showWebsite/{id}', 'ProductCategoryController@setWebsiteVisibility')->name('categories.setWebsiteVisibility');
    Route::post('showMenu/{id}', 'ProductCategoryController@setMenuVisibility')->name('categories.setMenuVisibility');
    Route::post('order/menu', 'ProductCategoryController@orderMenuItemsPost');

});

Route::group(['prefix' => 'product'], function() {

    Route::get('/', 'ProductController@index')->name('products');
    Route::get('new', 'ProductController@create')->name('products.new');
    Route::get('edit/{id}', 'ProductController@edit')->name('products.edit');

    Route::get('delete/{id}', 'ProductController@delete')->name('products.delete');
    Route::get('autosearch/navision', 'ProductController@navision')->name('products.autosearch.navision');
    Route::get('deleteImage/{id}', 'ProductController@deleteImage');
    Route::get('deleteSizes/{id}', 'ProductController@removeProductSizes')->name('products.sizes.delete');

    Route::get('sync/all-products', 'DynamicsController@fullSync')->name('products.sync.all');
    Route::get('sync/{id}', 'DynamicsController@singleSync')->name('products.sync');

    Route::post('new', 'ProductController@createNew');
    Route::post('edit/{id}', 'ProductController@change');
    Route::post('showWebsite/{id}', 'ProductController@setWebsiteVisibility')->name('products.setWebsiteVisibility');
    Route::post('showPrice/{id}', 'ProductController@setShowPrice')->name('products.setShowPrice');
    Route::post('set-featured/{id}', 'ProductController@setFeaturedProduct')->name('products.setFeatured');
    Route::post('images/{id}', 'ProductController@addImages')->name('products.images');
    Route::post('setMainImage/{id}', 'ProductController@setMainImage');
});

Route::group(['prefix' => 'settings'], function() {
    Route::get('/', 'SettingsController@index')->name('settings');
    Route::post('/', 'SettingsController@save');
    Route::post('dynamics-nav', 'DynamicsController@sync');
});

Route::group(['prefix' => 'manufacturers'], function() {

    Route::get('/', 'ManufacturerController@index')->name('manufacturers');
    Route::get('new', 'ManufacturerController@create')->name('manufacturers.new');
    Route::get('edit/{id}', 'ManufacturerController@edit')->name('manufacturers.edit');

    Route::post('new', 'ManufacturerController@createNew');
    Route::post('edit/{id}', 'ManufacturerController@change');
    Route::post('setActive/{id}', 'ManufacturerController@setActive')->name('manufacturers.setActive');

});

//Route::get('manufacturers', 'ManufacturerController@index')->name('manufacturers');
