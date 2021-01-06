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

/*
* Routes for without login
*/
Route::group(['middleware' => 'api','prefix' => '/','namespace' => 'Api'], function(){
	Route::post('login', 'AuthController@login');
	
	/*
	* Routes for section (Activation)
	*/
	Route::get('planActivation', 'AppDefaultController@planActivation');
	Route::get('appActivation', 'AppDefaultController@appActivation');
	
	/*
	* Routes for section (Data Get From Store)
	*/
	Route::post('getProductFromStore', 'AppDefaultController@getProductsFromStore');
	Route::post('storeOrder', 'AppDefaultController@storeOrder');
	
	/*
	* Routes for Section(webhook)
	*/
	Route::post('ProductCreateUpdateFromStore', 'AppDefaultController@updateProduct');
	Route::post('ProductDeleteFromStore', 'AppDefaultController@ProductDeleteFromStore');
	Route::post('shop_data_erasure', 'AppDefaultController@deleteShopData');
	Route::post('customer_data_request', 'AppDefaultController@customerDataRequest');
	Route::post('customer_data_erasure', 'AppDefaultController@deleteCustomerData');
});

/*
* Routes for with login
*/
Route::group(['middleware' => ['auth:api', 'CheckStoreId'],'namespace' => 'Api'], function(){
	/*
	Routes for section(logout)
	*/
	Route::get('logout', 'AuthController@logout');

	/*
	Routes for section(Theme Integration)	
	*/
	Route::get('getAppPublishTheme/{storeId?}','AppPublishThemeController@index'); // store_id
	Route::post('updateAppPublishTheme','AppPublishThemeController@update');
	Route::post('updateThemeStatus','AppPublishThemeController@updateThemeStatus');
	Route::get('getPublishTheme/{storeId?}','AppPublishThemeController@show'); // store_id

	/*
	* Route for section(welcome)
	*/
	Route::post('updateStep','StepController@update');

	/*
	* Route for section(App Theme)
	*/
	Route::post('updateAppTheme','AuthController@updateAppTheme');
	
	/*
	* Route for section(Price Plan)
	*/
	Route::get('getPricePlansList/{storeId?}','PricePlanController@index'); // store_id
	Route::get('getActivePricePlan/{storeId?}','PricePlanController@show'); // store_id

	/*
	* Route for section(Store)
	*/
	Route::get('getStore/{storeId?}','StoreController@show'); // store_id

	/*
	* Routes for section(Contact Support)
	*/
	Route::post('contactSupport','ContactSupportController@store');
});
