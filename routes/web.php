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

Route::get('/', 'HomeController@index');

Route::get('intergrate/token/{id}', 'IntergrateController@token');
Route::get('intergrate/syncprod/{id}', 'IntergrateController@syncprod');
Route::get('intergrate/getprocess', 'IntergrateController@getprocess');
Route::get('intergrate/delcategory/{id}', 'IntergrateController@delcategory');

Route::group(['prefix' => 'api/v1', 'namespace' => 'Api\v1'], function () {
	
	Route::get('/token', 'CommonApiController@token');
	Route::get('/syncprod', 'CommonApiController@syncprod');
	Route::group(['middleware' => 'jwt-auth'], function () {
    	Route::resource('/setting', 'SettingApiController');
    	Route::resource('/nuvemshop', 'NuvemShopApiController');
    });
});

// Webhooks, call from TiendaNude
Route::group(['prefix' => 'tiendanube/{nuvemShopId}/callback', 'namespace' => 'Admin'], function () {
	
	Route::get('/product/created', 'CallbackController@productCreated')->name('callback.product.created');
	Route::get('/order/created', 'CallbackController@orderCreated')->name('callback.order.created');

	Route::post('/product/created', 'CallbackController@productCreated')->name('callback.product.created');
	Route::post('/product/updated', 'CallbackController@productUpdated')->name('callback.product.updated');
	Route::post('/product/deleted', 'CallbackController@productDeleted')->name('callback.product.deleted');

	Route::post('/category/created', 'CallbackController@categoryCreated')->name('callback.category.created');
	Route::post('/category/updated', 'CallbackController@categoryUpdated')->name('callback.category.updated');
	Route::post('/category/deleted', 'CallbackController@categoryDeleted')->name('callback.category.deleted');

	Route::post('/order/created', 'CallbackController@orderCreated')->name('callback.order.created');
	Route::post('/order/updated', 'CallbackController@orderUpdated')->name('callback.order.updated');
	Route::post('/order/paid', 'CallbackController@orderPaid')->name('callback.order.paid');
	Route::post('/order/fulfilled', 'CallbackController@orderFulfilled')->name('callback.order.fulfilled');
	Route::post('/order/cancelled', 'CallbackController@orderCancelled')->name('callback.order.cancelled');
});

// Webhooks, call from TiendaNude
Route::group(['prefix' => 'callback', 'namespace' => 'Callback', 'middleware' => ['verify.webhook']], function () {
	Route::get('/order/list', 'OrderController@getList')->name('callback.order.list');
	Route::post('/order/created', 'OrderController@created')->name('callback.order.created');
	Route::post('/order/paid', 'OrderController@paid')->name('callback.order.paid');

	Route::post('/product/created', 'ProductController@created')->name('callback.product.created');
	Route::post('/product/deleted', 'ProductController@deleted')->name('callback.product.deleted');

	Route::post('/category/created', 'CategoryController@created')->name('callback.category.created');
	Route::post('/category/deleted', 'CategoryController@deleted')->name('callback.category.deleted');
});

// Webhooks, call from TiendaNude
Route::group(['prefix' => 'download', 'namespace' => 'Download'], function () {
	Route::get('/{orderId}/{productId}', 'ProductController@download')->name('download.product');
});

/**
 * Routing to admin
 */
Route::group(['middleware' => 'auth', 'namespace' => 'Admin'], function () {

    //Please do not remove this if you want adminlte:route and adminlte:link commands to works correctly.
    #adminlte_routes

	// Routing to index of admin
	Route::get('/', 'SettingController@index')->name('admin');

	// Routing to settings
	Route::group(['prefix' => 'setting'], function () {

		Route::get('/', 'SettingController@index')->name('setting.index');
		Route::post('/save', 'SettingController@save')->name('setting.save');
	});

	Route::group(['prefix' => 'nuvemshop'], function () {

		//list
		Route::get('/', 'NuvemShopController@index')->name('nuvemshops.index');
		//delete
		Route::get('/delete/{id}', 'NuvemShopController@delete');
		//edit
		Route::get('/edit/{id}', 'NuvemShopController@form')->name('nuvemshops.edit');
		Route::post('/edit/{id}', 'NuvemShopController@form');
		//add
		Route::get('/add', 'NuvemShopController@form');
		Route::post('/add', 'NuvemShopController@form');

		// Routing to Webhooks
		Route::group(['prefix' => '{nuvemShopId}'], function () {

			// Webhook controller
			Route::resource('webhooks', 'WebhookController');

			// Webhooks, get the list of webhook from cloud
			Route::get('/hooks/apiListing', 'WebhookController@apiListing')->name('webhooks.apiListing');

			// Email template controller
			Route::resource('emailtemplates', 'EmailTemplateController');
		});
	});

	Route::group(['prefix' => 'user'], function () {
		//list
		Route::get('/', 'UserController@index');
		//delete
		Route::get('/delete/{id}', 'UserController@delete');
	});

	Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');
});
