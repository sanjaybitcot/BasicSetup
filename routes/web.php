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

/*Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');*/
/*Route::group(['namespace' => 'Backend','prefix' => '/backend'], function () {
	
	//App Install routes
	 
    Route::get('install',   'AppAuthController@index');

});*/
Route::group(['prefix' => '/auth'], function () {
	Route::get('/install', 'AppSetupController@index');
	Route::get('/login', 'AppSetupController@login');
	Route::get('/unInstall', 'AppSetupController@unInstall');
	Route::get('/load', 'AppSetupController@load');
});

/*
Routs for front end api start
*/
Route::get('privacy-policy', 'CommonController@privacyPolicy');
Route::get('faq', 'CommonController@faq');

/*
Routs for front end 401 page
*/
Route::get('unauthorize', 'CommonController@unauthorize');

Route::get('{path}', 'SPAController@index')->where('path', '(.*)'); 


	
