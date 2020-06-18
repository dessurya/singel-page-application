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

Route::get('/login', 'Auth\LoginController@view')->name('auth.login.view');

Route::get('/signup', 'Auth\RegisterController@view')->name('auth.signup.view');

Route::post('/signup/action', 'Auth\RegisterController@create')->name('auth.signup.action');
Route::post('/login/action', 'Auth\LoginController@login')->name('auth.login');
Route::get('/login/action/token', 'Auth\LoginController@newUserLogin')->name('auth.login.token');


Route::middleware('user')->group(function(){

	Route::get('/welcome', 'DashboardController@index')->name('dashboard');
	Route::post('/logout/action', 'Auth\LoginController@logout')->name('auth.logout');

	Route::prefix('/config')->group(function(){
		Route::post('/index', 'ConfigController@index')->name('config.index');
		Route::post('/menu', 'ConfigController@menu')->name('config.menu');

		Route::post('/table-list', 'ConfigController@tabList')->name('config.tab.list');
	});

	Route::post('/action', 'ActionController@action')->name('action');

	Route::prefix('/account')->group(function(){
		Route::get('/list', 'AccountController@list')->name('account.list');
		Route::get('/me', 'AccountController@self')->name('account.me');
		Route::post('/form', 'AccountController@getForm')->name('account.form');
		Route::post('/form/store', 'AccountController@storeForm')->name('account.form.store');
	});

});

